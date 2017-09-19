<?php

namespace addons\blog\controller;

use addons\blog\model\Comment;
use addons\blog\model\Post;
use app\common\library\Email;
use think\addons\Controller;
use think\Exception;
use think\Validate;

/**
 * Ajax
 */
class Ajax extends Controller
{

    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
    }

    public function postcomment()
    {
        $this->request->filter('strip_tags');
        $post_id = (int) $this->request->post("post_id");
        $pid = intval($this->request->post("pid"));
        $username = $this->request->post("username");
        $email = $this->request->post("email");
        $website = $this->request->post("website");
        $content = $this->request->post("content");
        $subscribe = intval($this->request->post("subscribe"));
        $useragent = $this->request->server('HTTP_USER_AGENT');
        $ip = $this->request->ip();
        $website = $website != '' && substr($website, 0, 7) != 'http://' && substr($website, 0, 8) != 'https://' ? "http://" . $website : $website;
        $username = preg_replace("/<(.*?)>/", "", $username);
        $content = preg_replace("/<(.*?)>/", "", $content);
        $content = preg_replace("/\r?\n/", '<br />', $content);
        $token = $this->request->post('__token__');
        try
        {

            $post = Post::get($post_id);
            if (!$post || $post['status'] == 'hidden')
            {
                throw new Exception("日志未找到");
            }

            $rule = [
                'pid'       => 'require|number',
                'username'  => 'require|chsDash|length:3,30',
                'email'     => 'require|email|length:3,30',
                'website'   => 'url|length:3,50',
                'content'   => 'require|length:3,250',
                '__token__' => 'token',
            ];
            $data = [
                'pid'       => $pid,
                'username'  => $username,
                'email'     => $email,
                'website'   => $website,
                'content'   => $content,
                '__token__' => $token,
            ];
            $validate = new Validate($rule);
            $result = $validate->check($data);
            if (!$result)
            {
                throw new Exception($validate->getError());
            }

            $lastcomment = Comment::get(['post_id' => $post_id, 'email' => $email, 'ip' => $ip]);
            if ($lastcomment && time() - $lastcomment['createtime'] < 30)
            {
                throw new Exception("对不起！您发表评论的速度过快！请稍微休息一下，喝杯咖啡");
            }
            if ($lastcomment && $lastcomment['content'] == $content)
            {
                throw new Exception("您可能连续了相同的评论，请不要重复提交");
            }
            $data = [
                'pid'       => $pid,
                'post_id'   => $post_id,
                'username'  => $username,
                'email'     => $email,
                'content'   => $content,
                'ip'        => $ip,
                'useragent' => $useragent,
                'subscribe' => (int) $subscribe,
                'website'   => $website,
                'status'    => 'normal'
            ];
            Comment::create($data);

            $post->setInc('comments');
            if ($pid)
            {
                //查找父评论，是否并发邮件通知
                $parent = Comment::get($pid);
                if ($parent && $parent['subscribe'] && Validate::is($parent['email'], 'email'))
                {
                    $title = "{$parent['username']}，您发表在《{$post['title']}》上的评论有了新回复 - {$this->view->config['name']}";
                    $post_url = addon_url("blog/index/post", ['id' => $post['id']], false, true);
                    $unsubscribe_url = addon_url("blog/index/unsubscribe", ['id' => $parent['id'], 'key' => md5($parent['id'] . $parent['email'])]);
                    $content = "亲爱的{$parent['username']}：<br />您于" . date("Y-m-d H:i:s") .
                            "在《<a href='{$post_url}' target='_blank'>{$post['title']}</a>》上发表的评论<br /><blockquote>{$parent['content']}</blockquote>" .
                            "<br />{$username}发表了回复，内容是<br /><blockquote>{$content}</blockquote><br />您可以<a href='{$post_url}'>点击查看评论详情</a>。" .
                            "<br /><br />如果你不愿意再接受最新评论的通知，<a href='{$unsubscribe_url}'>请点击这里取消</a>";
                    $email = new Email;
                    $result = $email
                            ->to($parent['email'])
                            ->subject($title)
                            ->message('<div style="min-height:550px; padding: 100px 55px 200px;">' . $content . '</div>')
                            ->send();
                }
            }
            $this->success(__('评论成功'));
        }
        catch (Exception $e)
        {
            $this->error($e->getMessage(), null, ['token' => $this->request->token()]);
        }
    }

    public function getcommentlist()
    {
        $post_id = $this->request->get('post_id');
        $commentlist = Comment::where(['post_id' => $post_id, 'pid' => 0, 'status' => 'normal'])
                ->with('sublist')
                ->order('id desc')
                ->paginate($this->view->config['commentpagesize']);
        $this->view->assign("commentlist", $commentlist);
        return $this->view->fetch('common/commentlist');
    }

}

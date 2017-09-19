<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:60:"D:\phpStudy\WWW\fastadmin4\addons\blog\view\index\index.html";i:1505359785;s:63:"D:\phpStudy\WWW\fastadmin4\addons\blog\view\common\sidebar.html";i:1505359785;s:64:"D:\phpStudy\WWW\fastadmin4\addons\blog\view\common\postlist.html";i:1505359785;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>首页 - <?php echo $config['name']; ?></title>
        <meta name="renderer" content="webkit">
        <meta name="apple-mobile-web-app-title" content="My App">
        <meta content="yes" name="apple-mobile-web-app-capable" />
        <meta content="black" name="apple-mobile-web-app-status-bar-style" />
        <meta name="format-detection" content="telephone=no" />
        <meta name="author" content="">
        <meta name="keywords" content="<?php echo $config['keywords']; ?>">
        <meta name="description" content="<?php echo $config['description']; ?>">
        <link rel="stylesheet" href="__ADDON__/css/main.css">
        <!--[if lt IE 9]>
            <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
          <![endif]-->
    </head>

    <body>
        <!-- 侧栏 -->
        <div id="side" class="ta-c" style="background-image: url('<?php echo cdnurl($config['background']); ?>');">
    <div class="logo">
        <img src="__CDN__<?php echo $config['avatar']; ?>" alt="">
    </div>
    <h1><?php echo $config['name']; ?></h1>
    <h3><?php echo $config['enname']; ?></h3>
    <ul class="nav">
        <li><a href="<?php echo addon_url('blog'); ?>" class="active"><span class="icon-home hidden-l"></span>首页</a></li>
        <li><a href="<?php echo addon_url('blog/index/post', ['id'=>1]); ?>"><span class="icon-user hidden-l"></span>关于我</a></li>
        <li><a href="<?php echo addon_url('blog/index/archieve'); ?>"><span class="icon-list hidden-l"></span>归档</a></li>
    </ul>
    <p class="intro ta-l hidden-l"><?php echo $config['intro']; ?></p>
    <?php if(true): ?>
    <div class="doing hidden-l">
        <p>FastAdmin博客插件正式发布。</p>
        <p><span class="icon-map-marker"></span>广东 深圳</p>
    </div>
    <?php endif; ?>
    <p class="copyright hidden-l">© <?php echo $config['enname']; ?> 2017 - 2018</p>
</div>
        <!-- 文章列表 -->
        <div id="post-list">
            <ul>
                <?php if(is_array($postlist) || $postlist instanceof \think\Collection || $postlist instanceof \think\Paginator): $i = 0; $__LIST__ = $postlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$post): $mod = ($i % 2 );++$i;?>
<li class="clearfix line">

    <div class="post-about xl12 xs8">
        <h1><a href="<?php echo $post['url']; ?>"><?php echo $post['title']; ?></a></h1>
        <div class="post-meta"><a href="<?php echo $post['category']['url']; ?>"><?php echo $post['category']['name']; ?></a> | <?php echo human_date($post['createtime']); ?>发布 | <a href="<?php echo $post['url']; ?>#comments"><?php echo $post['comments']; ?>条评论</a></div>
        <p class="mt20 mb10"><?php echo $post['summary']; ?></p>
    </div>
    <div class="post-img xl12 xs4">
        <a href="<?php echo $post['url']; ?>"><img src="__CDN__<?php echo $post['thumb']; ?>" alt=""></a>
    </div>
</li>
<?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <!-- 分页 -->
            <div class="page">
                <?php if($prevurl): ?>
                <a href="<?php echo $prevurl; ?>">上一页</a>
                <?php endif; if($nexturl): ?>
                <a href="<?php echo $nexturl; ?>">下一页</a>
                <?php endif; ?>
            </div>
        </div>
        <script src="__ADDON__/lib/jquery.js"></script>
    </body>

</html>

<?php

namespace app\admin\controller\product;

use app\admin\model\Page;
use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 产品管理
 *
 * @icon fa fa-circle-o
 */
class Product extends Backend
{
    
    /**
     * Product模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Product');
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);

        //产品名关键字
        $strSearch = Request::instance()->get('search');

        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('pkey_name'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            //搜索产品名
            /*if( $strSearch!==null ){
                $this->model = $this->model->where('product_name','like',"%$strSearch%");
            }*/

            $total = $this->model
                //->where($where)
                ->where('product_name', 'like', "%$strSearch%")
                ->order($sort, $order)
                ->count();

            $list = $this->model
                //->where($where)
                ->where('product_name', 'like', "%$strSearch%")
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }



    

}

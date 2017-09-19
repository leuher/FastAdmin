<?php

namespace app\admin\controller\product;

use app\common\controller\Backend;
use fast\Tree;
use think\Controller;
use app\common\model\Category as CategoryModel;
use think\Request;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Category extends Backend
{
    
    /**
     * ProductCategory模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Product_category');
       
        
        $tree = Tree::instance();
        $tree->init($this->model->order('weigh desc,id desc')->select(), 'pid');
        $this->categorylist = $tree->getTreeList($tree->getTreeArray(0), 'name');

        $categorydata = [0 => ['type' => 'all', 'name' => __('None')]];
        foreach ($this->categorylist as $k => $v)
        {
            $categorydata[$v['id']] = $v;
        }       
      
        $this->view->assign("parentList", $categorydata);
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    /**
     * 查看
     */
    public function index()
    {
        if ($this->request->isAjax())
        {
            $search = $this->request->request("search");
            //构造父类select列表选项数据
            $list = [];
            if ($search)
            {
                foreach ($this->categorylist as $k => $v)
                {
                    if (stripos($v['name'], $search) !== false || stripos($v['nickname'], $search) !== false)
                    {
                     
                        $list[] =$v;
                    }
                }
            }
            else
            {
                $list = $this->categorylist;
            }
            $total = count($list);
            $result = array("total" => $total, "rows" => $list);
            
            return json($result);
        }

        return $this->view->fetch();
    }
   
    

}

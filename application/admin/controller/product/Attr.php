<?php
namespace app\admin\controller\product;

use app\common\controller\Backend;
use fast\Tree;
use think\Controller;
use think\Request;

/**
 * @icon fa fa-circle-o
 */
class Attr extends Backend
{

    /**
     * ProductAttr模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('ProductAttr');
        
        $tree = Tree::instance();
        $tree->init(model('ProductCategory')->order('weigh desc,id desc')
            ->select(), 'pid');
        $this->categorylist = $tree->getTreeList($tree->getTreeArray(0), 'name');
        $categorydata = [
            0 => [
                'type' => 'all',
                'name' => __('None')
            ]
        ];
        foreach ($this->categorylist as $k => $v) {
            $categorydata[$v['id']] = $v;
        }
        $this->view->assign("categorydata", $categorydata);
    }

    public function index()
    {
        if ($this->request->isAjax()) {
            $this->attrlist = $this->model->where(array(
                'pid' => array(
                    'EQ',
                    0
                )
            ))
                ->order('id desc')
                ->select();
            $search = $this->request->request("search");
            // 构造父类select列表选项数据
            $list = [];
            if ($search) {
                foreach ($this->attrlist as $k => $v) {
                    if (stripos($v['name'], $search) !== false || stripos($v['nickname'], $search) !== false) {
                        
                        $list[] = $v;
                    }
                }
            } else {
                $list = $this->attrlist;
            }
            $total = count($list);
            $result = array(
                "total" => $total,
                "rows" => $list
            );
            
            return json($result);
        }
        
        return $this->view->fetch();
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get([
            'id' => $ids
        ]);
        if (! $row)
            $this->error(__('No Results were found'));
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
		
                foreach ($params as $key => $val) {
                    $dataset[$key] = $val;
                    if ($key == 'time') {
                        $dataset[$key] = strtotime($val);
                    }
                }
          
                $this->model->where(array('id'=>$row['id']))->update($dataset);
                $this->success();
            }
            $this->error();
        }
        $grouplist = $this->auth->getGroups($row['id']);
        $groupids = [];
        foreach ($grouplist as $k => $v) {
            $groupids[] = $v['id'];
        }
        $son = $this->model->where(array(
            'pid' => $row['id']
        ))
            ->order('id asc')
            ->select();
        $this->view->assign('son', $son);
        $this->view->assign("row", $row);
        $this->view->assign("groupids", $groupids);
        return $this->view->fetch();
    }

    public function addson($ids = NULL)
    {
        $row = $this->model->get([
            'id' => $ids
        ]);
        
        if (! $row)
            $this->error(__('No Results were found'));
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                
                foreach ($params as $key => $value) {
                    $dataset[$key] = $value;
                    if ($key == 'time') {
                        $dataset[$key] = strtotime($value);
                    }
                }
                
                model('ProductAttr')->save($dataset);
                $this->success();
            }
            $this->error();
        }
        $grouplist = $this->auth->getGroups($row['id']);
        $groupids = [];
        foreach ($grouplist as $k => $v) {
            $groupids[] = $v['id'];
        }
        
        $this->view->assign("row", $row);
        $this->view->assign("groupids", $groupids);
        return $this->view->fetch();
    }

    public function delete($ids = NULL)
    {
        $row = $this->model->get([
            'id' => $ids
        ]);
        if (! $row)
            $this->error(__('No Results were found'));
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $attr = new ProductAttr();
            }
            $attr->where(array(
                'id' => $params['id'],
                'pid' => $params['id']
            ))->update(array(
                'status' => - 1
            ));
            $this->success();
        }
        $this->error();
    }	
	/*
	*@获得规则
	*@param $attr_id 主规则id
	*return array
	*/
	public function getAttr($attr_id){
		$attr=$this->model->where(array('id'=>$attr_id,'pid'=>'0'))->find();
		if(!$attr){
		$this->error('参数错误');	
		}
		$attrList=$this->model->where(array('pid'=>$attr_id))->find();
		return $attrList;
	}


    // 通过目录获取属性组
    public function getAttrsByCid($intCid)
    {
        $arrayPAttr = db('product_attr')->where('category_id', '=', $intCid)->select();

        $arraysAttr = array();
        foreach($arrayPAttr as $key=>$each)
        {
            $arraysAttr[$key]['info']  = $each;
            $arraysAttr[$key]['child'] = db('product_attr')->where('pid', '=', $each['id'])->select();
        }
        return $arraysAttr;
    }

}

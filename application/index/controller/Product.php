<?php

namespace app\index\controller;

use app\common\controller\Frontend;

class Product extends Frontend
{
    protected $strTbName    = 'product';
    protected $intProductId = null;
    protected $intCategory  = null;
    protected $strSearch    = null;
    protected $intLimit     = 10;
    protected $intPage      = 1;
    protected $objSql       = null;

    public function _initialize()
    {
        parent::_initialize();

        $this->checkInput();
        $this->makeCondition();
    }

    // 参检 get [id, category, search, limit, page]
    protected function checkInput()
    {
        if( ($id=$this->request->get('id'))!==null ){
            filter_var( ltrim($id, 0), FILTER_VALIDATE_INT, ['num'=>'number'] ) OR exit();
            $this->intProductId = $id;
        }
        if( ($category=$this->request->get('category'))!==null ){
            filter_var( ltrim($category, 0), FILTER_VALIDATE_INT, ['num'=>'number'] ) OR exit();
            $this->intCategory = $category;
        }
        if( ($search=$this->request->get('search'))!==null ){
            $this->strSearch = $search;
        }
        if( ($limit=$this->request->get('limit'))!==null ){
            filter_var($limit, FILTER_VALIDATE_INT, ['num'=>'number', 'min_range'=>'0', 'max_range'=>'100']) OR exit();
            $this->intLimit = $limit;
        }
        if( ($page=$this->request->get('page'))!==null ){
            filter_var($page, FILTER_VALIDATE_INT, ['num'=>'number']) OR exit();
            $this->intPage = $page;
        }
    }

    // 约束条件
    protected function makeCondition()
    {
        $objSql = db($this->strTbName);

        // 约束
        if( $this->intProductId!==null ){
            $objSql = $objSql->where('id', '=', $this->intProductId);
        }
        if( $this->intCategory!==null ){
            $objSql = $objSql->where('product_category_id', '=', $this->intCategory);
        }
        if( $this->strSearch!==null ){
            $arrayKeyword = explode(' ', $this->strSearch);
            $strTitle     = $arrayKeyword[0];
            $strAttribute = $arrayKeyword[1] ?? '';
            $objSql = $objSql->where('product_name', 'LIKE', "%$strTitle%");
            $objSql = $objSql->where('labels', 'LIKE', "%$strAttribute%");
        }

        // 分页与排序
        $objSql = $objSql->page("$this->intPage, $this->intLimit");
        $objSql = $objSql->order("updatetime DESC");

        $this->objSql = $objSql;
    }

    // 通过条件筛选获取产品
    public function getProducts()
    {
        $result = $this->objSql->select();
        return json_encode($result);
    }

    // 通过系列ID和标签获取产品
    public function getProductsByLabels(){}


}

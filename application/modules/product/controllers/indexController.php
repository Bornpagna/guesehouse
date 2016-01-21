<?php
class Product_indexController extends Zend_Controller_Action {	
	
	protected $tr;
	const REDIRECT_URL ='/product';
    public function init()
    {    	
    	header('content-type: text/html; charset=utf8');
    	$this->tr=Application_Form_FrmLanguages::getCurrentlanguage();
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}

    public function indexAction()
    {
    	$db = new Product_Model_DbTable_DbProduct();
    	$rs_rows = $db->getProduct();
    	
    	$glClass = new Application_Model_GlobalClass();
    	$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
    	$list = new Application_Form_Frmtable();
    	$collumns = array("CODE","NAME","BRAND","CATEGORY","QTY","DATE","STATUS");
    	$link=array(
    			'module'=>'product','controller'=>'index','action'=>'edit',
    	);
    	$this->view->list=$list->getCheckList(0, $collumns, $rs_rows,array('code'=>$link,'name'=>$link,'brand_id'=>$link));
//     	$db = new Product_Model_DbTable_DbProduct();
//     	$row = $db->getProduct();
//     	$this->view->row = $row;
    }
    public function addAction()
    {
    	$db = new Product_Model_DbTable_DbProduct();
    	if($this->getRequest()->isPost()){
    		$data = $this->getRequest()->getPost();
    		$db->add($data);
    		if(isset($data["save_new"])){
    			Application_Form_FrmMessage::Sucessfull("Insert was Success!", "/product/index/add");
    		}
    	
    	}
    	$frm = new Product_Form_FrmProduct();
    	$frm=$frm->FrmProduct();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->form = $frm;
    }
    public function editAction()
    {
    	$id = $this->getRequest()->getParam("id");
    	$db = new Product_Model_DbTable_DbProduct();
    	$row = $db->getProductByID($id);
    	if($this->getRequest()->isPost()){
    		$data = $this->getRequest()->getPost();
    		$db->edit($data, $id);
    		if(isset($data["save_new"])){
    			Application_Form_FrmMessage::Sucessfull("Product was updateed!", "/product/index/add");
    		}else{
    			Application_Form_FrmMessage::Sucessfull("Product was updateed!", "/product/index");
    		}
    	}
    	 
    	$frm = new Product_Form_FrmProduct();
    	$frm=$frm->FrmProduct($row);
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->form = $frm;
    }
    
}

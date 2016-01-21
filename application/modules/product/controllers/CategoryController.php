<?php
class Product_CategoryController extends Zend_Controller_Action {
	
	
	protected $tr;
	const REDIRECT_URL ='/category';
    public function init()
    {    	
    	header('content-type: text/html; charset=utf8');
    	$this->tr=Application_Form_FrmLanguages::getCurrentlanguage();
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}

    public function indexAction()
    {
    	$db = new Product_Model_DbTable_DbCategory();
    	$rs_rows = $db->getCategory();
    	$glClass = new Application_Model_GlobalClass();
    	$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
    	$list = new Application_Form_Frmtable();
    	$collumns = array("NAME","DATE","STATUS");
    	$link=array(
    			'module'=>'product','controller'=>'index','action'=>'edit',
    	);
    	$this->view->list=$list->getCheckList(0, $collumns, $rs_rows,array('name'=>$link));
    }
    public function addAction()
    {
    	$db = new Product_Model_DbTable_DbCategory();
    	if($this->getRequest()->isPost()){
    		$data = $this->getRequest()->getPost();
    		$db->add($data);
    		if(isset($data["save_new"])){
    			Application_Form_FrmMessage::Sucessfull("Insert was Success!", "/product/category/add");
    		}
    		
    	}
    	$frm = new Product_Form_FrmCategory();
    	$frm=$frm->FrmCategory();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->form = $frm;
    }
    
    public function editAction(){
    	$id = $this->getRequest()->getParam("id");
    	$db = new Product_Model_DbTable_DbCategory();
    	$row = $db->getCategoryByID($id);
    	if($this->getRequest()->isPost()){
    		$data = $this->getRequest()->getPost();
    		$db->edit($data, $id);
    		if(isset($data["save_new"])){
    			Application_Form_FrmMessage::Sucessfull("Category was updateed!", "/product/category/add");
    		}else{
    			Application_Form_FrmMessage::Sucessfull("Category was updateed!", "/product/category");
    		}
    	}
    	
    	$frm = new Product_Form_FrmCategory();
    	$frm=$frm->FrmCategory($row);
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->form = $frm;
    }
}

<?php
class Product_MeasureController extends Zend_Controller_Action {
	
	
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
    	$db = new Product_Model_DbTable_DbMeasure();
    	$rs_rows = $db->getMeasure();
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
    	$db = new Product_Model_DbTable_DbMeasure();
    	if($this->getRequest()->isPost()){
    		$data = $this->getRequest()->getPost();
    		$db->add($data);
    		if(isset($data["save_new"])){
    			Application_Form_FrmMessage::Sucessfull("Insert was Success!", "/product/measure/add");
    		}
    		
    	}
    	$frm = new Product_Form_FrmMeasure();
    	$frm=$frm->FrmMeasure();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->form = $frm;
    }
    
    public function editAction(){
    	$id = $this->getRequest()->getParam("id");
    	$db = new Product_Model_DbTable_DbMeasure();
    	$row = $db->getMeasureByID($id);
    	if($this->getRequest()->isPost()){
    		$data = $this->getRequest()->getPost();
    		$db->edit($data, $id);
    		if(isset($data["save_new"])){
    			Application_Form_FrmMessage::Sucessfull("Measure was updateed!", "/product/measure/add");
    		}else{
    			Application_Form_FrmMessage::Sucessfull("Measure was updateed!", "/product/measure");
    		}
    	}
    	
    	$frm = new Product_Form_FrmMeasure();
    	$frm=$frm->FrmMeasure($row);
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->form = $frm;
    }
}

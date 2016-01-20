<?php
class Product_BrandController extends Zend_Controller_Action {
	
	
    public function init()
    {    	
     /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	
	}

    public function indexAction()
    {
    	$db = new Product_Model_DbTable_DbBrand();
    	$row = $db->getBrand();
    	$this->view->row = $row;
    }
    public function addAction()
    {
    	$db = new Product_Model_DbTable_DbBrand();
    	if($this->getRequest()->isPost()){
    		$data = $this->getRequest()->getPost();
    		$db->add($data);
    		if(isset($data["save_new"])){
    			Application_Form_FrmMessage::Sucessfull("Insert was Success!", "/product/category/add");
    		}
    		
    	}
    	$frm = new Product_Form_FrmBrand();
    	$frm=$frm->FrmBrand();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->form = $frm;
    }
    
    public function editAction(){
    	$id = $this->getRequest()->getParam("id");
    	$db = new Product_Model_DbTable_DbBrand();
    	$row = $db->getBrandByID($id);
    	if($this->getRequest()->isPost()){
    		$data = $this->getRequest()->getPost();
    		$db->edit($data, $id);
    		if(isset($data["save_new"])){
    			Application_Form_FrmMessage::Sucessfull("Category was updateed!", "/product/category/add");
    		}else{
    			Application_Form_FrmMessage::Sucessfull("Category was updateed!", "/product/category");
    		}
    	}
    	
    	$frm = new Product_Form_FrmBrand();
    	$frm=$frm->FrmBrand($row);
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->form = $frm;
    }
}

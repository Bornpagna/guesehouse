<?php
class Registrar_RequestController extends Zend_Controller_Action {
	
	
    public function init()
    {    	
     /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	
	}

    public function indexAction()
    {
        
    }
	public function addAction()
    {
    	$frm = new Registrar_Form_FrmRegister();
    	$frm_request=$frm->FrmStudentRequest();
    	Application_Model_Decorator::removeAllDecorator($frm_request);
    	$this->view->frm_request = $frm_request;
    	$key = new Application_Model_DbTable_DbKeycode();
    	$this->view->keycode=$key->getKeyCodeMiniInv(TRUE);
    }
    public function testAction(){
    	$frm = new Registrar_Form_FrmTest();
    	$frm_request=$frm->FrmTestNew();
    	$this->view->frmtest = $frm_request;
    	
    }
}

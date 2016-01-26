<?php
class Booking_FloorController extends Zend_Controller_Action {
	protected $tr;
	const REDIRECT_URL ='/room';
    public function init()
    {    	
    	header('content-type: text/html; charset=utf8');
    	$this->tr=Application_Form_FrmLanguages::getCurrentlanguage();
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}

    public function indexAction()
    {
    	try{
    		$db = new Room_Model_DbTable_DbFloor();
//     		if($this->getRequest()->isPost()){
//     			$search=$this->getRequest()->getPost();
//     		}
//     		else{
//     			$search = array(
//     					'adv_search' => '',
//     					'search_status' => -1,
//     					'start_date'=> date('Y-m-01'),
//     					'end_date'=>date('Y-m-d'));
//     		}
    		$rs_rows= $db->getAllFloor();
    		$glClass = new Application_Model_GlobalClass();
    		$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
    		$list = new Application_Form_Frmtable();
    		$collumns = array("FLOOR_NAME","STATUS");
    		$link=array(
    				'module'=>'room','controller'=>'floor','action'=>'edit',
    		);
    		$this->view->list=$list->getCheckList(0, $collumns, $rs_rows,array('floor_name'=>$link));
    	}catch (Exception $e){
    		Application_Form_FrmMessage::message("Application Error");
    		Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
    	}
    }
    public function addAction()
    {
    	if($this->getRequest()->isPost()){
    		$_data = $this->getRequest()->getPost();
    		try {
    			$db = new Room_Model_DbTable_DbFloor();
    			if(!empty($_data['save_new'])){
    				$db->addFloor($_data);
    				Application_Form_FrmMessage::message($this->tr->translate('INSERT_SUCCESS'));
    			}else{
    				$db->addFloor($_data);
    				Application_Form_FrmMessage::Sucessfull($this->tr->translate('INSERT_SUCCESS'), self::REDIRECT_URL . '/floor/index');
    			}
    		} catch (Exception $e) {
    			Application_Form_FrmMessage::message($this->tr->translate('INSERT_FAIL'));
    			$err =$e->getMessage();
    			Application_Model_DbTable_DbUserLog::writeMessageError($err);
    		}
    	}
    }
    public function editAction()
    {
    	if($this->getRequest()->isPost()){
    		$_data = $this->getRequest()->getPost();
    		try {
    			$db = new Room_Model_DbTable_DbFloor();
    			if(!empty($_data['save_close'])){
    				$db->updateFloor($_data);
    				Application_Form_FrmMessage::Sucessfull($this->tr->translate('INSERT_SUCCESS'), self::REDIRECT_URL . '/floor/index');
    			}
    		} catch (Exception $e) {
    			Application_Form_FrmMessage::message($this->tr->translate('INSERT_FAIL'));
    			$err =$e->getMessage();
    			Application_Model_DbTable_DbUserLog::writeMessageError($err);
    		}
    	}
    	$db = new Room_Model_DbTable_DbFloor();
    	$id=$this->getRequest()->getParam('id');
    	$row=$this->view->floor=$db->getFloorById($id);
    }
}

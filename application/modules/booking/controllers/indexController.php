<?php
class Booking_IndexController extends Zend_Controller_Action {
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
    		$db = new Room_Model_DbTable_DbRoomType();
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
    		$rs_rows= $db->getAllRoomType();
    		$glClass = new Application_Model_GlobalClass();
    		$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
    		$list = new Application_Form_Frmtable();
    		$collumns = array("ROOM_TYPE","STATUS");
    		$link=array(
    				'module'=>'room','controller'=>'index','action'=>'edit',
    		);
    		$this->view->list=$list->getCheckList(0, $collumns, $rs_rows,array('type'=>$link));
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
    			$db = new Room_Model_DbTable_DbRoomType();
    			if(!empty($_data['save_new'])){
    				 $db->addRooomType($_data);
    				Application_Form_FrmMessage::message($this->tr->translate('INSERT_SUCCESS'));
    			}else{
    				$db->addRooomType($_data);
    				Application_Form_FrmMessage::Sucessfull($this->tr->translate('INSERT_SUCCESS'), self::REDIRECT_URL . '/index/index');
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
    			$db = new Room_Model_DbTable_DbRoomType();
    			if(!empty($_data['save_close'])){
    				$db->updateRoomType($_data);
    				Application_Form_FrmMessage::Sucessfull($this->tr->translate('INSERT_SUCCESS'), self::REDIRECT_URL . '/index/index');
    			}
    		} catch (Exception $e) {
    			Application_Form_FrmMessage::message($this->tr->translate('INSERT_FAIL'));
    			$err =$e->getMessage();
    			Application_Model_DbTable_DbUserLog::writeMessageError($err);
    		}
    	}
    	$id=$this->getRequest()->getParam('id');
    	$db = new Room_Model_DbTable_DbRoomType();
    	$this->view->row_room_type=$db->getRoomTypeById($id);
    }
}

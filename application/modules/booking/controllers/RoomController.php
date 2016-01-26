<?php
class Booking_RoomController extends Zend_Controller_Action {
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
    		$db = new Room_Model_DbTable_DbRoom();
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
    		$rs_rows= $db->getAllRoom();
    		$glClass = new Application_Model_GlobalClass();
    		$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
    		$list = new Application_Form_Frmtable();
    		$collumns = array("ROOM_NO","ROOM_NUMBER","ROOM_TYPE","FLOOR_NAME","DATE","BED_NUMBER","DESCRIPTION","STATUS");
    		$link=array(
    				'module'=>'room','controller'=>'room','action'=>'edit',
    		);
    		$this->view->list=$list->getCheckList(0, $collumns, $rs_rows,array('room_no'=>$link,'room_number'=>$link,'type_id'=>$link,'floor_id'=>$link,'date'=>$link));
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
    			$db = new Room_Model_DbTable_DbRoom();
    			if(isset($_data['save_new'])){
    				$db->addRooom($_data);
    				Application_Form_FrmMessage::message($this->tr->translate('INSERT_SUCCESS'));
    			}else{
    				$db->addRooom($_data);
    				Application_Form_FrmMessage::Sucessfull($this->tr->translate('INSERT_SUCCESS'), self::REDIRECT_URL . '/room/index');
    			}
    		} catch (Exception $e) {
    			Application_Form_FrmMessage::message($this->tr->translate('INSERT_FAIL'));
    			$err =$e->getMessage();
    			Application_Model_DbTable_DbUserLog::writeMessageError($err);
    		}
    	}
    	$room_type=new Room_Model_DbTable_DbRoom();
    	$this->view->all_type=$room_type->getAllRoomType();
    	$this->view->all_floor=$room_type->getAllFloor();
    }
    public function editAction(){
    	$id=$this->getRequest()->getParam('id');
    	$db=new Room_Model_DbTable_DbRoom();
    	$this->view->row_room=$db->getRoomById($id);
    	if($this->getRequest()->isPost()){
    		$_data = $this->getRequest()->getPost();
    		$_data['id']=$id;
    		try {
    			$db = new Room_Model_DbTable_DbRoom();
    			if(isset($_data['save_close'])){
    				$db->updateRooom($_data);
    				Application_Form_FrmMessage::Sucessfull($this->tr->translate('INSERT_SUCCESS'), self::REDIRECT_URL . '/room/index');
    			}
    		} catch (Exception $e) {
    			Application_Form_FrmMessage::message($this->tr->translate('INSERT_FAIL'));
    			$err =$e->getMessage();
    			Application_Model_DbTable_DbUserLog::writeMessageError($err);
    		}
    	}
    	$room_type=new Room_Model_DbTable_DbRoom();
    	$this->view->all_type=$room_type->getAllRoomType();
    	$this->view->all_floor=$room_type->getAllFloor();
    }
    
	function itemAction()
	{
		$item= new Accounting_Form_Frmitem();
		$frm_item=$item->Frmitem();
		Application_Model_Decorator::removeAllDecorator($frm_item);
		$this->view->frm_item = $frm_item;
	}	
   
}

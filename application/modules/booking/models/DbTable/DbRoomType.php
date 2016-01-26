<?php
class Room_Model_DbTable_DbRoomType extends Zend_Db_Table_Abstract
{

    protected $_name = 'tb_roomtype';
    public function getUserId(){
    	$session_user=new Zend_Session_Namespace('auth');
    	return $session_user->user_id;
    
    }
    public function addRooomType($_data){
    	$db = $this->getAdapter();
    		$_arr = array(
    				'type'=>$_data['room_type'],
    				'status'=>$_data['status'],
    				'user_id'=>$this->getUserId(),
    		);
    		$this->insert($_arr);
    } 
    public function serviceExist($service_name,$_type){
    	$db = $this->getAdapter();
    	$sql = "SELECT service_id FROM `rms_program_name` WHERE title= '".$service_name."' AND ser_cate_id=$_type";
    	return $db->fetchRow($sql);
    }
    public function updateRoomType($_data){
    	$_arr = array(
    				'type'=>$_data['room_type'],
    				'status'=>$_data['status'],
    				'user_id'=>$this->getUserId(),
    		);
    	$where="id=".$_data["id"];
    	$this->update($_arr, $where);
    }
    public function getRoomTypeById($id){
    	$db = $this->getAdapter();
    	$sql = "SELECT id,`type`,`status` FROM $this->_name WHERE id=".$id;
    	return $db->fetchRow($sql);
    }	
    public function getAllRoomType(){
    	$db = $this->getAdapter();
    	$sql = "SELECT id,`type`,`status` FROM tb_roomtype WHERE `status`=1";
    	$order=" ORDER BY id DESC ";
    	return $db->fetchAll($sql.$order);
    }
    	
}




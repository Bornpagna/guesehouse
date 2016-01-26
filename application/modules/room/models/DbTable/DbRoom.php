<?php
class Room_Model_DbTable_DbRoom extends Zend_Db_Table_Abstract
{

    protected $_name = 'tb_room';
    public function getUserId(){
    	$session_user=new Zend_Session_Namespace('auth');
    	return $session_user->user_id;
    
    }
    public function addRooom($_data){
    	$db = $this->getAdapter();
    		$_arr = array(
    				'room_no'=>$_data['room_no'],
    				'type_id'=>$_data['room_type'],
    				'floor_id'=>$_data['floor_name'],
    				'date'=>$_data['date'],
    				'room_number'=>$_data['room_number'],
    				'description'=>$_data['description'],
    				'bed_num'=>$_data['bet_number'],
    				'status'=>$_data['status'],
    				'user_id'=>$this->getUserId(),
    		);
    		$this->insert($_arr);
    } 
    public function updateRooom($_data){
    	$db = $this->getAdapter();
    	$_arr = array(
    			'room_no'=>$_data['room_no'],
    			'type_id'=>$_data['room_type'],
    			'floor_id'=>$_data['floor_name'],
    			'date'=>$_data['date'],
    			'room_number'=>$_data['room_number'],
    			'description'=>$_data['description'],
    			'bed_num'=>$_data['bet_number'],
    			'status'=>$_data['status'],
    			'user_id'=>$this->getUserId(),
    	);
    	$where="id=".$_data['id'];
    	$this->update($_arr, $where);
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
    public function getAllRoom(){
    	$db = $this->getAdapter();
    	$sql = "SELECT id,room_no,room_number,type_id,floor_id,`date`,bed_num,description,`status` 
    	        FROM tb_room WHERE `status`=1";
    	$order=" ORDER BY id DESC ";
    	return $db->fetchAll($sql.$order);
    }	
    public function getAllRoomType(){
    	$db = $this->getAdapter();
    	$sql = "SELECT id,`type`,`status` FROM tb_roomtype WHERE `status`=1";
    	$order=" ORDER BY id DESC ";
    	return $db->fetchAll($sql.$order);
    }
    public function getRoomById($id){
    	$db = $this->getAdapter();
    	$sql = "SELECT id,room_no,type_id,`date`,floor_id,room_number,bed_num,description FROM $this->_name WHERE id=".$id;
    	return $db->fetchRow($sql);
    }
    public function getAllFloor(){
    	$db = $this->getAdapter();
    	$sql = "SELECT id,floor_name,`status` FROM tb_floor WHERE `status`=1";
    	$order=" ORDER BY id DESC ";
    	return $db->fetchAll($sql.$order);
    }
    	
}




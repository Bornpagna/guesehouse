<?php
class Room_Model_DbTable_DbFloor extends Zend_Db_Table_Abstract
{

    protected $_name = 'tb_floor';
    public function getUserId(){
    	$session_user=new Zend_Session_Namespace('auth');
    	return $session_user->user_id;
    
    }
    public function addFloor($_data){
    	$db = $this->getAdapter();
    		$_arr = array(
    				'floor_name'=>$_data['floor_name'],
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
    public function updateFloor($_data){
    	$_arr = array(
    				'floor_name'=>$_data['floor_name'],
    				'status'=>$_data['status'],
    				'user_id'=>$this->getUserId(),
    		);
    	$where="id=".$_data["id"];
    	$this->update($_arr, $where);
    }
    public function getFloorById($id){
    	$db = $this->getAdapter();
    	$sql = "SELECT id,floor_name,`status` FROM tb_floor WHERE id=".$id;
    	return $db->fetchRow($sql);
    }	
    public function getAllFloor(){
    	$db = $this->getAdapter();
    	$sql = "SELECT id,floor_name,`status` FROM tb_floor WHERE `status`=1";
    	$order=" ORDER BY id DESC ";
    	return $db->fetchAll($sql.$order);
    }
    	
}




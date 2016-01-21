<?php

class Product_Model_DbTable_DbMeasure extends Zend_Db_Table_Abstract
{
    protected $_name = 'tb_measure';
    public function getUserId(){
    	$session_user=new Zend_Session_Namespace('auth');
    	return $session_user->user_id;
    	 
    }
	public function getMeasure(){
		$db = $this->getAdapter();
		$sql="SELECT b.`id`,CONCAT(b.`name_en`,'-',b.`name_kh`) AS `name`,b.`date`,b.`status` FROM $this->_name AS b WHERE b.`status`=1";
		$row = $db->fetchAll($sql);
		if($row){
			return $row;
		}
	}
	public function getMeasureByID($id){
		$db = $this->getAdapter();
		$sql="SELECT b.`id`,b.`name_en`,b.`name_kh`,b.`status` FROM $this->_name AS b WHERE b.`id`=$id";
		$row = $db->fetchRow($sql);
		if($row){
			return $row;
		}
	}
	public function add($data){
		$db = $this->getAdapter();
		$arr = array(
			'name_en'		=>	$data["name_en"],
			'name_kh'		=>	$data["name_kh"],
			'date'		=>	new Zend_Date(),
			'status'	=>	$data["status"]
		);
		$this->insert($arr);
	}
	public function edit($data,$id){
		$db = $this->getAdapter();
		$arr = array(
			'name_en'		=>	$data["name_en"],
			'name_kh'		=>	$data["name_kh"],
			'date'		=>	new Zend_Date(),
			'status'	=>	$data["status"]
		);
		$where = $db->quoteInto("id=?", $id);
		$this->update($arr, $where);
	}
}


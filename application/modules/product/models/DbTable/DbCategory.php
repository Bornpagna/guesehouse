<?php

class Product_Model_DbTable_DbCategory extends Zend_Db_Table_Abstract
{
    protected $_name = 'tb_category';
    public function getUserId(){
    	$session_user=new Zend_Session_Namespace('auth');
    	return $session_user->user_id;
    	 
    }
	public function getCategory(){
		$db = $this->getAdapter();
		$sql="SELECT c.`id`,c.`name`,c.`date`,c.`status` FROM $this->_name AS c WHERE c.`status`=1";
		$row = $db->fetchAll($sql);
		if($row){
			return $row;
		}
	}
	public function getCategoryByID($id){
		$db = $this->getAdapter();
		$sql="SELECT c.`id`,c.`parent_id`,c.`name`,c.`date`,c.`status` FROM $this->_name AS c WHERE c.`id`=$id";
		$row = $db->fetchRow($sql);
		if($row){
			return $row;
		}
	}
	public function add($data){
		$db = $this->getAdapter();
		$arr = array(
			'parent_id'	=>	$data["parent"],
			'name'		=>	$data["name"],
			'date'		=>	new Zend_Date(),
			'status'	=>	$data["status"]
		);
		$this->_name= "tb_category";
		$this->insert($arr);
	}
	public function edit($data,$id){
		$db = $this->getAdapter();
		$arr = array(
				'parent_id'	=>	$data["parent"],
				'name'		=>	$data["name"],
				'date'		=>	new Zend_Date(),
				'status'	=>	$data["status"]
		);
		$this->_name= "tb_category";
		$where = $db->quoteInto("id=?", $id);
		$this->update($arr, $where);
	}
}


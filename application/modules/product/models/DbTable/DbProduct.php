<?php

class Product_Model_DbTable_DbProduct extends Zend_Db_Table_Abstract
{
    protected $_name = 'tb_product';
    public function getUserId(){
    	$session_user=new Zend_Session_Namespace('auth');
    	return $session_user->user_id;
    	 
    }
    public static function getProductCode(){
    	$db = new Application_Model_DbTable_DbGlobal();
    	$sql = "SELECT COUNT(id) AS amount FROM tb_product";
    	$acc_no= $db->getGlobalDbRow($sql);
    	$acc_no=$acc_no['amount'];
    	$new_acc_no= (int)$acc_no+1;
    	$acc_no= strlen((int)$acc_no+1);
    	$pre = "";
    	for($i = $acc_no;$i<3;$i++){
    		$pre.='0';
    	}
    	return "PC".$pre.$new_acc_no;
    }
	public function getProduct(){
		$db = $this->getAdapter();
		$sql="SELECT b.`id`,b.`code`,CONCAT(b.`name_en`,'-',b.`name_kh`) AS `name`,b.`brand_id`,b.`cate_id`,b.`qty_onhand`,b.`date`,b.`status` FROM $this->_name AS b WHERE b.`status`=1";
		$row = $db->fetchAll($sql);
		if($row){
			return $row;
		}
	}
	public function getProductByID($id){
		$db = $this->getAdapter();
		$sql="SELECT b.`id`,b.`name_en`,b.`name_kh`,b.`status`,b.`date`,b.`brand_id`,b.`cate_id`,b.`code`,b.`qty_onhand`,b.`size`,b.`measure_id` FROM $this->_name AS b WHERE b.`id`=$id";
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
			'brand_id'		=>	$data["brand"],
			'cate_id'		=>	$data["category"],
			'code'			=>	$data["code"],
			'size'			=>	$data["pro_size"],
			'measure_id'	=>	$data["measure"],
			'qty_onhand'	=>	$data["qty_onhand"],
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
			'brand_id'		=>	$data["brand"],
			'cate_id'		=>	$data["category"],
			//'code'			=>	$data["code"],
			'size'			=>	$data["pro_size"],
			'measure_id'	=>	$data["measure"],
			'qty_onhand'	=>	$data["qty_onhand"],
			'date'		=>	new Zend_Date(),
			'status'	=>	$data["status"]
		);
		$where = $db->quoteInto("id=?", $id);
		$this->update($arr, $where);
	}
}


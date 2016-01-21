<?php 
Class Product_Form_FrmProduct extends Zend_Dojo_Form {
	protected $tr;
	protected $tvalidate ;//text validate
	protected $filter;
	protected $t_date;
	protected $t_num;
	protected $text;
	protected $check;
	public function init()
	{
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
		$this->tvalidate = 'dijit.form.ValidationTextBox';
		$this->filter = 'dijit.form.FilteringSelect';
		$this->t_date = 'dijit.form.DateTextBox';
		$this->t_num = 'dijit.form.NumberTextBox';
		$this->text = 'dijit.form.TextBox';
		$this->check='dijit.form.CheckBox';
	}
	public function FrmProduct($data=null){
		$db = new Product_Model_DbTable_DbProduct();
		$pro_code = $db->getProductCode();
		$code = new Zend_Dojo_Form_Element_TextBox("code");
		$code->setAttribs(array('dojoType'=>$this->text,'class'=>'fullside','readonly'=>'readonly','style'=>'color:red;'));
		$code->setValue($pro_code);
		
		$name_en = new Zend_Dojo_Form_Element_TextBox('name_en');
		$name_en->setAttribs(array('dojoType'=>$this->text,'class'=>'fullside',));
		
		$name_kh = new Zend_Dojo_Form_Element_TextBox('name_kh');
		$name_kh->setAttribs(array('dojoType'=>$this->text,'class'=>'fullside',));
		
		$db_brand = new Product_Model_DbTable_DbBrand();
		$row = $db_brand->getBrand();
		$brand=  new Zend_Dojo_Form_Element_FilteringSelect('brand');
		$brand->setAttribs(array('dojoType'=>$this->filter,'class'=>'fullside',));
		$opt_parent = array(
				'0'=>$this->tr->translate("SELECT"));
		if($row){
			foreach ($row as $rs){
				$opt_parent[$rs["id"]] = $rs["name"];
			}
		}
		$brand->setMultiOptions($opt_parent);
		
		$db_cate = new Product_Model_DbTable_DbCategory();
		$row= $db_cate->getCategory();
		$category=  new Zend_Dojo_Form_Element_FilteringSelect('category');
		$category->setAttribs(array('dojoType'=>$this->filter,'class'=>'fullside',));
		$opt_cat = array(
				'0'=>$this->tr->translate("SELECT"));
		if($row){
			foreach ($row as $rs){
				$opt_cat[$rs["id"]] = $rs["name"];
			}
		}
		$category->setMultiOptions($opt_cat);
		
		$pro_size = new Zend_Dojo_Form_Element_TextBox("pro_size");
		$pro_size->setAttribs(array('dojoType'=>$this->text,'class'=>'fullside',));
		
		$db_measure = new Product_Model_DbTable_DbMeasure();
		$row = $db_measure->getMeasure();
		$measure=  new Zend_Dojo_Form_Element_FilteringSelect('measure');
		$measure->setAttribs(array('dojoType'=>$this->filter,'class'=>'fullside',));
		$opt_measure = array(
				'0'=>$this->tr->translate("SELECT"));
		if($row){
			foreach ($row as $rs){
				$opt_measure[$rs["id"]] = $rs["name"];
			}
		}
		$measure->setMultiOptions($opt_measure);
		
		$qty_onhand = new Zend_Dojo_Form_Element_TextBox("qty_onhand");
		$qty_onhand->setAttribs(array('dojoType'=>$this->t_num,'class'=>'fullside',));
		
		$opt_statu = array(1=>$this->tr->translate("Active"),0=>$this->tr->translate("Deactve"));
		$status = new Zend_Dojo_Form_Element_FilteringSelect('status');
		$status->setAttribs(array('dojoType'=>$this->filter,'class'=>'fullside',));
		$status->setMultiOptions($opt_statu);
		
		$this->addElements(array($name_en,$name_kh,$brand,$status,$code,$category,$pro_size,$qty_onhand,$measure));
		
		if($data){
			$name_en->setValue($data["name_en"]);
			$name_kh->setValue($data["name_kh"]);
			$brand->setValue($data["brand_id"]);
			$category->setValue($data["cate_id"]);
			$code->setValue($data["code"]);
			$pro_size->setValue($data["size"]);
			$measure->setValue($data["measure_id"]);
			$qty_onhand->setValue($data["qty_onhand"]);
			$status->setValue($data["status"]);
		}
		
		return $this;
		
	}
	
}
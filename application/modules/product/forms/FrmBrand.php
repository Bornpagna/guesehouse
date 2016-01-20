<?php 
Class Product_Form_FrmBrand extends Zend_Dojo_Form {
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
	public function FrmBrand($data=null){
		$db = new Product_Model_DbTable_DbBrand();
		$row = $db->getBrand();
		$name_en = new Zend_Dojo_Form_Element_TextBox('name_en');
		$name_en->setAttribs(array('dojoType'=>$this->text,'class'=>'fullside',));
		
		$name_kh = new Zend_Dojo_Form_Element_TextBox('name_kh');
		$name_kh->setAttribs(array('dojoType'=>$this->text,'class'=>'fullside',));
		
		$parent=  new Zend_Dojo_Form_Element_FilteringSelect('parent');
		$parent->setAttribs(array('dojoType'=>$this->filter,'class'=>'fullside',));
		$opt_parent = array(
				'0'=>$this->tr->translate("SELECT"));
		if($row){
			foreach ($row as $rs){
				$opt_parent[$rs["id"]] = $rs["name"];
			}
		}
		$parent->setMultiOptions($opt_parent);
		
		$opt_statu = array(1=>$this->tr->translate("Active"),0=>$this->tr->translate("Deactve"));
		$status = new Zend_Dojo_Form_Element_FilteringSelect('status');
		$status->setAttribs(array('dojoType'=>$this->filter,'class'=>'fullside',));
		$status->setMultiOptions($opt_statu);
		
		$this->addElements(array($name_en,$name_kh,$parent,$status));
		
		if($data){
			$parent->setValue($data["parent_id"]);
			$name_en->setValue($data["name_en"]);
			$name_kh->setValue($data["name_kh"]);
			$status->setValue($data["status"]);
		}
		
		return $this;
		
	}
	
}
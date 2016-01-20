<?php 
Class Product_Form_FrmCategory extends Zend_Dojo_Form {
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
	public function FrmCategory($data=null){
		$db = new Product_Model_DbTable_DbCategory();
		$row = $db->getCategory();
		$name = new Zend_Dojo_Form_Element_TextBox('name');
		$name->setAttribs(array('dojoType'=>$this->text,'class'=>'fullside',));
		
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
		
		$this->addElements(array($name,$parent,$status));
		
		if($data){
			$parent->setValue($data["parent_id"]);
			$name->setValue($data["name"]);
			$status->setValue($data["status"]);
		}
		
		return $this;
		
	}
	
}
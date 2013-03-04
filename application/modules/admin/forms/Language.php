<?php

class Admin_Form_Language extends Zend_Form
{

 public function __construct($option = null) {
        parent::__construct($option);
        
        $this->setName('languageForm');
        $this->setAttrib('id','article')
             ->setAttrib('class', 'article')
             ->setMethod('get')
             ->setAction('#')
             ->setAttrib('enctype', 'multipart/form-data');
        
        $lang = new Application_Model_Lang_Data_Lang();
        $l = $lang->getAll();
        $languages = array();
        foreach($l as $key){
           $languages[$key->getId()] = $key->getLang();   
                    }
        
        $language = new Zend_Form_Element_Select('language');
        $language->removeDecorator('label')
                 ->removeDecorator('DtDdWrapper')
                 ->setAttrib('class', 'field')
                 ->removeDecorator('htmlTag')
                 ->addMultiOptions($languages);
     
           $submit = new Zend_Form_Element_Button('submitButton');
           $submit->setLabel('Select')
                  ->removeDecorator('DtDdWrapper')
                  ->removeDecorator('htmlTag')
                  ->setAttrib('type', 'submit')
                  ->setIgnore(true);
                
           
        $this->addElements(array($language,$submit));
        $this->setDecorators(array(array('ViewScript', array('viewScript' =>'settings/language_form.phtml'))));
     
        
 }

}


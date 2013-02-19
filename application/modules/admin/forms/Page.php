<?php

class Admin_Form_Page extends Zend_Form
{

 public function __construct($option = null) {
        parent::__construct($option);
        
        $this->setName('ArticleForm');
        $this->setAttrib('id','article')
             ->setAttrib('class', 'article')
             ->setAction('#')
             ->setAttrib('enctype', 'multipart/form-data');
        
        $title = new Zend_Form_Element_Text('title');
        $title->removeDecorator('label')                
              ->removeDecorator('DtDdWrapper')
              ->removeDecorator('htmlTag')
              ->setAttrib('class', 'field required')
              ->addFilter('StringTrim')
              ->setRequired(true)
              ->addValidator('NotEmpty', true, array('messages' => 'This field is mandatory'));
        
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
        
        $status = new Zend_Form_Element_Select('status');
        $status->removeDecorator('label')
               ->removeDecorator('DtDdWrapper')
               ->setAttrib('class', 'field')
               ->removeDecorator('htmlTag')
               ->addMultiOptions(array(0 => 'Disabled',1 => 'Enabled'));
        
       
        $description = new Zend_Form_Element_Textarea('content');
        $description->removeDecorator('label')                
                    ->removeDecorator('DtDdWrapper')
                    ->removeDecorator('htmlTag')
                    ->setAttrib('class', 'field required')
                    ->addFilter('StringTrim')
                    ->setRequired(true)
                    ->addValidator('NotEmpty', true, array('messages' => 'This field is mandatory'));

        
           $file = new Zend_Form_Element_File('file');
           $file->removeDecorator('label')  
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('htmlTag')
                ->addValidator('Extension', false, 'jpg,png,gif,bmp,jpeg',array('messages' => 'Invalid file type only images with jpg,png,gif,bmp,jpeg extensions allowed '))
                ->setValueDisabled(true)
                ->setMultiFile(5);
           
        $inc_in_header = new Zend_Form_Element_Select('header');
        $inc_in_header->removeDecorator('label')
               ->removeDecorator('DtDdWrapper')
               ->setAttrib('class', 'field')
               ->removeDecorator('htmlTag')
               ->addMultiOptions(array(0 => 'No',1 => 'Yes'));
        
        $inc_in_footer = new Zend_Form_Element_Select('footer');
        $inc_in_footer->removeDecorator('label')
               ->removeDecorator('DtDdWrapper')
               ->setAttrib('class', 'field')
               ->removeDecorator('htmlTag')
               ->addMultiOptions(array(0 => 'No',1 => 'Yes'));
        
           $submit = new Zend_Form_Element_Button('submitButton');
           $submit->setLabel('Save')
                  ->removeDecorator('DtDdWrapper')
                  ->removeDecorator('htmlTag')
                  ->setAttrib('type', 'submit')
                  ->setIgnore(true);
                
           
        $this->addElements(array($title,$language,$status,$inc_in_header,$inc_in_footer,$description,$file,$submit));
        $this->setDecorators(array(array('ViewScript', array('viewScript' =>'pages/page_form.phtml'))));
     
        
 }

}


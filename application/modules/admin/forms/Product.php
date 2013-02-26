<?php

class Admin_Form_Product extends Zend_Form
{

 public function __construct($option = null) {
        parent::__construct($option);
        
        $this->setName('ArticleForm');
        $this->setAttrib('id','article')
             ->setAttrib('class', 'article')
             ->setAction('#')
             ->setAttrib('enctype', 'multipart/form-data');
        
        $name = new Zend_Form_Element_Text('name');
        $name->removeDecorator('label')                
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
        
       
        $shortDesc = new Zend_Form_Element_Text('short');
        $shortDesc->removeDecorator('label')                
                    ->removeDecorator('DtDdWrapper')
                    ->removeDecorator('htmlTag')
                    ->setAttrib('class', 'field required')
                    ->addFilter('StringTrim')
                    ->setRequired(true)
                    ->addValidator('NotEmpty', true, array('messages' => 'This field is mandatory'));
        
        $description = new Zend_Form_Element_Textarea('description');
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
           
        
        
           $submit = new Zend_Form_Element_Button('submitButton');
           $submit->setLabel('Save')
                  ->removeDecorator('DtDdWrapper')
                  ->removeDecorator('htmlTag')
                  ->setAttrib('type', 'submit')
                  ->setIgnore(true);
                
           
        $this->addElements(array($name,$language,$status,$shortDesc,$description,$file,$submit));
        $this->setDecorators(array(array('ViewScript', array('viewScript' =>'products/product_form.phtml'))));
     
        
 }

}


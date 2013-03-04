<?php

class Admin_Form_Settings extends Zend_Form
{

 public function __construct($option = null) {
        parent::__construct($option);
        
        $this->setName('settingsForm');
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
        
        $meta_description = new Zend_Form_Element_Textarea('meta_description');
        $meta_description->removeDecorator('label')                
                         ->removeDecorator('DtDdWrapper')
                         ->removeDecorator('htmlTag')
                         ->setAttrib('class', 'field')
                         ->addFilter('StringTrim');

        $meta_keywords = new Zend_Form_Element_Text('meta_keywords');
        $meta_keywords->removeDecorator('label')                
                      ->removeDecorator('DtDdWrapper')
                      ->removeDecorator('htmlTag')
                      ->setAttrib('class', 'field')
                      ->addFilter('StringTrim');
        
        
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
     
        
           $file = new Zend_Form_Element_File('file');
           $file->removeDecorator('label')  
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('htmlTag')
                ->addValidator('Extension', false, 'jpg,png,gif,bmp,jpeg',array('messages' => 'Invalid file type only images with jpg,png,gif,bmp,jpeg extensions allowed '))
                ->setValueDisabled(true);
           
          $file2 = new Zend_Form_Element_File('file2');
          $file2->removeDecorator('label')  
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('htmlTag')
                ->addValidator('Extension', false, 'jpg,png,gif,bmp,jpeg',array('messages' => 'Invalid file type only images with jpg,png,gif,bmp,jpeg extensions allowed '))
                ->setValueDisabled(true);
     
          $contacts = new Application_Model_Contacts_Data_Contacts();
        
        $allContacts = $contacts->getAllContacts();

        $contactList = array();
        if(isset($allContacts) && !empty($allContacts)){
            foreach ($allContacts as $key) {
           $contactList[$key->getId()] = $key->getName() . ' (' . ucfirst($key->getIso()) . ')'; 
            } 
            
         $contactSelect = new Zend_Form_Element_Select('contacts');
         $contactSelect->setMultiOptions($contactList)
                       ->removeDecorator('label')  
                       ->removeDecorator('DtDdWrapper')
                       ->removeDecorator('htmlTag');
          
         $this->addElement($contactSelect);
        }
   
        
           $submit = new Zend_Form_Element_Button('submitButton');
           $submit->setLabel('Save')
                  ->removeDecorator('DtDdWrapper')
                  ->removeDecorator('htmlTag')
                  ->setAttrib('type', 'submit')
                  ->setIgnore(true);
                
           
        $this->addElements(array($title,$language,$meta_description,$meta_keywords,$file,$file2,$submit));
        $this->setDecorators(array(array('ViewScript', array('viewScript' =>'settings/setting_form.phtml'))));
     
        
 }

}


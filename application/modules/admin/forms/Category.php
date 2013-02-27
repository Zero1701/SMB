<?php

class Admin_Form_Category extends Zend_Form
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

        
        $products = new Application_Model_Products_Data_Products();
        
        $allProducts = $products->getAllProducts();
       
        
        $productList = array();
        if(isset($allProducts) && !empty($allProducts)){
            foreach ($allProducts as $key) {
           $productList[$key->getId()] = $key->getName() . ' (' . ucfirst($key->getIso()) . ')'; 
            } 
            
        }
        
        
        $productsSelect = new Zend_Form_Element_Multiselect('products');
        $productsSelect->setMultiOptions($productList)
                       ->removeDecorator('label')  
                       ->removeDecorator('DtDdWrapper')
                       ->removeDecorator('htmlTag');
   
        
        
        
           $file = new Zend_Form_Element_File('file');
           $file->removeDecorator('label')  
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('htmlTag')
                ->addValidator('Extension', false, 'jpg,png,gif,bmp,jpeg',array('messages' => 'Invalid file type only images with jpg,png,gif,bmp,jpeg extensions allowed '))
                ->setValueDisabled(true);
           
        
        
           $submit = new Zend_Form_Element_Button('submitButton');
           $submit->setLabel('Save')
                  ->removeDecorator('DtDdWrapper')
                  ->removeDecorator('htmlTag')
                  ->setAttrib('type', 'submit');
        
           
        $this->addElements(array($title,$language,$status,$shortDesc,$description,$file,$productsSelect,$submit));
        $this->setDecorators(array(array('ViewScript', array('viewScript' =>'categories/category_form.phtml'))));
     
        
 }

}


<?php

class Admin_Form_Article extends Zend_Form
{

 public function __construct($option = null) {
        parent::__construct($option);
        
        $this->setName('ArticleForm');
        $this->setAttrib('id','article')
             ->setAttrib('class', 'article')
              ->setAction('#');
        
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
        
        $featured = new Zend_Form_Element_Select('featured');
        $featured->removeDecorator('label')
                 ->removeDecorator('DtDdWrapper')
                 ->setAttrib('class', 'field')
                 ->removeDecorator('htmlTag')
                 ->addMultiOptions(array(0 => 'No',1 => 'Yes'));
        
        $status = new Zend_Form_Element_Select('status');
        $status->removeDecorator('label')
               ->removeDecorator('DtDdWrapper')
               ->setAttrib('class', 'field')
               ->removeDecorator('htmlTag')
               ->addMultiOptions(array(0 => 'Disabled',1 => 'Enabled'));
        
       
        $description = new Zend_Form_Element_Textarea('description');
        $description->removeDecorator('label')                
                    ->removeDecorator('DtDdWrapper')
                    ->removeDecorator('htmlTag')
                    ->setAttrib('class', 'field required')
                    ->addFilter('StringTrim')
                    ->setRequired(true)
                    ->addValidator('NotEmpty', true, array('messages' => 'This field is mandatory'));
        
           
        
           $datepicker = new ZendX_JQuery_Form_Element_DatePicker('beginDate');
           $datepicker->setJQueryParam('dateFormat','dd.mm.yy.')
                      ->setJQueryParam('timeFormat','hh:mm:ss')
                      ->setJQueryParam('changeYear', 'true')
                      ->setJqueryParam('changeMonth', 'true')
                      //->setJqueryParam('regional', 'us')
                      ->setJqueryParam('yearRange', "-100:+100")
                      //->setDescription('dd.mm.yyyy')
                      ->removeDecorator('label')                
                      ->removeDecorator('DtDdWrapper')
                      ->removeDecorator('htmlTag')
                      ->setAttrib('class', 'field required')
                      ->addFilter('StringTrim')
                      ->setRequired(true)
                      ->addValidator('NotEmpty', true, array('messages' => 'This field is mandatory'));
                      

           
    	

        
        
           
        
           $submit = new Zend_Form_Element_Button('submitButton');
           $submit->setLabel('Save')
                  ->removeDecorator('DtDdWrapper')
                  ->removeDecorator('htmlTag')
                  ->setAttrib('type', 'submit')
                  ->setIgnore(true);
                
           
        $this->addElements(array($title,$language,$featured,$status,$datepicker,$description,$submit));
        $this->setDecorators(array(array('ViewScript', array('viewScript' =>'articles/article_form.phtml'))));
     
        
 }

}


<?php

class Admin_Form_EditDelete extends Zend_Form
{

 public function __construct($option = null) {
        parent::__construct($option);
        
        $this->setName($option['name']);
        $this->setAttrib('id',$option['id'])
             ->setAttrib('class', $option['class'])
             ->setAction($option['action'])
             ->setMethod($option['method']);
                   
          $hidden = new Zend_Form_Element_Hidden('hidden');
          $hidden->removeDecorator('label')                
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('htmlTag')
                 ->setAttrib('class', 'hidden')
                 ->setAttrib('id', 'hidden')
                 ->setName('id')
                 ->addFilter('StringTrim');
        
//           $submit = new Zend_Form_Element_Button('submitButton');
//           $submit->setLabel($option['submitLabel'])
//                  ->removeDecorator('DtDdWrapper')
//                  ->removeDecorator('htmlTag')
//                  ->setAttrib('type', 'submit')
//                  ->setIgnore(true);
           
           $submit = new Zend_Form_Element_Submit('submitButton');
           $submit->setLabel($option['submitLabel'])
                  ->removeDecorator('DtDdWrapper')
                  ->removeDecorator('htmlTag')
                   ->setIgnore(true);
                
           
        $this->addElements(array($hidden,$submit));
        $this->setDecorators(array(array('ViewScript', array('viewScript' =>'articles/editDelete_form.phtml'))));
     
        
 }

}


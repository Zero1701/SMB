<?php

class Admin_Form_Delete extends Zend_Form
{
 public function __construct($option = null) {
        parent::__construct($option);
        
           $this->setName('deleteForm');
           $this->setAttrib('id','delete')
                ->setAttrib('class', 'delete')
                ->setAction('#');
        
           $submitYes = new Zend_Form_Element_Submit('yes');
           $submitYes->setLabel('Yes')
                     ->removeDecorator('DtDdWrapper')
                     ->removeDecorator('htmlTag')
                     ->setAttrib('id', 'submit-button')
                     ->setAttrib('name', 'del')
                     ->setIgnore(true);
           
           $submitNo = new Zend_Form_Element_Submit('no');
           $submitNo->setLabel('No')
                    ->removeDecorator('DtDdWrapper')
                    ->removeDecorator('htmlTag')
                    ->setAttrib('id', 'submit-button1')
                    ->setAttrib('name', 'del')
                    ->setIgnore(true);
           
        $this->addElements(array($submitYes, $submitNo));
        $this->setDecorators(array(array('ViewScript',array('viewScript' =>'articles/delete_form.phtml'))));
     
        
 }
}


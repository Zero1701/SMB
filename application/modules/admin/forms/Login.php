<?php

class Admin_Form_Login extends Zend_Form
{

 public function __construct($option = null) {
        parent::__construct($option);
        
        $this->setName('LoginForm');
        $this->setAttrib('id','login')
             ->setAttrib('class', 'login')
              ->setAction('#');
        
        $userName = new Zend_Form_Element_Text('userName');
        $userName->removeDecorator('label')                
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('htmlTag')
                 ->setAttrib('class', 'field required')
                 ->addFilter('StringTrim')
                 ->setRequired(true)
                 ->addValidator('NotEmpty', true, array('messages' => 'Polje je obvezno za unos'))
                 ->addValidator('EmailAddress', true, array('messages' => 'Neispravna E-mail adresa'));
        
           $password = new Zend_Form_Element_Password('password');
           $password->removeDecorator('label')
                    ->removeDecorator('DtDdWrapper')
                    ->removeDecorator('htmlTag')
                    ->setAttrib('class', 'field required')
                    ->addFilter('StringTrim')
                    ->setRequired(true)
                    ->addErrorMessage('Polje je obvezno za unos');
           
           $submit = new Zend_Form_Element_Button('submitButton');
           $submit->setLabel('Logiraj se')
                  ->removeDecorator('DtDdWrapper')
                  ->removeDecorator('htmlTag')
                  ->setAttrib('type', 'submit')
                  ->setIgnore(true);
                
           
        $this->addElements(array($userName,$password,$submit));
        $this->setDecorators(array(array('ViewScript', array('viewScript' =>'index/login_form.phtml'))));
     
        
 }

}


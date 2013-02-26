<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('admin');
        
        $action = $this->getRequest()->getActionName();
        
        if($action !== 'login' && $action !== 'logout')
        {
        $uri=$this->_request->getControllerName();
        $active = $this->view->navigation()->findBy('label',ucfirst($uri));
        if(!$active) {
        	$uri=$this->_request->getActionName();
        	$active = $this->view->navigation()->findBy('label',ucfirst($uri));
        }
        
        $active->active = true;
        
        
        
        }
        
        $products = new Application_Model_Products_Data_Products();
        $latestProducts = $products->getLatest(5);
        $this->view->latestProducts = $latestProducts;
         
        $articles = new Application_Model_Articles_Data_Articles();
        $latestArticles = $articles->getLatest(5);
        $this->view->latestArticles = $latestArticles;
         
        $pages = new Application_Model_Pages_Data_Pages();
        $latestPages = $pages->getLatest(5);
        $this->view->latestPages = $latestPages;
         
        $categories = new Application_Model_Categories_Data_Categories();
        $latestCategories = $categories->getLatest(5);
        $this->view->latestCategories = $latestCategories;
       
        $this->view->addScriptPath('/application/views/scripts');
		$this->view->render('sidebar.phtml');
     
    }

    public function indexAction()
    {
    if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
       
    }
    
    else
    {
       $this->redirect('admin/index/dashboard'); 
    }
   
    }
    
    public function loginAction()
    {
    	$this->_helper->layout->setLayout('admin_login');
    	
       if(Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/dashboard');
        }
        $forma = new Admin_Form_Login();
        
        $request = $this->getRequest();
        
        if($request->isPost()){
        if($forma->isValid($this->_request->getPost())){
            $username = $forma->getValue('userName');
            $password = $forma->getValue('password');
            $authorise = new Application_Model_Auth_Auth();
            $loggedIn = $authorise->authorise($username, $password);
          
           if($loggedIn){
           
               $this->redirect('admin/index/index');
           }
           else
           {
               $this->view->errorMessage = "Neispravno korisničko ime ili lozinka";
           } 
        }
        
        }
        
        $this->view->messages = $this->_helper->FlashMessenger->getMessages('actions');
        $this->view->forma = $forma;
    }
    
 public function logoutAction()
    {
        $this->_helper->layout()->getView()->headTitle('Odjava');
        
        Zend_Auth::getInstance()->clearIdentity();
        $this->redirect('admin/index/index');
    }
    
     public function dashboardAction()
    {
    if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
       
    }
         
    }


}


<?php

class Admin_ArticlesController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('admin');
        
       
        $uri=$this->_request->getControllerName();
        $active = $this->view->navigation()->findBy('label',ucfirst($uri));
        if(!$active) {
        	$uri=$this->_request->getActionName();
        	$active = $this->view->navigation()->findBy('label',ucfirst($uri));
        }
        
        $active->active = true;
        
      	$articles = new Application_Model_Articles_Data_Articles();
        $latestArticles = $articles->getLatest(5);
        $this->view->latestAarticles = $latestArticles;
      
        $this->view->addScriptPath('/application/views/scripts');
	$this->view->render('sidebar.phtml');
        
    }

    public function indexAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
        }
        
        $editForm = new Admin_Form_EditDelete(array('action' => '/admin/articles/edit','id' => 'edit','method' =>'get','class' => 'edit','name' => 'edit','submitLabel' => 'Edit' ));
        $this->view->editForm = $editForm;
        
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/articles/delete','method' =>'get','id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
        $this->view->deleteForm = $deleteForm;
        
        $articles = new Application_Model_Articles_Data_Articles();
        $lang = new Application_Model_Lang_Data_Lang();
        $userData = new Application_Model_UserData_Data_UserData();
        
        if($this->hasParam('page')) {
            $allArticles = $articles->getAllPaginator($this->getParam('page'));
            $this->view->pageNum = $allArticles->getPages()->pageCount;
        }
        else {
            $allArticles = $articles->getAllPaginator(1);
            $this->view->pageNum = $allArticles->getPages()->pageCount;
        }
        
        $this->view->articles = $allArticles;
        $this->view->lang = $lang;
        $this->view->userData = $userData;
        $this->view->messages = $this->_helper->flashMessenger->getMessages('actions');
        
    }
    
    public function newAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
        }
        
        $form = new Admin_Form_Article();
        $articles = new Application_Model_Articles_Data_Articles();
        
        $request = $this->getRequest();
        $requestParams = $this->getRequest()->getParams();
        
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
        $data = array();
        $date = new Zend_Date(trim($requestParams['beginDate']));
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        $data['title'] = trim($requestParams['title']);
        $data['date'] = $date->get('yyyy-MM-dd');
        $data['description'] = trim($requestParams['description']);
        $data['featured'] = trim($requestParams['featured']);
        $data['status'] = trim($requestParams['status']);
        $data['createdby'] = $user;
        $data['editedby'] = $user;
        $data['createdon'] = new Zend_Db_Expr('NOW()');
        $data['editedon'] = new Zend_Db_Expr('NOW()');
        $data['lang'] = trim($requestParams['language']);
        
        $articles->save($data);
        
        $successMessage = "Article successfully created.";        
        $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');       
        $this->redirect('admin/articles/index');
        
        }
        }
        $this->view->form = $form;
    }
    
    public function editAction() 
    {
        $this->mergeQueryString();
         if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
        }
        
        $request = $this->getRequest();
        $requestParams = $this->getRequest()->getParams();
      
        if(isset($requestParams['id']))
       {
        $id = $requestParams['id'];
       }
       
        if(!$this->hasParam('id')) {
            $errorMessage = 'Invalid id parameter';
            $this->view->errorMessage = $errorMessage;
        }
        else
        {
            
        $form = new Admin_Form_Article();
        $articles = new Application_Model_Articles_Data_Articles();
        $row = $articles->getRowById($id);
        if($row)
     {
        
     
        $date = new Zend_Date((string) trim($row[0]->getDate()));
        $form->getElement('title')->setValue((string) trim($row[0]->getTitle()));
        $form->getElement('language')->setValue((int) trim($row[0]->getLang()));
        $form->getElement('featured')->setValue((int) trim($row[0]->getFeatured()));
        $form->getElement('status')->setValue((int) trim($row[0]->getStatus()));
        $form->getElement('beginDate')->setValue($date->get('dd.MM.yyyy. hh:mm:ss'));
        $form->getElement('description')->setValue((string) trim($row[0]->getDescription()));
        
     
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
        $data = array();
        $date = new Zend_Date(trim($requestParams['beginDate']));
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        $data['id'] = $id;
        $data['title'] = trim($requestParams['title']);
        $data['date'] = $date->get('yyyy-MM-dd');
        $data['description'] = trim($requestParams['description']);
        $data['featured'] = trim($requestParams['featured']);
        $data['status'] = trim($requestParams['status']);
        $data['editedby'] = $user;
        $data['editedon'] = new Zend_Db_Expr('NOW()');
        $data['lang'] = trim($requestParams['language']);
        
        $articles->save($data);
        
        $successMessage = "Article successfully edited.";        
        $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');       
        $this->redirect('admin/articles/index');
          
        }
        }
        $this->view->form = $form;
        }
        else
        {
          $errorMessage = 'Invalid id parameter';
          $this->view->errorMessage = $errorMessage;  
        }
        
    }
    }
    
    public function deleteAction() {
        
        $this->mergeQueryString();
         if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
        }
        
        $request = $this->getRequest();
        $requestParams = $this->getRequest()->getParams();
       
        if(isset($requestParams['id']))
       {
        $id = $requestParams['id'];
       }
        
        if(!$this->hasParam('id')) {
            $errorMessage = 'Invalid id parameter';
            $this->view->errorMessage = $errorMessage;
        }
        else
        {
            
        $form = new Admin_Form_Delete();
        $articles = new Application_Model_Articles_Data_Articles();
        $row = $articles->getRowById($id);
        if($row)
     {
     
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
          
            $del = $request->getParam('del');
            if ($del == 'Yes') {
                $articles->delete($id);
                
                $successMessage = "Article successfully deleted.";        
                $this->_helper->FlashMessenger->addMessage($successMessage, 'actions'); 
                
                $this->redirect('admin/articles/index');
                } else {
                $this->redirect('admin/articles/index');
                }       
          
        }
        }
        
        $this->view->form = $form;
        } else {
          $errorMessage = 'Invalid id parameter';
          $this->view->errorMessage = $errorMessage;  
        }
        
    }
        
    }
    
   public function featuredAction(){
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
        }
        
        $editForm = new Admin_Form_EditDelete(array('action' => '/admin/articles/edit','id' => 'edit','method' =>'get','class' => 'edit','name' => 'edit','submitLabel' => 'Edit' ));
        $this->view->editForm = $editForm;
        
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/articles/delete','method' =>'get','id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
        $this->view->deleteForm = $deleteForm;
        
        $articles = new Application_Model_Articles_Data_Articles();
        $lang = new Application_Model_Lang_Data_Lang();
        $userData = new Application_Model_UserData_Data_UserData();
        
        if($this->hasParam('page')) {
            $allArticles = $articles->getAllFeaturedArticlesPaginator($this->getParam('page'));
            $this->view->pageNum = $allArticles->getPages()->pageCount;
        }
        else {
            $allArticles = $articles->getAllFeaturedArticlesPaginator(1);
            $this->view->pageNum = $allArticles->getPages()->pageCount;
        }
        
        $this->view->articles = $allArticles;
        $this->view->lang = $lang;
        $this->view->userData = $userData;
        $this->view->messages = $this->_helper->flashMessenger->getMessages('actions');
   }
           
}


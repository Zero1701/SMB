<?php

class Admin_PagesController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('admin');
        
        $uri=$this->_request->getControllerName();
        $active = $this->view->navigation()->findBy('label',ucfirst($uri));
        $active->active = true;
        
      	$pages = new Application_Model_Pages_Data_Pages();
        $latestPages = $pages->getLatest(5);
        $this->view->latestPages = $latestPages;
      
        $this->view->addScriptPath('/application/views/scripts');
	$this->view->render('sidebar.phtml');
        
    }

    public function indexAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
        }
        
        $request = $this->getRequest();
        
        
        
        $editForm = new Admin_Form_EditDelete(array('action' => '/admin/articles/edit','method' => 'get','id' => 'edit','class' => 'edit','name' => 'edit','submitLabel' => 'Edit' ));
        $this->view->editForm = $editForm;
        
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/articles/delete','method' => 'get','id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
        $this->view->deleteForm = $deleteForm;
        
        $upForm = new Admin_Form_EditDelete(array('action' => '#','method' => 'post','id' => 'up','class' => 'up','name' => 'up','submitLabel' => '+' ));
        $this->view->upForm = $upForm;
        
        $downForm = new Admin_Form_EditDelete(array('action' => '#','method' => 'post','id' => 'down','class' => 'down','name' => 'down','submitLabel' => '-' ));
        $this->view->downForm = $downForm;
        
        $pages = new Application_Model_Pages_Data_Pages();
        $lang = new Application_Model_Lang_Data_Lang();
        $userData = new Application_Model_UserData_Data_UserData();
        
        if($this->hasParam('page')) {
            $allPages = $pages->getInnerJoin($this->getParam('page'));
            $this->view->pageNum = $allPages->getPages()->pageCount;
        }
        else {
            $allPages = $pages->getInnerJoin(1);
            $this->view->pageNum = $allPages->getPages()->pageCount;
        }
        
        if($request->isPost()){
            //if(isset($request->getParam('submitButton')) && !empty($request->getParam('submitButton')));
           // {
           
              if($request->getParam('submitButton') == '+'){ $pages->SortUp($request->getParam('id'));};
              if($request->getParam('submitButton') == '-'){ $pages->SortDown($request->getParam('id'));};
           // }
            //unset($request);
        }
        
        $this->view->pages = $allPages;
        $this->view->lang = $lang;
        $this->view->userData = $userData;
        $this->view->messages = $this->_helper->flashMessenger->getMessages('actions');
        
    }
    
    public function newAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
        }
        
        $form = new Admin_Form_Page();
        $pages = new Application_Model_Pages_Data_Pages();
        $navigation = new Application_Model_Navigation_Data_Navigation();
        $navId = $navigation->getMaxId();
      
        if (isset($navId) && !empty($navId))
        {
        
            $maxSort = $navigation->getMaxId()[0]->getSort();
       
        }
        else
        {
         
            $maxSort = 0;
  
        }
      
        $maxSort++;
      
        $request = $this->getRequest();
        $requestParams = $this->getRequest()->getParams();
        
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
            
                  
        $data = array();
        $navData = array();
        
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        $data['status'] = trim($requestParams['status']);
        $data['title'] = trim($requestParams['title']);
        $data['contents'] = trim($requestParams['content']);
        $data['createdby'] = $user;
        $data['editedby'] = $user;
        $data['createdon'] = new Zend_Db_Expr('NOW()');
        $data['editedon'] = new Zend_Db_Expr('NOW()');
        $data['lang'] = trim($requestParams['language']);
      
        
        $lastId = $pages->save($data);
        
        $pages->saveImg($lastId, true, $user);
     
        $navData['page_id'] = $lastId;
        $navData['sort'] = $maxSort;
        $navData['inc_in_header'] = trim($requestParams['header']);
        $navData['inc_in_footer'] = trim($requestParams['footer']);
        $navData['createdby'] = $user;
        $navData['editedby'] = $user;
        $navData['createdon'] = new Zend_Db_Expr('NOW()');
        $navData['editedon'] = new Zend_Db_Expr('NOW()');
        
        $navigation->save($navData);
        
        $successMessage = "Page successfully created.";        
        $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');       
        $this->redirect('admin/pages/index');
        
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
}


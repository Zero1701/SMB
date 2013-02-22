<?php

class Admin_PagesController extends Zend_Controller_Action
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
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        
        
        
        $editForm = new Admin_Form_EditDelete(array('action' => '/admin/pages/edit','method' => 'get','id' => 'edit','class' => 'edit','name' => 'edit','submitLabel' => 'Edit' ));
        $this->view->editForm = $editForm;
        
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/pages/deletepage','method' => 'get','id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
        $this->view->deleteForm = $deleteForm;
        
        $upForm = new Admin_Form_EditDelete(array('action' => '#','method' => 'post','id' => 'up','class' => 'up','name' => 'up','submitLabel' => '+' ));
        $this->view->upForm = $upForm;
        
        $downForm = new Admin_Form_EditDelete(array('action' => '#','method' => 'post','id' => 'down','class' => 'down','name' => 'down','submitLabel' => '-' ));
        $this->view->downForm = $downForm;
        
        $pages = new Application_Model_Pages_Data_Pages();
        $lang = new Application_Model_Lang_Data_Lang();
        $userData = new Application_Model_UserData_Data_UserData();
        
        if($request->isPost()){
            
           
              if($request->getParam('submitButton') == '+'){ $pages->SortUp($request->getParam('id'),$user);};
              if($request->getParam('submitButton') == '-'){ $pages->SortDown($request->getParam('id'), $user);};
         
           
            $request->setParam('submitButton', null);
            
        }
        
        if($this->hasParam('page')) {
            $allPages = $pages->getInnerJoin($this->getParam('page'));
            $this->view->pageNum = $allPages->getPages()->pageCount;
        }
        else {
            $allPages = $pages->getInnerJoin(1);
            $this->view->pageNum = $allPages->getPages()->pageCount;
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
            
        $form = new Admin_Form_Page();
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/pages/deleteimage', 'method' => 'get', 'id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
        $pages = new Application_Model_Pages_Data_Pages();
        $row = $pages->getRowById($id);
        if($row)
     {
       
       
        
        
       $navigation = new Application_Model_Navigation_Data_Navigation();
       
       $image = new Application_Model_Images_Data_Images();
       $imagePath = '/images/pages/' . $id . '/';
       $images = $image->getAllImagesByPageId($row[0]->getId());
       
       
       $navRow = $navigation->getPageDataById($row[0]->getId());
     
  
     
        
        $form->getElement('title')->setValue((string) trim($row[0]->getTitle()));
        $form->getElement('language')->setValue((int) trim($row[0]->getLang()));
        $form->getElement('status')->setValue((int) trim($row[0]->getStatus()));
        $form->getElement('header')->setValue((boolean) trim($navRow[0]->getInc_in_header()));
        $form->getElement('footer')->setValue((boolean) trim($navRow[0]->getInc_in_footer()));
        $form->getElement('content')->setValue((string) trim($row[0]->getContents()));
        
     
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
        $pageData = array();
        $navigationData = array();
        
        
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        $pageData['id'] = $id;
        $pageData['status'] = trim((int) $requestParams['status']);
        $pageData['title'] = trim((string) $requestParams['title']);
        $pageData['contents'] = trim((string) $requestParams['content']);
        $pageData['editedby'] = $user;
        $pageData['editedon'] = new Zend_Db_Expr('NOW()');
        $pageData['lang'] = trim($requestParams['language']);
        
        $navigationData['id'] = trim($navRow[0]->getId());
        $navigationData['inc_in_header'] = trim((int) $requestParams['header']);
        $navigationData['inc_in_footer'] = trim((int) $requestParams['footer']);
        $navigationData['editedby'] = $user;
        $navigationData['editedon'] = new Zend_Db_Expr('NOW()');
      
       
        $pages->save($pageData);
        $navigation->save($navigationData);
        $pages->saveImg($id, true, $user);
        
        $successMessage = "Page successfully edited.";        
        $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');       
        $this->redirect('admin/pages/index');
          
        }
        }
        $this->view->form = $form;
        $this->view->images = $images;
        $this->view->imagePath = $imagePath;
        $this->view->deleteForm = $deleteForm;
        
        }
        else
        {
          $errorMessage = 'Invalid id parameter';
          $this->view->errorMessage = $errorMessage;  
        }
        
    }
    }
    
    public function deleteimageAction() {
        
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
        $image = new Application_Model_Images_Data_Images();
        $row = $image->getRowById($id);
        if($row)
     {
       $imageToPage = new Application_Model_ImgToPage_Data_ImgToPage();
       
       $imageToPageRow = $imageToPage->getRowByImageId($id);
       if(isset($imageToPageRow) && !empty($imageToPageRow))
       {
       $imageToPageId = $imageToPageRow[0]->getId();
       }
       
     if(isset($imageToPageId) && !empty($imageToPageId)){
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
          
            $del = $request->getParam('del');
            if ($del == 'Yes') {
                
                
                $imageToPage->delete($imageToPageId);
                $image->delete($id);
                $image->unlinkImage($imageToPageRow[0]->getPage_id(),$row[0]->getImg(),'pages');
                
                $successMessage = "Article successfully deleted.";        
                $this->_helper->FlashMessenger->addMessage($successMessage, 'actions'); 
                
                $this->redirect('admin/pages/edit/id/' . $imageToPageRow[0]->getPage_id());
                } else {
                $this->redirect('admin/pages/edit/id/' . $imageToPageRow[0]->getPage_id());
                }       
          
        }
        }
        
        $this->view->form = $form;
        } else {
          $errorMessage = 'This image is not linked to this product';
          $this->view->errorMessage = $errorMessage;  
        }
        
    } else {
          $errorMessage = 'Invalid id parameter';
          $this->view->errorMessage = $errorMessage;  
    }
        }  
    }
    
    public function deletepageAction() {
        
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
        $page = new Application_Model_Pages_Data_Pages();
        $row = $page->getRowById($id);
        if($row)
     {
       $image = new Application_Model_Images_Data_Images();     
            
       $imageToPage = new Application_Model_ImgToPage_Data_ImgToPage();
       
       $allImageToPage = $imageToPage->getAllByPageId($id);
       
       $allImages = $image->getAllImagesByPageId($id);            
     
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
          
            $del = $request->getParam('del');
            if ($del == 'Yes') {
                
                foreach ($allImageToPage as $key) {
                    
                    $imageToPage->delete($key->getId());
                    
                }
                
                foreach ($allImages as $key) {
                    
                    $image->delete($key->getId());
                }
                
                $page->delete($id);
                
                $page->deleteFolder($id);
                
                $successMessage = "Page successfully deleted.";
                
                $this->_helper->FlashMessenger->addMessage($successMessage, 'actions'); 
                
                $this->redirect('admin/pages/index');
                } else {
                $this->redirect('admin/pages/index');
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


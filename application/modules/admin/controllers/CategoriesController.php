<?php

class Admin_CategoriesController extends Zend_Controller_Action
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
        
        $request = $this->getRequest();
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        
        
        
        $editForm = new Admin_Form_EditDelete(array('action' => '/admin/categories/edit','method' => 'get','id' => 'edit','class' => 'edit','name' => 'edit','submitLabel' => 'Edit' ));
        $this->view->editForm = $editForm;
        
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/categories/deletepage','method' => 'get','id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
        $this->view->deleteForm = $deleteForm;
        
        $upForm = new Admin_Form_EditDelete(array('action' => '#','method' => 'post','id' => 'up','class' => 'up','name' => 'up','submitLabel' => '+' ));
        $this->view->upForm = $upForm;
        
        $downForm = new Admin_Form_EditDelete(array('action' => '#','method' => 'post','id' => 'down','class' => 'down','name' => 'down','submitLabel' => '-' ));
        $this->view->downForm = $downForm;
        
        $categories = new Application_Model_Categories_Data_Categories();
        $lang = new Application_Model_Lang_Data_Lang();
        $userData = new Application_Model_UserData_Data_UserData();
        
        
        
        if($this->hasParam('page')) {
            $allCategories = $categories->getAllPaginator($this->getParam('page'));
            $this->view->pageNum = $allCategories->getPages()->pageCount;
        }
        else {
            $allCategories = $categories->getAllPaginator(1);
            $this->view->pageNum = $allCategories->getPages()->pageCount;
        }
        
        
        
        $this->view->categories = $allCategories;
        $this->view->lang = $lang;
        $this->view->userData = $userData;
        $this->view->messages = $this->_helper->flashMessenger->getMessages('actions');
        
    }
    
    public function newAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
        }
        
        $form = new Admin_Form_Category();
        $categories = new Application_Model_Categories_Data_Categories();
        $img = new Application_Model_Images_Data_Images();
        $categoryToProduct = new Application_Model_CategoryToProduct_Data_CategoryToProduct();
      
        $request = $this->getRequest();
        $requestParams = $this->getRequest()->getParams();
        
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
            
                  
        $data = array();
       
        
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        $data['title'] = trim($requestParams['title']);
        $data['short_desc'] = trim($requestParams['short']);
        $data['description'] = trim($requestParams['description']);
        $data['createdby'] = $user;
        $data['editedby'] = $user;
        $data['createdon'] = new Zend_Db_Expr('NOW()');
        $data['editedon'] = new Zend_Db_Expr('NOW()');
        $data['status'] = trim($requestParams['status']);
        $data['lang'] = trim($requestParams['language']);
        
        
        
        
        $lastCategoryId = $categories->save($data);
       
        if($this->hasParam('products')){
            $categoryToProduct->deleteCatToProd($lastCategoryId);
            $catProd = array();
            foreach ($requestParams['products'] as $key) {
                $catProd['category_id'] = $lastCategoryId;
                $catProd['product_id'] = $key;   
                $catProd['createdby'] = $user;
                $catProd['editedby'] = $user;
                $catProd['createdon'] = new Zend_Db_Expr('NOW()');
                $catProd['editedon'] = new Zend_Db_Expr('NOW()');
                
            $categoryToProduct->save($catProd);
            }
        }
        
        
       $lastImgId = $categories->saveImg($lastCategoryId, true, $user);
       
       if(isset($lastImgId) && !empty($lastImgId)){
       $categories->save(array('id' => $lastCategoryId,'image_id' =>$lastImgId));
        }
       
        $successMessage = "Category successfully created.";        
        $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');       
        $this->redirect('admin/categories');
        
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
            
        $form = new Admin_Form_Category();
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/pages/deleteimage', 'method' => 'get', 'id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
        $categories = new Application_Model_Categories_Data_Categories();
        $products = new Application_Model_Products_Data_Products();
        $row = $categories->getRowById($id);
        if($row)
     {
       $allProducts = $products->getAllProductByCategoryId($id);
       $image = new Application_Model_Images_Data_Images();
       $imagePath = '/images/categories/' . $id . '/';
       $images = $image->getAllImagesByCategoryId($row[0]->getId());
       
       
        $form->getElement('title')->setValue((string) trim($row[0]->getTitle()));
        $form->getElement('language')->setValue((int) trim($row[0]->getLang()));
        $form->getElement('status')->setValue((int) trim($row[0]->getStatus()));
        $form->getElement('short')->setValue((string) trim($row[0]->getShort_desc()));
        $form->getElement('description')->setValue((string) trim($row[0]->getDescription()));
        
        if(isset($allProducts) && !empty($allProducts)){
            $selectedProducts = array();
            foreach ($allProducts as $key) {
                array_push($selectedProducts, $key->getId());
            }
           $form->getElement('products')->setValue($selectedProducts);     
        }
        
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
        $categoryData = array();
     
        
        
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        $categoryData['id'] = $id;
        $categoryData['title'] = trim($requestParams['title']);
        $categoryData['short_desc'] = trim($requestParams['short']);
        $categoryData['description'] = trim($requestParams['description']);
        $categoryData['createdby'] = $user;
        $categoryData['editedby'] = $user;
        $categoryData['createdon'] = new Zend_Db_Expr('NOW()');
        $categoryData['editedon'] = new Zend_Db_Expr('NOW()');
        $categoryData['status'] = trim($requestParams['status']);
        $categoryData['lang'] = trim($requestParams['language']);
      
      
       
        //$pages->save($pageData);
       
        //$pages->saveImg($id, true, $user);
        
        $successMessage = "Category successfully edited.";        
        $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');       
        //$this->redirect('admin/categories');
          
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


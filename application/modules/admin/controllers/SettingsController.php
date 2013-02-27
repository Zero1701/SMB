<?php

class Admin_SettingsController extends Zend_Controller_Action
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

        $editForm = new Admin_Form_EditDelete(array('action' => '/admin/categories/edit','method' => 'get','id' => 'edit','class' => 'edit','name' => 'edit','submitLabel' => 'Edit' ));
        $this->view->editForm = $editForm;
        
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/categories/deletecategory','method' => 'get','id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
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
        
        $form = new Admin_Form_Settings();
        $settings = new Application_Model_Settings_Data_Settings();
        $settingsToContact = new Application_Model_SettingsToContact_Data_SettingsToContact();
       
        $request = $this->getRequest();
        $requestParams = $this->getRequest()->getParams();
        

        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
        
                  
        $data = array();
       
      
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        $data['title'] = trim($requestParams['title']);
        $data['meta_desc'] = trim($requestParams['meta_description']);
        $data['meta_keywords'] = trim($requestParams['meta_keywords']);
        $data['createdby'] = $user;
        $data['editedby'] = $user;
        $data['createdon'] = new Zend_Db_Expr('NOW()');
        $data['editedon'] = new Zend_Db_Expr('NOW()');
        $data['lang'] = trim($requestParams['language']);
        
     
        
        
        //$lastSettingId = $settings->save($data);
      $adapter = new Zend_File_Transfer_Adapter_Http();
                $files = $adapter->getFileInfo();
                
           $lastSettingId = 1;     
        
       $lastImgId = $settings->saveImg($lastSettingId, true, $user);
       print_r($lastImgId);
       if(isset($lastImgId) && !empty($lastImgId)){
       //$categories->save(array('id' => $lastCategoryId,'image_id' => $lastImgId));
        }
       
        $successMessage = "Category successfully created.";        
        $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');       
        //$this->redirect('admin/settings');
        
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
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/categories/deleteimage', 'method' => 'get', 'id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
        $categories = new Application_Model_Categories_Data_Categories();
        $categoryToProduct = new Application_Model_CategoryToProduct_Data_CategoryToProduct();
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
        $data = array();
       
        
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        $data['id'] = $id;
        $data['title'] = trim($requestParams['title']);
        $data['short_desc'] = trim($requestParams['short']);
        $data['description'] = trim($requestParams['description']);
        $data['createdby'] = $user;
        $data['editedby'] = $user;
        $data['createdon'] = new Zend_Db_Expr('NOW()');
        $data['editedon'] = new Zend_Db_Expr('NOW()');
        $data['status'] = trim($requestParams['status']);
        $data['lang'] = trim($requestParams['language']);
        
        $categories->save($data);
        
        
        $lastCategoryId = $id;
       
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
        } else {
            $categoryToProduct->deleteCatToProd($lastCategoryId);
               }
        
        $upload = new Zend_File_Transfer();
        $files = $upload->getFileInfo();
        $file = $files['file']['name'];
   
        if(isset($file) && !empty($file)){
         if(isset($images) && !empty($images)){
       $image->delete($row[0]->getImage_id());
       $image->unlinkImage($id,$images[0]->getImg(),'categories');
         }
       $lastImgId = $categories->saveImg($lastCategoryId, true, $user);
       
       
       if(isset($lastImgId) && !empty($lastImgId)){
       $categories->save(array('id' => $lastCategoryId,'image_id' => $lastImgId));
        }
        $images = $image->getAllImagesByCategoryId($row[0]->getId());
        
        }
        $successMessage = "Category successfully edited.";        
        $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');       
        $this->redirect('admin/categories');
          
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
       $categories = new Application_Model_Categories_Data_Categories();
       
       $category = $categories->getRowByImageId($id);
       
       if(isset($category) && !empty($category))
       {
       $imageId = $category[0]->getImage_id();
       }
       
     if(isset($imageId) && !empty($imageId)){
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
          
            $del = $request->getParam('del');
            if ($del == 'Yes') {
                
                
                
                $image->delete($id);
                $image->unlinkImage($category[0]->getId(),$row[0]->getImg(),'categories');
                
                $categories->save(array('id' => $category[0]->getId(), 'image_id' => new Zend_Db_Expr('NULL')));
                
                $successMessage = "Image successfully deleted.";        
                $this->_helper->FlashMessenger->addMessage($successMessage, 'actions'); 
                
               $this->redirect('admin/categories/edit/id/' . $category[0]->getId());
                } else {
               $this->redirect('admin/categories/edit/id/' . $category[0]->getId());
                }       
          
        }
        }
        
        $this->view->form = $form;
        } else {
          $errorMessage = 'This image is not linked to this category';
          $this->view->errorMessage = $errorMessage;  
        }
        
    } else {
          $errorMessage = 'Invalid id parameter';
          $this->view->errorMessage = $errorMessage;  
    }
        }  
    }
    
    public function deletecategoryAction() {
        
        
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
        $categories = new Application_Model_Categories_Data_Categories();
        $row = $categories->getRowById($id);
          if(!isset($row) && empty($row))
     {
          $errorMessage = 'Invalid id parameter';
          $this->view->errorMessage = $errorMessage;
          return false;
     }
     
     $rowId = $row[0]->getId();
     
     $products = new Application_Model_Products_Data_Products();
     
    $product = $products->getAllProductByCategoryId($rowId);
        
    
    if(isset($product) && !empty($product)){ 
          
                $productName = '';
                foreach ($product as $key2) {
                $productName .= $key2->getName();
                $productName .= ', ';
                } 
               
          $errorMessage = 'This category cannot be deleted because the following products are bound to it: ' . rtrim($productName, ', ');
          $this->view->errorMessage = $errorMessage;
          return false;
          
          }
       $image = new Application_Model_Images_Data_Images();     
       
       $categoryToProduct = new Application_Model_CategoryToProduct_Data_CategoryToProduct();
       
       $prodCat = $categoryToProduct->getAllByCategoryId($id);
     
       $allImages = $image->getAllImagesByCategoryId($id); 
    
     
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
          
            $del = $request->getParam('del');
            if ($del == 'Yes') {
                
                foreach ($allImages as $key) {
                    
                    $image->delete($key->getId());
                    
                }
                
                foreach ($prodCat as $key) {
                    
                    $categoryToProduct->delete($key->getId());
                }
                
                $categories->delete($id);
                
                $categories->deleteFolder($id);
                
                $successMessage = "Category successfully deleted.";
                
                $this->_helper->FlashMessenger->addMessage($successMessage, 'actions'); 
                
                $this->redirect('admin/categories');
                } else {
                $this->redirect('admin/categories');
                }       
          
        }
        }
        
        $this->view->form = $form;
        
        
    }
        
    }
}


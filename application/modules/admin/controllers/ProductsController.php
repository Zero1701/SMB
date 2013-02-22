<?php

class Admin_ProductsController extends Zend_Controller_Action
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
        
      	$products = new Application_Model_Products_Data_Products();
        $latestProducts = $products->getLatest(5);
        $this->view->latestProducts = $latestProducts;
      
        $this->view->addScriptPath('/application/views/scripts');
	$this->view->render('sidebar.phtml');
        
    }

    public function indexAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
        }
       
        
        $editForm = new Admin_Form_EditDelete(array('action' => '/admin/products/edit','method' => 'get','id' => 'edit','class' => 'edit','name' => 'edit','submitLabel' => 'Edit' ));
        $this->view->editForm = $editForm;
        
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/products/deleteproduct','method' => 'get','id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
        $this->view->deleteForm = $deleteForm;
       
        $products = new Application_Model_Products_Data_Products();
        $lang = new Application_Model_Lang_Data_Lang();
        $userData = new Application_Model_UserData_Data_UserData(); 
        $category = new Application_Model_Categories_Data_Categories();
        
        if($this->hasParam('page')) {
            $allProducts = $products->getAllPaginator($this->getParam('page'));
            $this->view->pageNum = $allProducts->getPages()->pageCount;
        }
        else {
            $allProducts = $products->getAllPaginator(1);
            $this->view->pageNum = $allProducts->getPages()->pageCount;
        }
        
   
        
        $this->view->products = $allProducts;
        $this->view->lang = $lang;
        $this->view->userData = $userData;
        $this->view->category = $category;
        $this->view->messages = $this->_helper->flashMessenger->getMessages('actions');
        
    }
    
    public function newAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->redirect('admin/index/login');
        }
        
        $form = new Admin_Form_Product();
        $products = new Application_Model_Products_Data_Products();
        
      
        $request = $this->getRequest();
        $requestParams = $this->getRequest()->getParams();
        
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
            
                  
        $data = array();

        
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        
        $data['name'] = trim($requestParams['name']);
        $data['short_desc'] = trim($requestParams['short']);
        $data['description'] = trim($requestParams['description']);
        $data['createdby'] = $user;
        $data['editedby'] = $user;
        $data['createdon'] = new Zend_Db_Expr('NOW()');
        $data['editedon'] = new Zend_Db_Expr('NOW()');
        $data['lang'] = trim($requestParams['language']);
        $data['status'] = trim($requestParams['status']);
        
     
        $lastId = $products->save($data);
        
     
        
        $products->saveImg($lastId, true, $user);

        $successMessage = "Page successfully created.";        
        $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');       
        $this->redirect('admin/products/index');
        
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
            
        $form = new Admin_Form_Product();
        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/products/deleteimage', 'method' => 'get', 'id' => 'delete','class' => 'delete','name' => 'delete','submitLabel' => 'Delete' ));
        $products = new Application_Model_Products_Data_Products();
        $row = $products->getRowById($id);
        if($row)
     {
       
       $image = new Application_Model_Images_Data_Images();
       $imagePath = '/images/products/' . $id . '/';
       $images = $image->getAllImagesByProductId($row[0]->getId());
       
 
     
  
     
        
        $form->getElement('name')->setValue((string) trim($row[0]->getName()));
        $form->getElement('language')->setValue((int) trim($row[0]->getLang()));
        $form->getElement('status')->setValue((int) trim($row[0]->getStatus()));
        $form->getElement('short')->setValue((string) trim($row[0]->getShort_desc()));
        $form->getElement('description')->setValue((string) trim($row[0]->getDescription()));
        
     
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
        $productData = array();
    
        
        
        $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
        $productData['id'] = $id;
        $productData['name'] = trim((string) $requestParams['name']);
        $productData['short_desc'] = trim((string) $requestParams['short']);
        $productData['description'] = trim((string) $requestParams['description']);
        $productData['editedby'] = $user;
        $productData['editedon'] = new Zend_Db_Expr('NOW()');
        $productData['status'] = trim((int) $requestParams['status']);
        $productData['lang'] = trim($requestParams['language']);
        
        
       
        $products->save($productData);
        
        $products->saveImg($id, true, $user);
        
        $successMessage = "Page successfully edited.";        
        $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');       
        $this->redirect('admin/products/index');
          
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
         
            return false;
        }
    
            
        $form = new Admin_Form_Delete();
        $image = new Application_Model_Images_Data_Images();
        $row = $image->getRowById($id);
        if(!isset($row) && empty($row))
     {
          $errorMessage = 'Invalid id parameter';
          $this->view->errorMessage = $errorMessage;
          return false;
     }
     
       $imageToProduct = new Application_Model_ImgToProduct_Data_ImgToProduct();
       
       $imageToProductRow = $imageToProduct->getRowByImageId($id);
       if(isset($imageToProductRow) && !empty($imageToProductRow))
       {
       $imageToProductId = $imageToProductRow[0]->getId();
       }
        
       if(!isset($imageToProductId) && empty($imageToProductId)){
          $errorMessage = 'This image is not linked to this product';
          $this->view->errorMessage = $errorMessage;  
           return false; 
          
             
         }
         
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
          
            $del = $request->getParam('del');
            if ($del == 'Yes') {
                
                
                $imageToProduct->delete($imageToProductId);
                $image->delete($id);
                $image->unlinkImage($imageToProductRow[0]->getProduct_id(),$row[0]->getImg(),'products');
                
                $successMessage = "Image successfully deleted.";        
                $this->_helper->FlashMessenger->addMessage($successMessage, 'actions'); 
                
                $this->redirect('admin/products/edit/id/' . $imageToProductRow[0]->getProduct_id());
                } else {
                $this->redirect('admin/products/edit/id/' . $imageToProductRow[0]->getProduct_id());
                }       
          
        }
        }
        
        $this->view->form = $form;
        
        
        }
    
    public function deleteproductAction() {
        
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
        $product = new Application_Model_Products_Data_Products();
        $row = $product->getRowById($id);
          if(!isset($row) && empty($row))
     {
          $errorMessage = 'Invalid id parameter';
          $this->view->errorMessage = $errorMessage;
          return false;
     }
     
     $rowId = $row[0]->getId();
     
     $categories = new Application_Model_Categories_Data_Categories();
     
    $category = $categories->getAllCategoriesByProductId($rowId);
        
    
    if(isset($category) && !empty($category)){ 
          
                $categoryName = '';
                foreach ($category as $key2) {
                $categoryName .= $key2->getTitle();
                $categoryName .= ', ';
                } 
               
          $errorMessage = 'This product cannot be deleted because it is bound to the following categories: ' . rtrim($categoryName, ', ');
          $this->view->errorMessage = $errorMessage;
          return false;
          
          }
       $image = new Application_Model_Images_Data_Images();     
            
       $imageToProduct = new Application_Model_ImgToProduct_Data_ImgToProduct();
       
       $allImageToPage = $imageToProduct->getAllByProductId($id);
       
       $allImages = $image->getAllImagesByProductId($id);            
     
        if($request->isPost()){
        if($form->isValid($this->_request->getPost())){
          
            $del = $request->getParam('del');
            if ($del == 'Yes') {
                
                foreach ($allImageToPage as $key) {
                    
                    $imageToProduct->delete($key->getId());
                    
                }
                
                foreach ($allImages as $key) {
                    
                    $image->delete($key->getId());
                }
                
                $product->delete($id);
                
                $product->deleteFolder($id);
                
                $successMessage = "Product successfully deleted.";
                
                $this->_helper->FlashMessenger->addMessage($successMessage, 'actions'); 
                
                $this->redirect('admin/products/index');
                } else {
                $this->redirect('admin/products/index');
                }       
          
        }
        }
        
        $this->view->form = $form;
        
        
    }
        
    }
}


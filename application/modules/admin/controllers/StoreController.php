<?php
class Admin_StoreController extends Zend_Controller_Action
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
}
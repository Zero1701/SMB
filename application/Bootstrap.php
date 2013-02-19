<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initSidebar(){
		$this->bootstrap('view');
        $view = $this->getResource('view'); 
		$view->placeholder('sidebar')
		     ->setPrefix('<div class="sidebar"><div class="block">')
		     ->setSeparator('</div>\n <div class="block">')
		     ->setPostfix('</div> </div>');
	}
	
	
	protected function _initViewHelpers() {
	$view = new Zend_View();
	$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
 
	$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
	$viewRenderer->setView($view);
	Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        }
	
        protected function _initPlugins() {
				$route = new Application_Model_Navigation_Navigation();
				$route->init();
				$loader = new Zend_Loader_PluginLoader();
				
				
				//$loader->registerNamespace('Application_');
	
	
				$loader->addPrefixPath('Application_Controller_Plugin', '../application/Controller/Plugin/');
	
				$loader->load('ModuleNavigation', false);
	

				if($loader->getClassPath('ModuleNavigation')){
				$loader->getClassName('ModuleNavigation');
	
				
	
// 				$loader->load('Language',false);
		
// 				if($loader->getClassPath('Language')){
// 				$loader->getClassName('Language');
        		$front = Zend_Controller_Front::getInstance();
        		$front->registerPlugin(new Application_Controller_Plugin_ModuleNavigation());
//         		$front->registerPlugin(new Application_Controller_Plugin_Language());
 		}
	
          }
}


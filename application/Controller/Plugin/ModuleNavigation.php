<?php
class Application_Controller_Plugin_ModuleNavigation extends Zend_Controller_Plugin_Abstract {

        public function preDispatch (Zend_Controller_Request_Abstract $request)
        {
        	

                $module = $request->getModuleName();
                if(!$module) $module = "default";
                $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
                $viewRenderer->initView();
                $view = $viewRenderer->view;
				

                if( file_exists(APPLICATION_PATH . '/modules/' . strtolower($module) . '/configs/' . 'navigation.xml')) {

                        $config = new Zend_Config_Xml(APPLICATION_PATH . '/modules/' . strtolower($module) . '/configs/' . 'navigation.xml', 'nav');
                        $navigation = new Zend_Navigation($config);
                        $view->navigation($navigation);

                }elseif( $module === 'default' ){
                	
			
                	 Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.'/controllers/helpers');  
        				// now get the helper  
       				 $linkStructure = Zend_Controller_Action_HelperBroker::getStaticHelper('LinkStructure');  
        				// and assign it to the navigation helper  
        				$view->navigation($linkStructure->direct());  
   					$pages = $view->navigation()->getPages() ;
					foreach($pages as $page){ 
						
						$ex=explode('?',$page->getHref());
						if($ex[0]=='/' && $request->getControllerName()=='index') $ex[0]="/index";
						if(in_array(str_replace('/', '', $ex[0]), $request->getParams())) 
							$page->setActive();
						
					}
                }else {
					echo "OOps! navigation does not exist.";                
                }
                
                

        }

}
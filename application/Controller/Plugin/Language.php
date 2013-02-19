<?php
class Application_Controller_Plugin_Language extends Zend_Controller_Plugin_Abstract{

	public function preDispatch (Zend_Controller_Request_Abstract $request)
        {
        	$req=$request->getParams('l');
        	$lang = '';
        	if(isset($req['l'])):
        	 $lang = $request->getParam('l');
        	 else: $lang='hr';
        	 endif;
        	 
        	 $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
             $viewRenderer->initView();
             $view = $viewRenderer->view;
        	 
        	 $view->lang = $lang;
        }

}
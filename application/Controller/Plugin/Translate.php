<?php
class Application_Controller_Plugin_Translate
    extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $lang = $request->getParam('l', null);

        $translate = Zend_Registry::get('Zend_Translate');
        
        if ($translate->isAvailable($lang)) {
            $translate->setLocale($lang);
        } else {
        	$translate->setLocale('hr');
        }

        // Set language to global param so that our language route can
        // fetch it nicely.
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->setGlobalParam('l', $lang);
    }
}


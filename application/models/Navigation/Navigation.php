<?php
/**
 * Navigation behaviour
 */

class Application_Model_Navigation_Navigation {
	public function init(){
     
		Zend_Controller_Front::getInstance()->getRouter()->addRoute(
		'pageview',
		 new Zend_Controller_Router_Route_Regex(  
    '(?(?=^index$|^moves$|^articles$|^events$|^admin$|^cms$|^save$|^delete$|^edit$)|([a-z0-9-_.]+))',  
    array(  
        'controller' => 'page',  
        'action' => 'index',  
        'slug' => null  
    ),  
    array(  
        1 => 'slug',  
    ),  
    '%s'  
    )
		
		);
		
		

		
	}
}
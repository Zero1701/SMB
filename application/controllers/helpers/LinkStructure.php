<?php  
class Zend_Controller_Action_Helper_LinkStructure extends  
        Zend_Controller_Action_Helper_Abstract{  
function direct(){  
	
	$route = new Application_Model_Navigation_Navigation();
					$route->init();
	
	
	
	$lang= $this->getRequest()->getParam('l');
	
	$lang ? $l="?l=".$lang : $l=null;
	
	if(!isset($lang)) $lang = 'hr';
	
	//$pages=new Application_Model_Pages();
	//$ln=new Application_Model_Language();
	//$ln = $ln->findLang($lang);
	//$pages=$pages->fetchAllLang($ln[0]->getId());
	
	
	$structure = array(  
    array(  
         'label'=>'Home',  
         'uri'=>'/'. $l 
    ),  
    array(  
         'label'=>'Events',  
         'uri'=>'/events' . $l  
    ),
    array(  
         'label'=>'Articles',  
         'uri'=>'/articles' . $l  
    ), 
    array(  
         'label'=>'Moves',  
         'uri'=>'/moves'  . $l 
    ) 
    , 
    array(  
         'label'=>'Gallery',  
         'uri'=>'/gallery/index'  . $l 
    ) 
                       
);  


//foreach($pages as $page){
//		$link['uri'] ='/' . $page->getUrl(). $l ;
//		$link['label'] = $page->getTitle();
//		
//		$structure[count($structure)]=$link;
//	}
	
	$structure[count($structure)] = array(  
         'label'=>'Contact',  
         'uri'=>'/contact/index'  . $l 
    );
	
return new Zend_Navigation($structure);  
}  
} 
<?php

class Application_Model_Lang_Data_Lang extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_iso;
                protected $_lang;    			
    			
                protected $_tableName = 'lang';
                protected $_class = 'Application_Model_Lang_Data_Lang';
    
                public function setId($id)
                {
                    $this ->_id = (int) $id;
                    return $this;
                }
        
                public function getId()
                {
                    return $this->_id;
                }
                
   
                public function setIso($iso)
                {
                    $this ->_iso = (string) $iso;
                    return $this;
                }
        
                public function getIso()
                {
                    return $this->_iso;
      
                }
                
		public function setLang($lang)
                {
                    $this ->_lang = (string) $lang;
                    return $this;
                }
        
                public function getLang()
                {
                    return $this->_lang;
      
                }
                
                //------------------------------------
                public function getRowById ($id) {
                 
                $map = new Application_Model_DbMapper_DbMapper();
                
                return $map->fetchRowById($id, $this->_tableName, $this);
                    
                }
                
                public function getAll () {
                 
                $map = new Application_Model_DbMapper_DbMapper();
                
                return $map->fetchAll($this->_tableName, $this->_class);
                    
                }
                
                
}


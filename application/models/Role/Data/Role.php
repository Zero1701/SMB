<?php

class Application_Model_Role_Data_Role extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_name;
    
                protected $_tableName = 'role';
                protected $_class = 'Application_Model_Role_Data_Role';
    
                public function setId($id)
                {
                    $this ->_id = (int) $id;
                    return $this;
                }
        
                public function getId()
                {
                    return $this->_id;
                }
                
                public function setName($name)
                {
                	$this ->_name = (string) $name;
                	return $this;
                }
                
                public function getName()
                {
                	return $this->_name;
                }
                  
                 
}


<?php

class Application_Model_UserData_Data_UserData extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_name;
                protected $_lastname;
    		protected $_user_id;
    			
                protected $_tableName = 'userdata';
                protected $_class = 'Application_Model_UserData_Data_UserData';
    
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
                
                  public function setLastname($lastname)
                {
                    $this ->_lastname = (string) $lastname;
                    return $this;
                }
        
                public function getLastname()
                {
                    return $this->_lastname;
      
                }
                
		public function setUser_id($user_id)
                {
                    $this ->_user_id = (int) $user_id;
                    return $this;
                }
        
                public function getUser_id()
                {
                    return $this->_user_id;
                }
                
                   //------------------------------------
                public function getRowById ($id) {
                 
                $map = new Application_Model_DbMapper_DbMapper();
                
                return $map->fetchRowById($id, $this->_tableName, $this);
                    
                }
                
                 
}


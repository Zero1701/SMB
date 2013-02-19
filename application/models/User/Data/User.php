<?php

class Application_Model_User_Data_User extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_email;
                protected $_password;
                protected $_role;
    
                protected $_tableName = 'user';
                protected $_class = 'Application_Model_User_Data_User';
    
                public function setId($id)
                {
                    $this ->_id = (int) $id;
                    return $this;
                }
        
                public function getId()
                {
                    return $this->_id;
                }
                
                public function setEmail($email)
                {
                	$this ->_email = (string) $email;
                	return $this;
                }
                
                public function getEmail()
                {
                	return $this->_email;
                }
                  
                  public function setPassword($password)
                {
                    $this ->_password = (string) $password;
                    return $this;
                }
        
                public function getPassword()
                {
                    return $this->_password;
                }
                
                
   
                public function setRole($role)
                {
                    $this ->_role = (int) $role;
                    return $this;
                }
        
                public function getRole()
                {
                    return $this->_role;
      
                }
                
                 
}


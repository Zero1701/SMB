<?php

class Application_Model_Products_Data_Products extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_name;
                protected $_short_desc;
    		protected $_description;
    		protected $_createdby;
    		protected $_editedby;
		protected $_createdon;
    		protected $_editedon;
    		protected $_status;
    		protected $_images_id;
    			
    			
                protected $_tableName = 'products';
                protected $_class = 'Application_Model_Products_Data_Products';
    
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
                
                  public function setShort_desc($short_desc)
                {
                    $this ->_short_desc = (string) $short_desc;
                    return $this;
                }
        
                public function getShort_desc()
                {
                    return $this->_short_desc;
      
                }
                
 				public function setDescription($description)
                {
                    $this ->_description = (string) $description;
                    return $this;
                }
        
                public function getDescription()
                {
                    return $this->_description;
      
                }
        		
				public function setCreatedby($createdby)
                {
                    $this ->_createdby = (int) $createdby;
                    return $this;
                }
                
                public function getCreatedby()
                {
                    return $this->_createdby;
                }
                
				public function setEditedby($editedby)
                {
                    $this ->_editedby = (int) $editedby;
                    return $this;
                }
        
                public function getEditedby()
                {
                    return $this->_editedby;
                }
                
				public function setCreatedon($createdon)
                {
                    $this ->_createdon = (string) $createdon;
                    return $this;
                }
        
                public function getCreatedon()
                {
                    return $this->_createdon;
                }
                
				public function setEditedon($editedon)
                {
                    $this ->_editedon = (string) $editedon;
                    return $this;
                }
        
                public function getEditedon()
                {
                    return $this->_editedon;
                }
				
                public function setStatus($status)
                {
                    $this ->_status = (boolean) $status;
                    return $this;
                }
        
                public function getStatus()
                {
                    return $this->_status;
                }
                
 				public function setImages_id($images_id)
                {
                    $this ->_images_id = (int) $images_id;
                    return $this;
                }
        
                public function getImages_id()
                {
                    return $this->_images_id;
                }
                
               //----------------------------------------------------------------- 
                public function getLatest($limit){
                    
		$map = new Application_Model_DbMapper_DbMapper();
		
		return $map->fetchLast($this->_tableName, $this->_class, $limit);
                
                }
				
                 
}


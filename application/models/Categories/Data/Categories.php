<?php

class Application_Model_Categories_Data_Categories extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_title;
                protected $_short_desc;
    		protected $_description;
                protected $_createdby;
    		protected $_editedby;
		protected $_createdon;
    		protected $_editedon;
                protected $_status;
                protected $_image_id;
                protected $_lang; 


                protected $_tableName = 'categories';
                protected $_class = 'Application_Model_Categories_Data_Categories';
    
                public function setId($id)
                {
                    $this ->_id = (int) $id;
                    return $this;
                }
        
                public function getId()
                {
                    return $this->_id;
                }
                
   
                public function setTitle($title)
                {
                    $this ->_title = (string) $title;
                    return $this;
                }
        
                public function getTitle()
                {
                    return $this->_title;
      
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
                
                public function setImage_id($image_id)
                {
                    $this ->_image_id = (int) $image_id;
                    return $this;
                }
        
                public function getImage_id()
                {
                    return $this->_image_id;
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
                
                
                
                //-----------------------------------------------
            
                 public function save($data){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->save($data, $this->_tableName);
	        
                
                }
                
                public function getRowById($id){
                      
                  
                    $map = new Application_Model_DbMapper_DbMapper();
                 
                    return $map->fetchRowById($id, $this->_tableName, $this);
                    
                }
                
                public function delete($id){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->delete($id, $this->_tableName);
	        
                
                }
                 
}


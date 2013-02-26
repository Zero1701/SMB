<?php

class Application_Model_ImgToPage_Data_ImgToPage extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_page_id;
                protected $_image_id;
    		protected $_createdby;
    		protected $_editedby;
		protected $_createdon;
    		protected $_editedon;
                


                protected $_tableName = 'imgtopage';
                protected $_class = 'Application_Model_ImgToPage_Data_ImgToPage';
    
                public function setId($id)
                {
                    $this ->_id = (int) $id;
                    return $this;
                }
        
                public function getId()
                {
                    return $this->_id;
                }
                
                public function setPage_id($page_id)
                {
                    $this ->_page_id = (int) $page_id;
                    return $this;
                }
        
                public function getPage_id()
                {
                    return $this->_page_id;
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
                               
                
                //----------------------------------------------- 
                
                public function save($data){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->save($data, $this->_tableName);
	        
                
                }
                
                
                public function delete($id){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->delete($id, $this->_tableName);
	        
                
                }
                
                public function getRowByImageId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllByColumnName($this->_tableName, $this->_class, $id, 'image_id');
                }
                
                public function getAllByPageId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllByColumnName($this->_tableName, $this->_class, $id, 'page_id');
                }
                 
}


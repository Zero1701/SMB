<?php

class Application_Model_Images_Data_Images extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_img;
                protected $_status;
    		protected $_createdby;
    		protected $_editedby;
		protected $_createdon;
    		protected $_editedon;
    			
                protected $_tableName = 'images';
                protected $_class = 'Application_Model_Images_Data_Images';
    
                public function setId($id)
                {
                    $this ->_id = (int) $id;
                    return $this;
                }
        
                public function getId()
                {
                    return $this->_id;
                }
                
   
                public function setImg($img)
                {
                    $this ->_img = (string) $img;
                    return $this;
                }
        
                public function getImg()
                {
                    return $this->_img;
      
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
                
                //---------------------------------
                
                public function save($data){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->save($data, $this->_tableName);
	        
                
                }
                
                public function getAllImagesByPageId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllInnerJoinId($id, $this->_tableName, 'imgtopage', 'image', $this->_tableName . '.id', 'asc', $this->_class,'imgtopage.page_id','*',null);
                }
                
                public function getAllImagesByCategoryId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllInnerJoinId($id, $this->_tableName, 'categories', 'image', $this->_tableName . '.id', 'asc', $this->_class,'categories.id','*',null);
                }
                
                public function getWebImageBySettingsId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllInnerJoinId($id, $this->_tableName, 'settings', 'webimg', $this->_tableName . '.id', 'asc', $this->_class,'settings.id','*',null);
                }
                
                public function getMailImageBySettingsId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllInnerJoinId($id, $this->_tableName, 'settings', 'mailimg', $this->_tableName . '.id', 'asc', $this->_class,'settings.id','*',null);
                }
                
                 public function getAllImagesByProductId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllInnerJoinId($id, $this->_tableName, 'imgtoproduct', 'image', $this->_tableName . '.id', 'asc', $this->_class,'imgtoproduct.product_id','*',null);
                }
                
                 public function getRowById($id){
                      
                    $map = new Application_Model_DbMapper_DbMapper();
                 
                    return $map->fetchRowById($id, $this->_tableName, $this);
                    
                }
                
                public function delete($id){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->delete($id, $this->_tableName);
	        
                
                }
                
                public function unlinkImage($id,$name,$imgSubFolder) {
                   
                    $path = realpath(APPLICATION_PATH . '\\..\\Public') . '\\images\\' . $imgSubFolder . '\\' . $id . '\\';
               
                   
                    unlink($path . $name);
                    
                    return true;
                }
                 
}


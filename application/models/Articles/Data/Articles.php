<?php

class Application_Model_Articles_Data_Articles extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_title;
                protected $_date;
    		protected $_description;
                protected $_featured;
                protected $_status;
    		protected $_createdby;
    		protected $_editedby;
		protected $_createdon;
    		protected $_editedon;
                protected $_lang; 


                protected $_tableName = 'articles';
                protected $_class = 'Application_Model_Articles_Data_Articles';
    
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
                
                  public function setDate($date)
                {
                    $this ->_date = (string) $date;
                    return $this;
                }
        
                public function getDate()
                {
                    return $this->_date;
      
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
                
                public function setFeatured($featured)
                {
                    $this ->_featured = (boolean) $featured;
                    return $this;
                }
        
                public function getFeatured()
                {
                    return $this->_featured;
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
               public function getLatest($limit){
                    
                      $map = new Application_Model_DbMapper_DbMapper();
		
                      return $map->fetchLast($this->_tableName, $this->_class, $limit);
                
                }
                
                
                public function getAllPaginator($page = 1){
                
                	$map = new Application_Model_DbMapper_DbMapper();
                
                	return $map->fetchAllPaginator($this->_tableName, $this->_class, $page);
                
                }
                
                public function getAllFeaturedArticlesPaginator($page = 1){
                
                	$map = new Application_Model_DbMapper_DbMapper();
                
                	return $map->fetchAllWhereColumnValueIsPaginator($this->_tableName, $this->_class,'featured',1, $page);
                
                }
                
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


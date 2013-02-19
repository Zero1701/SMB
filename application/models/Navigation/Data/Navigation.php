<?php

class Application_Model_Navigation_Data_Navigation extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_page_id;
                protected $_sort;
                protected $_inc_in_header;
    		protected $_inc_in_footer;
    		protected $_createdby;
    		protected $_editedby;
		protected $_createdon;
    		protected $_editedon;
    			
                protected $_tableName = 'navigation';
                protected $_class = 'Application_Model_Navigation_Data_Navigation';
    
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
                
		public function setSort($sort)
                {
                    $this ->_sort = (int) $sort;
                    return $this;
                }
        
                public function getSort()
                {
                    return $this->_sort;
                }
                
		public function setInc_in_header($inc_in_header)
                {
                    $this ->_inc_in_header = (boolean) $inc_in_header;
                    return $this;
                }
        
                public function getInc_in_header()
                {
                    return $this->_inc_in_header;
                }
                
		public function setInc_in_footer($inc_in_footer)
                {
                    $this ->_inc_in_footer = (boolean) $inc_in_footer;
                    return $this;
                }
        
                public function getInc_in_footer()
                {
                    return $this->_inc_in_footer;
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
                
                //--------------------------------
                
                     public function save($data){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->save($data, $this->_tableName);
	        
                
                }
                
                
                public function delete($id){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->delete($id, $this->_tableName);
	        
                
                }
                
                public function getMaxId() {
                        
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchMax($this->_tableName, $this->_class);
                }
                 
}


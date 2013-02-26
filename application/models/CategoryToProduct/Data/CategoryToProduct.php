<?php

class Application_Model_CategoryToProduct_Data_CategoryToProduct extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_category_id;
                protected $_product_id;
    		protected $_createdby;
    		protected $_editedby;
		protected $_createdon;
    		protected $_editedon;
                


                protected $_tableName = 'categorytoproduct';
                protected $_class = 'Application_Model_CategoryToProduct_Data_CategoryToProduct';
    
                public function setId($id)
                {
                    $this ->_id = (int) $id;
                    return $this;
                }
        
                public function getId()
                {
                    return $this->_id;
                }
                
                public function setCategory_id($category_id)
                {
                    $this ->_category_id = (int) $category_id;
                    return $this;
                }
        
                public function getCategory_id()
                {
                    return $this->_category_id;
                }
                
                 public function setProduct_id($product_id)
                {
                    $this ->_product_id = (int) $product_id;
                    return $this;
                }
        
                public function getProduct_id()
                {
                    return $this->_product_id;
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
                
                 public function deleteCatToProd($id){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->deleteByColumnName($this->_tableName, 'category_id', $id);
	        
                
                }
              


                public function getRowByImageId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllByColumnName($this->_tableName, $this->_class, $id, 'image_id');
                }
                
                public function getAllByPageId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllByColumnName($this->_tableName, $this->_class, $id, 'page_id');
                }
                
                public function getAllByCategoryId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllByColumnName($this->_tableName, $this->_class, $id, 'category_id');
                }
                 
}


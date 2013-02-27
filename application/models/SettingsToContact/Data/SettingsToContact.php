<?php

class Application_Model_SettingsToContact_Data_SettingsToContact extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_settings_id;
                protected $_contact_id;
    		protected $_createdby;
    		protected $_editedby;
		protected $_createdon;
    		protected $_editedon;
                


                protected $_tableName = 'settingstocontact';
                protected $_class = 'Application_Model_SettingsToContact_Data_SettingsToContact';
    
                public function setId($id)
                {
                    $this ->_id = (int) $id;
                    return $this;
                }
        
                public function getId()
                {
                    return $this->_id;
                }
                
                public function setSettings_id($settings_id)
                {
                    $this->_settings = (int) $settings_id;
                    return $this;
                }
        
                public function getSettings_id()
                {
                    return $this->_settings_id;
                }
                
                 public function setContact_id($contact_id)
                {
                    $this->_contact_id = (int) $contact_id;
                    return $this;
                }
        
                public function getContact_id()
                {
                    return $this->_contact_id;
                }
                
		public function setCreatedby($createdby)
                {
                    $this->_createdby = (int) $createdby;
                    return $this;
                }
        
                public function getCreatedby()
                {
                    return $this->_createdby;
                }
                
		public function setEditedby($editedby)
                {
                    $this->_editedby = (int) $editedby;
                    return $this;
                }
        
                public function getEditedby()
                {
                    return $this->_editedby;
                }
                
		public function setCreatedon($createdon)
                {
                    $this->_createdon = (string) $createdon;
                    return $this;
                }
        
                public function getCreatedon()
                {
                    return $this->_createdon;
                }
                
		public function setEditedon($editedon)
                {
                    $this->_editedon = (string) $editedon;
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
                
                public function getAllByProductId($id) {
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    return $map->fetchAllByColumnName($this->_tableName, $this->_class, $id, 'product_id');
                }
                 
}


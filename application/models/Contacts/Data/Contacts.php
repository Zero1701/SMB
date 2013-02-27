<?php

class Application_Model_Contacts_Data_Contacts extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_name;
                protected $_oib;
    		protected $_country;
                protected $_county;
                protected $_city;
                protected $_zip_code;
                protected $_address1;
                protected $_address2;
                protected $_phone;
                protected $_mobile_phone;
                protected $_fax;
                protected $_contact_email;
                protected $_booking_email;
    		protected $_createdby;
    		protected $_editedby;
		protected $_createdon;
    		protected $_editedon;
    		protected $_lang;
                protected $_iso;
                
                protected $_tableName = 'contacts';
                protected $_class = 'Application_Model_Contacts_Data_Contacts';
    
                public function setId($id)
                {
                    $this->_id = (int) $id;
                    return $this;
                }
        
                public function getId()
                {
                    return $this->_id;
                }
                
		public function setName($name)
                {
                    $this->_name = (string) $name;
                    return $this;
                }
        
                public function getName()
                {
                    return $this->_name;
      
                }
                
                public function setOib($oib)
                {
                    $this->_oib = (int) $oib;
                    return $this;
                }
        
                public function getOib()
                {
                    return $this->_oib;
      
                }
                
                  public function setCountry($country)
                {
                    $this->_country = (string) $country;
                    return $this;
                }
        
                public function getCountry()
                {
                    return $this->_country;
      
                }
                
                public function setCounty($county)
                {
                    $this->_county = (string) $county;
                    return $this;
                }
        
                public function getCounty()
                {
                    return $this->_county;
      
                }
                
                public function setCity($city)
                {
                    $this->_city = (string) $city;
                    return $this;
                }
        
                public function getCity()
                {
                    return $this->_city;
      
                }
                
                public function setZip_code($zip_code)
                {
                    $this->_zip_code = (string) $zip_code;
                    return $this;
                }
        
                public function getZip_code()
                {
                    return $this->_zip_code;
      
                }
		
                public function setAddress1($address1)
                {
                    $this->_address1 = (string) $address1;
                    return $this;
                }
        
                public function getAddress1()
                {
                    return $this->_address1;
      
                }
                
                public function setAddress2($address2)
                {
                    $this->_address2 = (string) $address2;
                    return $this;
                }
        
                public function getAddress2()
                {
                    return $this->_address2;
      
                }
                
                public function setPhone($phone)
                {
                    $this->_phone = (string) $phone;
                    return $this;
                }
        
                public function getPhone()
                {
                    return $this->_phone;
      
                }
                
                public function setMobile_phone($mobile_phone)
                {
                    $this->_mobile_phone = (string) $mobile_phone;
                    return $this;
                }
        
                public function getMobile_phone()
                {
                    return $this->_mobile_phone;
      
                }

                public function setFax($fax)
                {
                    $this->_fax = (string) $fax;
                    return $this;
                }
        
                public function getFax()
                {
                    return $this->_fax;
      
                }
                
                public function setContact_email($contact_email)
                {
                    $this->_contact_email = (string) $contact_email;
                    return $this;
                }
        
                public function getContact_email()
                {
                    return $this->_contact_email;
      
                }
                
                public function setBooking_email($booking_email)
                {
                    $this->_booking_email = (string) $booking_email;
                    return $this;
                }
        
                public function getBooking_email()
                {
                    return $this->_booking_email;
      
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
                
                public function setIso($iso)
                {
                    $this ->_iso = (string) $iso;
                    return $this;
                }
        
                public function getIso()
                {
                    return $this->_iso;
      
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
                
              public function getAllContacts(){
                    
		$map = new Application_Model_DbMapper_DbMapper();
		
		return $map->fetchAllInnerJoin($this->_tableName, 'lang', 'lang', 'id','*','iso', $this->_class);
                
                }
             
}


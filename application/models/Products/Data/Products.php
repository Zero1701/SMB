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
    		protected $_lang;
    			
    			
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
                
                 public function setLang($lang)
                {
                    $this ->_lang = (string) $lang;
                    return $this;
                }
        
                public function getLang()
                {
                    return $this->_lang;
                }
                
               //----------------------------------------------------------------- 
                public function getLatest($limit){
                    
		$map = new Application_Model_DbMapper_DbMapper();
		
		return $map->fetchLast($this->_tableName, $this->_class, $limit);
                
                }
                
                 public function getAllPaginator($page = 1){
                
                	$map = new Application_Model_DbMapper_DbMapper();
                
                	return $map->fetchAllPaginator($this->_tableName, $this->_class, $page);
                
                }
                
                public function getRowById($id){
                      
                  
                    $map = new Application_Model_DbMapper_DbMapper();
                 
                    return $map->fetchRowById($id, $this->_tableName, $this);
                    
                }
                
                 public function save($data){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->save($data, $this->_tableName);
	        
                
                }
                
                public function delete($id){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->delete($id, $this->_tableName);
	        
                
                }
                
                public function saveImg($id,$new,$userid,$imgId = null){
                      
                    
                $adapter = new Zend_File_Transfer_Adapter_Http();
                $files = $adapter->getFileInfo();
                $path = realpath(APPLICATION_PATH . '\\..\\Public') . '\\images\\products\\' . $id . '\\';
                $path2 = realpath(APPLICATION_PATH . '\\..\\Public') . '\\images\\products\\' . $id;
              
                $image = new Application_Model_Images_Data_Images();
                $ImgToProduct = new Application_Model_ImgToProduct_Data_ImgToProduct();
                
                if(!is_dir($path2)){ mkdir($path2,0755,true); }
                
                $adapter->setDestination($path);
                foreach($files as $fieldname=>$fileinfo)
                    {
                    if (($adapter->isUploaded($fileinfo['name']))&& ($adapter->isValid($fileinfo['name'])))
                        {
                            $data = array();
                            $data2 = array();
                            $adapter->receive($fileinfo['name']);
                            
                            if($new == true){
                                
                            $data['img'] = $fileinfo['name'];
                            $data['createdby'] = $userid;
                            $data['editedby'] = $userid;
                            $data['createdon'] = new Zend_Db_Expr('NOW()');
                            $data['editedon'] = new Zend_Db_Expr('NOW()');
                            $lastid = $image->save($data);
                            
                            unset($data);
                            
                            $data2['product_id'] = $id;
                            $data2['image_id'] = $lastid;
                            $data2['createdby'] = $userid;
                            $data2['editedby'] = $userid;
                            $data2['createdon'] = new Zend_Db_Expr('NOW()');
                            $data2['editedon'] = new Zend_Db_Expr('NOW()');
                            $ImgToProduct->save($data2);
                            
                            unset($data2);
                            
                            }else{
                                
                            $data['id'] = $imgId;
                            $data['img'] = $fieldname['name'];
                            $data['editedby'] = $userid;
                            $data['editedon'] = new Zend_Db_Expr('NOW()'); 
                            $lastid = $image->save($data);
                            
                            unset($data);
                            
                            $data2['id'] = $imgId;
                            $data2['page_id'] = $id;
                            $data2['image_id'] = $lastid;
                            $data2['editedby'] = $userid;
                            $data2['editedon'] = new Zend_Db_Expr('NOW()');
                            $ImgToProduct->save($data2);
                            
                            unset($data2);
                            
                            }
                            
                          
                        }
                    }
                 return true;
                }
				
                public function deleteFolder($id){
                    
                    $map = new Application_Model_DbMapper_DbMapper();
                    
                    $folderPath = realpath(APPLICATION_PATH . '\\..\\Public\\images\\products\\' . $id . '\\');
                    
                    return $map->deleteAll($folderPath);
                }
}


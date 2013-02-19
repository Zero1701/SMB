<?php

class Application_Model_Pages_Data_Pages extends Application_Model_Abstract_Abstract
{

                protected $_id;
                protected $_status;
                protected $_title;
    		protected $_contents;
    		protected $_createdby;
    		protected $_editedby;
		protected $_createdon;
    		protected $_editedon;
    		protected $_lang;
                protected $_sort;
                
                protected $_tableName = 'pages';
                protected $_class = 'Application_Model_Pages_Data_Pages';
    
                public function setId($id)
                {
                    $this ->_id = (int) $id;
                    return $this;
                }
        
                public function getId()
                {
                    return $this->_id;
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
                
   
                public function setTitle($title)
                {
                    $this ->_title = (string) $title;
                    return $this;
                }
        
                public function getTitle()
                {
                    return $this->_title;
      
                }
                
                  public function setContents($contents)
                {
                    $this ->_contents = (string) $contents;
                    return $this;
                }
        
                public function getContents()
                {
                    return $this->_contents;
      
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
                
                public function setSort($sort)
                {
                    $this ->_sort = (int) $sort;
                    return $this;
                }
        
                public function getSort()
                {
                    return $this->_sort;
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
                
                public function saveImg($id,$new,$userid,$imgId = null){
                      
                    
                $adapter = new Zend_File_Transfer_Adapter_Http();
                $files = $adapter->getFileInfo();
                $path = APPLICATION_PATH . '\\Images\\Pages\\' . $id . '\\';
                $path2 = APPLICATION_PATH . '\\Images\\Pages\\' . $id;
               
                $image = new Application_Model_Images_Data_Images();
                $ImgToPage = new Application_Model_ImgToPage_Data_ImgToPage();
                
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
                            
                            $data2['page_id'] = $id;
                            $data2['image_id'] = $lastid;
                            $data2['createdby'] = $userid;
                            $data2['editedby'] = $userid;
                            $data2['createdon'] = new Zend_Db_Expr('NOW()');
                            $data2['editedon'] = new Zend_Db_Expr('NOW()');
                            $ImgToPage->save($data2);
                            
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
                            $ImgToPage->save($data2);
                            
                            unset($data2);
                            
                            }
                            
                          
                        }
                    }
                 return true;
                }
                
        
              public function getInnerJoin($page){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->fetchAllInnerJoinPaginator($this->_tableName, 'navigation', 'page', 'sort', 'asc', $this->_class,$page);
	        
                
                }
                
                public function SortUp($id){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->SortUP($id,$this->_tableName, 'navigation', 'page', 'sort', 'desc', $this->_class);
	        
                
                }
                
                public function SortDown($id){
		
                    $map = new Application_Model_DbMapper_DbMapper();
		
                    return $map->SortDOWN($id,$this->_tableName, 'navigation', 'page', 'sort', 'desc', $this->_class);
	        
                
                }
}


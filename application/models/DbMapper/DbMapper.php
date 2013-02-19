<?php
class Application_Model_DbMapper_DbMapper extends Application_Model_Abstract_Abstract
{
    
              protected $_dbtable;

    public function setDbTable($dbtable){
        if(is_string($dbtable)){
            $dbtable=new $dbtable();
        }

        if(!$dbtable instanceof Zend_DB_Table_Abstract){
            throw new Exception('Provided table is not instance of Zend_Db_Table!');
        }

        $this->_dbtable=$dbtable;
        return $this;
    }

    public function getDbTable($table_name){
    	//mislim da ovdje treba prepravljati
        if($this->_dbtable===null){
            $this->setDbTable('Application_Model_'.ucfirst($table_name).'_DbTable_'.ucfirst($table_name));
        }
        return $this->_dbtable;
    }
    
       public function fetchAll($table_name, $class_name){
        $result=$this->getDbTable($table_name)->fetchAll();

        $entries=array();

        foreach($result as $row){
            $entry = new $class_name();

            $entry->setOptions($row->toArray());

            $entries[] = $entry;
        }

        return $entries;

    }
    
     public function fetchAllPaginator($table_name, $class_name,$page = null){
        $result=$this->getDbTable($table_name)->fetchAll();

        $entries=array();

        foreach($result as $row){
            $entry = new $class_name();

            $entry->setOptions($row->toArray());

            $entries[] = $entry;
        }

        $paginationCount = 3;
        $pageRange = 5;
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($entries));
        $paginator->setItemCountPerPage($paginationCount);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange($pageRange);
        return $paginator;

    }
    
        public function fetchLast($table_name, $class_name,$limit){
        $result=$this->getDbTable($table_name)->fetchAll($this->_dbtable->select()
                                                        ->where('status = 1')
							->order('editedon ASC')
                                                        ->limitPage(0,$limit));

        $entries=array();
       
        foreach($result as $row){
            $entry = new $class_name();

            $entry->setOptions($row->toArray());

            $entries[] = $entry;
        }

        return $entries;

    }
    
        public function fetchAllById($table_name, $class_name, $id, $column_name,$page = null){
        $result=$this->getDbTable($table_name)->fetchAll($this->_dbtable->select()
                                                        ->where('idUser_FK = ?', $id)
							->order($column_name . " ASC"));

        $entries=array();

        foreach($result as $row){
            $entry = new $class_name();

            $entry->setOptions($row->toArray());

            $entries[] = $entry;
        }
        $paginationCount = 3;
        $pageRange = 5;
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($entries));
        $paginator->setItemCountPerPage($paginationCount);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange($pageRange);
        return $paginator;

    }
    
    public function fetchAllByColumnName($table_name, $class_name, $value, $column_name){
       echo $table_name;
        $dbtable = $this->getDbTable($table_name); 
       
        $select = $dbtable->select()->where($column_name . ' = ?', $value);
        echo $select->__toString();
        //$result=$this->getDbTable($table_name)->fetchAll($select);

        $entries=array();

        foreach($result as $row){
            $entry = new $class_name();

            $entry->setOptions($row->toArray());

            $entries[] = $entry;
        }

        return $entries;

    }
    
  
    
        public function fetchRowById($id, $table_name, $object){
        $result=$this->getDbTable($table_name)->find($id);

        if(count($result)==0){
            //throw new Exception('Cannot find record with specified id.');
            return null;
        //$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        //$redirector->gotoSimple('index','index');


        }

        $row=$result->current();
        $object->setOptions($row->toArray());

        $entries=array();
        $entries[]=$object;
        return $entries;

    }
    
     public function fetchMaxSortId($id, $table_name, $class_name){
        $result=$this->getDbTable($table_name)->fetchAll($this->_dbtable->select()
                                                        ->from($table_name,array('max(sort) as maxId'))
                                                        ->where('idUser_FK = ?', $id));
      

        $entries=array();
        
        foreach($result as $row){
            
            $entry = new $class_name();
             
            $entry->setOptions($row->toArray());
            $entries[] = $entry;
        }

        return $entries;
      
       
    }
    
      public function fetchMax($table_name, $class_name){
          
    $result=$this->getDbTable($table_name)->fetchAll($this->_dbtable->select()
                                                          ->from($table_name)
                                                           ->where('sort = (select max(sort) from `' . $table_name . '`)'));
      

        $entries=array();
        
        foreach($result as $row){
            
            $entry = new $class_name();
             
            $entry->setOptions($row->toArray());
            $entries[] = $entry;
        }

        return $entries;
      
    }
    
    
    
     public function save($data,$table_name){
        if(empty($data['id']) || $data['id']=='' || $data['id'] == null){
            unset($data['id']);
            $result = $this->getDbTable($table_name)->insert($data);
        	return $result;
                    }else{
        	
                $where = $this->getDbTable($table_name)->getAdapter()->quoteInto('id = ?', $data['id']);
                
            $result = $this->getDbTable($table_name)->update($data,$where);
            
            return $result;
        }

    }
    
    public function delete($id,$table_name){
       
                $where = $this->getDbTable($table_name)->getAdapter()->quoteInto('id = ?', $id);
                $result = $this->getDbTable($table_name)->delete($where);
                return $result;
       
        }
        
        public function SortUP($id,$table_name, $table_name2,$foreignId,$sortName,$sort, $class_name) {
            
         $currentSort = $this->fetchAllInnerJoinId($id,$table_name, $table_name2,$foreignId,$sortName,$sort, $class_name);
         $currentPageId = $currentSort[0]->getId();
         $this->fetchAllByColumnName('navigation', 'Application_Model_Navigation_Data_Navigation', $currentPageId, 'page_id');
         
         
//         $db = Zend_Db_Table::getDefaultAdapter();
//         
//       $select = $db->select()->from('navigation')->where('page_id = ?', $currentPageId);
//       $rez = $db->fetchRow($select);
//       
//       $currentPageNum = (int) $rez['page_id'];
//       $currSortNum = (int) ($currentSort[0]->getSort());
//       $lang = (int) $currentSort[0]->getLang();
//        
//         
//         $result = $this->fetchRowInnerJoinLang($lang,$table_name,true ,$table_name2,$foreignId,$sortName,$sort,$currSortNum, $class_name);
//         
//      
//         if(!empty($result))
//         {
//             $dataCurr = array();
//             $dataCurr['id'] = $currentPageNum;
//             $dataCurr['sort'] = (int) ($currSortNum - 1);
//          
            // $this->save($dataCurr, $table_name2);
             
//             $dataPrev = array();
//             $dataPrev['id'] = $result[0]->getid();
//             $dataPrev['sort'] = (int) $currentSort[0]->getsort();
//             $this->save($dataPrev, $table_name2);
//         }
    
         //return $result;
            
        }
        
        public function SortDOWN($id,$table_name, $table_name2,$foreignId,$sortName,$sort, $class_name) {
            
         $currentSort = $this->fetchAllInnerJoinId($id,$table_name, $table_name2,$foreignId,$sortName,$sort, $class_name);
            
         $lang = (int) $currentSort[0]->getLang();
         $currSortNum = (int) ($currentSort[0]->getSort());
       
         
         $result = $this->fetchRowInnerJoinLang($lang,$table_name,false, $table_name2,$foreignId,$sortName,$sort,$currSortNum, $class_name);
         

//         if(!empty($result))
//         {
//             $dataCurr = array();
//             $dataCurr['id'] = $currentSort[0]->getid();
//             $dataCurr['sort'] = (int) ($currSortNum + 1);
//             $this->save($dataCurr, $table_name2);
//             
//             $dataPrev = array();
//             $dataPrev['id'] = $result[0]->getid();
//             $dataPrev['sort'] = (int) $currentSort[0]->getsort();
//             $this->save($dataPrev, $table_name2);
//         }
//  
//         return $result;
            
        }
        
           public function getKeygen(){
                $length = 10;
                $characters = 'z0jtkbc1sde9fx2guh3a8i6ylm4nop7qrvw5';
                $string = '';    
	
	    for ($p = 0; $p < $length; $p++) {
	        $string .= $characters[mt_rand(0, strlen($characters)-1)];
	    }
	    
	    return $string;
    }


         public function fetchAllInnerJoinPaginator($table_name, $table_name2,$foreignId,$sortName,$sort, $class_name,$page = null){
        
        $dbtable1 = $this->getDbTable($table_name);    
        $select = $dbtable1->select();
    	$select->setIntegrityCheck(false)
               ->from($table_name)
               ->join($table_name2, $table_name.'.id = ' . $table_name2 . '.' . $foreignId . '_id' , null)
               ->order($table_name2 . '.' . $sortName . ' ' . $sort);
        
             
        $result=$this->getDbTable($table_name)->fetchAll($select);
         
        $entries=array();

        foreach($result as $row){
            $entry = new $class_name();

            $entry->setOptions($row->toArray());

            $entries[] = $entry;
        }

        $paginationCount = 3;
        $pageRange = 5;
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($entries));
        $paginator->setItemCountPerPage($paginationCount);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange($pageRange);
        return $paginator;

    }
    
    public function fetchAllInnerJoinId($id,$table_name, $table_name2,$foreignId,$sortName,$sort, $class_name){
        
        $dbtable1 = $this->getDbTable($table_name);    
        $select = $dbtable1->select();
    	$select->setIntegrityCheck(false)
               ->from($table_name,'*')
               ->joinInner($table_name2, $table_name . '.id = ' . $table_name2 . '.' . $foreignId . '_id', 'sort')
               ->where($table_name . '.id = ?', $id)
               ->order($sortName . ' ' . $sort);
             
        $result=$this->getDbTable($table_name)->fetchAll($select);
       
        $entries=array();
        
        foreach($result as $row){
            
            $entry = new $class_name();

            $entry->setOptions($row->toArray());

            $entries[] = $entry;
        }

        return $entries;

    }
    
    public function fetchRowInnerJoinLang($lang,$table_name,$minMax ,$table_name2,$foreignId,$sortName,$sort,$value, $class_name){
        
        if($minMax == true){
            $operator = '<';
        } else {
            $operator = '>';
        }
        
        $dbtable1 = $this->getDbTable($table_name);
        $select = $dbtable1->select();
    	$select->setIntegrityCheck(false)
               ->from($table_name,'*')
               ->joinInner($table_name2, $table_name . '.id = ' . $table_name2 . '.' . $foreignId . '_id', 'sort')
               ->where($table_name . '.lang = ?', $lang)
               ->where($sortName . ' ' . $operator . ' ?', $value)
               ->order($sortName . ' ' . $sort)
               ->limitPage(0,1);
        
        
             
        $result=$this->getDbTable($table_name)->fetchAll($select);
       
        $entries=array();
        
        foreach($result as $row){
            
            $entry = new $class_name();

            $entry->setOptions($row->toArray());

            $entries[] = $entry;
        }

        return $entries;

    }
    


}

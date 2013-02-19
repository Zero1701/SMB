<?php

class Application_Model_Auth_Auth
{
 public function authorise($username,$password) {
            
           $authAdapter = $this->getAuthAdapter();
           
         
           
           $authAdapter->setIdentity($username)
                       ->setCredential($password);
           
           $auth = Zend_Auth::getInstance();
           $result = $auth->authenticate($authAdapter);
           if($result->isValid()){
               
               $identity = $authAdapter->getResultRowObject();             
               $authStorage = $auth->getStorage();
                                     
               $authStorage->write($identity);
               return true;
            }
            else
            {
              return false;
            }
     
 }
    
    
    
    public function getAuthAdapter()
    {
        
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('user')
                    ->setIdentityColumn('email')
                    ->setCredentialColumn('password')
                    ->setCredentialTreatment('MD5(?)');
        return $authAdapter;
    }
    
    public function getAuthStorage() {
        if(Zend_Auth::getInstance()->hasIdentity()){
          $auth = Zend_Auth::getInstance();
          $result = $auth->getStorage()->read();
          return $result;
        }
        else
        {
          return null;
        }
    }

}


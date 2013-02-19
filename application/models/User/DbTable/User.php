<?php

class Application_Model_User_DbTable_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'user';
	protected $_primary = 'id';
    protected $_sequence = true;

}


<?php

class Application_Model_Articles_DbTable_Articles extends Zend_Db_Table_Abstract
{

    protected $_name = 'articles';
	protected $_primary = 'id';
    protected $_sequence = true;

}


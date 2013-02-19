<?php

class Application_Model_Products_DbTable_Products extends Zend_Db_Table_Abstract
{

    protected $_name = 'products';
	protected $_primary = 'id';
    protected $_sequence = true;

}


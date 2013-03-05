<?php

class Application_Model_Settings_Data_Settings extends Application_Model_Abstract_Abstract {

    protected $_id;
    protected $_title;
    protected $_meta_desc;
    protected $_meta_keywords;
    protected $_createdby;
    protected $_editedby;
    protected $_createdon;
    protected $_editedon;
    protected $_lang;
    protected $_webimg_id;
    protected $_mailimg_id;
    protected $_tableName = 'settings';
    protected $_class = 'Application_Model_Settings_Data_Settings';

    public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setTitle($title) {
        $this->_title = (string) $title;
        return $this;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function setMeta_desc($meta_desc) {
        $this->_meta_desc = (string) $meta_desc;
        return $this;
    }

    public function getMeta_desc() {
        return $this->_meta_desc;
    }

    public function setMeta_keywords($meta_keywords) {
        $this->_meta_keywords = (string) $meta_keywords;
        return $this;
    }

    public function getMeta_keywords() {
        return $this->_meta_keywords;
    }

    public function setCreatedby($createdby) {
        $this->_createdby = (int) $createdby;
        return $this;
    }

    public function getCreatedby() {
        return $this->_createdby;
    }

    public function setEditedby($editedby) {
        $this->_editedby = (int) $editedby;
        return $this;
    }

    public function getEditedby() {
        return $this->_editedby;
    }

    public function setCreatedon($createdon) {
        $this->_createdon = (string) $createdon;
        return $this;
    }

    public function getCreatedon() {
        return $this->_createdon;
    }

    public function setEditedon($editedon) {
        $this->_editedon = (string) $editedon;
        return $this;
    }

    public function getEditedon() {
        return $this->_editedon;
    }

    public function setLang($lang) {
        $this->_lang = (string) $lang;
        return $this;
    }

    public function getLang() {
        return $this->_lang;
    }

    public function setWebimg_id($webimg_id) {
        $this->_webimg_id = (int) $webimg_id;
        return $this;
    }

    public function getWebimg_id() {
        return $this->_webimg_id;
    }

    public function setMailimg_id($mailimg_id) {
        $this->_mailimg_id = (int) $mailimg_id;
        return $this;
    }

    public function getMailimg_id() {
        return $this->_mailimg_id;
    }

    //-----------------------------------------------

    public function getAllPaginator($page = 1) {

        $map = new Application_Model_DbMapper_DbMapper();

        return $map->fetchAllPaginator($this->_tableName, $this->_class, $page);
    }

    public function getAllByLang($lang) {

        $map = new Application_Model_DbMapper_DbMapper();

        return $map->fetchAllByColumnName($this->_tableName, $this->_class, $lang, 'lang');
    }

    public function getAllFeaturedArticlesPaginator($page = 1) {

        $map = new Application_Model_DbMapper_DbMapper();

        return $map->fetchAllWhereColumnValueIsPaginator($this->_tableName, $this->_class, 'featured', 1, $page);
    }

    public function save($data) {

        $map = new Application_Model_DbMapper_DbMapper();

        return $map->save($data, $this->_tableName);
    }

    public function getRowById($id) {


        $map = new Application_Model_DbMapper_DbMapper();

        return $map->fetchRowById($id, $this->_tableName, $this);
    }

    public function delete($id) {

        $map = new Application_Model_DbMapper_DbMapper();

        return $map->delete($id, $this->_tableName);
    }

    public function saveImg($id, $new, $userid, $imgId = null) {


        $adapter = new Zend_File_Transfer_Adapter_Http();
        $file = $adapter->getFileInfo('file');
        $file2 = $adapter->getFileInfo('file2');


        $path = realpath(APPLICATION_PATH . '\\..\\Public') . '\\images\\settings\\' . $id . '\\';
        $path2 = realpath(APPLICATION_PATH . '\\..\\Public') . '\\images\\settings\\' . $id;

        $image = new Application_Model_Images_Data_Images();


        if (!is_dir($path2)) {
            mkdir($path2, 0755, true);
        }

        $adapter->setDestination($path);
        foreach ($file as $fieldname => $fileinfo) {
            if (($adapter->isUploaded($fileinfo['name'])) && ($adapter->isValid($fileinfo['name']))) {
                $data = array();

                $adapter->receive($fileinfo['name']);

                if ($new == true) {

                    $data['img'] = $fileinfo['name'];
                    $data['createdby'] = $userid;
                    $data['editedby'] = $userid;
                    $data['createdon'] = new Zend_Db_Expr('NOW()');
                    $data['editedon'] = new Zend_Db_Expr('NOW()');
                    $lastid = $image->save($data);

                    $this->save(array('id' => $id, 'webimg_id' => $lastid));

                    unset($data);
                } else {

                    $data['id'] = $imgId;
                    $data['img'] = $fieldname['name'];
                    $data['editedby'] = $userid;
                    $data['editedon'] = new Zend_Db_Expr('NOW()');
                    $lastid = $image->save($data);

                    unset($data);
                }
            }
        }

        foreach ($file2 as $fieldname => $fileinfo) {
            if (($adapter->isUploaded($fileinfo['name'])) && ($adapter->isValid($fileinfo['name']))) {
                $data = array();

                $adapter->receive($fileinfo['name']);

                if ($new == true) {

                    $data['img'] = $fileinfo['name'];
                    $data['createdby'] = $userid;
                    $data['editedby'] = $userid;
                    $data['createdon'] = new Zend_Db_Expr('NOW()');
                    $data['editedon'] = new Zend_Db_Expr('NOW()');
                    $lastid = $image->save($data);

                    $this->save(array('id' => $id, 'mailimg_id' => $lastid));

                    unset($data);
                } else {

                    $data['id'] = $imgId;
                    $data['img'] = $fieldname['name'];
                    $data['editedby'] = $userid;
                    $data['editedon'] = new Zend_Db_Expr('NOW()');
                    $lastid = $image->save($data);

                    unset($data);
                }
            }
        }

        return true;
    }

     public function getRowByLangId($id) {

        $map = new Application_Model_DbMapper_DbMapper();

        return $map->fetchAllByColumnName($this->_tableName, $this->_class, $id, 'lang');
    }

    public function deleteFolder($id) {

        $map = new Application_Model_DbMapper_DbMapper();

        $folderPath = realpath(APPLICATION_PATH . '\\..\\Public\\images\\settings\\' . $id . '\\');

        return $map->deleteAll($folderPath);
    }
    
     public function getRowByImageId($id, $columnName) {

        $map = new Application_Model_DbMapper_DbMapper();

        return $map->fetchAllByColumnName($this->_tableName, $this->_class, $id, $columnName);
    }

}


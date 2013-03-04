<?php

class Admin_SettingsController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout->setLayout('admin');

        $uri = $this->_request->getControllerName();
        $active = $this->view->navigation()->findBy('label', ucfirst($uri));
        if (!$active) {
            $uri = $this->_request->getActionName();
            $active = $this->view->navigation()->findBy('label', ucfirst($uri));
        }

        $active->active = true;

        $categories = new Application_Model_Categories_Data_Categories();
        $latestCategories = $categories->getLatest(5);
        $this->view->latestCategories = $latestCategories;

        $this->view->addScriptPath('/application/views/scripts');
        $this->view->render('sidebar.phtml');
    }

    public function indexAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->redirect('admin/index/login');
        }
    }

    public function generalAction() {

        $this->mergeQueryString();
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->redirect('admin/index/login');
        }

        $request = $this->getRequest();
        $requestParams = $this->getRequest()->getParams();


        if (isset($requestParams['language'])) {
            $langId = $requestParams['language'];
        }

        if (!$this->hasParam('language')) {
            $langId = 1;
        }

        $langForm = new Admin_Form_Language();
        $langForm->getElement('language')->setValue($langId);
        $form = new Admin_Form_Settings();

        $deleteForm = new Admin_Form_EditDelete(array('action' => '/admin/settings/deleteimage', 'method' => 'get', 'id' => 'delete', 'class' => 'delete', 'name' => 'delete', 'submitLabel' => 'Delete'));
        $settings = new Application_Model_Settings_Data_Settings();
        $settingsToContact = new Application_Model_SettingsToContact_Data_SettingsToContact();
        $contacts = new Application_Model_Contacts_Data_Contacts();
        $row = $settings->getRowByLangId($langId);



        if ($row) {
            $settingId = $row[0]->getId();
            $contact = $contacts->getAllContactsBySettingsId($settingId);
            $image = new Application_Model_Images_Data_Images();
            $imagePath = '/images/settings/' . $settingId . '/';
            $webImg = $image->getWebImageBySettingsId($settingId);
            $mailImg = $image->getMailImageBySettingsId($settingId);

            $form->getElement('title')->setValue((string) trim($row[0]->getTitle()));
            $form->getElement('language')->setValue((int) trim($row[0]->getLang()));
            if (isset($contact) && !empty($contact)) {
                $form->getElement('contacts')->setValue((int) trim($contact[0]->getId()));
            }
            $form->getElement('meta_description')->setValue((string) trim($row[0]->getMeta_desc()));
            $form->getElement('meta_keywords')->setValue((string) trim($row[0]->getMeta_keywords()));



            if ($request->isPost()) {
                if ($form->isValid($this->_request->getPost())) {


                    $data = array();


                    $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
                    $data['id'] = $settingId;
                    $data['title'] = trim($requestParams['title']);
                    $data['meta_desc'] = trim($requestParams['meta_description']);
                    $data['meta_keywords'] = trim($requestParams['meta_keywords']);
                    $data['editedby'] = $user;
                    $data['editedon'] = new Zend_Db_Expr('NOW()');


                    $settings->save($data);

                    if ($this->hasParam('contacts')) {
                        $settingsToContact->deleteSettToCont($settingId);

                        $data = array();

                        $data['settings_id'] = $settingId;
                        $data['contact_id'] = trim($requestParams['contacts']);
                        $data['createdby'] = $user;
                        $data['editedby'] = $user;
                        $data['createdon'] = new Zend_Db_Expr('NOW()');
                        $data['editedon'] = new Zend_Db_Expr('NOW()');


                        $settingsToContact->save($data);
                    }


                    $upload = new Zend_File_Transfer();
                    $files = $upload->getFileInfo();
                    $file = $files['file']['name'];
                    $file2 = $files['file2']['name'];

                    if (isset($file) && !empty($file)) {
                        if (isset($webImg) && !empty($webImg)) {
                            $image->delete($row[0]->getWebimg_id());
                            $image->unlinkImage($settingId, $webImg[0]->getImg(), 'settings');
                        }
                        $lastImgId = $settings->saveImg($settingId, true, $user);

                        $webImg = $image->getWebImageBySettingsId($settingId);
                    }

                    if (isset($file2) && !empty($file2)) {
                        if (isset($mailImg) && !empty($mailImg)) {
                            $image->delete($row[0]->getMailimg_id());
                            $image->unlinkImage($settingId, $mailImg[0]->getImg(), 'settings');
                        }
                        $lastImgId = $settings->saveImg($settingId, true, $user);

                        $mailImg = $image->getMailImageBySettingsId($settingId);
                    }
                    $successMessage = "Setting successfully edited.";
                    $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');
                    $this->redirect('admin/settings/general/language/' . $row[0]->getLang());
                }
            }
            $this->view->form = $form;
            $this->view->langForm = $langForm;
            $this->view->webImage = $webImg;
            $this->view->mailImage = $mailImg;
            $this->view->imagePath = $imagePath;
            $this->view->deleteForm = $deleteForm;
        } else {

            $form = new Admin_Form_Settings();
            $settings = new Application_Model_Settings_Data_Settings();
            $settingsToContact = new Application_Model_SettingsToContact_Data_SettingsToContact();

            $request = $this->getRequest();
            $requestParams = $this->getRequest()->getParams();


            if ($request->isPost()) {
                if ($form->isValid($this->_request->getPost())) {

                    $allByLang = $settings->getAllByLang(trim($requestParams['language']));

                    if (isset($allByLang) && !empty($allByLang)) {
                        $errorMessage = 'Setting for this language is already created.';
                        $this->view->errorMessage = $errorMessage;
                        $this->view->form = $form;
                        $this->view->langForm = $langForm;
                        return false;
                    }


                    $data = array();


                    $user = trim(Zend_Auth::getInstance()->getIdentity()->id);
                    $data['title'] = trim($requestParams['title']);
                    $data['meta_desc'] = trim($requestParams['meta_description']);
                    $data['meta_keywords'] = trim($requestParams['meta_keywords']);
                    $data['createdby'] = $user;
                    $data['editedby'] = $user;
                    $data['createdon'] = new Zend_Db_Expr('NOW()');
                    $data['editedon'] = new Zend_Db_Expr('NOW()');
                    $data['lang'] = trim($requestParams['language']);





                    $lastSettingId = $settings->save($data);
                    if ($this->hasParam('contacts')) {
                        $data = array();

                        $data['settings_id'] = $lastSettingId;
                        $data['contact_id'] = trim($requestParams['contacts']);
                        $data['createdby'] = $user;
                        $data['editedby'] = $user;
                        $data['createdon'] = new Zend_Db_Expr('NOW()');
                        $data['editedon'] = new Zend_Db_Expr('NOW()');


                        $settingsToContact->save($data);
                    }

                    $settings->saveImg($lastSettingId, true, $user);


                    $successMessage = "Setting successfully created.";
                    $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');
                    if (isset($requestParams['language']) && !empty($requestParams['language'])) {
                        $this->redirect('admin/settings/general/language/' . $requestParams['language']);
                    }
                    $this->redirect('admin/settings/general');
                }
            }
            $this->view->form = $form;
            $this->view->langForm = $langForm;
        }
    }

    public function contactAction() {
        
    }

    public function modulesAction() {
        
    }

    public function saveAction() {
        
    }

    public function usersAction() {
        
    }

    public function newAction() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->redirect('admin/index/login');
        }
    }

    public function editAction() {
        
    }

    public function deleteimageAction() {

        $this->mergeQueryString();
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->redirect('admin/index/login');
        }

        $request = $this->getRequest();
        $requestParams = $this->getRequest()->getParams();

        if (isset($requestParams['id'])) {
            $id = $requestParams['id'];
        }

        if (!$this->hasParam('id')) {
            $errorMessage = 'Invalid id parameter';
            $this->view->errorMessage = $errorMessage;
        } else {

            $form = new Admin_Form_Delete();
            $image = new Application_Model_Images_Data_Images();
            $row = $image->getRowById($id);

            if ($row) {

                $settings = new Application_Model_Settings_Data_Settings();

                $settingWeb = $settings->getRowByImageId($id, 'webimg_id');
                $settingMail = $settings->getRowByImageId($id, 'mailimg_id');

                if (isset($settingWeb) && !empty($settingWeb)) {
                    $imageId = $settingWeb[0]->getWebimg_id();
                }

                if (isset($settingMail) && !empty($settingMail)) {
                    $imageId = $settingMail[0]->getMailimg_id();
                }

                if (isset($imageId) && !empty($imageId)) {
                    if ($request->isPost()) {
                        if ($form->isValid($this->_request->getPost())) {

                            $del = $request->getParam('del');
                            if ($del == 'Yes') {



                                $image->delete($id);

                                if (isset($settingWeb) && !empty($settingWeb)) {
                                    $image->unlinkImage($settingWeb[0]->getId(), $row[0]->getImg(), 'settings');

                                    $settings->save(array('id' => $settingWeb[0]->getId(), 'webimg_id' => new Zend_Db_Expr('NULL')));

                                    $successMessage = "Image successfully deleted.";
                                    $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');

                                    $this->redirect('admin/settings/edit/id/' . $settingWeb[0]->getId());
                                }

                                if (isset($settingMail) && !empty($settingMail)) {
                                    $image->unlinkImage($settingMail[0]->getId(), $row[0]->getImg(), 'settings');

                                    $settings->save(array('id' => $settingMail[0]->getId(), 'mailimg_id' => new Zend_Db_Expr('NULL')));

                                    $successMessage = "Image successfully deleted.";
                                    $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');

                                    $this->redirect('admin/settings/edit/id/' . $settingMail[0]->getId());
                                }
                            } else {
                                if (isset($settingWeb) && !empty($settingWeb)) {
                                    $this->redirect('admin/settings/edit/id/' . $settingWeb[0]->getId());
                                }

                                if (isset($settingMail) && !empty($settingMail)) {
                                    $this->redirect('admin/settings/edit/id/' . $settingMail[0]->getId());
                                }
                            }
                        }
                    }

                    $this->view->form = $form;
                } else {
                    $errorMessage = 'This image is not linked to this category';
                    $this->view->errorMessage = $errorMessage;
                }
            } else {
                $errorMessage = 'Invalid id parameter';
                $this->view->errorMessage = $errorMessage;
            }
        }
    }

    public
            function deletesettingAction() {


        $this->mergeQueryString();
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->redirect('admin/index/login');
        }

        $request = $this->getRequest();
        $requestParams = $this->getRequest()->getParams();

        if (isset($requestParams['id'])) {
            $id = $requestParams['id'];
        }

        if (!$this->hasParam('id')) {
            $errorMessage = 'Invalid id parameter';
            $this->view->errorMessage = $errorMessage;
            return false;
        }

        $form = new Admin_Form_Delete();
        $settings = new Application_Model_Settings_Data_Settings();
        $row = $settings->getRowById($id);
        if (!isset($row) && empty($row)) {
            $errorMessage = 'Invalid id parameter';
            $this->view->errorMessage = $errorMessage;
            return false;
        }


        $image = new Application_Model_Images_Data_Images();

        $settToCont = new Application_Model_SettingsToContact_Data_SettingsToContact();

        $allSettToCont = $settToCont->getAllBySettingId($id);

        $webImgId = $row[0]->getWebimg_id();
        $mailImgId = $row[0]->getMailimg_id();

        $allImages = array();
        if (isset($webImgId) && !empty($webImgId)) {
            array_push($allImages, $webImgId);
        }
        if (isset($mailImgId) && !empty($mailImgId)) {
            array_push($allImages, $mailImgId);
        }


        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {

                $del = $request->getParam('del');
                if ($del == 'Yes') {

                    foreach ($allImages as $key) {

                        $image->delete($key);
                    }

                    foreach ($allSettToCont as $key) {

                        $settToCont->delete($key->getId());
                    }

                    $settings->delete($id);

                    $settings->deleteFolder($id);

                    $successMessage = "Setting successfully deleted.";

                    $this->_helper->FlashMessenger->addMessage($successMessage, 'actions');

                    $this->redirect('admin/settings/general');
                } else {
                    $this->redirect('admin/settings/general');
                }
            }
        }

        $this->view->form = $form;
    }

}


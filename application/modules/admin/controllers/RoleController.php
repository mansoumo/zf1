<?php
class Admin_RoleController extends Zend_Controller_Action
{

    public function listerAction()
    {
        $roleList = Application_Model_AppRole::getAllRoles();
        
        $this->view->rolesList = $roleList;
    }
    
    public function editerAction()
    {
        $roleId  = $this->_getParam('role_id', null);
        
        $roleForm  = new Application_Form_AppRole();
        $roleParentOptions = Application_Model_AppRole::getRoleParentsOptions($roleId);
        $roleForm->getElement('parent_id')->setMultiOptions($roleParentOptions);
        
        if ($roleId !== null) {
            try {
                $roleInstance  = Application_Model_AppRole::findByDbId($roleId);
                $values  = $roleInstance->getDbRow()->toArray();
                $roleForm->populate($values);
            } catch (Zend_Exception $e ) {
                $this->view->errorStatus = App_View_Helper_Alert::STATUS_ERROR;
                $this->view->errorMessage = $e->getMessage();
            }
        }
        
        if ($this->_request->isPost()) {
            $formIsValid  = $roleForm->isValid($this->_request->getPost());
        
            if ($formIsValid) {
                try {
                    $res = Application_Model_AppRole::save($roleForm, $roleId);
        
                    if (empty($res)) {
                        $this->view->saveStatus  = App_View_Helper_Alert::STATUS_WARNING;
                        $this->view->saveMessage  = 'role_save_ko';
                    } else {
                        $this->_helper->flashMessengerStatus->addMessageStatus(
                            'role_save_ok',
                            App_View_Helper_Alert::STATUS_SUCCESS
                        );
                        $this->_helper->redirector('lister', 'role', 'admin', array());
                    }
                } catch (Zend_Exception $e) {
                    $this->view->saveStatus = App_View_Helper_Alert::STATUS_ERROR;
                    $this->view->saveMessage = $e->getMessage();
                }
            }
        }
        
        $this->view->roleId = $roleId;
        $this->view->form = $roleForm;
    }
    
    public function supprimerAction()
    {
        $roleId  = $this->_getParam('role_id', null);
        
        try {
            $res  = Application_Model_AppRole::deleteById($roleId);
            if (empty($res)) {
                $messageStatus = App_View_Helper_Alert::STATUS_WARNING;
                $flashMessage  = 'role_delete_ko';
            } else {
                $messageStatus = App_View_Helper_Alert::STATUS_SUCCESS;
                $flashMessage = 'role_delete_ok';
            }
        } catch (Zend_Exception $e) {
            $flashMessage = $e->getMessage();
            $messageStatus = App_View_Helper_Alert::STATUS_ERROR;
        }
        
        $this->_helper->flashMessengerStatus($flashMessage, $messageStatus);
        $this->_helper->redirector('lister', 'role', 'admin', array());
    }
}

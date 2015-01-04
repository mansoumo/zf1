<?php
class Admin_ResourceController extends Zend_Controller_Action
{

    public function listerAction()
    {
        $resourceList = Application_Model_AppResource::getAllResources();
        
        $this->view->resourcesList = $resourceList;
    }
    
    public function editerAction()
    {
        $resourceId = $this->_getParam('resource_id', null);
        
        $resourceForm = new Application_Form_AppResource();
        
        if ($resourceId !== null) {
            try {
                $resourceInstance = Application_Model_AppResource::findByDbId($resourceId);
                $values  = $resourceInstance->getDbRow()->toArray();
                $resourceForm->populate($values);
            } catch (Zend_Exception $e ) {
                $this->view->errorStatus = App_View_Helper_Alert::STATUS_ERROR;
                $this->view->errorMessage = $e->getMessage();
            }
        }
        
        if ($this->_request->isPost()) {
            $formIsValid  = $resourceForm->isValid($this->_request->getPost());
        
            if ($formIsValid) {
                try {
                    $res = Application_Model_AppResource::save($resourceForm, $resourceId);
        
                    if (empty($res)) {
                        $this->view->saveStatus  = App_View_Helper_Alert::STATUS_WARNING;
                        $this->view->saveMessage  = 'resource_save_ko';
                    } else {
                        $this->_helper->flashMessengerStatus->addMessageStatus(
                            'resource_save_ok',
                            App_View_Helper_Alert::STATUS_SUCCESS
                        );
                        $this->_helper->redirector('lister', 'resource', 'admin', array());
                    }
                } catch (Zend_Exception $e) {
                    $this->view->saveStatus = App_View_Helper_Alert::STATUS_ERROR;
                    $this->view->saveMessage = $e->getMessage();
                }
            }
        }
        
        $this->view->resourceId = $resourceId;
        $this->view->form = $resourceForm;
    }
    
    public function supprimerAction()
    {
        $resourceId = $this->_getParam('resource_id', null);
        
        try {
            $res  = Application_Model_AppResource::deleteById($resourceId);
            if (empty($res)) {
                $messageStatus = App_View_Helper_Alert::STATUS_WARNING;
                $flashMessage  = 'resource_delete_ko';
            } else {
                $messageStatus = App_View_Helper_Alert::STATUS_SUCCESS;
                $flashMessage = 'resource_delete_ok';
            }
        } catch (Zend_Exception $e) {
            $flashMessage = $e->getMessage();
            $messageStatus = App_View_Helper_Alert::STATUS_ERROR;
        }
        
        $this->_helper->flashMessengerStatus($flashMessage, $messageStatus);
        $this->_helper->redirector('lister', 'resource', 'admin', array());
    }
}

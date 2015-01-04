<?php
class User_ProfileController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $userDbId  = Zend_Auth::getInstance()->getIdentity()->db_row_id;
        
        try {
            $userInstance  = Application_Model_User::findByDbId($userDbId);
            $this->view->userRow = $userInstance->getDbRow();
        } catch (Zend_Exception $e) {
            $this->view->error = $e->getMessage();
        }
    }
    
    public function updatePasswordAction()
    {
        $userPasswordForm  = new Application_Form_UserPassword();
        
        if ($this->_request->isPost()) {
            $formIsValid  = $userPasswordForm->isValid($this->_request->getPost());
        
            if ($formIsValid) {
                $login  = Zend_Auth::getInstance()->getIdentity()->login;
                $password  = $userPasswordForm->getValue('password2');
                try {
                    $res  = Application_Model_User::updatePassword($login, $password);
                    
                    if(empty($res)) {
                        $this->view->updatePasswordStatus  = App_View_Helper_Alert::STATUS_WARNING;
                        $this->view->updatePasswordMessage  = 'user_update_password_ko';
                    } else {
                        $this->view->updatePasswordStatus = App_View_Helper_Alert::STATUS_SUCCESS;
                        $this->view->updatePasswordMessage  = 'user_update_password_ok';
                    }
                } catch (Zend_Exception $e) {
                    $this->view->updatePasswordStatus  = App_View_Helper_Alert::STATUS_DANGER;
                    $this->view->updatePasswordStatus  = $e->getMessage();
                }
            }
        }
        
        $this->view->form = $userPasswordForm;
    }
}

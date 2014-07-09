<?php

class User_AuthController extends Zend_Controller_Action
{

    public function init()
    {
    }
    
    public function preDispatch()
    {
        $this->_helper->layout->setLayout('auth');
    }
    
    public function loginAction()
    {
        $form = new Application_Form_UserLogin();
        
        if ($this->_request->isPost()) {
            $formIsValid  = $form->isValid($this->_request->getPost());
            
            if ($formIsValid) {
                
                $auth  = Zend_Auth::getInstance();
                
                $authAdapterDbTable  = new App_Auth_Adapter_DbTable();
                $authAdapterDbTable
                ->setLogin($form->getValue('username'))
                ->setPassword($form->getValue('password'));
                
                $authResult  = $auth->authenticate($authAdapterDbTable);
                
                if ($authResult->isValid()) {
                    // @todo paramétrage dans application.ini
                    $this->_helper->redirector('index', 'index', 'default');
                } else {
                    $this->view->authResultMessages = $authResult->getMessages();
                }
            }
        }
        $this->view->userLoginForm = $form;
    }
    
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('login', 'auth', 'user');
    }
    
    public function registerAction()
    {
    }
}

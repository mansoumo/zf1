<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $countryList  = Application_Model_Country::getList();
        
        App_Application::firePhpDebug('toto');
    }

    public function postDispatch()
    {
        
    }
}

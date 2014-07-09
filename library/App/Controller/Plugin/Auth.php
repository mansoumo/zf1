<?php
/**
 * Mourad MANSOUR
 *
 *
 * @category   App
 * @package    App_Controller
 * @subpackage Plugins
 * @version    $Id$
 *
 * @since      2014 June
 */


/**
 * @uses       Zend_Controller_Plugin_Abstract
 * @category   App
 * @package    App_Controller
 * @subpackage Plugins
 */

class App_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $auth = Zend_Auth::getInstance();
        $front  = Zend_Controller_Front::getInstance();
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        
        $authModule  = $front->getParam('authModule');
        $authController  = $front->getParam('authController');
        $authAction  = $front->getParam('authAction');
        
        if (
            !$auth->hasIdentity() &&
            (
                $request->getControllerName() != $authController &&
                $request->getModuleName() != $authModule
            )
        ) {
            $redirector->gotoSimple($authAction, $authController, $authModule);
        }
    }
}

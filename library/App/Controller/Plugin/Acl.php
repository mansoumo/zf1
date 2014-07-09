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
 * @since      2014 July
 */


/**
 * @uses       Zend_Controller_Plugin_Abstract
 * @category   App
 * @package    App_Controller
 * @subpackage Plugins
 */

class App_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $auth = Zend_Auth::getInstance();
        $identityRoleId = App_Acl::getIdentityRoleId();
        $cacheManager = App_Application::getInstance()->getResource('cachemanager');
        $acl = false ;
        
        if ($cacheManager !== null) {
            $cacheAcl = $cacheManager->getCache('acl');
            if ( $cacheAcl instanceof Zend_Cache_Core) {
                $acl = $cacheAcl->load('ACL_'.$identityRoleId);
            }
        }
        
        if ($acl === false) {
            $acl = new App_Acl();
        }
        
        if ($cacheManager !== null && $cacheAcl instanceof Zend_Cache_Core) {
            $cacheAcl->save($acl, 'ACL_'.$identityRoleId);
        }
        
        $module  = $request->getModuleName();
        $controller  = $request->getControllerName();
        $action  = $request->getActionName();
        
        $mvcSep = App_Acl::MVC_SEP;
        
        $resources = array (
            '*'.$mvcSep.'*'.$mvcSep.'*',
            $module.$mvcSep.'*',
            $module.$mvcSep.$controller.$mvcSep.'*',
            $module.$mvcSep.$controller.$mvcSep.$action
        );
        
        $allowed = false;
        
        foreach ($resources as $resource) {
            if ($acl->has($resource)) {
                $allowed = $acl->isAllowed($acl->getRoleId(), $resource);
            }
        }
        
        if ( ! $allowed && ! $auth->hasIdentity()) {
            $front  = Zend_Controller_Front::getInstance();
            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            
            $authModule  = $front->getParam('authModule');
            $authController  = $front->getParam('authController');
            $authAction  = $front->getParam('authAction');
            
            $redirector->gotoSimple($authAction, $authController, $authModule);
        }
        
        if ( ! $allowed &&  $auth->hasIdentity()) {
            $request->setModuleName('default');
            $request->setControllerName('error');
            $request->setActionName('no-right');
        }
    }
}

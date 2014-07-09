<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    }
    
    public function postDispatch()
    {
    }
    
    public function indexAction()
    {
//         $acl = new App_Acl();
        
//         $module  = $this->_getParam('module');
//         $controller  = $this->_getParam('controller');
//         $action  = $this->_getParam('action');
        
//         $resources= array (
//             '*/*/*',
//             $module.'/*/*',
//             $module.'/'.$controller.'/*',
//             $module.'/'.$controller.'/'.$action
//         );
        
//         $result = false;
        
//         foreach ($resources as $res) {
//             if ($acl->has($res)) {
//                 $result= $acl->isAllowed($acl->getRoleId(), $res);
//             }
//         }
        
//         Zend_Debug::dump($result);
        
//         Zend_Debug::dump(Zend_Auth::getInstance()->getIdentity());
        
    }

    public function action1Action()
    {
        die('action1');
    }
    
    public function action2Action()
    {
        die('action2');    
        
    }

    public function action3Action()
    {
        die('action 3');
    }
    
    public function action4Action()
    {
        die('action 4');        
    }
    
    public function testAction()
    {
        
        die('action test');
    }
}

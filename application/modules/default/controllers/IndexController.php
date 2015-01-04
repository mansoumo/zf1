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
//         $id  = 1;
        
//         $idCrypted  = App_Crypt::encrypt($id);
//         Zend_Debug::dump($idCrypted);
        
//         Zend_Debug::dump(App_Crypt::decrypt($idCrypted));
        
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
        $this->_request->setPost(array('p1'=>'val1'));
        $this->forward('action2');        
    }
    
    public function action2Action()
    {
        var_dump($_POST); die();
        
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

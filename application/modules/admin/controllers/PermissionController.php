<?php
class Admin_PermissionController extends Zend_Controller_Action
{

    public function settingAction()
    {
        $roleList = Application_Model_AppRole::getAllRoles();
        $resourcesList = Application_Model_AppResource::getAllResources();
        
        $this->view->rolesList = $roleList;
        $this->view->resourcesList = $resourcesList;
    }    
}

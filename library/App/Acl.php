<?php
/**
 * Mourad MANSOUR
 *
 *
 * @category   App
 * @package    App_Acl
 * @version    $Id$
 *
 * @since      2014 july
 */

/**
 * @category   App
 * @package    App_Acl
 *
 * @see        Zend_Acl
 */

class App_Acl extends Zend_Acl
{
    const MVC_SEP = '/';
    
    protected $_roleId = null;
    
    protected $_resourcePermissions = null;
    
    public function __construct()
    {
        $this->_initAuthRoleId();
        $this->_addRoles();
        $this->_addResources();
        $this->_addPermissions();
    }
    
    public function getRoleId()
    {
        return $this->_roleId;
    }
    
    public static function getIdentityRoleId()
    {
        $auth  = Zend_Auth::getInstance();
        
        if (null === $auth ||
            false === $auth->hasIdentity()
        ) {
            return Application_Model_AppRole::GUEST_ID;
        } else {
            return $auth->getIdentity()->role_id;
        }
        
    }
    
    protected function _initAuthRoleId()
    {
        $this->_roleId = self::getIdentityRoleId();
        return $this->_roleId;
    }
    
    protected function _addRoles()
    {
        $roleRows  = Application_Model_AppRole::getAllRoles();
        
        if ( ! is_array($roleRows) || 0 === count($roleRows) ) {
            return false;
        }
        
        foreach ($roleRows as $roleRow) {
            if ( empty($roleRow['parent_id'])) {
                $this->addRole($roleRow['id']);
            } else {
                $this->addRole($roleRow['id'], $roleRow['parent_id']);
            }
        }
        return true;
    }
    
    protected function _addResources()
    {
        $resourcesList  = $this->_getResourcePermissions();
        
        if (is_array($resourcesList) && count($resourcesList)) {
            foreach ($resourcesList as $resourceRow) {
                $resourceMvc = self::_getResourceMvc($resourceRow);
                if (!$this->has($resourceMvc)) {
                    $this->addResource(new Zend_Acl_Resource($resourceMvc));
                }
            }
        }
    }
    
    protected function _addPermissions()
    {
        $resourcesList  = $this->_getResourcePermissions();
        
        if (is_array($resourcesList) && count($resourcesList)) {
            foreach ($resourcesList as $resourceRow) {
                $resourceMvc = self::_getResourceMvc($resourceRow);
                
                if ($resourceRow['permission'] == Application_Model_AppPermission::ALLOW) {
                    $this->allow($resourceRow['role_id'], $resourceMvc);
                } else {
                    $this->deny($resourceRow['role_id'], $resourceMvc);
                }
            }
        }
    }
    
    protected function _getResourcePermissions()
    {
        if ($this->_resourcePermissions === null) {
            $roleIds  = array();
            
            $roleIds = $this->getRoleParents();
            
            if ($this->_roleId !== null) {
                $roleIds[$this->_roleId] = $this->_roleId;
            }
                        
            $this->_resourcePermissions  = Application_Model_AppResource::getListByRoleIds($roleIds);
        }
        return $this->_resourcePermissions;
    }
    
    protected static function _getResourceMvc($resourcePermissionRow)
    {
        $module  = $resourcePermissionRow['module'];
        $controller  = $resourcePermissionRow['controller'];
        $action  = $resourcePermissionRow['action'];
        
        return $module.self::MVC_SEP.$controller.self::MVC_SEP.$action;
    }
    
    public function getRoleParents()
    {
        $parents = array();
        
        if ( $this->_roleId === null ) {
            return $parents;
        }
        
        $allRoles  = $this->getRoles();
        
        foreach ($allRoles as $inherit) {
            if ($this->inheritsRole($this->_roleId, $inherit)) {
                $parents[$inherit] = $inherit;
            }
        }
        return $parents;
    }
}

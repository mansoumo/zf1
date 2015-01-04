<?php
class Application_Model_AppRole extends Application_Model_Abstract
{
    const GUEST_ID = 1;
    const USER_ID = 2;
    const ADMIN_ID = 3;

    protected $_dbRowId = null;
    
    protected $_dbRow = null;
    
    public function __construct($roleDbId = null)
    {
        $this->_dbRowId = $roleDbId;
    }
    
    public function getDbRowId()
    {
        return $this->_dbRowId;
    }
    
    /**
     * 
     * @return Zend_Db_Table_Row_Abstract
     */
    public function getDbRow()
    {
        return $this->_dbRow;
    }
    
    /**
     *
     * @param    int  $roleDbId
     * @throws   Zend_Exception
     * @return   Application_Model_Role
     */
    public static function findByDbId($roleDbId)
    {
        $roleInstance  = new self($roleDbId);
        $modelTable  = new Application_Model_Table_AppRoles();
        $roleInstance->_dbRow = $modelTable->findRowById($roleDbId);
        if ($roleInstance->_dbRow === null) {
            throw new Zend_Exception(
                'role_error_database_not_found',
                self:: DB_ERROR_ROW_NOT_FOUND
            );
        }
        return $roleInstance;
    }
    
    /**
     * 
     * @param Application_Form_AppRole $form
     * @param int $roleId
     * @return int
     */
    public static function save(Application_Form_AppRole $form, $roleId = null)
    {
        $modelTable  = new Application_Model_Table_AppRoles();
        $data  = array();
        $data['role'] = $form->getValue('role');
        $data['parent_id'] = $form->getValue('parent_id');
        
        if ($data['parent_id'] === self::FORM_SELECT_OPTION_NULL) {
            $data['parent_id'] = null;
        }
        
        try {
            if ($roleId === null) {
                $rowId  = $modelTable->insert($data);
            } else {
                $modelTable->updateByRoleId($data, $roleId);
                $rowId = $roleId;
            }            
        } catch (Zend_Exception $e ) {
            $code  = $e->getCode();
            switch ($code) {
            	case 23000:
            	    $message = 'role_already_exists';
            	    break;
            	default:
            	    $message = $e->getMessage();
            }
            throw new Zend_Exception($message, $e->getCode());
        }       
        return $rowId;
    }
    
    public static function deleteById($roleDbId)
    {        
        $modelTable  = new Application_Model_Table_AppRoles();
        $res  = false;
        $rowDb  = $modelTable->findRowById($roleDbId);
        
        if (false === $rowDb instanceof Zend_Db_Table_Row) {
            return $res;
        }
        
        if( $rowDb->locked) {
            throw new Zend_Exception('role_delete_impossible_locked');
        }
        
        try {
            $res  = $modelTable->deleteById($roleDbId);
        } catch (Zend_Exception $e ) {
            $code  = $e->getCode();
            switch ($code) {
            	case 23000:
            	    $message = 'role_delete_impossible_ref_intergrity';
            	    break;
            	default:
            	    $message = $e->getMessage();
            }
            throw new Zend_Exception($message, $e->getCode()); 
        }
        return $res;
    }
    
    public static function getAllRoles()
    {
        $modelTable  = new Application_Model_Table_AppRoles();
        return $modelTable->getAll();
    }
    
    public static function getRoleParentsOptions($excludeRoleId = null)
    {
        $modelTable = new Application_Model_Table_AppRoles();
        
        $criteres  = array();
        if ($excludeRoleId !== null) {
            $criteres  = array('exclude' => $excludeRoleId);
        }
        
        $rolePairs = $modelTable->fetchPairs($criteres);
        $nullOption = self::getNullOption();
        return $nullOption + $rolePairs;
    }
    
    public static function basicList()
    {
        return array(
            self::GUEST_ID,
            self::USER_ID,
            self::ADMIN_ID
        );
    }
    
    public static function isGuest($roleId)
    {
        return ($roleId === self::GUEST_ID);
    }
    
    public static function isUser($roleId)
    {
        return ($roleId === self::USER_ID);
    }
    
    public static function isAdmin($roleId)
    {
        return ($roleId === self::ADMIN_ID);
    }
}

<?php
class Application_Model_AppResource extends Application_Model_Abstract
{
    /**
     * 
     * @var int
     */
    protected $_dbRowId = null;
    
    /**
     * 
     * @var Zend_Db_Table_Row_Abstract
     */
    protected $_dbRow = null;

    public function __construct($resourceDbId = null)
    {
        $this->_dbRowId = $resourceDbId;
    }
    
    /**
     * 
     * @return int
     */
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
            
    public static function getAllResources()
    {
        $modelTable  = new Application_Model_Table_AppResources();
        return $modelTable->getAll();
    }
    
    public static function findByDbId($resourceDbId)
    {
        $resourceInstance  = new self($resourceDbId);
        $modelTable  = new Application_Model_Table_AppResources();
        $resourceInstance->_dbRow = $modelTable->findRowById($resourceDbId);
        if ($resourceInstance->_dbRow === null) {
            throw new Zend_Exception(
                'resource_error_database_not_found',
                self:: DB_ERROR_ROW_NOT_FOUND
            );
        }
        return $resourceInstance;
    }
    
    public static function save(Application_Form_AppResource $form, $resourceId = null)
    {
        $modelTable  = new Application_Model_Table_AppResources();
        
        $data  = array();
        $data['module'] = $form->getValue('module');
        $data['controller'] = $form->getValue('controller');
        $data['action'] = $form->getValue('action');
        $data['description'] = $form->getValue('description');
    
    
        try {
            if ($resourceId === null) {
                $rowId  = $modelTable->insert($data);
            } else {
                $modelTable->updateByResourceId($data, $resourceId);
                $rowId = $resourceId;
            }
        } catch (Zend_Exception $e ) {
            $code  = $e->getCode();
            switch ($code) {
                case 23000:
                    $message = 'resource_already_exists';
                    break;
                default:
                    $message = $e->getMessage();
            }
            throw new Zend_Exception($message, $e->getCode());
        }
        return $rowId;
    }
    
    public static function deleteById($resourceDbId)
    {
        $modelTable  = new Application_Model_Table_AppResources();
        $res  = false;
    
        try {
            $res  = $modelTable->deleteById($resourceDbId);
        } catch (Zend_Exception $e ) {
            $code  = $e->getCode();
            switch ($code) {
                case 23000:
                    $message = 'resource_delete_impossible_ref_intergrity';
                    break;
                default:
                    $message = $e->getMessage();
            }
            throw new Zend_Exception($message, $e->getCode());
        }
        return $res;
    }
    
    public static function getListByRoleIds(array $roleIds)
    {
        $modelTable  = new Application_Model_Table_AppResources();
        $criteres['role_ids']  =  $roleIds;
    
        return $modelTable->getList($criteres);
    }
}

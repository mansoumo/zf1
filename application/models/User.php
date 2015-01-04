<?php
class Application_Model_User extends Application_Model_Abstract
{
    const ERROR_DATABASE_NOT_FOUND = -1;
    
    protected $_dbRowId = null;
    
    protected $_dbRow = null;
    
    public function __construct($userDbId = null)
    {
        $this->_dbRowId = $userDbId;
    }
    
    public function getDbRowId()
    {
        return $this->_dbRowId;
    }
    
    public function getDbRow()
    {
        return $this->_dbRow;
    }
    
    public static function findByMail($userMail)
    {
        $userInstance  = new self();
    }
    
    /**
     * 
     * @param    int  $userDbId
     * @throws   Zend_Exception
     * @return   Application_Model_User
     */
    public static function findByDbId($userDbId)
    {
        $userInstance  = new self($userDbId);
        $modelTable  = new Application_Model_Table_AppUsers();
        $userInstance->_dbRow = $modelTable->findRowById($userDbId);
        if($userInstance->_dbRow === null) {
            throw new Zend_Exception(
                'user_error_database_not_found',
                self::DB_ERROR_ROW_NOT_FOUND
            );
        }
        return $userInstance;
    }
    
    public static function generateSalt($saltLength = 16)
    {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $characterListLength = strlen($characterList) - 1;
        
        $salt = "";
        for ($i = 0; $i < $saltLength; $i++ ) {
            $rand  = mt_rand(0,$characterListLength);            
            $salt .= $characterList{$rand};            
        }
        return $salt;
    }
    
    public static function updatePassword($login, $password)
    {
        $userModelTable = new Application_Model_Table_AppUsers();
        $salt  = self::generateSalt();
                
        return $userModelTable->updatePassword($login, $password, $salt);
    }
}
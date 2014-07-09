<?php
/**
 * Mourad MANSOUR
 *
 *
 * @category   App
 * @package    App_Auth
 * @subpackage Adapter
 * @version    $Id$
 *
 * @since      2014 June
 */


/**
 * @category   App
 * @package    App_Auth
 * @subpackage Adapter
 */

class App_Auth_Adapter_DbTable implements Zend_Auth_Adapter_Interface
{
    protected $_login = null;

    protected $_password = null;
    
    /**
     * 
     * @var stdClass | NULL
     */
    protected $_userIdentity = null;
    
    public function authenticate()
    {
        $appUserModelDbTable = new Application_Model_Table_AppUsers();
        $dbTableRow = $appUserModelDbTable->findByCredentials($this->_login, $this->_password);
        
        if ($dbTableRow === null) {
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
                $this->_login,
                array('user_invalid_credentials')
            );
        }
        
        $active  = (int) $dbTableRow->active;
        
        if ($active === 0) {
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE,
                $this->_login,
                array('user_inactive_account')
            );
        }
        
        // Authentification is OK
        $this->_setUserIdentity($dbTableRow);
        
        return new Zend_Auth_Result(
            Zend_Auth_Result::SUCCESS,
            $this->getUserIdentity(),
            array('user_connection_successful')
        );
    }
    
    /**
     * 
     * @param string $login
     * @return App_Auth_Adapter_DbTable
     */
    public function setLogin($login)
    {
        $this->_login = $login;
        return $this;
    }
    
    /**
     * 
     * @param    string $password
     * @return   App_Auth_Adapter_DbTable
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }
    
    /**
     * @return stdClass | null
     */
    public function getUserIdentity()
    {
        return $this->_userIdentity;
    }
    
    protected function _setUserIdentity($userDbTableRow)
    {
        if (! $userDbTableRow instanceof  Zend_Db_Table_Row_Abstract) {
            return $this->_userIdentity;
        }
        
        $this->_userIdentity = new stdClass();
        foreach ($userDbTableRow as $resultColumn => $resultValue) {
            $this->_userIdentity->{$resultColumn} = $resultValue;
        }
        
        return $this->_userIdentity;
    }
}

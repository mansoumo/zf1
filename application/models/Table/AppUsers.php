<?php
class Application_Model_Table_AppUsers extends Application_Model_Table_Abstract
{
    protected $_name = 'app_users';
    
    protected $_primary = 'id';
    
    protected $_sequence = true;

    /**
     * 
     * @param     string $login
     * @param     string $password
     * @return    Zend_Db_Table_Row_Abstract | NULL
     */
    public function findByCredentials($login, $password)
    {
        $select  = $this->select();
        $select->setIntegrityCheck(false);
        
        $select->from(
            array('u' => $this->_name),
            array(
                'db_row_id' => 'id',
                'familly_name',
                'first_name',
                'email',
                'language_code',
                'login',
                'active',
                'role_id'
            )
        )
        ->joinLeft(
            array('r' => 'app_roles'),
            'r.id = u.role_id',
            array(
                'role_libelle' => 'role'
            )
        )
        ->where(' ( login = ?  OR email = ? )', $login)
        ->where(' password = MD5(CONCAT(salt, ?)) ', $password);
        
        return $this->fetchRow($select);
    }
    
    public function updatePassword($login, $password, $salt)
    {
        $data['salt']  = $salt;
        $passwordValue  = $this->_db->quoteinto("MD5(CONCAT(?))", array($salt, $password));
        $data['password']  = new Zend_Db_Expr($passwordValue);
        
        $where = $this->_db->quoteInto('login = ?', $login);
        
        return $this->update($data, $where);
    }
    
    public function findRowById($userDbId)
    {
        return $this->findRowByColumn(
            'id',
            $userDbId,
            array(
                'id',
                'familly_name',
                'first_name',
                'email',
                'language_code',
                'login'
            )
        );
    }
}

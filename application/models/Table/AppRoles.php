<?php
class Application_Model_Table_AppRoles extends Application_Model_Table_Abstract
{
    protected $_name = 'app_roles';
    
    protected $_primary = 'id';
    
    protected $_sequence = true;
    
    /**
     * 
     * @return array of array{id, role, parent_id, role_parent}
     */
    public function getAll()
    {
        $select  = $this->select();
        
        $select->from(
            array('r' => $this->_name),
            array(
                'id',
                'role',
                'parent_id'
            )
        )
        ->joinLeft(
            array('rp' => $this->_name),
            'rp.id = r.parent_id',
            array(
                'role_parent' => 'role'
            )
        );
        return $this->_db->fetchAll($select);
    }
    
    public function fetchPairs($criteres = array())
    {
        $select = $this->select();
        
        $select->from(
            array('ar' => $this->_name),
            array(
                'key' => 'ar.id',
                'value' => "ar.role"
            )
        );
        
        if (array_key_exists('exclude', $criteres)) {            
            $select->where('ar.id not in (?)', $criteres['exclude']);
        }
        
        $select->order('ar.id');
        return $this->_db->fetchPairs($select);        
    }
    
    public function updateByRoleId($data, $roleId)
    {
        $where  = $this->_db->quoteInto('id  = ?', $roleId);
        return $this->update($data, $where);
    }
    
    public function deleteById($roleId)
    {
        $where  = $this->_db->quoteInto('id  = ?', $roleId);
        return $this->delete($where);        
    }
    
    public function findRowById($roleDbId)
    {
        return $this->findRowByColumn(
            'id',
            $roleDbId,
            array(
                'id',
                'role',
                'parent_id',
                'locked'
            )
        );
    }    
}

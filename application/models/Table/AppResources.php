<?php
class Application_Model_Table_AppResources extends Application_Model_Table_Abstract
{
    protected $_name = 'app_resources';
    
    protected $_primary = 'id';
    
    protected $_sequence = true;
    
    public function getAll()
    {
        $select  = $this->select();
        
        $select->from(
            array('r' => $this->_name),
            array(
                'id',
                'module',
                'controller',
                'action',
                'description'
            )
        );
        
        return $this->_db->fetchAll($select);
    }
    
    public function findRowById($resourceId)
    {
        return $this->findRowByColumn(
            'id',
            $resourceId,
            array(
                'id',
                'module',
                'controller',
                'action',
                'description'
            )
        );
    }
    
    public function updateByResourceId($data, $resourceId)
    {
        $where  = $this->_db->quoteInto('id  = ?', $resourceId);
        return $this->update($data, $where);
    }
    
    public function deleteById($resourceId)
    {
        $where  = $this->_db->quoteInto('id  = ?', $resourceId);
        return $this->delete($where);
    }
    
    public function getList(array $criteres)
    {
        $select  = $this->getAdapter()->select();
    
        $select->from(
            array('r' => $this->_name),
            array(
                'module',
                'controller',
                'action'
            )
        )
        ->join(
            array('p' => 'app_permissions'),
            'p.resource_id = r.id',
            array(
                'role_id',
                'resource_id',
                'permission'
            )
        );
    
        if (array_key_exists('role_ids', $criteres) &&
            is_array($criteres['role_ids']) &&
            count($criteres['role_ids'])
        ) {
            $select->where('p.role_id in (?)', $criteres['role_ids']);
        }
    
        return $this->_db->fetchAll($select);
    }
}

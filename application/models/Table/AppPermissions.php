<?php
class Application_Model_Table_AppPermissions extends Application_Model_Table_Abstract
{
    protected $_name = 'app_permissions';
    
    protected $_primary = 'id';
    
    protected $_sequence = true;
    
    public function getAll()
    {
        $select  = $this->select();
    
        $select->from(
            array('r' => $this->_name),
            array(
                'id',
                'rele_id',
                'resource_id',
                'permission'
            )
        );
        
        return $this->_db->fetchAll($select);
    }
}

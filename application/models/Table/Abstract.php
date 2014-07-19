<?php
class Application_Model_Table_Abstract extends Zend_Db_Table
{
    public function findRowByColumn($columnName, $value, $cols = null)
    {
        $select  = $this->select()->where($columnName.' = ? ', $value);

        if ( $cols !== null) {
            $select->from($this->_name);
            $select->columns($cols);
        }
        
        return $this->fetchRow($select);
    }
}

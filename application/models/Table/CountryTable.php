<?php
class Application_Model_Table_CountryTable extends Zend_Db_Table
{
    protected $_name = 'country';
    
    protected $_primary = 'Code';
    
    protected $_sequence = false;
    
    /**
     * 
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getList($cols = null)
    {
        $select  = $this->select();
        
        $select->setIntegrityCheck(false);
        
        if ($cols === null) {
            $cols  = $this->_getCols();
        }
        
        $select->from(
            array('c' => $this->_name ),
            $cols
        );
        
        return $this->fetchAll($select);
    }
    
    /**
     * 
     * @param    string $countryCode
     * @param    array $cols
     * @return   Zend_Db_Table_Row_Abstract | NULL
     */
    public function findByPrimary($countryCode, $cols = null)
    {
        $select  = $this->select();
        
        if ($cols === null) {
            $cols  = $this->_getCols();
        }
        
        $select->from(
            array('c' => $this->_name ),
            $cols
        );
                
        $select->where('c.Code = ?', $countryCode);
        
        return $this->fetchRow($select);
    }
}

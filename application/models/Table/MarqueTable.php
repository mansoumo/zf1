<?php
class Application_Model_Table_MarqueTable extends Zend_Db_Table
{
    protected $_name= 'marques';
    
    protected $_primary = 'id';
    
    protected $_sequence = true;
    
    public function getOptionList()
    {
        $select  = $this->select();
    
        $select->setIntegrityCheck(false);
        $select->from( 
            $this->_name,            
            array(
                'key' => 'id',
                'value' => new Zend_Db_Expr("CONCAT(libelle, ' : ', pays )"),
            )            
        );    
        return $this->_db->fetchPairs($select);
    }
}
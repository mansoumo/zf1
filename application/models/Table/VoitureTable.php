<?php
class Application_Model_Table_VoitureTable extends Zend_Db_Table
{
    protected $_name= 'voitures';
    
    protected $_primary = 'id';
    
    protected $_sequence = true;
    
    
    public function getListSelectDb()
    {
        $select  = $this->select();
        
        $select->setIntegrityCheck(false);
        $select->from( array('v'=>$this->_name ));
        
        $marqueCols = array('marque'=>'libelle');
        
        $select->join(
            array('m' => 'marques'),
            'v.marque_id = m.id',
            $marqueCols
        );
        
        return $select;
        
    }
    public function getList()
    {
        /**
         * Avant
         */
//         return $this->fetchAll()->toArray();
        
        /**
		 * Après
         */
        $select  = $this->select();
        
        $select->setIntegrityCheck(false);
        $select->from( array('v'=>$this->_name ));
        
        $marqueCols = array('marque'=>'libelle');
        
        $select->join(
            array('m' => 'marques'),
            'v.marque_id = m.id',
            $marqueCols
       );        

//         $select->limit(7, 0);
        
//        Zend_Debug::dump($select->assemble()); die(); 
//                 
        return $this->fetchAll($select)->toArray();
        
//         $sql  =
//         "
//             	select
//             		v.*,
//             		m.libelle as marque
//             	from
//             		voitures v
//             	inner join
//             		marques m on (m.id = v.marque_id)
//             ";
        
            
// //         $db  = Zend_Db_Table::getDefaultAdapter();
//         $db = $this->_db ;
        
//         return $db->fetchAll($sql);
    }
    
    
    public function findRecordById($voitureId)
    {
        $select  = $this->select();
        
        $select->setIntegrityCheck(false);
        $select->from( array('v'=>$this->_name ));
        
        $marqueCols = array('marque'=>'libelle');
        
        $select->join(
            array('m' => 'marques'),
            'v.marque_id = m.id',
            $marqueCols
        );
        
        $select->where('v.id = ?', $voitureId);
        
        return $this->fetchRow($select);
        
        // Une seule table
//         $rows = $this->find($voitureId);
//         return $rows->current();        
    }
    
}
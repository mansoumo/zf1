<?php
class Application_Model_Voiture
{
    public static function getList()
    {
        $db  = Zend_Db_Table::getDefaultAdapter();
        
        $sql  =
        "
            	select
            		v.*,
            		m.libelle as marque
            	from
            		voitures v
            	inner join
            		marques m on (m.id = v.marque_id)
            ";
        
        return  $db->fetchAll($sql);
        
    }
    
    /**
     * 
     * @return array
     */
    public static function getTableList()
    {
        /**
 		 * commentaire	
         */
        
        $modelTable  = new Application_Model_Table_VoitureTable();

        return $modelTable->getList();
    }

    public static function getListSelectDb()
    {
    
        $modelTable  = new Application_Model_Table_VoitureTable();
    
        return $modelTable->getListSelectDb();
    }
    
    public static function findById($voitureId)
    {
        $modelTable = new Application_Model_Table_VoitureTable();
        
        $dbRow  = $modelTable->findRecordById($voitureId);        
        return $dbRow;
        
//         Zend_Debug::dump($dbRow); die();
        
//         $obj = new stdClass();
//         $obj->marque = "fiat";
//         $obj->energie = "essence";
//         $obj->annee = "1994";
//         $obj->modele = "punto";
        
    }
    
    public static function getMarqueOptions()
    {
        $modelTable  = new Application_Model_Table_MarqueTable();
        return array(0 => '-- liste des marques') + $modelTable->getOptionList();        
    }
    
    
    public static function addRecord(Zend_Form $form)
    {
        $modelTable  = new Application_Model_Table_VoitureTable();
        
        $data = array();
        
        $data['marque_id'] = $form->getValue('marque_id');
        $data['modele'] = $form->getValue('modele');
        $data['energie'] = $form->getValue('energie');
        $data['annee'] = $form->getValue('annee');
        
        $voitureId = $modelTable->insert($data);
                
        return $voitureId;
    }
    
    /**
     * 
     * @param Application_Form_VoitureForm $form
     * @param number $voitureId
     * @return number
     */
    public static function updateRecord(Application_Form_VoitureForm $form, $voitureId)
    {
        $modelTable  = new Application_Model_Table_VoitureTable();
        
        $data  = array();
        $data['marque_id'] = $form->getValue('marque_id');
        $data['modele'] = $form->getValue('modele');
        $data['energie'] = $form->getValue('energie');
        $data['annee'] = $form->getValue('annee');
        
        $where = $modelTable->getAdapter()->quoteInto('id = ?', $voitureId); 
        
        $nbUpdated =  $modelTable->update($data, $where);

        return $nbUpdated;
    }
    
    public static function removeRecordById($voitureId)
    {
        $modelTable  = new Application_Model_Table_VoitureTable();
        $where = $modelTable->getAdapter()->quoteInto('id = ?', $voitureId);
        
        return $modelTable->delete($where);
        
    }
}
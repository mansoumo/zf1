<?php
class Application_Model_Country
{
    public static function getList()
    {
        $modelTable = new Application_Model_Table_CountryTable();
        return $modelTable->getList();
    }
}
<?php
class Application_Model_Abstract
{
    const OP_STATUS_OK = 'ok';
    const OP_STATUS_KO = 'ko';
    
    const FORM_SELECT_OPTION_NULL  = 'OPTION_NULL';
    
    const DB_ERROR_ROW_NOT_FOUND = -10000;
    
    public static function getNullOption()
    {
        return array(self::FORM_SELECT_OPTION_NULL => '- -');
    }
}
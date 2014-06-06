<?php
/**
 * Mourad MANSOUR
 *
 *
 * @category   My
 * @package    My_View
 * @subpackage Helper
 * @version    $Id$
 * 
 * @since      2014 May
 */

/**
 * Helper for returning my application name, contact name and contact email
 *
 * @category   My
 * @package    My_View
 * @subpackage Helper
 * @see        Zend_View_Helper_Abstract
 */

class My_View_Helper_Language extends Zend_View_Helper_Abstract
{
    public function language()
    {
        $locale  = My_App::getInstance()->getResource('locale');        
        return $locale->getLanguage(); 
    }
}

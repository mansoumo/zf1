<?php
/**
 * Mourad MANSOUR
 *
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @version    $Id$
 * 
 * @since      2014 May
 */

/**
 * Helper for returning my application name, contact name and contact email
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @see        Zend_View_Helper_Abstract
 */

class App_View_Helper_Language extends Zend_View_Helper_Abstract
{
    public function language()
    {
        $locale  = App_Application::getInstance()->getResource('locale');
        return $locale->getLanguage();
    }
}

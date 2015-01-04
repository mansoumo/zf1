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
 * @since      2014 July
 */

/**
 * Helper for encrypting sensitive data
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @see        Zend_View_Helper_Abstract
 */

class App_View_Helper_Encrypt extends Zend_View_Helper_Abstract
{
    public function encrypt($sensitive)
    {
        return App_Crypt::encrypt($sensitive);
    }
}

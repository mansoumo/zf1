<?php
/**
 *
 * @category   App
 * @package    App_Controller
 * @subpackage App_Controller_Action_Helper
 * 
 * 
 */

/**
 * Helper for decrypting sensitive params
 *
 * @uses       Zend_Controller_Action_Helper_FlashMessenger
 * @category   App
 * @package    App_Controller
 * @subpackage App_Controller_Action_Helper
 * 
 * @version    $Id$
 */

class App_Controller_Action_Helper_Decrypt extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($encrypted)
    {
        if (empty($encrypted)) {
            return $encrypted;
        }
        return App_Crypt::decrypt($encrypted);
    }
    
}
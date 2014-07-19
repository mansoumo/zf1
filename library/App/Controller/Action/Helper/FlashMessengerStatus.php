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
 * Flash Messenger Status- implement session-based messages width status
 *
 * @uses       Zend_Controller_Action_Helper_FlashMessenger
 * @category   App
 * @package    App_Controller
 * @subpackage App_Controller_Action_Helper
 * 
 * @version    $Id$
 */

class App_Controller_Action_Helper_FlashMessengerStatus extends Zend_Controller_Action_Helper_FlashMessenger
{    
    public function direct($message, $status, $namespace=NULL)
    {
        return $this->addMessageStatus($message, $status, $namespace);
    }
    
    public function addMessageStatus($message, $status, $namespace = null)
    {
        if (!is_string($namespace) || $namespace == '') {
            $namespace = $this->getNamespace();
        }
        
        if (self::$_messageAdded === false) {
            self::$_session->setExpirationHops(1, null, true);
        }
        
        if (!is_array(self::$_session->{$namespace})) {
            self::$_session->{$namespace} = array();
        }
        
        self::$_session->{$namespace}[] = array('status' => $status, 'text' => $message);
        self::$_messageAdded = true;
        
        return $this;        
    }
}
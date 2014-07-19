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
 * @since      2014 july
 */

/**
 * Helper for displayoing flash messages
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @see        Zend_View_Helper_Abstract
 * @uses       App_View_Helper_Alert
 */

class App_View_Helper_FlashMessengerStatus extends Zend_View_Helper_Abstract
{
    protected $_messages = null;
    
    public function __construct()
    {
        $flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessengerStatus');
        if ($flashMessenger->hasMessages()) {
            $this->_messages = $flashMessenger->getMessages();
        }
    }
    
    public function flashMessengerStatus($translate = true)
    {
        if ($this->_messages === null) {
            return '';
        }
        
        $html = '';
        
        foreach ($this->_messages as $message) {
            if (! array_key_exists('text', $message)) {
                throw new Zend_Exception('text key is required in each message');
            }
            
            if (! array_key_exists('status', $message)) {
                throw new Zend_Exception('status key is required in each message');
            }
            
            if ($translate) {
                $messageText = $this->view->translate($message['text']);
            } else {
                $messageText = $message['text'];
            }
            
            $html .= $this->view->alert($messageText, $message['status']);
        }
        return $html;
        
    }
}

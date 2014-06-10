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

class App_View_Helper_MyApp extends Zend_View_Helper_Abstract
{
    protected $_myAppOptions = null;
    
    public function __construct()
    {
        $this->_myAppOptions = App_Application::getInstance()->getOptionKey('myApp');
    }
    
    public function myApp()
    {
        return $this;
    }
    
    public function getName()
    {
        return (array_key_exists('name', $this->_myAppOptions))
        ? $this->_myAppOptions['name'] : '';
    }
    
    public function getContactName()
    {
        return (array_key_exists('contactName', $this->_myAppOptions)) ?
        $this->_myAppOptions['contactName'] : '';
    }
    
    public function getContactEmail()
    {
        return (array_key_exists('ContactEmail', $this->_myAppOptions)) ?
        $this->_myAppOptions['ContactEmail'] : '';
    }
}

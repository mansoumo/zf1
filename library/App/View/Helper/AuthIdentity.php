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
 * Helper for returning connected user informations
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @see        Zend_View_Helper_Abstract
 */

class App_View_Helper_AuthIdentity extends Zend_View_Helper_Abstract
{
    protected $_userIdentity = null;
    
    public function __construct()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity() ) {
            $this->_userIdentity = $auth->getIdentity();
        }        
    }
    
    public function authIdentity()
    {
        return $this;
    }
    
    public function hasIdentity()
    {
        return Zend_Auth::getInstance()->hasIdentity();
    }
    
    public function getName()
    {
        if ( null === $this->_userIdentity  
            || false ===  $this->_userIdentity instanceof stdClass
            || empty($this->_userIdentity->first_name)
            || empty($this->_userIdentity->familly_name)
        ) {
            return '';
        }
        return $this->_userIdentity->first_name . ' ' . $this->_userIdentity->familly_name; 
    }
}

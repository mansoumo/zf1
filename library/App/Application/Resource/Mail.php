<?php
/**
 * Mourad MANSOUR
 *
 *
 * @category   App
 * @package    App_Application
 * @subpackage Resource
 * @version    $Id$
 *
 * @since      2014 May
 */

/**
 * @see Zend_Application_Resource_ResourceAbstract
 */

/**
 * @uses       Zend_Application_Resource_ResourceAbstract
 * @category   App
 * @package    App_Application
 * @subpackage Resource
 */

class App_Application_Resource_Mail extends Zend_Application_Resource_ResourceAbstract
{

    /**
     * 
     * @var array
     */
    protected $_mailParams = array();

    /**
     * 
     * @var array
     */
    protected $_transportParams = array();

    /**
     * 
     * @var Zend_Mail_Transport_Abstract | null
     */
    protected $_transport = null;

    /**
     * @return Zend_Mail
     * @see    Zend_Application_Resource_Resource::init()
     */
    public function init()
    {
        $options = $this->getOptions();
        
        $this->_setMailParams($options);
        $this->_setTransportParams($options);
        
        return $this->getMail();
    }

    /**
     * 
     * @return Zend_Mail
     */
    public function getMail()
    {
        $defaultCharset = ($this->_hasMailParam('defaultcharset')) ? $this->_mailParams['defaultcharset'] : null;
        
        $mailInstance = new Zend_Mail($defaultCharset);
        
        if ($this->_hasMailParam('defaultfrom')) {
            $this->_setDefaultFrom();
        }
        
        if ($this->_hasMailParam('defaultreplyTo')) {
            $this->_setDefaultReplayTo();
        }
        
        if ($this->_hasTransportParam('className')) {
            $this->_setDefaultTransport();
        }
        
        return $mailInstance;
    }

    protected function _setDefaultFrom()
    {
        $email = isset($this->_mailParams['defaultfrom']['email']) ?
        $this->_mailParams['defaultfrom']['email'] : null;
        
        $name = isset($this->_mailParams['defaultfrom']['name']) ?
        $this->_mailParams['defaultfrom']['name'] : null;
        
        if ($email !== null) {
            Zend_Mail::setDefaultFrom($email, $name);
        }
    }

    protected function _setDefaultReplayTo()
    {
        $email = isset($this->_mailParams['defaultreplyTo']['email']) ?
        $this->_mailParams['defaultreplyTo']['email'] : null;
        
        $name = isset($this->_mailParams['defaultreplyTo']['name']) ?
        $this->_mailParams['defaultreplyTo']['name'] : null;
        
        if ($email !== null) {
            Zend_Mail::setDefaultReplyTo($email, $name);
        }
    }

    protected function _setDefaultTransport()
    {
        if (false === $this->_hasTransportParam('className')) {
            return $this->_transport;
        }
        
        $transportName = $this->_transportParams['className'];
        
        $options = $this->_transportParams;
        unset($options['className']);
        
        switch ($transportName) {
            case 'Zend_Mail_Transport_Smtp':
                if (!isset($options['host'])) {
                    throw new Zend_Application_Resource_Exception(
                        'A host is necessary for smtp transport,' . ' but none was given'
                    );
                }
                
                $this->_transport = new Zend_Mail_Transport_Smtp($options['host'], $options);
                break;
            case 'Zend_Mail_Transport_Sendmail':
                $this->_transport = new Zend_Mail_Transport_Sendmail($options);
                break;
            default:
        }
        
        if ($this->_transport instanceof Zend_Mail_Transport_Abstract) {
            Zend_Mail::setDefaultTransport($this->_transport);
        }
    }

    protected function _setMailParams($options)
    {
        if (array_key_exists('params', $options)) {
            $this->_mailParams = $options['params'];
        }
    }

    protected function _setTransportParams($options)
    {
        if (array_key_exists('transport', $options)) {
            $this->_transportParams = $options['transport'];
        }
    }

    /**
     * 
     * @param  string
     * @return boolean
     */
    protected function _hasMailParam($key)
    {
        return array_key_exists($key, $this->_mailParams);
    }

    /**
     * @param  string
     * @return boolean
     */
    protected function _hasTransportParam($key)
    {
        return array_key_exists($key, $this->_transportParams);
    }
}

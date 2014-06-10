<?php
/**
 * Mourad MANSOUR
 *
 *
 * @category   App
 * @package    App_Application
 * @version    $Id$
 *
 * @since      2014 May
 */

/**
 * @category   App
 * @package    App_Application
 * 
 * @see        Zend_Application
 */
    
final class App_Application
{
    /**
     * 
     * @var App_Application
     */
    protected static $_instance  = null;
    
    /**
     * 
     * @var Zend_Application
     */
    protected $_application = null;
    
    /**
     * 
     * @var string
     */
    protected $_configFile  = null;
    
    /**
     * 
     * @var string
     */
    protected $_environment = null;
    
    private function __construct($configFile)
    {
        $this->_setEnvironment();
        $this->_setConfig($configFile);
    }
    
    public static function getInstance($configFile = null)
    {
        if (self::$_instance === null) {
            self::$_instance = new self($configFile);
        }
        return self::$_instance;
    }
    
    /**
     * @see Zend_Application
     * 
     * @return Zend_Application
     */
    public function getApplication()
    {
        if ($this->_application === null) {
            $this->_application = new Zend_Application(
                $this->_environment,
                $this->_configFile
            );
        }
        return $this->_application;
    }
    
    public function run()
    {
        $this->getApplication()->bootstrap()->run();
    }
    
    public function getOptions()
    {
        return $this->getApplication()->getOptions();
    }
    
    public function getOptionKey($key)
    {
        return $this->getApplication()->getOption($key);
    }
    
    public function getResource($name)
    {
        return $this->getApplication()->getBootstrap()->getResource($name);
    }
    
    public function getEnvironment()
    {
        return $this->getApplication()->getEnvironment();
    }
    
    public function getName()
    {
        $myAppOptions  = $this->getOptionKey('myApp');
        return (array_key_exists('name', $myAppOptions)) ?
        $myAppOptions['name'] : '';
    }
    
    protected function _setConfig($configFile)
    {
        if (!is_file($configFile)) {
            throw new Zend_Exception(
                $configFile. ' : is not an existing file'
            );
        }
        $this->_configFile = $configFile;
    }
    
    protected function _setEnvironment()
    {
        if ( !defined('APPLICATION_ENV')) {
            throw new Zend_Exception('APPLICATION_ENV  : is not defined');
        }
    
        $this->_environment = APPLICATION_ENV;
    }
}

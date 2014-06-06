<?php
/**
 * Mourad MANSOUR
 *
 *
 * @category   My
 * @package    My_App
 * @version    $Id$
 *
 * @since      2014 May
 */

/**
 * @category   My
 * @package    My_App
 * 
 * @see        Zend_Application
 */

require_once 'Zend/Application.php';
    
final class My_App
{
    /**
     * 
     * @var My_App
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
    protected $_configFilePath  = null;
    
    /**
     * 
     * @var string
     */
    protected $_environment = null;
    
    private function __construct()
    {
        $this->_setConfigFilePath();
        $this->_setEnvironment();
    }
    
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
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
                $this->_configFilePath
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
    
    protected function _setConfigFilePath()
    {
        if ( !defined('APPLICATION_DIR')) {
            require_once 'Zend/Exception.php';
            throw new Zend_Exception('APPLICATION_DIR  : is not defined');
        }
        
        $this->_configFilePath =
        APPLICATION_DIR.DS.'configs'.DS.'application.ini';
        
        if (!is_file($this->_configFilePath)) {
            require_once 'Zend/Exception.php';
            throw new Zend_Exception(
                $this->_configFilePath. ' : is not an existing file' 
            );
        }        
    }
    
    protected function _setEnvironment()
    {
        if ( !defined('APPLICATION_ENV')) {
            require_once 'Zend/Exception.php';
            throw new Zend_Exception('APPLICATION_ENV  : is not defined');
        }
    
        $this->_environment = APPLICATION_ENV;
    }
    
}
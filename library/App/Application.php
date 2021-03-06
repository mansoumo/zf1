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
        $this->_pluginsLoaderSetIncludeFileCache();
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
    
    /**
     * 
     * @return string
     */
    public function getEnvironment()
    {
        return $this->getApplication()->getEnvironment();
    }
    
    /**
     * 
     * @return string
     */
    public function getName()
    {
        $myAppOptions  = $this->getOptionKey('myApp');
        return (array_key_exists('name', $myAppOptions)) ?
        $myAppOptions['name'] : '';
    }
    
    public function getSecurityKey()
    {
        $myAppOptions  = $this->getOptionKey('myApp');
        if ( !isset($myAppOptions['securityKey'])) {
            throw new Zend_Exception('myApp.securityKey not found in application.ini file');
        }
        
        return $myAppOptions['securityKey'];
    }
    
    public function getSecuritySalt()
    {
        $myAppOptions  = $this->getOptionKey('myApp');
        if ( !isset($myAppOptions['securitySalt'])) {
            throw new Zend_Exception('myApp.securitySalt not found in application.ini file');
        }
    
        return $myAppOptions['securitySalt'];
    }
    
    protected function _pluginsLoaderSetIncludeFileCache()
    {
        $options  = $this->getOptions();
        
        if (!isset($options['pluginsLoader']) ) {
            return false;
        } else {
            $pluginLoaderOptions = $options['pluginsLoader'];
        }
        
        if ( false === isset($pluginLoaderOptions['enableCache'])
            ||
            1 !== (int) $pluginLoaderOptions['enableCache']
        ) {
            return false;
        }
        
        if ( false === isset($pluginLoaderOptions['includeCachePath'])
            ||
            false === is_file($pluginLoaderOptions['includeCachePath'])
        ) {
            throw new Zend_Exception($pluginLoaderOptions['includeCachePath'] . ' invalid file');
        }
        
        require_once $pluginLoaderOptions['includeCachePath'];
        Zend_Loader_PluginLoader::setIncludeFileCache($pluginLoaderOptions['includeCachePath']);
        
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

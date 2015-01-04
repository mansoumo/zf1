<?php
defined('DS')
|| define('DS', DIRECTORY_SEPARATOR);

defined('PS')
|| define('PS', PATH_SEPARATOR);

// Define root path to application directory
defined('APPLICATION_ROOT')
|| define('APPLICATION_ROOT', realpath(dirname(dirname(__FILE__))));


// Define path to application directory
defined('APPLICATION_DIR')
    || define('APPLICATION_DIR', APPLICATION_ROOT.DS. 'application');

// Define path to application directory
defined('LANGUAGES_DIR')
    || define('LANGUAGES_DIR', APPLICATION_DIR.DS. 'languages');
    
// Define path to data directory
defined('DATA_DIR')
    || define('DATA_DIR', APPLICATION_ROOT.DS. 'data');
    
// Define path to cache directory
defined('CACHE_DIR')
    || define('CACHE_DIR', DATA_DIR.DS. 'cache');
    
// Define path to logs directory
 defined('LOGS_DIR')
    || define('LOGS_DIR', DATA_DIR.DS. 'logs');
    
// Define path to library directory
defined('LIBRARY_DIR')
    || define('LIBRARY_DIR', APPLICATION_ROOT.DS. 'library');
    
// Define path to public directory
defined('PUBLIC_DIR')
    || define('PUBLIC_DIR', APPLICATION_ROOT.DS. 'public');
    
// Define ZF LIBRARY directory
defined('ZF_LIB')
    || define(
        'ZF_LIB',
        (getenv('ZF_LIB') ? getenv('ZF_LIB') : LIBRARY_DIR.DS.'zf'.DS.'1.12.6')
    );

defined('APP_LIB')
    || define('APP_LIB', LIBRARY_DIR.DS.'App');
    
// Define path to application directory
defined('DATA_DIR')
    || define('APPLICATION_ROOT', APPLICATION_ROOT.DS. 'data');
    
// Define application environment
defined('APPLICATION_ENV')
    || define(
        'APPLICATION_ENV',
        (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development')
    );

 
// Ensure library/ is on include_path
set_include_path(
    ZF_LIB.PS.
    LIBRARY_DIR
);

require_once 'Zend'.DS.'Loader.php';
require_once 'Zend'.DS.'Loader'.DS.'Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('App_');

require_once APPLICATION_DIR.DS.'Bootstrap.php';

$configFile  = APPLICATION_DIR.DS.'configs'.DS.'application.ini';

try{
    App_Application::getInstance($configFile)->run();
} catch (Zend_Exception $e) {
    
    echo "<pre>\n";
    echo $e->getMessage();
    echo "</pre>\n";
    
    echo "<pre>\n";
    echo $e->getTraceAsString();
    echo "</pre>\n";
}
 
// require_once 'Zend/Loader/AutoloaderFactory.php';
// require_once 'Zend/Loader/SplAutoloader.php';
// require_once 'Zend/Loader/StandardAutoloader.php';
// require_once 'Zend/Loader/ClassMapAutoloader.php';

// Zend_Loader_AutoloaderFactory::factory(
// 	array(

// 		'Zend_Loader_ClassMapAutoloader' => array(
// 			ZF_LIB.'/autoload_classmap.php',
// 			APP_LIB.DS.'autoload_classmap.php'
//     	 ),
 
//     	'Zend_Loader_StandardAutoloader' => array(
//     		'prefixes' => array(
//     			'Zend' => ZF_LIB.DS.'Zend',
//     		),
//     		'fallback_autoloader' => true
//     	)
// 	)
// );

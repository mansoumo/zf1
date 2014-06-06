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

defined('MY_LIB')
    || define('MY_LIB', LIBRARY_DIR.DS.'My');
    
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
    LIBRARY_DIR.PS.
    ZF_LIB    
);

require_once 'My/App.php';

My_App::getInstance()->run(); 

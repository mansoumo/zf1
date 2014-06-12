<?php
return 

array(
    'bootstrap' => array(
        'path' => APPLICATION_DIR.DS.'Bootstrap.php',
        'class' => 'Bootstrap'
    ),
    
    'appnamespace' => 'Application',
    
    'resources' => array(
        
        'cachemanager' => array(
            'myApp' => array(
                'frontend' => array(
                    'name' => 'Core',
                    'options' => array(
                        'lifetime' => 36000,
                        'automatic_serialization' => 1,
                        'write_control' => 1,
                        'caching' => 1,
                        'cache_id_prefix' => null,
                        'automatic_cleaning_factor' => 0,
                        'logging' => false,
                        'logger' => false,
                        'ignore_user_abort' => false                        
                    )
                ),
                'backend' => array(
                    'name' => 'File',
                    'options' => array(
                        'cache_dir' => CACHE_DIR,
                        'file_name_prefix' => 'App'
                    )
                )
            )
        ),
        
        'frontController' => array(
            
            'params' => array(
                'displayExceptions' => 1
            ),
            
            'actionHelperPaths' => array(
                'AppActionHelpers' => APP_LIB.'/Controller/Action/Helper'                
            ),
            
            'moduleControllerDirectoryName' => 'controllers',
            
            'moduleDirectory' => APPLICATION_DIR.DS.'modules',
            'defaultModule' => 'default',
            'defaultControllerName' => 'index',
            'defaultAction' => 'index'            
        ),
        
        
        'layout' => array(
            'layoutPath' => APPLICATION_DIR.DS.'layouts',
            'layout' => 'sb-admin'
        ),
        
        'locale' => array(
            'default' => 'fr',
            'force' => false
        ),
        
        'navigation' => array(
            'pages' => array(
                'home' => array(
                    'label' => 'home',
                    'iconeClass' => 'fa fa-home fa-fw',
                    'type' => 'mvc',
                    'action' => 'index',
                    'controller' => 'index',
                    'module' => 'default',                    
                ),
                
                'demo' => array(
                    'label' => 'demo',
                    'iconeClass' => 'fa fa-video-camera fa-fw',
                    'type' => 'uri',
                    'uri' => '#',
                    
                    'pages' => array(
                        'table' => array(
                            'label' => 'tables',
                            'iconeClass' => 'fa fa-list fa-fw',
                            'type' => 'mvc',
                            'action' => 'table',
                            'controller' => 'demo',
                            'module' => 'default'                            
                        ),
                        
                        'charts' => array(
                            'label' => 'Charts',
                            'iconeClass' => 'fa fa-bar-chart-o fa-fw',
                            'type' => 'mvc',
                            'action' => 'charts',
                            'controller' => 'demo',
                            'module' => 'default'
                        ),
                        
                        'forms' => array(
                            'label' => 'Forms',
                            'iconeClass' => 'fa fa-edit fa-fw',
                            'type' => 'mvc',
                            'action' => 'forms',
                            'controller' => 'demo',
                            'module' => 'default'
                        ),
                        'notifications' => array(
                            'label' => 'Notifications',
                            'iconeClass' => 'fa fa-bell-o fa-fw',
                            'type' => 'mvc',
                            'action' => 'forms',
                            'controller' => 'demo',
                            'module' => 'default'
                        ),                        
                    )                     
                ),
                'settings' => array(
                    'label' => 'Settings',
                    'iconeClass' => 'fa fa-gears fa-fw',
                    'type' => 'mvc',
                    'action' => 'index',
                    'controller' => 'index',
                    'module' => 'default',                    
                )
             )           
        ),
        
        'translate' => array(
            'adapter' => 'ini',
            'content' => LANGUAGES_DIR,
            'disableNotices' => true,
            'options' => array(
                'scan' => 'directory'
            ),
            //'cache' => 'myApp'
        ),
        
        'view' => array(
            'doctype' => 'HTML5',
            'charset' => 'UTF-8',
            'contentType' => 'text/html',
            'helperPath' => array(
                'App_View_Helper' => LIBRARY_DIR.DS.'App/View/Helper'
            )
        )
        
    ),
        
    'myApp' => array(
        'name' => 'ZF1 APP',
        'contactName' => 'Mourad MANSOUR',
        'contactEmail' => 'mansour.mourad@gmail.com'
    ),
        
    'phpSettings' => array(
        'display_startup_errors' => 1,
        'display_errors' => 1
    )
);

<?php
/**
 * Mourad MANSOUR
 *
 *
 * @category   App
 * @package    App_Debug
 * @version    $Id$
 *
 * @since      2014 june
 */

/**
 * @category   App
 * @package    App_Debug
 *
 * @see        Zend_Log_Writer_Firebug
 */

class App_Debug
{
    public static function console($var)
    {
        $logger = App_Application::getInstance()->getResource('log');
        $logger->log($var, Zend_Log::DEBUG);
    }
}

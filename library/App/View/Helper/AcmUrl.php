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
 * @since      2014 july
 */

/**
 * Helper for getting urls from Action, Controller, Module and Params
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @see        Zend_View_Helper_Abstract
 */

class App_View_Helper_AcmUrl extends Zend_View_Helper_Abstract
{
    public function acmUrl(
        $action,
        $controller,
        $module = null,
        $params = array()
    ) {
        $urlOptions  = $params;
        
        $urlOptions['action'] = $action;
        $urlOptions['controller'] = $controller;
        $urlOptions['module'] = $module;        
        
        return $this->view->url($urlOptions, null, true);
    }
}

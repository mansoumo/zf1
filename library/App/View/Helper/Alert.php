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
 * Helper for displayoing alerts with the following status : success, info, warning and danger
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @see        Zend_View_Helper_Abstract
 */

class App_View_Helper_Alert extends Zend_View_Helper_Abstract
{
    const STATUS_SUCCESS = 'success';
    const STATUS_INFO = 'info';
    const STATUS_WARNING = 'warning';
    const STATUS_DANGER = 'danger';
    
    public function alert($message, $status, $dismissable = true)
    {
        $html  = '';
        
        $alertClass = 'alert';
        $alertClass .= ' alert-'.$status;
        if ( $dismissable) {
            $alertClass .= ' alert-dismissable';
        }
        
        $html .= '<div class="'.$alertClass.'">';
        
        if ( $dismissable) {
            $html .= '<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>';
        }
        
        $html .= $message;
        
        $html .= '</div>';
        
        return $html;
    }
}

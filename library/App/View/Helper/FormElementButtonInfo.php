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
 * @since      2014 june
 */

/**
 * Helper for displaying form element infomations
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @see        Zend_View_Helper_Abstract
 */

class App_View_Helper_FormElementButtonInfo extends Zend_View_Helper_Abstract
{
    const DATA_PLACEMENT_TOP = 'top';
    const DATA_PLACEMENT_RIGHT = 'right';
    const DATA_PLACEMENT_BOTTOM = 'bottom';
    const DATA_PLACEMENT_LEFT = 'left';
    
    public function formElementButtonInfo($text, $dataPlacement = self::DATA_PLACEMENT_RIGHT)
    {
        $html = ' <button';
        $html .= ' class="btn btn-default"';
        $html .= ' type="button"';
        $html .= ' title=""';
        $html .= ' data-placement="'.$dataPlacement.'"';
        $html .= ' data-toggle="popover"';
        $html .= ' data-container="body"';
        $html .= ' data-content="'.$text.'"';
        $html .= ' data-original-title="Info"';
        $html .= ' >';
        $html .= ' <i class="fa fa-info-circle"></i>';
        $html .= ' </button>';
        
        return $html;
    }
}

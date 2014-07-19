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
 * Helper for displaying HTML anchors 
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @see        Zend_View_Helper_Abstract
 */

class App_View_Helper_HtmlAnchor extends Zend_View_Helper_HtmlElement
{
    public function htmlAnchor($text, $url, $attribs = null)
    {
        $htmlAttribs = $this->_htmlAttribs($attribs);

        $output = '<a ';
        $output .= ' href  ="'. $url.'"';
        $output .= ' '.$htmlAttribs;
        $output .= '>';
        $output .= $this->view->escape($text);
        $output .= '</a>';
        return $output;
    }
}

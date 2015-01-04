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
 * Helper for displaying form errors
 *
 * @category   App
 * @package    App_View
 * @subpackage Helper
 * @see        Zend_View_Helper_Abstract
 */

class App_View_Helper_FormElementErrors extends Zend_View_Helper_Abstract
{
    public function FormElementErrors(array $errors = array(), $options = array())
    {
        $html  = '';
        
        if(!count($errors)) {
            return $html;            
        }
        
        $ulClass  = array_key_exists('ulClass', $options) ? $options['ulClass'] : 'list-unstyled ';
        $liClass  = array_key_exists('liClass', $options) ? $options['ilClass'] : 'list-unstyled left5';
        $textClass = array_key_exists('textClass', $options) ? $options['textClass'] : 'text-warning';
        
        $html .= '<ul class="'.$ulClass.'" >';
        
        foreach ($errors as $errorMsg) {
            $html .= '<li class="'.$liClass.'">';
            $html .= '<i class="fa fa-warning '.$textClass.'"></i> ';
            $html .= '<span class="'.$textClass.'">'.$this->view->escape($errorMsg).'</span>';
            $html .= '</li>';
        }
        $html .= '</ul>';
        
        return $html;
    }
}
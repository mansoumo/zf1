<?php
class App_View_Helper_Breadcrumbs extends Zend_View_Helper_Placeholder_Container_Standalone
{

    /**
     * Registry key for placeholder
     * @var string
     */
    protected $_regKey = 'App_View_Helper_Breadcrumbs';
    
    /**
     * Default Separator
     * @var string 
     */
    protected $_separator = ' / ';
    
    
    public function breadcrumbs()
    {    
        return $this;
    }    
}
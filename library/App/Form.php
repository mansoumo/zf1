<?php
class App_Form extends Zend_Form
{
    /**
     * Should we disable loading the default decorators? yes !!
     * @var bool
     */
    protected $_disableLoadDefaultDecorators = true;
    
    public function init()
    {
        
        $this->setElementDecorators(
            array(
                'Errors',
                array('class' => 'text-warning errors'),
                'ViewHelper'
            )
        );        
    }
    
}
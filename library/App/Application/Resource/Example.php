<?php
class App_Application_Resource_example extends Zend_Application_Resource_ResourceAbstract
{

    public function init()
    {
        $options  = $this->getOptions();
        var_dump($options); die();
    }
}
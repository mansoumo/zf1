<?php
class Zend_Controller_Action_Helper_Double extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($number)
    {
        return $number * 2;
    }
}
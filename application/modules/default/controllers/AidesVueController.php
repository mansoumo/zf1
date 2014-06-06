<?php
class AidesVueController extends Zend_Controller_Action
{
    public function demoAction()
    {
        $valeurBase = 1;
        
        $this->view->checked  = ($valeurBase === 1) ? true : false ;
    }
}
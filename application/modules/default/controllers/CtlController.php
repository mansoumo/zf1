<?php

class CtlController extends Zend_Controller_Action
{

    public function indexAction()
    {
        
    }
    
    public function testAction()
    {
        $paramUrl1 = $this->_request->getParam('param1', 'pas trouvée');
        
        $paramUrl2 = $this->_request->getParam('p2', 'p2 non trouvée');
        
        $nom = 'Mourad';
        
        $this->view->nomDansVue = $nom;
        $this->view->paramUrl1DansVue = $paramUrl1;
        
        $this->view->paramUrl2DansVue = $paramUrl2;
    }
    
    public function listerAction()
    {
        $marque = $this->_request->getParam('marque', null);
        
        $liste = Application_Model_Voiture::getList($marque);
        
        $this->view->voitureList  = $liste;
        
    }


}


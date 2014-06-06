<?php

class VoituresController extends Zend_Controller_Action
{


    public function indexAction()
    {
        // action body
    }

    public function listerAction()
    {        
//         $this->_helper->viewRenderer->setNoRender(false);
//         $this->_helper->layout->disableLayout();
                
        $voitureListe  = Application_Model_Voiture::getTableList();
        
        $this->view->flashMessengerMsg = $this->_helper->flashMessenger->getMessages();        
        
        $this->view->voitureList = $voitureListe;
    }
    
    public function voirAction()
    {
        // Récupération des paramètres
        $voitureId  = $this->_request->getParam('id', null);
        
        $voitureObj = Application_Model_Voiture::findById($voitureId);
        
        // variables de la voiture
        $voitureMarque = $voitureObj->marque;
        $voitureModele = $voitureObj->modele;
        $voitureEnergie = $voitureObj->energie;
        $voitureAnnee = $voitureObj->annee;
        
        // Assignation des variables        
        $this->view->voitureId = $voitureId;
        $this->view->voitureMarque = $voitureMarque;
        $this->view->voitureModele = $voitureModele;
        $this->view->voitureEnergie = $voitureEnergie;
        $this->view->voitureAnnee = $voitureAnnee;
        
    }
    
    public function ajouterAction()
    {
        $form  = new Application_Form_VoitureForm();
        
        if($this->_request->isPost()) {
            
            $post  = $this->_request->getPost();
            
            $leFormulaireEstValide  = $form->isValid($post);
            
            if($leFormulaireEstValide) {               
              try {
                  $voitureId  = Application_Model_Voiture::addRecord($form);
                  if($voitureId) {
                      $this->_helper->redirector('voir', 'voitures', null, array('id'=>$voitureId));
                  }
                  
              } catch (Zend_Exception $e) {
                  $this->view->error = 'Erreur de sauvegarde dans la base';
              }                
            }
            
        }
        
        $this->view->voitureForm = $form;
    }

    public function modifierAction()
    {
        $voitureId  = $this->_request->getParam('voiture_id');
        
        if ($voitureId === null) {
            $this->_helper->flashMessenger->addMessage('fausse url');
            $this->_helper->redirector('lister', 'voitures');                        
        }        
        
        $voitureDbRow  = Application_Model_Voiture::findById($voitureId);        
        $voitureArray = $voitureDbRow->toArray();
        
        
        $voitureForm = new Application_Form_VoitureForm();

        $voitureForm->populate($voitureArray);
        
        
        if($this->_request->isPost()) {
        
            $post  = $this->_request->getPost();
        
            $leFormulaireEstValide  = $voitureForm->isValid($post);
        
            if($leFormulaireEstValide) {
                try {
                    $voitureId  = Application_Model_Voiture::updateRecord($voitureForm, $voitureId);
                    if($voitureId) {
                        $this->_helper->redirector('voir', 'voitures', null, array('id'=>$voitureId));
                    }
        
                } catch (Zend_Exception $e) {
                    $this->view->error = 'Erreur de sauvegarde dans la base';
                }
            }        
        }
        
        $this->view->voitureForm = $voitureForm;
        
        //$this->renderScript('voitures/ajouter.phtml');
    }
    
    public function supprimerAction()
    {
        $voitureId  = $this->_request->getParam('voiture_id');
        
        Application_Model_Voiture::removeRecordById($voitureId);
        $this->_helper->redirector('lister', 'voitures');
        
    }
    
    public function doubleAction()
    {
        $res  = $this->_helper->double(20);
        var_dump($res); die();        
    }
    
    public function csvAction()
    {
        $selectDb = Application_Model_Voiture::getListSelectDb();
        $this->_helper->exportCsv($selectDb);
        
    }
}


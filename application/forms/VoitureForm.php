<?php
class Application_Form_VoitureForm extends Zend_Form
{
    public function init()
    {
//         $elements[] = $this->_getElementModele();
//         $this->addElements($elements);
                
        $this->addElement($this->_getElementMarque());
        $this->addElement($this->_getElementModele());
        $this->addElement($this->_getElementEnergie());
        $this->addElement($this->_getElementAnnee());
        $this->addElement($this->_getElementSubmit());
        
        $this->setMethod("post");
        $this->setAttrib('id', "voiture-form-id");
    
        parent::init();
    }

    protected function _getElementMarque()
    {
        $element = new Zend_Form_Element_Select('marque_id');
    
        $options  = Application_Model_Voiture::getMarqueOptions();
        
        $element->setLabel("Marque de la voiture")
        ->setMultiOptions($options)
        ->setRequired(true)
        
        ;
        
    
        return $element;
    }
    
    protected function _getElementModele()
    {
        $element = new Zend_Form_Element_Text('modele');
    
        $element->setLabel("Modèle de la voiture")
        ->setAttrib("maxlength", 64)
        ->setAttrib("size", 50)
        ->setRequired(true)
//         ->addValidator(new Zend_Validate_NotEmpty())
        //->addFilter(new Zend_Filter_Alnum())
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
//         ->addFilter($filter)
        
        ;
    
        return $element;
    }
    
    protected function _getElementEnergie()
    {
        $element = new Zend_Form_Element_Text('energie');
    
        $element->setLabel("Energie de la voiture")
        ->setAttrib("maxlength", 32)
        ->setAttrib("size", 40)
        ->setRequired(true)
        ->addValidator(new Zend_Validate_NotEmpty());
    
        return $element;
    }

    protected function _getElementAnnee()
    {
        $element = new Zend_Form_Element_Text('annee');
    
        $element->setLabel("Année de la voiture")
        ->setAttrib("maxlength", 4)
        ->setAttrib("size", 10)
        ->setRequired(true)
        ->addValidator(new Zend_Validate_NotEmpty());
    
        return $element;
    }
    
    protected function _getElementSubmit()
    {
        $element  = new Zend_Form_Element_Submit('valider');
        $element->setLabel('Enregistrer');
        return $element;
    }
    
}
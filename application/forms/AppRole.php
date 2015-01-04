<?php
class Application_Form_AppRole extends App_Form
{
    public function init()
    {
        $this->addElement($this->_getElementRoleLibelle());
        $this->addElement($this->_getElementRoleParent());
        
        $this->setMethod("post");
        $this->setAttrib('id', "app-role-form");
        $this->setElementFilters(array('StringTrim'));
        parent::init();
    }
    
    protected function _getElementRoleLibelle()
    {
        $element = new Zend_Form_Element_Text('role');
    
        $element->setLabel('role_libelle')
        ->setDescription('role_libelle_description')
        ->setAttrib('maxlength', '32')
        ->setAttrib('class', 'form-control')        
        ->setRequired(true)
        ->addValidator(new Zend_Validate_Alnum());
        return $element;
    }
    
    protected function _getElementRoleParent()
    {
        $element = new Zend_Form_Element_Select('parent_id');
        
        $options  = array();
        
        $element->setLabel('role_parent')
        ->setDescription('role_parent_description')
        ->setAttrib('class', 'form-control')
        ->setMultiOptions($options)
        ->setRequired(false);
        return $element;
    }
}

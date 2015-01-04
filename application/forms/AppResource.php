<?php
class Application_Form_AppResource extends App_Form
{
    public function init()
    {
        $this->addElement($this->_getElementResourceModule());
        $this->addElement($this->_getElementResourceController());
        $this->addElement($this->_getElementResourceAction());
        $this->addElement($this->_getElementResourceDescription());
        
        $this->setMethod("post");
        $this->setAttrib('id', "app-resource-form");
        $this->setElementFilters(array('StringTrim'));
        parent::init();
    }
    
    protected function _getElementResourceModule()
    {
        $element = new Zend_Form_Element_Text('module');
    
        $element->setLabel('resource_module')
        ->setDescription('resource_module_description')
        ->setAttrib('maxlength', '32')
        ->setAttrib('class', 'form-control')
        ->setRequired(true);
        
        return $element;
    }
    
    protected function _getElementResourceController()
    {
        $element = new Zend_Form_Element_Text('controller');
    
        $element->setLabel('resource_controller')
        ->setDescription('resource_controller_description')
        ->setAttrib('maxlength', '32')
        ->setAttrib('class', 'form-control')
        ->setRequired(true);
        
        return $element;
    }
    
    protected function _getElementResourceAction()
    {
        $element = new Zend_Form_Element_Text('action');
    
        $element->setLabel('resource_action')
        ->setDescription('resource_action_description')
        ->setAttrib('maxlength', '32')
        ->setAttrib('class', 'form-control')
        ->setRequired(true);
    
        return $element;
    }
    
    protected function _getElementResourceDescription()
    {
        $element = new Zend_Form_Element_Text('description');
    
        $element->setLabel('resource_description')
        ->setDescription('resource_description_description')
        ->setAttrib('maxlength', '64')
        ->setAttrib('class', 'form-control')
        ->setRequired(false);
    
        return $element;
    }
}

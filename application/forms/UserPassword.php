<?php
class Application_Form_UserPassword extends App_Form
{
    public function init()
    {
        $this->addElement($this->_getElementPassword1());
        $this->addElement($this->_getElementPassword2());
        
        $this->setMethod("post");
        $this->setAttrib('id', "user-password-form");
        $this->setElementFilters(array('StringTrim'));
        
        parent::init();
    }
    
    protected function _getElementPassword1()
    {
        $element = new Zend_Form_Element_Password('password1');
    
        $element->setLabel('user_password_new')        
        ->setDescription('user_password_info')
        ->setAttrib('maxlength', '16')
        ->setAttrib('class', 'form-control')
        ->setRequired(true);
        return $element;
    }
    
    protected function _getElementPassword2()
    {
        $element = new Zend_Form_Element_Password('password2');
        
        $element
        ->setLabel('user_password_confirm')
        ->setDescription('user_password_identical_info')
        ->setAttrib('maxlength', '16')
        ->setAttrib('class', 'form-control')
        ->setRequired(true)
        ->addValidator(
            new Zend_Validate_Identical('password1')
        );
        return $element;
    }
}

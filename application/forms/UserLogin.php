<?php
class Application_Form_UserLogin extends App_Form
{
    public function init()
    {
        $this->addElement($this->_getElementUsername());
        $this->addElement($this->_getElementPassword());
        
        $this->setMethod("post");
        $this->setAttrib('id', "user-login-form");
        $this->setElementFilters(array('StringTrim'));
        parent::init();
    }
    
    protected function _getElementUsername()
    {
        $element = new Zend_Form_Element_Text('username');
    
        $element->setLabel('user_username')
        ->setDescription('user_auth_username_description')
        ->setAttrib('maxlength', '32')
        ->setAttrib('class', 'form-control')
        ->setRequired(true);
        return $element;
    }
    
    protected function _getElementPassword()
    {
        $element = new Zend_Form_Element_Password('password');
        $element->setLabel('user_password')
        ->setDescription('user_auth_password_description')
        ->setAttrib('maxlength', '16')
        ->setAttrib('class', 'form-control')
        ->setRequired(true);
        return $element;
    }    
}

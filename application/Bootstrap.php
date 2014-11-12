<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    public function _initLocaleTranslate()
    {        
        $this->bootstrap('translate');
        $zendTranslate  = $this->getResource('translate');
        
        $this->bootstrap('locale');
        $zendLocale  = $this->getResource('locale');
        
        if ( ! $zendTranslate->isAvailable($zendLocale)) {
            $options  = $this->getOptions();
            
            $localeDefault  = isset($options['resources']['locale']['default'] )
            ? $options['resources']['locale']['default']
            : 'en';
            
            $zendLocale->setLocale($localeDefault);
            
            $key = (isset($options['registry_key']) && !is_numeric($options['registry_key']))
            ? $options['registry_key']
            : Zend_Application_Resource_Locale::DEFAULT_REGISTRY_KEY;
            Zend_Registry::set($key, $zendLocale);
            
            $zendTranslate->setLocale($zendLocale);
            Zend_Registry::set('Zend_Translate', $zendTranslate);
        }
        
        
    }
}

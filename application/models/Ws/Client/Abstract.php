<?php
abstract class Application_Model_Ws_Client_Abstract
{
    const WS_SOAP_CLIENT_ERR_WSDL  = 1001;
    const WS_SOAP_CLIENT_ERR_LOCATION  = 1002;
    
    /**
     *
     * @var SoapClient
     */
    protected $_soapClient = null;
    
    /**
     *
     * @var string
     */
    protected $_wsdlPath = null;
    
    /**
     *
     * @var array
     */
    protected $_options  = null ;
    
    public function __construct()
    {
        $wsdlPath = $this->getWsdlPath();
        $options = $this->getSoapClientOptions();
        
        $this->init($wsdlPath, $options);
    }
    
    /**
     *
     * @return SoapClient
     */
    public function getSoapClient()
    {
        if ( false === $this->_soapClient instanceof SoapClient ) {
            throw new Zend_Exception('unable to get SoapClient Instance');
        }
        
        return $this->_soapClient;
    }
    
    /**
     * 
     * @param string $wsdlPath
     * @param array $options
     * 
     * @throws Zend_Exception
     */
    protected function init($wsdlPath, array $options)
    {
        if ( !is_file($wsdlPath) ) {
            $message  = $wsdlPath. ' : is an invalid path';
            throw new Zend_Exception($message, self::WS_SOAP_CLIENT_ERR_WSDL);
        }
        
        if ( !array_key_exists('location', $options) || empty($options['location'])) {
            $message  = 'option location is required but not given';
            throw new Zend_Exception($message, self::WS_SOAP_CLIENT_ERR_LOCATION);
        }
        
        $this->_soapClient = new SoapClient($this->_wsdlPath, $this->_options);
        
    }
    
    abstract protected function getWsdlPath();
    
    abstract protected function getSoapClientOptions();
}

<?php
class Application_Model_Ws_Client_Cristal extends Application_Model_Ws_Client_Abstract
{
    const REQUEST_HEADER_NAMESPACE = 'http://www.w3.org/2005/08/addressing';
    const REQUEST_HEADER_ACTION = 'http://www.francetelecom.com/scristal/WebServices/ConsulterDossierClientG1/ConsulterDossierClientG1Port/consulterDossierClientRequest';
    
    /**
     * 
     * @var Zend_Config_Ini
     */
    protected $_config  = null ;
        
    /**
     * 
     * @param string $codeDirection
     * @param string $nd
     * @param string $codeBasicat
     * @param string $etatNd
     * @param string $reference
     * 
     * @throws Zend_Exception
     * 
     * @return stdClass
     */
    public function consulterDossierClient($codeDirection, $nd, $codeBasicat = '', $etatNd = '', $reference = '')
    {
        $soapClient  = $this->getSoapClient();
        
        $soapHeaders  = $this->consulterDossierClientBuildSoapHeaders($codeDirection);
        $requestParams = $this->consulterDossierClientBuildRequestParams($nd, $codeBasicat, $etatNd, $reference);
        
        $soapClient->__setSoapHeaders($soapHeaders);
        
        try {
            $response  = $soapClient->consulterDossierClient($requestParams);
        } catch (SoapFault $e) {
            throw new Zend_Exception($e->getMessage(), $e->getCode());
        }
        
        return $response;
    }

    /**
     * 
     * @param string $codeDirection
     * @return SoapHeader
     */
    protected function consulterDossierClientBuildSoapHeaders($codeDirection)
    {
        $wsaHeaders  = new stdClass();
        $wsaHeaders->Action = self::REQUEST_HEADER_ACTION;
        $wsaHeaders->To = $codeDirection;
        
        $soapHeaders = new SoapHeader(
            self::REQUEST_HEADER_NAMESPACE,
            'wsa',
            $wsaHeaders
        );
        return $soapHeaders;
    }
    
    /**
     * 
     * @param string $nd
     * @param string $codeBasicat
     * @param string $etatNd
     * @param string $reference
     * 
     * @return stdClass
     */
    protected function consulterDossierClientBuildRequestParams($nd, $codeBasicat, $etatNd, $reference)
    {
        $request = new stdClass();
        
        $request->structureConsulterDossierClientIn->ND = $nd;
        $request->structureConsulterDossierClientIn->codeBasicat = $codeBasicat;
        $request->structureConsulterDossierClientIn->etatND = $etatNd;
        $request->structureConsulterDossierClientIn->reference = $reference;

        return $request;
    }
        
    /**
     * 
     * @return array
     */
    protected function getSoapClientOptions()
    {
        if ( $this->_options === null ) {
            $config = $this->getConfig();
            $this->_options = $config->ws->cristal->options->toArray();
        }
        return $this->_options;
    }
    
    /**
     * 
     * @throws Zend_Exception
     * @return string
     */
    protected function getWsdlPath()
    {
        if ( $this->_wsdlPath === null) {
            $config  = $this->getConfig();
            $wsdlPath = $config->ws->cristal->wsdlpath;
            
            if ( $wsdlPath === null ) {
                $msg = 'wsdl path is required but not set in the configuration file';
                throw new Zend_Exception($msg);
            }
            
            if ( !is_file($wsdlPath) ) {
                $msg = $wsdlPath. ' is not a file';
                throw new Zend_Exception($msg);
            }
            $this->_wsdlPath  = $wsdlPath;
        }
        return $this->_wsdlPath;
    }
    
    /**
     * 
     * @return Zend_Config_Ini
     */
    protected function getConfig()
    {
        if ($this->_config === null) {
            $filename = APPLICATION_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'application.ini';
            $this->_config = new Zend_Config_Ini($filename, APPLICATION_ENV);
        }
        
        return $this->_config;
    }
}

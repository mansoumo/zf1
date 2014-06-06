<?php
class Application_Model_Ws_Client_OrangeCarto extends Application_Model_Ws_Client_Abstract
{
    
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
    public function searchApplicationByBasicat($basicat)
    {
        $soapClient  = $this->getSoapClient();
                
        $requestParams = $this->searchApplicationByBasicatBuildRequestParams($basicat);
                
        try {
            $response  = $soapClient->SearchApplication($requestParams);
        } catch (SoapFault $e) {
            throw new Zend_Exception($e->getMessage(), $e->getCode());
        }
        
        return $response;
    }

    /**
     * 
     * @param number $orangeCartoId
     * 
     * @throws Zend_Exception
     * 
     * @return stdClass
     */
    public function searchApplicationByOrangeCartoId($orangeCartoId)
    {
        $soapClient  = $this->getSoapClient();
    
        $requestParams = $this->searchApplicationByOrangeCartoIdBuildRequestParams($orangeCartoId);
    
        try {
            $response  = $soapClient->SearchApplication($requestParams);
        } catch (SoapFault $e) {
            throw new Zend_Exception($e->getMessage(), $e->getCode());
        }
    
        return $response;
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
    protected function searchApplicationByBasicatBuildRequestParams($basicat)
    {
        $request = new stdClass();

        $request->Basicat= $basicat;

        return $request;
    }
    
    protected function searchApplicationByOrangeCartoIdBuildRequestParams($orangeCartoId)
    {
        $request = new stdClass();
    
        $request->IDFTCarto= $orangeCartoId;
    
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
            $this->_options = $config->ws->orangecarto->options->toArray();
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
            $wsdlPath = $config->ws->orangecarto->wsdlpath;
            
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

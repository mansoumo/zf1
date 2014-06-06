<?php
class WsController extends Zend_Controller_Action
{
    
    public function indexAction()
    {
        $wsdlPath  = dirname(__FILE__).DIRECTORY_SEPARATOR.'ConsulterDossierClientG1.wsdl';
        
        $options  = array(
            'location' => 'http://op45rws1.nanterre.francetelecom.fr:9000/apt-router/ConsulterDossierClient-1',
            'soap_version' => SOAP_1_1 ,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'connection_timeout' => 20,
            'trace' => true 
        );        
        
        $wsaHeaders  = new stdClass();
        $wsaHeaders->Action = 'http://www.francetelecom.com/scristal/WebServices/ConsulterDossierClientG1/ConsulterDossierClientG1Port/consulterDossierClientRequest';
        $wsaHeaders->To = '45R_U20';
        
        $soapHeaders = new SoapHeader(
            'http://www.w3.org/2005/08/addressing',
            'wsa',
            $wsaHeaders
        );
                
        $request = new stdClass();
        $request->structureConsulterDossierClientIn->ND = '0148351983';
        $request->structureConsulterDossierClientIn->codeBasicat = '';
        $request->structureConsulterDossierClientIn->etatND = '';
        $request->structureConsulterDossierClientIn->reference = '';
        
        $client = new SoapClient($wsdlPath, $options);
        
        $client->__setSoapHeaders($soapHeaders);
        
        try {
            
            $response  = $client->consulterDossierClient($request);
            var_dump($response);
            
        } catch (Exception $e ) {
            
            var_dump($e->getCode());
            echo "<hr/>";
            
            var_dump($e->getMessage());
            echo "<hr/>";
                        
            print($client->__getLastRequest());            
        }
        die();
    }
    
    public function cristalAction()
    {
        $modelWs  = new Application_Model_Ws_Client_Cristal();
        
        $codeDirection = '45R_U20';
        $nd = '0148351983';
        
        try {
            $response  = $modelWs->consulterDossierClient($codeDirection, $nd);
        } catch (Zend_Exception $e ) {
            Zend_Debug::dump($e->getMessage());
        }
        
        var_dump($response); 
        
        die();
    }
    
    public function orangeCartoAction()
    {
        
        $modelWs  = new Application_Model_Ws_Client_OrangeCarto();
    
        $basicat = 'YVE';
        $orangeCartoId  = '19445';
    
        try {            
            $response  = $modelWs->searchApplicationByBasicat($basicat);
//             $response  = $modelWs->searchApplicationByOrangeCartoId($orangeCartoId);
            Zend_Debug::dump($response);
                        
        } catch (Zend_Exception $e ) {
            Zend_Debug::dump($e->getMessage());
        }
    
        
    
        die();
    }
    
    
    
}

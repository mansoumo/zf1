<?php 

require_once APPLICATION_ROOT.DS.'library'.DS.'PluploadHandler.php';


class FileController extends Zend_Controller_Action
{

    public function loadAction()
    {
        if($this->_request->isPost()) {
            
            Zend_Debug::dump($_FILES);
            
            echo "<hr>";
            
            Zend_Debug::dump($_POST);
            
            echo "<hr>";
            
            PluploadHandler::no_cache_headers();
            PluploadHandler::cors_headers();
            
            $conf = array(
                	'allow_extensions'=> 'xls'
                );
            
            if (!PluploadHandler::handle($conf)) {
                die(json_encode(array(
                    'OK' => 0,
                    'error' => array(
                        'code' => PluploadHandler::get_error_code(),
                        'message' => PluploadHandler::get_error_message()
                    )
                )));
            } else {
                die(json_encode(array('OK' => 1)));
            }
            
        }
    }
}


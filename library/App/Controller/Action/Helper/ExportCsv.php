<?php
class Zend_Controller_Action_Helper_ExportCsv extends Zend_Controller_Action_Helper_Abstract
{

    const CSV_EXTENSION = 'csv';

    const CSV_DELIMITER = ';';

    const CSV_ENCLOSURE = '"';

    const CSV_SELECT_DB_LIMIT = 10000;

    public function direct($selectDb, $headers = array(), $options = array())
    {
        return $this->_process($selectDb, $headers, $options);
    }

    protected function _process($selectDb, $headers, $options)
    {
        set_time_limit(0);
        
        $filename = (array_key_exists('filename', $options)) ? $options['filename'] : $this->_getDefaultFilename();
        $this->_disableRendering();
        $this->_setHeaders($filename);
        
        $fp = @fopen('php://output', 'w');
        
        if ($fp === false) {
            throw new Zend_Exception('Impossible d\'ouvrir le fichier de sortie : php://output');
        }
        
        if (is_array($headers) && count($headers)) {
            $this->_rowWrtite($fp, $headers);
        }
        
        $perPage = self::CSV_SELECT_DB_LIMIT;
        $offset = 0;
        do {
            $selectDb->limit($perPage, $offset);
            $result = $selectDb->query()->fetchAll();
            if (count($result)) {
                foreach ($result as $row) {
                    $this->_rowWrtite($fp, $row);
                }
            }
            $offset += $perPage;
        } while (count($result));
        
        fclose($fp);
        
        $content = ob_get_contents();
        ob_clean();
        
        echo utf8_decode($content);
    }

    protected function _getDefaultFilename()
    {
        return 'export' . '.' . self::CSV_EXTENSION;
    }

    protected function _rowWrtite($resource, array $row)
    {
        $res = @fputcsv($resource, $row, self::CSV_DELIMITER, self::CSV_ENCLOSURE);
        return $res;
    }

    protected function _disableRendering()
    {
        Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->setNoRender(true);
        Zend_Layout::getMvcInstance()->disableLayout();
    }

    protected function _setHeaders($filename)
    {
        header("Content-type: application/force-download");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    }
}

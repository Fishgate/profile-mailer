<?php
/**
 * Handles file uploads
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za>
 */

class Upload {
    private $con;
    private $logs;
    private $alerts;
    
    private $logList;
    
    /**
     *
     * @var Array
     */
    public $file;
    
    /**
     *
     * @var String
     */
    public $newName;
    
    public function __construct() {
        // prepare db connection
        $this->con = new Connection();
        $this->con = $this->con->dbConnect();
        
        if($this->con) $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
        
        // prepare alerts
        $this->alerts = new Alerts();
        
        // prepare error logging
        $this->logs = new ErrorLog();
    }
    
    /**
     * 
     * @return boolean
     */
    private function errorCheck(){
        switch ($this->file['error']) {
            case 1:
                return $this->logs->output($this->alerts->UPLOAD_ERROR_1, $this->alerts->UPLOAD_ERROR_GENERAL);
            case 2:
                return $this->logs->output($this->alerts->UPLOAD_ERROR_2, $this->alerts->UPLOAD_ERROR_GENERAL);
            case 3:
                return $this->logs->output($this->alerts->UPLOAD_ERROR_3, $this->alerts->UPLOAD_ERROR_GENERAL);
            case 4:
                return $this->logs->output($this->alerts->UPLOAD_ERROR_4, $this->alerts->UPLOAD_ERROR_GENERAL);
            case 6:
                return $this->logs->output($this->alerts->UPLOAD_ERROR_6, $this->alerts->UPLOAD_ERROR_GENERAL);
            case 7:
                return $this->logs->output($this->alerts->UPLOAD_ERROR_7, $this->alerts->UPLOAD_ERROR_GENERAL);
            case 8:
                return $this->logs->output($this->alerts->UPLOAD_ERROR_8, $this->alerts->UPLOAD_ERROR_GENERAL);
            default:
                return true;
        }
    }
    
    /**
     * 
     * @return type
     */
    private function getFileExt(){
        return '.' . pathinfo($this->file['name'], PATHINFO_EXTENSION);
    }
    
    private function filterName($filename){
        return str_replace(' ', '_', $filename);
    }
    
    /**
     * 
     * @param type $name
     * @param type $file
     * @return boolean
     * @throws Exception
     */
    private function logUploads($name, $file){
        try {
            $this->logList = $this->con->prepare('INSERT INTO '.DB_LISTS_TBL.' (name, file, date, unix) VALUES (:name, :file, :date, :unix);');
            
            $this->logList->bindValue(':name', $name);
            $this->logList->bindValue(':file', $this->filterName($file));
            $this->logList->bindValue(':date', date('d-m-Y'));
            $this->logList->bindValue(':unix', time());
            
            if($this->logList->execute()){
                return true;
            }
        } catch (PDOException $ex) {
            throw new Exception( $this->logs->output($ex->getMessage(), $this->alerts->LOG_UPLOAD_ERR) );
        }
    }
    
    /**
     * 
     * @return type
     * @throws Exception
     */
    public function uploadFile(){
        if($this->errorCheck()){
            if ( @move_uploaded_file($this->file['tmp_name'], UPLOAD_DIR.$this->filterName($this->newName).$this->getFileExt()) ){
                return $this->logUploads($this->newName, $this->file['name']);
            }else{
                throw new Exception( $this->logs->output($this->alerts->MOVE_UPLOADED_FILE_FAIL, $this->alerts->UPLOAD_ERROR_GENERAL) );
            }
        }else{
            throw new Exception( $this->logs->output($this->errorCheck(), $this->alerts->UPLOAD_ERROR_GENERAL) );
        }
    }
    
    
}
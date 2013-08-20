<?php
/**
 * Handles file uploads, indexing, and renaming
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za>
 */

class Upload {
    private $con;
    private $logs;
    private $alerts;
    
    private $logList;
    private $nospace;
    
    /**
     *
     * @var Array The $_FILES array being post with php
     */
    public $file;
    
    /**
     *
     * @var String The users desired name for the list, this is also send from the form
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
     * Checks for errors in the file upload and returns an appropriate message
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
     * Gets the extention of the current file being processed
     * 
     * @return type
     */
    private function getFileExt(){
        return '.' . pathinfo($this->file['name'], PATHINFO_EXTENSION);
    }
    
    /**
     * 
     * @param String $string The matched string to remove spaces from
     * @return String
     */
    private function filterName($string){
        $this->nospace = trim($string);
        $this->nospace = strtolower($this->nospace);
        $this->nospace = preg_replace('/[^A-Za-z0-9_\-]/', '_', $this->nospace);
        
        return $this->nospace;
    }
    
    /**
     * Captures the uploaded list into an indexing table which will be used later
     * to reference all of the available lists.
     * 
     * @param String $name The new name of the file after it has been uploaded
     * @return boolean returns true on success
     * @throws Exception
     */
    private function logUploads($newName){
        try {
            $this->logList = $this->con->prepare('INSERT INTO '.DB_LISTS_TBL.' (nice_name, file_name, tbl_name, date, unix) VALUES (:nice, :file, :tbl, :date, :unix);');
            
            $this->logList->bindValue(':nice',  $newName);
            $this->logList->bindValue(':file',  $this->filterName($newName).$this->getFileExt());
            $this->logList->bindValue(':tbl',   $this->filterName($newName));
            $this->logList->bindValue(':date',  date('d-m-Y'));
            $this->logList->bindValue(':unix',  time());
            
            if($this->logList->execute()){
                return true;
            }
        } catch (PDOException $ex) {
            throw new Exception( $this->logs->output($ex->getMessage(), $this->alerts->LOG_UPLOAD_ERR) );
        }
    }
    
    /**
     * Uploads the file to a specified location. Location specified in config.php
     * 
     * @return Boolean returns true on success
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
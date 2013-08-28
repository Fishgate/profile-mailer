<?php
/**
 * Handles file uploads, indexing, and renaming
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za>
 */

class ImportList {
    private $con;
    private $logs;
    private $alerts;
    
    private $logList;
    private $listLogID;
    private $readListLog;
    private $listLogResult;
    
    private $nospace;
    private $create_tbl;
    private $addColumn;
    private $addColumn_success;
    private $colCount;
    private $populate;
    private $populate_success;
    private $colsToInsert = array();
    
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
    private function errorCheck() {
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
     * Gets the total number of columns inside of the CSV file to prepare
     * its temporary table columns. These will later be cleaned up by the user.
     * 
     * @param String $filename Name of the file in the uploads directory to read
     * @return Int
     */
    public function csvGetColumnCount($filename){
        ini_set('auto_detect_line_endings', TRUE);
                
        if($fh = fopen(UPLOAD_DIR.$filename, 'r')){
            $row = fgetcsv($fh);
            return count($row);                    
        }
    }
    
    /**
     * 
     * 
     */
    public function prepareCreateTblSQL(){
        
    }
    
    /**
     * Creates a new database table with temporary column headers based on the uploaded CSV file.
     * 
     * 
     * @param type $tbl_name
     * @param type $filename
     * @return type
     * @throws Exception
     */
    private function importCSV($tbl_name, $filename){
        try {
            $this->create_tbl = $this->con->prepare("CREATE TABLE $tbl_name (id INT NOT NULL AUTO_INCREMENT,  PRIMARY KEY(id));");
            
            if($this->create_tbl->execute()){
                $this->colCount = $this->csvGetColumnCount($filename);                       

                if($this->colCount > 0){
                    for($i=1; $i<=$this->colCount; $i++){
                        // populate an array of the columns we just made to use in the INSERT statement later
                        array_push($this->colsToInsert, 'temp_'.$i);

                        // append the neccesary amount of columns onto the table we just created
                        $this->addColumn = $this->con->prepare("ALTER TABLE $tbl_name ADD COLUMN temp_$i TEXT NOT NULL;");                    

                        if(!$this->addColumn->execute()){
                            $this->addColumn_success = false;
                            break;
                        }else{
                            $this->addColumn_success = true;
                        }
                    }

                    if($this->addColumn_success){
                        if($fh = fopen(UPLOAD_DIR.$filename, 'r')){
                            while($row = fgetcsv($fh)) {
                                $this->populate = $this->con->prepare("INSERT INTO $tbl_name (". implode(",", $this->colsToInsert) .") VALUES ('". implode("','", $row) ."');");
                                
                                if(!$this->populate->execute()){
                                    $this->populate_success = false;
                                    break;
                                }else{
                                    $this->populate_success = true;
                                }
                            }
                            
                            if($this->populate_success){
                                return $this->logUploads($this->newName);
                            }
                        }
                    }
                }else{
                    throw new Exception( $this->logs->output('Could not count columns in CSV file.', 'Could not count columns in CSV file.') );
                }
            }
        } catch (PDOException $ex) {
           throw new Exception( $this->logs->output($ex->getMessage(), $this->alerts->CREATE_LIST_DB_ERR) );
        }
    }
    
    /**
     * Captures the uploaded list into an indexing table which will be used later to reference all of the available lists.
     * 
     * @param String $name The new name of the file after it has been uploaded
     * @return boolean returns a json object with the result of the final query and the data it retrieved
     * @throws Exception
     */
    private function logUploads($newName){
        try {
            $this->logList = $this->con->prepare(
                'INSERT INTO '.DB_LISTS_TBL.' 
                (nice_name, file_name, tbl_name, date, unix)
                VALUES 
                (:nice, :file, :tbl, :date, :unix);'
            );
            
            $this->logList->bindValue(':nice',  $newName);
            $this->logList->bindValue(':file',  $this->filterName($newName).$this->getFileExt());
            $this->logList->bindValue(':tbl',   'mailinglist_'.$this->filterName($newName));
            $this->logList->bindValue(':date',  date('d-m-Y'));
            $this->logList->bindValue(':unix',  time());
            
            if($this->logList->execute()){                
                $this->readListLog = $this->con->prepare("SELECT id FROM ".DB_LISTS_TBL." WHERE tbl_name = :tbl_name");
                $this->readListLog->bindValue(':tbl_name', 'mailinglist_'.$this->filterName($newName));
                $this->readListLog->execute();
                
                if($this->readListLog->rowCount() > 0){
                    $this->listLogResult = $this->readListLog->fetch(PDO::FETCH_ASSOC);
                    return json_encode(array('result' => 'success', 'id' => $this->listLogResult['id']));
                }
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
                return $this->importCSV('mailinglist_'.$this->filterName($this->newName), $this->filterName($this->newName).$this->getFileExt());
            }else{
                throw new Exception( $this->logs->output($this->alerts->MOVE_UPLOADED_FILE_FAIL, $this->alerts->UPLOAD_ERROR_GENERAL) );
            }
        }else{
            throw new Exception( $this->logs->output($this->errorCheck(), $this->alerts->UPLOAD_ERROR_GENERAL) );
        }
    }
    
    
    
    
}
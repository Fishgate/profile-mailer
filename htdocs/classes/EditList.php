<?php
/**
 * Handles all minipulation of the mailing list database tables
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za> <kyle@fishgate.co.za>
 */

class EditList {
    // class instance variables
    private $con;
    private $logs;
    private $alerts;
    
    // db query variables
    private $getTableName;
    private $workingTable;
    private $tableData;
    private $tableDataRow;
    private $tableDataArray = array();    
    private $removeRows;
    private $renameColumns;
    
    // booleans
    private $renamed = false;
    private $removedRows = false;
    
    /**
     *
     * @var Array The associative array of old column names as $key to new column names as $value
     */
    public $columnNamesArray = array();
    
    /**
     *
     * @var Array An array of row id's to match in the mailing list table that will be deleted
     */
    public $removeRowsArray = array();
    
    /**
     *
     * @var type The dynamic imported table name which is being minipulated
     */
    public $tableName;
    
    /**
     *
     * @var int The ID of the row in the reference table (lists) which holds records of all the lists uploaded
     */
    public $tableRefID;
    
    /**
     *
     * @var String The id of the list which should be fetched and crossed referenced for minipulating
     */
    public $listID;
    
    public function __construct() {
        // prep the database
        $this->con = new Connection();
        $this->con = $this->con->dbConnect();
        
        if($this->con) $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // setup instance of alerts
        $this->alerts = new Alerts();
        
        // setup instance of errorlogs
        $this->logs = new ErrorLog();
    }
    
    /**
     * Gets the current working table after it has been uploaded based on the ID in the reference table
     * 
     * @return String
     */
    public function getWorkingTable() {
        $this->getTableName = $this->con->prepare("SELECT tbl_name FROM ".DB_LISTS_TBL." WHERE id=:id");
        $this->getTableName->bindValue(":id", $this->tableRefID);
        $this->getTableName->execute();
        
        if($this->getTableName->rowCount() > 0){
            $this->workingTable = $this->getTableName->fetch(PDO::FETCH_ASSOC);
            return $this->workingTable['tbl_name'];
        }
    }
    
    /**
     * come back to this when doing managing of lists. At the moment 
     * the current column names are just assumed as coming from the 
     * import process i.e. temp_1, temp_2, etc. This works fine for
     * now, however it will need to be fetched dynamicaly instead.
     * 
     * 
    public function getTableSchema(){
        $this->tableSchema = $this->con->prepare("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_name=:name;");
        $this->tableSchema->bindValue(":name", $this->getWorkingTable());
        
        $this->tableSchema->execute();
        
        while($row = $this->tableSchema->fetch(PDO::FETCH_ASSOC)){
            print_r($row);
        }
    }
     * 
     * 
     */
    
    /**
     * Fetches and returns and associative array of the table data. 
     * The data is presented to the end user to edit the table
     * 
     * @return Array The table data in an associative array
     * @throws Exception Failed to fetch data from the table
     */
    public function getTableData(){
        try {
            $this->tableData = $this->con->prepare("SELECT * FROM ".$this->getWorkingTable().";" );
            $this->tableData->execute();
            
            if($this->tableData->rowCount() > 0) {
                while($this->tableDataRow = $this->tableData->fetch(PDO::FETCH_ASSOC)) {
                    array_push($this->tableDataArray, $this->tableDataRow);
                }

                return $this->tableDataArray;
            }else{
                throw new Exception( $this->logs->output($this->alerts->EDIT_FETCH_TBL_EMPTY, $this->alerts->EDIT_FETCH_TBL_EMPTY) );
            }
            
        } catch (PDOException $ex) {
            throw new Exception( $this->logs->output($ex->getMessage(), $this->alerts->EDIT_FETCH_TBL_ERR) );
        }
    }
    
    /**
     * Loops through the $removeRowsArray of ID's and deletes matching rows from the current working table
     * 
     * @return boolean True on success
     * @throws Exception
     */
    public function removeRows() {
        try {
            $this->removeRows = $this->con->prepare("DELETE FROM $this->tableName WHERE id=:id");
            
            foreach ($this->removeRowsArray as $rowID) {
                $this->removeRows->bindValue(":id", $rowID);
                if(!$this->removeRows->execute()){
                    $this->removedRows = false;
                }
            }
           
            if($this->removedRows) return true;
           
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
    }
    
    /**
     * Loops through the associative $columnNamesArray if old column names ($key) and new column names ($value)
     * and runs an ALTER TABLE sql statement to rename the column headers from their temporary names to the 
     * desired name the users wishes them to have
     * 
     * @return boolean True on success
     * @throws Exception
     */
    public function renameColumns() {
        try {
            foreach ( $this->columnNamesArray as $oldname => $newname ) {
                $this->renameColumns = $this->con->prepare("ALTER TABLE `$this->tableName` CHANGE `$oldname` `$newname` TEXT;");
                
                if(!$this->renameColumns->execute()){
                    $this->renamed = false;
                }
                
                if($this->renamed) return true;
            }
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}   


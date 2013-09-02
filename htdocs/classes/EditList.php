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
    private $tableSchema;
    
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
     * might not need this seeing as its just incrimentaly numbered
     * 
    public function getTableSchema(){
        $this->tableSchema = $this->con->prepare("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_name=:name;");
        $this->tableSchema->bindValue(":name", $this->getWorkingTable());
        $this->tableSchema->execute();
        
        while($row = $this->tableSchema->fetch(PDO::FETCH_ASSOC)){
            print_r($row);
        }
    }
    */
    
    public function getTableData(){
        try {
            $this->tableData = $this->con->prepare("SELECT * FROM ".$this->getWorkingTable().";" );
            $this->tableData->execute();
            
            while($this->tableDataRow = $this->tableData->fetch(PDO::FETCH_ASSOC)) {
                array_push($this->tableDataArray, $this->tableDataRow);
            }
            
            return $this->tableDataArray;
            
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
    }
    
}


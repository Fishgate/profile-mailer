<?php
/**
 * Controls database connection wherever its required
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za> <kyle@fishgate.co.za>
 */

class Connection {
    private $alerts;
    private $logs;
    
    /**
     * Initiate an instance of Error log class
     * 
     */
    public function __construct() {
        $this->logs = new ErrorLog;
        $this->alerts = new Alerts();
    }
    
    /**
     * Initiates a PDO database connection
     * 
     * @return \PDO
     */
    public function dbConnect() {
        try {
            return new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $ex) {
            $this->logs->output($ex->getMessage(), $this->alerts->DB_CONNECT_FAIL);
        }
    }
    
}


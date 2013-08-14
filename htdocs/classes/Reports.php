<?php
/**
 * Fetches data used in frontend logging and reporting
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za> <kyle@fishgate.co.za>
 */

require_once(SITE_ROOT . '/classes/Connection.php');
require_once(SITE_ROOT . '/classes/ErrorLog.php');

class Reports {
    private $con;
    private $quicksend_logs;
    private $quicksend_logs_results = array();
    private $quicksend_total;
    private $quicksend_opened;
    private $quicksend_unopened;
    
    public function __construct() {
        $this->con = new Connection();
        $this->con = $this->con->dbConnect();
        
        if($this->con) $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * Returns and assoc array of the latest 10 email log entries in the database table
     * 
     * @return boolean
     */
    public function quicksend_logs() {
        try {
            $this->quicksend_logs = $this->con->prepare('SELECT * FROM '.DB_LOGS_TBL.' ORDER BY unix DESC LIMIT 10;');
            $this->quicksend_logs->execute();
            
            if($this->quicksend_logs->rowCount() > 0) {
                while($result = $this->quicksend_logs->fetch(PDO::FETCH_ASSOC)){
                    array_push($this->quicksend_logs_results, $result);
                }
                
                return $this->quicksend_logs_results;
            }else{
                throw new Exception('Email logs are currently empty.');
            }
        } catch (PDOException $ex) {
            $this->quicksend_logs->output($ex->getMessage(), 'Error retrieving email logs from database.');
        }
    } 
   
    public function get_quicksend_total() {
        $this->quicksend_total = $this->con->prepare('SELECT * FROM '.DB_LOGS_TBL.';');
        $this->quicksend_total->execute();
        
        return $this->quicksend_total->rowCount();
    }
    
    public function get_quicksend_opened() {
        $this->quicksend_opened = $this->con->prepare('SELECT * FROM '.DB_LOGS_TBL.' WHERE opened=:opened;');
        $this->quicksend_opened->bindValue(':opened', 1);
        $this->quicksend_opened->execute();
        
        return $this->quicksend_opened->rowCount();
    }
    
    public function get_quicksend_unopened() {
        $this->quicksend_unopened = $this->con->prepare('SELECT * FROM '.DB_LOGS_TBL.' WHERE opened=:opened;');
        $this->quicksend_unopened->bindValue(':opened', 0);
        $this->quicksend_unopened->execute();
        
        return $this->quicksend_unopened->rowCount();
    }
}


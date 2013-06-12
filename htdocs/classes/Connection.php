<?php
/**
 * Controls database connection wherever its required
 *
 * @author kyle@fishgate.co.za
 */

require_once(SITE_ROOT . '/classes/ErrorLog.php');

class Connection {
    
    private $logs;
    
    public function __construct() {
        $this->logs = new ErrorLog;
    }
    
    public function dbConnect() {
        try {
            return new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $ex) {
            $this->logs->output($ex->getMessage(), 'Error connecting to database.');
        }
    }
    
}


<?php
/**
 * Description of Connection
 *
 * @author Kyle
 */

require_once(SITE_ROOT . '/classes/ErrorLog.php');

class Connection {
    
    private $logs;
    
    public function dbConnect() {
        $this->logs = new ErrorLog();
        
        try {
            return new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $ex) {
            $this->logs->output($ex->getMessage(), 'Error connecting to database.');
        }
    }
    
}


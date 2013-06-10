<?php
/**
 * Description of Connection
 *
 * @author Kyle
 */

//require_once('../includes/config.php');

class Connection {
    
    public function dbConnect(){
        return new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
    }
    
}


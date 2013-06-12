<?php
/**
 * Description of Connection
 *
 * @author Kyle
 */

class Connection {
    
    public function dbConnect() {
        return new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
    }
    
}


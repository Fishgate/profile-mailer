<?php
/**
 * Description of User
 *
 * @author Owner
 */

require_once(SITE_ROOT . '/classes/Connection.php');

class User {
    
    private $db;
    
    public function __construct() {
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();        
        if($this->db) $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    
    public function validate($user) {
        try {
            $st = $this->db->prepare('SELECT * FROM '.DB_USER_TBL.' WHERE user=fdfd');
            $st->bindParam(1, $user);
            $st->execute();
            $result = $st->fetch();

            print_r($result);
        } catch(PDOException $ex) {
            die( $ex->getMessage() );
        }
    }
    
}

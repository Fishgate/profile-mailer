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
    }
    
    public function validate($user) {
        try {
            //$st = $this->db->prepare('SELECT * FROM '.DB_USER_TBL.' WHERdsE user=?');
            $st = $this->db->prepare('ehehehe');
            $st->bindParam(1, $user);
            $st->execute();
            $result = $st->fetch();

            print_r($result);
        } catch(PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
}

<?php
/**
 * Handles user creation, login, verification and authentication
 *
 * @author kyle@fishgate.co.za
 */

require_once(SITE_ROOT . '/classes/Connection.php');
require_once(SITE_ROOT . '/classes/ErrorLog.php');

class User {
    
    private $db;
    private $logs;
    
    public function __construct() {
        $this->logs = new ErrorLog();
        
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();        
        if($this->db) $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    private function generateSalt(){
        return substr(md5(rand(0, 999)), 0, 5);
    }
    
    private function passwordHash($password, $salt){
        return md5($password.$salt);
    }
    
    public function createUser($username, $password){
        $loginSalt = $this->generateSalt();
        $passwordHash = $this->passwordHash($password, $loginSalt);
        
        try {
            $userCreate = $this->db->prepare('INSERT INTO '.DB_USER_TBL.' (user, salt, hash) VALUES (?, ?, ?);');
            $userCreate->bindParam(1, $username);
            $userCreate->bindParam(2, $loginSalt);
            $userCreate->bindParam(3, $passwordHash);
            if($userCreate->execute()) {
                echo "User <strong>$username</strong> with password <strong>$password</strong> succefully created.";
            }
            
        } catch (PDOException $ex) {
            $this->logs->output($ex->getMessage(), 'Error creating user.');
        }
    }
    
    public function validateUser($username, $password) {
        try {
            $st = $this->db->prepare('SELECT * FROM '.DB_USER_TBL.' WHERE user=?;');
            $st->bindParam(1, $username);
            $st->execute();
            
            if($st->rowCount() > 0) {
                $result = $st->fetch(PDO::FETCH_ASSOC);
                
                if( md5($password.$result['salt']) == ($result['hash']) ){
                    $_SESSION['user_auth'] = true;
                    echo trim('success');
                    
                } else {
                    echo 'Password is incorrect';
                }                            
            }else{
                echo 'Username does not exist';
            }
        } catch(PDOException $ex) {
            $this->logs->output($ex->getMessage(), 'Error validating user from database.');
        }
    }
    
    public function authUser($sessionBool){
        if(!isset($sessionBool) || empty($sessionBool)){
            header('location: index.php');
        }else{
            if($sessionBool){
                print_r($_SESSION);
            }
        }   
    }
    
}
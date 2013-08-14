<?php
/**
 * Handles user creation, login, verification and authentication
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za> <kyle@fishgate.co.za>
 */

require_once(SITE_ROOT . '/classes/Connection.php');
require_once(SITE_ROOT . '/classes/ErrorLog.php');

class User {
    
    private $con;
    private $logs;
    
    /**
     *
     * @var String
     */
    public $username;
    
    /**
     *
     * @var String
     */
    public $password;
    
    /**
     * Initiates a new instance of the Error log class, creates a new PDO database connection 
     * and sets its error mode attribute to exception.
     * 
     */
    public function __construct() {
        $this->logs = new ErrorLog();
        
        $this->con = new Connection();
        $this->con = $this->con->dbConnect();        
        if($this->con) $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * Returns a random 5 character long md5 string to be used as login salt.
     * 
     * @return String
     */
    private function generateSalt(){
        return substr(md5(rand(0, 999)), 0, 5);
    }
    
    /**
     * Returns a complete md5 hash of the to be stored as the password of a user.
     * 
     * @param String $password User password.
     * @param String $salt Generated login salt.
     * @return String
     */
    private function passwordHash($password, $salt){
        return md5($password.$salt);
    }
    
    /**
     * Creates a new user and adds the details to the users database table. The
     * details can then be used to log into the application.
     * 
     * @param String $username New username.
     * @param String $password New Password.
     */
    private function createUser($username, $password){
        $loginSalt = $this->generateSalt();
        $passwordHash = $this->passwordHash($password, $loginSalt);
        
        try {
            $userCreate = $this->con->prepare('INSERT INTO '.DB_USER_TBL.' (user, salt, hash) VALUES (?, ?, ?);');
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
    
    /**
     * Authenticates login attempts by checking if the user exists in the user database table. Starts
     * a session if the current user is valid which will allow them access to the rest of the application.
     * 
     * @param String $username
     * @param String $password
     */
    public function validateUser($username, $password) {
        try {
            $st = $this->con->prepare('SELECT * FROM '.DB_USER_TBL.' WHERE user=?;');
            $st->bindParam(1, $username);
            $st->execute();
            
            if($st->rowCount() > 0) {
                $result = $st->fetch(PDO::FETCH_ASSOC);
                
                if( md5($password.$result['salt']) == ($result['hash']) ){
                    $_SESSION['user_auth'] = true;
                    return true;
                    
                } else {
                    //echo 'Password is incorrect';
                    throw new Exception('Password is incorrect');
                }                            
            }else{
                //echo 'Username does not exist';
                throw new Exception('Username does not exist');
            }
        } catch(PDOException $ex) {
            $this->logs->output($ex->getMessage(), 'Error validating user from database.');
        }
    }
    
    /**
     * Checks the authentication session to determine if a user is currently logged in or not
     * in restricted areas of the application.
     * 
     * @param boolean $sessionBool
     */
    public function authUser($sessionBool){
        if(!isset($sessionBool) || empty($sessionBool)){
            die('You do not have sufficient permissions to access this page. Please <a href="index.php">log in</a> to continue.');
        }else{
            if(!$sessionBool){
                die('You do not have sufficient permissions to access this page. Please <a href="index.php">log in</a> to continue.');
            }
        }   
    }
    
}
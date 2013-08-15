<?php
/**
 * Handles user creation, login, verification and authentication
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za> <kyle@fishgate.co.za>
 */

require_once(SITE_ROOT . '/classes/Connection.php');
require_once(SITE_ROOT . '/classes/ErrorLog.php');

class User {
    
    private $alerts;
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
     *
     * @var Boolean
     */
    public $sessionBool;
    
    
    /**
     *
     * @var String URL to the default page a user should be redicted to if they already have a valid login session but end up on the login page.
     */
    public $defaultRedirect;
    
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
        
        $this->alerts = new Alerts();
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
            $this->logs->output($ex->getMessage(), $this->alerts->USER_CREATE_ERROR);
        }
    }
    
    /**
     * Authenticates login attempts by checking if the user exists in the user database table. Starts
     * a session if the current user is valid which will allow them access to the rest of the application.
     * 
     */
    public function validateUser() {
        try {
            $st = $this->con->prepare('SELECT * FROM '.DB_USER_TBL.' WHERE user=?;');
            $st->bindParam(1, $this->username);
            $st->execute();
            
            if($st->rowCount() > 0) {
                $result = $st->fetch(PDO::FETCH_ASSOC);
                
                if( md5($this->password.$result['salt']) == ($result['hash']) ){
                    $_SESSION['user_auth'] = true;
                    return true;
                    
                } else {
                    //echo 'Password is incorrect';
                    throw new Exception($this->alerts->PASSWORD_WRONG);
                }                            
            }else{
                //echo 'Username does not exist';
                throw new Exception($this->alerts->USER_DOESNT_EXIST);
            }
        } catch(PDOException $ex) {
            $this->logs->output($ex->getMessage(), $this->alerts->DB_USER_ERROR);
        }
    }
    
    /**
     * Checks the authentication session to determine if a user is currently logged in or not
     * in restricted areas of the application.
     * 
     * @param boolean $sessionBool
     */
    public function authUser(){
        if(!isset($this->sessionBool) || empty($this->sessionBool)){
            die($this->alerts->ACCESS_DENIED);
        }else{
            if(!$this->sessionBool){
                die($this->alerts->ACCESS_DENIED);
            }
        }   
    }
    
    public function autoRedirect(){
        if(isset($this->sessionBool) || !empty($this->sessionBool)){
            header('Location: ' . $this->defaultRedirect);
        }else{
            return false;
        }
    }
    
}
<?php
/**
 * Handles all processes of the mail, its sending, and its database communication
 *
 * @author kyle@fishgate.co.za
 */

require_once(SITE_ROOT . '/classes/Connection.php');
require_once(SITE_ROOT . '/classes/ErrorLog.php');

class Mailer {
    
    private $con;
    private $logs;
    private $log_results = array();
    private $phpmailer;
    private $template_dir;
    private $date;
    private $unix;
    private $opened;
    private $tokenId;
    
    /**
     * Includes the PHPmailer class, initiates a new instance of the Error log class, 
     * creates a new PDO database connection and sets its error mode attribute to exception,
     * and defines the HTML email template directory form a constant in config.php
     * 
     */
    public function __construct() {
        require_once('class.phpmailer.php');
        
        $this->logs = new ErrorLog();
        
        $this->con = new Connection();
        $this->con = $this->con->dbConnect();        
        if($this->con) $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->template_dir = TEMPLATE_DIR;
    }
    
    /**
     * Returns an array of all items in the template directory
     * 
     * @return \DirectoryIterator
     */
    public function getTemplates() {
        return new DirectoryIterator($this->template_dir);
    }
    
    
    /**
     * Returns an randomly generated md5 string
     * 
     * @return String
     */
    private function generateTokenId(){
        return md5(rand(0, 999));
    }
    
    /**
     * Parses the HTML email template for shortcode identifiers and replaces them with 
     * variable data. Then returns the prepared template as a string to be used as the
     * "body" of the PHPmailer class.
     * 
     * @return type String
     */
    private function prepareTemplate() {
        $this->tokenId = $this->generateTokenId();
        
        $template_file = fopen($this->template_dir . $_POST['template'], 'r');
        $template_string = fread($template_file, filesize($this->template_dir . $_POST['template']));
        $template_string = trim($template_string);
        fclose($template_file);
        
        $template_string = str_replace('[[name]]', strtoupper($_POST['name']), $template_string);
        $template_string = str_replace('[[message]]', $_POST['message'], $template_string);
        $template_string = str_replace('[[id]]', $this->tokenId, $template_string);
        
        return $template_string;
    }
    
    /**
     * Creates a database log of the email being sent. Returns TRUE on success, returns
     * error exception on fail.
     * 
     * @param String $email
     * @param String $name
     * @param String $message
     * @param String $template
     * @return boolean
     */
    private function logEmail($email, $name, $message, $template) {
        try {
            $this->date = date('d-m-Y');
            $this->unix = time();
            $this->opened = false;
            
            $logEmail = $this->con->prepare('INSERT INTO '.DB_LOGS_TBL.' (email, name, message, date, unix, template, opened, token) VALUES (?, ?, ?, ?, ?, ?, ?, ?);');
            
            $logEmail->bindParam(1, $email);
            $logEmail->bindParam(2, $name);
            $logEmail->bindParam(3, $message);
            $logEmail->bindParam(4, $this->date);
            $logEmail->bindParam(5, $this->unix);
            $logEmail->bindParam(6, $template);
            $logEmail->bindParam(7, $this->opened);
            $logEmail->bindParam(8, $this->tokenId);
            
            if($logEmail->execute()) {
                return true;
            }
            
        } catch (PDOException $ex) {
            $this->logs->output($ex->getMessage(), 'Error creating email log.');
        }
    }
    
    /**
     * Initiates a new instance of the PHPmailer class, prepares the neccesary headers and
     * sends the HTML email to a single recipient. On success returns TRUE and logs email, 
     * returns error exception on fail.
     * 
     * @return boolean
     */
    public function quickSend() {
        $this->phpmailer = new PHPMailer();
     
        $this->phpmailer->From = 'info@fishgate.co.za';
        $this->phpmailer->FromName = 'Fishgate';
        $this->phpmailer->AddReplyTo('info@fishgate.co.za', 'Fishgate');
        $this->phpmailer->IsHTML(true);
        
        $this->phpmailer->AddAddress($_POST['email']);
        
        $this->phpmailer->Subject = 'Here is the subject';
        
        $this->phpmailer->Body = $this->prepareTemplate();
        
        if(!$this->phpmailer->Send()) {
            $this->logs->output($this->phpmailer->ErrorInfo, 'Message could not be sent');
        }else{
            $this->logEmail($_POST['email'], $_POST['name'], $_POST['message'], $_POST['template']);
            return true;
        }
    }
    
    /**
     * Returns and assoc array of the latest 10 email log entries in the database table
     * 
     * @return boolean
     */
    public function outputLogs(){
        try {
            $this->logs = $this->con->prepare('SELECT * FROM '.DB_LOGS_TBL.' ORDER BY unix DESC LIMIT 10;');
            $this->logs->execute();
            
            if($this->logs->rowCount() > 0) {
                while($result = $this->logs->fetch(PDO::FETCH_ASSOC)){
                    array_push($this->log_results, $result);
                }
                
                return $this->log_results;
            }else{
                return false;
            }
        } catch(PDOException $ex) {
            $this->logs->output($ex->getMessage(), 'Error displaying email logs.');
        }
    }
}
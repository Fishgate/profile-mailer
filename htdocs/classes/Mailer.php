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
    
    public function __construct() {
        require_once('class.phpmailer.php');
        
        $this->logs = new ErrorLog();
        
        $this->con = new Connection();
        $this->con = $this->con->dbConnect();        
        if($this->con) $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->template_dir = TEMPLATE_DIR;
    }
    
    public function getTemplates() {
        return new DirectoryIterator($this->template_dir);
    }
    
    private function prepareTemplate() {
        $template_file = fopen($this->template_dir . $_POST['template'], 'r');
        $template_string = fread($template_file, filesize($this->template_dir . $_POST['template']));
        $template_string = trim($template_string);
        fclose($template_file);
        
        $template_string = str_replace('[[name]]', strtoupper($_POST['name']), $template_string);
        $template_string = str_replace('[[message]]', strtoupper($_POST['message']), $template_string);
        
        return $template_string;
    }
    
    private function logEmail($email, $name, $message, $template) {
        try {
            $this->date = date('d-m-Y');
            $this->unix = time();
            $this->opened = false;
            
            $logEmail = $this->con->prepare('INSERT INTO '.DB_LOGS_TBL.' (email, name, message, date, unix, template, opened) VALUES (?, ?, ?, ?, ?, ?, ?);');
            
            $logEmail->bindParam(1, $email);
            $logEmail->bindParam(2, $name);
            $logEmail->bindParam(3, $message);
            $logEmail->bindParam(4, $this->date);
            $logEmail->bindParam(5, $this->unix);
            $logEmail->bindParam(6, $template);
            $logEmail->bindParam(7, $this->opened);
            
            if($logEmail->execute()) {
                return true;
            }
            
        } catch (PDOException $ex) {
            $this->logs->output($ex->getMessage(), 'Error creating email log.');
        }
    }
    
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
            echo trim('success');
        }
    }
    
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
<?php
/**
 * Writes cought exceptions into a error.txt log file. Also outputs pretty 
 * errors for end user depending on project state (DEV = true/false) in config.php
 *
 * @author kyle@fishgate.co.za
 */

class ErrorLog {
    
    private $logFile;
    private $phpmailer;
    
    /**
     * Includes the PHPMailer class to deliver error notifications
     * to the dev accounts. DEV email addresses are specified in config.php
     * 
     * Also defines the path to the error log text document.
     * 
     */
    public function __construct(){
        require_once('class.phpmailer.php');
        
        $this->logFile = SITE_ROOT.'/logs/errors.txt';         
    }
    
    /**
     * TODO
     * 
     * @param type $error
     * @return boolean
     */
    private function emailLogs($error){
        $this->phpmailer = new PHPMailer();
     
        $this->phpmailer->From = 'noreply@fishgate.co.za';
        $this->phpmailer->FromName = 'Fishgate Profile Mailer';
        $this->phpmailer->AddReplyTo('noreply@fishgate.co.za', 'Fishgate Profile Mailer');
        $this->phpmailer->IsHTML(false);
        
        $this->phpmailer->AddAddress(DEV_EMAIL);
        
        $this->phpmailer->Subject = 'Fishgate Profile Mailer Error Notification';
        
        $this->phpmailer->Body = $error;
        
        if(!$this->phpmailer->Send()) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Opens the log file defined in the constructor and adds a new time stamped string to the bottom of 
     * the file before saving and closing it.
     * 
     * @param String $error Error string which will be written to the log file.
     */
    private function writeLog($error){
        $fh = fopen($this->logFile, "a") or die('Could not open log file '.$this->logFile);
        fwrite($fh, date('d-m-Y, H:i').' - '.$error."\n") or die('Could not write to log file '.$this->logFile);
        fclose($fh);
    }
    
    /**
     * Handles the returning of errors cought in exceptions. Displays an appropriate error message
     * as well as creates a new entry in the error log file.
     * 
     * @param String $error The detailed "dev friendly" error which will be logged into the error log file
     * @param String $msg The "user friendly" error which will be displayed in alerts to the end user.
     */
    public function output($error, $msg){
        $this->writeLog($error);
        
        if(!DEV){
            $this->emailLogs($error);
            die($msg);
        }else{
            die($error);
        }
    }
}
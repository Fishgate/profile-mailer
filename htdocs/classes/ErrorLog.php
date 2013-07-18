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
        
    public function __construct(){
        $this->logFile = SITE_ROOT.'/logs/errors.txt';         
    }
    
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
    
    private function writeLog($error){
        $fh = fopen($this->logFile, "a") or die('Could not open log file '.$this->logFile);
        fwrite($fh, date('d-m-Y, H:i').' - '.$error."\n") or die('Could not write to log file '.$this->logFile);
        fclose($fh);
    }
    
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
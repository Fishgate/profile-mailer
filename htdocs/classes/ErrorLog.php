<?php
/**
 * Description of ErrorLog
 *
 * @author Owner
 */

class ErrorLog {
    
    private $logFile;
        
    public function __construct(){
        $this->logFile = SITE_ROOT.'/logs/errors.txt';         
    }
           
    private function writeLog($error){
        $fh = fopen($this->logFile, "a") or die('Could not open log file '.$this->logFile);
        fwrite($fh, date('d-m-Y, H:i').' - '.$error."\n") or die('Could not write to log file '.$this->logFile);
        fclose($fh);
    }
    
    public function output($error, $msg){
        $this->writeLog($error);
        
        if(!DEV){   
            die($msg);
        }else{
            die($error);
        }
    }
}
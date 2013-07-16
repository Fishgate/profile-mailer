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
    private $phpmailer;
    private $template_dir;
    
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
        fclose($file);
        
        $template_string = str_replace('[[name]]', strtoupper($_POST['name']), $template_string);
        $template_string = str_replace('[[message]]', strtoupper($_POST['message']), $template_string);
        
        return $template_string;
    }
    
    public function quickSend() {
        $this->phpmailer = new PHPMailer();
     
        $this->phpmailer->From = 'info@fishgate.co.za';
        $this->phpmailer->FromName = 'Fishgate';
        $this->phpmailer->AddReplyTo('info@fishgate.co.za', 'Fishgate');
        $this->phpmailer->IsHTML(true);
        
        //$this->phpmailer->AddAddress('tyrone@fishgate.co.za', 'Tyrone'); //name is optional, will probably come into play when dealing with mailing lists
        $this->phpmailer->AddAddress($_POST['email']);
        
        $this->phpmailer->Subject = 'Here is the subject';
        
        $this->phpmailer->Body = $this->prepareTemplate();
        
        if(!$this->phpmailer->Send()) {
            $this->logs->output($this->phpmailer->ErrorInfo, 'Message could not be sent');
        }else{
            echo trim('success');
        }
    }
    
}
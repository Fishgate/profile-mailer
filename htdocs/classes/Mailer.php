<?php
/**
 * Handles all processes of the mail, its sending, and its database communication
 *
 * @author Kyle Vermeulen <kyle@source-lab.co.za> <kyle@fishgate.co.za>
 */

/*require_once(SITE_ROOT . '/classes/Connection.php');
require_once(SITE_ROOT . '/classes/ErrorLog.php');*/

class Mailer {
    private $alerts;
    private $con;
    private $phpmailer;
    private $template_dir;
    private $template_fh;
    private $template_string;
    private $date;
    private $unix;
    private $opened;
    private $tokenId;
    private $logEmail;
    
    /**
     *
     * @var String Name of the template file.
     */
    public $template_name;
    
    /**
     *
     * @var String The shortcode match which should be replaced with the tracking URL + token
     */
    public $tracking_string_match;
    
    /**
     *
     * @var String
     */
    public $recipient_address;
    
    /**
     *
     * @var String
     */
    public $email_subject;
    
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
        
        $this->alerts = new Alerts();
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
        
        $this->template_fh = fopen($this->template_dir . $this->template_name, 'r');
        $this->template_string = fread($this->template_fh, filesize($this->template_dir . $_POST['template']));
        $this->template_string = trim($this->template_string);
        fclose($this->template_fh);
        
        $this->template_string = str_replace($this->tracking_string_match, SITE_URL.'/services.gif?token='.$this->tokenId, $this->template_string);
        
        if(isset($_POST) && !empty($_POST)){
            foreach($_POST as $key => $val) {
                $this->template_string = str_replace("[$key]", $val, $this->template_string);   
            }
        }
        else if(isset($_GET) && !empty($_GET)){
            foreach($_GET as $key => $val) {
                $this->template_string = str_replace("[$key]", $val, $this->template_string);   
            }
        }
        
        return $this->template_string;
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
    private function logEmail($email, $template) {
        try {
            $this->date = date('d-m-Y');
            $this->unix = time();
            $this->opened = false;
            
            $this->logEmail = $this->con->prepare('INSERT INTO '.DB_LOGS_TBL.' (email, date, unix, template, opened, token) VALUES (:email, :date, :unix, :template, :opened, :token);');
            
            $this->logEmail->bindValue(':email',      $email);    
            $this->logEmail->bindValue(':date',       $this->date);
            $this->logEmail->bindValue(':unix',       $this->unix);
            $this->logEmail->bindValue(':template',   $template);
            $this->logEmail->bindValue(':opened',     $this->opened);
            $this->logEmail->bindValue(':token',      $this->tokenId);
            
            if($this->logEmail->execute()) {
                return true;
            }
            
        } catch (PDOException $ex) {
            throw new Exception( $this->logs->output($ex->getMessage(), $this->alerts->QUICKSEND_LOG_FAIL) );
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
        
        $this->phpmailer->AddAddress($this->recipient_address);
        
        $this->phpmailer->Subject = $this->email_subject;
        
        $this->phpmailer->Body = $this->prepareTemplate();
        
        if($this->phpmailer->Send()) {
            try {
                return $this->logEmail( $this->recipient_address, $this->template_name );
            } catch (Exception $ex) {
                throw new Exception( $this->logs->output($ex->getMessage(), $ex->getMessage()) );
            }
        }else{
            throw new Exception( $this->logs->output($this->phpmailer->ErrorInfo, $this->alerts->QUICKSEND_SEND_FAIL) );
        }
    }

}
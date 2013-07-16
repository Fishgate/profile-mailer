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
    
    public function __construct() {
        require_once('class.phpmailer.php');
        
        $this->logs = new ErrorLog();
        
        $this->con = new Connection();
        $this->con = $this->con->dbConnect();        
        if($this->con) $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function quickSend() {
        $this->phpmailer = new PHPMailer();
     
        $this->phpmailer->From = 'info@fishgate.co.za';
        $this->phpmailer->FromName = 'Fishgate';
        $this->phpmailer->AddReplyTo('info@fishgate.co.za', 'Fishgate');
        $this->phpmailer->IsHTML(true);
        
        $this->phpmailer->AddAddress('tyrone@fishgate.co.za', 'Tyrone');
        $this->phpmailer->AddAddress('kyle@fishgate.co.za', 'Kyle');
        
        $this->phpmailer->Subject = 'Here is the subject';
        
        $this->phpmailer->Body = '
            <!DOCTYPE html>
            <html>
            <head>
                    <title>Fishgate Mailer</title>
                    <style type=text/css>
                    p{
                             margin-left: 20px;
                             margin-right: 20px;
                             font-family: Arial, sans-serif;
                             font-weight:normal;
                             font-size: 12px;
                             color: #597781;
                    }
                    </style>
            </head>
            <body>
                    <table cellspacing="20" cellpadding="0" style="width: 600px; margin: 0 auto; background: #171f21;">
                    <!--/// BEGIN ROW 1 \\\-->
                            <tr>
                                    <td  width="290" height="350" style="background: #101518;">
                                            <img width="290" height="350" style="display: block;" src="http://www.staging.fishgate.co.za/fg_mailer/fg_mailer_03.jpg" alt="fishgate" />
                                    </td>
                                    <td class="style_me" width="290" height="350" valign="top" style="background: #101518;">
                                            <img width="290" height="5" style="display: block;" src="http://www.staging.fishgate.co.za/fg_mailer/fg_mailer_05.jpg" alt="decoration" />
                                            <h1 style="margin-left: 20px; margin-right: 20px; margin-top: 35px; font-family: Arial, sans-serif; font-weight: normal; font-size: 16px; color: #abbec4;">DEAR '.strtoupper($_POST['name']).'</h1>
                                            '.$_POST['message'].'
                                            <table>
                                                    <tr>
                                                            <td style="width: 15px;">&nbsp;</td>
                                                            <td style="padding: 10px; background: #ffcc00;">
                                                                    <p style="font-family: Aria, sans-serif; font-size: 16px; margin: 0;"><a href="#" style="text-decoration: none; color: #000000;">Contact Us</a></p>
                                                            </td>
                                                    </tr>
                                            </table>
                                    </td>
                            </tr>
                            <!--/// BEGIN ROW 2 \\\-->
                            <tr>
                                    <td  width="290" height="350" valign="top" style="background: #101518;">
                                            <img width="290" height="5" style="display: block;" src="http://www.staging.fishgate.co.za/fg_mailer/fg_mailer_10.jpg" alt="decoration" />
                                            <h1 style="margin-left: 20px; margin-right: 20px; margin-top: 35px; font-family: Arial, sans-serif; font-weight: normal; font-size: 16px; color: #abbec4;">FISHGATE ATTITUDE</h1>
                                            <p style="margin-left: 20px; margin-right: 20px; font-family: Arial, sans-serif; font-weight: normal; font-size: 12px; color: #597781;">Step into a world of infinite possibilities, a world where ideas are king and hold the power to change perception. Ideas that breathe new life into old. Ideas that build solid brands and where those brands live in the minds and hearts of consumers. This is the world where Fishgate Advertising was born. This is where we live, work and play.</p>
                                            <table>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #5cdefe; margin-left: 5px;"><a href="#" style="text-decoration: none; color: #5cdefe;">Read More</a></p>
                                                            </td>
                                                    </tr>
                                            </table>
                                    </td>
                                    <td  width="290" height="350" valign="top" style="background: #101518;">
                                            <img width="290" height="242" style="display: block;" src="http://www.staging.fishgate.co.za/fg_mailer/fg_mailer_11.jpg" alt="d and a d" />
                                            <p style="margin-left: 20px; margin-right: 20px; font-family: Arial, sans-serif; font-weight: normal; font-size: 12px; color: #597781;">Step into a world of infinite possibilities, a world where ideas are king and hold</p>
                                            <table>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_green.jpg" alt="green arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #b2d233; margin-left: 5px;"><a href="#" style="text-decoration: none; color: #b2d233;">View More</a></p>
                                                            </td>
                                                    </tr>
                                            </table>
                                    </td>
                            </tr>
                            <!--/// BEGIN ROW 3 \\\-->
                            <tr>
                                    <td  width="290" height="350" valign="top" style="background: #101518;">
                                            <img width="290" height="242" style="display: block;" src="http://www.staging.fishgate.co.za/fg_mailer/fg_mailer_15.jpg" alt="woolworths" />
                                            <p style="margin-left: 20px; margin-right: 20px; font-family: Arial, sans-serif; font-weight: normal; font-size: 12px; color: #597781;">Step into a world of infinite possibilities, a world where ideas are king and hold</p>
                                            <table>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_green.jpg" alt="green arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #b2d233; margin-left: 5px;"><a href="#" style="text-decoration: none; color: #b2d233;">View More</a></p>
                                                            </td>
                                                    </tr>
                                            </table>
                                    </td>
                                    <td  width="290" height="350" valign="top" style="background: #101518;">
                                            <img width="290" height="5" style="display: block;" src="http://www.staging.fishgate.co.za/fg_mailer/fg_mailer_10.jpg" alt="decoration" />
                                            <h1 style="margin-left: 20px; margin-right: 20px; margin-top: 35px; font-family: Arial, sans-serif; font-weight: normal; font-size: 16px; color: #abbec4;">PIONEERING</h1>
                                            <p style="margin-left: 20px; margin-right: 20px; font-family: Arial, sans-serif; font-weight: normal; font-size: 12px; color: #597781;">Formed in 2006, Fishgate is the brainchild of creative brother duo Quintes and Herman Venter and partner Michael Heyns. Over the last 6 years the company has grown a reputable portfolio with clients, staff and acclaim, with a list of awards and nominations that include gold and silver Loeries, Pendorings, Clios, Eagles and a Lürzer Archive entry.</p>
                                            <table>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #5cdefe; margin-left: 5px;"><a href="#" style="text-decoration: none; color: #5cdefe;">Read More</a></p>
                                                            </td>
                                                    </tr>
                                            </table>
                                    </td>
                            </tr>
                            <!--/// BEGIN ROW 4 \\\-->
                            <tr>
                                    <td  width="290" height="350" valign="top" style="background: #101518;">
                                            <img width="290" height="5" style="display: block;" src="http://www.staging.fishgate.co.za/fg_mailer/fg_mailer_10.jpg" alt="decoration" />
                                            <h1 style="margin-left: 20px; margin-right: 20px; margin-top: 35px; font-family: Arial, sans-serif; font-weight: normal; font-size: 16px; color: #abbec4;">FULL PACKAGE</h1>
                                            <p style="margin-left: 20px; margin-right: 20px; font-family: Arial, sans-serif; font-weight: normal; font-size: 12px; color: #597781;">Fishgate has 15 talented staff with a range of design, web, graphics, art, copywriting, public relations and marketing skills, all working from our central charismatic office. This means that we have immediate access to different services to provide you with better execution, cost effectiveness and efficiency, with the benefit of a shared creative think tank.</p>
                                            <table>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #5cdefe; margin-left: 5px;"><a href="#" style="text-decoration: none; color: #5cdefe;">Read More</a></p>
                                                            </td>
                                                    </tr>
                                            </table>
                                    </td>
                                    <td  width="290" height="350" valign="top" style="background: #101518;">
                                            <img width="290" height="242" style="display: block;" src="http://www.staging.fishgate.co.za/fg_mailer/fg_mailer_18.jpg" alt="lionel smit" />
                                            <p style="margin-left: 20px; margin-right: 20px; font-family: Arial, sans-serif; font-weight: normal; font-size: 12px; color: #597781;">Step into a world of infinite possibilities, a world where ideas are king and hold</p>
                                            <table>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_green.jpg" alt="green arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #b2d233; margin-left: 5px;"><a href="#" style="text-decoration: none; color: #b2d233;">View More</a></p>
                                                            </td>
                                                    </tr>
                                            </table>
                                    </td>
                            </tr>
                            <!--/// BEGIN ROW 5 \\\-->
                            <tr>
                                    <td  width="290" height="350" valign="top" style="background: #101518;">
                                            <img width="290" height="241" style="display: block;" src="http://www.staging.fishgate.co.za/fg_mailer/fg_mailer_20.jpg" alt="eurolux" />
                                            <p style="margin-left: 20px; margin-right: 20px; font-family: Arial, sans-serif; font-weight: normal; font-size: 12px; color: #597781;">Step into a world of infinite possibilities, a world where ideas are king and hold</p>
                                            <table>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_green.jpg" alt="green arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #b2d233; margin-left: 5px;"><a href="#" style="text-decoration: none; color: #b2d233;">View More</a></p>
                                                            </td>
                                                    </tr>
                                            </table>
                                    </td>
                                    <td  width="290" height="350" valign="top" style="background: #101518;">
                                            <img width="290" height="5" style="display: block;" src="http://www.staging.fishgate.co.za/fg_mailer/fg_mailer_10.jpg" alt="decoration" />
                                            <h1 style="margin-left: 20px; margin-right: 20px; margin-top: 35px; font-family: Arial, sans-serif; font-weight: normal; font-size: 16px; color: #abbec4;">TTL AGENCY</h1>
                                            <table>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #597781; margin: 0;">Brand Strategy and Management</p>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #597781; margin: 0;">Media Relations</p>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #597781; margin: 0;">Public Relations and Marketing</p>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #597781; margin: 0;">Online Marketing</p>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #597781; margin: 0;">Advertising</p>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #597781; margin: 0;">Design</p>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #597781; margin: 0;">Digital</p>
                                                            </td>
                                                    </tr>
                                            </table>

                                            <table>
                                                    <tr>
                                                            <td style="padding-left: 20px;">
                                                                    <img width="4" height="6" src="http://www.staging.fishgate.co.za/fg_mailer/arrow_blue.jpg" alt="blue arrow" />
                                                            </td>
                                                            <td>
                                                                    <p style="font-family: Arial, sans-serif; font-weight: normal; font-size: 13px; color: #5cdefe; margin-left: 5px;"><a href="#" style="text-decoration: none; color: #5cdefe;">Read More</a></p>
                                                            </td>
                                                    </tr>
                                            </table>
                                    </td>
                            </tr>
                            <!--/// BEGIN ROW 6 \\\-->
                            <tr>
                                    <td colspan="2" valign="top" style="background: #101518;">
                                            <p style="margin-left: 20px; margin-right: 20px; margin-top: 20px; font-family: Arial, sans-serif; font-weight: normal; font-size: 12px; color: #597781; text-align: center;">Tyger Falls, Falcon Crest, Shop 5A | Bellville, Cape Town. 7530<br />Tel: 021 914 4054 | Fax: 021 914 4043</p>
                                            <p style="margin-left: 20px; margin-right: 20px; margin-bottom: 20px; font-family: Arial, sans-serif; font-weight: normal; font-size: 12px; color: #597781; text-align: center;"><a href="#" style="text-decoration: none; color: #5cddfc;">www.fishgate.co.za</a></p>
                                    </td>
                            </tr>
                    </table>
            </body>
            </html>
         ';
        
        $this->phpmailer->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$this->phpmailer->Send()) {
            echo 'Message could not be sent. Mailer Error: ' . $this->phpmailer->ErrorInfo;            
        }else{
            echo trim('success');
        }
    }
    
}
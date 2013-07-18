<?php

define('DB_HOST',       'localhost');
define('DB_NAME',       'fishgate-profile-mailer');
define('DB_USERNAME',   'root');
define('DB_PASSWORD',   '');
define('DB_LOGS_TBL',   'emaillogs');

$dbConnect = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
$dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {    
    $token = trim($_GET['token']);
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $host = gethostbyaddr($ip_address);
    
    
    $update = $dbConnect->prepare("UPDATE emaillogs SET opened='1', ip=:ip, host=:host WHERE token=:token;");
    $update->bindParam(':token',$token);
    $update->bindParam(':ip', $ip_address);
    $update->bindParam(':host', $host);
    $update->execute();
        
} catch (PDOException $ex) {
    //
}

$trackergif = imagecreatefromgif('../img/services.gif');

header( 'Content-type: image/gif' );

imagegif($trackergif);

?>

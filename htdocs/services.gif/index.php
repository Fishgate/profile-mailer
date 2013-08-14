<?php

header('Content-type: image/gif');

require_once('../config.php');

$dbConnect = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
$dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {    
    @$token = trim($_GET['token']);
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $host = gethostbyaddr($ip_address);
    
    $update = $dbConnect->prepare("UPDATE ".DB_LOGS_TBL." SET opened='1', ip=:ip, host=:host WHERE token=:token;");
    $update->bindParam(':token',    $token);
    $update->bindParam(':ip',       $ip_address);
    $update->bindParam(':host',     $host);
    $update->execute();
        
} catch (PDOException $ex) {
    // silence is golden
}

$trackergif = imagecreatefromgif('../img/services.gif');

imagegif($trackergif);


?>

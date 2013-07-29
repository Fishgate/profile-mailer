<?php require_once('./config.php'); ?>

<?php

$mail = new Mailer();
if($mail->quickSend()){
    echo 'success';
}

?>
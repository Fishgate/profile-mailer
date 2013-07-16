<?php require_once('./config.php'); ?>

<?php

$mail = new Mailer();

$mail->quickSend();

?>
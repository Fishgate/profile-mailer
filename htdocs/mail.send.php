<?php require_once('./config.php'); ?>

<?php

$mail = new Mailer();
$mail->template_name = $_POST['template'];
$mail->tracking_string_match = '[tracking_string]';
$mail->recipient_address = $_POST['email'];
$mail->email_subject = $_POST['subject'];

try {
    if($mail->quickSend()){
        echo 'success';
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>
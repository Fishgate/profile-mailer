<?php require_once('./config.php'); ?>

<?php

$mail = new Mailer();

try {
    if($mail->quickSend()){
        echo 'success';
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>
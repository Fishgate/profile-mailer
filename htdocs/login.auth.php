<?php require_once('./config.php'); ?>

<?php

$user = new User();

try {
   if($user->validateUser($_GET['username'], $_GET['password'])){
       echo 'success';
   }
} catch (Exception $ex) {
    // just kill the script here, no need to log errors for failed login attempts
    die($ex->getMessage());
}


?>
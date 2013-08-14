<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->username = $_GET['username'];
$user->password = $_GET['password'];

try {
   if($user->validateUser($user->username, $user->password)){
       echo 'success';
   }
} catch (Exception $ex) {
    // just kill the script here, no need to log errors for failed login attempts
    die($ex->getMessage());
}


?>
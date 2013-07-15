<?php

require_once('./config.php');

$user = new User();
$user->validateUser($_GET['username'], $_GET['password']);

?>

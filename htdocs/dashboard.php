<?php require_once('./config.php'); ?>

<?php
$user = new User();
$user->authUser($_SESSION['user_auth']);

?>

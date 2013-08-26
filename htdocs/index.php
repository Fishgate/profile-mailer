<?php require_once('./config.php'); ?>

<?php

if(isset($_SESSION['user_auth'])){
    $user = new User();
    
    $user->sessionBool= $_SESSION['user_auth'];
    $user->defaultRedirect = 'dashboard.php';

    $user->autoRedirect();
}

?>

<!DOCTYPE html>
<html>
    <?php require_once('includes/head.php'); ?>
    
    <body>
        <h1 class="centered">
            <img src="img/logo.png" alt="Fishgate Logo" />
        </h1>
        <br />
        <p class="centered">Welcome to Fishgate Mailing system</p>
        <br />
        <form id="loginform" class="">
            <div id="decoration_index"></div>
            <input required="required" placeholder="Username" id="username" type="text" name="username" />
            <br />
            <input required="required" placeholder="Password" id="password" type="password" name="password" />
            <br />
            <input id="login" type="submit" value="Login" />
            <img id="loader" class="invisible right" alt="loader" src="img/loader_index.gif" /><!-- replace this with some kind of loading gif -->
        </form>
        
<?php require_once('includes/footer.php'); ?>

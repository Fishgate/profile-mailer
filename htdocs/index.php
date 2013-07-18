<?php require_once('./config.php'); ?>

<!DOCTYPE html>
<html>
    <?php require_once('./head.php'); ?>
    
    <body>
        <h1 class="centered">
            <img src="img/logo.png" alt="Fishgate Logo" />
        </h1>
        <p class="centered">Profile Mailer System</p>
        <form id="loginform" class="">
            <input placeholder="Username" id="username" type="text" name="username" />
            <br />
            <input placeholder="Password" id="password" type="password" name="password" />
            <br />
            <input id="login" type="button" value="Login" />
            <img id="loader" class="invisible right" alt="loader" src="img/loader.gif" /><!-- replace this with some kind of loading gif -->
        </form>
        
    </body>
</html>

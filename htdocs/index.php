<?php require_once('./config.php'); ?>

<!DOCTYPE html>
<html>
    <?php require_once('./head.php'); ?>
    
    <body>
        <h2>Login</h2>
        <form id="loginform">
            Username: <input id="username" type="text" name="username" />
            Password: <input id="password" type="password" name="password" />
            <input id="login" type="button" value="Login" />
        </form>
        
    </body>
</html>

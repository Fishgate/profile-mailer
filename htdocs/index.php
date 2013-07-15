<?php require_once('./config.php'); ?>

<!DOCTYPE html>
<html>
    <?php require_once('./head.php'); ?>
    
    <body>
        <h1>Login</h1>
        <form id="loginform">
            Username: <input id="username" type="text" name="username" />
            Password: <input id="password" type="password" name="password" />
            <input id="login" type="button" value="Login" />
            <img id="loader" class="invisible" alt="loader" src="http://placehold.it/40x40" /><!-- replace this with some kind of loading gif -->
        </form>
        
    </body>
</html>

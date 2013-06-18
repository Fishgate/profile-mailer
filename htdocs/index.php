<?php require_once('./config.php'); ?>

<!DOCTYPE html>
<html>
    <?php require_once('./head.php'); ?>
    <body>
        <h2>Login</h2>
        <form id="loginform">
            Username: <input type="text" name="username" />
            Password: <input type="password" name="password" />
            <input type="button" value="Login" />
        </form>
        <?php
            
        $user = new User();
        
        $user->validateUser('admin', 'gyqqkx540');
        
        ?>
    </body>
</html>

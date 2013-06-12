<?php 

require_once('./config.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Fishgate Profile Mailer</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h2>Login</h2>
        <form id="loginform">
            Username: <input type="text" name="username" />
            Password: <input type="password" name="password" />
            <input type="button" value="Login" />
        </form>
        <?php
            
        $user = new User();
        
        ?>
    </body>
</html>

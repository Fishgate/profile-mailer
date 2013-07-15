<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->authUser($_SESSION['user_auth']);

?>

<!DOCTYPE html>
<html>
    <?php require_once('./head.php'); ?>
    
    <body>
        <h1>Dashboard</h1>
        
        <h2>Navigation</h2>
        <ul id="dash-nav">
            <li>New mass mail</li>
            <li>Import list</li>
            <li>Manage lists</li>
            <li>View full logs</li>
        </ul>
        
        <h2>Quick send</h2>
        <form>
            Name:<br /> <input id="name" name="name" type="text" />
            <br />
            Email:<br /> <input id="email" name="email" type="text" />
            <br />
            Message:<br /> <textarea name="message" id="tinymce">We know your field, so i thought that I would email you. We are an award winning PR and advertising agency that understands how to get people talking and buying. Lets us put some ideas together for you. We do everything under one roof. Capable and inventive - we would like the opportunity to prove it. I would be happy to come in and chat to you about your current promotional activities and provide you with some real, free, market research.</textarea>
            <br />
            <input type="button" id="send" value="Send" />
            <img id="loader" class="invisible" alt="loader" src="http://placehold.it/40x40" /><!-- replace this with some kind of loading gif -->
        </form>
        
        <h2>Recent Emails</h2>
        <table border="1">
            <tr>
                <td>To</td>
                <td>Email</td>
                <td>Date</td>
                <td>Opened</td>
            </tr>
            <tr>
                <td>John Doe</td>
                <td>john@doe.com</td>
                <td>17-07-2013</td>
                <td>&#x2713;</td>
            </tr>
            <tr>
                <td>Jane Doe</td>
                <td>jane@doe.com</td>
                <td>18-07-2013</td>
                <td>&#x2717</td>                
            </tr>
        </table>
        
    </body>
</html>
<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->authUser($_SESSION['user_auth']);

?>

<!DOCTYPE html>
<html>
    <?php require_once('./head.php'); ?>
    
    <body>
        
        <!--==================================== NAVIGATION ===========-->
            <nav class="centered">
                <div class="decoration"></div>
                <div id="menutitle">menu</div>
                <ul id="dash-nav">
                    <li>New mass mail</li>
                    <li id="selected">Import list</li>
                    <li>Manage lists</li>
                    <a href="logs.php"><li>View full logs</li></a>
                </ul>
            </nav>
        
        <div id="wrapper" class="clearfix">
            
            <!--==================================== CONTENTS ===========-->
            <div class="contents">
                <div id="importlist" class="left">
                    <form id="importlistform" enctype="multipart/form-data">
                        <h2>Import List</h2>
                        <input type="file" />
                        <input type="button" value="Upload" />
                    </form>
                </div>
            </div>
            
        </div>    
    </body>
</html>
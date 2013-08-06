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
                    <a href="managelist.php"><li>Manage lists</li></a>
                    <a href="logs.php"><li>View full logs</li></a>
                </ul>
            </nav>
        
        <div id="wrapper" class="clearfix">
            
            <?php include 'includes/branding.html' ?>
            
            <!--==================================== CONTENTS ===========-->
            <div class="contents clearfix">
                <div id="importlist" class="left">
                    <!--<form id="importlistform" enctype="multipart/form-data" method="POST" action="import.exec.php">-->
                    <form id="importlistform" enctype="multipart/form-data">
                        <h2>Import List</h2>
                        <input name="file" id="fileupload" type="file" />
                        <input id="upload" type="button" value="Upload" />
                        <!--<input type="submit" value="Upload" />-->
                    </form>
                </div>
            </div>
            
        </div>    
    </body>
</html>
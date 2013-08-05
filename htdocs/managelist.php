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
                    <a  href="importlist.php"><li>Import list</li></a>
                    <li id="selected">Manage lists</li>
                    <a href="logs.php"><li>View full logs</li></a>
                </ul>
            </nav>
        
        <div id="wrapper" class="clearfix">
            
            <!--==================================== CONTENTS ===========-->
            <div class="contents">
                <div id="importlist" class="left">
                    <form id="importlistform" enctype="multipart/form-data">
                        <h2>Import List</h2>
                        <input id="fileupload" type="file" />
                        <input id="upload" type="button" value="Upload" />
                    </form>
                </div>
            </div>
            
        </div>    
    </body>
</html>
<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->sessionBool = $_SESSION['user_auth'];
$user->authUser();

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
                    <form id="importlistform" enctype="multipart/form-data">
                        <h2>Import List</h2>
                        <input required="required" id="listname" name="listname" type="text" placeholder="List Name" />
                        <input name="file" id="fileupload" type="file" />
                        <em>Max file size 2MB. Supported file types include CSV and XLS</em>                        
                        <input id="upload" type="submit" value="Upload" />
                    </form>
                </div>
            </div>
            
        </div>   
        
<?php require_once('footer.php'); ?>
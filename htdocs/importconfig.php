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
            <nav>
                <div class="decoration"></div>
                <div id="menutitle" class="centered">menu</div>
                <ul id="dash-nav">
                    <li>
                        <span class="icons menu_icons">C</span>
                        New mass mail
                    </li>
                    <a href="importlist.php">
                        <li>
                            <span class="icons menu_icons">w</span>
                            Import list
                        </li>
                    </a>
                    <a href="managelist.php">
                        <li>
                            <span class="icons menu_icons">n</span>
                            Manage lists
                        </li>
                    </a>
                    <a href="logs.php">
                        <li>
                            <span class="icons menu_icons">g</span>
                            View full logs
                        </li>
                    </a>
                </ul>
                
                <div id="techs" class="clearfix">
                    <span class="left icons">q</span>
                    <span class="left icons">r</span>
                    <span class="left icons">s</span>
                </div>
            </nav>
        
        <div id="wrapper" class="clearfix">
            
            <?php include 'includes/branding.html' ?>
            
            <!--==================================== CONTENTS ===========-->
            <div class="contents clearfix">
                
            </div>
            
        </div>   
        
<?php require_once('footer.php'); ?>

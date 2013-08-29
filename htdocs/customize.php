<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->sessionBool = $_SESSION['user_auth'];
$user->authUser();

?>

<!DOCTYPE html>
<html>
    <?php require_once('includes/head.php'); ?>
    
    <body>
            <!--============================
            MODAL - MENU HEADING
            ==============================-->
            <div id="modal-menu-heading" class="reveal-modal">
                <h2>Customise your Menu Heading Background</h2>
                <div class="clearfix">
                    <div class="left">
                        Example:
                        <img src="img/customise/menu_heading.jpg" />
                    </div>
                    <div class="left">
                        <form action="">
                                <label for="color">Color:</label>
                                <input type="color" id="color" name="color" value="#123456" />
                        </form>
                    </div>
                </div>
                <a class="close-reveal-modal">&#215;</a>
            </div>
            <!--==================================== NAVIGATION ===========-->
            <nav class="centered">
                <div class="decoration_custom"></div>
                <a data-reveal-id="modal-menu-heading">
                    <span class="icons_custom">u</span>
                
                    <div id="menu_custom" class="custom">
                        menu
                    </div>
                </a>
                <ul id="dash-nav">
                    <a href="dashboard.php">
                        <li>
                            <span class="icons menu_icons">F</span>
                            Dashboard
                        </li>
                    </a>
                    <li>
                        <span class="icons menu_icons">C</span>
                        New mass mail
                    </li>
                    <li id="selected_custom" class="custom">
                        <span class="icons_custom">u</span>
                        <span class="icons menu_icons">w</span>
                        Import list
                    </li>
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
        
        <div id="wrapper" class="clearfix custom_bg_dark">
            
            
            <span style="position: fixed; top: 130px;" class="icons_custom">u</span>
            <span style="position: fixed;" class="icons_custom">u</span>
            
            <div id="branding_custom" class="custom">
                <img src="img/logo.png"/>
            </div>
            
            <!--==================================== CONTENTS ===========-->
            <div class="contents clearfix">
                <div id="importlist" class="left">                   
                    <form id="importlistform" enctype="multipart/form-data">
                        <h2 class="custom">
                            <span class="icons_custom">u</span>
                            Import List
                        </h2>
                        <div style="position: relative;">
                            <span class="icons_custom">u</span>
                        <input id="upload" class="custom_bg" type="submit" value="Upload" />
                        </div>
                    </form>
                </div>
                
            </div>
            
        </div>   
        
<?php require_once('includes/footer.php'); ?>

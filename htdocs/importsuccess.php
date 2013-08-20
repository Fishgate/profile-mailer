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
                <div id="importlist" class="left">                   
                    <form id="quickaccess_import">
                        <h2>Quick-Access Menu</h2>
                        <div id="logs_menu">
                            <form method="post" action="">
                                <select>
                                    <option>Please make a selection</option>
                                    <option>View</option>
                                    <option>Manage</option>
                                    <option>Send</option>
                                </select>
                                <br />
                                <input type="button" value="GO!">
                            </form>
                        </div>
                    </form>
                </div>
                <!--=========== STEPS INDICATOR ============-->
                <div id="success_import" class="left clearfix">
                    <span class="icons green success_icon">m</span>
                    <h2 class="success">Success!</h2>
                    <div class="noticeDiv">
                        <p>Everything checked out, your list has been imported!<p>
                        <p>On the left you will find a Quick-Access Menu to <a href="#">View</a>, <a href="#">Manage</a> and <a href="#">Send</a> to your imported list.</p>
                    </div>
<!--                    <a class="successLinks green_bg white right">Send</a>
                    <a class="successLinks green_bg white right">Manage</a>
                    <a class="successLinks green_bg white right">View</a>-->
                </div>
            </div>
            
        </div>   
        
<?php require_once('footer.php'); ?>

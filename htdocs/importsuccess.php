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
                    <h2 class="success">SUCCESS!</h2>
                    <div class="noticeDiv">
                        <p>Everything checked out, your list has been imported!<p>
                        <p>On the left you can choose from some quick-access links to <a href="#">View</a>, <a href="#">Manage</a> and <a href="#">Send</a> to your imported list.</p>
                    </div>
<!--                    <a class="successLinks green_bg white right">Send</a>
                    <a class="successLinks green_bg white right">Manage</a>
                    <a class="successLinks green_bg white right">View</a>-->
                </div>
            </div>
            
        </div>   
        
<?php require_once('footer.php'); ?>

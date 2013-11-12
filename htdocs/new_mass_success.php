<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->sessionBool = $_SESSION['user_auth'];
$user->authUser();

$reports = new Reports();
$quicksend_total = $reports->get_quicksend_total();
$quicksend_opened = $reports->get_quicksend_opened();
$quicksend_unopened = $reports->get_quicksend_unopened();

$mail = new Mailer();

?>

<!DOCTYPE html>
<html>
    <?php require_once('includes/head.php'); ?>
    
    <body>       
        <!--==================================== NAVIGATION ===========-->
            <nav class="centered">
                <div class="decoration"></div>
                <div id="menu">menu</div>
                <ul id="dash-nav">
                    <a href="dashboard.php">
                        <li>
                            <span class="icons menu_icons">F</span>
                            Dashboard
                        </li>
                    </a>
                        <li id="selected">
                            <span class="icons menu_icons selected_icon">C</span>
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
                
                <!--=========== STEPS INDICATOR ============-->
                <!--<h2>Progress</h2>-->
                <div id="stepsHolder" class="clearfix">
                    <a href="new_mass.php">
                        <div class="left steps">
                            <div class="hidden stepsDecoration  currentStep_decoration"></div>
                            <div class="hidden stepsDecoration_mirror"></div>
                            TEMPLATE
                        </div>
                    </a>
                    <a href="new_mass_list.php">
                        <div class="left steps">
                            <div class="hidden stepsDecoration  currentStep_decoration"></div>
                            <div class="hidden stepsDecoration_mirror"></div>
                            MAILING LIST
                        </div>
                    </a>
                    <a href="new_mass_match.php">
                        <div class="left steps">
                            MATCH SHORT-CODES
                        </div>
                    </a>
                    <div class="left steps currentStep">
                        VALIDATION
                    </div>
                </div>
                
                <div id="new_mass_validation_holder" class="clearfix">
                    <h2>SUCCESS!</h2>
                        <div class="recents">
                            <table border="1" width="100%" cellpadding="5">
                                <tr id="quicksendLogHeaders">
                                    <td class="recent_heads">Template</td>
                                    <td class="recent_heads">Mailing List</td>
                                    <td class="recent_heads">Short-codes</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="icons green">h</span>
                                        <p>Template_name_here</p>
                                    </td>
                                    <td>
                                        <span class="icons green">h</span>
                                        <p>Mailing list name</p>
                                        <p>Containing 512 recipients</p>
                                    </td>
                                    <td>
                                        <span class="icons green">h</span>
                                        <p>4 short-codes found</p>
                                        <p>
                                           4 assigned:
                                           <br />[name] => Name
                                           <br />[lastname] => Last_Name
                                           <br />[email] => Email
                                           <br />[message] => Message
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    <br />
                    <a href="#">
                        <div class="btn right">Send Campaign</div>
                    </a>
                </div>
                
                
            </div><!--.content close-->
            
        </div><!--#wrapper close-->
        
<?php require_once('includes/footer.php'); ?>
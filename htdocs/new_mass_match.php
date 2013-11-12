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
                    <div class="left steps currentStep">
                        MATCH SHORT-CODES
                    </div>
                </div>
                
                <div id="new_mass_holder">                   
                    <form id="new_mass_template"><!-- enctype="multipart/form-data" -->
                        <h2>Match Short-Codes</h2>
                        
                        <table id="match_shortcodes" width="100%" cellspacing="5">
                            <tr>
                                <th>Short-Code</th>
                                <th>Assignment</th>
                            </tr>
                            <tr>
                                <td><span class="shortcode">[name]</span></td>
                                <td class="selecter">
                                    <div class="icons dropdown">5</div>
                                    <select>
                                        <option>-- Choose one --</option>
                                        <option>Name</option>
                                        <option>Last Name</option>
                                        <option>Email</option>
                                        <option>Message</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- short code -->
                            <tr>
                                <td><span class="shortcode">[email]</span></td>
                                <td class="selecter">
                                    <div class="icons dropdown">5</div>
                                    <select>
                                        <option>-- Choose one --</option>
                                        <option>Name</option>
                                        <option>Last Name</option>
                                        <option>Email</option>
                                        <option>Message</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        
                        <input class="left" type="button" id="prev" value="Back" />
                        <input class="right" type="submit" id="new_mass_finish" value="Finish" />
                    </form>
                </div>
          
                
            </div><!--.content close-->
            
        </div><!--#wrapper close-->
        
<?php require_once('includes/footer.php'); ?>
<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->sessionBool = $_SESSION['user_auth'];
$user->authUser();



if(isset($_GET['id']) && !empty($_GET['id'])){
    $editList = new EditList();
    $editList->refID = mysql_real_escape_string($_GET['id']);
    
}

?>

<!DOCTYPE html>
<html>
    <?php require_once('includes/head.php'); ?>
    
    <body>
        
        <!--==================================== NAVIGATION ===========-->
            <nav>
                <div class="decoration"></div>
                <div id="menu" class="centered">menu</div>
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
                    <a href="importlist.php">
                        <li id="selected">
                            <span class="icons menu_icons selected_icon">w</span>
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
                <!--  -->
                <!--=========== STEPS INDICATOR ============-->
                <!--<h2>Progress</h2>-->
                    <div id="stepsHolder" class="clearfix">
                        <div class="left steps">
                            <div class="hidden stepsDecoration  currentStep_decoration"></div>
                            <div class="hidden stepsDecoration_mirror"></div>
                            IMPORT
                        </div>
                        <div class="left steps currentStep">
                            <div class="stepsDecoration  currentStep_decoration"></div>
                            <div class="stepsDecoration_mirror"></div>
                            CONFIGURE
                        </div>
                        <div class="left steps">
                            <div class="hidden stepsDecoration  currentStep_decoration"></div>
                            <div class="hidden stepsDecoration_mirror"></div>
                            COMPLETED!
                        </div>
                    </div>
                <!--  -->
                <div class="left managelist_holder">
                    <h3>Rename Headers</h3>
                    <form method="post">
                    <div class="managelist_table">
                        
                        <div id="action_buttons" class="clearfix">
                            <div class="left button add green_bg">Add entry</div>
                            <div class="right button delete red_bg">Remove selected</div>
                        </div>
                        
                        <!-- come back to this later
                        <div id="add_holder" class="clearfix">
                            <table border="1" width="100%" cellpadding="5">
                            <tr>
                                <td class="recent_heads">Name</td>
                                <td class="recent_heads">Email</td>
                            </tr>
                            <tr>
                                <td><input type="text" name="add_name" class="name" placeholder="Name*" list="add_name" /></td>
                                <td><input type="text" name="add_email" class="email" placeholder="Email address*" list="add_email" /></td>
                            </tr>
                            </table>
                            <div class="right button asphalt_bg ok">OK</div>
                            <div class="right button midnight_bg another">Add another</div>
                        </div>
                        -->
                        
                    </div>
                    <div class="right button blue_bg save">Save my changes</div>
                    </form>
                </div>
                <!--  -->
            </div>
            </div>
            
        </div>   
        
<?php require_once('includes/footer.php'); ?>

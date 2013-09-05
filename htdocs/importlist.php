<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->sessionBool = $_SESSION['user_auth'];
$user->authUser();

$alerts = new Alerts();

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
                    <li>
                        <span class="icons menu_icons">C</span>
                        New mass mail
                    </li>
                    <li id="selected">
                        <span class="icons menu_icons selected_icon">w</span>
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
        
        <div id="wrapper" class="clearfix">
            
            <?php include 'includes/branding.html' ?>
            
            <!--==================================== CONTENTS ===========-->
            <div class="contents clearfix">
                <!--=========== STEPS INDICATOR ============-->
                <!--<h2>Progress</h2>-->
                <div id="stepsHolder" class="clearfix">
                    <div class="left steps currentStep">
                        <div class="stepsDecoration  currentStep_decoration"></div>
                        <div class="stepsDecoration_mirror"></div>
                        IMPORT
                    </div>
                    <div class="left steps">
                        <div class="hidden stepsDecoration  currentStep_decoration"></div>
                        <div class="hidden stepsDecoration_mirror"></div>
                        CONFIGURE
                    </div>
                    <div class="left steps">
                        <div class="hidden stepsDecoration  currentStep_decoration"></div>
                        <div class="hidden stepsDecoration_mirror"></div>
                        COMPLETED!
                    </div>
                </div>
                
                <div id="importlist">                   
                    <form id="importlistform" enctype="multipart/form-data">
                        <h2>Import List</h2>
                        
                        <input required="required" id="listname" name="listname" type="text" placeholder="List Name" />
                        <textarea id="list_acquired" name="list_acquired" required="required" placeholder="How was this list acquired?"></textarea>
                        
                        <p><em><?php echo $alerts->SPAM_WARNING; ?></em></p>
                        
                        <input name="file" id="fileupload" type="file" />
                        
                        <input id="upload" type="submit" value="Upload" />
                        
                        <em><?php echo $alerts->UPLOAD_WARNING; ?></em>
                        
                        <br />                        
                        
                        <img id="importLoader" class="invisible right switch_loader" alt="loader" src="img/loader.gif" />
                    </form>
                </div>
            </div>
                       
        </div><!--#wrapper close--> 
        
<?php require_once('includes/footer.php'); ?>

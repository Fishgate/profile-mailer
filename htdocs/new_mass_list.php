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
                    <div class="left steps">
                        <div class="hidden stepsDecoration  currentStep_decoration"></div>
                        <div class="hidden stepsDecoration_mirror"></div>
                        TEMPLATE
                    </div>
                    <div class="left steps currentStep">
                        <div class="stepsDecoration  currentStep_decoration"></div>
                        <div class="stepsDecoration_mirror"></div>
                        MAILING LIST
                    </div>
                    <div class="left steps">
                        <div class="hidden stepsDecoration  currentStep_decoration"></div>
                        <div class="hidden stepsDecoration_mirror"></div>
                        MATCH SHORT-CODES
                    </div>
                </div>
                
                <div id="new_mass_holder">                   
                    <form id="new_mass_template"><!-- enctype="multipart/form-data" -->
                        <h2>Select Mailing List</h2>
                        
                        <select name="template" id="template">
                            <option value="0">--Select Template--</option>
                            
                            <?php

                            $mail_templates = $mail->getTemplates();

                            foreach($mail_templates as $file){
                                $filename = $file->getFileName();

                                if($filename != '.' && $filename != '..'){
                                    ?>
                                    <option value="<?php echo $filename; ?>"><?php echo $filename; ?></option>
                                    <?php
                                }
                            }

                            ?>
                        </select>
                        
                        <img id="templateSelectLoader" class="hidden right switch_loader" alt="loader" src="img/loader.gif" />
                        
                        <div id="form_elements"><p>No template currently selected.</p></div>
                        
                        
                        <center>- OR -</center>
                        
                        <h2>Import List</h2>
                        
                        <input required="required" id="listname" name="listname" type="text" placeholder="List Name" />
                        <textarea id="list_acquired" name="list_acquired" required="required" placeholder="How was this list acquired?"></textarea>
                        
                        <p><em><?php echo $alerts->SPAM_WARNING; ?></em></p>
                        
                        <input name="file" id="fileupload" type="file" />
                        
                        <input id="upload" type="submit" value="Upload" />
                        
                        <em><?php echo $alerts->UPLOAD_WARNING; ?></em>
                        
                        <br />                        
                        
                        <img id="importLoader" class="invisible right switch_loader" alt="loader" src="img/loader.gif" />
                        
                        <input class="right" type="button" id="next" value="Next" />                        
                        <img id="quickSendLoader" class="invisible right" alt="loader" src="img/loader.gif" />
                    </form>
                </div>
          
                
            </div><!--.content close-->
            
        </div><!--#wrapper close-->
        
<?php require_once('includes/footer.php'); ?>
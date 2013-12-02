<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->sessionBool = $_SESSION['user_auth'];
$user->authUser();

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
                    <as>
                        <div class="left steps currentStep">
                            <div class="stepsDecoration  currentStep_decoration"></div>
                            <div class="stepsDecoration_mirror"></div>
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
                </div>
                
                <div id="new_mass_holder">                   
                    <form id="new_mass_template">`
                        <h2>Select Template</h2>
                        
                        <select name="mass_template" id="mass_template">
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
                        
                        <input class="right" type="button" id="next" value="Next &rang;" />
                        
                        <img id="quickSendLoader" class="invisible right" alt="loader" src="img/loader.gif" />
                    </form>
                </div>
          
                
            </div><!--.content close-->
            
        </div><!--#wrapper close-->
        
<?php require_once('includes/footer.php'); ?>
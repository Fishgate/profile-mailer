<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->sessionBool = $_SESSION['user_auth'];
$user->authUser();

$alerts = new Alerts();

$id_set = false;

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id_set = true;
    
    $editList = new EditList();    
    $editList->tableRefID = mysql_real_escape_string($_GET['id']);
   
    try {
        $tbl_data = $editList->getTableData();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
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
                    <h3>Configure List</h3>
                    
                    <?php if($id_set) { ?>
                        <p><em><?php echo $alerts->IMPORT_CONF_INSTRUCTIONS; ?></em></p>

                        <form method="post" action="importconfig.exec.php" id="importconfigform">
                            <input type="hidden" name="workingTable" value="<?php echo $editList->getWorkingTable(); ?>" />


                                <div class="managelist_table">
                                    <table border="1">
                                        <tr>
                                            <td>Delete</td>
                                            <?php
                                                $totalCols = count($tbl_data[0]) - 1;

                                                for($i=1; $i<=$totalCols; $i++){
                                                    echo "<td><input class=\"colNames\" name=\"temp_$i\" type=\"text\"></td>";
                                                }
                                            ?>
                                        </tr>

                                        <?php foreach ($tbl_data as $data) { ?>
                                            <tr>
                                                <?php foreach ($data as $key => $val) { ?>
                                                    <td>
                                                        <?php
                                                            if($key == "id"){
                                                                echo "<input type=\"checkbox\" class=\"deleteRow\" name=\"delete[]\" value=\"$val\" />";
                                                            }else{
                                                                echo $val;
                                                            }
                                                        ?>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </table>

                                <!-- 
                                come back to this later (adding new entries into the table)

                                <div id="action_buttons" class="clearfix">
                                    <div class="left button add green_bg">Add entry</div>
                                    <div class="right button delete red_bg">Remove selected</div>
                                </div>


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

                            <input id="update" type="submit" value="Update List" />

                            <img id="importconfigLoader" class="invisible right switch_loader" alt="loader" src="img/loader.gif" />
                        </form>
                    
                    <?php }else{ ?>
                        <p><em><?php echo $alerts->IMPORT_CONF_NO_TBL . $editList->tableRefID; ?></em></p>
                    <?php } ?>
                </div>
            </div>
            </div>
            
        </div>   
        
<?php require_once('includes/footer.php'); ?>

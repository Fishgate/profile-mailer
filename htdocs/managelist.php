<?php require_once('./config.php'); ?>

<?php
$user = new User();
$user->sessionBool = $_SESSION['user_auth'];
$user->authUser();

$reports = new Reports();

?>

<!DOCTYPE html>
<html>
    <?php require_once('includes/head.php'); ?>
    
    <body>
        <!--==============================================================
                            DATALIST FOR INPUTS
        ==================================================================-->
        <datalist id="add_name">
            <option value="John Doe [EXAMPLE NAME]">
            <option value="Clients Name [EXAMPLE NAME]">
        </datalist>
        
        <datalist id="add_email">
            <option value="name@mail.com [EXAMPLE EMAIL]">
                <option value="client@mail.com [EXAMPLE EMAIL]">
        </datalist>
        
        
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
                    <a href="new_mass.php">
                    <li>
                        <span class="icons menu_icons">C</span>
                        New mass mail
                    </li>
                    </a>
                    <a href="importlist.php">
                        <li>
                            <span class="icons menu_icons">w</span>
                            Import list
                        </li>
                    </a>
                        <li id="selected">
                            <span class="icons menu_icons selected_icon">n</span>
                            Manage lists
                        </li>
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
                <div id="logs_menu_holder" class="left">
                    <h2>Lists Archive</h2>
                    <div id="logs_menu">
                        <form method="post" action="">
                            <select>
                                <option>Please make a selection</option>
                                <option>Clients 2013</option>
                                <option>Year-End 2013</option>
                                <option>Fishgate invitation 2013</option>
                            </select>
                            <br />
                            <input type="button" value="View List Details">
                        </form>
                    </div>
                </div>
                
                <div class="left managelist_holder">
                    <h3>Comprehensive View</h3>
                    <form method="post">
                    <div class="managelist_table">
                        
                        <table border="1" width="100%" cellpadding="5">
                            <tr>
                                <td class="recent_heads">To</td>
                                <td class="recent_heads">Email</td>
                                <td class="recent_heads">Date</td>
                                <td class="recent_heads">Opened</td>
                                <td class="recent_heads">Action</td>
                            </tr>
                            
                            <?php

                            try {
                                if($email_logs = $reports->quicksend_logs()){
                                    foreach($email_logs as $log){
                                        ?>
                                        <tr>
                                            <td><?php echo $log['email']; ?></td>
                                            <td><?php echo $log['template']; ?></td>
                                            <td><?php echo $log['date']; ?></td>
                                            <td align="center">
                                                <?php 
                                                if($log['opened']){
                                                    echo '<span class="icons green">h</span>';
                                                }else{
                                                    echo '<span class="icons red">i</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            } catch (Exception $ex) {
                                ?>
                                <tr>
                                    <td colspan="4"><?php echo $ex->getMessage(); ?></td>
                                </tr>
                                <?php
                            }

                            ?>
                        </table>
                        
                        <div id="action_buttons" class="clearfix">
                            <div class="left button add green_bg">Add entry</div>
                            <div class="right button delete red_bg">Remove selected</div>
                        </div>
                        
                        <script>
                            //============================ SHOW ADD ENTRY TABLE
                            $('.add').click(function(){
                                $('#add_holder').removeClass('hidden');
                            });
                            //============================ HIDE ADD ENTRY TABLE
                            $('.ok').live('click', function(){
                                $('#add_holder').addClass('hidden');
                                //--- GROWL examples
                                //$.growl.notice({message: 'YOUR NOTICE HERE'});
                                //$.growl.warning({message: 'YOUR WARNING HERE'});
                                //$.growl.error({message: 'YOUR ERROR HERE'});
                                $.growl.notice({message: 'Extra entries added!'});
                            });
                            
                            //simulate deletion
                            $('.delete').click(function(){
                                $.growl.error({message: 'row/s deleted'});
                            });
                            
                        </script>
                        
                        <div id="add_holder" class="clearfix hidden">
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
                        
                    </div>
                    <div class="right button blue_bg save">Save my changes</div>
                    </form>
                </div>
            </div>
        </div>
        
<?php require_once('includes/footer.php'); ?>

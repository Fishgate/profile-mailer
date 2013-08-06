<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->authUser($_SESSION['user_auth']);

$mail = new Mailer();

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
                    <a  href="importlist.php"><li>Import list</li></a>
                    <li id="selected">Manage lists</li>
                    <a href="logs.php"><li>View full logs</li></a>
                </ul>
            </nav>
        
        <div id="wrapper" class="clearfix">
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
                                if($email_logs = $mail->outputLogs()){
                                    foreach($email_logs as $log){
                                        ?>
                                        <tr>
                                            <td><?php echo $log['name']; ?></td>
                                            <td><?php echo $log['email']; ?></td>
                                            <td><?php echo $log['date']; ?></td>
                                            <td align="center">
                                                <?php 
                                                if($log['opened']){
                                                    echo '<span style="color: green;">&#x2713;</span>';
                                                }else{
                                                    echo '<span style="color: red;">&#x2717;</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <input type="checkbox" clas="remove_row" />
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
                                <td><input type="text" name="add_name" class="name" /></td>
                                <td><input type="text" name="add_email" class="email" /></td>
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
    </body>
</html>
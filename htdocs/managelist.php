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
                    <div class="managelist_table">
                        <form method="post">
                        <table border="1" width="100%" cellpadding="5">
                            <tr>
                                <td class="recent_heads">Action</td>
                                <td class="recent_heads">To</td>
                                <td class="recent_heads">Email</td>
                                <td class="recent_heads">Date</td>
                                <td class="recent_heads">Opened</td>
                            </tr>
                            
                            <?php
                            
                            try {
                                if($email_logs = $mail->outputLogs()){
                                    foreach($email_logs as $log){
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" clas="remove_row" />
                                                Remove
                                            </td>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>    
    </body>
</html>
<?php require_once('./config.php'); ?>

<?php

$user = new User();
$user->authUser($_SESSION['user_auth']);

$reports = new Reports();
$quicksend_total = $reports->get_quicksend_total();
$quicksend_opened = $reports->get_quicksend_opened();
$quicksend_unopened = $reports->get_quicksend_unopened();

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
                    <a href="importlist.php"><li>Import list</li></a>
                    <a href="managelist.php"><li>Manage lists</li></a>
                    <a href="logs.php"><li>View full logs</li></a>
                </ul>
            </nav>
        
        <div id="wrapper" class="clearfix">
            <?php include 'includes/branding.html' ?>
            
            
            <!--==================================== CONTENTS ===========-->
            <div class="contents clearfix">
                <!--========================= QUICK SEND =========-->
                <div id="quicksend" class="left">
                    <form method="post" id="quicksendform" class="clearfix">
                        <h3>Quick send</h3>
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
                        
                        <!-- /// STATIC INPUTS \\\-->                        
                        <input id="email" name="email" type="email" placeholder="Email" />
                        <input id="subject" name="subject" type="text" placeholder="Subject" />
                        
                        <!-- /// SWITCHING TEMPLATES loader \\\-->
                        <img id="templateSelectLoader" class="hidden right switch_loader" alt="loader" src="img/loader.gif" />
                        
                        <div id="form_elements"><p>No template currently selected.</p></div>

                        <input class="right" type="submit" id="send" value="Send" />
                        
                        <!-- /// SENDING TEMPLATES loader \\\-->
                        <img id="quickSendLoader" class="invisible right" alt="loader" src="img/loader.gif" />
                    </form>
                </div>
                
                <div class="left recents_holder">
                    <h3>Recent Emails</h3>
                    <div class="recents">
                        <table border="1" width="100%" cellpadding="5">
                            <tr>
                                <td class="recent_heads">Email</td>
                                <td class="recent_heads">Template</td>
                                <td class="recent_heads">Date</td>
                                <td class="recent_heads">Opened</td>
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
                    </div>
                </div>
                
                <!--==========================================
                            OPEN/UNOPEN PIE CHART
                ================================================-->
                <div class="left" id="chart">
                    <h3>Quick Send Overview</h3>
                    
                    <div class="analytics clearfix">
                        <h4>Opened vs Unopened</h4>
                        <canvas class="left" id="canvas" height="250" width="250"></canvas>
                        <div id="stats_holder" class="left">
                            <div class="total_sent">
                                <div class="small_block blue_bg"></div> Total [<span class="blue"><?php echo $quicksend_total; ?></span>]
                            </div>
                            <div class="opened">
                                <div class="small_block green_bg"></div> Opened [<span class="green"><?php echo $quicksend_opened; ?></span>]
                            </div>
                            <div class="closed">
                                <div class="small_block red_bg"></div> Unopened [<span class="red"><?php echo $quicksend_unopened; ?></span>]
                            </div>
                        </div>
                    </div>
                    
                </div><!--#chart close -->
                
            </div><!--.content close-->
            
        </div><!--#wrapper close-->
        
        <script type="text/javascript">
        /* <![CDATA[ */
        var quicksend_data = {
            "opened" : <?php echo $quicksend_opened; ?>, 
            "unopened" : <?php echo $quicksend_unopened; ?>
        };
        /* ]]> */
        </script>
<?php require_once('footer.php'); ?>
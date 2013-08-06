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
                    <a href="importlist.php"><li>Import list</li></a>
                    <a href="managelist.php"><li>Manage lists</li></a>
                    <li id="selected">View full logs</li>
                </ul>
            </nav>
        
        <div id="wrapper" class="clearfix">
            
            <?php include 'includes/branding.html' ?>
            
            <!--==================================== CONTENTS ===========-->
            <div class="contents clearfix">
                <div id="logs_menu_holder" class="left">
                    <h2>Logs Filter Menu</h2>
                    <div id="logs_menu">
                        <form method="post" action="">
                            <select>
                                <option>Please make a selection</option>
                                <option>Quick Sends</option>
                                <option>Mass List Sends</option>
                            </select>
                            <br />
                            <input type="button" value="See Logs">
                        </form>
                    </div>
                </div>
                
                <div id="logs_overview_holder" class="left">
                    <h2>Quick Send Stats</h2>
                    <div id="logs_overview" class="clearfix">
                        <h4>Opened vs Unopened [Quick Sends]</h4>
                        <canvas class="left" id="canvas" height="250" width="250"></canvas>
                        <div id="stats_holder" class="left">
                            <div class="total_sent">
                                <div class="small_block blue_bg"></div> Total [<span class="blue">1234</span>]
                            </div>
                            <div class="opened">
                                <div class="small_block green_bg"></div> Opened [<span class="green">1024</span>]
                            </div>
                            <div class="closed">
                                <div class="small_block red_bg"></div> Unopened [<span class="red">119</span>]
                            </div>
                        </div>
                        <script>
                            //DRAWS A CHART -- *TEST
                            var pieData = [
                                {
                                    value: 17,//UNOPENED VALUE HERE
                                    color:"#E74C3C"
                                },
                                {
                                    value : 61,//OPENED VALUE HERE
                                    color : "#2ECC71"
                                }

                                ];

                            var myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData);
                        </script>
                    </div>
                </div>
                
                <div class="left recents_holder">
                    <h3>Comprehensive View</h3>
                    <div class="recents">
                        <table border="1" width="100%" cellpadding="5">
                            <tr>
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
                    </div>
                </div>
            </div>
            
        </div>    
    </body>
</html>
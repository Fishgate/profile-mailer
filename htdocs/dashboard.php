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
                    <a href="logs.php"><li>View full logs</li></a>
                </ul>
            </nav>
        
        <div id="wrapper" class="clearfix">
            <div id="branding" class="dark_bg">
                <img src="img/logo.png"/>
            </div>
            
            <!--==================================== CONTENTS ===========-->
            <div class="contents clearfix">
                <!--========================= QUICK SEND =========-->
                <div id="quicksend" class="left">
                    <form method="post" id="quicksendform" class="clearfix">
                        <h2>Quick send</h2>
                        Template:<br /> 
                        <select id="template">
                            <?php

                            $mail_templates = $mail->getTemplates();

                            foreach($mail_templates as $file){
                                $filename = $file->getFileName();

                                if($filename != '.' && $filename != '..'){
                                    ?>
                                    <option value="<?php echo $filename; ?>"><?php echo $filename; ?></option>";
                                    <?php
                                }
                            }

                            ?>
                        </select>
                        <br />
                        <input placeholder="Name" id="name" name="name" type="text" value="" />
                        <br />
                        <input placeholder="Email" id="email" name="email" type="text" value="" />
                        <br />
                        Message:<br /> <textarea name="message" id="tinymce">We know your field, so i thought that I would email you. We are an award winning PR and advertising agency that understands how to get people talking and buying. Lets us put some ideas together for you. We do everything under one roof. Capable and inventive - we would like the opportunity to prove it. I would be happy to come in and chat to you about your current promotional activities and provide you with some real, free, market research.</textarea>
                        <br />
                        <input class="right" type="button" id="send" value="Send" />
                        <img id="loader" class="invisible right" alt="loader" src="img/loader.gif" /><!-- replace this with some kind of loading gif -->
                    </form>
                </div>
                
                <div class="left recents_holder">
                    <h3>Recent Emails</h3>
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
                
                <!--==========================================
                            OPEN/UNOPEN PIE CHART
                ================================================-->
                <div class="left" id="chart">
                    <h3>Statistics Overview</h3>
                    <div class="analytics clearfix">
                        <h4>Opened vs Unopened</h4>
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
                
                    </div>
                </div>
                
            </div>
            
        </div>
        <script>
            //==================================
            //       SUPER LABELS
            //==================================
            $('form').superLabels({
                         duration:500,
                         easingIn:'easeInOutCubic',
                         easingOut:'easeInOutCubic',
                         fadeDuration:250,
                         opacity:0.5
                 });
        </script>
    </body>
</html>
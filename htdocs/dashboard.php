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
                <h1>menu</h1>
                <ul id="dash-nav">
                    <li>New mass mail</li>
                    <li>Import list</li>
                    <li>Manage lists</li>
                    <li>View full logs</li>
                </ul>
            </nav>
        
        <div id="wrapper" class="clearfix">
            
            
            <!--==================================== CONTENTS ===========-->
            <div class="contents">
                <!--========================= QUICK SEND =========-->
                <div class="left">
                <form id="quicksendform" class="clearfix">
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
                        <input placeholder="Name" id="name" name="name" type="text" />
                        <br />
                        <input placeholder="Email" id="email" name="email" type="text" />
                        <br />
                        Message:<br /> <textarea name="message" id="tinymce">We know your field, so i thought that I would email you. We are an award winning PR and advertising agency that understands how to get people talking and buying. Lets us put some ideas together for you. We do everything under one roof. Capable and inventive - we would like the opportunity to prove it. I would be happy to come in and chat to you about your current promotional activities and provide you with some real, free, market research.</textarea>
                        <br />
                        <input class="right" type="button" id="send" value="Send" />
                        <img id="loader" class="invisible" alt="loader" src="http://placehold.it/40x40" /><!-- replace this with some kind of loading gif -->
                    </form>
                    </div>
                
                <div class="left recents">
                <h3>Recent Emails</h3>
                    <table border="1" width="100%" cellpadding="5">
                        <tr>
                            <td class="recent_heads">To</td>
                            <td class="recent_heads">Email</td>
                            <td class="recent_heads">Date</td>
                            <td class="recent_heads">Opened</td>
                        </tr>
                        <?php

                        if($email_logs = $mail->outputLogs()){
                            foreach($email_logs as $log){
                                ?>
                                <tr>
                                    <td><?php echo $log['name']; ?></td>
                                    <td><?php echo $log['email']; ?></td>
                                    <td><?php echo $log['date']; ?></td>
                                    <td>&#x2713;</td><!--/// <?php// echo $log['opened']; ?> \\\-->
                                </tr>
                                <?php
                            }
                        }else{
                            ?>
                            <tr>
                                <td colspan="4">No recent logs.</td>
                            </tr>
                            <?php
                        }

                        ?>
                    </table>
                </div>
            </div>
            
            
            
        </div>
    </body>
</html>
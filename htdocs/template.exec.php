<?php require_once('./config.php'); ?>

<?php

$template = new Template();
$template->template_name = trim($_GET['template']);
$template->textarea_matches = array('body', 'content', 'message', 'address', 'description');

try {
    echo $template->generateForm();
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>
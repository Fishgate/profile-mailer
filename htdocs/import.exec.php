<?php require_once('./config.php'); ?>

<?php

$upload = new Upload();
$upload->file = $_FILES['file'];
$upload->newName = $_POST['listname'];

try {
    if($upload->uploadFile()){
        echo 'success';
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
    
?>
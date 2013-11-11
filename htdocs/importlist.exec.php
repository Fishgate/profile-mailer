<?php require_once('./config.php'); ?>

<?php

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

$import = new ImportList();
$import->file = $_FILES['file'];
$import->acquired = $_POST['list_acquired'];
$import->newName = $_POST['listname'];

try {
    $importFile = $import->uploadFile();
    
    $result = json_decode( $importFile, true);
    
    if($result['result'] == 'success'){
        echo $importFile;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>
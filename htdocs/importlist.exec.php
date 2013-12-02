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
    if($import->uploadFile()) {
        if($import->importCSV()){
            $imp = $import->logUploads();
            
            $impResult = json_decode($imp, true);
    
            if($result['result'] == 'success'){
                echo $imp;
            }
        }
    }
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>
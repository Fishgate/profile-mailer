<?php require_once('./config.php'); ?>

<?php

/**
 * NOTE: after we have assinged the necccesary information to the class instance we get rid
 * of the variable from the post array, so the only values we are left with are the names of 
 * the temporary column headers to be changes. This makes the final step of renaming each 
 * column header an easy foreach as $key => $val loop.
 * 
 */

$editList = new EditList();

try {
    $editList->tableName = $_POST['workingTable'];    
    unset($_POST['workingTable']); //done

    if(isset($_POST['delete']) && !empty($_POST['delete'])) {
        $editList->removeRowsArray = $_POST['delete'];
        unset($_POST['delete']); // done

        if($editList->removeRows()){
            $editList->columnNamesArray = $_POST;
            if($editList->renameColumns()){
                echo 'success';
            }
        }
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}


?>
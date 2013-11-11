<?php require_once('./config.php'); ?>

<?php

/**
 * NOTE: after we have assinged the necccesary information to the class instance we get rid
 * of the variable from the post array, so the only values we are left with are the names of 
 * the temporary column headers to be changed. This makes the final step of renaming each 
 * column header an easy foreach as $key => $val loop. $key represents the old name of the
 * column, and $val the new name. This is then used to complete the ALTER TABLE SQL statement
 * 
 */

$editList = new EditList();

try {
    $editList->tableName = $_POST['workingTable'];    
    unset($_POST['workingTable']); //done with this variable

    if(isset($_POST['delete']) && !empty($_POST['delete'])) {
        $editList->removeRowsArray = $_POST['delete'];
        unset($_POST['delete']); //done with this variable

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
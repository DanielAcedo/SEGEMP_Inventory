<?php
    include_once 'app.php';

    global $app;

    $app = new App();

    $app->start_session();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $productId = $_POST["id"];

        deleteProduct($productId);

    }

    function deleteProduct($id){
        global $app;
        $sqlDelete = "DELETE FROM ".TABLE_PRODUCT." WHERE ".PRODUCT_ID." = ".$id;
        $statement = $app->getDao()->prepare($sqlDelete);
        $statement->execute();

        if($statement){
            $app->goToInventory();
        }else{
            echo "Error";
        }
    }
?>
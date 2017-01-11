<?php
    include_once 'app.php';

    global $app;
    $app = new App();

    $app->start_session();

    $app->head("Añadir producto", "Añadir producto");
    $app->nav("addproduct");

    //Get typeproducts name
    $result = $app->getDao()->executeSelect("SELECT * FROM ".TABLE_TYPEPRODUCT);

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $model = $_POST["model"];
            $typeproduct = $_POST['typeproduct'];
            $serial = $_POST["serial"];

            $sqlSelectTPID = "SELECT ".TYPEPRODUCT_ID." FROM ".TABLE_TYPEPRODUCT." WHERE ".TYPEPRODUCT_DESCRIPTION."=\"".$typeproduct."\"";
            $statement = $app->getDao()->executeSelect($sqlSelectTPID);
            
            $typeproduct_id = $statement->fetch()[0];

            $sql_insert = "INSERT INTO ".TABLE_PRODUCT." (".PRODUCT_MODEL.", ".PRODUCT_TYPEPRODUCT.", ".PRODUCT_SERIAL.
            ") VALUES (:model, :typeproduct, :serial)";

            $statement = $app->getDao()->prepare($sql_insert);
            $statement->bindParam(":model", $model);
            $statement->bindParam(":typeproduct", $typeproduct_id);
            $statement->bindParam(":serial", $serial);
            $statement->execute();

            if($statement){
                $app->goToInventory();
            }else{
                echo "Error";
            }

    }
    else{
        if(!$result){
        echo "<p>Error al consultar con la base de datos</p>";
    }else{
        $types = $result->fetchAll();

        //Print add form
        echo '
        <form action="'.htmlspecialchars(basename(__FILE__)).'" name="addproduct" method="POST">
            <p>Modelo</p><input type="text" name="model"/>
            ';
            
            echo '<p>Tipo</p> <select name="typeproduct">
            ';

            for($i = 0; $i < count($types); $i++){
                $type = $types[$i][TYPEPRODUCT_DESCRIPTION];
                echo '<option value="'.$type.'">'.$type.'</option>
                ';
            }

            echo '</select>
            ';

            echo '<p>Serial</p><input type="text" name="serial"/>

            <p><input type="submit" value="Añadir"/></p>
        </form>
    ';
    }
    }

    

    $app->footer();
?>
<?php
    include_once 'app.php';

    global $app;
    $app = new App();

    $app->start_session();

    $app->head("Inventario", "Inventario");
    $app->nav("inventory");

    $sql = "SELECT * FROM ".TABLE_PRODUCT;
    $result = $app->getDao()->executeSelect($sql);

    $products;

    // SQL Statement is not valid
    if(!$result){
        echo $app->getDao()->getError();
    }
    // There is no data to be displayed
    else if (count($products = $result->fetchAll()) == 0){
        echo "No hay productos";
    }
    //There is data
    else{
        echo "<table border='1'>";
        echo "<tr>";

        for($i = 0; $i<$result->columnCount();$i++){
            $columnMeta = $result->getColumnMeta($i);

            echo "<th>".$columnMeta['name']."</th>";
        }

        echo "</tr>";

        for($i = 0; $i<count($products);$i++){
            $product = $products[$i];
            echo "<tr>";

            for($j = 0; $j<$result->columnCount();$j++){
                $columnMeta = $result->getColumnMeta($j);

                if($columnMeta['name'] == PRODUCT_TYPEPRODUCT){
                    $sqlSt = "SELECT ".TYPEPRODUCT_DESCRIPTION." FROM ".TABLE_TYPEPRODUCT." WHERE ".TYPEPRODUCT_ID."=".$product[$j];
                    $statement = $app->getDao()->executeSelect($sqlSt);
                    echo "<td>".$statement->fetch()[0]."</td>";
                }else{
                    echo "<td>".$product[$j]."</td>";
                }
            }

            echo "</tr>";
            
        }

        echo "</table>";
    }

    $app->footer();
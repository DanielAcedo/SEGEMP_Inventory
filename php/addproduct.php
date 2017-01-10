<?php
    include_once 'app.php';

    global $app;
    $app = new App();

    $app->start_session();

    $app->head("Añadir producto", "Añadir producto");
    $app->nav("addproduct");

    $result = $app->getDao()->executeSelect("SELECT * FROM ".TABLE_TYPEPRODUCT);

    if(!$result){
        echo "<p>Error al consultar con la base de datos</p>";
    }else{
        $types = $result->fetchAll();

        echo '
        <form action="'.htmlspecialchars(basename(__FILE__)).'" name="addproduct">
            <p>Modelo</p><input type="text" name="model"/>
            ';
            
            echo '<p>Tipo</p> <select name="type">
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

    $app->footer();
?>
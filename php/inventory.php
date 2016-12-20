<?php
    include_once 'app.php';

    global $app;
    $app = new App();

    $app->start_session();

    $app->head("Inventario", "Inventario");
    $app->nav(null);

    echo '<p> Hola, '.$_SESSION['user'];

    $app->footer();
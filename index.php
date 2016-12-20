<?php
    include_once 'php/app.php';

    session_start();

    global $app;

    $app = new App();

    if(!$app->isLogged())
        header('Location: php/login.php');
    else{
        header('Location: php/inventory.php');
    }

?>
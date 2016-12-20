<?php
    include_once 'app.php';

    global $app;
    $app = new App();
    
    session_start();

    $app->close_session();

?>
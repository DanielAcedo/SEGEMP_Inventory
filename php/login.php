<?php
    include_once 'app.php';

    global $app;
    $app = new App();

    session_start();

    $app->head("Inicio de sesión", "Login");
    $app->nav(null);

    $user = "";
    $passwd = "";

    //If we are already logged in, display information about it and ask to log out
    if (($app->isLogged())){
        $user = $_SESSION['user'];
        echo "Ya estás logeado como ".$user.", pulsa <a href='logout.php'>aquí</a> para cerrar sesión";
    }
    //Show login form
    else{
        echo '<div id="login">
        <form method="post" action="'.htmlspecialchars(basename(__FILE__)).'" name="login">
            <p class="input">User</p> <input class="input" type="text" name="user"/>
            <p class="input">Password</p> <input class="input" type="password" name="passwd"/>

            <p> <input class="input" type="submit" value="Submit"/>
        </form>
        </div>
        ';
    
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $user = $_POST['user'];
            $passwd = $_POST['passwd'];

            if(empty($user)){
                echo '<p>Debe introducir un nombre</p>';
            }
            else if(empty($passwd)){
                echo '<p>Debe introducir una contraseña</p>';
            }
            else{
                //Connect to database and check if user exists

                //1.Create connection

                //If we are not connected, show an error
                if(is_null($app->getDao()->isConnected())){
                    echo '<p>'.$app->showErrorConnection().'</p>';
                }
                else{
                    //Compare credentials with database
                    if($app->getDao()->checkUser($user, $passwd)){
                        //Save session
                        $app->init_session($user);
                        //Redirect to another page
                        echo '<script>
                            window.location.href="inventory.php";
                            </script>';
                    }
                    else{
                        //If credentials don't match
                        echo '<br>Error en las credenciales';
                    }
                }
            }
        }

    }

    $app->footer();
?>
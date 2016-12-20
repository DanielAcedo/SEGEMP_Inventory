<?php
    include_once 'app.php';

    global $app;
    $app = new App();

    session_start();

    $app->head("Inicio de sesión", "Login");
    $app->nav(null);

    $user = "";
    $passwd = "";


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
            //Conectar a la base de datos y comprobar que el usuario existe

            //1.Crear conexión

            //Si no estamos conectados mostramos error
            if(is_null($app->getDao()->isConnected())){
                echo '<p>'.$app->showErrorConnection().'</p>';
            }
            else{
                //Comparamos con la base de datos las credenciales
                if($app->getDao()->checkUser($user, $passwd)){
                    //Guardar sesion
                    $app->init_session($user);
                    //Redireccionar a otra página
                    echo '<script>
                        window.location.href="inventory.php";
                        </script>';
                }
                else{
                    //Si no están bien las credenciales
                    echo '<br>Error en las credenciales';
                }
            }
        }
    }

    $app->footer();
?>
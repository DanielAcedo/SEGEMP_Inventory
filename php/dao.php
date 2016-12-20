<?php
    define("MYSQL_HOST", "mysql:dbname=Inventory;host=127.0.0.1");
    define("MYSQL_USER", "www-data");
    define("MYSQL_PASSWORD", "www-data");
    define("DATABASE", "inventory");

    //Se define el nombre de todas las tablas
    define ("TABLE_USER", 'user');

    //Se define las columnas de las tablas
    define("USER_NAME", "username");
    define("USER_PASSWORD", "password");

    class InventoryDao{
        protected $conn;
        private $error;

        /* Se crea un objeto de conexión a la base de datos en el constructor */

        function __construct(){
            try{
                $this->conn = new PDO(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
                $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            }
            catch(PDOException $e){
                $this->error = "Error en la conexión: ".$e.getMessage();
                $this->conn = null;
            }
        }

        public function checkUser($user, $password){
            $result = 0;
            $statement = $this->conn->query("SELECT username, password from user where username='$user'");

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if($row == false || is_null($row)){
                $result = 0;
            }
            else if($row['password'] == sha1($password)){
                $result = 1;
            }else{
                echo $row['password']." y ".sha1($password);
            }

            return $result;
        }

        public function isConnected(){
            return $this->conn != null;
        }

        public function getError(){
            return $this->error;
        }

        function __destruct(){
            if($this->isConnected()){
                $this->conn = null;
            }
        }
    }

    
?>
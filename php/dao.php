<?php
    define("DATABASE", "Inventory");
    define("MYSQL_HOST", "mysql:dbname=".DATABASE.";host=127.0.0.1");
    define("MYSQL_USER", "www-data");
    define("MYSQL_PASSWORD", "www-data");

    //Se define el nombre de todas las tablas
    define ("TABLE_USER", 'user');
    define ("TABLE_PRODUCT", 'product');
    define ("TABLE_TYPEPRODUCT", 'typeproduct');

    //Se define las columnas de las tablas
    define("USER_NAME", "username");
    define("USER_PASSWORD", "password");
    define("PRODUCT_ID", "id");
    define("PRODUCT_MODEL", "model");
    define("PRODUCT_TYPEPRODUCT", "typeproduct");
    define("PRODUCT_SERIAL", "numserie");
    define("TYPEPRODUCT_ID", "id");
    define("TYPEPRODUCT_DESCRIPTION", "description");

    class InventoryDao{
        protected $conn;
        private $error;

        /* Se crea un objeto de conexión a la base de datos en el constructor */

        function __construct(){
            try{
                $this->conn = new PDO(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                //$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            }
            catch(PDOException $e){
                $this->error = "Error en la conexión: ".$e->getMessage();
                $this->conn = null;
            }
        }

        public function checkUser($user, $password){
            $result = 0;
            
            $statement = $this->conn->query("SELECT ".USER_NAME.", ".USER_PASSWORD." from ".TABLE_USER." where ".USER_NAME."='$user'");

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if($row == false || is_null($row)){
                $result = 0;
            }
            else if($row[USER_PASSWORD] == sha1($password)){
                $result = 1;
            }else{
                echo $row[USER_PASSWORD]." y ".sha1($password);
            }

            return $result;
        }

        public function executeSelect($sql){
            $result = $this->conn->prepare($sql);
            $result->execute();
            
            if(!$result){
                $this->error = "Error en la consulta de datos";
            }

            return $result;
        }

        public function prepare($sql){
            $result = $this->conn->prepare($sql);

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
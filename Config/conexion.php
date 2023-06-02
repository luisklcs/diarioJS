<?php
    class db{
        private $host= "localhost";
        private $dbname="diariojucicialnueva";
        private $user="root";
        private $password="";
        public function conexion(){
            try{
                $PDO = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->password);
          #echo "<script> alert('conectado...')</script>";
                return $PDO;
            }catch(PDOException $e){
            #    echo "<script>alert('Error...')</script>" ;
                return $e->getMessage();
            }
        }
    }

?>
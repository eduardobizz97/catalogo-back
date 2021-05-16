<?php
class Conexion{

    static function ConectarDB()
    {
        try{
            require "Global.php";

            $db = new PDO(DSN,user,password);

            return $db;
            
        }catch(PDOException $ex){

            die($ex->getMessage());
        }
    }
}
?>
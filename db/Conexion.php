<?php
class Conexion{
    /**
     * Esta static function realiza la conexion con la base de datos.
     * En caso de error retorna un PDOException.
     * @return void
     */
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
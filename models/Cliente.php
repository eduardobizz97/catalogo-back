<?php

class Cliente {

    public $db;
   /**
    * La función obtiene la conexion a la base de datos
    */
     public function __construct(){
        $this->db =  Conexion::ConectarDB();
     }
     
     /**
      * Esta función registra datos en la tabla Clientes en la BD
      * y también valida si el cliente está registrado o no
      * @param string $nombre
      * @param string $correo
      * @param string $clave
      * @param string $telefono
      * @return void
      */
     public function registrarClientes( $nombre,$correo,$clave, $telefono){

         $validate = "SELECT correo from clientes where correo = :correo";
         $validateResult = $this->db->prepare($validate);
         $validateResult->bindParam('correo',$correo, PDO::PARAM_STR, 12 );
         $validateResult->execute();
         if($validateResult->rowCount() > 0){
            $response = array('result' => "Usuario ya registrado");
            echo json_encode($response);
            exit();
            return;
         }
         $sql = "INSERT INTO clientes(nombre,correo,clave,telefono) VALUES (:nombre,:correo,:clave,:telefono)";
         $result = $this->db->prepare($sql);
         $result->bindParam('nombre',$nombre, PDO::PARAM_STR, 12 );
         $result->bindParam ('correo',$correo, PDO::PARAM_STR, 12);
         $clave_hash=password_hash($clave,PASSWORD_DEFAULT);
         $result->bindParam ('clave',$clave_hash,PDO::PARAM_STR, 255);
         $result->bindParam('telefono',$telefono, PDO::PARAM_STR, 45);
         if($result->execute()){
            $json = $result->fetch(PDO::FETCH_ASSOC);
            $response = array('result' => "SUCCESS");
            echo json_encode($response);
            exit();
         }else{

            $response = array('result' => "Error al registrar usuario");
            echo json_encode($response);
            exit();
         }
     }

   /**
    * Esta función permite validar los datos del Cliente al momento de 
    * iniciar sesión
    * @param string $correo
    * @param string $clave
    * @return void
    */
     public function ValidarCliente($correo,$clave){
      $sql = "SELECT * FROM clientes WHERE correo = :correo";
      $result = $this->db->prepare($sql);
      $result->bindParam('correo',$correo);
      $result->execute();
      $fila = $result->fetch(PDO::FETCH_ASSOC);
      if(!$fila){
         $response = array('result' => "Error en el usuario o contraseña");
         echo json_encode($response);
         exit();
      }
      if(password_verify($clave,$fila["clave"])){
         $json = array('cliente' => $fila, 'result'=>'SUCCESS');
         echo json_encode($json);
         exit();
      }
   }

      /**
       * Esta función obtiene todos los datos de la tabla clientes de la BD
       *
       * @return void
       */
     public function getClientes() {
        $sql = $this->db->prepare("select * from clientes");
        $sql->execute();
        $result=$sql->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        
     }

   


}



?>
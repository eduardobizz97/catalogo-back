<?php

class EmpresaCliente {

    public $db;
      /**
       * La función obtiene la conexion a la base de datos
       */
     public function __construct(){
        $this->db =  Conexion::ConectarDB();
     }
     /**
      * Esta función registra datos en la tabla empresa_cliente en la BD
      * y también valida si la empresa_cliente está registrado o no
      * @param string $nombre
      * @param string $correo
      * @param string $descripcion
      * @param string $telefono
      * @param string $clave
      * @return void
      */
     public function registrarEmpresa( $nombre,$correo,$descripcion,$telefono,$clave){

         $validate = "SELECT correo from empresa_cliente where correo = :correo";
         $validateResult = $this->db->prepare($validate);
         $validateResult->bindParam('correo',$correo, PDO::PARAM_STR, 12 );
         $validateResult->execute();
         if($validateResult->rowCount() > 0){
            $response = array('result' => "Usuario ya registrado");
            echo json_encode($response);
            exit();
            return;
         }
         $sql = "INSERT INTO empresa_cliente(nombre,correo,descripcion,telefono,clave) VALUES (:nombre,:correo,:descripcion,:telefono,:clave)";
         $result = $this->db->prepare($sql);
         $result->bindParam('nombre',$nombre, PDO::PARAM_STR, 12 );
         $result->bindParam ('correo',$correo, PDO::PARAM_STR, 12);
         $result->bindParam ('descripcion',$descripcion, PDO::PARAM_STR, 12);
         $result->bindParam ('telefono',$telefono, PDO::PARAM_INT, 12);
         $clave_hash=password_hash($clave,PASSWORD_DEFAULT);
         $result->bindParam ('clave',$clave_hash,PDO::PARAM_STR, 255);
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
       * Esta función valida los datos de la empresa al momento de iniciar sesión
       *
       * @param string $correo
       * @param string $clave
       * @return void
       */
     public function ValidarEmpresa($correo,$clave){
      $sql = "SELECT * FROM empresa_cliente WHERE correo = :correo";
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
       * Esta función obtiene todos los datos de la tabla empresa_cliente 
       *
       * @return void
       */
     public function getEmpresa() {
        $sql = $this->db->prepare("select * from empresa_cliente");
        $sql->execute();
        $result=$sql->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        
     }

     


}



?>
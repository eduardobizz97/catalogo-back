<?php

class Categoria {

    public $db;
 
     public function __construct(){
        $this->db =  Conexion::ConectarDB();
     }
     
     public function registrarCategoria($nombre){
         $sql = "INSERT INTO categorias(nombre, estado) VALUES (:nombre, 1)";
         $result = $this->db->prepare($sql);
         $result->bindParam('nombre',$nombre, PDO::PARAM_STR, 12 );    
         if($result->execute()){
            // $json = $result->fetch(PDO::FETCH_ASSOC);
            $response = array('result' => "SUCCESS");
            echo json_encode($response);
            exit(); 
         }else{
            $response = array('result' => "Error al registrar categoria");
            echo json_encode($response);
            exit();
         }
     }

     public function modificarCategoria($id,$nombre){
      $sql = "UPDATE categorias SET nombre=:nombre WHERE id = $id";
      $result = $this->db->prepare($sql);
      $result->bindParam(':nombre',$nombre, PDO::PARAM_STR, 12 );    
      if($result->execute()){
         $response = array('result' => "SUCCESS");
         echo json_encode($response);
         exit();  
      }else{
         $response = array('result' => "Error al modificar categoria");
         echo json_encode($response);
         exit();
      }
  }

   public function eliminarCategoria($id){
      $sql = "UPDATE categorias SET estado=0 WHERE id = $id";
      $result = $this->db->prepare($sql);
      $result->bindParam(':nombre',$nombre, PDO::PARAM_STR, 12 );    
      if($result->execute()){
         $response = array('result' => "SUCCESS");
         echo json_encode($response);
         exit(); 
      }else{
         $response = array('result' => "Error al eliminar categoria");
         echo json_encode($response);
         exit();
      }
   }

      public function buscarCategorias($id) {
         $sql = $this->db->prepare("SELECT * FROM categorias WHERE id = $id ");
         $sql->execute();
         $result=$sql->fetch(PDO::FETCH_ASSOC);
         if($result){
            echo json_encode($result);
            return true;
         }
      }

     public function getCategorias() {
        $sql = $this->db->prepare("SELECT * FROM categorias WHERE estado = 1");
        $sql->execute();
        $result=$sql->fetchAll(PDO::FETCH_ASSOC);
        $response = array('result' => "SUCCESS", 'categorias' =>$result);
        echo json_encode($response);
        exit();
        
     }

     
     


}



?>
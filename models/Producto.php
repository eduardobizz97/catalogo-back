<?php

class Producto {

    public $db;
 
     public function __construct(){
        $this->db =  Conexion::ConectarDB();
     }
     
     public function registrarProducto($nombre,$precio,$stock,$categoria,$idEmpresa){
         $sql = "INSERT INTO productos(nombre,precio,stock,categoria_id,id_empresa) VALUES (:nombre,:precio,:stock,:categoria_id,:id_empresa)";
         $result = $this->db->prepare($sql);
         $result->bindParam('nombre',$nombre, PDO::PARAM_STR, 250);   
         $result->bindParam('precio',$precio, PDO::PARAM_INT );   
         $result->bindParam('stock',$stock, PDO::PARAM_INT);   
         $result->bindParam('categoria_id',$categoria, PDO::PARAM_INT );    
         $result->bindParam('id_empresa',$idEmpresa, PDO::PARAM_INT ); 
         if($result->execute()){
            $response = array('result' => "SUCCESS");
            echo json_encode($response);
            exit(); 
         }else{
            $response = array('result' => "Error al registrar producto");
            echo json_encode($response);
            exit();
         }
     }

     public function modificarProducto($id,$nombre,$precio,$stock,$categoria,$idEmpresa){
      $sql = "UPDATE productos SET nombre=:nombre, precio=:precio,stock=:stock,categoria_id=:categoria_id WHERE id = $id";
      $result = $this->db->prepare($sql);
       
      $result->bindParam(':nombre',$nombre, PDO::PARAM_STR, 250);   
      $result->bindParam(':precio',$precio, PDO::PARAM_INT );   
      $result->bindParam(':stock',$stock, PDO::PARAM_INT);   
      $result->bindParam(':categoria_id',$categoria, PDO::PARAM_INT );
      if($result->execute()){
         $response = array('result' => "SUCCESS");
         echo json_encode($response);
         exit(); ;  
      }else{
         $response = array('result' => "Error al modificar categoria");
         echo json_encode($response);
         exit();
      }
  }

      public function buscarProductos($id) {
         $sql = $this->db->prepare("SELECT * FROM productos WHERE id = $id ");
         $sql->execute();
         $result=$sql->fetch(PDO::FETCH_ASSOC);
         if($result){
            echo json_encode($result);
            return true;
         }
      }

     public function getProducto($id) {
        $sql = "SELECT * FROM productos WHERE id_empresa = :empresa";
        $result = $this->db->prepare($sql);
        $result->bindParam(':empresa',$id, PDO::PARAM_INT, 12);   
        $result->execute();
        $result=$result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        
     }

     public function eliminarProducto($id){
      $sql = "DELETE FROM productos WHERE id = $id";
      $result = $this->db->prepare($sql);
      if($result->execute()){
         $response = array('result' => "SUCCESS");
         echo json_encode($response);
         exit(); ;  
      }else{
         $response = array('result' => "Error al modificar categoria");
         echo json_encode($response);
         exit();
      }
  }
     


}



?>
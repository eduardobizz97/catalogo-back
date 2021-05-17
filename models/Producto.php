<?php

class Producto {

    public $db;
      /**
       * La función obtiene la conexion a la base de datos
       */
     public function __construct(){
        $this->db =  Conexion::ConectarDB();
     }
     
     /**
      * Esta función registra datos en la tabla productos en la BD
      *
      * @param string $nombre
      * @param string $precio
      * @param string $stock
      * @param string $categoria
      * @param string $idEmpresa
      * @return void
      */
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

     /**
      * Esta función modifica los datos de la tabla productos en la BD
      *
      * @param string $id
      * @param string $nombre
      * @param string $precio
      * @param string $stock
      * @param string $categoria
      * @param string $idEmpresa
      * @return void
      */
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
      /**
       * Esta función busca por id productos
       *
       * @param integer $id
       * @return void
       */
      public function buscarProductos($id) {
         $sql = $this->db->prepare("SELECT * FROM productos WHERE id = $id ");
         $sql->execute();
         $result=$sql->fetch(PDO::FETCH_ASSOC);
         if($result){
            echo json_encode($result);
            return true;
         }
      }

      /**
       * Esta función obtiene todos los productos de cada empresa
       */
      public function getProducto($id) {
        $sql = "SELECT * FROM productos WHERE id_empresa = :empresa";
        $result = $this->db->prepare($sql);
        $result->bindParam(':empresa',$id, PDO::PARAM_INT, 12);   
        $result->execute();
        $result=$result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        
     }
     /**
      * Esta función elimina datos de la tabla productos dependiendo del id
      *
      * @param [type] $id
      * @return void
      */
     public function eliminarProducto($id){
      $sql = "DELETE FROM productos WHERE id = $id";
      $result = $this->db->prepare($sql);
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
     /**
      * Esta función obtiene todos los datos de la tabla productos de la BD
      *
      * @return void
      */
     public function getAllProducto() {
        $sql = "SELECT * FROM productos";
        $result = $this->db->prepare($sql);
        if($result->execute()){
         $result=$result->fetchAll(PDO::FETCH_ASSOC);
         $response = array('result' => "SUCCESS",'productos'=>$result);
         echo json_encode($response);
         exit();  
      }
        $result=$result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        
     }

}



?>
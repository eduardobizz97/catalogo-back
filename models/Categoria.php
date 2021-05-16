<?php

class Categoria {

    public $db;
   /**
    * La función obtiene la conexion a la base de datos
    */
     public function __construct(){
        $this->db =  Conexion::ConectarDB();
     }

     /**
      * La función registra una Categoria a la BD
      *
      * @param string $nombre
      * @return void
      */
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
     /**
      * Esta función modifica los datos de la tabla Categoria en la BD
      *
      * @param integer $id
      * @param string $nombre
      * @return void
      */
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

  /**
   * Esta función elimina los datos de la tabla Categoria de la BD
   *
   * @param integer $id
   * @return void
   */
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
   /**
    * Esta función permite buscar por id de Categoria 
    *
    * @param integer $id
    * @return void
    */
      public function buscarCategorias($id) {
         $sql = $this->db->prepare("SELECT * FROM categorias WHERE id = $id ");
         $sql->execute();
         $result=$sql->fetch(PDO::FETCH_ASSOC);
         if($result){
            echo json_encode($result);
            return true;
         }
      }

      /**
       * Esta función obtiene todos los datos de la tabla Categoria
       * que tengan como estado 1(Habilitado)
       * @return void
       */
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
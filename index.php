<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE, PATCH");
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "OPTIONS") {
        die();
    }
    require_once("db/Conexion.php");
    require_once("models/Cliente.php");
    require_once("models/Categoria.php");
    require_once("models/Producto.php");
    require_once("models/EmpresaCliente.php");

    include('./routes/Route.php');
    ;
    Route::add('/', function() {
        echo "<a href='index.php'>Ir a /inicio</a>";
        echo '<form action="/cliente/registrar.php" method="post">
       <label for="id">Id</label>
       <input type="text" name="id">
       <button type="submit">Registrar</button>
        </form>';
    });

    Route::add('/index.php', function(){
        $empresaCliente = new EmpresaCliente();
        $empresaCliente->getEmpresa();
    });
    // CLIENTES 
    // 
    // 
    Route::add('/cliente', function(){
        $cliente = new Cliente();
        $cliente->getClientes();
    },'get');

    Route::add('/cliente/registrar', function(){
        $cliente = new Cliente();
        $_POST = json_decode(file_get_contents("php://input"),true);
        $nombre = $_POST["nombre"];
        $correo = $_POST["email"];
        $clave = $_POST["password"];
        $telefono = $_POST["telefono"];
        
        if($cliente->registrarClientes($nombre,$correo,$clave,$telefono)){
            echo "Registro cliente exitoso";
        }else{
            echo "Error al registrar cliente x.x";
        }
    },'post');

    Route::add('/cliente/validar', function(){
        $cliente = new Cliente();
        $_POST = json_decode(file_get_contents("php://input"),true);
        $correo = $_POST["email"];
        $clave = $_POST["password"];
        if($cliente->ValidarCliente($correo,$clave)){
            echo"Cliente encontrado!";
        }else{
            echo "Cliente no encontrado";
        }
    },'post');

    // EMPRESAS 
    // 
    // 
    Route::add('/empresa_cliente/registrar', function(){
        $empresaCliente = new EmpresaCliente();
        $_POST = json_decode(file_get_contents("php://input"),true);
        $nombre = $_POST["nombre"];
        $correo = $_POST["email"];
        $clave = $_POST["password"];
        $descripcion = $_POST["descripcion"];
        $telefono = $_POST["telefono"];
        $empresaCliente->registrarEmpresa($nombre,$correo,$descripcion,$telefono,$clave);
    },'post');

    Route::add('/empresa_cliente/validar', function(){
        $empresaCliente = new EmpresaCliente();
        $_POST = json_decode(file_get_contents("php://input"),true);
        $correo = $_POST["email"];
        $clave = $_POST["password"];
        if($empresaCliente->ValidarEmpresa($correo,$clave)){
            echo"Empresa encontrada!";
        }else{
            echo "Empresa no encontrada";
        }
    },'post');

    Route::add('/categoria/registrar', function(){
        $categoria = new Categoria();
        $_POST = json_decode(file_get_contents("php://input"),true);
        $nombre = $_POST["nombre"];

        if($categoria->registrarCategoria($nombre)){
            echo "Registro categoria exitoso";
        }else{
            echo "Error al registrar categoria x.x";
        }
    },'post');

    Route::add('/categoria/listar', function(){
        $categoria = new Categoria();
        $categoria->getCategorias();
    });

    Route::add('/categoria/modificar', function(){
        $categoria = new Categoria();
        $_POST = json_decode(file_get_contents("php://input"),true);
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        if($categoria->modificarCategoria($id,$nombre)){
            echo "Modificar categoria exitoso";
        }else{
            echo "Error al mod categoria x.x";
        }
    },'patch');


    Route::add('/categoria/eliminar', function(){
        $categoria = new Categoria();
        $_POST = json_decode(file_get_contents("php://input"),true);
        $id = $_POST["id"];
        if($categoria->eliminarCategoria($id)){
            echo "Modificar categoria exitoso";
        }else{
            echo "Error al mod categoria x.x";
        }
    },'patch');

    Route::add('/categoria/buscar.php', function(){
        $categoria = new Categoria();
        $id="3";

        if($categoria->buscarCategorias($id)){
            echo "Categoria encontrada";
        }else{
            echo "No se encontró la categoria x.x";
        }
    });

    Route::add('/producto/registrar', function(){
        $producto = new Producto();
        $_POST = json_decode(file_get_contents("php://input"),true);
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        $categoria = $_POST["categoria"];
        $idEmpresa = $_POST["idEmpresa"];

        if($producto->registrarProducto($nombre,$precio,$stock,$categoria,$idEmpresa)){
            echo "Registro producto exitoso";
        }else{
            echo "Error al registrar producto x.x";
        }
    },'post');

    Route::add('/producto/listar/([0-9]*)', function($id){

        $producto = new Producto();
        $producto->getProducto($id);
    });
    
    Route::add('/producto/modificar', function(){
        $producto = new Producto();
        $_POST = json_decode(file_get_contents("php://input"),true);
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        $categoria = $_POST["categoria"];
        $idEmpresa = $_POST["idEmpresa"];
        $producto->modificarProducto($id,$nombre,$precio,$stock,$categoria,$idEmpresa);
        
    },'patch');


    Route::add('/producto/eliminar/([0-9]*)', function($id){
        $producto = new Producto();
        $producto->eliminarProducto($id);
        
    },'delete');

    Route::add('/producto/buscar.php', function(){
        $producto = new Producto();
        $id="1";

        if($producto->buscarProductos($id)){
            echo "Producto encontrado";
        }else{
            echo "No se encontró el producto x.x";
        }
    });


    Route::run("/");
  
?>

<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET Todos los clientes 
$app->get('/api/clientes', function(Request $request, Response $response){
  $sql = "SELECT * FROM clientes";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($clientes);
    }else {
      echo json_encode("No existen clientes en la BBDD.");
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

// GET Recueperar cliente por ID 
$app->get('/api/clientes/{id}', function(Request $request, Response $response){
  $id_cliente = $request->getAttribute('id');
  $sql = "SELECT * FROM clientes WHERE id = $id_cliente";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $cliente = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($cliente);
    }else {
      echo json_encode("No existen cliente en la BBDD con este ID.");
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


// POST Crear nuevo cliente 
$app->post('/api/clientes/nuevo', function(Request $request, Response $response){
   $nombre = $request->getParam('nombre');
   $apellidos = $request->getParam('apellidos');
   $telefono = $request->getParam('telefono');
   $email = $request->getParam('email');
   $direccion = $request->getParam('direccion');
   $ciudad = $request->getParam('ciudad'); 
  
  $sql = "INSERT INTO clientes (nombre, apellidos, telefono, email, direccion, ciudad) VALUES 
          (:nombre, :apellidos, :telefono, :email, :direccion, :ciudad)";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':nombre', $nombre);
    $resultado->bindParam(':apellidos', $apellidos);
    $resultado->bindParam(':telefono', $telefono);
    $resultado->bindParam(':email', $email);
    $resultado->bindParam(':direccion', $direccion);
    $resultado->bindParam(':ciudad', $ciudad);

    $resultado->execute();
    echo json_encode("Nuevo cliente guardado.");  

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 



// PUT Modificar cliente 
$app->put('/api/clientes/modificar/{id}', function(Request $request, Response $response){
   $id_cliente = $request->getAttribute('id');
   $nombre = $request->getParam('nombre');
   $apellidos = $request->getParam('apellidos');
   $telefono = $request->getParam('telefono');
   $email = $request->getParam('email');
   $direccion = $request->getParam('direccion');
   $ciudad = $request->getParam('ciudad'); 
  
  $sql = "UPDATE clientes SET
          nombre = :nombre,
          apellidos = :apellidos,
          telefono = :telefono,
          email = :email,
          direccion = :direccion,
          ciudad = :ciudad
        WHERE id = $id_cliente";
     
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':nombre', $nombre);
    $resultado->bindParam(':apellidos', $apellidos);
    $resultado->bindParam(':telefono', $telefono);
    $resultado->bindParam(':email', $email);
    $resultado->bindParam(':direccion', $direccion);
    $resultado->bindParam(':ciudad', $ciudad);

    $resultado->execute();
    echo json_encode("Cliente modificado.");  

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


// DELETE borar cliente 
$app->delete('/api/clientes/delete/{id}', function(Request $request, Response $response){
   $id_cliente = $request->getAttribute('id');
   $sql = "DELETE FROM clientes WHERE id = $id_cliente";
     
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);
     $resultado->execute();

    if ($resultado->rowCount() > 0) {
      echo json_encode("Cliente eliminado.");  
    }else {
      echo json_encode("No existe cliente con este ID.");
    }

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 








<?php
include 'conexion.php'; 
$pdo = connect(); 
    
// Primero me aseguro el método HTTP
$request_method = $_SERVER["REQUEST_METHOD"];

// CRUD para usuarios
// En este caso para agilizar los procesos por cuestión de tiempo se usará un switch

switch ($request_method) {
    case 'POST':
        // Crear un nuevo usuario
        $data = json_decode(file_get_contents("php://input"));
        $nombre = $data->nombre;
        $correo = $data->correo;
        $password = password_hash($data->password, PASSWORD_DEFAULT); // Encriptar la contraseña. Normalmente uso HASH256 pero por cuestión de tiempo usaré la opción de bcrypt de php (o sea password_hash)

        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)"); //Paso los datos por signo de interrogación para evitar inyección SQL;
        $stmt->execute([$nombre, $correo, $password]);

        echo json_encode(['status' => 'Usuario creado']);
        break;
        
    case 'GET':
        // Obtener un usuario en específico (lógicamente a través de la ID)
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($usuario);
        // Obtener todos los usuarios de la base de datos
        } else {
            $stmt = $pdo->query("SELECT * FROM usuarios");
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($usuarios);
        }
        break;

    case 'PUT':
        // Actualizar un usuario
        $data = json_decode(file_get_contents("php://input"));
        $id = intval($data->id);
        $nombre = $data->nombre;
        $correo = $data->correo;
        $password = password_hash($data->password, PASSWORD_DEFAULT); // Encriptar la nueva contraseña

        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, password = ? WHERE id = ?"); 
        $stmt->execute([$nombre, $correo, $password, $id]);

        echo json_encode(['status' => 'Usuario actualizado']);
        break;

    case 'DELETE':
        // Eliminar un usuario
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['status' => 'Usuario eliminado']);
        }
        break;
}

?>
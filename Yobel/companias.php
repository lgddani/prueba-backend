<?php
include 'conexion.php'; 
$pdo = connect(); 

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("SELECT * FROM companias WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $pdo->prepare("SELECT * FROM companias");
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $nombre = $data->nombre;
        $direccion = $data->direccion;

        $stmt = $pdo->prepare("INSERT INTO companias (nombre, direccion) VALUES (?, ?)");
        $stmt->execute([$nombre, $direccion]);

        echo json_encode(['status' => 'Compañía creada']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $id = intval($data->id);
        $nombre = $data->nombre;
        $direccion = $data->direccion;

        $stmt = $pdo->prepare("UPDATE companias SET nombre = ?, direccion = ? WHERE id = ?");
        $stmt->execute([$nombre, $direccion, $id]);

        echo json_encode(['status' => 'Compañía actualizada']);
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("DELETE FROM companias WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['status' => 'Compañía eliminada']);
        }
        break;
}
?>

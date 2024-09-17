<?php
include 'conexion.php'; 
$pdo = connect();
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("SELECT * FROM sucursales WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $pdo->prepare("SELECT * FROM sucursales");
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $nombre = $data->nombre;
        $direccion = $data->direccion;
        $ciudad = $data->ciudad;
        $id_compania = $data->id_compania;

        $stmt = $pdo->prepare("INSERT INTO sucursales (nombre, direccion, ciudad, id_compania) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $direccion, $ciudad, $id_compania]);

        echo json_encode(['status' => 'Sucursal creada']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $id = intval($data->id);
        $nombre = $data->nombre;
        $direccion = $data->direccion;
        $ciudad = $data->ciudad;
        $id_compania = $data->id_compania;

        $stmt = $pdo->prepare("UPDATE sucursales SET nombre = ?, direccion = ?, ciudad = ?, id_compania = ? WHERE id = ?");
        $stmt->execute([$nombre, $direccion, $ciudad, $id_compania, $id]);

        echo json_encode(['status' => 'Sucursal actualizada']);
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("DELETE FROM sucursales WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['status' => 'Sucursal eliminada']);
        }
        break;
}
?>

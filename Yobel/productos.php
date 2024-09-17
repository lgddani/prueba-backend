<?php
include 'conexion.php'; 
$pdo = connect();
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $pdo->prepare("SELECT * FROM productos");
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $descripcion = $data->descripcion;
        $peso = $data->peso;

        $stmt = $pdo->prepare("INSERT INTO productos (descripcion, peso) VALUES (?, ?)");
        $stmt->execute([$descripcion, $peso]);

        echo json_encode(['status' => 'Producto creado']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $id = intval($data->id);
        $descripcion = $data->descripcion;
        $peso = $data->peso;

        $stmt = $pdo->prepare("UPDATE productos SET descripcion = ?, peso = ? WHERE id = ?");
        $stmt->execute([$descripcion, $peso, $id]);

        echo json_encode(['status' => 'Producto actualizado']);
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['status' => 'Producto eliminado']);
        }
        break;
}
?>

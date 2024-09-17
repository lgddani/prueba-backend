<?php
include 'conexion.php';
$pdo = connect();
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("SELECT * FROM paquetes WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } elseif (isset($_GET['count'])) {
            // Contar paquetes basados en los parámetros propuestos en el ejercicio
            $date = isset($_GET['date']) ? $_GET['date'] : null;
            $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;
            $branch_id = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : null;
            
            $query = "SELECT COUNT(*) as total FROM paquetes WHERE 1=1";
            $params = [];
            
            if ($date) {
                $query .= " AND fecha_envio = ?";
                $params[] = $date;
            }
            if ($user_id) {
                $query .= " AND (id_usuario_origen = ? OR id_usuario_destino = ?)";
                $params[] = $user_id;
                $params[] = $user_id;
            }
            if ($branch_id) {
                $query .= " AND (id_sucursal_origen = ? OR id_sucursal_destino = ?)";
                $params[] = $branch_id;
                $params[] = $branch_id;
            }
            
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['total' => $result['total']]);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM paquetes");
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $id_usuario_origen = $data->id_usuario_origen;
        $id_usuario_destino = $data->id_usuario_destino;
        $id_producto = $data->id_producto;
        $id_sucursal_origen = $data->id_sucursal_origen;
        $id_sucursal_destino = $data->id_sucursal_destino;
        $estado = $data->estado;
        $fecha_envio = $data->fecha_envio;

        $stmt = $pdo->prepare("INSERT INTO paquetes (id_usuario_origen, id_usuario_destino, id_producto, id_sucursal_origen, id_sucursal_destino, estado, fecha_envio) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_usuario_origen, $id_usuario_destino, $id_producto, $id_sucursal_origen, $id_sucursal_destino, $estado, $fecha_envio]);

        echo json_encode(['status' => 'Paquete creado']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $id = intval($data->id);
        $id_usuario_origen = $data->id_usuario_origen;
        $id_usuario_destino = $data->id_usuario_destino;
        $id_producto = $data->id_producto;
        $id_sucursal_origen = $data->id_sucursal_origen;
        $id_sucursal_destino = $data->id_sucursal_destino;
        $estado = $data->estado;
        $fecha_envio = $data->fecha_envio;

        $stmt = $pdo->prepare("UPDATE paquetes SET id_usuario_origen = ?, id_usuario_destino = ?, id_producto = ?, id_sucursal_origen = ?, id_sucursal_destino = ?, estado = ?, fecha_envio = ? WHERE id = ?");
        $stmt->execute([$id_usuario_origen, $id_usuario_destino, $id_producto, $id_sucursal_origen, $id_sucursal_destino, $estado, $fecha_envio, $id]);

        echo json_encode(['status' => 'Paquete actualizado']);
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("DELETE FROM paquetes WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['status' => 'Paquete eliminado']);
        }
        break;
}
?>

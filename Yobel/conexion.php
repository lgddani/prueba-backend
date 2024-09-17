<?php

function connect() {
    $host = 'localhost';
    $nombre_db = 'yobel';
    $usuario = 'root';
    $clave = '123';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$nombre_db", $usuario, $clave);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Conexión exitosa";
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

// connect();

?>

<?php

// Configuración de la conexión a la base de datos
$dsn = "pgsql:host=localhost;dbname=parqueadero";
$username = "postgres";
$password = "12345";

try {
    // Crear una nueva instancia de PDO
    $conex = new PDO($dsn, $username, $password);

    // Establecer el modo de error para lanzar excepciones en caso de error
    $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mostrar mensaje de conexión exitosa
} catch (PDOException $e) {
    // Error al conectar a la base de datos
    echo "Error al conectar a la base de datos: " . $e->getMessage();
    exit();
}

// Lista de nombres de tablas
$users = 'users';
?>

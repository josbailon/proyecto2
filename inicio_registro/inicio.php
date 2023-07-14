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

} catch (PDOException $e) {
    // Error al conectar a la base de datos
    echo "Error al conectar a la base de datos: " . $e->getMessage();
    exit();
}

// Verificar si se envió el formulario de inicio de sesión
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar la base de datos para verificar las credenciales
    $consulta = "SELECT COUNT(*) FROM users WHERE username = ? AND password = ?";
    $stmt = $conex->prepare($consulta);
    $stmt->execute([$username, $password]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Credenciales correctas, redirigir a la página de desarrollo
        header("Location: ../desarrollo/gestion_carros.php");
        exit();
    } else {
        // Credenciales incorrectas
        $mensaje = "Usuario incorrecto";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inicio.css">
    <title>LOGIN</title>
</head>
<body>
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:500' rel='stylesheet' type='text/css'>

    <div class="login">
        <div class="login-header">
            <h1>Iniciar sesión</h1>
        </div>
        <div class="login-form">
            <form method="POST" action="inicio.php">
                <h3>Nombre de usuario:</h3>
                <input type="text" name="username" placeholder="Nombre de usuario" required/><br>
                <h3>Contraseña:</h3>
                <input type="password" name="password" placeholder="Contraseña" required/>
                <br>
                <input type="submit" name="login" value="Iniciar sesión" class="login-button"/>
            </form>
            <?php if (isset($mensaje)) { echo "<p>$mensaje</p>"; } ?>
            <br>
            <a href="registro.php" class="sign-up">¡Registrarse!</a>
            <br>
            <h6 class="no-access">¿No puedes acceder a tu cuenta?</h6>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="inicio.js"></script>
</body>
</html>

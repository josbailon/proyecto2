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

// Verificar si se envió el formulario de registro
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Realizar las operaciones de inserción en la base de datos
    try {
        $consulta = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $conex->prepare($consulta);
        $stmt->execute([$username, $password, $email]);

        echo "Registro exitoso. Ahora puedes <a href='inicio.html'>iniciar sesión</a>.";
    } catch (PDOException $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
}

?>

<!-- HTML del formulario de registro -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inicio.css">
    <title>Registro </title>
</head>
<body>
    <div class="login">
        <div class="login-header">
            <h1>Registro de Usuario</h1>
        </div>
        <div class="login-form">
            <form method="POST" action="registro.php">
                <h3>Nombre de usuario:</h3>
                <input type="text" name="username" placeholder="Nombre de usuario" required/><br>
                <h3>Contraseña:</h3>
                <input type="password" name="password" placeholder="Contraseña" required/>
                <br>
                <h3>Email:</h3>
                <input type="text" name="email" placeholder="Email" required/><br>
                <input type="submit" name="register" value="Registrarse" class="register-button"/>
            </form>
            <br>
            <a href="inicio.php" class="sign-in">Iniciar sesión</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="registro.js"></script>
</body>
</html>

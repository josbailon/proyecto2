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

// Función para agregar la hora de llegada de un carro por su ID
function agregarHoraLlegada($conex, $carroId, $horaLlegada) {
    $consulta = "INSERT INTO reportes_vehiculo (carro_id, llegada) VALUES (?, ?)";
    $stmt = $conex->prepare($consulta);
    return $stmt->execute([$carroId, $horaLlegada]);
}

// Obtener el ID del carro de la URL
$carroId = isset($_GET['carro_id']) ? intval($_GET['carro_id']) : 0;

// Obtener la hora de llegada del formulario
if (isset($_POST['submit'])) {
    $horaLlegada = $_POST['hora_llegada'];

    // Agregar la hora de llegada del carro
    agregarHoraLlegada($conex, $carroId, $horaLlegada);

    // Redireccionar a la misma página después de agregar la hora de llegada
    header("Location: reporte.php?carro_id=" . $carroId);
    exit();
}

// Obtener la información del carro y el sitio de estacionamiento
$consultaCarro = "SELECT * FROM carros WHERE id = ?";
$stmtCarro = $conex->prepare($consultaCarro);
$stmtCarro->execute([$carroId]);
$carro = $stmtCarro->fetch(PDO::FETCH_ASSOC);
$sitioEstacionamiento = $carro['sitio_estacionamiento'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Hora de Llegada - Carro <?php echo $carroId; ?></title>
    <link rel="stylesheet" href="reporte.css">
</head>
<body>
<ul>
      <li><a href="gestion_carros.php">gestion</a></li>
      <li><a href="informacion.html">informacion</a></li>
      <li><a href="#">Contacto</a></li>
      <li><a href="../inicio_registro/registro.php">REGISTARSE</a></li>
      <li style="float:right"><a class="active" href="#about">About</a></li>
    </ul>
    <h1>Agregar Hora de Llegada - Carro <?php echo $carroId; ?></h1>

    <p>Sitio de estacionamiento: <?php echo $sitioEstacionamiento; ?></p>

    <form method="POST" action="reporte.php?carro_id=<?php echo $carroId; ?>">
        <label for="hora_llegada">Hora de Llegada:</label>
        <input type="datetime-local" name="hora_llegada" required>
        <br>
        <input type="submit" name="submit" value="Guardar">
    </form>

    <a href="gestion_carros.php">Volver a la Gestión de Carros</a>

</body>
</html>

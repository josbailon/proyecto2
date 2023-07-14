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

// Función para obtener todos los registros de carros
function obtenerCarros($conex) {
    $consulta = "SELECT * FROM carros";
    $stmt = $conex->query($consulta);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para agregar un nuevo carro
function agregarCarro($conex, $marca, $modelo, $año, $color) {
    $consulta = "INSERT INTO carros (marca, modelo, año, color) VALUES (?, ?, ?, ?)";
    $stmt = $conex->prepare($consulta);
    return $stmt->execute([$marca, $modelo, $año, $color]);
}

// Función para editar un carro existente
function editarCarro($conex, $id, $marca, $modelo, $año, $color) {
    $consulta = "UPDATE carros SET marca = ?, modelo = ?, año = ?, color = ? WHERE id = ?";
    $stmt = $conex->prepare($consulta);
    return $stmt->execute([$marca, $modelo, $año, $color, $id]);
}

// Función para eliminar un carro
function eliminarCarro($conex, $id) {
    $consulta = "DELETE FROM carros WHERE id = ?";
    $stmt = $conex->prepare($consulta);
    return $stmt->execute([$id]);
}

// Manejar el envío del formulario para agregar o editar un carro
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $año = $_POST['año'];
    $color = $_POST['color'];

    if ($id) {
        // Editar un carro existente
        editarCarro($conex, $id, $marca, $modelo, $año, $color);
    } else {
        // Agregar un nuevo carro
        agregarCarro($conex, $marca, $modelo, $año, $color);
    }

    // Redireccionar a la misma página después de agregar/editar un carro
    header("Location: gestion_carros.php");
    exit();
}

// Manejar la eliminación de un carro
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    eliminarCarro($conex, $id);

    // Redireccionar a la misma página después de eliminar un carro
    header("Location: gestion_carros.php");
    exit();
}

// Obtener todos los registros de carros
$carros = obtenerCarros($conex);

// Obtener el carro para editar si se proporciona el ID de edición
if (isset($_GET['editar'])) {
    $idEditar = $_GET['editar'];
    $consulta = "SELECT * FROM carros WHERE id = ?";
    $stmt = $conex->prepare($consulta);
    $stmt->execute([$idEditar]);
    $carroEditar = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Carros</title>
    <link rel="stylesheet" href="principal.css">
</head>
<body>
     
<ul>
      <li><a href="gestion_carros.php">gestion</a></li>
      <li><a href="informacion.html">informacion</a></li>
      <li><a href="contactenos.html">Contacto</a></li>
      <li><a href="../inicio_registro/registro.php">REGISTARSE</a></li>
      <li style="float:right"><a class="active" href="#about">About</a></li>
    </ul>
    <h1>Gestión de Carros</h1>

    <!-- Formulario para agregar/editar un carro -->
    <form method="POST" action="gestion_carros.php">
        <?php if (isset($carroEditar)) : ?>
            <input type="hidden" name="id" value="<?php echo $carroEditar['id']; ?>">
        <?php endif; ?>
        <label for="marca">Marca:</label>
        <input type="text" name="marca" required value="<?php echo isset($carroEditar) ? $carroEditar['marca'] : ''; ?>">
        <br>
        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" required value="<?php echo isset($carroEditar) ? $carroEditar['modelo'] : ''; ?>">
        <br>
        <label for="año">Año:</label>
        <input type="number" name="año" required value="<?php echo isset($carroEditar) ? $carroEditar['año'] : ''; ?>">
        <br>
        <label for="color">Color:</label>
        <input type="text" name="color" required value="<?php echo isset($carroEditar) ? $carroEditar['color'] : ''; ?>">
        <br>
        <input type="submit" name="submit" value="<?php echo isset($carroEditar) ? 'Editar' : 'Guardar'; ?>">
    </form>

    <!-- Tabla de registros de carros -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Color</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carros as $carro) : ?>
                <tr>
                    <td><?php echo $carro['id']; ?></td>
                    <td><?php echo $carro['marca']; ?></td>
                    <td><?php echo $carro['modelo']; ?></td>
                    <td><?php echo $carro['año']; ?></td>
                    <td><?php echo $carro['color']; ?></td>
                    <td>
                        <a href="gestion_carros.php?editar=<?php echo $carro['id']; ?>">Editar</a>
                        <a href="gestion_carros.php?eliminar=<?php echo $carro['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>

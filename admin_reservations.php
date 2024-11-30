<?php
session_start();
include_once("db_connection.php");

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: loginpage.php");
    exit;
}

// Obtener todas las reservaciones
$query = "SELECT reservaciones.*, menu.nombre AS habitacion 
        FROM reservaciones 
        INNER JOIN menu ON reservaciones.codigo_habitacion = menu.codigo";
$result = $conn->query($query);
$reservaciones = $result->fetch_all(MYSQLI_ASSOC);

// Obtener usuarios para el select del formulario
$usuariosQuery = "SELECT id, CONCAT(nombre, ' ', apellido1) AS nombre_completo FROM usuarios";
$usuariosResult = $conn->query($usuariosQuery);
$usuarios = $usuariosResult->fetch_all(MYSQLI_ASSOC);

// Obtener habitaciones para el select del formulario
$habitacionesQuery = "SELECT codigo, nombre FROM menu";
$habitacionesResult = $conn->query($habitacionesQuery);
$habitaciones = $habitacionesResult->fetch_all(MYSQLI_ASSOC);

// Validar y procesar el formulario para agregar una nueva reservación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_reservation'])) {
    $codigoHabitacion = $_POST['codigo_habitacion'];
    $idUsuario = $_POST['id_usuario'];
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin = $_POST['fecha_fin'];

    // Validar que las fechas sean válidas
    $fechaActual = date('Y-m-d');
    if ($fechaInicio < $fechaActual || $fechaFin < $fechaInicio) {
        echo "<script>alert('Las fechas deben ser futuras y la fecha de fin debe ser posterior a la de inicio.'); window.history.back();</script>";
        exit;
    }

    // Validar que el usuario existe
    $userQuery = "SELECT id FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $idUsuario);
    $stmt->execute();
    $userResult = $stmt->get_result();
    if ($userResult->num_rows === 0) {
        echo "<script>alert('El ID del usuario no existe. Por favor, selecciona un usuario válido.'); window.history.back();</script>";
        exit;
    }

    // Generar un nuevo ID de reservación
    $query = "SELECT MAX(SUBSTRING(id_reservacion, 5)) AS max_id FROM reservaciones";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $newId = str_pad((int)$row['max_id'] + 1, 3, '0', STR_PAD_LEFT);
    $idReservacion = "BKN-" . $newId;

    // Insertar la nueva reservación
    $query = "INSERT INTO reservaciones (id_reservacion, codigo_habitacion, id_usuario, fecha_inicio, fecha_fin, estado) 
            VALUES (?, ?, ?, ?, ?, 'pendiente')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $idReservacion, $codigoHabitacion, $idUsuario, $fechaInicio, $fechaFin);
    if ($stmt->execute()) {
        echo "<script>alert('Reservación añadida exitosamente.'); window.location.href='admin_reservations.php';</script>";
    } else {
        echo "<script>alert('Error al añadir la reservación.');</script>";
    }
}

// Manejo de eliminación de reservaciones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_reservation'])) {
    $idReservacion = $_POST['id_reservacion'];

    // Eliminar la reservación
    $query = "DELETE FROM reservaciones WHERE id_reservacion = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $idReservacion);

    if ($stmt->execute()) {
        echo "<script>alert('Reservación eliminada exitosamente.'); window.location.href='admin_reservations.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar la reservación.');</script>";
    }
}

// Manejo de actualización de estado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $idReservacion = $_POST['id_reservacion'];
    $nuevoEstado = $_POST['nuevo_estado'];

    // Validar el nuevo estado
    if (!in_array($nuevoEstado, ['pendiente', 'confirmada', 'cancelada', 'facturada'])) {
        echo "<script>alert('Estado inválido.'); window.history.back();</script>";
        exit;
    }

    // Actualizar el estado de la reservación
    $query = "UPDATE reservaciones SET estado = ? WHERE id_reservacion = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $nuevoEstado, $idReservacion);

    if ($stmt->execute()) {
        echo "<script>alert('Estado actualizado exitosamente.'); window.location.href='admin_reservations.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el estado.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reservaciones</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hotelstylesheet.css">
</head>
    <style>
        .form-container {
            background-color: #e6dfc6; /* Fondo claro para el formulario */
            border: 3px dotted #5e968f; /* Borde verde */
            border-radius: 10px; /* Bordes redondeados */
            padding: 20px;
            margin-bottom: 20px;
            align-items: center;
            justify-content: center;
        }
    </style>
<body>

<?php include_once("admin_menu.php"); ?>

<div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px 10px 10px 10px; margin-top: 100px;"> <!--Contenedor de contenido-->
    <div class="container" style="margin: 20px 0px 20px 0px; ">
        <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px 10px 10px 10px; padding:20px;">
                <div class="container mt-5">
            <h1 class="text-center">Gestión de Reservaciones</h1>

            <!-- Tabla de reservaciones -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>ID Reservación</th>
                        <th>Habitación</th>
                        <th>Usuario</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservaciones as $reservacion): ?>
                        <tr>
                            <td><?php echo $reservacion['id_reservacion']; ?></td>
                            <td><?php echo $reservacion['habitacion']; ?></td>
                            <td><?php echo $reservacion['id_usuario']; ?></td>
                            <td><?php echo $reservacion['fecha_inicio']; ?></td>
                            <td><?php echo $reservacion['fecha_fin']; ?></td>
                            <td><?php echo ucfirst($reservacion['estado']); ?></td>
                            <td>
                                <!-- Formulario para actualizar estado -->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id_reservacion" value="<?php echo $reservacion['id_reservacion']; ?>">
                                    <select name="nuevo_estado" class="form-select form-select-sm d-inline-block w-auto">
                                        <option value="pendiente" <?php echo $reservacion['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                        <option value="confirmada" <?php echo $reservacion['estado'] === 'confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                                        <option value="cancelada" <?php echo $reservacion['estado'] === 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                                        <option value="facturada" <?php echo $reservacion['estado'] === 'facturada' ? 'selected' : ''; ?>>Facturada</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-primary btn-sm">Actualizar</button>
                                </form>
                                <!-- Formulario para eliminar -->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id_reservacion" value="<?php echo $reservacion['id_reservacion']; ?>">
                                    <button type="submit" name="delete_reservation" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta reservación?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="form-container">
            <h3 class="mt-5">Añadir nueva reservación</h3>
                <div class="row" style="margin-bottom: 30px;">
                    <form method="POST" class="mt-3">
                        <input type="hidden" name="add_reservation" value="1">
                        <div class="mb-3">
                            <label for="codigo_habitacion" class="form-label">Código Habitación</label>
                            <select name="codigo_habitacion" id="codigo_habitacion" class="form-select" required>
                                <option value="">Seleccione una habitación</option>
                                <?php foreach ($habitaciones as $habitacion): ?>
                                    <option value="<?php echo $habitacion['codigo']; ?>">
                                        <?php echo htmlspecialchars($habitacion['codigo'] . ' - ' . $habitacion['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_usuario" class="form-label">Usuario</label>
                            <select name="id_usuario" id="id_usuario" class="form-select" required>
                                <option value="">Seleccione un usuario</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?php echo $usuario['id']; ?>"><?php echo htmlspecialchars($usuario['nombre_completo']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Añadir Reservación</button>
                            <button type="reset" class="btn btn-secondary">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<?php include_once("footer.html"); ?>
</body>
</html>

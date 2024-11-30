<?php
session_start();
include_once("db_connection.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: loginpage.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoHabitacion = $_POST['codigo'];
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin = $_POST['fecha_fin'];
    $idUsuario = $_SESSION['id']; // ID del usuario logueado

    // Validar que las fechas no estén en conflicto
    $query = "SELECT * FROM reservaciones 
            WHERE codigo_habitacion = ? AND (
                (fecha_inicio BETWEEN ? AND ?) OR 
                (fecha_fin BETWEEN ? AND ?) OR 
                (? BETWEEN fecha_inicio AND fecha_fin) OR 
                (? BETWEEN fecha_inicio AND fecha_fin)
            )";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $codigoHabitacion, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Las fechas seleccionadas ya están reservadas. Por favor, elige otras fechas.'); window.history.back();</script>";
        exit;
    }

    // Generar ID de la reservación
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
        echo "<script>alert('Reserva realizada exitosamente.'); window.location.href='catalog.php';</script>";
    } else {
        echo "<script>alert('Error al realizar la reserva.'); window.history.back();</script>";
    }
}
?>

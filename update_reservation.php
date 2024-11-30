<?php
session_start();
include_once("db_connection.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: loginpage.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idReservacion = $_POST['id_reservacion'];
    $action = $_POST['action']; // "confirmar" o "cancelar"

    // Validar la acción
    if ($action === 'confirmar') {
        $nuevoEstado = 'confirmada';
    } elseif ($action === 'cancelar') {
        $nuevoEstado = 'cancelada';
    } else {
        echo "<script>alert('Acción no válida.'); window.history.back();</script>";
        exit;
    }

    // Actualizar la reservación
    $query = "UPDATE reservaciones SET estado = ? WHERE id_reservacion = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $nuevoEstado, $idReservacion);

    if ($stmt->execute()) {
        echo "<script>alert('Reservación actualizada correctamente.'); window.location.href='user_reservations.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la reservación.'); window.history.back();</script>";
    }
}
?>

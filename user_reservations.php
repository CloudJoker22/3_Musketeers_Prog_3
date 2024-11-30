<?php
session_start();
include_once("db_connection.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: loginpage.php");
    exit;
}

$idUsuario = $_SESSION['id']; // ID del usuario logueado

// Obtener las reservaciones del usuario
$query = "SELECT * FROM reservaciones 
        INNER JOIN menu ON reservaciones.codigo_habitacion = menu.codigo
        WHERE id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$reservaciones = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Bits&uacute; - Mis Reservaciones</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hotelstylesheet.css">
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php include_once("menu.php"); ?>

<div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px 10px 10px 10px; margin-top: 100px;"> <!--Contenedor de contenido-->
    <div class="container" style="margin: 20px 0px 20px 0px; ">
        <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px 10px 10px 10px; padding:20px;">
            <div class="container mt-5">
                <h1 class="text-center">Mis Reservaciones</h1>

                <div class="text-end mb-3">
                    <a href="export_reservations.php" class="btn btn-primary">Exportar a PDF</a>
                </div>

                <?php if (count($reservaciones) > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Reservación</th>
                                <th>Habitación</th>
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
                                    <td><?php echo $reservacion['nombre']; ?></td>
                                    <td><?php echo $reservacion['fecha_inicio']; ?></td>
                                    <td><?php echo $reservacion['fecha_fin']; ?></td>
                                    <td><?php echo ucfirst($reservacion['estado']); ?></td>
                                    <td>
                                        <?php if ($reservacion['estado'] === 'pendiente'): ?>
                                            <form method="POST" action="update_reservation.php" style="display: inline;">
                                                <input type="hidden" name="id_reservacion" value="<?php echo $reservacion['id_reservacion']; ?>">
                                                <input type="hidden" name="action" value="confirmar">
                                                <button type="submit" class="btn btn-success btn-sm">Confirmar</button>
                                            </form>
                                            <form method="POST" action="update_reservation.php" style="display: inline;">
                                                <input type="hidden" name="id_reservacion" value="<?php echo $reservacion['id_reservacion']; ?>">
                                                <input type="hidden" name="action" value="cancelar">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de cancelar esta reservación?')">Cancelar</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-muted">No disponible</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">No tienes reservaciones registradas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once("footer.html"); ?>

</body>
</html>

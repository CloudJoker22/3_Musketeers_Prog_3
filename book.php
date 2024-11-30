<?php 
session_start();
include_once("db_connection.php");

// Verificar si hay un usuario logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: loginpage.php");
    exit;
}

// Verificar que se reciba el parámetro `codigo`
if (!isset($_GET['codigo']) || empty($_GET['codigo'])) {
    die("<div style='text-align: center; margin-top: 50px;'>
            <h1>Reservar Habitación</h1>
            <p style='color: red;'>No se encontró información de la habitación seleccionada.</p>
        </div>");
}

// Obtener el código de la habitación
$codigo = $_GET['codigo'];

// Consultar la información de la habitación desde la base de datos
$query = "SELECT * FROM menu WHERE codigo = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $codigo);
$stmt->execute();
$result = $stmt->get_result();
$habitacion = $result->fetch_assoc();

if (!$habitacion) {
    die("<div style='text-align: center; margin-top: 50px;'>
            <h1>Reservar Habitación</h1>
            <p style='color: red;'>No se encontró información de la habitación seleccionada.</p>
        </div>");
}

// Construir la ruta de la imagen
$ruta_imagen = "resources/pictures/habitaciones/" . htmlspecialchars($habitacion['codigo']) . ".jpg";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar - Hotel Bitsú</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hotelstylesheet.css">
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>
<!-- Script de validación -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');

        form.addEventListener('submit', function (event) {
            const today = new Date().toISOString().split('T')[0];
            if (fechaInicio.value < today) {
                alert('La fecha de inicio no puede ser en el pasado.');
                event.preventDefault();
                return;
            }

            if (fechaFin.value <= fechaInicio.value) {
                alert('La fecha de fin debe ser posterior a la fecha de inicio.');
                event.preventDefault();
                return;
            }
        });
    });
</script>
<body>
<?php include_once("menu.php"); ?>

<div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px; margin-top: 100px;">
    <div class="container" style="margin: 20px 0;">
        <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px; padding:20px;">
            <div class="container" style="margin-top: 50px;">
                <h1 class="text-center">Reservar Habitación</h1>
                <div class="card" style="margin-top: 20px; position: relative; background-image: url('<?php echo $ruta_imagen; ?>'); background-size: cover; background-position: center; border-radius: 10px; color: white;">
                    <div class="card-header text-center bg-primary text-white" style="opacity: 0.9;">
                        <?php echo htmlspecialchars($habitacion['nombre']); ?>
                    </div>
                    <div class="card-body" style="background-color: rgba(0, 0, 0, 0.6); padding: 20px; border-radius: 0 0 10px 10px;">
                        <p><strong>Tipo de habitación:</strong> <?php echo htmlspecialchars($habitacion['tipo']); ?></p>
                        <p><strong>Mayordomo a cargo:</strong> <?php echo htmlspecialchars($habitacion['mayordomo']); ?></p>
                        <p><strong>Costo por noche:</strong> $<?php echo htmlspecialchars($habitacion['costo']); ?></p>
                        <form method="POST" action="process_reservation.php">
                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($habitacion['codigo']); ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="catalog.php" class="btn btn-secondary">Volver</a>
                                <button type="submit" class="btn btn-success">Confirmar Reserva</button>
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
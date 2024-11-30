<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Incluye el autoloader de Composer

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $asunto = trim($_POST['asunto']); // Captura el asunto desde el dropdown
    $mensaje = trim($_POST['mensaje']);

    // Validar campos
    if (empty($nombre) || empty($correo) || empty($telefono) || empty($asunto) || empty($mensaje)) {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
        exit;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Correo electrónico no válido.'); window.history.back();</script>";
        exit;
    }

    // Configurar PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'bitsuinfo@gmail.com';   // Cambiar por el correo SMTP que usará para enviar
        $mail->Password = 'tlvv groe ghzw ojaq';        // Cambiar por la contraseña o clave de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

         // Configurar codificación UTF-8
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        // Configuración del correo
        $mail->setFrom('bitsucorpltd@gmail.com', 'Administrador de Hotel Bitsú');
        $mail->addAddress('bitsucorpltd@gmail.com'); // Destinatario principal
        $mail->addCC($correo); // Con copia al remitente

        // Asunto y cuerpo
        $mail->Subject = $asunto;
        $mail->Body = "Nombre: $nombre\nCorreo: $correo\nTeléfono: $telefono\n\nMensaje:\n$mensaje";

        // Enviar correo
        $mail->send();
        echo "<script>alert('Tu mensaje ha sido enviado exitosamente.'); window.location.href='contact.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error al enviar el mensaje: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hotel Bistú- Cont&aacute;ctenos</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hotelstylesheet.css">
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <!-- Incluyendo la API de Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDaeWicvigtP9xPv919E-RNoxfvC-Hqik&callback=initMap" async defer></script>
</head>
    <script>
            // Función para inicializar el mapa
            function initMap() {
            // La ubicación del hotel
            var ubicacionHotel = { lat: 9.46205244707638, lng: -83.60072211328293}; 

            // Opciones del mapa
            var mapOptions = {
                zoom: 15,
                center: ubicacionHotel,
                mapTypeId: 'roadmap'
            };

            // Crear el mapa y añadirlo al contenedor con id "map"
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);

            // Añadir un marcador en la ubicación del hotel
            var marker = new google.maps.Marker({
                position: ubicacionHotel,
                map: map,
                title: "Hotel Bitsú"
            });
        }
    </script>
<body> 

<?php
include_once("menu.php"); // Asegúrate de incluir correctamente el menú
?>

<div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px 10px 10px 10px; margin-top: 150px; padding: 20px; align-items:center">

    <div class="row">
        <div class="col">
            <div class="container mt-5" style="background-color: #e6dfc6; border: #1b2e28 dotted 3px; border-radius: 10px; padding: 20px; margin: 0px 0px 30px 0px;">
                    <h2 style="margin-bottom: 20px;">Contáctenos</h2>
                    <form action="contact.php" method="POST">
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>

                        <!-- Correo electrónico -->
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo electrónico:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>

                        <!-- Teléfono -->
                        <div class="mb-3">
                            <label for="telefono">Teléfono:</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        </div>

                        <!-- Asunto (Dropdown) -->
                        <div class="mb-3">
                            <label for="asunto" class="form-label">Asunto:</label>
                            <select class="form-select" id="asunto" name="asunto" required>
                                <option value="Consultas">Consultas</option>
                                <option value="Reclamos">Reclamos</option>
                                <option value="Feedback">Feedback</option>
                            </select>
                        </div>

                        <!-- Mensaje -->
                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Escriba su mensaje:</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                        </div>

                        <!-- Botones -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Enviar</button>
                            <button type="reset" class="btn btn-danger" style="margin-bottom: 20px;">Cancelar</button>
                        </div>
                    </form>
            </div>
        </div>
        <div class="col">
            <div class="container mt-5" style="background-color:#e6dfc6; border: #1b2e28 dotted 3px; border-radius: 10px 10px 10px 10px; padding: 20px; margin: 0px 0px 30px 0px;">
            <!-- Contenedor del mapa -->
            <h2 style="margin-bottom: 20px;">Direcci&oacute;n:</h2>
            <p>F96X+RPC Rivas, San José</p>
            <p>Cerca del Liceo Canaán, San Gerardo de Rivas, Perez Zeledon, San José, Costa Rica.</p>
                <div id="map" style="height: 205px; width: 100%; border-radius: 10px; margin-top: 30px;"></div>
            <h3 style="margin: 20px 0px 10px 0px; font-style: italic;">Contactos:</h3>
            <p>Tel&eacute;fono: 6361-4609</p>
            <p>Correo dpto. ventas: bitsuinfo@gmail.com</p>
            </div>
        </div>
    </div>
    
</div>

<?php
include_once("footer.html"); // Asegúrate de incluir correctamente el footer
?>

</body>
</html>

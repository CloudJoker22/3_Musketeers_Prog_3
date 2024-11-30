<?php
// Inicia el proceso de envío solo si el formulario se envía (es decir, con el método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y sanitizarlos
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $mensaje = htmlspecialchars($_POST['mensaje']);
    $telefono = htmlspecialchars($_POST['telefono']);

    // Validar el correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('El correo electrónico no es válido.'); window.location.href='contacto.php';</script>";
        exit;
    }

    // Dirección de correo a la que se enviará el mensaje
    $to = "bitsucorpltd@gmail.com"; // Correo de destino
    $subject = "Nuevo mensaje de contacto desde el sitio web";

    // Cuerpo del mensaje
    $message = "Nombre: $nombre\n";
    $message .= "Correo electrónico: $email\n";
    $message .= "Teléfono: $telefono\n";
    $message .= "Mensaje: \n$mensaje\n";

    // Cabeceras del correo
    $headers = "From: $email" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Enviar el correo
    if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('Gracias por tu mensaje, lo hemos recibido satisfactoriamente y en breve lo estaremos analizando.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Hubo un error al enviar tu mensaje. Por favor, inténtalo nuevamente.'); window.location.href='contacto.php';</script>";
    }
}
?>
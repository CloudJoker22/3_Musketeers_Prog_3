<?php
$servername = "localhost";
$username = "root";  // Predeterminado en XAMPP
$password = "";  // Sin contraseña por defecto
$dbname = "hotel_bitsu";  // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

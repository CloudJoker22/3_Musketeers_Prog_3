<?php
include_once("db_connection.php"); // Incluye la conexión a la base de datos

// Consulta para verificar si el usuario administrador ya existe
$query = "SELECT * FROM usuarios WHERE usuario = 'admin'";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    // Si no existe el usuario administrador, lo creamos
    $hashed_password = password_hash('admin123*+', PASSWORD_BCRYPT); // Contraseña encriptada
    $insert_query = "INSERT INTO usuarios (usuario, nombre, correo, contrasena, tipo_usuario) 
                     VALUES ('admin', 'Administrador', 'admin@hotelbitsu.com', '$hashed_password', 'admin')";

    if ($conn->query($insert_query)) {
        echo "Usuario administrador creado exitosamente.";
    } else {
        echo "Error al crear el administrador: " . $conn->error;
    }
} else {
    echo "El usuario administrador ya existe.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>

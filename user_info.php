<?php
session_start();
include_once("db_connection.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: loginpage.php"); // Redirige a login si no está autenticado
    exit();
}

$user_id = $_SESSION['id'];  // ID del usuario logueado

// Consultar la información del usuario
$query = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $usuario = $_POST['usuario'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Verificar si las contraseñas coinciden
    if ($nueva_contrasena !== $confirmar_contrasena) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.location.href='user_info.php';</script>";
        exit();
    }

    // Si la contraseña es diferente, la encriptamos
    if (!empty($nueva_contrasena)) {
        $nueva_contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $update_query = "UPDATE usuarios SET nombre = ?, apellido1 = ?, apellido2 = ?, correo = ?, telefono = ?, usuario = ?, contrasena = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('sssssssi', $nombre, $apellido1, $apellido2, $correo, $telefono, $usuario, $nueva_contrasena, $user_id);
    } else {
        // Si no se ha cambiado la contraseña, actualizamos solo los demás datos
        $update_query = "UPDATE usuarios SET nombre = ?, apellido1 = ?, apellido2 = ?, correo = ?, telefono = ?, usuario = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('ssssssi', $nombre, $apellido1, $apellido2, $correo, $telefono, $usuario, $user_id);
    }

    if ($update_stmt->execute()) {
        echo "<script>alert('Información actualizada correctamente.'); window.location.href='user_info.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la información.'); window.location.href='user_info.php';</script>";
    }
}
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Hotel Bistú- Gestion de usuario</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hotelstylesheet.css">
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>

<!-- Script para confirmar los cambios -->
<script>
function confirmChanges() {
    return confirm("¿Está seguro de que desea guardar los cambios?");
}
</script>

<body> 

<?php
include_once("menu.php");
?>

<div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px 10px 10px 10px; margin-top: 150px;"> <!--Contenedor de contenido-->
    <div class="container" style="margin: 20px 0px 20px 0px">
        <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px 10px 10px 10px;">
            <div id="login_container" style="padding: 20px;">
                <h2 class="text-center fst-italic" style="padding: 20px;">Información de usuario</h2>
                <div class="row justify-content-center">
                    <!-- Formulario de Registro -->
                    <div class="col-md-8"> <!--los comandos php echo $user['parametro'] se utilizan para cargar la respectiva info en su espacio-->
                        <form action="user_info.php" method="POST" onsubmit="return confirmChanges()">
                            <!-- Campo para identificación (llave primaria) -->
                            <div class="mb-3">
                                <label for="id" class="form-label">ID de Usuario</label>
                                <input type="text" class="form-control" id="id" name="id" value=" <?php echo $user['id']; ?>" readonly>
                            </div>

                            <!-- Campo para usuario -->
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $user['usuario']; ?>" required>
                            </div>

                            <!-- Campo para nombre -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $user['nombre']; ?>" required>
                            </div>

                            <!-- Campo para primer apellido -->
                            <div class="mb-3">
                                <label for="apellido1" class="form-label">Primer Apellido</label>
                                <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?php echo $user['apellido1']; ?>" required>
                            </div>

                            <!-- Campo para segundo apellido -->
                            <div class="mb-3">
                                <label for="apellido2" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?php echo $user['apellido2']; ?>" required>
                            </div>

                            <!-- Campo para correo electrónico -->
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $user['correo']; ?>" required>
                            </div>

                            <!-- Campo para teléfono -->
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $user['telefono']; ?>" required>
                            </div>

                            <!-- Campo para cambiar la contraseña -->
                            <div class="mb-3">
                                <label for="nueva_contrasena" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" placeholder="Ingrese su nueva contraseña">
                            </div>

                            <!-- Campo para confirmar la nueva contraseña -->
                            <div class="mb-3">
                                <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirme su nueva contraseña">
                            </div>

                            <!-- Botón de actualización -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Actualizar Información</button>
                                <button type="reset" class="btn btn-secondary" style="margin-bottom: 20px;">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!--fin de contenedor-->

<?php
include_once("footer.html");
?>

</body>
</html>

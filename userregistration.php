    <?php
    include_once("db_connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $identificacion = $_POST['identificacion'];  // Cédula del usuario
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];  // Contraseña
        $confirm_contrasena = $_POST['confirm_password'];  // Confirmación de la contraseña
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];

        // Verificar que las contraseñas coincidan
        if ($contrasena !== $confirm_contrasena) {
            echo "<script>alert('Las contraseñas no coinciden.'); window.location.href='userregistration.php';</script>";
            exit; // Termina el script y no registra al usuario
        }

        // Verificar si el usuario, correo o cédula ya existen
        $query = "SELECT * FROM usuarios WHERE usuario = ? OR correo = ? OR id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $usuario, $correo, $identificacion);  // Añadimos la cédula en la búsqueda
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('El usuario, correo o cédula ya están registrados.'); window.location.href='userregistration.php';</script>";
        } else {
            // Encriptar la contraseña
            $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

            // Insertar nuevo usuario en la base de datos
            $insert_query = "INSERT INTO usuarios (id, usuario, contrasena, nombre, apellido1, apellido2, correo, telefono, tipo_usuario)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'normal')";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param('ssssssss', $identificacion, $usuario, $contrasena_hash, $nombre, $apellido1, $apellido2, $correo, $telefono);

            if ($insert_stmt->execute()) {
                // Si se registró correctamente, mostrar mensaje de éxito y redirigir
                echo "<script>alert('Usuario registrado con éxito.'); window.location.href='loginpage.php';</script>";
            } else {
                echo "<script>alert('Error al registrar el usuario. Vuelva a intentarlo'); window.location.href='userregistration.php';</script>";
            }
        }
    }
    ?>

        <!-- Script de validación en JavaScript -->
        <script>
            function validatePasswords() {
                var password = document.getElementById("contrasena").value;
                var confirmPassword = document.getElementById("confirm_password").value;

                if (password !== confirmPassword) {
                    alert("Las contraseñas no coinciden.");
                    return false;  // Evita que se envíe el formulario
                }

                return true;  // Permite que el formulario se envíe
            }
        </script>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Hotel Bistú- Registro de Usuario</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hotelstylesheet.css">
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body> 

<?php
include_once("menu.php");
?>

<div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px 10px 10px 10px; margin-top: 150px;"> <!--Contenedor de contenido-->
    <div class="container" style="margin: 20px 0px 20px 0px">
        <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px 10px 10px 10px;">
            <div id="login_container" style="padding: 20px;">
                <h2 class="text-center fst-italic" style="padding: 20px;">Registro de usuario</h2>
                <div class="row justify-content-center">
                    <!-- Formulario de Registro -->
                    <div class="col-md-8">
                        <form action="userregistration.php" method="POST" onsubmit="return validatePasswords()">
                            <!-- Campo para identificación (llave primaria) -->
                            <div class="mb-3">
                                <label for="identificacion" class="form-label">Identificación</label>
                                <input type="text" class="form-control" id="identificacion" name="identificacion" placeholder="Ingrese su identificación" required>
                            </div>

                            <!-- Campo para nombre -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
                            </div>

                            <!-- Campo para primer apellido -->
                            <div class="mb-3">
                                <label for="apellido1" class="form-label">Primer Apellido</label>
                                <input type="text" class="form-control" id="apellido1" name="apellido1" placeholder="Ingrese su primer apellido" required>
                            </div>

                            <!-- Campo para segundo apellido -->
                            <div class="mb-3">
                                <label for="apellido2" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2" placeholder="Ingrese su segundo apellido" required>
                            </div>

                            <!-- Campo para correo electrónico -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo electrónico" required>
                            </div>

                            <!-- Campo para teléfono -->
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingrese su número de teléfono" required>
                            </div>

                            <!-- Campo para usuario -->
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese su nombre de usuario" required>
                            </div>

                            <!-- Campo para contraseña -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>
                            </div>

                            <!-- Confirmación de contraseña -->
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirme su contraseña" required>
                            </div>

                            <!-- Botón de registro -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Registrar</button>
                            </div>

                            <!-- Enlace para ir a login -->
                            <div class="text-center" style="margin-top: 20px;">
                                <a href="loginpage.php" class="btn btn-link">¿Ya tienes cuenta? Iniciar sesión</a>
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

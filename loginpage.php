<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Hotel Bistú- Inicio de sesión</title>
        <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/hotelstylesheet.css">
        <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <?php
    session_start();
    include_once("db_connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario_o_email = $_POST['email'];
        $contrasena = $_POST['password'];

        // Consultar al usuario en la base de datos usando nombre de usuario o correo electrónico
        $query = "SELECT * FROM usuarios WHERE usuario = ? OR correo = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $usuario_o_email, $usuario_o_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verificar si el usuario existe y la contraseña es correcta
        if ($user && password_verify($contrasena, $user['contrasena'])) {
            // Autenticación exitosa
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['nombre'] = $user['nombre']; // Guardamos solo el nombre
            $_SESSION['id'] = $user['id'];
            $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
            header("Location: index.php"); // Redirigir a la página privada (dashboard)
            exit;
        } else {
            echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='loginpage.php';</script>";
        }
    }
    ?>

    <body> 
    
<?php

include_once("menu.php")

?>

    <div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px 10px 10px 10px; margin-top: 150px;">
        <div class="container" style="margin: 20px 0px 20px 0px"> <!--Contenedor de slider habitaciones-->
                <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px 10px 10px 10px;">
                    <!-- Información General del Hotel -->
                    <div id="login_container" style="padding: 20px;">
                    <h2 class="text-center fst-italic" style="padding: 20px;">Acceso de Usuario</h2>
                        <div class="row justify-content-center">

                            <!-- Formulario de Login -->
                            <div class="col-md-6">

                                <form action="loginpage.php" method="POST">
                                    
                                    <!-- Campo para correo electrónico -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo electrónico o Nombre de usuario:</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico o nombre de usuario" required>
                                    </div>

                                    <!-- Campo para la contraseña -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña:</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
                                    </div>

                                    <!-- Botón de acción (login) -->
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                                    </div>

                                    <!-- Botón de reset -->
                                    <div class="text-center" style="margin-top: 10px;">
                                        <button type="reset" class="btn btn-secondary">Limpiar</button>
                                    </div>

                                    <!-- Botón para crear usuario -->
                                    <div class="text-center" style="margin-top: 20px;">
                                        <a href="userregistration.php" class="btn btn-link">¿No tienes cuenta? Crear Usuario</a>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!--fin de contenedor-->

    </div> <!--End of content container-->

<?php
include_once("footer.html")
?>

</body>
    
</html>

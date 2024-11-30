<?php
session_start();
include_once("db_connection.php");

// Verificar si el usuario es administrador
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: loginpage.php");
    exit;
}

// Manejar solicitudes CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        // Crear nuevo usuario
        $id = $_POST['id'];
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $nueva_contrasena = $_POST['nueva_contrasena'];
        $confirmar_contrasena = $_POST['confirmar_contrasena'];
        $tipo_usuario = $_POST['tipo_usuario'];

        // Validar contraseñas
        if (empty($nueva_contrasena) || $nueva_contrasena !== $confirmar_contrasena) {
            echo "<script>alert('Las contraseñas no coinciden o están vacías.'); window.location.href='user_catalog.php';</script>";
            exit();
        }

        // Encriptar contraseña
        $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

        $query = "INSERT INTO usuarios (id, usuario, nombre, apellido1, apellido2, correo, telefono, contrasena, tipo_usuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssss", $id, $usuario, $nombre, $apellido1, $apellido2, $correo, $telefono, $hashed_password, $tipo_usuario);

        if ($stmt->execute()) {
            echo "<script>alert('Usuario creado exitosamente.'); window.location.href='user_catalog.php';</script>";
        } else {
            echo "<script>alert('Error al crear el usuario: {$conn->error}'); window.location.href='user_catalog.php';</script>";
        }
    } elseif ($action == 'edit') {
        // Editar usuario existente
        $id = $_POST['id'];
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $tipo_usuario = $_POST['tipo_usuario'];
        $nueva_contrasena = $_POST['nueva_contrasena'];
        $confirmar_contrasena = $_POST['confirmar_contrasena'];

        // Validar contraseñas
        if (!empty($nueva_contrasena) && $nueva_contrasena !== $confirmar_contrasena) {
            echo "<script>alert('Las contraseñas no coinciden.'); window.location.href='user_catalog.php';</script>";
            exit();
        }

        // Si hay nueva contraseña, actualizamos con ella
        if (!empty($nueva_contrasena)) {
            $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
            $query = "UPDATE usuarios SET usuario=?, nombre=?, apellido1=?, apellido2=?, correo=?, telefono=?, tipo_usuario=?, contrasena=? WHERE id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssssssi", $usuario, $nombre, $apellido1, $apellido2, $correo, $telefono, $tipo_usuario, $hashed_password, $id);
        } else {
            // Si no hay cambio de contraseña, actualizamos sin ella
            $query = "UPDATE usuarios SET usuario=?, nombre=?, apellido1=?, apellido2=?, correo=?, telefono=?, tipo_usuario=? WHERE id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssssi", $usuario, $nombre, $apellido1, $apellido2, $correo, $telefono, $tipo_usuario, $id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Usuario actualizado correctamente.'); window.location.href='user_catalog.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar usuario.'); window.location.href='user_catalog.php';</script>";
        }
    } elseif ($action == 'delete') {
        // Eliminar usuario
        $id = $_POST['id'];
        $query = "DELETE FROM usuarios WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Usuario eliminado correctamente.'); window.location.href='user_catalog.php';</script>";
        } else {
            echo "<script>alert('Error al eliminar usuario.'); window.location.href='user_catalog.php';</script>";
        }
    }
}

// Obtener lista de usuarios
$query = "SELECT * FROM usuarios";
$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Bitsú Admin- Usuarios</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hotelstylesheet.css">
</head>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            background-color: #e6dfc6; /* Fondo del contenedor */
            border: 3px dotted #5e968f; /* Borde del contenedor */
            border-radius: 10px; /* Bordes redondeados */
            padding: 20px;
            margin-top: 20px;
            flex: 1;
            overflow-y: auto; /* Permitir desplazamiento vertical */
        }

        .form-container {
            background-color: #e6dfc6; /* Fondo claro para el formulario */
            border: 3px dotted #5e968f; /* Borde verde */
            border-radius: 10px; /* Bordes redondeados */
            padding: 20px;
            margin-bottom: 20px;
        }

        .table-responsive {
            overflow-x: auto; /* Permitir desplazamiento horizontal */
            width: 100%;
        }
    </style>
    <script>
        // Modificar el formulario según el modo (Agregar o Editar)
        function editUser(id, usuario, nombre, apellido1, apellido2, correo, telefono, tipo_usuario) {
            document.getElementById('action').value = 'edit';
            document.getElementById('id').value = id;
            document.getElementById('id').readOnly = true; // Solo readonly en modo edición
            document.getElementById('usuario').value = usuario;
            document.getElementById('nombre').value = nombre;
            document.getElementById('apellido1').value = apellido1;
            document.getElementById('apellido2').value = apellido2;
            document.getElementById('correo').value = correo;
            document.getElementById('telefono').value = telefono;
            document.getElementById('tipo_usuario').value = tipo_usuario;
            document.getElementById('nueva_contrasena').value = ''; // Dejar la contraseña vacía
            document.getElementById('confirmar_contrasena').value = ''; // Dejar la confirmación vacía
        }

        function resetForm() {
            document.getElementById('action').value = 'add';
            document.getElementById('id').readOnly = false; // Habilitar el campo ID en modo agregar
            document.querySelector('form').reset();
        }

        function confirmSubmit() {
            const action = document.getElementById('action').value;
            if (action === 'add') {
                return confirm('¿Está seguro de que desea agregar este usuario?');
            }
            return true;
        }
    </script>
<body>

<?php
include_once("admin_menu.php")
?>

<div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px 10px 10px 10px; margin-top: 100px;"> <!--Contenedor de contenido-->
    <div class="container" style="margin: 20px 0px 20px 0px; ">
        <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px 10px 10px 10px; padding:20px;">
            <div class="container mt-5">
                <h1 class="text-center">Gestión de Usuarios</h1>
                <div class="form-container">
                    <form method="POST" onsubmit="return confirmSubmit();">
                        <input type="hidden" name="action" id="action" value="add">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id" class="form-label">ID</label>
                                <input type="text" name="id" id="id" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" name="usuario" id="usuario" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido1" class="form-label">Primer Apellido</label>
                                <input type="text" name="apellido1" id="apellido1" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido2" class="form-label">Segundo Apellido</label>
                                <input type="text" name="apellido2" id="apellido2" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" name="correo" id="correo" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                                <select name="tipo_usuario" id="tipo_usuario" class="form-control" required>
                                    <option value="normal">Normal</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nueva_contrasena" class="form-label">Nueva Contraseña</label>
                                <input type="password" name="nueva_contrasena" id="nueva_contrasena" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
                                <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Cancelar</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="table-primary">
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['usuario']; ?></td>
                                    <td><?php echo $user['nombre']; ?></td>
                                    <td><?php echo $user['apellido1']; ?></td>
                                    <td><?php echo $user['apellido2']; ?></td>
                                    <td><?php echo $user['correo']; ?></td>
                                    <td><?php echo $user['telefono']; ?></td>
                                    <td><?php echo $user['tipo_usuario']; ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="editUser('<?php echo $user['id']; ?>', '<?php echo $user['usuario']; ?>', '<?php echo $user['nombre']; ?>', '<?php echo $user['apellido1']; ?>', '<?php echo $user['apellido2']; ?>', '<?php echo $user['correo']; ?>', '<?php echo $user['telefono']; ?>', '<?php echo $user['tipo_usuario']; ?>')">Editar</button>
                                        <form method="POST" style="display: inline-block;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once("footer.html")
?>

</body>
</html>

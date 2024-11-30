<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: loginpage.php");
    exit;
}

include_once("db_connection.php"); // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        // Agregar nuevo servicio o habitación
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $tipo = ucfirst(strtolower($_POST['tipo'])); // Capitalizar el tipo
        $mayordomo = $_POST['mayordomo'];
        $costo = $_POST['costo'];

        // Manejar subida de imagen
        if (!empty($_FILES['imagen']['name'])) {
            $target_dir = "resources/pictures/habitaciones/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true); // Crear directorio si no existe
            }
            $target_file = $target_dir . $codigo . ".jpg"; // Guardar imagen con el nombre del código como .jpg
            move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file);
        }

        $query = "INSERT INTO menu (codigo, nombre, tipo, mayordomo, costo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssd", $codigo, $nombre, $tipo, $mayordomo, $costo);
        if ($stmt->execute()) {
            $message = "Servicio agregado exitosamente.";
        } else {
            $message = "Error al agregar servicio: " . $conn->error;
        }
    } elseif ($action == 'edit') {
        // Editar servicio o habitación existente
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $tipo = ucfirst(strtolower($_POST['tipo']));
        $mayordomo = $_POST['mayordomo'];
        $costo = $_POST['costo'];

        $query = "UPDATE menu SET nombre=?, tipo=?, mayordomo=?, costo=? WHERE codigo=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssds", $nombre, $tipo, $mayordomo, $costo, $codigo);
        if ($stmt->execute()) {
            $message = "Servicio actualizado exitosamente.";
        } else {
            $message = "Error al actualizar servicio: " . $conn->error;
        }
    } elseif ($action == 'delete') {
        // Eliminar servicio o habitación
        $codigo = $_POST['codigo'];

        $query = "DELETE FROM menu WHERE codigo=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $codigo);
        if ($stmt->execute()) {
            // Eliminar la imagen asociada
            $image_path = "resources/pictures/habitaciones/" . $codigo . ".jpg";
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $message = "Habitación eliminado exitosamente.";
        } else {
            $message = "Error al eliminar Habitación: " . $conn->error;
        }
    }
}

// Obtener lista de servicios
$query = "SELECT * FROM menu";
$result = $conn->query($query);
$services = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Bitsú Admin- Habitaciones</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hotelstylesheet.css">
</head>
    <style>
        .content-wrapper {
                background-color: #e6dfc6; /* Fondo claro */
                border-radius: 10px; /* Bordes redondeados */
                padding: 20px;
                margin-top: 20px;
            }

        .form-container {
            background-color: #e6dfc6; /* Fondo claro para el formulario */
            border: 3px dotted #5e968f; /* Borde verde */
            border-radius: 10px; /* Bordes redondeados */
            padding: 20px;
            margin-bottom: 20px;
        }

        .form-label {
            color: #1b2e28; /* Texto oscuro para etiquetas */
        }

    </style>
    <script>
        function editService(codigo, nombre, tipo, mayordomo, costo) {
            document.getElementById('action').value = 'edit';
            document.getElementById('codigo').value = codigo;
            document.getElementById('nombre').value = nombre;
            document.getElementById('tipo').value = tipo;
            document.getElementById('mayordomo').value = mayordomo;
            document.getElementById('costo').value = costo;
            // Deshabilitar el campo de imagen al editar
            document.getElementById('imagen').disabled = true;
        }

        function resetForm() {
            document.getElementById('action').value = 'add';
            document.querySelector('form').reset();
            document.getElementById('imagen').disabled = false;
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
            <h1 class="text-center">Catálogo de Habitaciones</h1>
                    <?php if (isset($message)): ?>
                        <div class="alert alert-info"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <!-- Formulario para agregar o editar habitaciones -->
                    <div class="form-container">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" id="action" value="add">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" name="codigo" id="codigo" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <select name="tipo" id="tipo" class="form-control">
                                        <option value="Riverfront">Riverfront</option>
                                        <option value="Montaña">Montaña</option>
                                        <option value="Económica">Económica</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="mayordomo" class="form-label">Mayordomo</label>
                                    <input type="text" name="mayordomo" id="mayordomo" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="costo" class="form-label">Costo</label>
                                    <input type="number" step="0.01" name="costo" id="costo" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="imagen" class="form-label">Imagen</label>
                                    <input type="file" name="imagen" id="imagen" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary" onclick="return confirm('¿Estás seguro de guardar este servicio?')">Guardar</button>
                                <button type="button" class="btn btn-secondary" onclick="resetForm()">Cancelar</button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabla de habitaciones -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="table-primary">
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Mayordomo</th>
                                    <th>Costo $</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($services as $service): ?>
                                    <tr>
                                        <td><?php echo $service['codigo']; ?></td>
                                        <td><?php echo $service['nombre']; ?></td>
                                        <td><?php echo $service['tipo']; ?></td>
                                        <td><?php echo $service['mayordomo']; ?></td>
                                        <td><?php echo $service['costo']; ?></td>
                                        <td>
                                            <img src="resources/pictures/habitaciones/<?php echo $service['codigo']; ?>.jpg" alt="Imagen" style="width: 100px;">
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="editService('<?php echo $service['codigo']; ?>', '<?php echo $service['nombre']; ?>', '<?php echo $service['tipo']; ?>', '<?php echo $service['mayordomo']; ?>', '<?php echo $service['costo']; ?>')">Editar</button>
                                            <form method="POST" style="display: inline-block;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="codigo" value="<?php echo $service['codigo']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este servicio?')">Eliminar</button>
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

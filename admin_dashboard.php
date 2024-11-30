<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hotelstylesheet.css">

</head>
<body>

<?php
include_once("admin_menu.php")
?>

<div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px 10px 10px 10px; margin-top: 150px;"> <!--Contenedor de contenido-->
    <div class="container" style="margin: 20px 0px 20px 0px; ">
        <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px 10px 10px 10px; padding:20px;">
            <div class="container" style="text-align: center; padding:20px;">
            <h1 style="text-align: center; padding: 20px;">Bienvenido al Dashboard de Administrador</h1>
                <p>Seleccione una de las opciones del menú de arriba para gestionar el sistema.</p>
                <img src="resources/pictures/Sample_Pictures/admin_horizon_3.webp" alt="Gemini" class="img-fluid" style="max-width: 100%; height: 400px; border-radius: 10px 10px 10px 10px; align-items:center;">
            </div>
        </div>
    </div>
</div>

<?php
include_once("footer.html")
?>

</body>
</html>
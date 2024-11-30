<?php
session_start();
include_once("db_connection.php");

// Consultar las habitaciones o servicios disponibles desde la base de datos
$query = "SELECT * FROM menu";
$result = $conn->query($query);
$items = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Servicios</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hotelstylesheet.css">
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <style>

        .btn-reservar {
            background-color: #5e968f;
            color: white;
        }

        .btn-reservar:hover {
            background-color: #467a6b;
        }
    </style>
</head>
<body>

    <?php 
    include_once("menu.php"); // Navbar del sitio público 
    ?>

    <div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px 10px 10px 10px; margin-top: 100px;"> <!--Contenedor de contenido-->
        <div class="container" style="margin: 20px 0px 20px 0px; ">
            <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px 10px 10px 10px; padding:20px;">
                <div class="container mt-5">
                <h1 class="text-center mb-4">Hospedajes disponibles</h1>
                <div class="row" style="text-align: center; align-items:center; justify-content:center; padding: 20px;">
                    <?php foreach ($items as $item): ?>
                        <div class="col-md-4" style="text-align: center; align-items:center; justify-content:center; padding: 20px;">
                            <div class="card">
                                <div class="card-img-wrapper">
                                    <img src="resources/pictures/habitaciones/<?php echo $item['codigo']; ?>.jpg" alt="<?php echo $item['nombre']; ?>">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $item['nombre']; ?></h5>
                                    <p class="card-text">
                                        Tipo: <?php echo $item['tipo']; ?><br>
                                        Costo: $<?php echo number_format($item['costo'], 2); ?> / noche
                                    </p>
                                    <a href="book.php?codigo=<?php echo $item['codigo']; ?>" class="btn btn-reservar">
                                        Ver disponibilidad
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
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

<?php include_once("initialize_admin.php"); ?>

<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Hotel Bistú- Página Principal</title>
        <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/hotelstylesheet.css">
        <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body> 
    
<?php

include_once("menu.php")

?>

    <div class="container" style="border: #5e968f dotted 3px; background-color: #1b2e28; border-radius: 10px 10px 10px 10px; margin-top: 150px;">

        <div class="container" style="background-color:#1b2e28; border: #1b2e28 dotted 3px; border-radius: 10px 10px 10px 10px; margin: 20px 0px 20px 0px"> <!--Encabezado-->
            <div class="row">
                <div class="container" style="border: #1b2e28 dotted 3px; border-radius: 10px 10px 10px 10px; margin: 0px 0px 20px 0px">
                    <div class="row" style="background-color: #5e968f; border: #1b2e28 dotted 3px; border-radius: 10px 10px 10px 10px;">
                        <div class="col">
                            <h1 class="text-center"><img src="resources/pictures/Comercial/logo_no_background.png" style="width: 150px; height: 150px;"> 
                            <P style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"> Hotel Bits&uacute;</p></h1>
                        </div>
                        <div class="col" style="display: flex;  align-items: center; justify-content: center; text-align: center; font-size: 170%;">
                            <p class="fst-italic">"Un paraiso tropical sin igual"</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container"> <!--Contenedor video de bienvenida-->
                <!--video de bienvenida-->
                <div class="row" style= "border:#1b2e28 dotted 3px; border-radius: 10px 10px 10px 10px; margin: auto;" >
                    <div class="col" style="background-color: #1b2e28; border-radius: 10px 10px 10px 10px;  margin: auto;" >
                        <!--w-100 trata la col como una sola fila o una sola celda dentro del row-->
                        <video class="w-100" autoplay loop muted style="border-radius: 10px 10px 10px 10px">
                        <source src="resources/videos/background_video2.mp4" type="video/mp4"/>
                        </video>
                    </div>
                </div>
            </div> <!--Fin de contenedor-->
        </div><!--Aqui termina la seccion del encabezado-->

        <div class="container" style="margin: 20px 0px 20px 0px"> <!--Contenedor de slider habitaciones-->
            <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px 10px 10px 10px;">
                <!-- Información General del Hotel -->
                <div id="informacion-hotel">
                    <h2 class="fst-italic">Nuestras instalaciones</h2>
                    <div class="container_hotel_info">
                        <p class="fst-italic">Disfruta de una experiencia única en un ambiente de naturaleza y sostenibilidad.</p>
                        <p class="fst-italic">Ofrecemos habitaciones cómodas, espacios ecológicos, y un servicio de calidad.</p>
                    </div>
                    <div class="container">
                        <div class="row">
                                <div class="sliderpictures" style="border-radius: 10px 10px 10px 10px;">
                                <!-- Banner con Slider -->
                                <div id="slider" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="resources/pictures/Sample_Pictures/bgpicture1.jpg" class="d-block w-100" alt="Hotel 1">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="resources/pictures/Sample_Pictures/HotelSample2.jpg" class="d-block w-100" alt="Hotel 2">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="resources/pictures/Sample_Pictures/HotelSample3.jpg" class="d-block w-100" alt="Hotel 3">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="resources/pictures/Sample_Pictures/HotelSample4.jpg" class="d-block w-100" alt="Hotel 4">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="resources/pictures/Sample_Pictures/HotelSample5.jpg" class="d-block w-100" alt="Hotel 5">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="resources/pictures/Sample_Pictures/HotelSample8.jpg" class="d-block w-100" alt="Hotel 8">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="resources/pictures/Sample_Pictures/HotelSample9.jpg" class="d-block w-100" alt="Hotel 9">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="resources/pictures/Sample_Pictures/HotelSample10.jpg" class="d-block w-100" alt="Hotel 10">
                                            </div>
                                    </div>
                                        <!-- Botones de navegación -->
                                        <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Anterior</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Siguiente</span>
                                        </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!--fin de contenedor-->

        <div class="container" style="border: #1b2e28 dotted 3px; background-color: #5e968f; border-radius: 10px 10px 10px 10px; margin: 20px 0px 20px 0px">    <!-- Contenedor de servicios -->
            <div id="servicios_info">
                <h2 class="fst-italic">Comodidad, cultura nacional y naturaleza a su disposición</h2> 
                <div class="container_servicios_info">
                        <p class="fst-italic">Opciones para aventurarse solo o en compañia.</p>
                        <p class="fst-italic">Contamos con el personal m&aacute;s calificado para experiencias sin igual.</p>
                </div>
                <!-- Fila de tarjetas -->
                <div class="row text-center">
                    <!-- Tarjeta Piscina -->
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <!-- Parte delantera de la tarjeta (imagen) -->
                            <div class="flip-card-front">
                                <img src="resources/pictures/Sample_Pictures/Piscina.jpg" class="card-img-top" alt="Piscina">
                            </div>
                            <!-- Parte trasera de la tarjeta (descripción) -->
                            <div class="flip-card-back">
                                <div class="row">
                                    <h5 class="card-title">Piscina Panorámica y Spa</h5>
                                    <p class="card-text">Relájese en nuestra piscina al aire libre mientras disfruta de atardeceres en medio de la naturaleza.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta Senderos -->
                    <div class="col-md-3 mb-4">
                        <div class="card-container">
                            <div class="card">
                                    <div class="flip-card-front">
                                        <img src="resources/pictures/Sample_Pictures/Senderos.jpg" class="card-img-top" alt="Senderos">
                                    </div>
                                    <div class="flip-card-back">
                                        <div class="row">
                                            <h5 class="card-title">Senderos y Áreas Verdes</h5>
                                            <p class="card-text">Conéctese con la naturaleza mientras camina por nuestros senderos rodeados de paisajes verdes.</p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Tarjeta Restaurante -->
                    <div class="col-md-3 mb-4">
                        <div class="card-container">
                            <div class="card">
                                    <div class="flip-card-front">
                                        <img src="resources/pictures/Sample_Pictures/Restaurante.jpg" class="card-img-top" alt="Restaurante">
                                    </div>
                                    <div class="flip-card-back">
                                        <div class="row">
                                            <h5 class="card-title">Restaurante Molinos</h5>
                                            <p class="card-text">Disfrute de una deliciosa comida en nuestro restaurante con una vista increíble a la montaña.</p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta Galeria-->
                    <div class="col-md-3 mb-4">
                        <div class="card-container">
                            <div class="card">
                                    <div class="flip-card-front">
                                        <img src="resources/pictures/Sample_Pictures/Galeria_Arte.jpg" class="card-img-top" alt="Galeria">
                                    </div>
                                    <div class="flip-card-back">
                                        <div class="row">
                                            <h5 class="card-title">Galeria de Arte</h5>
                                            <p class="card-text">Admire las obras de arte en nuestra galería, rodeado de la belleza natural del lugar</p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!--Fin del contenedor-->

        <div class="container" style="margin: 20px 0px 20px 0px"> <!--Contenedor de tipos de habitacion-->
            <div class="row" style="border: #1b2e28 dotted 3px; background-color: #e6dfc6; border-radius: 10px 10px 10px 10px;">
                <!-- Información General del Hotel -->
                <div id="habitaciones_info">
                    <h2 class="fst-italic">Diferentes cabañas disponibles</h2>
                    <div class="habitaciones_info_container"> 
                        <p class="fst-italic">Contamos con varios tipos de habitaciones disponibles.</p>
                        <p class="fst-italic">Distintas opciones seg&uacute;n el tipo de experiencia que este buscando.</p>
                    </div>
                        <div class="row text-center justify-content-center">
        
                            <!--Caba;a Riverfront-->
                            <div class="col-md-3 mb-4">
                                <div class="card" style="border-radius: 10px;">
                                    <div class="card-img-wrapper">
                                        <img src="resources/pictures/Sample_Pictures/Cabana_riverfront.jpg" class="card-img" alt="Riverfront" style="border-radius: 10px 10px 0 0;">
                                    </div>
                                    <div class="card-body" style="background-color: #1b2e28; color: white; border-radius: 0 0 10px 10px;">
                                        <h5 class="card-title">Cabañas Riverfront</h5>
                                        <p class="card-text">Combinando un concepto rústico con comodidad, una elección exclusiva y privada en donde los unicos sonidos serán los de la naturaleza, 
                                            con el encantador r&iacute;o justo en frente de esta atractiva opci&oacute;n (2-4 personas).</p>
                                    </div>
                                </div>
                            </div>
    
                            <!--Caba;a de montana-->
                            <div class="col-md-3 mb-4">
                                <div class="card" style="border-radius: 10px;">
                                    <div class="card-img-wrapper">
                                        <img src="resources/pictures/Sample_Pictures/Cabana_montana.jpg" class="card-img" alt="Riverfront" style="border-radius: 10px 10px 0 0;">
                                    </div>
                                    <div class="card-body" style="background-color: #1b2e28; color: white; border-radius: 0 0 10px 10px;">
                                        <h5 class="card-title">Cabañas de Montaña</h5>
                                        <p class="card-text">Rodeadas de Jardines, con una extraordinarias e inspiradoras vistas, los cuales superan los 3500 m.s.n.m. Estas casitas cuentan con Chimenea para que su estadía sea m&aacute;s placentera (2-4 personas).</p>
                                    </div>
                                </div>
                            </div>
    
                            <!--Habitaciones-->
                            <div class="col-md-3 mb-4">
                                <div class="card" style="border-radius: 10px;">
                                    <div class="card-img-wrapper">
                                        <img src="resources/pictures/Sample_Pictures/habitaciones.jpg" class="card-img" alt="Riverfront" style="border-radius: 10px 10px 0 0;">
                                    </div>
                                    <div class="card-body" style="background-color: #1b2e28; color: white; border-radius: 0 0 10px 10px;">
                                        <h5 class="card-title">Habitaciones</h5>
                                        <p class="card-text">Una opción económica y práctica, siembre con un concepto rústico y en un entorno de montaña y jardines, ideal para grupos familiares o caminantes (2-4 personas).</p>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                </div>
            </div>
        </div> <!--fin de contenedor-->

        <div class="container" style="margin: 20px 0px 20px 0px"> <!--Contenedor de testimonios-->
            <div class="row" style="border-radius: 10px 10px 10px 10px;">
                <!-- Testimonios -->
                <div id="testimonios" style="border-radius: 10px 10px 10px 10px;">
                    <h2>¿Qu&eacute; dicen nuestros huespedes?</h2>
                    <div class="slider-testimonios" style="border-radius: 5px 5px 5px 5px; border: #1b2e28 dotted 3px"> <!--Dejar este div-->
                        <div id="testimonios-slider" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <p class="fst-italic">"Una experiencia inolvidable. El servicio fue excelente y el entorno es impresionante."</p>
                                    <p><strong>- Pedro Parker</strong></p>
                                </div>
                                <div class="carousel-item">
                                    <p class="fst-italic">"Un lugar increíble para relajarse y conectarse con la naturaleza."</p>
                                    <p><strong>- Matias Murdock</strong></p>
                                </div>
                                <div class="carousel-item">
                                    <p class="fst-italic">"El mejor hotel ecológico que he visitado. Muy recomendado."</p>
                                    <p><strong>- Bruno Tapia</strong></p>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#testimonios-slider" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#testimonios-slider" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div><!--dejar este tambien-->
                </div>
            </div>
        </div>

            <div class="container" style="margin: 20px 0px 30px 0px;"> <!--Contenedor de contactos-->
                <div class="row" style="border-radius: 5px 5px 5px 5px; border: #1b2e28 dotted 3px; background-color: #e6dfc6; ">
                    <!-- Redes Sociales -->
                            <div id="redes-sociales">
                            <h4>Síguenos en Redes Sociales</h4>
                            <div class="redes">
                                <a href="Error404.php" target="_blank"><img src="resources/pictures/UI_icons/icons8-facebook-50.png"></a>
                                <a href="Error404.php" target="_blank"><img src="resources/pictures/UI_icons/icons8-instagram-50.png"></a>
                                <a href="Error404.php" target="_blank"><img src="resources/pictures/UI_icons/icons8-twitterx-50.png"></a>
                            </div>
                        </div>
                    </div>
            </div>

    </div> <!--End of content container-->

<?php
include_once("footer.html")
?>

</body>
    
</html>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>404 - Página no encontrada</title>
        <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/hotelstylesheet.css">
        <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    </head>
    <body style="background-image: url(resources/pictures/UI_icons/404_Background_page.jpg);">

        <?php
            include_once("menu.php")
        ?>
        <div class="container" 
        style="border: #5e968f dotted 3px; 
        background-color: #e6dfc6; 
        border-radius: 10px 10px 10px 10px; 
        justify-content: center; 
        text-align: center; 
        align-items: center; margin-top: 150px">
            <h1 class="display-4 text-danger">¡Ups! Página no encontrada</h1>
            <div class="my-4" style="justify-content: center; text-align: center; align-items: center;">
                <img src="resources/pictures/UI_icons/404_Sloth_Sample.webp" alt="Oso Perezoso Jedi cruzando la calle" class="img-fluid" style="max-width: 100%; height: auto; border-radius: 10px 10px 10px 10px;">
            </div>
            <p class="lead text-muted" style="justify-content: center; text-align: center; align-items: center;">Oops! Parece que has terminado en un sitio muy muy lejano, aqui no encontraras lo que buscas.</p>
            <p class="lead text-muted" style="justify-content: center; text-align: center; align-items: center;">Te recomendamos volver de donde viniste.</p>
        </div>
        <?php
            include_once("footer.html")
        ?>
    </body>
</html>

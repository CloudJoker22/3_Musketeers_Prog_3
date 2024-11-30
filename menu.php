<?php
session_start(); // Inicia la sesión
?>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand ms-4" href="index.php">
            <img src="resources/pictures/Comercial/logo_no_background.png" alt="Hotel Bistú" style="width: 70px; height: 70px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contáctenos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="catalog.php">Reservar</a>
                </li>

                <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="user_info.php">Mi cuenta</a></li>
                            <li><a class="dropdown-item" href="user_reservations.php">Mis reservaciones</a></li>
                            <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                            <?php if ($_SESSION['tipo_usuario'] === 'admin'): ?>
                                <li><a class="dropdown-item" href="admin_dashboard.php" style="background-color: #5e968f; font-weight: bold;">Admin Dashboard</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="loginpage.php">Iniciar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Script para confirmar la salida -->
<script>
function confirmLogout() {
    if (confirm("¿Estás seguro de que deseas cerrar sesión?")) {
        window.location.href = 'logout.php';  // Redirige a la página de logout
    }
}
</script>


<style>
/* Estilos adicionales para que el dropdown coincida con el diseño de la barra de navegación */
.navbar-nav .dropdown-menu {
    background-color: #1b2e28;  /* Fondo similar al de la barra */
    border: none; /* Eliminar bordes */
}

.navbar-nav .dropdown-item {
    color: #e6dfc6;  /* Color de texto igual al de la barra */
    padding: 10px 20px;
    text-align: center;
}

/* Cambiar el color al pasar el mouse */
.navbar-nav .dropdown-item:hover {
    background-color: #e9ecef;
    color: #1b2e28; /* Texto más oscuro al hacer hover */
    border-radius: 10px;
}

/* Centrar el contenido de los items del dropdown */
.navbar-nav .dropdown-menu {
    text-align: center;
}

/* Estilos para los items de la barra de navegación */
.navbar-nav .nav-link {
    transition: background-color 0.3s, color 0.3s; /* Transición suave */
    border-radius: 10px;
    color: #e6dfc6 !important;  /* Color de texto por defecto */
}

/* Cambiar color de fondo y de texto al pasar el mouse */
.navbar-nav .nav-link:hover {
    background-color: #e9ecef; /* Fondo cuando el mouse pasa */
    color: #1b2e28 !important;  /* Texto más oscuro cuando pasa el mouse */
}

/* Cambiar el color de fondo y texto al pasar el mouse en el item de usuario */
.navbar-nav .nav-link.dropdown-toggle:hover {
    background-color: #e9ecef;
    color: #1b2e28;  /* Texto más oscuro al pasar el mouse */
}

</style>

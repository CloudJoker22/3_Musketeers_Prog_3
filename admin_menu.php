

<!DOCTYPE html>

    <!-- Navigation bar específica del Admin Dashboard -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand ms-4" href="index.php">
                <img src="resources/pictures/Comercial/logo_no_background.png" alt="Hotel Bistú" style="width: 70px; height: 70px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="service_catalog.php">Habitaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_catalog.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_reservations.php">Reservaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Cerrar sesión</a>
                    </li>
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


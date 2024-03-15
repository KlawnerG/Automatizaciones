<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administracion</title>
    <link rel="stylesheet" href="estiloprincipalesadmin.css">

</head>
<body>
    <?php

    session_start();

    if (!isset($_SESSION["usuario"])) {
        # code...
        header("location: Login.html ");
    }
    ?>
    <header>
        <h1>Bienvenido al Panel de Administración</h1>

        <p><a href="cerrar-sesion.php" class="login-link">Cerrar Sesion</a>
    </header>

    <div class="menu">
        <nav>
        <ul>
        <li><a href="../Gestor_usuarios/usuario.php">Gestor de Usuarios</a></li>
    <li><a href="../Gestor_peticiones/peticiones.php">Gestor de Peticiones</a></li>
      <li class="dropdown">
  <a href="#">Automatizaciones</a>
  <ul class="dropdown-menu">
    <li><a href="../Gestor_bots/bots.php">Gestor de Bots</a></li>
    <li><a href="../Gestor_categorias/categoria.php">Categorías</a></li>
    <li><a href="../Gestor_sub_categorias/sub_categoria.php">Subcategorías</a></li>
    <li><a href="../Gestor_tipos/tipos.php">Gestor de Tipos</a></li>
  </ul>
</li>
    <li><a href="../Gestor_calificaciones/calificacion.php">Gestor de Calificaciones</a></li>
    <li><a href="../Gestor_roles/roles.php">Gestor de Roles</a></li>
    <li><a href="../Gestor_control/Control.php">Control</a></li>
    <li><a href="../menu/menuadmin.php">Home</a></li>
  </ul>
        </nav>
    </div>

    <main>
        <section class="informacion-bots">
            <h2>¡Bienvenido al Panel de Administración!</h2>
            <p>Desde aquí puedes gestionar usuarios, bots, peticiones, calificaciones, roles, tipos, categorías y subcategorías.</p>
            <p>Selecciona una opción del menú de navegación para empezar.</p>
        </section>
    </main>

    <footer>
    <footer>
        <p>© 2023, Bots Avanzados</p>
        <p>Contacto:
            <a href="mailto:info@botsavanzados.com">info@botsavanzados.com</a>
            <a href="tel:3214879337">3214879337</a>
        </p>
    </footer>
    </footer>
</body>
</html>
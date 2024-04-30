<?php
require_once 'routeController.php';
$rc = new RouteController();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - SinisterApp</title>
</head>

<body>
    <header>
        <h1>INICIAR SESION</h1>
        <h2>SinisterApp</h2>
        <nav>
            <ul>
                <li><a href="<?php $rc->getRoute('view-home')->getUrl(); ?>">Inicio</a></li>
                <li><a href="<?php $rc->getRoute('view-signIn')->getUrl(); ?>">Iniciar sesión</a></li>
                <li><a href="<?php $rc->getRoute('view-signUp')->getUrl(); ?>">Registrarse</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <p>Para poder utilizar la aplicación SinisterApp, debes iniciar sesión.</p>
        <form action="<?php $rc->getRoute('user-signIn')->getUrl(); ?>" method="post">
            <section>
                <label for="inputEmail">
                    Correo electrónico
                </label>
                <input type="email" name="email" id="inputEmail" minlength="15" required>
                <span></span>
            </section>
            <section>
                <label for="inputPassword">
                    Contraseña
                </label>
                <input type="password" name="password" id="inputPassword" minlength="5" required>
                <span></span>
            </section>
            <section>
                <input type="checkbox" name="rememberMe" id="inputRememberMe">
                <label for="inputRememberMe">
                    Recordar mi sesión en este dispositivo.
                </label>
            </section>
            <input type="submit" value="INICIAR SESION">
        </form>
    </main>
    <footer>
        <ul>
            <li><a href="<?php $rc->getRoute('view-contactUs')->getUrl(); ?>">Contáctanos</a></li>
            <li><a href="<?php $rc->getRoute('view-aboutUs')->getUrl(); ?>">Acerca de nosotros</a></li>
        </ul>
        <span>Aplicación elaborada por Illesoft © Derechos reservados</span>
    </footer>
</body>

</html>
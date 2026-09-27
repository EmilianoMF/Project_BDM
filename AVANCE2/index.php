<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="esfera-fondo esfera-1"></div>
    <div class="esfera-fondo esfera-2"></div>
    <div class="esfera-fondo esfera-3"></div>

    <div class="glass-panel">
        
        <h1>AutoTrack</h1>
        <h2>Iniciar Sesión</h2>

        <form action="Login.php" method="POST">
            <label>Correo Electrónico:</label>
            <input type="email" name="correo" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Ingresar</button>
        </form>

        <p>¿No tienes cuenta? <a href="SignUp.php">Registrarse</a></p>

    </div> <script src="login.js"></script>
</body>
</html>
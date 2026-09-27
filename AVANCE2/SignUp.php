<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoTrack - Registro de Usuario</title>
    <link rel="stylesheet" href="SignUp.css">
</head>
<body>

    <div class="esfera-fondo esfera-1"></div>
    <div class="esfera-fondo esfera-2"></div>
    <div class="esfera-fondo esfera-3"></div>

    <div class="glass-panel">
        
        <h1>AutoTrack</h1>
        <h2>Registro de Usuario</h2>

        <form action="registro_usuario.php" method="POST" enctype="multipart/form-data">
            
            <div class="input-group full-width">
                <label>TIPO DE USUARIO</label>
                <select name="tipo_usuario">
                    <option value="Asegurado">Asegurado</option>
                    <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == "Supervisor") { ?>
                        <option value="Ajustador">Ajustador</option>
                        <option value="Supervisor">Supervisor</option>
                    <?php } ?>
                </select>
            </div>

            <div class="input-group">
                <label>NOMBRE</label>
                <input type="text" name="nombre" required>
            </div>

            <div class="input-group">
                <label>APELLIDOS</label>
                <input type="text" name="apellidos" required>
            </div>

            <div class="input-group">
                <label>FECHA DE NACIMIENTO</label>
                <input type="date" name="fecha_nacimiento" required>
            </div>

            <div class="input-group">
                <label>GÉNERO</label>
                <select name="genero">
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="input-group">
                <label>CORREO ELECTRÓNICO</label>
                <input type="email" name="correo" required>
            </div>

            <div class="input-group">
                <label>ALIAS</label>
                <input type="text" name="alias" required>
            </div>

            <div class="input-group full-width">
                <label>CONTRASEÑA</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="input-group full-width">
                <label>FOTO DE PERFIL</label>
                <input type="file" name="foto" id="foto" accept="image/*">
                <img id="preview" style="display:none; width:100px; border-radius: 10px; margin-top: 10px;">
            </div>

            <button type="submit" class="full-width">Registrarse</button>
        </form>

        <p>¿Ya tienes cuenta? <a href="Login.php">Iniciar sesión</a></p>
    </div>

    <script src="SignUp.js"></script>
</body>
</html>
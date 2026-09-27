
<?php
session_start();
require_once "Conexion.php";

$bd = new Conexion();

$correo = $_POST['correo'];
$password = $_POST['password'];

// Buscar usuario por correo
$stmt = $bd->conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {

    $usuario = $resultado->fetch_assoc();

    // Verificar contraseña
    if (password_verify($password, $usuario['contraseña'])) {

        // Crear sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['alias'] = $usuario['alias'];

        // Redirigir
        header("Location: Dashboard.php");
        exit;

    } else {
        echo "<script>
                alert('Contraseña incorrecta');
                window.location='index.php';
              </script>";
    }

} else {
    echo "<script>
            alert('Correo no registrado');
            window.location='index.php';
          </script>";
}

$bd->cerrar();
?>
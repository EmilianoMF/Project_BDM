<?php
session_start();
require_once "Conexion.php";
require_once "validar_contraseña.php"; 

$bd = new Conexion();

// Capturar datos del formulario
$tipo_usuario = $_POST['tipo_usuario'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
    // Validar mayoría de edad
    $fechaNacimiento = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fechaNacimiento)->y;

    if ($edad < 18) {
        echo "<script>
                alert('Debes ser mayor de 18 años');
                window.history.back();
            </script>";
        exit;
    }
$genero = $_POST['genero'];
$correo = $_POST['correo'];
$alias = $_POST['alias'];
$contraseña = $_POST['password'];


$foto = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

    // Validar que sea imagen
    if (!getimagesize($_FILES['foto']['tmp_name'])) {
        echo "Solo se permiten imágenes";
        exit;
    }

    // Guardar imagen
    $foto = "uploads/" . uniqid() . "_" . $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
}

// Validar contraseña
$resultadoValidacion  = validarContraseña($contraseña);

if ($resultadoValidacion  === true) {
    
    $contraseña_segura = password_hash($contraseña, PASSWORD_DEFAULT);
    
        
    $stmt_verificar = $bd->conexion->prepare("SELECT correo FROM usuarios WHERE correo = ?");
    $stmt_verificar->bind_param("s", $correo);
    $stmt_verificar->execute();
    $resultado  = $stmt_verificar->get_result();

    if ($resultado ->num_rows > 0) {
        echo "<script>
                alert('Este correo ya está registrado');
                window.history.back();
            </script>";
    } else {

        // Verificar alias
        $stmt_alias = $bd->conexion->prepare("SELECT alias FROM usuarios WHERE alias = ?");
        $stmt_alias->bind_param("s", $alias);
        $stmt_alias->execute();
        $res_alias = $stmt_alias->get_result();

        if ($res_alias->num_rows > 0) {
            echo "<script>
                    alert('Este alias ya está en uso');
                    window.history.back();
                </script>";
            exit;
        }
        
        //VERIFICA QUE SEA SUPERVISOR 
        if ($_SESSION['tipo_usuario'] != "Supervisor") {
            $tipo_usuario = "Asegurado";
        }

        $sql = "INSERT INTO Usuarios 
        (tipo_usuario, nombre, apellidos, fecha_nacimiento, foto, genero, correo, alias, contraseña)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $bd->conexion->prepare($sql);
        $stmt->bind_param("sssssssss", $tipo_usuario, $nombre, $apellidos, $fecha_nacimiento, $foto, $genero, $correo, $alias, $contraseña_segura);
        $stmt->execute();

        // Obtener ID del usuario recién insertado
        $id_usuario = $bd->conexion->insert_id;

        // Guardar datos en sesión
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['correo'] = $correo;
        $_SESSION['alias'] = $alias;

        echo "<script>
          alert('Usuario registrado correctamente');
          window.location='index.php';
        </script>";
    }
} else {
    echo "Errores en la contraseña:<br>";
    foreach ($resultadoValidacion  as $error) {
        echo "- " . $error . "<br>";
    }
}

$bd->cerrar();
?>

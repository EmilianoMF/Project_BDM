<?php
session_start();
require_once "Conexion.php";

$bd = new Conexion();

// Verificar sesión
if (
    !isset($_SESSION['id_usuario']) ||
    (
        $_SESSION['tipo_usuario'] != "Supervisor" &&
        $_SESSION['tipo_usuario'] != "Ajustador"
    )
) {
    header("Location: Dashboard.php");
    exit;
}

// ======================================
// DATOS COMPAÑÍA
// ======================================

$nombre_compania = $_POST['nombre_compania'];
$direccion_compania = $_POST['direccion_compania'];
$telefono_compania = $_POST['telefono_compania'];
$correo_compania = $_POST['correo_compania'];

// ======================================
// DATOS CLIENTE
// ======================================

$nombre_cliente = $_POST['nombre_cliente'];
$correo_cliente = $_POST['correo_cliente'];
$numero_poliza = $_POST['num_poliza'];

// ======================================
// DATOS VEHÍCULO
// ======================================

$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$año = $_POST['año'];
$color = $_POST['color'];
$placas = $_POST['placas'];
$num_serie = $_POST['num_serie'];

// ======================================
// DATOS SINIESTRO
// ======================================

$fecha_siniestro = $_POST['fecha_hora'];
$ubicacion = $_POST['ubicacion'];
$otras_uni = $_POST['otras_uni'];
$descripcion = $_POST['descripcion'];

$id_ajustador = $_SESSION['id_usuario'];

// ======================================
// INSERTAR UNIDAD
// ======================================

$sqlUnidad = "INSERT INTO Unidades
(marca, modelo, año, placas, numero_serie, color)

VALUES (?, ?, ?, ?, ?, ?)";

$stmtUnidad = $bd->conexion->prepare($sqlUnidad);

$stmtUnidad->bind_param(
    "ssisss",
    $marca,
    $modelo,
    $año,
    $placas,
    $num_serie,
    $color
);

$stmtUnidad->execute();

// ID unidad creada
$id_unidad = $bd->conexion->insert_id;

// ======================================
// INSERTAR SINIESTRO
// ======================================

$sql = "INSERT INTO Siniestros
(
id_ajustador,
id_unidad,
nombre_compania,
nombre_cliente,
correo_cliente,
direccion_compania,
telefono_compania,
correo_compania,
fecha_siniestro,
ubicacion,
descripcion,
otras_Uni,
numero_poliza
)

VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $bd->conexion->prepare($sql);

$stmt->bind_param(
    "iisssssssssss",
    $id_ajustador,
    $id_unidad,
    $nombre_compania,
    $nombre_cliente,
    $correo_cliente,
    $direccion_compania,
    $telefono_compania,
    $correo_compania,
    $fecha_siniestro,
    $ubicacion,
    $descripcion,
    $otras_uni,
    $numero_poliza
);

$stmt->execute();

// ID del siniestro
$id_siniestro = $bd->conexion->insert_id;

// ======================================
// MULTIMEDIA
// ======================================

if (!empty($_FILES['multimedia']['name'][0])) {

    foreach ($_FILES['multimedia']['tmp_name'] as $key => $tmp_name) {

        $nombreArchivo = uniqid() . "_" . $_FILES['multimedia']['name'][$key];

        $ruta = "uploads/" . $nombreArchivo;

        move_uploaded_file($tmp_name, $ruta);

        // Tipo de archivo
        $tipo = "Foto";

        if (str_contains($_FILES['multimedia']['type'][$key], "video")) {
            $tipo = "Video";
        }

        // Insert multimedia
        $sqlMedia = "INSERT INTO Multimedia_Siniestro
        (id_siniestro, tipo_archivo, url_archivo)

        VALUES (?, ?, ?)";

        $stmtMedia = $bd->conexion->prepare($sqlMedia);

        $stmtMedia->bind_param(
            "iss",
            $id_siniestro,
            $tipo,
            $ruta
        );

        $stmtMedia->execute();
    }
}

// ======================================
// MENSAJE FINAL
// ======================================

echo "<script>
        alert('Siniestro registrado correctamente');
        window.location='Dashboard.php';
      </script>";

$bd->cerrar();
?>
<?php
session_start();

require_once "Conexion.php";

$bd = new Conexion();


if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

// ======================================
// DATOS
// ======================================

$id_siniestro = $_POST['id_siniestro'];

$comentario = $_POST['comentario'];

$id_usuario = $_SESSION['id_usuario'];

// ======================================
// INSERTAR COMENTARIO
// ======================================

$sql = "
INSERT INTO Seguimiento
(
    id_siniestro,
    id_usuario,
    comentario
)

VALUES (?, ?, ?)
";

$stmt = $bd->conexion->prepare($sql);

$stmt->bind_param(
    "iis",
    $id_siniestro,
    $id_usuario,
    $comentario
);

$stmt->execute();


header("Location: ReportDetails.php?id=$id_siniestro");

exit;
?>
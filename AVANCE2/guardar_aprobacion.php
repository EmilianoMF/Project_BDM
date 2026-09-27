<?php
session_start();

if (
    !isset($_SESSION['id_usuario']) ||
    $_SESSION['tipo_usuario'] != "Supervisor"
) {
    header("Location: Dashboard.php");
    exit;
}

require_once "Conexion.php";

$bd = new Conexion();

$id_siniestro = $_POST['id_siniestro'];
$estado = $_POST['estado'];
$tipo_pago = $_POST['tipo_pago'];
$id_supervisor = $_SESSION['id_usuario'];

$errores = [];

// ======================================
// VALIDACIONES
// ======================================

if ($estado == 'Rechazado' && $tipo_pago != 'Pendiente') {
    $errores[] = "Si está RECHAZADO, el tipo de pago debe ser PENDIENTE.";
}

if ($estado == 'Pérdida total' && $tipo_pago != 'Pérdida total') {
    $errores[] = "Si es PÉRDIDA TOTAL, el tipo de pago debe ser PÉRDIDA TOTAL.";
}

if ($estado == 'Pago reparación' && $tipo_pago != 'Reparación') {
    $errores[] = "Si es PAGO REPARACIÓN, el tipo de pago debe ser REPARACIÓN.";
}

// ======================================
// SI HAY ERRORES → REGRESAR SIN SALIR DE FLUJO
// ======================================

if (count($errores) > 0) {
    $_SESSION['errores_aprobacion'] = $errores;
    header("Location: ReportDetails.php?id=$id_siniestro");
    exit;
}

// ======================================
// FECHAS
// ======================================

$fecha_aprobacion = null;
$fecha_finalizacion = null;

if (
    $estado == 'Aceptado' ||
    $estado == 'Aceptado con deducible' ||
    $estado == 'Aceptado sin deducible'
) {
    $fecha_aprobacion = date("Y-m-d H:i:s");
}

if (
    $estado == 'Rechazado' ||
    $estado == 'Pago reparación' ||
    $estado == 'Pérdida total'
) {
    $fecha_finalizacion = date("Y-m-d H:i:s");
}

// ======================================
// UPDATE
// ======================================

$sql = "
UPDATE Siniestros
SET
    estado = ?,
    tipo_pago = ?,
    id_supervisor = ?,
    fecha_aprobacion = ?,
    fecha_finalizacion = ?
WHERE id_siniestro = ?
";

$stmt = $bd->conexion->prepare($sql);

$stmt->bind_param(
    "ssissi",
    $estado,
    $tipo_pago,
    $id_supervisor,
    $fecha_aprobacion,
    $fecha_finalizacion,
    $id_siniestro
);

$stmt->execute();

header("Location: ReportDetails.php?id=$id_siniestro");
exit;
?>
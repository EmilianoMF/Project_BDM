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

if (!isset($_GET['id'])) {
    header("Location: Dashboard.php");
    exit;
}

$id_siniestro = $_GET['id'];

$sql = "SELECT * FROM Siniestros WHERE id_siniestro = ?";
$stmt = $bd->conexion->prepare($sql);
$stmt->bind_param("i", $id_siniestro);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "Siniestro no encontrado";
    exit;
}

$siniestro = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoTrack - Aprobaciones</title>
    <link rel="stylesheet" href="Aprobaciones.css">
</head>
<body>

    <!-- Elementos 3D desenfocados del fondo -->
    <div class="esfera-fondo esfera-1"></div>
    <div class="esfera-fondo esfera-2"></div>
    <div class="esfera-fondo esfera-3"></div>

    <a href="Dashboard.php" class="flecha-regresar">←</a>

    <!-- Contenedor principal de cristal -->
    <div class="glass-panel">
        
        <h2>Aprobación de Siniestro #<?php echo $siniestro['id_siniestro']; ?></h2>

        <form action="guardar_aprobacion.php" method="POST">
            
            <input type="hidden" name="id_siniestro" value="<?php echo $siniestro['id_siniestro']; ?>">

            <div class="input-group">
                <label>ESTADO DEL SINIESTRO</label>
                <select name="estado" required>
                    <option value="" disabled selected>Seleccionar estado...</option>
                    <option value="Rechazado">Rechazado</option>
                    <option value="Aceptado">Aceptado</option>
                    <option value="Aceptado con deducible">Aceptado con deducible</option>
                    <option value="Aceptado sin deducible">Aceptado sin deducible</option>
                    <option value="Pago reparación">Pago reparación</option>
                    <option value="Pérdida total">Pérdida total</option>
                </select>
            </div>

            <div class="input-group">
                <label>TIPO DE PAGO</label>
                <select name="tipo_pago" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Deducible">Deducible</option>
                    <option value="Reparación">Reparación</option>
                    <option value="Pérdida total">Pérdida total</option>
                </select>
            </div>

            <button type="submit">Guardar Aprobación</button>

        </form>

    </div>

    <?php $bd->cerrar(); ?>
</body>
</html>
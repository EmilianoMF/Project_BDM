<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

require_once "Conexion.php";
$bd = new Conexion();

// ======================================
// OBTENER ID
// ======================================

if (!isset($_GET['id'])) {
    header("Location: Dashboard.php");
    exit;
}

$id_siniestro = $_GET['id'];

// ======================================
// CONSULTAR SINIESTRO
// ======================================

$sql = "SELECT * FROM vista_detalle_siniestro WHERE id_siniestro = ?";
$stmt = $bd->conexion->prepare($sql);
$stmt->bind_param("i", $id_siniestro);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "Siniestro no encontrado";
    exit;
}
$siniestro = $resultado->fetch_assoc();

// ======================================
// CONSULTAR MULTIMEDIA
// ======================================

$sqlMedia = "SELECT * FROM Multimedia_Siniestro WHERE id_siniestro = ?";
$stmtMedia = $bd->conexion->prepare($sqlMedia);
$stmtMedia->bind_param("i", $id_siniestro);
$stmtMedia->execute();
$resultadoMedia = $stmtMedia->get_result();

// ======================================
// OBTENER SEGUIMIENTO
// ======================================

$sqlSeguimiento = "SELECT * FROM vista_seguimiento WHERE id_siniestro = ? ORDER BY fecha_comentario DESC";
$stmtSeguimiento = $bd->conexion->prepare($sqlSeguimiento);
$stmtSeguimiento->bind_param("i", $id_siniestro);
$stmtSeguimiento->execute();
$resultadoSeguimiento = $stmtSeguimiento->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Siniestro</title>
    <link rel="stylesheet" href="ReportDetails.css?v=1">
</head>
<body>

    <div class="esfera-fondo esfera-1"></div>
    <div class="esfera-fondo esfera-2"></div>
    <div class="esfera-fondo esfera-3"></div>

    <a href="Dashboard.php" class="flecha-regresar">←</a>

    <div class="glass-panel detail-panel">
        
        <h2>Detalle del Siniestro #<?php echo $siniestro['id_siniestro']; ?></h2>
        
        <div class="status-badge">
            Estado: <strong><?php echo $siniestro['estado'] ?? "Pendiente"; ?></strong>
        </div>

        <h3>Datos Generales</h3>
        <div class="info-grid">
            <div class="info-item"><span class="label">Fecha del Siniestro</span><span class="value"><?php echo $siniestro['fecha_siniestro']; ?></span></div>
            <div class="info-item"><span class="label">Ubicación</span><span class="value"><?php echo $siniestro['ubicacion']; ?></span></div>
            <div class="info-item"><span class="label">Tipo de Pago</span><span class="value"><?php echo $siniestro['tipo_pago'] ? $siniestro['tipo_pago'] : "No definido"; ?></span></div>
            <div class="info-item"><span class="label">Aprobación</span><span class="value"><?php echo $siniestro['fecha_aprobacion'] ? $siniestro['fecha_aprobacion'] : "Pendiente"; ?></span></div>
            <div class="info-item"><span class="label">Finalización</span><span class="value"><?php echo $siniestro['fecha_finalizacion'] ? $siniestro['fecha_finalizacion'] : "Pendiente"; ?></span></div>
            <div class="info-item full-width"><span class="label">Descripción</span><span class="value"><?php echo $siniestro['descripcion']; ?></span></div>
            <div class="info-item full-width"><span class="label">Otras unidades</span><span class="value"><?php echo $siniestro['otras_Uni']; ?></span></div>
        </div>

        <div class="split-grid">
            <div>
                <h3>Cliente</h3>
                <div class="info-grid">
                    <div class="info-item full-width"><span class="label">Nombre</span><span class="value"><?php echo $siniestro['nombre_cliente']; ?></span></div>
                    <div class="info-item full-width"><span class="label">Correo</span><span class="value"><?php echo $siniestro['correo_cliente']; ?></span></div>
                    <div class="info-item full-width"><span class="label">Póliza</span><span class="value"><?php echo $siniestro['numero_poliza']; ?></span></div>
                </div>
            </div>

            <div>
                <h3>Vehículo</h3>
                <div class="info-grid">
                    <div class="info-item"><span class="label">Marca</span><span class="value"><?php echo $siniestro['marca']; ?></span></div>
                    <div class="info-item"><span class="label">Modelo</span><span class="value"><?php echo $siniestro['modelo']; ?></span></div>
                    <div class="info-item"><span class="label">Año</span><span class="value"><?php echo $siniestro['año']; ?></span></div>
                    <div class="info-item"><span class="label">Color</span><span class="value"><?php echo $siniestro['color']; ?></span></div>
                    <div class="info-item"><span class="label">Placas</span><span class="value"><?php echo $siniestro['placas']; ?></span></div>
                    <div class="info-item full-width"><span class="label">No. Serie</span><span class="value"><?php echo $siniestro['numero_serie']; ?></span></div>
                </div>
            </div>
        </div>

        <h3>Compañía de Seguros</h3>
        <div class="info-grid">
            <div class="info-item"><span class="label">Nombre</span><span class="value"><?php echo $siniestro['nombre_compania']; ?></span></div>
            <div class="info-item"><span class="label">Teléfono</span><span class="value"><?php echo $siniestro['telefono_compania']; ?></span></div>
            <div class="info-item"><span class="label">Correo</span><span class="value"><?php echo $siniestro['correo_compania']; ?></span></div>
            <div class="info-item full-width"><span class="label">Dirección</span><span class="value"><?php echo $siniestro['direccion_compania']; ?></span></div>
        </div>

        <hr class="divider">

        <h3>Multimedia Adjunta</h3>
        <div class="media-gallery">
            <?php if ($resultadoMedia->num_rows > 0) { ?>
                <?php while ($media = $resultadoMedia->fetch_assoc()) { ?>
                    <?php if ($media['tipo_archivo'] == "Foto") { ?>
                        <img src="<?php echo $media['url_archivo']; ?>" alt="Foto siniestro">
                    <?php } else { ?>
                        <video controls>
                            <source src="<?php echo $media['url_archivo']; ?>" type="video/mp4">
                        </video>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <p class="empty-msg">No hay archivos multimedia adjuntos.</p>
            <?php } ?>
        </div>

        <hr class="divider">

        <div class="comments-section">
            <div class="add-comment">
                <h3>Agregar Comentario</h3>

                <?php if (isset($_SESSION['errores_aprobacion'])) { ?>
                    <div class="error-box">
                        <?php foreach ($_SESSION['errores_aprobacion'] as $error) { ?>
                            <p><?php echo $error; ?></p>
                        <?php } ?>
                    </div>
                    <?php unset($_SESSION['errores_aprobacion']); ?>
                <?php } ?>

                <form action="guardar_comentario.php" method="POST">
                    <input type="hidden" name="id_siniestro" value="<?php echo $id_siniestro; ?>">
                    <textarea name="comentario" rows="4" placeholder="Escribe un comentario o actualización..." required></textarea>
                    <button type="submit">Enviar Comentario</button>
                </form>
            </div>

            <div class="history-list">
                <h3>Historial de Seguimiento</h3>
                <?php if ($resultadoSeguimiento->num_rows > 0) { ?>
                    <?php while ($seguimiento = $resultadoSeguimiento->fetch_assoc()) { ?>
                        <div class="comment-card">
                            <div class="comment-header">
                                <strong><?php echo $seguimiento['nombre']; ?></strong>
                                <span class="date"><?php echo date("d M Y, H:i", strtotime($seguimiento['fecha_comentario'])); ?></span>
                            </div>
                            <div class="comment-body">
                                <?php echo $seguimiento['comentario']; ?>
                            </div>
                            <?php if (!empty($seguimiento['respuesta'])) { ?>
                                <div class="reply-box">
                                    <strong>Respuesta:</strong> <?php echo $seguimiento['respuesta']; ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="empty-msg">No hay comentarios todavía.</p>
                <?php } ?>
            </div>
        </div>

    </div>

    <?php $bd->cerrar(); ?>
</body>
</html>
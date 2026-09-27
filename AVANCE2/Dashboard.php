<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

$tipo_usuario = $_SESSION['tipo_usuario'] ?? 'Desconocido';

require_once "Conexion.php";
$bd = new Conexion();

// ── Filtro de fechas desde el formulario GET ──────────────────────────────
$fecha_desde = $_GET['fecha_desde'] ?? '';
$fecha_hasta = $_GET['fecha_hasta'] ?? '';

// ── Construir consulta según tipo de usuario + rango de fechas ────────────
$where  = [];
$params = [];
$types  = '';

if ($tipo_usuario == "Ajustador") {
    $where[]  = 'id_ajustador = ?';
    $params[] = $_SESSION['id_usuario'];
    $types   .= 'i';
} elseif ($tipo_usuario != "Supervisor") {
    $where[]  = 'correo_cliente = ?';
    $params[] = $_SESSION['correo'] ?? '';
    $types   .= 's';
}

if ($fecha_desde !== '') {
    $where[]  = 'DATE(fecha_siniestro) >= ?';
    $params[] = $fecha_desde;
    $types   .= 's';
}
if ($fecha_hasta !== '') {
    $where[]  = 'DATE(fecha_siniestro) <= ?';
    $params[] = $fecha_hasta;
    $types   .= 's';
}

$sql = "SELECT * FROM vista_siniestros";
if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY fecha_siniestro DESC';

$stmt = $bd->conexion->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$resultadoSiniestros = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoTrack - Panel Principal</title>
    <link rel="stylesheet" href="Dashboard.css">
</head>
<body>

    <div class="esfera-fondo esfera-1"></div>
    <div class="esfera-fondo esfera-2"></div>
    <div class="esfera-fondo esfera-3"></div>

    <div class="dashboard-glass">

        <h1>Panel Principal</h1>

        <nav>
            <?php if ($tipo_usuario == "Supervisor" || $tipo_usuario == "Ajustador"): ?>
                <a href="Report.php" class="nav-btn">Registrar Siniestro</a>
            <?php endif; ?>
            <?php if ($tipo_usuario == "Supervisor"): ?>
                <a href="SignUp.php" class="nav-btn">Registrar Usuarios</a>
            <?php endif; ?>
            <a href="AdvancedSearch.php" class="nav-btn">Búsqueda</a>
            <a href="logout.php" class="nav-btn logout-btn">Cerrar Sesión</a>
        </nav>

        <h2>Listado de Siniestros</h2>

        <!-- ── Filtro de fechas ── -->
        <form method="GET" action="Dashboard.php" class="date-filter-form">
            <div class="date-filter-group">
                <div class="date-input-wrap">
                    <label for="fecha_desde">DESDE</label>
                    <input type="date" id="fecha_desde" name="fecha_desde"
                           value="<?php echo htmlspecialchars($fecha_desde); ?>">
                </div>
                <div class="date-input-wrap">
                    <label for="fecha_hasta">HASTA</label>
                    <input type="date" id="fecha_hasta" name="fecha_hasta"
                           value="<?php echo htmlspecialchars($fecha_hasta); ?>">
                </div>
                <button type="submit" class="filter-btn">Filtrar</button>
                <?php if ($fecha_desde !== '' || $fecha_hasta !== ''): ?>
                    <a href="Dashboard.php" class="clear-btn">Limpiar</a>
                <?php endif; ?>
            </div>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No. Siniestro</th>
                        <th>Fecha</th>
                        <th>Asegurado</th>
                        <th>Estado</th>
                        <th>Tipo de Pago</th>
                        <th>Acciones</th>
                        <?php if ($tipo_usuario == "Supervisor"): ?>
                            <th>Aprobaciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultadoSiniestros->num_rows > 0): ?>
                        <?php while ($s = $resultadoSiniestros->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $s['id_siniestro']; ?></td>
                                <td><?php echo date("d/m/Y H:i", strtotime($s['fecha_siniestro'])); ?></td>
                                <td><?php echo htmlspecialchars($s['nombre_cliente']); ?></td>
                                <td>
                                    <span class="badge-estado">
                                        <?php echo htmlspecialchars($s['estado'] ?? 'Pendiente'); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-pago">
                                        <?php echo htmlspecialchars($s['tipo_pago'] ?? '—'); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="ReportDetails.php?id=<?php echo $s['id_siniestro']; ?>" class="action-link">Ver Detalle</a>
                                </td>
                                <?php if ($tipo_usuario == "Supervisor"): ?>
                                    <td>
                                        <a href="Aprobaciones.php?id=<?php echo $s['id_siniestro']; ?>" class="action-link">Ver Detalles</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="empty-state">No hay siniestros en el rango seleccionado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="Dashboard.js"></script>
    <?php $bd->cerrar(); ?>

</body>
</html>
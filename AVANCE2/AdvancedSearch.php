<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

$tipo_usuario = $_SESSION['tipo_usuario'] ?? 'Desconocido';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoTrack - Búsqueda</title>
    <link rel="stylesheet" href="AdvancedSearch.css">
</head>
<body>

    <div class="esfera-fondo esfera-1"></div>
    <div class="esfera-fondo esfera-2"></div>
    <div class="esfera-fondo esfera-3"></div>

    <a href="Dashboard.php" class="flecha-regresar">←</a>

    <div class="search-wrapper">

        <!-- Panel de búsqueda -->
        <div class="glass-panel">
            <h2>Búsqueda de Siniestros</h2>
            <p class="subtitle">Ingresa uno o más parámetros para localizar el expediente.</p>

            <form id="searchForm">

                <div class="input-group">
                    <label for="id_siniestro">NÚMERO DE SINIESTRO</label>
                    <input type="text" id="id_siniestro" name="id_siniestro" placeholder="Ej. 1045">
                </div>

                <div class="input-group">
                    <label for="placas">PLACAS DEL VEHÍCULO</label>
                    <input type="text" id="placas" name="placas" placeholder="Ej. ABC-123">
                </div>

                <div class="input-group">
                    <label for="poliza">NÚMERO DE PÓLIZA</label>
                    <input type="text" id="poliza" name="poliza" placeholder="Ej. POL-987654321">
                </div>

                <button type="submit" id="btnBuscar">Buscar Expediente</button>

            </form>
        </div>

        <!-- Panel de resultados (oculto hasta que se busque) -->
        <div class="results-panel" id="resultsPanel" style="display:none;">
            <h2 class="results-title">Resultados</h2>

            <div id="mensajeResultado" class="empty-state" style="display:none;"></div>

            <div class="table-container" id="tablaContainer" style="display:none;">
                <table>
                    <thead>
                        <tr>
                            <th>No. Siniestro</th>
                            <th>Fecha</th>
                            <th>Asegurado</th>
                            <th>Estado</th>
                            <th>Tipo de Pago</th>
                            <th>Acciones</th>
                            <?php if ($tipo_usuario === "Supervisor"): ?>
                                <th>Aprobaciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="tablaResultados"></tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        // Pasa el tipo de usuario al JS de forma segura
        const tipoUsuario = <?php echo json_encode($tipo_usuario); ?>;
    </script>
    <script src="AdvancedSearch.js"></script>

</body>
</html>
<?php
session_start();

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoTrack - Registrar Siniestro</title>
    <link rel="stylesheet" href="Report.css">
</head>
<body>

    <div class="esfera-fondo esfera-1"></div>
    <div class="esfera-fondo esfera-2"></div>
    <div class="esfera-fondo esfera-3"></div>

    <a href="Dashboard.php" class="flecha-regresar">←</a>

    <div class="glass-panel form-panel">
        
        <h2>Registro de Siniestro</h2>

        <form action="registrar_siniestro.php" method="POST" enctype="multipart/form-data">

            <div class="form-section">
                <h3>Datos de la Compañía</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Nombre de la compañía *</label>
                        <input type="text" name="nombre_compania" placeholder="Ej. Seguros XYZ" required>
                    </div>
                    <div class="input-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion_compania" placeholder="Calle, Ciudad, Estado">
                    </div>
                    <div class="input-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono_compania" placeholder="Ej. 555-123-4567">
                    </div>
                    <div class="input-group">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo_compania" placeholder="contacto@seguros.com">
                    </div>
                </div>
            </div>

            <hr class="divider">

            <div class="form-section">
                <h3>Datos del Cliente</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Nombre del cliente *</label>
                        <input type="text" name="nombre_cliente" placeholder="Nombre completo" required>
                    </div>
                    <div class="input-group">
                        <label>Número de póliza *</label>
                        <input type="text" name="num_poliza" placeholder="Ej. POL-987654321" required>
                    </div>
                    <div class="input-group full-width">
                        <label>Correo del cliente</label>
                        <input type="email" name="correo_cliente" placeholder="cliente@correo.com">
                    </div>
                </div>
            </div>

            <hr class="divider">

            <div class="form-section">
                <h3>Datos del Vehículo</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Marca *</label>
                        <input type="text" name="marca" placeholder="Ej. Toyota" required>
                    </div>
                    <div class="input-group">
                        <label>Modelo *</label>
                        <input type="text" name="modelo" placeholder="Ej. Corolla" required>
                    </div>
                    <div class="input-group">
                        <label>Año *</label>
                        <input type="number" name="año" placeholder="Ej. 2023" required>
                    </div>
                    <div class="input-group">
                        <label>Color</label>
                        <input type="text" name="color" placeholder="Ej. Rojo">
                    </div>
                    <div class="input-group">
                        <label>Placas</label>
                        <input type="text" name="placas" placeholder="Ej. ABC-123">
                    </div>
                    <div class="input-group">
                        <label>Número de serie (VIN)</label>
                        <input type="text" name="num_serie" placeholder="17 caracteres">
                    </div>
                </div>
            </div>

            <hr class="divider">

            <div class="form-section">
                <h3>Datos del Siniestro</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Fecha y Hora *</label>
                        <input type="datetime-local" name="fecha_hora" required>
                    </div>
                    <div class="input-group">
                        <label>Ubicación *</label>
                        <input type="text" name="ubicacion" placeholder="Lugar del accidente" required>
                    </div>
                    <div class="input-group">
                        <label>¿Hubo otras unidades involucradas?</label>
                        <select name="otras_uni">
                            <option value="No">No</option>
                            <option value="Sí">Sí</option>
                        </select>
                    </div>
                    <div class="input-group full-width">
                        <label>Descripción de los hechos *</label>
                        <textarea name="descripcion" rows="4" placeholder="Describe detalladamente cómo ocurrió el siniestro..." required></textarea>
                    </div>
                </div>
            </div>

            <hr class="divider">

            <div class="form-section">
                <h3>Evidencia Multimedia</h3>
                <div class="input-group full-width">
                    <label>Adjuntar Fotos o Videos (Puedes seleccionar múltiples archivos)</label>
                    <input type="file" name="multimedia[]" multiple class="file-input">
                </div>
            </div>

            <button type="submit" class="submit-btn">Guardar Siniestro</button>

        </form>

    </div>

</body>
</html>
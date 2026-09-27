document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault();
    buscarSiniestros();
});

async function buscarSiniestros() {
    const idSiniestro = document.getElementById('id_siniestro').value.trim();
    const placas      = document.getElementById('placas').value.trim();
    const poliza      = document.getElementById('poliza').value.trim();

    const btnBuscar      = document.getElementById('btnBuscar');
    const resultsPanel   = document.getElementById('resultsPanel');
    const tablaContainer = document.getElementById('tablaContainer');
    const mensaje        = document.getElementById('mensajeResultado');
    const tbody          = document.getElementById('tablaResultados');

    // Estado de carga
    btnBuscar.textContent = 'Buscando…';
    btnBuscar.disabled    = true;

    // Construir URL con parámetros
    const params = new URLSearchParams({
        id_siniestro: idSiniestro,
        placas:       placas,
        poliza:       poliza
    });

    try {
        const response = await fetch(`buscar_siniestros.php?${params}`);
        const data     = await response.json();

        resultsPanel.style.display = 'block';

        if (data.error) {
            mostrarMensaje(mensaje, data.error);
            tablaContainer.style.display = 'none';
            return;
        }

        if (data.mensaje) {
            // Sin resultados o sin parámetros
            mostrarMensaje(mensaje, data.mensaje);
            tablaContainer.style.display = 'none';
        } else {
            mensaje.style.display        = 'none';
            tablaContainer.style.display = 'block';
            renderTabla(tbody, data.resultados);
        }

    } catch (err) {
        mostrarMensaje(mensaje, 'Error al conectar con el servidor. Intenta de nuevo.');
        tablaContainer.style.display = 'none';
    } finally {
        btnBuscar.textContent = 'Buscar Expediente';
        btnBuscar.disabled    = false;
    }
}

function renderTabla(tbody, siniestros) {
    tbody.innerHTML = '';

    siniestros.forEach(s => {
        // Formatear fecha legible
        const fecha = s.fecha_siniestro
            ? new Date(s.fecha_siniestro).toLocaleString('es-MX', {
                day:    '2-digit',
                month:  '2-digit',
                year:   'numeric',
                hour:   '2-digit',
                minute: '2-digit'
              })
            : '—';

        const estado = s.estado ?? 'Pendiente';

        // Columna de aprobaciones sólo para Supervisor
        const aprobaciones = tipoUsuario === 'Supervisor'
            ? `<td><a href="Aprobaciones.php?id=${s.id_siniestro}" class="action-link">Ver Detalles</a></td>`
            : '';

        const tipoPago = s.tipo_pago ?? '—';

        tbody.innerHTML += `
            <tr>
                <td>${s.id_siniestro}</td>
                <td>${fecha}</td>
                <td>${escapeHtml(s.nombre_cliente ?? '')}</td>
                <td><span class="badge-estado">${escapeHtml(estado)}</span></td>
                <td><span class="badge-pago">${escapeHtml(tipoPago)}</span></td>
                <td><a href="ReportDetails.php?id=${s.id_siniestro}" class="action-link">Ver Detalle</a></td>
                ${aprobaciones}
            </tr>
        `;
    });
}

function mostrarMensaje(el, texto) {
    el.textContent    = texto;
    el.style.display  = 'block';
}

// Evitar XSS al insertar texto en el DOM
function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}
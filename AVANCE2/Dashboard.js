function cargarSiniestros() {
    let tabla = document.getElementById("tablaSiniestros");

    let siniestros = JSON.parse(localStorage.getItem("siniestros")) || [];
    let usuarioActual = JSON.parse(localStorage.getItem("usuarioActivo"));

    tabla.innerHTML = "";

    // Filtrar según tipo de usuario
    let siniestrosFiltrados = [];

    if (usuarioActual.tipo === "supervisor") {
        
        siniestrosFiltrados = siniestros;
    } else if (usuarioActual.tipo === "ajustador") {
        
        siniestrosFiltrados = siniestros.filter(s => s.ajustadorId === usuarioActual.id);
    } else if (usuarioActual.tipo === "asegurado") {
        
        siniestrosFiltrados = siniestros.filter(s => s.aseguradoId === usuarioActual.id);
    }

    
    siniestrosFiltrados.forEach(s => {
        tabla.innerHTML += `
        <tr>
            <td>${s.id}</td>
            <td>${s.fecha}</td>
            <td>${s.asegurado}</td>
            <td>${s.estado}</td>
            <td>
                <button onclick="verDetalle(${s.id})">
                Ver
                </button>
            </td>
        </tr>
        `;
    });
}

function verDetalle(id){

    localStorage.setItem("siniestroSeleccionado", id);

    window.location.href = "ReportDetails.html";

}

window.onload = cargarSiniestros;




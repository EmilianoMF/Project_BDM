function registrarSiniestro() {
    let fecha = document.getElementById("fecha").value;
    let ubicacion = document.getElementById("ubicacion").value;
    let descripcion = document.getElementById("descripcion").value;
    let placas = document.getElementById("placas").value;
    let poliza = document.getElementById("poliza").value;

    
    let archivos = document.getElementById("multimedia").files; 
    let tieneImagen = false;
    let tieneVideo = false;

    for (let i = 0; i < archivos.length; i++) {
        if (archivos[i].type.startsWith("image/")) {
            tieneImagen = true;
        } else if (archivos[i].type.startsWith("video/")) {
            tieneVideo = true;
        }
    }

    // Validación imagen y video
    if (!tieneImagen || !tieneVideo) {
        alert("Debes seleccionar al menos una imagen y un video antes de registrar el siniestro.");
        return; 
    }
    

    let usuario = JSON.parse(localStorage.getItem("usuarioActivo"));
    let siniestros = JSON.parse(localStorage.getItem("siniestros")) || [];

    let nuevo = {
        id: siniestros.length + 1,
        fecha,
        ubicacion,
        descripcion,
        placas,
        poliza,
        estado: "Pendiente",
        ajustador: usuario.nombre,
        comentarios: [],
        multimedia: [] 
    };

    siniestros.push(nuevo);
    localStorage.setItem("siniestros", JSON.stringify(siniestros));

    alert("Siniestro registrado correctamente");
}

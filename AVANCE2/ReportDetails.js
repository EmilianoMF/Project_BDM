function cargarDetalle(){

    let id = localStorage.getItem("siniestroSeleccionado");

    let siniestros = JSON.parse(localStorage.getItem("siniestros"));

    let siniestro = siniestros.find(s => s.id == id);

    document.getElementById("NumSiniestro").innerText = siniestro.NumSiniestro;
    document.getElementById("descripcion").innerText = siniestro.descripcion;
    document.getElementById("estado").innerText = siniestro.estado;
    //AGREGAR MULTIMEDIA 

}

function agregarComentario(){

    let texto = document.getElementById("comentario").value;

    let id = localStorage.getItem("siniestroSeleccionado");

    let siniestros = JSON.parse(localStorage.getItem("siniestros"));

    let siniestro = siniestros.find(s => s.id == id);

    let usuario = JSON.parse(localStorage.getItem("usuarioActivo"));

    let comentario = {

        usuario: usuario.nombre,
        texto: texto,
        fecha: new Date().toLocaleString()

    };

    siniestro.comentarios.push(comentario);

    localStorage.setItem("siniestros", JSON.stringify(siniestros));

    alert("Comentario agregado");

}
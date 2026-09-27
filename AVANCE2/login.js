function login() {

    let correo = document.getElementById("correo").value;
    let password = document.getElementById("password").value;

    let usuarios = JSON.parse(localStorage.getItem("usuarios")) || [];

    let usuario = usuarios.find(u => 
        u.correo === correo && u.password === password
    );

    if(usuario){

        localStorage.setItem("usuarioActivo", JSON.stringify(usuario));

        alert("Bienvenido " + usuario.nombre);

        window.location.href = "Dashboard.html";

    }else{

        alert("Correo o contraseña incorrectos");

    }

}

<button onclick="login()">Ingresar</button>
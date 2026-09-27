
// Validar Contraseña en Tiempo real 
document.addEventListener("DOMContentLoaded", function() {
    const passwordInput = document.getElementById("password");

    // Crear contenedor de requisitos
    const requisitos = document.createElement("div");
    requisitos.innerHTML = `
        <p><strong>Requisitos de contraseña:</strong></p>
        <ul id="listaRequisitos">
            <li id="longitud">❌ Mínimo 8 caracteres</li>
            <li id="mayuscula">❌ Al menos una letra mayúscula</li>
            <li id="minuscula">❌ Al menos una letra minúscula</li>
            <li id="numero">❌ Al menos un número</li>
            <li id="especial">❌ Al menos un carácter especial (!@#$%^&*)</li>
        </ul>
    `;
    passwordInput.insertAdjacentElement("afterend", requisitos);

    // Función para validar en tiempo real
    passwordInput.addEventListener("input", function() {
        const valor = passwordInput.value;

        
        document.getElementById("longitud").textContent =
            valor.length >= 8 ? "✅ Mínimo 8 caracteres" : "❌ Mínimo 8 caracteres";

       
        document.getElementById("mayuscula").textContent =
            /[A-Z]/.test(valor) ? "✅ Al menos una letra mayúscula" : "❌ Al menos una letra mayúscula";

       
        document.getElementById("minuscula").textContent =
            /[a-z]/.test(valor) ? "✅ Al menos una letra minúscula" : "❌ Al menos una letra minúscula";

        
        document.getElementById("numero").textContent =
            /[0-9]/.test(valor) ? "✅ Al menos un número" : "❌ Al menos un número";

        
        document.getElementById("especial").textContent =
            /[!@#$%^&*(),.?":{}|<>]/.test(valor) ? "✅ Al menos un carácter especial" : "❌ Al menos un carácter especial";
    });
});

document.getElementById("foto").addEventListener("change", function(event) {
    const file = event.target.files[0];

    if (file) {

        if (!file.type.startsWith("image/")) {
            alert("Selecciona un archivo de imagen");
            return;
        }


        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById("preview");
            preview.src = e.target.result;
            preview.style.display = "block";
        }

        reader.readAsDataURL(file);
    }
});


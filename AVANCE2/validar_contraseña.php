<?php
function validarContraseña($contraseña) {
    $errores = [];

    // Longitud mínima
    if (strlen($contraseña) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres.";
    }

    // Mayúsculas
    if (!preg_match('/[A-Z]/', $contraseña)) {
        $errores[] = "Debe contener al menos una letra mayúscula.";
    }

    // Minúsculas
    if (!preg_match('/[a-z]/', $contraseña)) {
        $errores[] = "Debe contener al menos una letra minúscula.";
    }

    // Números
    if (!preg_match('/[0-9]/', $contraseña)) {
        $errores[] = "Debe contener al menos un número.";
    }

    // Caracteres especiales
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $contraseña)) {
        $errores[] = "Debe contener al menos un carácter especial.";
    }

    // Resultado
    if (empty($errores)) {
        return true; // Contraseña válida
    } else {
        return $errores; // Devuelve lista de errores
    }
}

?>

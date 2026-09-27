USE bdm_pia;


DELIMITER //
CREATE PROCEDURE sp_registrar_usuario (
    IN p_nombre VARCHAR(50),
    IN p_apellidos VARCHAR(50),
    IN p_fecha_nacimiento DATE,
    IN p_foto VARCHAR(255),
    IN p_genero ENUM('Masculino','Femenino','Otro'),
    IN p_correo VARCHAR(100),
    IN p_contraseña VARCHAR(255),
    IN p_alias VARCHAR(50),
    IN p_tipo_usuario ENUM('Ajustador','Supervisor','Asegurado')
)
BEGIN
    INSERT INTO Usuarios (nombre, apellidos, fecha_nacimiento, foto, genero, correo, contraseña, alias, tipo_usuario)
    VALUES (p_nombre, p_apellidos, p_fecha_nacimiento, p_foto, p_genero, p_correo, p_contraseña, p_alias, p_tipo_usuario);
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE sp_modificar_usuario (
    IN p_id_usuario INT,
    IN p_nombre VARCHAR(50),
    IN p_apellidos VARCHAR(50),
    IN p_fecha_nacimiento DATE,
    IN p_foto VARCHAR(255),
    IN p_genero ENUM('Masculino','Femenino','Otro'),
    IN p_correo VARCHAR(100),
    IN p_contraseña VARCHAR(255),
    IN p_alias VARCHAR(50),
    IN p_tipo_usuario ENUM('Ajustador','Supervisor','Asegurado')
)
BEGIN
    UPDATE Usuarios
    SET nombre = p_nombre,
        apellidos = p_apellidos,
        fecha_nacimiento = p_fecha_nacimiento,
        foto = p_foto,
        genero = p_genero,
        correo = p_correo,
        contraseña = p_contraseña,
        alias = p_alias,
        tipo_usuario = p_tipo_usuario
    WHERE id_usuario = p_id_usuario;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE sp_eliminar_usuario (
    IN p_id_usuario INT
)
BEGIN
    DELETE FROM Usuarios WHERE id_usuario = p_id_usuario;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE sp_consultar_usuarios ()
BEGIN
    SELECT id_usuario, nombre, apellidos, correo, tipo_usuario
    FROM Usuarios;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE sp_consultar_usuario_por_id (
    IN p_id_usuario INT
)
BEGIN
    SELECT * FROM Usuarios WHERE id_usuario = p_id_usuario;
END //
DELIMITER ;

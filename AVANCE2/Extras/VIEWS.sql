CREATE VIEW vista_siniestros AS

SELECT
    s.id_siniestro,
    s.fecha_siniestro,
    s.nombre_cliente,
    s.correo_cliente,
    s.estado,
    s.ubicacion,
    s.numero_poliza,

    u.marca,
    u.modelo,
    u.color,
    u.placas,

    usr.nombre AS nombre_ajustador,

    s.id_ajustador

FROM Siniestros s

INNER JOIN Unidades u
ON s.id_unidad = u.id_unidad

INNER JOIN Usuarios usr
ON s.id_ajustador = usr.id_usuario;



CREATE VIEW vista_detalle_siniestro AS
SELECT

    s.id_siniestro,
    s.id_ajustador,
    s.id_supervisor,

    s.nombre_compania,
    s.direccion_compania,
    s.telefono_compania,
    s.correo_compania,

    s.nombre_cliente,
    s.correo_cliente,

    s.fecha_siniestro,
    s.ubicacion,
    s.descripcion,
    s.otras_Uni,
    s.numero_poliza,
    s.tipo_pago,
    s.estado,
    s.fecha_aprobacion,
    s.fecha_finalizacion,

    u.marca,
    u.modelo,
    u.año,
    u.color,
    u.placas,
    u.numero_serie

FROM Siniestros s

INNER JOIN Unidades u
ON s.id_unidad = u.id_unidad;



CREATE VIEW vista_seguimiento AS
SELECT

    s.id_seguimiento,
    s.id_siniestro,
    s.comentario,
    s.respuesta,
    s.fecha_comentario,
    s.fecha_respuesta,

    u.nombre,
    u.tipo_usuario

FROM Seguimiento s

INNER JOIN Usuarios u
ON s.id_usuario = u.id_usuario;
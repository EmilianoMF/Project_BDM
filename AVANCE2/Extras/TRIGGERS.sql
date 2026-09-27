
DELIMITER //

CREATE TRIGGER trg_fecha_aprobacion
BEFORE UPDATE ON Siniestros
FOR EACH ROW
BEGIN

    IF (
        NEW.estado = 'Aceptado'
        OR NEW.estado = 'Aceptado con deducible'
        OR NEW.estado = 'Aceptado sin deducible'
    )
    AND (
        OLD.estado IS NULL
        OR OLD.estado <> NEW.estado
    ) THEN

        SET NEW.fecha_aprobacion = NOW();

    END IF;

END//

DELIMITER ;



DELIMITER //

CREATE TRIGGER trg_fecha_finalizacion
BEFORE UPDATE ON Siniestros
FOR EACH ROW
BEGIN

    IF (
        NEW.estado = 'Rechazado'
        OR NEW.estado = 'Pago reparación'
        OR NEW.estado = 'Pérdida total'
    )
    AND (
        OLD.estado IS NULL
        OR OLD.estado <> NEW.estado
    ) THEN

        SET NEW.fecha_finalizacion = NOW();

    END IF;

END//

DELIMITER ;

CREATE TRIGGER trigger_fecha_seguimiento
BEFORE INSERT ON Seguimiento
FOR EACH ROW
SET NEW.fecha_comentario = NOW();

SELECT
    estado,
    fecha_aprobacion,
    fecha_finalizacion
FROM Siniestros
WHERE id_siniestro = 1;

SHOW TRIGGERS;
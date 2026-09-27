DELIMITER //  //CALCULAR LA ANTIGüEDAD DEL SINIESTRO 

CREATE FUNCTION dias_siniestro(fecha DATETIME)
RETURNS INT
DETERMINISTIC

BEGIN

    RETURN DATEDIFF(NOW(), fecha);

END//

DELIMITER ;


DELIMITER //  //PRIORIDAD DE CADA SINIESTRO

CREATE FUNCTION prioridad_siniestro(tipo VARCHAR(50))
RETURNS VARCHAR(50)
DETERMINISTIC

BEGIN

    DECLARE prioridad VARCHAR(50);

    IF tipo = 'Pérdida total' THEN
        SET prioridad = 'Alta';

    ELSEIF tipo = 'Reparación' THEN
        SET prioridad = 'Media';

    ELSE
        SET prioridad = 'Baja';

    END IF;

    RETURN prioridad;

END//

DELIMITER ;
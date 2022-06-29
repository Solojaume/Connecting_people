
/*
Update estado_conexion_u1 con filtros solo para matches
*/
UPDATE `mach` SET `estado_conexion_u1` = '' WHERE `mach`.`match_id_usu1` = 1 &&(match_estado_u1=1 && match_estado_u2=1);

/*
Update estado_conexion_u2 con filtros solo para matches
*/
UPDATE `mach` SET `estado_conexion_u2` = '' WHERE `mach`.`match_id_usu2` = 1 &&(match_estado_u1=1 && match_estado_u2=1);

/*
Update estado_conexion_u1
*/
UPDATE `mach` SET `estado_conexion_u1` = 'Desconectado' WHERE `mach`.`match_id_usu1` = 1 ;

/*
Update estado_conexion_u2
*/
UPDATE `mach` SET `estado_conexion_u2` = 'Desconectado' WHERE `mach`.`match_id_usu2` = 1;


CREATE TRIGGER upd_estatus_conexion BEFORE UPDATE ON usuario
    FOR EACH ROW
    BEGIN
        IF (ISNULL(NEW.ip_cliente) && ISNULL(NEW.puerto_cliente))&&(ISNULL(NEW.ip_servidor) && ISNULL(NEW.puerto_servidor)) THEN
            /*
                Update estado_conexion_u1
            */
            UPDATE `mach` SET `estado_conexion_u1` = 'Desconectado' WHERE `mach`.`match_id_usu1` = NEW.id && OLD.ID=NEW.ID;

            /*
                Update estado_conexion_u2
            */
            UPDATE `mach` SET `estado_conexion_u2` = 'Desconectado' WHERE `mach`.`match_id_usu2` =  NEW.id && OLD.ID=NEW.ID;
        ELSEIF (NEW.ip_cliente="" && NEW.puerto_cliente="")&& (NEW.ip_servidor="" && NEW.puerto_servidor="") THEN
            /*
                Update estado_conexion_u1
            */
            UPDATE `mach` SET `estado_conexion_u1` = 'Desconectado' WHERE `mach`.`match_id_usu1` = NEW.id && OLD.ID=NEW.ID;

            /*
                Update estado_conexion_u2
            */
            UPDATE `mach` SET `estado_conexion_u2` = 'Desconectado' WHERE `mach`.`match_id_usu2` =  NEW.id && OLD.ID=NEW.ID;
        ELSEIF  (NEW.ip_cliente!="" && NEW.puerto_cliente!="")&& (NEW.ip_servidor!="" && NEW.puerto_servidor!="") THEN
            UPDATE `mach` SET `estado_conexion_u1` = 'Conectado' WHERE `mach`.`match_id_usu1` = NEW.id && OLD.ID=NEW.ID;

            /*
                Update estado_conexion_u2
            */
            UPDATE `mach` SET `estado_conexion_u2` = 'Conectado' WHERE `mach`.`match_id_usu2` =  NEW.id && OLD.ID=NEW.ID;
       END IF;
    END;
/* 
*
*/
UPDATE `mach` SET `estado_conexion_u1` = 'Escriviendo' WHERE `mach`.`match_id` = 2 && match_id_usu1=1;

    
 
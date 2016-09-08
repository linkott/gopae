-- Function: auditoria_etls.registro_log_group(character varying, integer, character varying, integer, timestamp without time zone, character varying, timestamp without time zone, character varying, text, timestamp without time zone, character varying)

-- DROP FUNCTION auditoria_etls.registro_log_group(character varying, integer, character varying, integer, timestamp without time zone, character varying, timestamp without time zone, character varying, text, timestamp without time zone, character varying);

CREATE OR REPLACE FUNCTION auditoria_etls.registro_log_group(groupname_vi character varying, level_vi integer, home_vi character varying, date_ini_vi timestamp without time zone, estatus_vi character varying, date_del_vi timestamp without time zone, resultado_vi character varying, mensaje_vi text, fecha_vi timestamp without time zone, operacion_vi character varying)
  RETURNS text AS
$BODY$
DECLARE
    
    group_id_v INTEGER :=0;   
    fecha_v TIMESTAMP WITHOUT TIME ZONE;
    mensaje_v TEXT; -- Mensaje que sera mostrado al usuario para indicarle el resultado_vo de la transaccion
    seccion_v INTEGER := 0;

BEGIN

    -- @author Nelson Gonzalez
    -- @date 2015-02-09 02:00

    RAISE NOTICE 'DATO: %', groupname_vi;

    RAISE NOTICE 'INICIO';

    fecha_v := (now())::timestamp(0);

    seccion_v := 1;
    INSERT INTO auditoria_etls.log_group(
        groupname,
        level,
        home,
        date_ini,
        estatus,
        date_del, 
        resultado,
        mensaje,
        fecha,
        operacion)
    VALUES (
        groupname_vi::character varying,
        level_vi::integer,
        home_vi::character varying,
        date_ini_vi::timestamp,
        estatus_vi::character varying,
        date_del_vi::timestamp,
        resultado_vi::character varying,
        mensaje_vi::text,
        fecha_v::timestamp,
        operacion_vi::character varying
    ) RETURNING id INTO group_id_v;

    RAISE NOTICE 'group_id: %',group_id_v;

    RETURN group_id_v;
EXCEPTION WHEN OTHERS THEN
    mensaje_v := 'Funcion auditoria_etls.resgistro_log_group Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (Seccion: '||seccion_v||')';
        
RETURN group_id_v;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION auditoria_etls.registro_log_group(character varying, integer, character varying, timestamp without time zone, character varying, timestamp without time zone, character varying, text, timestamp without time zone, character varying)
  OWNER TO postgres;

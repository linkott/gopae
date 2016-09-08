-- Function: auditoria_etls.log_autoridad_plantel(integer,integer,integer,integer,timestamp,character varying,character varying,text,timestamp,character varying)

-- DROP FUNCTION auditoria_etls.log_autoridad_plantel(integer,integer,integer,integer,timestamp,character varying,character varying,text,timestamp,character varying);

CREATE OR REPLACE FUNCTION auditoria_etls.log_autoridad_plantel(
  plantel_id_vi integer,
  usuario_id_vi integer,
  cargo_id_vi integer,
  usuario_ini_id_vi integer,
  fecha_ini_vi timestamp,
  estatus_vi character varying,
  resultado_vi character varying,
  mensaje_vi text,
  fecha_vi timestamp,
  operacion_vi character varying
)
 RETURNS text AS
$BODY$
DECLARE
    
  autoridad_plantel_id_v bigint :=0;   
  fecha_v TIMESTAMP WITHOUT TIME ZONE;
  mensaje_v TEXT; -- Mensaje que sera mostrado al usuario para indicarle el resultado_vo de la transaccion
  seccion_v INTEGER := 0;

BEGIN

  -- @author Nelson Gonzalez
  -- @date 2015-02-24 4:02

  RAISE NOTICE 'DATO: % - %', plantel_id_vi,usuario_id_vi;

  RAISE NOTICE 'INICIO';

  fecha_v := (now())::timestamp(0);

  seccion_v := 1;
  INSERT INTO auditoria_etls.log_autoridad_plantel(
    plantel_id, 
    usuario_id, 
    cargo_id,  
    usuario_ini_id, 
    fecha_ini,
    estatus, 
    resultado, 
    mensaje, 
    fecha, 
    operacion
  )
  VALUES (
    plantel_id_vi::integer, 
    usuario_id_vi::integer, 
    cargo_id_vi::integer,  
    usuario_ini_id_vi::integer, 
    fecha_ini_vi::timestamp,
    estatus_vi::character varying, 
    resultado_vi::character varying, 
    mensaje_vi::text, 
    fecha_v::timestamp, 
    operacion_vi::character varying
  ) RETURNING id INTO autoridad_plantel_id_v;

  RAISE NOTICE 'autoridad_plantel_id_v: %',autoridad_plantel_id_v;

  RETURN autoridad_plantel_id_v;
EXCEPTION WHEN OTHERS THEN
  mensaje_v := 'Funcion auditoria_etls.log_autoridad_plantel Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (Seccion: '||seccion_v||')';
        
RETURN autoridad_plantel_id_v;
END;
$BODY$
LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION auditoria_etls.log_autoridad_plantel(
   integer,
  integer,
  integer,
  integer,
  timestamp,
  character varying,
  character varying,
  text,
  timestamp,
  character varying
)OWNER TO postgres;
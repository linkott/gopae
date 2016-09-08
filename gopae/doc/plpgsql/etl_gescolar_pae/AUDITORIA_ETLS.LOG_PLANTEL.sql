-- Function: auditoria_etls.log_plantel(bigint, character varying, integer, character varying, integer, integer, integer, integer, integer, integer, text, integer, integer, integer, integer, integer, character varying, character varying, character varying, integer, integer, integer, integer, integer, integer, integer, integer, integer, boolean, boolean, character varying, text, boolean, integer, integer, timestamp without time zone, timestamp without time zone, character varying, integer, double precision, double precision, integer, integer, integer, integer, character varying, character varying, integer, character varying, integer, integer, integer, character varying, text, timestamp without time zone, character varying, character varying)

-- DROP FUNCTION auditoria_etls.log_plantel(bigint, character varying, integer, character varying, integer, integer, integer, integer, integer, integer, text, integer, integer, integer, integer, integer, character varying, character varying, character varying, integer, integer, integer, integer, integer, integer, integer, integer, integer, boolean, boolean, character varying, text, boolean, integer, integer, timestamp without time zone, timestamp without time zone, character varying, integer, double precision, double precision, integer, integer, integer, integer, character varying, character varying, integer, character varying, integer, integer, integer, character varying, text, timestamp without time zone, character varying, character varying);

CREATE OR REPLACE FUNCTION auditoria_etls.log_plantel(
    cod_estadistico_vi bigint, 
    cod_plantel_vi character varying, 
    planta_fisica_id_vi integer, 
    nombre_vi character varying, 
    denominacion_id_vi integer, 
    tipo_dependencia_id_vi integer, 
    estado_id_vi integer, 
    municipio_id_vi integer, 
    parroquia_id_vi integer, 
    localidad_id_vi integer, 
    direccion_vi text, 
    distrito_id_vi integer, 
    zona_educativa_id_vi integer, 
    modalidad_id_vi integer, 
    nivel_id_vi integer, 
    condicion_estudio_id_vi integer, 
    correo_vi character varying, 
    telefono_fijo_vi character varying, 
    telefono_otro_vi character varying, 
    director_actual_id_vi integer, 
    director_supl_actual_id_vi integer, 
    subdirector_actual_id_vi integer, 
    subdirector_supl_actual_id_vi integer, 
    coordinador_actual_id_vi integer, 
    coordinador_supl_actual_id_vi integer, 
    clase_plantel_id_vi integer, 
    condicion_infra_id_vi integer, 
    categoria_id_vi integer, 
    posee_electricidad_vi boolean, 
    posee_edificacion_vi boolean, 
    logo_vi character varying, 
    observacion_vi text, 
    es_tecnica_vi boolean, 
    especialidad_tec_id_vi integer, 
    usuario_ini_id_vi integer, 
    fecha_ini_vi timestamp without time zone, 
    fecha_elim_vi timestamp without time zone, 
    estatus_vi character varying, 
    estatus_plantel_id_vi integer, 
    latitud_vi double precision, 
    longitud_vi double precision, 
    annio_fundado_vi integer, 
    turno_id_vi integer, 
    genero_id_vi integer, 
    zona_ubicacion_id_vi integer, 
    nfax_vi character varying, 
    codigo_ner_vi character varying, 
    cod_unico_vi integer, 
    cod_plantel_anterior_vi character varying, 
    poblacion_id_vi integer, 
    urbanizacion_id_vi integer, 
    tipo_via_id_vi integer, 
    via_vi character varying, 
    mensaje_vi text, 
    fecha_vi timestamp without time zone, 
    operacion_vi character varying, 
    resultado_vi character varying)
  RETURNS text AS
$BODY$
DECLARE

    plantel_id_v bigint :=0;   
    fecha_v TIMESTAMP WITHOUT TIME ZONE;
    mensaje_v TEXT; -- Mensaje que sera mostrado al usuario para indicarle el resultado_vo de la transaccion
    seccion_v INTEGER := 0;

BEGIN

    -- @author Nelson Gonzalez
    -- @date 2015-02-19 5:00

    RAISE NOTICE 'DATO: %', nombre_vi;

    RAISE NOTICE 'INICIO';

    fecha_v := (now())::timestamp(0);

    seccion_v := 1;
    INSERT INTO auditoria_etls.log_plantel( 
        cod_estadistico, 
        cod_plantel, 
        planta_fisica_id, 
        nombre, 
        denominacion_id, 
        tipo_dependencia_id, 
        estado_id, 
        municipio_id, 
        parroquia_id, 
        localidad_id, 
        direccion, 
        distrito_id, 
        zona_educativa_id, 
        modalidad_id, 
        nivel_id, 
        condicion_estudio_id, 
        correo, 
        telefono_fijo, 
        telefono_otro, 
        director_actual_id, 
        director_supl_actual_id, 
        subdirector_actual_id, 
        subdirector_supl_actual_id, 
        coordinador_actual_id, 
        coordinador_supl_actual_id, 
        clase_plantel_id, 
        condicion_infra_id, 
        categoria_id, 
        posee_electricidad, 
        posee_edificacion, 
        logo, 
        observacion, 
        es_tecnica, 
        especialidad_tec_id, 
        usuario_ini_id, 
        fecha_ini, 
        fecha_elim, 
        estatus, 
        estatus_plantel_id, 
        latitud, 
        longitud, 
        annio_fundado, 
        turno_id, 
        genero_id, 
        zona_ubicacion_id, 
        nfax, 
        codigo_ner, 
        cod_unico, 
        cod_plantel_anterior, 
        poblacion_id, 
        urbanizacion_id, 
        tipo_via_id, 
        via, 
        mensaje, 
        fecha, 
        operacion, 
        resultado
    )
    VALUES (
        cod_estadistico_vi, 
        cod_plantel_vi, 
        planta_fisica_id_vi, 
        nombre_vi, 
        denominacion_id_vi, 
        tipo_dependencia_id_vi, 
        estado_id_vi, 
        municipio_id_vi, 
        parroquia_id_vi, 
        localidad_id_vi, 
        direccion_vi, 
        distrito_id_vi, 
        zona_educativa_id_vi, 
        modalidad_id_vi, 
        nivel_id_vi, 
        condicion_estudio_id_vi, 
        correo_vi, 
        telefono_fijo_vi, 
        telefono_otro_vi, 
        director_actual_id_vi, 
        director_supl_actual_id_vi, 
        subdirector_actual_id_vi, 
        subdirector_supl_actual_id_vi, 
        coordinador_actual_id_vi, 
        coordinador_supl_actual_id_vi, 
        clase_plantel_id_vi, 
        condicion_infra_id_vi, 
        categoria_id_vi, 
        posee_electricidad_vi, 
        posee_edificacion_vi, 
        logo_vi, 
        observacion_vi, 
        es_tecnica_vi, 
        especialidad_tec_id_vi, 
        usuario_ini_id_vi, 
        fecha_ini_vi, 
        fecha_elim_vi, 
        estatus_vi, 
        estatus_plantel_id_vi, 
        latitud_vi, 
        longitud_vi, 
        annio_fundado_vi, 
        turno_id_vi, 
        genero_id_vi, 
        zona_ubicacion_id_vi, 
        nfax_vi, 
        codigo_ner_vi, 
        cod_unico_vi, 
        cod_plantel_anterior_vi, 
        poblacion_id_vi, 
        urbanizacion_id_vi, 
        tipo_via_id_vi, 
        via_vi, 
        mensaje_vi, 
        fecha_v, 
        operacion_vi, 
        resultado_vi
    ) RETURNING id INTO plantel_id_v;


    RAISE NOTICE 'plantel_id: %',plantel_id_v;

    RETURN plantel_id_v;
EXCEPTION WHEN OTHERS THEN
    mensaje_v := 'Funcion auditoria_etls.log_plantel Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (Seccion: '||seccion_v||')';
        
RETURN mensaje_v;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION auditoria_etls.log_plantel(bigint, character varying, integer, character varying, integer, integer, integer, integer, integer, integer, text, integer, integer, integer, integer, integer, character varying, character varying, character varying, integer, integer, integer, integer, integer, integer, integer, integer, integer, boolean, boolean, character varying, text, boolean, integer, integer, timestamp, timestamp, character varying, integer, double precision, double precision, integer, integer, integer, integer, character varying, character varying, integer, character varying, integer, integer, integer, character varying, text, timestamp without time zone, character varying, character varying
)OWNER TO postgres;


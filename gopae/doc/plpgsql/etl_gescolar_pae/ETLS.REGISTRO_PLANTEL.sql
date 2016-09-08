-- Function: etls.registro_plantel(bigint, character varying, integer,character varying, integer, integer, integer, integer, integer, integer, text, integer, integer, integer, integer, integer, character varying(100), character varying, character varying, integer, integer, integer, integer, integer, integer, integer, integer, integer, boolean, boolean, character varying, text, boolean, integer, integer, timestamp , integer, timestamp, timestamp, character varying, integer, double precision, double precision, integer, integer, integer, integer, character varying, character varying, integer, character varying, integer, integer, integer, character varying)

-- DROP FUNCTION etls.registro_plantel(bigint, character varying, integer,character varying, integer, integer, integer, integer, integer, integer, text, integer, integer, integer, integer, integer, character varying(100), character varying, character varying, integer, integer, integer, integer, integer, integer, integer, integer, integer, boolean, boolean, character varying, text, boolean, integer, integer, timestamp , integer, timestamp, timestamp, character varying, integer, double precision, double precision, integer, integer, integer, integer, character varying, character varying, integer, character varying, integer, integer, integer, character varying)

CREATE OR REPLACE FUNCTION etls.registro_plantel(
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
    fecha_ini_vi timestamp ,
    usuario_act_id_vi integer,
    fecha_act_vi timestamp ,
    fecha_elim_vi timestamp,
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
    via_vi character varying)
  RETURNS text AS
$BODY$
DECLARE
    
    plantel_id_v bigint :=0;
    cant_existe_plantel_v INTEGER := 0; -- Indicara la Cantidad de Veces que un dato es encontrado en la tabla (Por regla debe aparecer mÃ¡ximo una vez) Si ya existe el dato no se debe registrar de nuevo.
    cant_existe_user_v INTEGER := 0;    
    resultado_log_v CHARACTER VARYING(10);
    resultado_vo CHARACTER VARYING(10);
    fecha_v TIMESTAMP WITHOUT TIME ZONE;
    mensaje_v TEXT; -- Mensaje que sera mostrado al usuario para indicarle el resultado_vo de la transaccion
    seccion_v INTEGER := 0;
    operacion_v CHARACTER VARYING(10);
    estado_id_v INTEGER:=0;
    municipio_id_v INTEGER:=0;
    parroquia_id_v INTEGER:=0;

BEGIN

    -- @author Nelson Gonzalez
    -- @date 2015-02-19 02:43

    RAISE NOTICE 'DATO: % %', nombre_vi, estado_id_vi;

    RAISE NOTICE 'INICIO';

    fecha_v := (now())::timestamp(0);
    fecha_ini_vi:=fecha_v;
    fecha_act_vi:=fecha_v;
    seccion_v := 1;

    SELECT COUNT(id) INTO cant_existe_plantel_v FROM gplantel.plantel WHERE nombre = nombre_vi;

    RAISE NOTICE 'DATO: %', nombre_vi;   
    IF nombre_vi IS NOT NULL AND cod_plantel_vi IS NOT NULL AND estado_id_vi IS NOT NULL THEN
        IF cant_existe_plantel_v = 0 THEN
            seccion_v := 2;
            
            INSERT INTO gplantel.plantel(
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
                usuario_act_id, 
                fecha_act, 
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
                via
            )
            VALUES ( 
                cod_estadistico_vi, 
                cod_plantel_vi, 
                null, 
                nombre_vi, 
                denominacion_id_vi, 
                tipo_dependencia_id_vi, 
                estado_id_vi, 
                municipio_id_vi, 
                parroquia_id_vi, 
                null,
                direccion_vi, 
                null, 
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
                usuario_act_id_vi, 
                fecha_act_vi, 
                fecha_elim_vi, 
                'I'::character varying, 
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
                via_vi
            ) RETURNING id INTO plantel_id_v;

            RAISE NOTICE 'EL PLANTEL %  SE HA REGISTRADO DE FORMA EXITOSA', nombre_vi;

            mensaje_v := 'EL PLANTEL '||nombre_vi||' SE HA REGISTRADO DE FORMA EXITOSA';

            resultado_vo := 'REGISTRO';

            -- INSERCION PARA LOS LOGS

            seccion_v := 3;

            operacion_v := 'REGISTRAR';




            resultado_log_v := auditoria_etls.log_plantel(
                cod_estadistico_vi, 
                cod_plantel_vi, 
                null, 
                nombre_vi, 
                denominacion_id_vi, 
                tipo_dependencia_id_vi, 
                estado_id_vi, 
                municipio_id_vi, 
                parroquia_id_vi, 
                null,
                direccion_vi, 
                null,  
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
                mensaje_v,
                fecha_v,
                operacion_v,
                resultado_vo
            );
        ELSE
            SELECT estado_id INTO estado_id_v 
                FROM gplantel.plantel WHERE nombre = nombre_vi;
            SELECT municipio_id INTO municipio_id_v 
                FROM gplantel.plantel WHERE nombre = nombre_vi;
            SELECT  parroquia_id INTO parroquia_id_v 
                FROM gplantel.plantel WHERE nombre = nombre_vi;
            seccion_v := 4;
                IF estado_id_vi IS NOT NULL AND estado_id_vi<>estado_id_v THEN
                    UPDATE gplantel.plantel SET
                    estado_id=estado_id_vi
                    WHERE nombre=nombre_vi;
                    RAISE NOTICE 'EL ESTADO ID DEL PLANTEL %  SE HA ACTUALIZADO DE FORMA EXITOSA', nombre_vi;

                    mensaje_v := 'EL ESTADO ID DEL PLANTEL '||nombre_vi||' SE HA ACTUALIZADO DE FORMA EXITOSA';

                    resultado_vo := 'ACTUALIZO';

                    -- INSERCION PARA LOS LOGS
                    operacion_v := 'ACTUALIZAR';
                    resultado_log_v := auditoria_etls.log_plantel(cod_estadistico_vi, cod_plantel_vi, null, nombre_vi, denominacion_id_vi, tipo_dependencia_id_vi, estado_id_vi, municipio_id_vi, parroquia_id_vi, null,direccion_vi, null,  zona_educativa_id_vi, modalidad_id_vi, nivel_id_vi,condicion_estudio_id_vi, correo_vi, telefono_fijo_vi, telefono_otro_vi, director_actual_id_vi,director_supl_actual_id_vi, subdirector_actual_id_vi, subdirector_supl_actual_id_vi,coordinador_actual_id_vi, coordinador_supl_actual_id_vi, clase_plantel_id_vi,condicion_infra_id_vi, categoria_id_vi, posee_electricidad_vi, posee_edificacion_vi,logo_vi, observacion_vi, es_tecnica_vi, especialidad_tec_id_vi, usuario_ini_id_vi,fecha_ini_vi,fecha_elim_vi,estatus_vi,estatus_plantel_id_vi,latitud_vi,longitud_vi,annio_fundado_vi,turno_id_vi,genero_id_vi,zona_ubicacion_id_vi,nfax_vi,codigo_ner_vi,cod_unico_vi,cod_plantel_anterior_vi,poblacion_id_vi,urbanizacion_id_vi, tipo_via_id_vi,via_vi,mensaje_v,fecha_v,operacion_v,resultado_vo);
                END IF;
            seccion_v := 5;
                IF municipio_id_vi IS NOT NULL AND municipio_id_vi<>municipio_id_v THEN
                    UPDATE gplantel.plantel SET
                    municipio_id=municipio_id_vi
                    WHERE nombre=nombre_vi;
                    RAISE NOTICE 'EL MUNICIPIO ID DEL PLANTEL %  SE HA ACTUALIZADO DE FORMA EXITOSA', nombre_vi;

                    mensaje_v := 'EL MUNICIPIO ID DEL PLANTEL '||nombre_vi||' SE HA ACTUALIZADO DE FORMA EXITOSA';

                    resultado_vo := 'ACTUALIZO';

                    -- INSERCION PARA LOS LOGS
                    operacion_v := 'ACTUALIZAR';
                    resultado_log_v := auditoria_etls.log_plantel(cod_estadistico_vi, cod_plantel_vi, null, nombre_vi, denominacion_id_vi, tipo_dependencia_id_vi, estado_id_vi, municipio_id_vi, parroquia_id_vi, null,direccion_vi, null,  zona_educativa_id_vi, modalidad_id_vi, nivel_id_vi,condicion_estudio_id_vi, correo_vi, telefono_fijo_vi, telefono_otro_vi, director_actual_id_vi,director_supl_actual_id_vi, subdirector_actual_id_vi, subdirector_supl_actual_id_vi,coordinador_actual_id_vi, coordinador_supl_actual_id_vi, clase_plantel_id_vi,condicion_infra_id_vi, categoria_id_vi, posee_electricidad_vi, posee_edificacion_vi,logo_vi, observacion_vi, es_tecnica_vi, especialidad_tec_id_vi, usuario_ini_id_vi,fecha_ini_vi,fecha_elim_vi,estatus_vi,estatus_plantel_id_vi,latitud_vi,longitud_vi,annio_fundado_vi,turno_id_vi,genero_id_vi,zona_ubicacion_id_vi,nfax_vi,codigo_ner_vi,cod_unico_vi,cod_plantel_anterior_vi,poblacion_id_vi,urbanizacion_id_vi, tipo_via_id_vi,via_vi,mensaje_v,fecha_v,operacion_v,resultado_vo);
            END IF;

            seccion_v := 6;

                IF parroquia_id_vi IS NOT NULL AND parroquia_id_vi<>parroquia_id_v THEN
                    UPDATE gplantel.plantel SET
                    parroquia_id=parroquia_id_vi
                    WHERE nombre=nombre_vi;
            RAISE NOTICE 'EL PARROQUIA ID DEL PLANTEL %  SE HA ACTUALIZADO DE FORMA EXITOSA', nombre_vi;

            mensaje_v := 'EL PARROQUIA ID DEL PLANTEL '||nombre_vi||' SE HA ACTUALIZADO DE FORMA EXITOSA';

            resultado_vo := 'EXITOSO';

            -- INSERCION PARA LOS LOGS
            operacion_v := 'REGISTRAR';
            resultado_log_v := auditoria_etls.log_plantel(cod_estadistico_vi, cod_plantel_vi, null, nombre_vi, denominacion_id_vi, tipo_dependencia_id_vi, estado_id_vi, municipio_id_vi, parroquia_id_vi, null,direccion_vi, null,  zona_educativa_id_vi, modalidad_id_vi, nivel_id_vi,condicion_estudio_id_vi, correo_vi, telefono_fijo_vi, telefono_otro_vi, director_actual_id_vi,director_supl_actual_id_vi, subdirector_actual_id_vi, subdirector_supl_actual_id_vi,coordinador_actual_id_vi, coordinador_supl_actual_id_vi, clase_plantel_id_vi,condicion_infra_id_vi, categoria_id_vi, posee_electricidad_vi, posee_edificacion_vi,logo_vi, observacion_vi, es_tecnica_vi, especialidad_tec_id_vi, usuario_ini_id_vi,fecha_ini_vi,fecha_elim_vi,estatus_vi,estatus_plantel_id_vi,latitud_vi,longitud_vi,annio_fundado_vi,turno_id_vi,genero_id_vi,zona_ubicacion_id_vi,nfax_vi,codigo_ner_vi,cod_unico_vi,cod_plantel_anterior_vi,poblacion_id_vi,urbanizacion_id_vi, tipo_via_id_vi,via_vi,mensaje_v,fecha_v,operacion_v,resultado_vo);
            END IF;
        END IF;

        RAISE NOTICE 'DATO: %', nombre_vi;

    ELSE

        RAISE NOTICE 'DATOS FALTANTES. EL DATO DEL REGISTRO Y EL ID DEL REGISTRO PROGRAMADO NO PUEDEN TENER VALORES NULOS';

        mensaje_v := 'DATOS FALTANTES. EL DATO DEL REGISTRO Y EL ID DEL REGISTRO PROGRAMADO NO PUEDEN TENER VALORES NULOS';

        resultado_vo := 'ERROR';
        operacion_v := 'SIN CAMBIO';
        resultado_log_v := auditoria_etls.log_plantel(cod_estadistico_vi, cod_plantel_vi, null, nombre_vi, denominacion_id_vi, tipo_dependencia_id_vi, estado_id_vi, municipio_id_vi, parroquia_id_vi, null,direccion_vi, null,  zona_educativa_id_vi, modalidad_id_vi, nivel_id_vi,condicion_estudio_id_vi, correo_vi, telefono_fijo_vi, telefono_otro_vi, director_actual_id_vi,director_supl_actual_id_vi, subdirector_actual_id_vi, subdirector_supl_actual_id_vi,coordinador_actual_id_vi, coordinador_supl_actual_id_vi, clase_plantel_id_vi,condicion_infra_id_vi, categoria_id_vi, posee_electricidad_vi, posee_edificacion_vi,logo_vi, observacion_vi, es_tecnica_vi, especialidad_tec_id_vi, usuario_ini_id_vi,fecha_ini_vi,fecha_elim_vi,estatus_vi,estatus_plantel_id_vi,latitud_vi,longitud_vi,annio_fundado_vi,turno_id_vi,genero_id_vi,zona_ubicacion_id_vi,nfax_vi,codigo_ner_vi,cod_unico_vi,cod_plantel_anterior_vi,poblacion_id_vi,urbanizacion_id_vi, tipo_via_id_vi,via_vi,mensaje_v,fecha_v,operacion_v,resultado_vo);

    END IF;

    RAISE NOTICE 'FIN';

    RETURN resultado_vo;

EXCEPTION WHEN OTHERS THEN
    mensaje_v := 'Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (Seccion: '||seccion_v||')';
    resultado_vo := 'ERROR';
    RAISE NOTICE 'Ha ocurrido un error % (ERROR NRO: %) (Seccion: %)', SQLERRM, SQLSTATE, seccion_v;
    -- ERROR LOG
    seccion_v := 8;
    operacion_v := 'SIN CAMBIO';
    resultado_log_v := auditoria_etls.log_plantel(cod_estadistico_vi, cod_plantel_vi, null, nombre_vi, denominacion_id_vi, tipo_dependencia_id_vi, estado_id_vi, municipio_id_vi, parroquia_id_vi, null,direccion_vi, null,  zona_educativa_id_vi, modalidad_id_vi, nivel_id_vi,condicion_estudio_id_vi, correo_vi, telefono_fijo_vi, telefono_otro_vi, director_actual_id_vi,director_supl_actual_id_vi, subdirector_actual_id_vi, subdirector_supl_actual_id_vi,coordinador_actual_id_vi, coordinador_supl_actual_id_vi, clase_plantel_id_vi,condicion_infra_id_vi, categoria_id_vi, posee_electricidad_vi, posee_edificacion_vi,logo_vi, observacion_vi, es_tecnica_vi, especialidad_tec_id_vi, usuario_ini_id_vi,fecha_ini_vi,fecha_elim_vi,estatus_vi,estatus_plantel_id_vi,latitud_vi,longitud_vi,annio_fundado_vi,turno_id_vi,genero_id_vi,zona_ubicacion_id_vi,nfax_vi,codigo_ner_vi,cod_unico_vi,cod_plantel_anterior_vi,poblacion_id_vi,urbanizacion_id_vi, tipo_via_id_vi,via_vi,mensaje_v,fecha_v,operacion_v,resultado_vo);

RETURN resultado_vo;
  
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION etls.registro_plantel(
    bigint,
    character varying,
    integer,
    character varying,
    integer,
    integer,
    integer,
    integer,
    integer,
    integer,
    text,
    integer,
    integer,
    integer,
    integer,
    integer,
    character varying,
    character varying,
    character varying,
    integer,
    integer,
    integer,
    integer,
    integer,
    integer,
    integer,
    integer,
    integer,
    boolean,
    boolean,
    character varying,
    text,
    boolean,
    integer,
    integer,
    timestamp ,
    integer,
    timestamp ,
    timestamp,
    character varying,
    integer,
    double precision,
    double precision,
    integer,
    integer,
    integer,
    integer,
    character varying,
    character varying,
    integer,
    character varying,
    integer,
    integer,
    integer,
    character varying
)
OWNER TO postgres;
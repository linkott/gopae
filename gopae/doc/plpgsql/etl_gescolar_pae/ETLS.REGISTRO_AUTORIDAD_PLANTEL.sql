-- Function: etls.registro_autoridad_plantel(integer,integer,integer,integer,timestamp,character varying)

-- DROP FUNCTION etls.registro_autoridad_plantel(integer,integer,integer,integer,timestamp,character varying)

CREATE OR REPLACE FUNCTION etls.registro_autoridad_plantel(
    plantel_id_vi integer,
    usuario_id_vi integer,
    cargo_id_vi integer,
    usuario_ini_id_vi integer,
    fecha_ini_vi timestamp,
    estatus_vi character varying)
  RETURNS text AS
$BODY$
DECLARE
    
    autoridad_plantel_id_v bigint :=0;
    cant_existe_autoridad_plantel_v INTEGER := 0; -- Indicara la Cantidad de Veces que un dato es encontrado en la tabla (Por regla debe aparecer mÃ¡ximo una vez) Si ya existe el dato no se debe registrar de nuevo.
    cant_existe_user_v INTEGER := 0;    
    resultado_log_v CHARACTER VARYING(10);
    resultado_vo CHARACTER VARYING(10);
    fecha_v TIMESTAMP WITHOUT TIME ZONE;
    mensaje_v TEXT; -- Mensaje que sera mostrado al usuario para indicarle el resultado_vo de la transaccion
    seccion_v INTEGER := 0;
    operacion_v CHARACTER VARYING(10);
    estatus_v character varying(1);
    cargo_id_v INTEGER:=0;

BEGIN

    -- @author Nelson Gonzalez
    -- @date 2015-02-24 02:37

    RAISE NOTICE 'DATO: % - % - %', plantel_id_vi, usuario_id_vi,cargo_id_vi;

    RAISE NOTICE 'INICIO';

    fecha_v := (now())::timestamp(0);
    fecha_ini_vi:=fecha_v;
    seccion_v := 1;

    SELECT COUNT(id) INTO cant_existe_autoridad_plantel_v FROM gplantel.autoridad_plantel WHERE plantel_id=plantel_id_vi AND usuario_id=usuario_id_vi AND cargo_id=cargo_id_vi;

    RAISE NOTICE 'DATO: % - % - %', plantel_id_vi, usuario_id_vi,cargo_id_vi;   
    IF plantel_id_vi IS NOT NULL AND usuario_id_vi IS NOT NULL THEN
        IF cant_existe_autoridad_plantel_v = 0 THEN
            seccion_v := 2;
            
            INSERT INTO gplantel.autoridad_plantel( 
                plantel_id, 
                usuario_id, 
                cargo_id, 
                usuario_ini_id, 
                fecha_ini,
                estatus
            )
            VALUES ( 
                plantel_id_vi::integer, 
                usuario_id_vi::integer, 
                cargo_id_vi::integer,  
                usuario_ini_id_vi::integer, 
                fecha_ini_vi::timestamp,
                estatus_vi::character varying 
            ) RETURNING id INTO autoridad_plantel_id_v;

            RAISE NOTICE 'LA AUTORIDAD PLANTEL %  SE HA REGISTRADO DE FORMA EXITOSA', autoridad_plantel_id_v;

            mensaje_v := 'LA AUTORIDAD PLANTEL '||autoridad_plantel_id_v||' SE HA REGISTRADO DE FORMA EXITOSA';

            resultado_vo := 'REGISTRO';

            -- INSERCION PARA LOS LOGS

            seccion_v := 3;

            operacion_v := 'REGISTRAR';


        ELSE 

            seccion_v := 4;
            SELECT estatus INTO estatus_v
                FROM gplantel.autoridad_plantel WHERE plantel_id = plantel_id_vi AND usuario_id=usuario_id_vi;
            seccion_v := 5;
            SELECT cargo_id INTO cargo_id_v
                FROM gplantel.autoridad_plantel WHERE plantel_id = plantel_id_vi AND usuario_id=usuario_id_vi;

            seccion_v := 6;
                IF estatus_vi IS NOT NULL AND estatus_vi<>estatus_v THEN
                    UPDATE gplantel.autoridad_plantel SET
                    estatus=estatus_vi
                    WHERE plantel_id = plantel_id_vi AND usuario_id=usuario_id_vi;
                    RAISE NOTICE 'EL ESTATUS DE LA AUTORIDAD PLANTEL %  SE HA ACTUALIZADO DE FORMA EXITOSA', autoridad_plantel_id_v;

                    mensaje_v := 'EL ESTATUS DE LA AUTORIDAD PLANTEL '||autoridad_plantel_id_v||' SE HA ACTUALIZADO DE FORMA EXITOSA';

                    resultado_vo := 'ACTUALIZO';

                    -- INSERCION PARA LOS LOGS
                    operacion_v := 'ACTUALIZAR';

                END IF;
            
        END IF;

        RAISE NOTICE 'DATO: %', autoridad_plantel_id_v;

    ELSE

        RAISE NOTICE 'DATOS FALTANTES. EL DATO DEL REGISTRO Y EL ID DEL REGISTRO PROGRAMADO NO PUEDEN TENER VALORES NULOS';

        mensaje_v := 'DATOS FALTANTES. EL DATO DEL REGISTRO Y EL ID DEL REGISTRO PROGRAMADO NO PUEDEN TENER VALORES NULOS';

        resultado_vo := 'ERROR';
        operacion_v := 'SIN CAMBIO';

    END IF;

    RAISE NOTICE 'FIN';

    RETURN resultado_vo;

    resultado_log_v := auditoria_etls.log_autoridad_plantel(
        plantel_id_vi, 
        usuario_id_vi, 
        cargo_id_vi,  
        usuario_ini_id_vi, 
        fecha_ini_vi,
        estatus_vi, 
        resultado_vo, 
        mensaje_v, 
        fecha_v, 
        operacion_v
    );

EXCEPTION WHEN OTHERS THEN
    mensaje_v := 'Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (Seccion: '||seccion_v||')';
    resultado_vo := 'ERROR';
    RAISE NOTICE 'Ha ocurrido un error % (ERROR NRO: %) (Seccion: %)', SQLERRM, SQLSTATE, seccion_v;
 -- ERROR LOG
    seccion_v := 8;
    operacion_v := 'SIN CAMBIO';
    resultado_log_v := auditoria_etls.log_autoridad_plantel(
        plantel_id_vi, 
        usuario_id_vi, 
        cargo_id_vi,  
        usuario_ini_id_vi, 
        fecha_ini_vi,
        estatus_vi, 
        resultado_vo, 
        mensaje_v, 
        fecha_v, 
        operacion_v
    );

    RETURN resultado_vo;
  
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION etls.registro_autoridad_plantel(
    integer,
    integer,
    integer,
    integer,
    timestamp,
    character varying
)OWNER TO postgres;
-- Function: gplantel.validate_madre_colaboradora(character varying, integer, integer, character varying, integer, character varying, character varying)

-- DROP FUNCTION gplantel.validate_madre_colaboradora(character varying, integer, integer, character varying, integer, character varying, character varying);

CREATE OR REPLACE FUNCTION gplantel.asignar_madre_cocinera(colaborador_id_vi integer, plantel_id_vi integer, modulo_vi character varying, usuario_vi integer, username_vi character varying, ipaddress_vi character varying)
  RETURNS text[] AS
$BODY$
DECLARE
    
    -- Periodo Escolar
    cant_periodo_v INTEGER := 0; -- Cantidad de periodos activos.
    periodo_id_v INTEGER; -- Contendrá el Id del periodo actual
    
    -- Datos de SAIME
    cant_saime_v INTEGER := 0;
    
    -- Datos del Plantel
    cant_plantel_v INTEGER := 0;
    codigo_plantel_v CHARACTER VARYING(15);
    nombre_plantel_v CHARACTER VARYING(150);
    pae_activo_v CHARACTER VARYING(2); -- SI o NO.
    matricula_total INTEGER := 0;
    plantel_id_v INTEGER;

    -- Madres Colaboradoras
    cant_madre_asignada_v INTEGER := 0; -- Indica si la Madre ya ha sido asignada a otro plantel o al plantel indicado (según sea el caso) en el periodo actual.
    cant_madre_colaboradora_v INTEGER := 0; -- Indica si la Madre colaboradora se encuentra registrada como tal en la tabla de colaborador(es).
    cant_madres_asignadas_v INTEGER := 0; -- Indica la cantidad de madres asignadas a un plantel en el periodo actual.
    cant_madres_necesarias_v INTEGER := 0;
    estatus_madre_asignada_v CHARACTER VARYING(1);
    
    -- Auditoria
    fecha_v TIMESTAMP WITHOUT TIME ZONE; -- Fecha Actual.
    
    -- Resultado
    codigo_v CHARACTER VARYING(15); -- Código del Resultado de la transaccion. S0000...
    transaccion_v CHARACTER VARYING(15); -- Resultado de la transaccion en una palabra o expresion clave. EXITO, ALERTA, ERROR
    mensaje_v CHARACTER VARYING(300); -- Mensaje que podría ser mostrado al usuario para indicarle el resultado de la transaccion.
    resultado TEXT[3]; -- Sera el Resultado que devolvera la funcion.

    -- Debug
    seccion SMALLINT := 1;

BEGIN
    
    -- $ColaboradorPlantel = new ColaboradorPlantel();
    -- $ColaboradorPlantel->colaborador_id = $colaboradora['id'];
    -- $ColaboradorPlantel->periodo_id = $periodoActual['id'];
    -- $ColaboradorPlantel->plantel_id = $idDecoded;
    -- $ColaboradorPlantel->beforeSave();

    -- ESTA FUNCION PERMITE REALIZAR LA ASIGNACION A UN PLANTEL DE UNA MADRE O PADRE COLABORADOR POR SU NÚMERO DE CEDULA, EL CUAL INDICA SI UNA MADRE PUEDE O NO SER ASIGNADA A UN PLANTEL.
    -- @author José Gabriel González
    -- @date 2014-09-12 16:20
    
    -- TABLA DE RESPUESTA QUE PODRÁ DAR LA FUNCION PL/PGSQL
    -- ------------------------------------------------------------------------------------------------------------------
    --  CODIGO | RESULTADO | MENSAJE
    -- ------------------------------------------------------------------------------------------------------------------
    --  S0000  | EXITO     | X Madre Colaboradora Asignada al Plantel.
    --  S0001  | EXITO     | X Madre Colaboradora Re-Asignada al Plantel.
    --  E0002  | ERROR     | X Colaboradora no registrada en base de datos
    --  E0003  | ERROR     | X La Madre Colaboradora se encuentra asignado a otro plantel en el periodo actual.
    -- ------------------------------------------------------------------------------------------------------------------

    RAISE NOTICE 'COLAB_ID: %-%. PLANTEL-ID: %', colaborador_id_vi, plantel_id_vi;

    RAISE NOTICE 'INICIO: Proceso de Asignación de Madre y Padre Colaborador';

    fecha_v := (now())::timestamp(0);

    seccion := 2;

    SELECT COUNT(1) INTO cant_madre_colaboradora_v FROM gplantel.colaborador cp WHERE cp.id = colaborador_id_vi;
    
    SELECT id INTO periodo_id_v FROM gplantel.periodo_escolar p WHERE p.estatus = 'A' LIMIT 1;

    IF cant_madre_colaboradora_v>0 THEN -- EXISTE EL COLABORADORA
        
        seccion := 5;
        
        SELECT COUNT(1) INTO cant_madre_asignada_v FROM gplantel.colaborador_plantel cp WHERE cp.plantel_id != plantel_id_vi AND cp.periodo_id = periodo_id_v AND cp.colaborador_id = colaborador_id_vi AND cp.estatus = 'A' LIMIT 1;

        IF cant_madre_asignada_v=0 THEN -- COLABORADOR NO ESTA ASIGNADA A OTRO PLANTEL EN EL PERIODO ACTUAL

            SELECT COUNT(1) INTO cant_madre_asignada_v FROM gplantel.colaborador_plantel cp WHERE cp.plantel_id = plantel_id_vi AND cp.periodo_id = periodo_id_v AND cp.colaborador_id = colaborador_id_vi LIMIT 1;

            IF cant_madre_asignada_v=0 THEN -- COLABORADORA NO ASIGNADA A ESTE PLANTEL ANTERIORMENTE

                seccion := 6;

                INSERT INTO gplantel.colaborador_plantel(colaborador_id, plantel_id, periodo_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, estatus) VALUES (colaborador_id_vi, plantel_id_vi, periodo_id_v, usuario_vi, fecha_v, usuario_vi, fecha_v, 'A');

                codigo_v := 'S0000';
                transaccion_v := 'EXITOSO';
                mensaje_v := 'La Madre Colaboradora fue asignada al plantel de forma exitosa.';
                resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

            ELSE -- COLABORADORA ASIGNADA A ESTE PLANTEL ANTERIORMENTE

                seccion := 7;

                SELECT cp.estatus INTO estatus_madre_asignada_v FROM gplantel.colaborador_plantel cp WHERE cp.plantel_id = plantel_id_vi AND cp.periodo_id = periodo_id_v AND cp.colaborador_id = colaborador_id_vi LIMIT 1;

                IF estatus_madre_asignada_v!='A' THEN

                    UPDATE gplantel.colaborador_plantel SET estatus = 'A', usuario_act_id = usuario_vi, fecha_act = fecha_v WHERE cp.plantel_id = plantel_id_vi AND cp.periodo_id = periodo_id_v AND cp.colaborador_id = colaborador_id_vi;

                END IF;

                codigo_v := 'S0001';
                transaccion_v := 'EXITOSO';
                mensaje_v := 'La Madre Colaboradora fue re-asignada al plantel de forma exitosa.';
                resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

            END IF;

        ELSE -- COLABORADORA ASIGNADA A OTRO PLANTEL ANTERIORMENTE
            
            seccion := 4;

            SELECT p.cod_plantel INTO codigo_plantel_v FROM gplantel.plantel INNER JOIN gplantel.colaborador_plantel cp ON p.id = cp.plantel_id WHERE cp.plantel_id != plantel_id_vi AND cp.periodo_id = periodo_id_v AND cp.colaborador_id = colaborador_id_vi AND cp.estatus = 'A' LIMIT 1;

            codigo_v := 'E0003';
            transaccion_v := 'ERROR';
            mensaje_v := 'La colaboradora ya se encuentra asignada a otro plantel ('||codigo_plantel_v||') en el periodo actual, debe ser desvinculada de este para poder ser asignada a otro.';
            resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

        END IF;

    ELSE
        
        seccion := 3;
        codigo_v := 'E0002';
        transaccion_v := 'ERROR';
        mensaje_v := 'La colaboradora indicada no se encuentra registrada en la base de datos.';
        resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

    END IF;

    INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id, username) VALUES (fecha_v, ipaddress_vi, 'ESCRITURA', modulo_vi, transaccion_v, 'ASIGNACION DE MADRE COLABORADORA ID ('||colaborador_id_vi||') AL PLANTEL ID ('||plantel_id_vi||') EN EL PERIODO ID ('||periodo_id_v||'): '||mensaje_v, usuario_vi, username_vi);

    RAISE NOTICE 'FIN: Proceso de Asignación de Madres Colaboradoras';

    RETURN resultado;

EXCEPTION

    WHEN OTHERS THEN
        codigo_v := SQLSTATE||'';
        transaccion_v := 'ERROR';
        mensaje_v := 'Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (SECCION: '||seccion||')';
        resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];
        INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id, username) VALUES (fecha_v, ipaddress_vi, 'ESCRITURA', modulo_vi, 'ERROR', 'ASIGNACION DE MADRE COLABORADORA: '||mensaje_v, usuario_vi, username_vi);
        RAISE NOTICE 'Ha ocurrido un error % (ERROR NRO: %) (SECCION: %)', SQLERRM, SQLSTATE, seccion;
    RETURN resultado;

END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION gplantel.asignar_madre_colaboradora(integer, integer, character varying, integer, character varying, character varying)
  OWNER TO postgres;

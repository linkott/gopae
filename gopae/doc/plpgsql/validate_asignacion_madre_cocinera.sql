-- Function: gplantel.validate_madre_cocinera(character varying, integer, integer, character varying, integer, character varying, character varying)

-- DROP FUNCTION gplantel.validate_madre_cocinera(character varying, integer, integer, character varying, integer, character varying, character varying);

CREATE OR REPLACE FUNCTION gplantel.validate_asignacion_madre_cocinera(
    origen_vi character varying,
    cedula_vi integer,
    plantel_id_vi integer,
    modulo_vi character varying,
    usuario_vi integer,
    username_vi character varying,
    ipaddress_vi character varying)
  RETURNS record AS
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

    -- Madres Cocineras
    cant_madre_asignada_v INTEGER := 0; -- Indica si la Madre ya ha sido asignada a otro plantel o al plantel indicado (según sea el caso) en el periodo actual.
    cant_madre_cocinera_v INTEGER := 0; -- Indica si la Madre cocinera se encuentra registrada como tal en la tabla de colaborador(es).
    cant_madres_asignadas_v INTEGER := 0; -- Indica la cantidad de madres asignadas a un plantel en el periodo actual.
    cant_madres_necesarias_v INTEGER := 0;
  
    obrero_id_v INTEGER := 11;
    estatus_empleado_v CHARACTER VARYING(1) := 'E';

    -- Auditoria
    fecha_v TIMESTAMP WITHOUT TIME ZONE; -- Fecha Actual.

    -- Resultado
    codigo_v CHARACTER VARYING(15); -- Código del Resultado de la transaccion. S0000...
    transaccion_v CHARACTER VARYING(15); -- Resultado de la transaccion en una palabra o expresion clave. EXITO, ALERTA, ERROR
    mensaje_v CHARACTER VARYING(300); -- Mensaje que podría ser mostrado al usuario para indicarle el resultado de la transaccion.
    resultado RECORD; -- Sera el Resultado que devolvera la funcion.

    -- Debug
    seccion SMALLINT := 1;

BEGIN

    -- ESTA FUNCION PERMITE REALIZAR LA VALIDACIÓN GENERAL DE UNA MADRE O PADRE COCINERO POR SU NÚMERO DE CEDULA, EL CUAL INDICA SI UNA MADRE PUEDE O NO SER ASIGNADA A UN PLANTEL.
    -- @author José Gabriel González
    -- @date 2014-08-15 05:36

    -- TABLA DE RESPUESTA QUE PODRÁ DAR LA FUNCION PL/PGSQL
    -- ------------------------------------------------------------------------------------------------------------------
    --  CODIGO | RESULTADO | MENSAJE
    -- ------------------------------------------------------------------------------------------------------------------
    --  S0000  | EXITO     | X Cumple con los requisitos básicos necesarios para ser asignada a un plantel como Madre Cocinera.
    --  W0001  | ALERTA    | X La Madre Cocinera ya se encuentra asignado a este plantel en el periodo actual.
    --  E0002  | ERROR     | X Cédula de Identidad no registrada como Madre Cocinera.
    --  E0003  | ERROR     | X El Plantel no es beneficiario CNAE.
    --  E0004  | ERROR     | X CNAE Inactivo en el Plantel.
    --  E0005  | ERROR     | X Cédula de Identidad no existente en la base de datos SAIME.
    --  E0006  | ERROR     | X La Madre Cocinera se encuentra asignado a otro plantel en el periodo actual.
    --  E0007  | ERROR     | X Sobrepasa la cantidad de Madres Cocineras Necesarias para la matricula del Plantel.
    --  E0008  | ERROR     | X No existe un periodo escolar activo en el sistema.
    -- ------------------------------------------------------------------------------------------------------------------

    RAISE NOTICE 'CEDULA: %-%. PLANTEL-ID: %', origen_vi, cedula_vi, plantel_id_vi;

    RAISE NOTICE 'INICIO: Proceso de Validación de Madre y Padre Cocinera';

    fecha_v := (now())::timestamp(0);

    seccion := 2;

    SELECT COUNT(1) INTO cant_plantel_v FROM gplantel.plantel_pae pp WHERE plantel_id = plantel_id_vi;

    IF cant_plantel_v>0 THEN -- PLANTEL BENEFICIARIO DEL CNAE

        seccion := 4;

        SELECT p.cod_plantel, p.nombre, pp.pae_activo INTO codigo_plantel_v, nombre_plantel_v, pae_activo_v FROM gplantel.plantel_pae pp INNER JOIN gplantel.plantel p ON pp.plantel_id = p.id WHERE plantel_id = plantel_id_vi LIMIT 1;

        IF UPPER(pae_activo_v)='SI' THEN -- PLANTEL CON EL CNAE ACTIVO

            seccion := 5;

            SELECT COUNT(1) INTO cant_saime_v FROM auditoria.saime s WHERE s.origen = origen_vi AND s.cedula = cedula_vi;

            IF cant_saime_v = 0 THEN -- EXISTE LA CEDULA DE IDENTIDAD EN SAIME
                codigo_v := 'E0005';
                transaccion_v := 'ERROR';
                mensaje_v := 'La Cédula de Identidad '||origen_vi||'-'||cedula_vi::TEXT||' no está validada con el SAIME.';
                -- resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];
            END IF;

            seccion := 6;

            SELECT COUNT(1) INTO cant_madre_cocinera_v FROM gestion_humana.talento_humano c WHERE c.origen = origen_vi AND c.cedula = cedula_vi AND c.estatus = estatus_empleado_v AND c.tipo_cargo_actual_id = obrero_id_v;

            IF cant_madre_cocinera_v>0 THEN -- LA CEDULA ESTA REGISTRADA COMO MADRE COCINEROA

                seccion := 7;

                SELECT COUNT(1) INTO cant_periodo_v FROM gplantel.periodo_escolar p WHERE p.estatus = 'A';

                IF cant_periodo_v>0 THEN -- EXISTE PERIODO ACTIVO EN EL SISTEMA

                    seccion := 8;

                    seccion := 9;

                    SELECT COUNT(1) INTO cant_madre_asignada_v FROM gestion_humana.talento_humano c INNER JOIN gplantel.cocinera_plantel cp ON c.id = cp.talento_humano_id WHERE c.origen = origen_vi AND c.cedula = cedula_vi AND cp.estatus = 'A' AND c.estatus = estatus_empleado_v AND c.tipo_cargo_actual_id = obrero_id_v;

                    IF cant_madre_asignada_v=0 THEN -- ESTA MADRE O PADRE COCINERO NO ESTÁ ASIGNADO EN ESTE PERIODO A NINGÚN PLANTEL

                        seccion := 10;

                        SELECT COUNT(1) INTO cant_madres_asignadas_v FROM gplantel.cocinera_plantel cp WHERE cp.plantel_id = plantel_id_vi AND cp.estatus = 'A';

                        seccion := 11;

                        cant_madres_necesarias_v = gplantel.get_cantidad_madres_cocineras_necesarias(plantel_id_vi);

                        IF cant_madres_asignadas_v < cant_madres_necesarias_v THEN -- PLANTEL CON CANTIDAD INCOMPLETA DE MADRES COCINERAS

                            codigo_v := 'S0000';
                            transaccion_v := 'EXITO';
                            mensaje_v := 'La Madre Cocinera puede ser asignada al plantel, si lo desea puede actualizar sus datos y efectuar la asignación.';
                            -- resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

                        ELSE -- PLANTEL CON CANTIDAD COMPLETA DE MADRES COCINERAS

                            codigo_v := 'E0007';
                            transaccion_v := 'ERROR';
                            mensaje_v := 'El Plantel ya posee '||cant_madres_asignadas_v||' Madres Cocineras en Periodo Escolar actual. No puede asignar una nueva madre cocinera a menos que desvincule alguna asignada previamente.';
                            -- resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

                        END IF;

                    ELSE

                        SELECT cp.plantel_id, p.cod_plantel, p.nombre INTO plantel_id_v, codigo_plantel_v, nombre_plantel_v FROM gestion_humana.talento_humano c INNER JOIN gplantel.cocinera_plantel cp ON c.id = cp.talento_humano_id INNER JOIN gplantel.plantel p ON cp.plantel_id = p.id WHERE c.origen = origen_vi AND c.cedula = cedula_vi AND cp.estatus = 'A';

                        IF plantel_id_v = plantel_id_vi THEN -- MADRE ASIGNADA AL MISMO PLANTEL

                            codigo_v := 'W0001';
                            transaccion_v := 'ALERTA';
                            mensaje_v := 'La Madre Cocinera ya se encuentra asignado a este plantel en el periodo actual.';
                            -- resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

                        ELSE -- MADRE ASIGNADA A OTR PLANTEL

                            codigo_v := 'E0006';
                            transaccion_v := 'ERROR';
                            mensaje_v := 'La Madre Cocinera se encuentra asignado al plantel ('||codigo_plantel_v||') '||nombre_plantel_v||' en el periodo actual, debe ser desvinculada de este antes de ser asignada a otro plantel, .';
                            -- resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

                        END IF;

                    END IF;

                ELSE -- NO EXISTE PERIODO ESCOLAR ACTIVO
                    codigo_v := 'E0008';
                    transaccion_v := 'ERROR';
                    mensaje_v := 'No Existe un Periodo Escolar activo en el Sistema. Comuniquese con los administradores del sistema.';
                    -- resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];
                END IF;

            ELSE -- LA PERSONA NO SE ENCUENTRA EN NÓMINA COMO MADRE COCINERA

                codigo_v := 'E0002';
                transaccion_v := 'ALERTA';
                mensaje_v := 'La persona con la Cédula de Identidad '||origen_vi||'-'||cedula_vi::TEXT||' no se encuentra registrada como Madre Cocinera.';
                -- resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

            END IF;

        ELSE -- PLANTEL CON PAE INACTIVO

            codigo_v := 'E0004';
            transaccion_v := 'ERROR';
            mensaje_v := 'El Plantel Indicado tiene el CNAE Inactivo Actualmente. Solicite a la Coordinación Nacional del CNAE que le active en Sistema como beneficiario del programa.';
            -- resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

        END IF;

    ELSE

        seccion := 3;
        codigo_v := 'E0003';
        transaccion_v := 'ERROR';
        mensaje_v := 'El Plantel Indicado no es beneficiario del CNAE. Solicite a la Coordinación Nacional del CNAE que le active en Sistema como beneficiario del programa.';
        -- resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];

    END IF;

    -- INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id, username) VALUES (fecha_v, ipaddress_vi, 'ESCRITURA', modulo_vi, transaccion_v, 'REGISTRO INICIAL DE REGISTRO: '||mensaje_v, usuario_vi, username_vi);

    RAISE NOTICE 'FIN: Proceso de Registro de Dato de Facsimil para Titulo de Graducacion';

    SELECT codigo_v, transaccion_v, mensaje_v INTO resultado;

    RETURN resultado;

EXCEPTION

    WHEN OTHERS THEN
        codigo_v := SQLSTATE||'';
        transaccion_v := 'ERROR';
        mensaje_v := 'Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (SECCION: '||seccion||')';
        -- resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];
        -- INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id, username) VALUES (fecha_v, ipaddress_vi, 'ESCRITURA', modulo_vi, 'ERROR', 'REGISTRO INICIAL DE REGISTRO: '||mensaje_v, usuario_vi, username_vi);
        SELECT codigo_v, transaccion_v, mensaje_v INTO resultado;
        RAISE NOTICE 'Ha ocurrido un error % (ERROR NRO: %) (SECCION: %)', SQLERRM, SQLSTATE, seccion;
    RETURN resultado;

END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- SELECT gplantel.registro_asistencia_madres_colaboradoras(ARRAY['34','31','29'], ARRAY['10','9','10'], 9, 2014, 'planles.madresColaboradoras.registroAsistencia',  1, 'admin', '127.0.0.1') AS result

-- Function: gplantel.registro_asistencia_madres_colaboradoras(integer[], integer[], integer, integer, character varying, integer, character varying, character varying)

-- DROP FUNCTION gplantel.registro_asistencia_madres_colaboradoras(integer[], integer[], integer, integer, character varying, integer, character varying, character varying);

CREATE OR REPLACE FUNCTION gplantel.registro_asistencia_madres_colaboradoras(colaboradoras_plantel_vi integer[], cant_asistencias_vi integer[], mes_vi integer, anio_vi integer, modulo_vi character varying, usuario_vi integer, username_vi character varying, ipaddress_vi character varying)
  RETURNS text[] AS
$BODY$
DECLARE

    cant_colaboradoras_v INTEGER := array_length(colaboradoras_plantel_vi, 1); -- Indica la Cantidad de Seriales que contiene el parÃ¡metro de entrada seriales_vi.
    cant_colaboradora_plantel_exists_v INTEGER := 0; -- Indicará la Cantidad de Veces que un id colaborador_plantel es encontrado en la tabla (Por regla debe aparecer máximo una vez) Si ya existe el colaborador_plantel en el mes del año actual no se debe registrar de nuevo.
    colaboradora_plantel_v INTEGER; -- alojara uno a uno cada colaborador_plantel_id contenido en el parametro de entrada colaboradoras_plantel_vi
    cant_asistenacia_v INTEGER;
    resultado TEXT[2001][6]; -- Sera el Resultado que devolvera la funcion.

    cant_colaborador_exist_v INTEGER;
    colaborador_id_v INTEGER;
    colaborador_origen_v CHARACTER VARYING(2);
    colaborador_cedula_v INTEGER;
    colaborador_nombre_v CHARACTER VARYING(50);
    colaborador_apellido_v CHARACTER VARYING(50);
    colaborador_feacha_nacimiento_v DATE;

    indice INTEGER;
    fecha_v TIMESTAMP WITHOUT TIME ZONE;
    i INTEGER := 1; -- Indice del arreglo resultado
    codigo_result_v CHARACTER VARYING(20);
    result_v CHARACTER VARYING(15); -- Resultado de la transaccion en una palabra o expresion clave
    mensaje_v CHARACTER VARYING(300); -- Mensaje que sera mostrado al usuario para indicarle el resultado de la transaccion
    
    line INTEGER := 25;

BEGIN

    -- ESTA FUNCION PERMITE REALIZAR UN REGISTRO POR LOTES DE ASISTENCIAS DE MADRES COLABORADORAS.
    -- @author José Gabriel González
    -- @creation_date 2014-09-11 14:46
    -- @edition_date 2014-09-11 14:57

    colaboradora_plantel_v := NULL;
    cant_asistenacia_v := 0;
    
    RAISE NOTICE 'INICIO: Proceso de registro de Asistencias de Madres Colaboradoras %', i;
    
    line := 1;

    IF mes_vi BETWEEN 1 AND 12 THEN
        
        line := 2;

        FOR indice IN 1..cant_colaboradoras_v LOOP

            colaboradora_plantel_v:= colaboradoras_plantel_vi[indice];
            cant_asistenacia_v:= cant_asistencias_vi[indice];

            fecha_v := (now())::timestamp(0);

            -- VERIFICO LA EXISTENCIA DEL COLABORADOR_ID Y SI EXISTE ME TRAIGO SUS DATOS
            SELECT COUNT(DISTINCT cp.colaborador_id) INTO cant_colaborador_exist_v FROM gplantel.colaborador c INNER JOIN gplantel.colaborador_plantel cp ON c.id = cp.colaborador_id WHERE cp.id = colaboradora_plantel_v;

            -- SI EXISTE EL COLABORADOR SIGO CON LAS DEMÁS VERIFICACIONES DE LA OPERACIÓN
            IF cant_colaborador_exist_v > 0 THEN
                
                line := 3;

                SELECT cp.colaborador_id INTO colaborador_id_v FROM gplantel.colaborador_plantel cp WHERE cp.id = colaboradora_plantel_v LIMIT 1;
                
                line := 4;

                SELECT c.origen, c.cedula, c.nombre, c.apellido, c.fecha_nacimiento INTO colaborador_origen_v, colaborador_cedula_v, colaborador_nombre_v, colaborador_apellido_v, colaborador_feacha_nacimiento_v FROM gplantel.colaborador c WHERE c.id = colaborador_id_v LIMIT 1;

                SELECT COUNT(1) INTO cant_colaboradora_plantel_exists_v FROM gplantel.colaborador_plantel_asistencia WHERE colaborador_plantel_id = colaboradora_plantel_v AND mes = mes_vi AND anio = anio_vi;

                RAISE NOTICE '%.- CEDULA: % | NOMBRE: % | APELLIDO: % | COLABORDADOR_PLANTEL_ID: % | MES: % | ANIO: % | ASISTENCIA: %', i, colaborador_cedula_v, colaborador_nombre_v, colaborador_apellido_v, colaboradora_plantel_v, mes_vi, anio_vi, cant_asistenacia_v;

                IF cant_colaboradora_plantel_exists_v > 0 THEN

                    line := 5;

                    RAISE NOTICE '%.- CEDULA: % | NOMBRE: % | APELLIDO: % | COLABORDADOR_PLANTEL_ID: % | MES: % | ANIO: % | ASISTENCIA: %. AL COLABORDADOR SE LE HA REGISTRADO SU ASISTENCIA EN EL MES INDICADO NO SE PUEDE EFECTUAR DE NUEVO SU REGISTRO.', i, colaborador_cedula_v, colaborador_nombre_v, colaborador_apellido_v, colaboradora_plantel_v, mes_vi, anio_vi, cant_asistenacia_v;

                    result_v := 'ALERTA';

                    mensaje_v := 'A la Madre Colaboradora con la Cédula '||colaborador_origen_v||'-'||colaborador_cedula_v||' ya se le ha registrado su asistencia en el mes indicado ('||mes_vi||'/'||anio_vi||') no se puede efectuar de nuevo su registro.';

                    resultado[i] := ARRAY[result_v, colaborador_origen_v||'-'||colaborador_cedula_v, colaborador_nombre_v, colaborador_apellido_v, cant_asistenacia_v::TEXT, mensaje_v];

                ELSE

                    line := 6;

                    RAISE NOTICE 'Se Registra de Asistencia de la Madre Colaboradora del Plantel % (%)', colaboradora_plantel_v, cant_asistenacia_v;

                    INSERT INTO gplantel.colaborador_plantel_asistencia(colaborador_plantel_id, mes, anio, cant_asistencia, usuario_ini_id, fecha_ini, estatus)
                    VALUES (colaboradora_plantel_v, mes_vi, anio_vi, cant_asistenacia_v, usuario_vi, NOW(), 'A');
                    
                    line := 7;

                    UPDATE gplantel.colaborador SET fecha_ultima_asistencia_reg = NOW(), ultima_asistencia_reg = cant_asistenacia_v WHERE id = colaborador_id_v;

                    line := 8;

                    mensaje_v := 'Se ha efectuado el Registro de Asistencia de la Madre Colaboradora con la Cédula '||colaborador_origen_v||'-'||colaborador_cedula_v||' de forma exitosa, Asitencia: ('||cant_asistenacia_v||') Mes/Anio: '||mes_vi||'/'||anio_vi;

                    result_v := 'EXITOSO';

                    resultado[i] := ARRAY[result_v, colaborador_origen_v||'-'||colaborador_cedula_v, colaborador_nombre_v, colaborador_apellido_v, cant_asistenacia_v::TEXT,  mensaje_v];

                END IF;

            ELSE
                
                line := 9;

                mensaje_v := 'El Colaborador indicado no existe.';

                result_v := 'ERROR';

                resultado[i] := ARRAY[result_v, '', '', '',  '', mensaje_v];

            END IF;

            line := 10;
            INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id, username) VALUES (fecha_v, ipaddress_vi, 'ESCRITURA', modulo_vi, result_v, 'ASISTENCIA MADRES COLABORADORAS: '||mensaje_v, usuario_vi, username_vi);

            i := i + 1;

        END LOOP;

    ELSE

	mensaje_v := 'El Mes indicado es inválido, debe estar entre 1 y 12.';

        result_v := 'ERROR';

        resultado[i] := ARRAY[result_v, '', '', '',  '', mensaje_v];
	
    END IF;
    
    RAISE NOTICE 'FIN: Proceso de Registro de Asistencia de Madres Colaboradores %', i;

    RETURN resultado;

EXCEPTION

    WHEN OTHERS THEN
        result_v := 'ERROR';
        mensaje_v := 'Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (SECCION: '||line||'). (COLAB_PLANT_ID: '||colaboradora_plantel_v||')';
        resultado[i] := ARRAY[result_v, '', '', '',  '', mensaje_v];
        INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id, username) VALUES (fecha_v, ipaddress_vi, 'ESCRITURA', modulo_vi, 'ERROR', 'ASISTENCIA MADRES COLABORADORAS: '||mensaje_v, usuario_vi, username_vi);
        RAISE NOTICE 'FIN (ERROR): Ha ocurrido un error % (ERROR NRO: %) (LINEA: %)', SQLERRM, SQLSTATE, line;
    RETURN resultado;

END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION gplantel.registro_asistencia_madres_colaboradoras(integer[], integer[], integer, integer, character varying, integer, character varying, character varying)
  OWNER TO postgres;

CREATE OR REPLACE FUNCTION planificacion_anual_menu_pae(ipaddress_vi character varying, modulo_vi character varying, usuario_vi integer, username_vi character varying)
  RETURNS text[] AS
$BODY$
DECLARE
    v_planificacion RECORD;
    v_menu RECORD;
    cant_planificacion INT;

    fecha_ini_pae DATE;
    cant_fecha_ini_pae INT;
    
    dia_de_semana INT;
    semana_del_mes INT;

    fecha_fin_pae DATE;
    cant_fecha_fin_pae INT;

    feriado_texto TEXT;

    periodo_actual_id INT;
    periodo_anio_ini INT;
    periodo_anio_fin INT;
    periodo_texto TEXT;

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

    fecha_v := (now())::timestamp(0);
    
    RAISE NOTICE 'FECHA: %', fecha_v;

    RAISE NOTICE 'INICIO: Proceso de Registro de Planificación anual del menú PAE.';

    SELECT COUNT(1) INTO cant_fecha_ini_pae FROM sistema.configuracion c WHERE c.nombre = 'FECHA_INI_PAE';
    SELECT COUNT(1) INTO cant_fecha_fin_pae FROM sistema.configuracion c WHERE c.nombre = 'FECHA_FIN_PAE';
    
    IF cant_fecha_ini_pae > 0 AND cant_fecha_fin_pae > 0 THEN

        SELECT valor_date INTO fecha_ini_pae FROM sistema.configuracion c WHERE c.nombre = 'FECHA_INI_PAE';
        SELECT valor_date INTO fecha_fin_pae FROM sistema.configuracion c WHERE c.nombre = 'FECHA_FIN_PAE';
        
        seccion := 2;
        
        SELECT id, periodo, anio_inicio, anio_fin INTO periodo_actual_id, periodo_texto, periodo_anio_ini, periodo_anio_fin FROM gplantel.periodo_escolar p WHERE p.estatus = 'A' LIMIT 1;
	
        seccion := 3;
        IF EXTRACT(YEAR FROM fecha_ini_pae)::INT = periodo_anio_ini AND EXTRACT(YEAR FROM fecha_fin_pae)::INT = periodo_anio_fin THEN

	    seccion := 4;
            SELECT COUNT(1) INTO cant_planificacion FROM nutricion.planificacion p WHERE p.fecha_inicio BETWEEN fecha_ini_pae AND fecha_fin_pae;
	
            IF cant_planificacion = 0 THEN

                seccion := 5;

                FOR v_planificacion IN SELECT a::DATE AS fecha FROM generate_series( '2014-09-15'::DATE, '2015-07-30', '1 day' ) a LOOP
 
                   RAISE NOTICE 'Procesando la planificación para la fecha %', v_planificacion.fecha;

                   feriado_texto := get_dia_feriado(v_planificacion.fecha);

                   IF feriado_texto IS NULL THEN
		       
                       dia_de_semana := day_of_week(v_planificacion.fecha);
                       semana_del_mes := week_of_month(v_planificacion.fecha);
                       
                       RAISE NOTICE 'Día de Semana %', dia_de_semana;
                       RAISE NOTICE 'Semana del Mes %', semana_del_mes;

                       FOR v_menu IN SELECT m.tipo_menu AS tipo_menu_id, m.id AS menu_id, tm.nombre_label AS label FROM nutricion.grupo_menu g
                            INNER JOIN nutricion.grupo_menu_detalle gd ON g.id = gd.grupo_menu_id
                            INNER JOIN nutricion.menu_nutricional m ON gd.menu_nutricional_id = m.id
                            INNER JOIN nutricion.tipo_menu tm ON m.tipo_menu = tm.id
                            WHERE g.semana = semana_del_mes AND g.dia = dia_de_semana LOOP

                            INSERT INTO nutricion.planificacion(menu_nutricional_id, tipo_menu_id, classname, fecha_inicio, fecha_fin, usuario_ini_id, fecha_ini, estatus)
                                VALUES (v_menu.menu_id, v_menu.tipo_menu_id, v_menu.label, v_planificacion.fecha, v_planificacion.fecha, usuario_vi, fecha_v, 'A');

                            RAISE NOTICE 'Se inserto la planificación menú: % y tipo de menú: %', v_menu.menu_id, v_menu.tipo_menu_id;

                        END LOOP;

                   ELSE
		       RAISE NOTICE 'Procesando la planificación para la fecha %', feriado_texto;
                   END IF;
                    
                END LOOP;

            ELSE
                codigo_v := 'E0003';
                transaccion_v := 'ERROR';
                mensaje_v := 'Ya existe una planificación para el Periodo Escolar actual ' || periodo_texto || '.';
                resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];
            END IF;

        ELSE
            codigo_v := 'E0002';
            transaccion_v := 'ERROR';
            mensaje_v := 'La Fecha de Inicio y Fecha de Finilización del servicio del PAE de la Configuración del Sistema no estan sincronizadas con el Periodo Escolar actual ' || periodo_text || '.';
            resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];
        
        END IF;
    
    ELSE
        codigo_v := 'E0001';
        transaccion_v := 'ERROR';
        mensaje_v := 'No se encuentran definidas en la Configuración del Sistema la Fecha de Inicio del PAE (FECHA_INI_PAE) o la Fecha Fin del programa de alimentación escolar (FECHA_FIN_PAE), Comuniquese con el administrador del sistema.';
        resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];
    END IF;
    -- INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id, username) VALUES (fecha_v, ipaddress_vi, 'ESCRITURA', modulo_vi, transaccion_v, 'REGISTRO INICIAL DE REGISTRO: '||mensaje_v, usuario_vi, username_vi);

    RAISE NOTICE 'FIN: Proceso de Registro de Planificación anual del menú PAE.';

    RETURN resultado;

EXCEPTION

    WHEN OTHERS THEN
        codigo_v := 'EE000';
        transaccion_v := 'ERROR';
        mensaje_v := 'Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (LINEA: '||seccion||')';
        resultado := ARRAY[codigo_v, transaccion_v, mensaje_v];
        INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id, username) VALUES (CURRENT_TIMESTAMP, ipaddress_vi, 'ESCRITURA', modulo_vi, 'ERROR', 'PLANIFICACION MENU PAE: '||mensaje_v, usuario_vi, username_vi);
        RAISE NOTICE 'Ha ocurrido un error % (ERROR NRO: %) (SECCION: %)', SQLERRM, SQLSTATE, seccion;
    RETURN resultado;

END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION planificacion_anual_menu_pae(character varying, character varying, integer, character varying)
  OWNER TO postgres;

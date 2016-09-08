-- Function: gplantel.puede_obtener_comprobante_pae(integer, character varying, integer, character varying, character varying)

-- DROP FUNCTION gplantel.puede_obtener_comprobante_pae(integer, character varying, integer, character varying, character varying);

CREATE OR REPLACE FUNCTION gplantel.puede_obtener_comprobante_pae(plantel_id_vi integer, modulo_vi character varying, usuario_vi integer, username_vi character varying, ipaddress_vi character varying)
  RETURNS text[] AS
$BODY$
DECLARE

    cant_plantel_v INTEGER := 0; -- Indicará si los datos Generales del Plantel han sido cargados
    cant_pae_v INTEGER := 0; -- Indicará si los Datos PAE del Plantel han sido Cargados
    cant_ingestas_v INTEGER := 0; -- Indicará si las Ingestas del Plantel han sido Cargadas
    cant_autoridades_v INTEGER := 0; -- Indicará si las Autoridades del Plantel han sido Cargadas
    cant_autoridades_verificadas_v INTEGER := 0; -- Indicará si las Autoridades del Plantel han sido Cargadas y Verificadas.

    cant_comprobante_v INTEGER := 0;

    codigo_seguridad_v CHARACTER VARYING(40) := '';
    origen_autoridad_v CHARACTER VARYING(1) := ''; 
    cedula_autoridad_v INTEGER := 0; 
    correo_autoridad_v CHARACTER VARYING(255) := '';
    archivo_pdf_v CHARACTER VARYING(255) := '';
    ultima_fecha_solicitud_v DATE;
    periodo_escolar_id_v INTEGER;
    fecha_emision_v DATE;
    fecha_caducidad_v DATE;

    resultado TEXT[7]; -- Sera el Resultado que devolvera la funcion.

    indice INTEGER;
    fecha_v TIMESTAMP WITHOUT TIME ZONE;
    i INTEGER := 1; -- Indice del arreglo resultado
    codigo_result_v CHARACTER VARYING(20);
    result_v CHARACTER VARYING(15); -- Resultado de la transaccion en una palabra o expresion clave
    mensaje_v CHARACTER VARYING(300); -- Mensaje que sera mostrado al usuario para indicarle el resultado de la transaccion
    
    line INTEGER := 25;

BEGIN

    -- ESTA FUNCION PERMITE REALIZAR LA VERIFICACIÓN DE LOS DATOS NECESARIOS PARA EMITIR EL COMPROBANTE DEL PAE.
    -- @author José Gabriel González
    -- @creation_date 2014-11-25 14:46
    -- @edition_date 2014-11-25 14:57

    fecha_v := (NOW())::TIMESTAMP(0);
    
    RAISE NOTICE 'INICIO: Proceso de Verificación de Datos para la Emisión del Reporte PAE % En el PlantelId: %', i, plantel_id_vi;
    
    SELECT COUNT(1) INTO cant_plantel_v FROM gplantel.plantel p INNER JOIN gplantel.plantel_pae pp ON p.id = pp.plantel_id WHERE p.cod_cnae IS NOT NULL AND p.estado_id IS NOT NULL AND p.municipio_id IS NOT NULL AND p.id = plantel_id_vi;

    line := 1;
    
    -- Valido que existe el plantel con sus datos generales y datos del pae debidamente cargados.

    IF (cant_plantel_v > 0) THEN
        
        line := 2;
        
        SELECT COUNT(1) INTO cant_pae_v FROM gplantel.plantel_pae pp WHERE (pp.matricula_maternal+pp.matricula_preescolar+pp.matricula_educacion_primaria+pp.matricula_educacion_media_general+pp.matricula_educacion_tecnica+pp.matricula_educacion_especial) > 0 AND pp.proveedor_actual_id IS NOT NULL AND pp.plantel_id = plantel_id_vi;

        -- Valido que la matricula sea mayor a cero y que los datos dle proveedor actual estén cargados.
        
        IF (cant_pae_v > 0) THEN

            line := 3;

            SELECT COUNT(1) INTO cant_ingestas_v FROM gplantel.plantel_ingesta pi WHERE pi.plantel_id = plantel_id_vi AND pi.estatus = 'A';

            -- Valido que la cantidad de ingestas que tiene el plantel asignadas sea mayor a cero.

            IF (cant_ingestas_v > 0) THEN

                line := 4;

                SELECT COUNT(1) INTO cant_autoridades_v FROM gplantel.autoridad_plantel ap WHERE ap.plantel_id = plantel_id_vi AND ap.estatus = 'A' AND ap.cargo_id IN (3, 27);
                
                line := 5;

                SELECT COUNT(1) INTO cant_autoridades_verificadas_v FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user u ON ap.usuario_id = u.id WHERE ap.plantel_id = plantel_id_vi AND ap.estatus = 'A' AND ap.cargo_id IN (3, 27) AND u.presento_documento_identidad = 'SI';
                
                -- Verifico que el director o el enlace PAE del Plantel esté debidamente registrado, asignado al plantel y verificados con la presentación de su documento de identidad.

                IF (cant_autoridades_v=cant_autoridades_verificadas_v AND cant_autoridades_v>0) THEN
                  
                    line := 6;
                    
                    SELECT COUNT(1) INTO cant_autoridades_verificadas_v FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user u ON ap.usuario_id = u.id WHERE ap.plantel_id = plantel_id_vi AND ap.estatus = 'A' AND ap.cargo_id = 3 AND u.presento_documento_identidad = 'SI';
                    
                    -- Verifico que el director esté registrado y verificados con la presentación de su documento de identidad.

                    IF (cant_autoridades_verificadas_v>0) THEN

                        line := 7;

                        mensaje_v := 'Se puede emitir el comprobante.';
                        result_v := 'EXITO';
                        
                        SELECT id INTO periodo_escolar_id_v FROM gplantel.periodo_escolar WHERE estatus = 'A' LIMIT 1;
                        
                        -- Debo empezar a seleccionar todos los datos requeridos en el reporte.

                        line := 8;
                        
                        -- Selecciono los datos de la autoridad (Director).

                        SELECT u.origen, u.cedula, u.email 
                          INTO origen_autoridad_v, cedula_autoridad_v, correo_autoridad_v 
                          FROM gplantel.autoridad_plantel ap 
                    INNER JOIN seguridad.usergroups_user u ON ap.usuario_id = u.id 
                         WHERE ap.plantel_id = plantel_id_vi AND ap.estatus = 'A' AND ap.cargo_id = 3 AND u.presento_documento_identidad = 'SI' 
                         LIMIT 1;

                        line := 9;
                        
                        -- Selecciono la fecha de caducidad o vencimiento de comprobante que coincide con la fecha final del servicio del PAE por el periodo escolar actual.

                        SELECT valor_date INTO fecha_caducidad_v FROM sistema.configuracion WHERE nombre = 'FECHA_FIN_PAE' LIMIT 1;

                        fecha_emision_v := NOW();
                        ultima_fecha_solicitud_v := fecha_emision_v;

                        RAISE NOTICE 'INICIO: Fecha de Solicitud de Comprobante: %', ultima_fecha_solicitud_v::TEXT;

                        line := 10;

                        SELECT COUNT(1) INTO cant_comprobante_v 
                          FROM gplantel.plantel_pae_comprobante 
                         WHERE plantel_id = plantel_id_vi 
                           AND periodo_escolar_id = periodo_escolar_id_v 
                           AND origen_autoridad = origen_autoridad_v
                           AND cedula_autoridad = cedula_autoridad_v;
			
			RAISE NOTICE 'Existe el Comprobante Solicitado: % % % %', plantel_id_vi::TEXT, periodo_escolar_id_v::TEXT, origen_autoridad_v::TEXT, cedula_autoridad_v::TEXT;

                        -- Verifico si no se emitido algún comprobante para esta autoridad en el periodo escolar actual.

                        IF (cant_comprobante_v=0) THEN
                            
                            -- Si no se ha emitidio ningún comprobante entonces se hace el registro de emisión del mismo.

		            line := 11;
		            
                            codigo_seguridad_v := md5(plantel_id_vi::TEXT||origen_autoridad_v::TEXT||cedula_autoridad_v::TEXT||periodo_escolar_id_v::TEXT||fecha_emision_v);
                            archivo_pdf_v := codigo_seguridad_v||'.pdf';
                            
                            line := 12;

                            INSERT INTO gplantel.plantel_pae_comprobante(
                                plantel_id, 
                                codigo_seguridad, 
                                origen_autoridad, 
                                cedula_autoridad, 
                                correo_autoridad, 
                                archivo_pdf, 
                                ultima_fecha_solicitud, 
                                periodo_escolar_id, 
                                fecha_emision, 
                                fecha_caducidad, 
                                usuario_ini_id
                            ) VALUES (
                                plantel_id_vi, 
                                codigo_seguridad_v, 
                                origen_autoridad_v, 
                                cedula_autoridad_v, 
                                correo_autoridad_v, 
                                archivo_pdf_v, 
                                ultima_fecha_solicitud_v, 
                                periodo_escolar_id_v, 
                                fecha_emision_v, 
                                fecha_caducidad_v, 
                                usuario_vi
                            );

                            line := 13;

                            UPDATE gplantel.plantel_pae 
                               SET comprobante_emitido = 'SI', 
                                   fecha_emision_comprobante = ultima_fecha_solicitud_v 
                             WHERE plantel_id = plantel_id_vi;

                        ELSE
                            
                            -- Si ya existe un comprobante emitido no debo crearlo de nuevo, solo actualizo la última fecha de emisión.

                            line := 14;
                            
                            SELECT codigo_seguridad, origen_autoridad, cedula_autoridad, correo_autoridad, archivo_pdf 
                              INTO codigo_seguridad_v, origen_autoridad_v, cedula_autoridad_v, correo_autoridad_v, archivo_pdf_v
                              FROM gplantel.plantel_pae_comprobante 
                             WHERE plantel_id = plantel_id_vi 
                               AND periodo_escolar_id = periodo_escolar_id_v 
                               AND origen_autoridad = origen_autoridad_v
                               AND cedula_autoridad = cedula_autoridad_v;
                               
                            line := 15;

                            UPDATE gplantel.plantel_pae_comprobante 
                               SET ultima_fecha_solicitud = ultima_fecha_solicitud_v, 
                                   email_enviado = 'NO', 
                                   usuario_act_id = usuario_vi, 
                                   fecha_act = ultima_fecha_solicitud_v
                             WHERE plantel_id = plantel_id_vi 
                               AND periodo_escolar_id = periodo_escolar_id_v 
                               AND origen_autoridad = origen_autoridad_v
                               AND cedula_autoridad = cedula_autoridad_v;

                        END IF;

                        line := 16;

                        INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id, username) VALUES (fecha_v, ipaddress_vi, 'ESCRITURA', modulo_vi, result_v, 'SOLICITUD DE EMISION DE COMPROBANTE CNAE: '||mensaje_v, usuario_vi, username_vi);

                    ELSE

                        mensaje_v := 'Debe ser registrado el Director de la Institución Educativa y presentar su Documento de Identidad.';
                        result_v := 'ERROR';

                    END IF;
                  
                ELSE

                    mensaje_v := 'Las Autoridades de la Institución Educativa deben presentar su Documento de Identidad y este acto debe ser registrado en el sistema.';
                    result_v := 'ERROR';

                END IF;

            ELSE

                mensaje_v := 'Antes de emitir el comprobante deber realizar el registro de las Ingestas proveidas por esta Institución Educativa.';
                result_v := 'ERROR';

            END IF;

        ELSE

            mensaje_v := 'No se han podido verificar Los Datos PAE de la Institución Educativa. Verifique que los datos requeridos como la Matrícula Total y el Proveedor Actual estén debidamente registrados.';
            result_v := 'ERROR';

        END IF;

    ELSE

	mensaje_v := 'No se han podido verificar Los Datos Generales de la Institución Educativa. Verifique que los datos requeridos como Código CNAE, Estado, Municipio y Consejo Comunal estén debidamente registrados.';
        result_v := 'ERROR';
	
    END IF;
    
    resultado := ARRAY[result_v, mensaje_v, codigo_seguridad_v, origen_autoridad_v, cedula_autoridad_v::TEXT, correo_autoridad_v, fecha_caducidad_v::TEXT, archivo_pdf_v];

    RAISE NOTICE 'FIN: Proceso de Registro de Verificación de Datos para la Emisión del Reporte PAE %', i;

    RETURN resultado;

EXCEPTION

    WHEN OTHERS THEN
        result_v := 'ERROR';
        mensaje_v := 'Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (SECCION: '||line||'). (PLANT_ID: '||plantel_id_vi||') --- QUERY:('||plantel_id_vi||', '||modulo_vi||', '||usuario_vi||', '||username_vi||', '||ipaddress_vi||')';
        resultado[i] := ARRAY[result_v, '', '', '',  '', '',  '', '', mensaje_v];
        INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id, username) VALUES (fecha_v, ipaddress_vi, 'ESCRITURA', modulo_vi, 'ERROR', 'COMPROBANTE CNAE: '||mensaje_v, usuario_vi, username_vi);
        RAISE NOTICE 'FIN (ERROR): Ha ocurrido un error % (ERROR NRO: %) (SECCION: %)', SQLERRM, SQLSTATE, line;
    RETURN resultado;

END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION gplantel.puede_obtener_comprobante_pae(integer, character varying, integer, character varying, character varying)
  OWNER TO postgres;

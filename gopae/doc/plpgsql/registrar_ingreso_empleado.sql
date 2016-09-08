CREATE OR REPLACE FUNCTION gestion_humana.ingreso_empleado(
    talento_humano_id_vi integer,
    posee_numero_contrato_vi character varying,
    nro_contrato_vi character varying,
    fecha_ingreso_vi date,
    fecha_fin_contrato_vi date,
    categoria_ingreso_id integer,
    tipo_cargo_nominal_id_vi integer,
    cargo_nominal_id_vi integer,
    estructura_organizativa_id_vi integer,
    condicion_nominal_id_vi integer,
    tipo_nomina_id_vi integer,
    plantel_id_vi integer,
    observacion character varying,
    ipaddress_vi varchar,
    modulo_vi varchar,
    usuario_ini_id_vi integer
) RETURNS RECORD AS
$BODY$
    DECLARE
        --VARIABLES
        fechaIniV date := date('today');
        estatusV varchar := 'A';
        integridadV varchar(40);

        --VARIABLES DE MENSAJE
        tipoMensajeV varchar := 'ERROR'; -- ERROR, EXITOSO, ALERTA
        mensajeV varchar := 'Datos incompletos';
        resultado RECORD;

        --VARIABLES DE EXISTENCIA
        existenciaIngresosIdV int := 0;
        existenciaTalentoHumanoIdV int := 0;
        existenciaUsuarioNominaV int := 0;

        --VARIABLES CAPTURA
        ingresosIdV int;
        talentoHumanoIdV int;
        fechaIngresoRegistradaV date;
        capturaCamposIntegridadV text;

        --VARIABLE DE CONTROL
        seccionV int := 0;
    BEGIN

    seccionV := 1;
    --VALIDAR SI TIENE PERMISOS PARA REGISTRAR UN NUEVO INGRESO (QUITAR AL USUARIO_ID = 1 "ADMIN" COMO USUARIO CON PERMISOS DE REGISTRAR INGRESOS EN NÓMINA)
    SELECT COUNT(1) INTO existenciaUsuarioNominaV FROM seguridad.usergroups_user as usuario LEFT JOIN seguridad.usergroups_group as grupo ON usuario.group_id = grupo.id WHERE (grupo.groupname ='NOMINA' AND usuario.id = usuario_ini_id_vi ) OR (1 = usuario_ini_id_vi) LIMIT 1;

    IF existenciaUsuarioNomina_vi = 0 THEN --IF 1

        mensajeV := 'Usted no posee permisos para realizar esta operación.';

    ELSE

        seccionV := 2;
        --EXISTENCIA EN TALENTO HUMANO
        SELECT COUNT(1) INTO existenciaTalentoHumanoIdV FROM gestion_humana.talento_humano WHERE id = talento_humano_id_vi;

        IF existenciaTalentoHumanoIdV = 0 THEN --IF 2

            mensajeV := 'Esta Persona no esta registrada como Talento Humano de la Corporación. Debe Ingresar primeramente los datos generales de esta persona.';

        ELSE

            seccionV := 3;
            --VALIDAR SI YA POSEE UN INGRESO CON ESTADO 'A' EN INGRESOS
            SELECT COUNT(1) INTO existenciaIngresosIdV FROM gestion_humana.ingreso_empleado WHERE estatus = 'A' AND talento_humano_id = talento_humano_id_vi;

            IF existenciaIngresosId_vi = 0 THEN --IF 3

                seccionV:= 4;
                -- SE VALIDA QUE LA FECHA NO SEA MENOR A LA DE EL ÚLTIMO INGRESO
                SELECT fecha_ingreso INTO fechaIngresoRegistradaV FROM gestion_humana.ingreso_empleado WHERE  talento_humano_id = talento_humano_id_vi ORDER BY id DESC;

                IF fechaIngresoRegistradaV = fecha_ingreso_vi THEN --IF 4

                    mensajeV := 'Esta persona ya posee un ingreso en esta fecha. Asigne otra fecha al ingreso o comuniquese con el Administrador del Área de Nómina.';

                ELSIF fechaIngresoRegistradaV > fecha_ingreso_vi THEN --ELSIF 4

                    mensajeV := 'Esta persona ya posee un ingreso en una fecha posterior a la escogida. Ingrese una fecha posterior a: '||fechaIngresoRegistradaV;

                ELSE --ELSE 4

                    seccionV := 5;
                    INSERT INTO gestion_humana.ingreso_empleado (
                        talento_humano_id,
                        posee_numero_contrato,
                        nro_contrato,
                        fecha_ingreso,
                        fecha_fin_contrato,
                        categoria_ingreso_id,
                        tipo_cargo_nominal_id,
                        cargo_nominal_id,
                        estructura_organizativa_id,
                        condicion_nominal_id,
                        tipo_nomina_id,
                        plantel_id,
                        observacion,
                        usuario_ini_id,
                        fecha_ini,
                        estatus
                    )VALUES(
                        talento_humano_id_vi::int,
                        posee_numero_contrato_vi::varchar,
                        nro_contrato_vi::varchar,
                        fecha_ingreso_vi::date,
                        fecha_fin_contrato_vi::date,
                        categoria_ingreso_id::int,
                        tipo_cargo_nominal_id_vi::int,
                        cargo_nominal_id_vi::int,
                        estructura_organizativa_id_vi::int,
                        condicion_nominal_id_vi::int,
                        tipo_nomina_id_vi::int,
                        plantel_id_vi::int,
                        observacion::varchar,
                        usuario_ini_id_vi::int,
                        fechaIniV::date,
                        estatusV::varchar
                    );
                    seccionV := 6;
                    UPDATE
                        gestion_humana.talento_humano
                    SET
                        fecha_ingreso = fecha_ingreso_vi::date,
                        categoria_ingreso_id = categoria_ingreso_id::int,
                        tipo_cargo_actual_id = tipo_cargo_nominal_id_vi::int,
                        cargo_actual_id = cargo_nominal_id_vi::int,
                        estructura_organizativa_actual_id = estructura_organizativa_id_vi::int,
                        condicion_actual_id = condicion_nominal_id_vi::int,
                        tipo_nomina_id = tipo_nomina_id_vi::int,
                        plantel_actual_id = plantel_id_vi::int,
                        usuario_act_id = usuario_ini_id_vi::int,
                        fecha_act = fechaIni_vi::date
                    WHERE
                        id = talento_humano_id_vi;

                    seccionV := 7;
                    SELECT MD5(COALESCE(rif::text, '')||COALESCE(apellido::text, '')||COALESCE(sexo::text, '')||COALESCE(foto::text, '')||COALESCE(nombre::text, '')||COALESCE(fecha_nacimiento::text, '')||COALESCE(registro_militar::text, '')||COALESCE(email_personal::text, '')||COALESCE(telefono_celular::text, '')||COALESCE(email_corporativo::text, '')||COALESCE(twitter::text, '')||COALESCE(manipulacion_alimentos::text, '')||COALESCE(mision_id::text, '')||COALESCE(grado_instruccion_id::text, '')||COALESCE(certificado_medico::text, '')||COALESCE(origen::text, '')||COALESCE(codigo_integridad::text, '')||COALESCE(codigo_empleado::text, '')||COALESCE(tipo_serial_cuenta_id::text, '')||COALESCE(id::text, '')||COALESCE(estado_id::text, '')||COALESCE(condicion_actual_id::text, '')||COALESCE(cargo_actual_id::text, '')||COALESCE(telefono_oficina::text, '')||COALESCE(cantidad_hijos::text, '')||COALESCE(banco_id::text, '')||COALESCE(hijo_en_plantel::text, '')||COALESCE(municipio_id::text, '')||COALESCE(categoria_ingreso_id::text, '')||COALESCE(numero_cuenta::text, '')||COALESCE(fecha_ingreso::text, '')||COALESCE(tipo_nomina_id::text, '')||COALESCE(username_corp::text, '')||COALESCE(tipo_cuenta_id::text, '')||COALESCE(tipo_cargo_actual_id::text, '')||COALESCE(usuario_ini_id::text, '')||COALESCE(password_corp::text, '')||COALESCE(origen_titular::text, '')||COALESCE(cedula::text, '')||COALESCE(parroquia_id::text, '')||COALESCE(fecha_egreso::text, '')||COALESCE(cedula_titular::text, '')||COALESCE(plantel_actual_id::text, '')||COALESCE(diversidad_funcional_id::text, '')||COALESCE(fecha_ini::text, '')||COALESCE(nombre_titular::text, '')||COALESCE(numero_ivss::text, '')||COALESCE(ultima_asistencia_reg::text, '')||COALESCE(estructura_organizativa_actual_id::text, '')||COALESCE(estatus::text, '')||COALESCE(fecha_act::text, '')||COALESCE(verificado_saime::text, '')||COALESCE(usuario_act_id::text, '')||COALESCE(etnia_id::text, '')||COALESCE(banco_tarjeta_alimentacion_id::text, '')||COALESCE(lateralidad::text, '')||COALESCE(numero_tarjeta_alimentacion::text, '')||COALESCE(habilidad_agropecuaria::text, '')||COALESCE(fecha_entrega_tarjeta_alimentacion::text, '') ) INTO capturaCodigoIntegridadV FROM gestion_humana.talento_humano WHERE id = talento_humano_id_vi;

                    seccionV := 8;
                    UPDATE
                        gestion_humana.talento_humano
                    SET
                        codigo_integridad = capturaCodigoIntegridadV
                    WHERE
                        id = talento_humano_id_vi;

                    tipoMensajeV := 'EXITOSO';

                    mensajeV := 'El Registro de los datos de Ingreso del Empleado ha sido efectuado exitosamente';

                END IF;-- FIN IF 4

            ELSE
                mensajeV := 'Esta persona ya ha Ingresado a la Corporación. Para efectuar un nuevo Ingreso a esta persona, debe primeramente registrar un egreso a la misma.';
            END IF;-- FIN IF 3

        END IF; --FIN IF 2

    END IF;--FIN IF 1
    SELECT tipoMensajeV, mensajeV INTO resultado;
    INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id) VALUES (fechaIniV, ipaddress_vi, 'ESCRITURA', modulo_vi, tipoMensajeV, 'REGISTRO INICIAL DE INGRESOS: '||mensaje_v||' DATA: '||'TalentoHumanoId:'||COALESCE(talento_humano_id_vi::text)||';'||COALESCE(posee_numero_contrato_vi::text)||';'||COALESCE(nro_contrato_vi::text)||';'||COALESCE(fecha_ingreso_vi::text)||';'||COALESCE(fecha_fin_contrato_vi::text)||';'||COALESCE(categoria_ingreso_id::text)||';'||COALESCE(tipo_cargo_nominal_id_vi::text)||';'||COALESCE(cargo_nominal_id_vi::text)||';'||COALESCE(estructura_organizativa_id_vi::text)||';'||COALESCE(condicion_nominal_id_vi::text)||';'||COALESCE(tipo_nomina_id_vi::text)||';'||COALESCE(plantel_id_vi::text)||';'||COALESCE(observacion::text)||';'||COALESCE(ipaddress_vi::text)||';'||COALESCE(usuario_ini_id_vi::text), usuario_ini_id_vi);
    RETURN resultado;

EXCEPTION

    WHEN OTHERS THEN
        tipoMensajeV := 'ERROR';
        mensajeV := 'Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (SECCIÓN: '||seccion||')';
        SELECT tipoMensajeV, mensajeV INTO resultado;
        INSERT INTO auditoria.traza(fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, user_id) VALUES (fechaIniV, ipaddress_vi, 'ESCRITURA', modulo_vi, tipoMensajeV, 'REGISTRO INICIAL DE INGRESOS: '||mensaje_v||' DATA: '||'TalentoHumanoId:'||COALESCE(talento_humano_id_vi::text)||';'||COALESCE(posee_numero_contrato_vi::text)||';'||COALESCE(nro_contrato_vi::text)||';'||COALESCE(fecha_ingreso_vi::text)||';'||COALESCE(fecha_fin_contrato_vi::text)||';'||COALESCE(categoria_ingreso_id::text)||';'||COALESCE(tipo_cargo_nominal_id_vi::text)||';'||COALESCE(cargo_nominal_id_vi::text)||';'||COALESCE(estructura_organizativa_id_vi::text)||';'||COALESCE(condicion_nominal_id_vi::text)||';'||COALESCE(tipo_nomina_id_vi::text)||';'||COALESCE(plantel_id_vi::text)||';'||COALESCE(observacion::text)||';'||COALESCE(ipaddress_vi::text)||';'||COALESCE(usuario_ini_id_vi::text), usuario_ini_id_vi);
        RAISE NOTICE 'Ha ocurrido un error % (ERROR NRO: %) (LINEA: %)', SQLERRM, SQLSTATE, seccion;
    RETURN resultado;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
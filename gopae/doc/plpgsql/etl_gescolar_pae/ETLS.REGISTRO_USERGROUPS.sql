-- Function: etls.registro_usergroups(character varying,integer,character varying, integer,timestamp without time zone, character varying,timestamp without time zone, integer,character varying,character varying,character varying,character varying,integer, text,text,timestamp without time zone, character varying, timestamp without time zone,timestamp without time zone,timestamp without time zone, text,character varying, character varying, character varying, character varying, integer, bigint, timestamp without time zone, bigint, character varying, character varying, character varying,smallint, character varying,character varying)

-- DROP FUNCTION etls.registro_usergroups(character varying,integer,character varying, integer,timestamp without time zone, character varying,timestamp without time zone, integer,character varying,character varying,character varying,character varying,integer, text,text,timestamp without time zone, character varying, timestamp without time zone,timestamp without time zone,timestamp without time zone, text,character varying, character varying, character varying, character varying, integer, bigint, timestamp without time zone, bigint, character varying, character varying, character varying,smallint, character varying,character varying);

CREATE OR REPLACE FUNCTION etls.registro_usergroups(groupname_vi character varying, level_vi integer, home_group_vi character varying, user_group_ini_id_vi integer, date_group_ini_vi timestamp without time zone, estatus_vi character varying, date_del_vi timestamp without time zone, cedula_vi integer, username_vi character varying, password_vi character varying, email_vi character varying, home_user_vi character varying,status_vi integer, question_vi text, answer_vi text, creation_date_vi timestamp without time zone, activation_code_vi character varying, activation_time_vi timestamp without time zone, last_login_vi timestamp without time zone, ban_vi timestamp without time zone, ban_reason_vi text, telefono_vi character varying, nombre_vi character varying, apellido_vi character varying, direccion_vi character varying, estado_id_vi integer, user_user_ini_id_vi bigint, date_user_ini_vi timestamp without time zone, user_ban_id_vi bigint, last_ip_address_vi character varying, origen_vi character varying, clave_anterior_vi character varying, cambio_clave_vi smallint, twitter_vi character varying, telefono_celular_vi character varying)
  RETURNS text AS
$BODY$
DECLARE
    resultado_vo CHARACTER VARYING;
    group_id_v INTEGER :=0;
    cant_existe_grupo_v INTEGER := 0; -- Indicara la Cantidad de Veces que un dato es encontrado en la tabla (Por regla debe aparecer mÃ¡ximo una vez) Si ya existe el dato no se debe registrar de nuevo.
    cant_existe_user_v INTEGER := 0;    
    resultado_log_v CHARACTER VARYING(10);
    fecha_v TIMESTAMP WITHOUT TIME ZONE;
    mensaje_v TEXT; -- Mensaje que sera mostrado al usuario para indicarle el resultado_vo de la transaccion
    seccion_v INTEGER := 0;
    operacion_v CHARACTER VARYING(10);

BEGIN

    -- @author Nelson Gonzalez
    -- @date 2015-08-01 08:36

    RAISE NOTICE 'DATO: % %', groupname_vi, cedula_vi;

    RAISE NOTICE 'INICIO';

    fecha_v := (now())::timestamp(0);
    date_group_ini_vi  := (now())::timestamp(0);
    seccion_v := 1;

    SELECT COUNT(1) INTO cant_existe_grupo_v FROM seguridad.usergroups_group WHERE groupname = groupname_vi;

    RAISE NOTICE 'DATO: %', groupname_vi;   

    IF groupname_vi IS NOT NULL THEN

        IF cant_existe_grupo_v = 0 THEN

            seccion_v := 2;
            
            INSERT INTO seguridad.usergroups_group(
                groupname,
                level,
                home,
                date_ini,
                estatus,
                date_del
            )
            VALUES (
                groupname_vi,
                level_vi,
                home_group_vi,
                fecha_v,
                estatus_vi,
                date_del_vi
            )  
            RETURNING id INTO group_id_v;


            RAISE NOTICE 'EL GRUPO %  SE HA REGISTRADO DE FORMA EXITOSA', groupname_vi;

            mensaje_v := 'EL GRUPO '||groupname_vi||' SE HA REGISTRADO DE FORMA EXITOSA';

            resultado_vo := 'REGISTRO';

            -- INSERCION PARA LOS LOGS

            seccion_v := 3;

            operacion_v := 'REGISTRAR';


        ELSE
            seccion_v := 4;

            SELECT id INTO group_id_v FROM seguridad.usergroups_group WHERE groupname = groupname_vi LIMIT 1; 

            mensaje_v := 'EL GRUPO '||groupname_vi||' SE HA CONSULTADO DE FORMA EXITOSA';

            resultado_vo := 'CONSULTO';

            -- INSERCION PARA LOS LOGS

            seccion_v := 3;

            operacion_v := 'CONSULTAR';

        END IF;

        resultado_log_v := auditoria_etls.registro_log_group(
            groupname_vi,
            level_vi,
            home_group_vi,
            date_group_ini_vi,
            estatus_vi,
            date_del_vi,
            resultado_vo,
            mensaje_v,
            fecha_v,
            operacion_v
        ); 
        
        seccion_v := 5;

        SELECT COUNT (1) INTO cant_existe_user_v FROM seguridad.usergroups_user WHERE cedula = cedula_vi AND origen=origen_vi;

        RAISE NOTICE 'DATO: %', cedula_vi;

        IF cant_existe_user_v = 0 THEN

            seccion_v := 6;
            
            INSERT INTO seguridad.usergroups_user( 
                group_id, 
                username, 
                password, 
                email, 
                home, 
                status, 
                question, 
                answer, 
                creation_date, 
                activation_code, 
                activation_time, 
                last_login, 
                ban, 
                ban_reason, 
                telefono, 
                nombre, 
                apellido, 
                cedula, 
                direccion, 
                estado_id, 
                date_ini, 
                user_act_id, 
                date_act, 
                user_ban_id, 
                last_ip_address, 
                origen, 
                clave_anterior, 
                cambio_clave, twitter, 
                telefono_celular
            )
            VALUES ( 
                group_id_v, 
                username_vi, 
                password_vi, 
                email_vi, 
                home_user_vi, 
                status_vi, 
                question_vi, 
                answer_vi, 
                creation_date_vi, 
                activation_code_vi, 
                activation_time_vi, 
                last_login_vi, 
                ban_vi, 
                ban_reason_vi, 
                telefono_vi, 
                nombre_vi, 
                apellido_vi, 
                cedula_vi, 
                direccion_vi, 
                estado_id_vi, 
                fecha_v, 
                null, 
                null, 
                null, 
                last_ip_address_vi, 
                origen_vi, 
                clave_anterior_vi, 
                cambio_clave_vi,
                twitter_vi, 
                telefono_celular_vi
            );

            RAISE NOTICE 'EL USUARIO % SE HA REGISTRADO DE FORMA EXITOSA', cedula_vi;

            mensaje_v := 'EL USUARIO '||cedula_vi||' SE HA REGISTRADO DE FORMA EXITOSA';

            resultado_vo := 'REGISTRO';

            -- INSERCION PARA LOS LOGS

            seccion_v := 7;

            operacion_v := 'REGISTRAR';



        END IF; 
    
    ELSE

        RAISE NOTICE 'DATOS FALTANTES. EL DATO DEL REGISTRO Y EL ID DEL REGISTRO PROGRAMADO NO PUEDEN TENER VALORES NULOS';

        mensaje_v := 'DATOS FALTANTES. EL DATO DEL REGISTRO Y EL ID DEL REGISTRO PROGRAMADO NO PUEDEN TENER VALORES NULOS';

        resultado_vo := 'ERROR';
        operacion_v := 'SIN CAMBIO';

    END IF;
    resultado_log_v := auditoria_etls.registro_log_user(
        cedula_vi, 
        username_vi, 
        password_vi, 
        email_vi, 
        home_user_vi, 
        question_vi, 
        answer_vi, 
        creation_date_vi, 
        activation_code_vi, 
        activation_time_vi, 
        last_login_vi, 
        ban_vi, 
        ban_reason_vi, 
        telefono_vi, 
        nombre_vi, 
        apellido_vi, 
        direccion_vi, 
        estado_id_vi, 
        date_user_ini_vi,
        null, 
        null, 
        last_ip_address_vi, 
        origen_vi, 
        clave_anterior_vi, 
        cambio_clave_vi, 
        twitter_vi, 
        telefono_celular_vi,
        mensaje_v,
        fecha_v,
        operacion_v,
        resultado_vo
    );

    RAISE NOTICE 'FIN';

    RETURN resultado_vo;

EXCEPTION WHEN OTHERS THEN
    mensaje_v := 'Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (Seccion: '||seccion_v||')';
    resultado_vo := 'ERROR';
    RAISE NOTICE 'Ha ocurrido un error % (ERROR NRO: %) (Seccion: %)', SQLERRM, SQLSTATE, seccion_v;
    -- ERROR LOG
    seccion_v := 8;
    operacion_v := 'SIN CAMBIO';

    resultado_log_v := auditoria_etls.registro_log_user(
        cedula_vi, 
        username_vi, 
        password_vi, 
        email_vi, 
        home_user_vi, 
        question_vi, 
        answer_vi, 
        creation_date_vi, 
        activation_code_vi, 
        activation_time_vi, 
        last_login_vi, 
        ban_vi, 
        ban_reason_vi, 
        telefono_vi, 
        nombre_vi, 
        apellido_vi, 
        direccion_vi, 
        estado_id_vi, 
        date_user_ini_vi,
        null, 
        null, 
        last_ip_address_vi, 
        origen_vi, 
        clave_anterior_vi, 
        cambio_clave_vi, 
        twitter_vi, 
        telefono_celular_vi,
        mensaje_v,
        fecha_v,
        operacion_v,
        resultado_vo
    );

    resultado_log_v := auditoria_etls.registro_log_group(
        groupname_vi,
        level_vi,
        home_group_vi,
        date_group_ini_vi,
        estatus_vi,
        date_del_vi,
        resultado_vo,
        mensaje_v,
        fecha_v,
        operacion_v
    );


    RETURN resultado_vo;
  

END;$BODY$
    LANGUAGE plpgsql VOLATILE
    COST 100;
    ALTER FUNCTION etls.registro_usergroups(
        character varying, 
        integer, 
        character varying, 
        integer, 
        timestamp without time zone, 
        character varying, 
        timestamp without time zone, 
        integer, 
        character varying, 
        character varying, 
        character varying, 
        character varying,
        integer, 
        text, 
        text, 
        timestamp without time zone, 
        character varying, 
        timestamp without time zone, 
        timestamp without time zone, 
        timestamp without time zone, 
        text, 
        character varying, 
        character varying,
        character varying, 
        character varying, 
        integer, 
        bigint, 
        timestamp without time zone, 
        bigint, 
        character varying, 
        character varying, 
        character varying, 
        smallint, 
        character varying, 
        character varying
    )
    OWNER TO postgres;
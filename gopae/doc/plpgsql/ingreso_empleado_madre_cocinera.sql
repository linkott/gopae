CREATE OR REPLACE FUNCTION gestion_humana.ingreso_empleado_madre_cocinera(
talentoHumanoId int,
poseeNumeroContrato varchar,
nroContrato varchar,
fechaIngreso date,
categoriaIngresoId int,
tipoCargoNominalId int,
cargoNominalId int,
estructuraOrganizativaId int,
condicionNominalId int,
tipoNominaId int,
plantelId int,
observacion varchar,
usuarioIniId int
)
RETURNS varchar AS $BODY$
    DECLARE
	--VARIABLES
	fechaIni_vi date := date('today');
	estatus_vi varchar := 'A';
    
	--VARIABLES DE MENSAJE
	mensaje_vi varchar := 'null';

	--VARIABLES DE EXISTENCIA
	existenciaIngresosId_vi int := 0;
	existenciaTalentoHumanoId_vi int := 0;
	existenciaUsuarioNomina_vi int := 0;

	--VARIABLES CAPTURA ID
	ingresosId_vi int;
	talentoHumanoId_vi int;
        fecha_ingreso_registrada_vi date;
	
    BEGIN
	--VALIDAR SI TIENE PERMISOS PARA REGISTRAR UN NUEVO INGRESO
	SELECT COUNT(1) INTO existenciaUsuarioNomina_vi FROM seguridad.usergroups_user as usuario LEFT JOIN seguridad.usergroups_group as grupo ON usuario.group_id = grupo.id WHERE (grupo.groupname ='NOMINA' AND usuario.id = usuarioIniId ) OR (1 = usuarioIniId) LIMIT 1;
        IF existenciaUsuarioNomina_vi = 0 THEN --IF 1
            mensaje_vi := 'Usted no tiene permisos para realizar esta operacion';
	ELSE
            --VALIDAR SI YA POSEE UN INGRESO CON ESTADO 'A' EN INGRESOS
            SELECT COUNT(1) INTO existenciaIngresosId_vi FROM gestion_humana.ingreso_empleado WHERE estatus = 'A' AND talento_humano_id = talentoHumanoId;
            IF existenciaIngresosId_vi = 0 THEN --IF 2
                SELECT fecha_ingreso INTO fecha_ingreso_registrada_vi FROM gestion_humana.ingreso_empleado WHERE  talento_humano_id = talentoHumanoId ORDER BY id DESC;
                IF fecha_ingreso_registrada_vi = fechaIngreso THEN --IF 3
                    mensaje_vi := 'Esta persona ya posee un ingreso en esta fecha.';
                ELSEIF fecha_ingreso_registrada_vi > fechaIngreso THEN
                    mensaje_vi := 'Ingrese una fecha superior a: '||fecha_ingreso_registrada_vi;
                ELSE
                    INSERT INTO gestion_humana.ingreso_empleado (
                        talento_humano_id,
                        posee_numero_contrato,
                        nro_contrato,
                        fecha_ingreso,
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
                        talentoHumanoId::int,
                        poseeNumeroContrato::varchar,
                        nroContrato::varchar,
                        fechaIngreso::date,
                        categoriaIngresoId::int,
                        tipoCargoNominalId::int,
                        cargoNominalId::int,
                        estructuraOrganizativaId::int,
                        condicionNominalId::int,
                        tipoNominaId::int,
                        plantelId::int,
                        observacion::varchar,
                        usuarioIniId::int,
                        fechaIni_vi::date,
                        estatus_vi::varchar
                    );
                    --EXISTENCIA EN TALENTO HUMANO 
                    SELECT COUNT(1) INTO existenciaTalentoHumanoId_vi FROM gestion_humana.talento_humano WHERE id = talentoHumanoId;
                    IF existenciaTalentoHumanoId_vi = 0 THEN --IF 4
                        mensaje_vi := 'Esta Persona no esta registrada en Talento Humano.';
                    ELSE
                        UPDATE 
                            gestion_humana.talento_humano 
                        SET  
                            fecha_ingreso = fechaIngreso::date,
                            categoria_ingreso_id = categoriaIngresoId::int,
                            tipo_cargo_actual_id = tipoCargoNominalId::int,
                            cargo_actual_id = cargoNominalId::int,
                            estructura_organizativa_actual_id = estructuraOrganizativaId::int,
                            condicion_actual_id = condicionNominalId::int,
                            tipo_nomina_id = tipoNominaId::int,
                            plantel_actual_id = plantelId::int,
                            usuario_act_id = usuarioIniId::int,
                            fecha_act = fechaIni_vi::date
                        WHERE 
                            id = talentoHumanoId;

                        mensaje_vi := 'El Registro de los datos de Ingreso del Empleado ha sido efectuado exitosamente.';
                    END IF; --FIN IF 4
                END IF;-- FIN IF 3
            ELSE 
                mensaje_vi := 'Esta persona ya posee un Ingreso en el sistema.';
            END IF;-- FIN IF 2
	END IF;--FIN IF 1
	RETURN mensaje_vi;
END; 
$BODY$  LANGUAGE plpgsql;
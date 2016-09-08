	/*
CREATE OR REPLACE FUNCTION cargaMasiva()
RETURNS varchar AS $BODY$
   DECLARE
   BEGIN
   RETURN mensaje;

END; 
$BODY$  LANGUAGE plpgsql;
*/


CREATE OR REPLACE FUNCTION cargaMasivaIngresos(
    idUsuario_vi int,
    origen_vi char,
    cedulaIdentidad_vi bigint,
    nroContrato_vi bigint,
    fechaIngreso_vi date,
    nombres_vi varchar,
    apellidos_vi varchar,
    correoPersonal_vi varchar,
    telefonoFijo_vi varchar,
    telefonoCelular_vi varchar,
    fechaNacimiento_vi date,
    estado_vi varchar,
    municipio_vi varchar,
    categoriaIngreso_vi varchar,
    tipoCargoNominal_vi varchar,
    cargoNominal_vi varchar,
    estructuraOrganizativa_vi varchar,
    condicionNominal_vi varchar,
    tipoNomina_vi varchar,
    banco_vi varchar,
    tipoCuenta_vi varchar,
    tipoSerialCuenta_vi varchar,
    nroCuenta_vi bigint,
    codigoPlantel_vi varchar,
    observacion_vi varchar
)
RETURNS varchar AS $BODY$
    DECLARE
        --Validar Existencia:
        existenciaCedula int := 0;
        existenciaUsuarioNomina int := 0;
        existenciaCedulaTH int := 0;

        --ID
        talentoHumanoId int;
        estadoId int;
        municipioId int;
        categoriaIngresoId int;
        tipoCargoNominalId int;
        cargoNominalId int;
        estructuraOrganizativaId int;
        condicionNominalId int;
        tipoNominaId int;
        bancoId int;
        tipoCuentaId int;
        tipoSerialCuentaId int;
        codigoPlantelId int;
       
        --Valores 
        nombreCompleto_vi varchar := nombres_vi||' '||apellidos_vi;
        sexo_vi CHAR;
        estado varchar := 'CORRECTO';
        verificarSaime varchar := 'Si';

    BEGIN
        --Validar que tiene permisos el usuario
        SELECT COUNT(1) FROM seguridad.usergroups_user as usuario LEFT JOIN seguridad.usergroups_group as grupo ON usuario.group_id = grupo.id WHERE (grupo.groupname ='NOMINA' AND usuario.id = idUsuario_vi ) OR (1 = idUsuario_vi) LIMIT 1
        INTO existenciaUsuarioNomina;
        IF existenciaUsuarioNomina != 0 THEN 
            
            --Validar que existe la cedula en el SAIME
            SELECT COUNT(1) FROM auditoria.saime WHERE cedula = cedulaIdentidad_vi and origen = origen_vi
            INTO existenciaCedula;
            IF existenciaCedula IS NOT NULL THEN
                --Variable Sexo.
                SELECT sexo INTO sexo_vi FROM  auditoria.saime WHERE cedula = cedulaIdentidad_vi AND origen = origen_vi LIMIT 1;

                --Transformar variables CHAR a ID
                SELECT id INTO estadoId FROM public.estado WHERE nombre = estado_vi;
                SELECT id INTO municipioId FROM public.municipio WHERE nombre = municipio_vi;
                SELECT id INTO categoriaIngresoId FROM gestion_humana.categoria_ingreso WHERE nombre = categoriaIngreso_vi;
                SELECT id INTO tipoCargoNominalId FROM gestion_humana.tipo_cargo_nominal WHERE nombre = tipoCargoNominal_vi;
                SELECT id INTO CargoNominalId FROM gestion_humana.cargo_nominal WHERE nombre = CargoNominal_vi;
                SELECT id INTO estructuraOrganizativaId FROM gestion_humana.estructura_organizativa WHERE nombre = estructuraOrganizativa_vi;
                SELECT id INTO condicionNominalId FROM gestion_humana.condicion_nominal WHERE nombre = condicionNominal_vi;
                SELECT id INTO tipoNominaId FROM gestion_nomina.tipo_nomina WHERE nombre = tipoNomina_vi;
                SELECT id INTO bancoId FROM administrativo.banco WHERE nombre = banco_vi;
                SELECT id INTO tipoCuentaId FROM administrativo.tipo_cuenta WHERE nombre = tipoCuenta_vi;
                SELECT id INTO tipoSerialCuentaId FROM administrativo.tipo_serial_cuenta WHERE nombre = tipoSerialCuenta_vi;
                SELECT id INTO codigoPlantelId FROM gplantel.plantel WHERE cod_plantel = codigoPlantel_vi;
                --FIN DE VARIABLES

                --Validar si existe la cedula en Talento Humano
                SELECT count(1) INTO existenciaCedulaTH FROM gestion_humana.talento_humano WHERE origen = origen_vi AND cedula = cedulaIdentidad_vi;
                IF existenciaCedulaTH IS NULL THEN 
                    INSERT INTO 
                        gestion_humana.talento_humano(
                        nombre,
                        apellido,
                        cedula,
                        origen,
                        fecha_nacimiento, 
                        telefono_fijo, 
                        telefono_celular, 
                        email_personal, 
                        estado_id, 
                        municipio_id,  
                        fecha_ingreso, 
                        categoria_ingreso_id, 
                        estructura_organizativa_actual_id, 
                        tipo_nomina_id, 
                        condicion_actual_id,  
                        tipo_cargo_actual_id, 
                        cargo_actual_id,  
                        plantel_actual_id,    
                        tipo_serial_cuenta_id,  
                        tipo_cuenta_id, 
                        banco_id, 
                        numero_cuenta, 
                        origen_titular,  
                        cedula_titular, 
                        nombre_titular, 
                        observacion,
                        usuario_ini_id,
                        sexo,
                        verificado_saime
                    )VALUES(
                        nombres_vi::varchar,
                        apellidos_vi::varchar,
                        cedulaIdentidad_vi::bigint,
                        origen_vi::char,
                        fechaNacimiento_vi::date,
                        telefonoFijo_vi::varchar,
                        telefonoCelular_vi::varchar,
                        correoPersonal_vi::varchar,
                        estadoId::int,
                        municipioId::int,
                        fechaIngreso_vi::date,
                        categoriaIngresoId::int,
                        estructuraOrganizativaId::int,
                        tipoNominaId::int,
                        condicionNominalId::int,
                        tipoCargoNominalId::int,
                        cargoNominalId::int,
                        codigoPlantelId::int,
                        tipoSerialCuentaId::int,
                        tipoCuentaId::int,
                        bancoId::int,
                        nroCuenta_vi::bigint,
                        origen_vi::char,
                        cedulaIdentidad_vi::bigint,
                        nombreCompleto_vi::varchar,
                        observacion_vi::varchar,
                        idUsuario_vi::int,
                        sexo_vi::char,
                        verificarSaime::varchar
                    ); 
                ELSE 
                    UPDATE 
                        gestion_humana.talento_humano 
                    SET 
			categoria_ingreso_id = categoriaIngresoId::int,
			tipo_cargo_actual_id = tipoCargoNominalId::int,
			cargo_actual_id = cargoNominalId::int,
                        estructura_organizativa_actual_id = estructuraOrganizativaId::int,
			condicion_actual_id = condicionNominalId::int,
			tipo_nomina_id = tipoNominaId::int,
			plantel_actual_id = codigoPlantelId::int,
			observacion = observacion_vi::varchar,
			verificado_saime = verificarSaime::varchar 


			
                    WHERE 
                        origen = origen_vi AND 
                        cedula = cedulaIdentidad_vi;
                END IF;--Talento Humano
                SELECT id INTO talentoHumanoId FROM gestion_humana.talento_humano WHERE origen = origen_vi AND cedula = cedulaIdentidad_vi;
                

            --Ingresar Empleado TRAZA
            INSERT INTO gestion_humana.ingreso_empleado(
                nro_contrato,
                fecha_ingreso,
                talento_humano_id,
                categoria_ingreso_id,
                tipo_cargo_nominal_id ,
                cargo_nominal_id ,
                estructura_organizativa_id ,
                condicion_nominal_id ,
                tipo_nomina_id ,
                plantel_id ,
                observaciones,
                usuario_ini_id
            )VALUES(
                nroContrato_vi::bigint, 
                fechaIngreso_vi::date, 
                talentoHumanoId::int, 
                categoriaIngresoId::int, 
                tipoCargoNominalId::int, 
                cargoNominalId::int, 
                estructuraOrganizativaId::int, 
                condicionNominalId::int, 
                tipoNominaId::int, 
                codigoPlantelId::int, 
                observacion_vi::text,
                idUsuario_vi::int
            ); 
            --Validar campos

            --
            END IF;--SAIME	
        ELSE
            estado := 'No tiene permisos para hacer esto.';
        END IF;--USUARIO
    RETURN estado;
    
    EXCEPTION
    WHEN OTHERS THEN 
        estado := 'ERROR';
    RETURN estado;
END; 
$BODY$  LANGUAGE plpgsql;

SELECT cargaMasiva(
    1::int,	--	idUsuario_vi int,
    'E'::char,	--	origen_vi char,
    82282165::bigint,	--	cedulaIdentidad_vi bigint,
    123123123::bigint,	--	nroContrato_vi bigint,
    '2015/01/16'::date,	--	fechaIngreso_vi date,
    'Daniel Felipe'::varchar,	--	nombres_vi varchar,
    'Ruiz Avella'::varchar,	--	apellidos_vi varchar,
    'danyruiz_2@hotmail.com'::varchar,	--	correoPersonal_vi varchar,
    '(0244)3223021'::varchar,	--	telefonoFijo_vi bigint,
    '(0412)8450998'::varchar,	--	telefonoCelular_vi bigint,
    '1991/06/20'::date,	--	fechaNacimiento_vi date,
    'ARAGUA'::varchar,	--	estado_vi int,
    'JOSE FELIX RIBAS'::varchar,	--	municipio_vi int,
    'Honorarios Profesionales'::varchar,	--	categoriaIngreso_vi int,
    'Bachiller'::varchar,	--	tipoCargoNominal_vi int,
    'Gerente General'::varchar,	--	cargonominal_vi int,
    'Gerencia General'::varchar,	--	estructuraOrganizativa_vi int,
    'Fijo 99'::varchar,	--	condicionNominal_vi int,
    'Nómina Cuenta Social'::varchar,	--	tipoNomina int,
    'Banco Bicentenario'::varchar,	--	banco_vi int,
    'AHORRO'::varchar,	--	tipoCuenta_vi int,
    'Social'::varchar,	--	tipoSerialCuenta_vi int,
    123123123::bigint,	--	nroCuenta_vi int,
    'PD00472203'::varchar,	--	codigoPlantel_vi int,
    'no tengo nada que agregar'::varchar	--	observacion_vi varchar
);

/*
CREATE OR REPLACE FUNCTION capturarId(
    tabla varchar, 
    campo varchar, 
    valor
)
RETURNS int AS $BODY$
    DECLARE
        id int;
        mensaje varchar;
    BEGIN
        SELECT count(id) FROM tabla WHERE campo = valor INTO id;
        IF id IS NOT NULL THEN
            SELECT id FROM tabla WHERE campo = valor INTO id;
            RAISE NOTICE 'Id encontrada';
        ELSE
            RAISE NOTICE 'No se pudo encontrar la id';
        END IF;
    RETURN id;
END; 
$BODY$  LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ingresos(
    nroContrato_vi bigint,
    fechaIngreso_vi date,
    talentoHumanoId_vi int,
    categoriaIngresoId_vi int,
    tipoCargoNominalId_vi int,
    cargoNominalId_vi int,
    estructuraOrganizativaId_vi int,
    condicionNominalId_vi int,
    tipoNominaId_vi int,
    plantelId_vi int,
    observaciones_vi text,
    usuarioIniId int
)
RETURNS varchar AS $BODY$
   DECLARE
   mensaje varchar := 'SE GUARDO CON EXITO.';
   BEGIN
   
    INSERT INTO gestion_humana.ingreso_empleado(
            nro_contrato,
            fecha_ingreso,
            talento_humano_id,
            categoria_ingreso_id,
            tipo_cargo_nominal_id ,
            cargo_nominal_id ,
            estructura_organizativa_id ,
            condicion_nominal_id ,
            tipo_nomina_id ,
            plantel_id ,
            observaciones,
            usuario_ini_id
        )VALUES(
            nroContrato_vi::bigint,
            fechaIngreso_vi::date,
            talentoHumanoId_vi::int,
            categoriaIngresoId_vi::int,
            tipoCargoNominalId_vi::int,
            cargoNominalId_vi::int,
            estructuraOrganizativaId_vi::int,
            condicionNominalId_vi::int,
            tipoNominaId_vi::int,
            plantelId_vi::int,
            observaciones_vi::text,
            usuarioIniId::int
        ); 
    RETURN mensaje;

END; 
$BODY$  LANGUAGE plpgsql;


--DROP FUNCTION ingresos( nroContrato_vi bigint,fechaIngreso_vi date, talentoHumanoId_vi int, categoriaIngresoId_vi int, tipoCargoNominalId_vi int, cargoNominalId_vi int, estructuraOrganizativaId_vi int, condicionNominalId_vi int,tipoNominaId_vi int, plantelId_vi int, observaciones_vi text);


--SELECT * FROM gestion_humana.estructura_organizativa limit 10;
*/
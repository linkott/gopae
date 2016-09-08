--DROP TYPE matricula.estudiante_matriculado;

CREATE TYPE matricula.estudiante_matriculado AS (
    existe_estudiante smallint,
    inscrito_periodo_actual smallint,
    mensaje_resultado text,
    id_estud integer,
    origen_estud character varying(1),
    identificacion_estud character varying(20),
    nombres_estud character varying(120),
    apellidos_estud character varying(120),
    cedula_representante character varying(20),
    fecha_nacimiento_estud date,
    cod_plantel character varying(15), 
    nombre_plantel character varying(150), 
    cod_plantel_actual character varying(15), 
    nombre_plantel_actual character varying(150),
    grado_estud character varying(80), 
    seccion_estud character varying(1),
    periodo_matriculacion_id integer,
    periodo_indicado character varying(20),
    consecutivo_grado_anterior integer,
    consecutivo_grado_inscripcion integer,
    error smallint
);

-- Function: matricula.estudiante_matriculado_x_identificacion(character varying, character varying, character varying, character varying, integer, integer, integer)

-- DROP FUNCTION matricula.estudiante_matriculado_x_identificacion(character varying, character varying, character varying, character varying, integer, integer, integer);

CREATE OR REPLACE FUNCTION matricula.estudiante_matriculado_x_identificacion(
    busqueda_vi character varying,
    cedula_representante_vi character varying,
    nombres_vi character varying,
    apellidos_vi character varying,
    grado_incripcion_id_vi integer,
    nivel_id_vi integer,
    periodo_id_vi integer
)
RETURNS SETOF matricula.estudiante_matriculado AS
$BODY$
  DECLARE
    seccionCod SMALLINT := 0;

    busquedaValida SMALLINT := 0;
    existePeriodo SMALLINT := 0;
    busquedaXNombre SMALLINT := 0;
    existeEstudiante INTEGER := 0;
    existeGrado SMALLINT := 0;
    inscritoPeriodoActual SMALLINT := 0;
    error SMALLINT := 0;
    mensajeResultado TEXT := 'No se han suministrado los datos necesarios para efectuar esta acción';

    idEstud matricula.estudiante.id%TYPE;
    origenEstud matricula.estudiante.tdocumento_identidad%TYPE;
    cedulaEstud matricula.estudiante.documento_identidad%TYPE;
    cedulaEscolarEstud matricula.estudiante.cedula_escolar%TYPE;
    nombresEstud matricula.estudiante.nombres%TYPE;
    apellidosEstud matricula.estudiante.apellidos%TYPE;
    fechaNacimientoEstud matricula.estudiante.fecha_nacimiento%TYPE;
    nombrePlantel gplantel.plantel.nombre%TYPE;
    codPlantel gplantel.plantel.cod_plantel%TYPE;
    nombrePlantelActual gplantel.plantel.nombre%TYPE;
    codPlantelActual gplantel.plantel.cod_plantel%TYPE;
    seccionEstud gplantel.seccion.nombre%TYPE;
    gradoEstud gplantel.grado.nombre%TYPE;
    periodoIndicado gplantel.periodo_escolar.periodo%TYPE;

    consecutivoGradoAnterior gplantel.grado.consecutivo%TYPE;
    existeGradoInscripcion gplantel.grado.consecutivo%TYPE;
    consecutivoGradoInscripcion gplantel.grado.consecutivo%TYPE;

    identificacionEstud matricula.estudiante.documento_identidad%TYPE;

    estudianteRec matricula.estudiante_matriculado%rowtype;

  BEGIN
    seccionCod := 1;

    SELECT COUNT(1) INTO busquedaValida WHERE busqueda_vi IN ('NOMBRE', 'REPRESENTANTE');

    SELECT COUNT(1) INTO existePeriodo FROM gplantel.periodo_escolar pr WHERE pr.id = periodo_id_vi;
    IF (existePeriodo>0) THEN
        SELECT pr.periodo INTO periodoIndicado FROM gplantel.periodo_escolar pr WHERE pr.id = periodo_id_vi;
    END IF;

    SELECT COUNT(1) INTO existeGrado FROM gplantel.grado g WHERE g.id = grado_incripcion_id_vi;
    IF (existeGrado>0) THEN
        SELECT g.consecutivo INTO consecutivoGradoInscripcion  FROM gplantel.grado g WHERE g.id = grado_incripcion_id_vi;
    END IF;

    IF (busquedaValida=1) THEN -- FIN ORIENGEN O TIPO DE DOCUMENTO VÁLIDO
        seccionCod := 2;
       
        SELECT COUNT(1) INTO busquedaXNombre WHERE busqueda_vi = 'NOMBRE';
        IF (busquedaXNombre=1) THEN -- SE EFECTUARÁ LA CONSULTA DE LOS DATOS DEL ESTUDIANTE POR NOMBRES Y APELLIDOS DEL ESTUDIANTE
        seccionCod := 3;
            SELECT COUNT(1) INTO existeEstudiante FROM matricula.estudiante WHERE busqueda @@ plainto_tsquery('pg_catalog.spanish', nombres_vi||' '||apellidos_vi);
            IF (existeEstudiante>0) THEN
                seccionCod := 4;
                IF nivel_id_vi > 2 THEN
                    FOR estudianteRec IN 
                        SELECT 
                            1 AS existe_estudiante,
                            CASE WHEN i.id IS NOT NULL THEN 1 ELSE 0 END AS inscrito_periodo_actual,
                            CASE WHEN i.id IS NOT NULL THEN 'El estudiante ya se encuentra matriculado.' ELSE 'Puede ser matriculado' END AS mensaje_resultado,
                            e.id AS id_estud,
                            CASE WHEN e.documento_identidad IS NOT NULL THEN e.tdocumento_identidad ELSE 'C' END AS origen_estud,
                            COALESCE(e.documento_identidad, e.cedula_escolar) AS identificacion_estud,
                            e.nombres AS nombres_estud,
                            e.apellidos AS apellidos_estud,
                            cedula_representante_vi AS cedula_representante,
                            e.fecha_nacimiento AS fecha_nacimiento_estud,
                            p.cod_plantel,
                            p.nombre AS nombre_plantel,
                            pa.cod_plantel AS cod_plantel_actual,
                            pa.nombre AS nombre_plantel_actual,
                            COALESCE(g.nombre, ga.nombre) AS grado_estud,
                            s.nombre AS seccion_estud,
                            periodo_id_vi AS periodo_matriculacion_id,
                            periodoIndicado AS periodo_indicado,
                            ga.consecutivo AS consecutivo_grado_anterior,
                            consecutivoGradoInscripcion AS consecutivo_grado_incripcion,
                            0 AS error
                        FROM matricula.estudiante e
                        LEFT JOIN matricula.inscripcion_estudiante i ON i.estudiante_id = e.id AND i.periodo_id = periodo_id_vi
                        LEFT JOIN gplantel.grado ga ON e.grado_actual_id = ga.id AND (ga.consegutivo = consecutivoGradoInscripcion-1 OR ga.consegutivo = consecutivoGradoInscripcion))
                        LEFT JOIN gplantel.plantel pa ON pa.id = e.plantel_actual_id
                        LEFT JOIN gplantel.plantel p ON p.id = i.plantel_id
                        LEFT JOIN gplantel.grado g ON g.id = i.grado_id
                        LEFT JOIN gplantel.seccion_plantel_periodo spp ON spp.id = i.seccion_plantel_periodo_id
                        LEFT JOIN gplantel.seccion_plantel sp ON sp.id = spp.seccion_plantel_id
                        LEFT JOIN gplantel.seccion s ON s.id = sp.seccion_id
                       WHERE e.busqueda @@ plainto_tsquery('pg_catalog.spanish', nombres_vi||' '||apellidos_vi) 
                    LOOP
                        RETURN NEXT estudianteRec;
                    END LOOP;
                ELSE
                    FOR estudianteRec IN 
                        SELECT
                            1 AS existe_estudiante,
                            CASE WHEN i.id IS NOT NULL THEN 1 ELSE 0 END AS inscrito_periodo_actual,
                            CASE WHEN i.id IS NOT NULL THEN 'El estudiante ya se encuentra matriculado.' ELSE 'Puede ser matriculado' END AS mensaje_resultado,
                            e.id AS id_estud,
                            CASE WHEN e.documento_identidad IS NOT NULL THEN e.tdocumento_identidad ELSE 'C' END AS origen_estud,
                            COALESCE(e.documento_identidad, e.cedula_escolar) AS identificacion_estud,
                            e.nombres AS nombres_estud,
                            e.apellidos AS apellidos_estud,
                            cedula_representante_vi AS cedula_representante,
                            e.fecha_nacimiento AS fecha_nacimiento_estud,
                            p.cod_plantel,
                            p.nombre AS nombre_plantel,
                            pa.cod_plantel AS cod_plantel_actual,
                            pa.nombre AS nombre_plantel_actual,
                            COALESCE(g.nombre, ga.nombre) AS grado_estud,
                            s.nombre AS seccion_estud,
                            periodo_id_vi AS periodo_matriculacion_id,
                            periodoIndicado AS periodo_indicado,
                            ga.consecutivo AS consecutivo_grado_anterior,
                            consecutivoGradoInscripcion AS consecutivo_grado_incripcion,
                            0 AS error
                        FROM matricula.estudiante e
                        LEFT JOIN matricula.inscripcion_estudiante i ON i.estudiante_id = e.id AND i.periodo_id = periodo_id_vi
                        LEFT JOIN gplantel.grado ga ON e.grado_actual_id = ga.id AND 
                        LEFT JOIN gplantel.plantel pa ON pa.id = e.plantel_actual_id
                        LEFT JOIN gplantel.plantel p ON p.id = i.plantel_id
                        LEFT JOIN gplantel.grado g ON g.id = i.grado_id
                        LEFT JOIN gplantel.seccion_plantel_periodo spp ON spp.id = i.seccion_plantel_periodo_id
                        LEFT JOIN gplantel.seccion_plantel sp ON sp.id = spp.seccion_plantel_id
                        -- LEFT JOIN gplantel.nivel n ON sp.nivel_id = n.nivel_id AND 
                        LEFT JOIN gplantel.seccion s ON s.id = sp.seccion_id
                       WHERE e.busqueda @@ plainto_tsquery('pg_catalog.spanish', nombres_vi||' '||apellidos_vi) AND ((nivel_id_vi = 1 AND EXTRACT(year from AGE(e.fecha_nacimiento))<6) OR (nivel_id_vi = 2 AND EXTRACT(year from AGE(e.fecha_nacimiento))<16))
                    LOOP
                        RETURN NEXT estudianteRec;
                    END LOOP;
                END IF;
            ELSE
                origenEstud := origen_vi;
                identificacionEstud := identificacion_vi;
                mensajeResultado := 'El Estudiante no se encuentra registrado en nuestra base de datos';
            END IF;
           
        ELSE -- SE EFECTUARÁ LA CONSULTA DE LOS DATOS DEL ESTUDIANTE POR DOCUMENTO DE IDENTIDAD DEL REPRESENTANTE
            seccionCod := 5;
           
        END IF; -- FIN EXISTE CONSULTA POR IDENTIFICACION VALIDA
   
    END IF; -- FIN ORIENGEN O TIPO DE DOCUMENTO VÁLIDO

    seccionCod := 11;
    
    IF (existeEstudiante=0) THEN
        SELECT existeEstudiante, inscritoPeriodoActual, mensajeResultado, idEstud,
                origenEstud, identificacionEstud, nombresEstud,
                apellidosEstud, fechaNacimientoEstud, codPlantel, nombrePlantel, codPlantelActual,
                nombrePlantelActual,gradoEstud, seccionEstud, consecutivoGradoAnterior,
                consecutivoGradoInscripcion, periodoIndicado, error
           INTO estudianteRec;
         RETURN NEXT estudianteRec;
    END IF;

EXCEPTION
    WHEN others THEN
        mensajeResultado := 'Ha ocurrido un error '||SQLERRM||' (ERROR NRO: '||SQLSTATE||') (SECCIÓN: '||seccionCod||')';
        error := 1;
        SELECT existeEstudiante, inscritoPeriodoActual, mensajeResultado, idEstud,
               origenEstud, identificacionEstud, nombresEstud,
               apellidosEstud, fechaNacimientoEstud, codPlantel, nombrePlantel, codPlantelActual,
               nombrePlantelActual,gradoEstud, seccionEstud, consecutivoGradoAnterior,
               consecutivoGradoInscripcion, periodoIndicado, error
          INTO estudianteRec;
        RETURN NEXT estudianteRec;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION matricula.estudiante_matriculado_x_identificacion(character varying, character varying, character varying, character varying, integer, integer, integer)
  OWNER TO postgres;

-- TEST SQL

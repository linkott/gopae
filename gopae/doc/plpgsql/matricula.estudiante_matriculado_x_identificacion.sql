--DROP FUNCTION matricula.estudiante_matriculado_x_identificacion(character, character varying, integer, integer);
CREATE OR REPLACE FUNCTION matricula.estudiante_matriculado_x_identificacion(
    origen_vi character,
    identificacion_vi character varying,
    grado_incripcion_id_vi integer,
    periodo_id_vi integer
)
RETURNS record AS
$BODY$
  DECLARE
    seccionCod SMALLINT := 0;

    origenValido SMALLINT := 0;
    origenEscolar SMALLINT := 0;
    existeEstudiante SMALLINT := 0;
    inscritoPeriodoActual SMALLINT := 0;
    cantPeriodoIndicado SMALLINT := 0;

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
    
    estudianteRec RECORD;

  BEGIN
    seccionCod := 1;
    IF origen_vi IN ('V','E','C','P') THEN -- FIN ORIENGEN O TIPO DE DOCUMENTO VÁLIDO
        seccionCod := 2;
        IF (origen_vi = 'C') THEN -- SE EFECTUARÁ LA CONSULTA DE LOS DATOS DEL ESTUDIANTE POR CÉDULA ESCOLAR
	    seccionCod := 3;
            SELECT COUNT(1) INTO existeEstudiante FROM matricula.estudiante WHERE cedula_escolar=identificacion_vi::TEXT;
            IF (existeEstudiante>0) THEN
                seccionCod := 4;
                SELECT e.id, origen_vi, e.documento_identidad, e.cedula_escolar, e.nombres, 
                       e.apellidos, e.fecha_nacimiento, g.consecutivo
                  INTO idEstud, origenEstud, cedulaEstud, cedulaEscolarEstud, nombresEstud, 
                       apellidosEstud, fechaNacimientoEstud, consecutivoGradoAnterior
                  FROM matricula.estudiante e 
                  LEFT JOIN gplantel.grado g ON e.grado_actual_id = g.id
                 WHERE cedula_escolar=identificacion_vi::TEXT
                 LIMIT 1;
                 identificacionEstud := cedulaEscolarEstud;
            ELSE
                origenEstud := origen_vi;
                identificacionEstud := identificacion_vi;
                mensajeResultado := 'El Estudiante no se encuentra registrado en nuestra base de datos';
            END IF;
            
        ELSE -- SE EFECTUARÁ LA CONSULTA DE LOS DATOS DEL ESTUDIANTE POR DOCUMENTO DE IDENTIDAD
            seccionCod := 5;
            SELECT COUNT(1) INTO existeEstudiante FROM matricula.estudiante WHERE documento_identidad=identificacion_vi::TEXT AND (nacionalidad=origen_vi::TEXT OR tdocumento_identidad=origen_vi::TEXT);
            IF (existeEstudiante>0) THEN
		seccionCod := 6;
                SELECT e.id, e.tdocumento_identidad, e.documento_identidad, e.cedula_escolar, e.nombres, 
                       e.apellidos, e.fecha_nacimiento, g.consecutivo, pa.cod_plantel, pa.nombre
                  INTO idEstud, origenEstud, cedulaEstud, cedulaEscolarEstud, nombresEstud, 
                       apellidosEstud, fechaNacimientoEstud, consecutivoGradoAnterior, codPlantelActual,
                       nombrePlantelActual
                  FROM matricula.estudiante e 
                  LEFT JOIN gplantel.grado g ON e.grado_actual_id = g.id
                  LEFT JOIN gplantel.plantel pa ON e.plantel_actual_id = pa.id
                 WHERE documento_identidad=identificacion_vi::TEXT 
                   AND (nacionalidad=origen_vi::TEXT OR tdocumento_identidad=origen_vi::TEXT)
                 LIMIT 1;
                identificacionEstud := cedulaEstud;
                
                SELECT COUNT(1) INTO cantPeriodoIndicado FROM gplantel.periodo_escolar pr WHERE pr.id = periodo_id_vi;

                IF (cantPeriodoIndicado>0) THEN
                    SELECT pr.periodo INTO periodoIndicado FROM gplantel.periodo_escolar pr WHERE pr.id = periodo_id_vi;
                END IF;

            ELSE
                origenEstud := origen_vi;
                identificacionEstud := identificacion_vi;
                mensajeResultado := 'El Estudiante no se encuentra registrado en nuestra base de datos';
            END IF;
        END IF; -- FIN EXISTE CONSULTA POR IDENTIFICACION VALIDA
    
        IF (existeEstudiante>0) THEN -- EXISTE EL ESTUDIANTE PARA MATRICULAR
            seccionCod := 7;
            SELECT COUNT(1)
              INTO inscritoPeriodoActual
              FROM matricula.estudiante e
             INNER JOIN matricula.inscripcion_estudiante i ON i.estudiante_id = e.id AND i.periodo_id = periodo_id_vi
             -- INNER JOIN gplantel.plantel p ON p.id = i.plantel_id
             -- INNER JOIN gplantel.grado g ON g.id = i.grado_id
             -- INNER JOIN gplantel.seccion_plantel_periodo spp ON spp.id = i.seccion_plantel_periodo_id
             -- INNER JOIN gplantel.seccion_plantel sp ON sp.id = spp.seccion_plantel_id
             -- INNER JOIN gplantel.seccion s ON s.id = sp.seccion_id
             WHERE e.id = idEstud
             LIMIT 1;

            IF inscritoPeriodoActual>0 THEN
                seccionCod := 8;
                SELECT p.cod_plantel, p.nombre, g.nombre, s.nombre, pa.cod_plantel, pa.nombre, pr.periodo
                  INTO codPlantel, nombrePlantel, gradoEstud, seccionEstud, codPlantelActual, nombrePlantelActual, periodoIndicado
                  FROM matricula.estudiante e
                 INNER JOIN matricula.inscripcion_estudiante i ON i.estudiante_id = e.id AND i.periodo_id = periodo_id_vi
                  LEFT JOIN gplantel.periodo_escolar pr ON pr.id = i.periodo_id
                  LEFT JOIN gplantel.plantel p ON p.id = i.plantel_id
                  LEFT JOIN gplantel.plantel pa ON e.plantel_actual_id = pa.id
                  LEFT JOIN gplantel.grado g ON g.id = i.grado_id
                  LEFT JOIN gplantel.seccion_plantel_periodo spp ON spp.id = i.seccion_plantel_periodo_id
                  LEFT JOIN gplantel.seccion_plantel sp ON sp.id = spp.seccion_plantel_id
                  LEFT JOIN gplantel.seccion s ON s.id = sp.seccion_id
                 WHERE e.id = idEstud
                 LIMIT 1;

                mensajeResultado := 'El Estudiante (<b>'||replace(origen_vi, 'C', 'C.E.')||'-'||identificacion_vi||'</b>) <b>'||nombresEstud||' '||apellidosEstud||'</b> se encuentra matriculado en el período '||periodoIndicado||' en el plantel <b>('||codPlantel||') '||nombrePlantel||'</b> en '||gradoEstud||' sección <b>'||seccionEstud||'</b>.';

            ELSE
                mensajeResultado := 'El Estudiante no se encuentra matriculado en el período indicado.';
            END IF;

	    seccionCod := 9;
            SELECT COUNT(1) INTO existeGradoInscripcion FROM gplantel.grado WHERE id = grado_incripcion_id_vi;
            IF (existeGradoInscripcion>0) THEN
                seccionCod := 10;
                SELECT consecutivo INTO consecutivoGradoInscripcion FROM gplantel.grado WHERE id = grado_incripcion_id_vi;
            END IF;

        END IF; -- FIN EXISTE EL ESTUDIANTE PARA MATRICULAR

    END IF; -- FIN ORIENGEN O TIPO DE DOCUMENTO VÁLIDO

    seccionCod := 11;

    SELECT existeEstudiante, inscritoPeriodoActual, mensajeResultado, idEstud,
           origenEstud, identificacionEstud, nombresEstud,
           apellidosEstud, fechaNacimientoEstud, codPlantel, nombrePlantel, codPlantelActual,
           nombrePlantelActual, gradoEstud, seccionEstud, consecutivoGradoAnterior,
           consecutivoGradoInscripcion, periodoIndicado, error
      INTO estudianteRec;
    RETURN estudianteRec;

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
        RETURN estudianteRec;
END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;

-- TEST SQL
SELECT * FROM matricula.estudiante_matriculado_x_identificacion(
    'V', -- Origen ('V', 'E', 'C')
    '24843413', -- Documento de Identidad o Cédula Escolar
    13, -- GRADO_INSCRIPCION_ID
    15 -- PERIODO_ID
    ) AS 
    f("existeEstudiante" smallint,
      "inscritoPeriodoActual" smallint,
      "mensajeResultado" text,
      "idEstud" integer,
      "origenEstud" character varying(1),
      "identificacionEstud" character varying(20),
      "nombresEstud" character varying(120),
      "apellidosEstud" character varying(120),
      "fechaNacimientoEstud" date,
      "codPlantel" character varying(15), 
      "nombrePlantel" character varying(150), 
      "codPlantelActual" character varying(15), 
      "nombrePlantelActual" character varying(150), 
      "gradoEstud" character varying(80), 
      "seccionEstud" character varying(1),
      "consecutivoGradoAnterior" integer,
      "consecutivoGradoInscripcion" integer,
      "periodoIndicado" character varying(20),
      "error" smallint
     );

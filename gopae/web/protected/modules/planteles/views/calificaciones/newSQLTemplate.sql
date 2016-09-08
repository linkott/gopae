
DECLARE
cant_asignaturas integer;
indice integer;
vcalif_cuantitativa integer;
vasistencia integer,
vasignatura_estudiante_id integer;
vinfluye_en_promedio integer;
fecha_v timestamp;

BEGIN
indice := 1;
cant_asignaturas := array_length(asignaturas, 1);

FOR indice IN 1..cant_asignaturas LOOP

    vcalif_cuantitativa = notas[indice];
    vasistencia = asistencia[indice];
    vasignatura_estudiante_id = asignaturas[indice]; 
    vinfluye_en_promedio = influye[indice];
    fecha_v := (now())::timestamp(0);

    INSERT INTO matricula.calificacion_asignatura_estudiante(asignatura_estudiante_id, lapso,
            calif_cuantitativa, influye_en_promedio, usuario_ini_id,estatus, asistencia, fecha_ini)
        VALUES
            (vasignatura_estudiante_id, vlapso,vcalif_cuantitativa, vinfluye_en_promedio, vusuario_id, 'A', vasistencia, fecha_v);

END LOOP;

return 'Todo Bien'::text;
EXCEPTION WHEN others THEN
--     WHEN not_null_violation THEN
--         RAISE EXCEPTION 'Todos los campos son requeridos';
--     WHEN foreign_key_violation THEN
--         RAISE EXCEPTION '';
--     WHEN string_data_right_truncation THEN
--         RAISE EXCEPTION '';
--     WHEN unique_violation THEN
--         RAISE EXCEPTION '';
RAISE EXCEPTION 'ocurrio algo: % %',SQLERRM, SQLSTATE;

END;


SELECT
  th.origen, 
  th.cedula, 
  th.nombre_titular, 
  th.sexo, 
  th.fecha_nacimiento, 
  th.nombre, 
  th.apellido, 
  e.nombre AS estado, 
  th.numero_cuenta, 
  th.estatus, 
  th.fecha_ingreso, 
  th.fecha_egreso, 
  th.verificado_saime, 
  s.origen AS origen_saime, 
  s.cedula AS cedula_saime, 
  s.primer_nombre AS primer_nombre_saime, 
  s.segundo_nombre AS segundo_nombre_saime, 
  s.primer_apellido AS _saime, 
  s.segundo_apellido AS _saime, 
  ci.nombre AS categoria_ingreso, 
  cdn.nombre AS condicion_nominal, 
  tn.nombre AS tipo_nomina, 
  tcgn.nombre AS tipo_cargo, 
  cgn.nombre AS cargo, 
  tsc.nombre AS serial_cuenta, 
  tc.nombre AS cuenta, 
  b.nombre AS banco
FROM
  gestion_humana.talento_humano th
  LEFT JOIN auditoria.saime s ON th.origen = s.origen AND th.cedula = s.cedula
  LEFT JOIN gestion_humana.cargo_nominal cgn ON th.cargo_actual_id = cgn.id
  LEFT JOIN gestion_humana.tipo_cargo_nominal tcgn ON th.tipo_cargo_actual_id = tcgn.id
  LEFT JOIN gestion_humana.condicion_nominal cdn ON th.condicion_actual_id = cdn.id
  LEFT JOIN gestion_nomina.tipo_nomina tn ON th.tipo_nomina_id = tn.id
  LEFT JOIN administrativo.banco b ON th.banco_id = b.id
  LEFT JOIN administrativo.tipo_cuenta tc ON th.tipo_cuenta_id = tc.id
  LEFT JOIN administrativo.tipo_serial_cuenta tsc ON th.tipo_serial_cuenta_id = tsc.id
  LEFT JOIN public.estado e ON th.estado_id = e.id
  LEFT JOIN gestion_humana.categoria_ingreso ci ON th.categoria_ingreso_id = ci.id
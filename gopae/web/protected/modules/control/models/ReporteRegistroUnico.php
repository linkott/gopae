<?php
/**
 * Created by PhpStorm.
 * User: nelson
 * Date: 11/03/15
 * Time: 03:31 PM
 */

class ReporteRegistroUnico extends CActiveRecord {

    public $cacheIndexRegUnico = 'A-REGISTRO-UNICO';
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.plantel';
    }
    
    /**
     * @author Jose Gabriel Gonzalez y Nelson Gonzalez
     * Este metodo permite obtener el reporte estadistico del registro unico del CNAE
     * 
     * @param string $level
     * @param integer $dependency_id
     * @return array
     */

    //$level: captura si es Region, Estado o Municipio
    public function reporteEstadisticoRegistroUnico($level, $dependency_id=null){

        $cacheIndex = $this->cacheIndexRegUnico.'A';
        $resultado = Yii::app()->cache->get($cacheIndex);
        
        if(!$resultado){
            $resultado = array();
            //$orderBy = 'titulo ASC, nombre ASC';
                
            if(in_array($level,array('region', 'estado', 'municipio')) && (is_null($dependency_id) || is_numeric($dependency_id))){
                if($level=='estado'){
                    $camposSeleccionados = "e.region_id AS region_id, r.nombre AS region, e.id AS id, e.nombre, 'AAA'||e.nombre AS titulo  ";
                    $camposSeleccionadosTotales = "$dependency_id AS region_id, 'X' AS region, 0 AS id, 'TOTAL' AS nombre , 'ZZZTOTAL' AS titulo";
                    $camposAgrupados = "e.region_id, r.nombre, e.id, e.nombre, titulo  ";
                    $where = 'e.id != 45 AND e.region_id = '.$dependency_id; // Excluye Dependencias Federales (Id=45)
                    $orderBy = 'titulo ASC, nombre ASC';
            }
            $sql = "SELECT  e.region_id AS region_id, r.nombre AS region, e.id AS id, e.nombre, 'AAA'||e.nombre AS titulo
                            , SUM(CASE WHEN (p.id IS NOT NULL) THEN 1 ELSE 0 END) AS planteles
                            , SUM(CASE WHEN (p.cod_cnae IS NOT NULL AND p.es_beneficiario_pae = 'SI' AND pp.matricula_general>0) THEN 1 ELSE 0 END) AS total_cnae
                            , (SELECT COUNT(DISTINCT ap.usuario_id) FROM gplantel.autoridad_plantel ap INNER JOIN gplantel.plantel ppa ON ppa.es_beneficiario_pae = 'SI' AND ap.plantel_id = ppa.id INNER JOIN seguridad.usergroups_user u ON ap.usuario_id = u.id WHERE u.presento_documento_identidad = 'SI' AND u.foto IS NOT NULL AND ap.cargo_id IN (3, 5, 27) AND ap.estatus = 'A' AND ppa.estado_id = e.id) AS autoridades_verificados
                            , (SELECT COUNT(DISTINCT ap.usuario_id) FROM gplantel.autoridad_plantel ap INNER JOIN gplantel.plantel ppa ON ppa.es_beneficiario_pae = 'SI' AND ap.plantel_id = ppa.id INNER JOIN seguridad.usergroups_user u ON ap.usuario_id = u.id WHERE u.presento_documento_identidad = 'SI' AND (u.foto IS NULL OR u.foto='') AND ap.cargo_id IN (3, 5, 27) AND ap.estatus = 'A' AND ppa.estado_id = e.id) AS autoridades_verificados_sin_foto
                            , (SELECT COUNT(th.id) FROM gestion_humana.talento_humano th WHERE th.estado_id = e.id AND th.estatus = 'E' AND th.tipo_cargo_actual_id = 11) AS cocineras_escolares
                            , (SELECT COUNT(c.id) FROM gplantel.cocinera_plantel c INNER JOIN gplantel.plantel pc ON c.plantel_id = pc.id WHERE pc.estado_id = e.id AND c.estatus = 'A') AS cocineras_escolares_asignadas
                            , SUM(CASE WHEN (p.cod_cnae IS NOT NULL AND pp.proveedor_actual_id = 5 AND p.es_beneficiario_pae = 'SI' AND pp.matricula_general>0) THEN 1 ELSE 0 END) AS beneficiados_x_mercal
                            , SUM(CASE WHEN (p.cod_cnae IS NOT NULL AND pp.proveedor_actual_id = 6 AND p.es_beneficiario_pae = 'SI' AND pp.matricula_general>0) THEN 1 ELSE 0 END) AS beneficiados_x_pdval
                            , SUM(CASE WHEN ( p.cod_cnae IS NOT NULL AND p.es_beneficiario_pae = 'SI' AND pp.matricula_general>0 AND (( pp.proveedor_actual_id != 6 AND pp.proveedor_actual_id != 5 ) OR ( pp.proveedor_actual_id IS NULL ))) THEN 1 ELSE 0 END) AS beneficiados_x_otros


                    FROM public.region r
                        INNER JOIN public.estado e
                            ON r.id = e.region_id
                        LEFT JOIN gplantel.plantel p
                            ON e.id = p.estado_id
                        LEFT JOIN gplantel.plantel_pae pp
                            ON pp.plantel_id = p.id
                        GROUP BY
                            e.region_id, r.nombre, e.id, e.nombre, titulo

                UNION

                SELECT  0 AS region_id, 'NACIONAL' AS region, 0 AS id, 'TOTAL', 'ZZZTOTAL' AS titulo
                            , SUM(CASE WHEN (p.id IS NOT NULL) THEN 1 ELSE 0 END) AS planteles
                            , SUM(CASE WHEN (p.cod_cnae IS NOT NULL AND p.es_beneficiario_pae = 'SI' AND pp.matricula_general>0) THEN 1 ELSE 0 END) AS total_cnae
                            , (SELECT COUNT(DISTINCT ap.usuario_id) FROM gplantel.autoridad_plantel ap INNER JOIN gplantel.plantel ppa ON ppa.es_beneficiario_pae = 'SI' AND ap.plantel_id = ppa.id INNER JOIN seguridad.usergroups_user u ON ap.usuario_id = u.id WHERE u.presento_documento_identidad = 'SI' AND u.foto IS NOT NULL AND ap.cargo_id IN (3, 5, 27) AND ap.estatus = 'A') AS autoridades_verificados
                            , (SELECT COUNT(DISTINCT ap.usuario_id) FROM gplantel.autoridad_plantel ap INNER JOIN gplantel.plantel ppa ON ppa.es_beneficiario_pae = 'SI' AND ap.plantel_id = ppa.id INNER JOIN seguridad.usergroups_user u ON ap.usuario_id = u.id WHERE u.presento_documento_identidad = 'SI' AND (u.foto IS NULL OR u.foto='') AND ap.cargo_id IN (3, 5, 27) AND ap.estatus = 'A') AS autoridades_verificados_sin_foto
                            , (SELECT COUNT(th.id) FROM gestion_humana.talento_humano th WHERE th.estatus = 'E' AND th.tipo_cargo_actual_id = 11) AS cocineras_escolares
                            , (SELECT COUNT(c.id) FROM gplantel.cocinera_plantel c INNER JOIN gplantel.plantel pc ON c.plantel_id = pc.id WHERE c.estatus = 'A') AS cocineras_escolares_asignadas
                            , SUM(CASE WHEN (p.cod_cnae IS NOT NULL AND pp.proveedor_actual_id = 5 AND p.es_beneficiario_pae = 'SI' AND pp.matricula_general>0) THEN 1 ELSE 0 END) AS beneficiados_x_mercal
                            , SUM(CASE WHEN (p.cod_cnae IS NOT NULL AND pp.proveedor_actual_id = 6 AND p.es_beneficiario_pae = 'SI' AND pp.matricula_general>0) THEN 1 ELSE 0 END) AS beneficiados_x_pdval
                            , SUM(CASE WHEN ( p.cod_cnae IS NOT NULL AND p.es_beneficiario_pae = 'SI' AND pp.matricula_general>0 AND (( pp.proveedor_actual_id != 6 AND pp.proveedor_actual_id != 5 ) OR ( pp.proveedor_actual_id IS NULL ))) THEN 1 ELSE 0 END) AS beneficiados_x_otros
                    FROM gplantel.plantel p
                        LEFT JOIN gplantel.plantel_pae pp
                            ON pp.plantel_id = p.id
                        ORDER BY
                            titulo ASC, nombre ASC";

                //echo "<pre><code>$sql</code></pre>"; die();
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $resultado = $command->queryAll();
                
                // if(is_array($resultado) && count($resultado)>0){
                //    Yii::app()->cache->set($cacheIndex, $resultado, 3600);
                // }
            }

        }
        else{
            $resultado = array();
        }

        return $resultado;

    }
    
    /**
     * 
     * Este Metodo proporciona el detalle del Reporte Estadistico para las columnas: "planteles", "total_cnae", "beneficiados_x_mercal", "beneficiados_x_pdval", "beneficiados_x_otros"
     * 
     * @author Jose Gabriel Gonzalez y Nelson Gonzalez
     * @param string $columna
     * @param integer $estadoId
     * @param integer $filas
     * @return array
     */
    public  function detalleRegistroUnicoPlanteles($columna,$estadoId,$filas=null){
        $resultado=array();
        $filtroEstado='';
        $filtroColumna='';
        $limiteFilas='';

        if(in_array($columna,array('planteles','total_cnae', 'beneficiados_x_mercal', 'beneficiados_x_pdval', 'beneficiados_x_otros',)) and is_numeric($estadoId) AND (is_null($filas) OR is_numeric($filas))){
            if($estadoId!='0'){
                $filtroEstado=' AND p.estado_id='.$estadoId;
            }

            if($columna=='planteles'){
                $filtroColumna=' AND p.id IS NOT NULL ';
            }elseif($columna=='total_cnae'){
                $filtroColumna=" AND p.cod_cnae IS NOT NULL AND p.es_beneficiario_pae = 'SI' AND pp.matricula_general>0 ";
            }elseif($columna=='beneficiados_x_mercal'){
                $filtroColumna=" AND p.cod_cnae IS NOT NULL AND pp.proveedor_actual_id = 5 AND pp.matricula_general>0";
            }elseif($columna=='beneficiados_x_pdval'){
                $filtroColumna=" AND p.cod_cnae IS NOT NULL AND pp.proveedor_actual_id = 6 AND pp.matricula_general>0";
            }elseif($columna=='beneficiados_x_otros'){
                //$filtroColumna=" AND p.cod_cnae IS NOT NULL AND pp.proveedor_actual_id != 6 AND pp.proveedor_actual_id != 5 ";
                $filtroColumna=" AND p.cod_cnae IS NOT NULL AND p.es_beneficiario_pae = 'SI' AND pp.matricula_general>0 AND
                                (( pp.proveedor_actual_id != 6 AND pp.proveedor_actual_id != 5) OR ( pp.proveedor_actual_id IS NULL)) ";
            }

            if(is_numeric($filas) AND (int)$filas>=0){
                $limiteFilas = ' LIMIT '.(int)$filas;
            }

            $sql="
             SELECT p.cod_plantel,
                  p.cod_estadistico,
                  p.nombre AS nombre_plantel,
                  p.annio_fundado,
                  p.cod_cnae,
                  p.codigo_ner,
                  p.registro_cnae,
                  p.es_beneficiario_pae,
                  d.nombre AS denominacion,
                  td.nombre AS dependencia,
                  e.nombre AS estado,
                  e.capital AS estado_capital,
                  m.nombre AS municipio,
                  m.capital AS municipio_capital,
                  pa.nombre AS parroquia,
                  z.nombre AS zona_educativa,
                  pp.pae_activo,
                  pv.abreviatura AS proveedor,
                  ts.nombre AS tipo_servicio_pae,
                  (SELECT string_agg(tm.nombre, ' | ') FROM gplantel.plantel_ingesta pi INNER JOIN nutricion.tipo_menu tm ON pi.tipo_ingesta_id = tm.id GROUP BY pi.plantel_id HAVING pi.plantel_id = p.id) AS ingestas,
                  pp.cantidad_madres_procesadoras,
                  pp.matricula_maternal,
                  pp.matricula_preescolar,
                  pp.matricula_educacion_primaria,
                  pp.matricula_educacion_media_general,
                  pp.matricula_educacion_tecnica,
                  pp.matricula_educacion_especial,
                  pp.matricula_docente_obrero,
                  pp.matricula_general,
                  u.origen AS origen_director,
                  u.cedula AS cedula_director,
                  u.apellido AS apellido_director,
                  u.nombre AS nombre_director,
                  u.telefono AS telefono_director,
                  u.email AS email_director,
                  (SELECT ec.origen FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 5 AND ap.estatus = 'A' LIMIT 1) AS origen_sub_director,
                  (SELECT ec.cedula FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 5 AND ap.estatus = 'A' LIMIT 1) AS cedula_sub_director,
                  (SELECT ec.apellido FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 5 AND ap.estatus = 'A' LIMIT 1) AS apellido_sub_director,
                  (SELECT ec.nombre FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 5 AND ap.estatus = 'A' LIMIT 1) AS nombre_sub_director,
                  (SELECT ec.telefono FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 5 AND ap.estatus = 'A' LIMIT 1) AS telefono_sub_director,
                  (SELECT ec.email FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 5 AND ap.estatus = 'A' LIMIT 1) AS email_sub_director,
                  (SELECT ec.origen FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A' LIMIT 1) AS origen_enlace_pae,
                  (SELECT ec.cedula FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A' LIMIT 1) AS cedula_enlace_pae,
                  (SELECT ec.apellido FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A' LIMIT 1) AS apellido_enlace_pae,
                  (SELECT ec.nombre FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A' LIMIT 1) AS nombre_enlace_pae,
                  (SELECT ec.telefono FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A' LIMIT 1) AS telefono_enlace_pae,
                  (SELECT ec.email FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A' LIMIT 1) AS email_enlace_pae
                FROM
                  gplantel.plantel p
                  LEFT JOIN gplantel.plantel_pae pp ON pp.plantel_id = p.id
                  LEFT JOIN public.estado e ON p.estado_id = e.id
                  LEFT JOIN gplantel.zona_educativa z ON p.zona_educativa_id = z.id
                  LEFT JOIN public.municipio m ON p.municipio_id = m.id
                  LEFT JOIN public.parroquia pa ON p.parroquia_id = pa.id
                  LEFT JOIN seguridad.usergroups_user u ON p.director_actual_id = u.id
                  LEFT JOIN gplantel.denominacion d ON p.denominacion_id = d.id
                  LEFT JOIN gplantel.tipo_dependencia td ON p.tipo_dependencia_id = td.id
                  LEFT JOIN gplantel.tipo_servicio_pae ts ON pp.tipo_servicio_pae_id = ts.id
                  LEFT JOIN proveduria.proveedor pv ON pp.proveedor_actual_id = pv.id
            WHERE 1=1 $filtroEstado $filtroColumna $limiteFilas";
            
            // echo "<pre><code>$sql</code></pre>"; die();
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $resultado = $command->queryAll();

        }

        return $resultado;
    }

    /**
     * 
     * Este Metodo proporciona el detalle del Reporte Estadistico para las columnas: "autoridades_verificados"
     * 
     * @author Jose Gabriel Gonzalez y Nelson Gonzalez
     * @param string $columna
     * @param integer $estadoId
     * @param integer $filas
     * @return array
     */
    public  function detalleRegistroUnicoAutoridades($columna,$estadoId,$filas=null){
        $resultado=array();
        $filtroEstado='';
        $filtroColumna='';
        $limiteFilas='';
        if(in_array($columna,array('autoridades_verificados','autoridades_verificados_sin_foto')) and is_numeric($estadoId) AND (is_null($filas) OR is_numeric($filas))){
            if($estadoId!='0'){
                $filtroEstado=" AND p.estado_id = $estadoId";
            }

            if($columna=='autoridades_verificados'){
                $filtroColumna=" AND p.es_beneficiario_pae = 'SI' AND u.presento_documento_identidad = 'SI' AND u.foto IS NOT NULL AND (p.director_actual_id IS NOT NULL OR p.subdirector_actual_id IS NOT NULL OR p.enlace_pae_actual_id IS NOT NULL) AND ap.estatus = 'A' AND ap.cargo_id IN (3, 5, 27)";
            }elseif($columna=='autoridades_verificados_sin_foto'){
                $filtroColumna=" AND p.es_beneficiario_pae = 'SI' AND u.presento_documento_identidad = 'SI' AND (u.foto IS NULL OR u.foto='') AND (p.director_actual_id IS NOT NULL OR p.subdirector_actual_id IS NOT NULL OR p.enlace_pae_actual_id IS NOT NULL) AND ap.estatus = 'A' AND ap.cargo_id IN (3, 5, 27)";
            }

            if(is_numeric($filas) AND (int)$filas>=0){
                //$limiteFilas = ' LIMIT '.(int)$filas;
            }

            $sql="
             SELECT p.cod_plantel,
                  p.cod_estadistico,
                  p.nombre AS nombre_plantel,
                  p.annio_fundado,
                  p.cod_cnae,
                  p.codigo_ner,
                  p.registro_cnae,
                  p.es_beneficiario_pae,
                  d.nombre AS denominacion,
                  td.nombre AS dependencia,
                  e.nombre AS estado,
                  e.capital AS estado_capital,
                  m.nombre AS municipio,
                  m.capital AS municipio_capital,
                  pa.nombre AS parroquia,
                  z.nombre AS zona_educativa,
                  pp.pae_activo,
                  ts.nombre AS tipo_servicio_pae,
                  (SELECT string_agg(tm.nombre, ' | ') FROM gplantel.plantel_ingesta pi INNER JOIN nutricion.tipo_menu tm ON pi.tipo_ingesta_id = tm.id GROUP BY pi.plantel_id HAVING pi.plantel_id = p.id) AS ingestas,
                  pp.cantidad_madres_procesadoras,
                  pp.matricula_maternal,
                  pp.matricula_preescolar,
                  pp.matricula_educacion_primaria,
                  pp.matricula_educacion_media_general,
                  pp.matricula_educacion_tecnica,
                  pp.matricula_educacion_especial,
                  pp.matricula_docente_obrero,
                  pp.matricula_general,
                  c.nombre AS responsabilidad_autoridad,
                  u.origen AS origen_autoridad,
                  u.cedula AS cedula_autoridad,
                  u.apellido AS apellido_autoridad,
                  u.nombre AS nombre_autoridad,
                  u.telefono AS telefono_autoridad,
                  u.email AS email_autoridad,
                  u.foto AS foto

                FROM
                  gplantel.plantel p
                  LEFT JOIN gplantel.plantel_pae pp ON pp.plantel_id = p.id
                  LEFT JOIN public.estado e ON p.estado_id = e.id
                  LEFT JOIN gplantel.zona_educativa z ON p.zona_educativa_id = z.id
                  LEFT JOIN public.municipio m ON p.municipio_id = m.id
                  LEFT JOIN public.parroquia pa ON p.parroquia_id = pa.id
                  LEFT JOIN gplantel.denominacion d ON p.denominacion_id = d.id
                  LEFT JOIN gplantel.tipo_dependencia td ON p.tipo_dependencia_id = td.id
                  LEFT JOIN gplantel.tipo_servicio_pae ts ON pp.tipo_servicio_pae_id = ts.id
                  INNER JOIN gplantel.autoridad_plantel ap ON ap.plantel_id = p.id
                  LEFT JOIN gplantel.cargo c ON ap.cargo_id = c.id
                  LEFT JOIN seguridad.usergroups_user u ON ap.usuario_id = u.id
            WHERE 1=1 $filtroEstado $filtroColumna $limiteFilas";

            // echo "<pre><code>$sql</code></pre>"; die();
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $resultado = $command->queryAll();

        }

        return $resultado;
    }

    /**
     * 
     * Este Metodo proporciona el detalle del Reporte Estadistico para las columnas: "cocineras_escolares", "cocineras_escolares_asignadas"
     * 
     * @author Jose Gabriel Gonzalez y Nelson Gonzalez
     * @param string $columna
     * @param integer $estadoId
     * @param integer $filas
     * @return array
     */ 
    public  function detalleRegistroUnicoCocineras($columna,$estadoId,$filas=null){
        $resultado=array();
        $filtroEstado='';
        $filtroColumna='';
        $limiteFilas='';
        if(in_array($columna,array("cocineras_escolares", "cocineras_escolares_asignadas")) and is_numeric($estadoId) AND (is_null($filas) OR is_numeric($filas))){
            if($estadoId!='0'){
                $filtroEstado=' AND th.estado_id='.$estadoId;
                if($columna=='cocineras_escolares_asignadas'){
                    $filtroEstado=' AND p.estado_id='.$estadoId;
                }
            }

            if($columna=='cocineras_escolares'){
                $filtroColumna=" AND th.estatus = 'E' AND th.tipo_cargo_actual_id = 11 ";
            }elseif($columna=='cocineras_escolares_asignadas'){
                $filtroColumna=" AND th.plantel_actual_id IS NOT NULL AND th.estatus = 'E' AND th.tipo_cargo_actual_id = 11 ";
            }

            if(is_numeric($filas) AND (int)$filas>=0){
                $limiteFilas = ' LIMIT '.(int)$filas;
            }

            $sql="
             SELECT
                  eth.nombre AS estado_cocinera_escolar,
                  th.origen,
                  th.cedula,
                  th.nombre,
                  th.apellido,
                  th.fecha_nacimiento,
                  th.sexo,
                  th.telefono_celular,
                  th.telefono_fijo,
                  th.email_personal,
                  p.cod_plantel,
                  p.cod_estadistico,
                  p.nombre AS nombre_plantel,
                  p.annio_fundado,
                  p.cod_cnae,
                  p.codigo_ner,
                  p.registro_cnae,
                  d.nombre AS denominacion,
                  td.nombre AS dependencia,
                  e.nombre AS estado,
                  e.capital AS estado_capital,
                  m.nombre AS municipio,
                  pa.nombre AS parroquia,
                  u.origen AS origen_director,
                  u.cedula AS cedula_director,
                  u.apellido AS apellido_director,
                  u.nombre AS nombre_director,
                  u.telefono AS telefono_director,
                  u.email AS email_director
                FROM
                  gestion_humana.talento_humano th
                  LEFT JOIN gplantel.plantel p ON th.plantel_actual_id = p.id
                  LEFT JOIN gplantel.plantel_pae pp ON pp.plantel_id = p.id
                  LEFT JOIN public.estado e ON p.estado_id = e.id
                  LEFT JOIN public.estado eth ON th.estado_id = eth.id
                  LEFT JOIN public.municipio m ON p.municipio_id = m.id
                  LEFT JOIN public.parroquia pa ON p.parroquia_id = pa.id
                  LEFT JOIN seguridad.usergroups_user u ON p.director_actual_id = u.id
                  LEFT JOIN gplantel.denominacion d ON p.denominacion_id = d.id
                  LEFT JOIN gplantel.tipo_dependencia td ON p.tipo_dependencia_id = td.id
            WHERE 1=1 $filtroEstado $filtroColumna $limiteFilas";
            
            // echo "<pre><code>$sql</code></pre>"; die();
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $resultado = $command->queryAll();

        }

        return $resultado;
    }


}

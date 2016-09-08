<?php

/**
 * Description of DirectoresPlantel
 *
 * @author Jose Gabriel Gonzalez
 */
class ControlPlantel extends CActiveRecord {
    
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.plantel';
    }
    
    public function reporteDetalladoPlantel($column, $level, $dependency,$fecha=null ,$orderBy=null){
        
        $columnFilter = $this->getColumnFilter($column,$fecha);
        $drillDownFilter = $this->getGeoDrillDownFilter($level, $dependency);
        
        $where = $drillDownFilter.' AND '.$columnFilter;
        
        if(is_null($orderBy)){
            $orderBy = 'p.cod_plantel,'
                    . 'p.nombre, '
                    . 'es.nombre, '
                    . 'mc.nombre, '
                    . 'pq.nombre, '
                    . 'fundacion';
        }
        
        $sql = "SELECT DISTINCT
                    p.cod_plantel,
                    p.cod_estadistico,
                    dn.nombre AS denominacion,
                    p.nombre,
                    ze.nombre AS zona_educativa,
                    td.nombre AS tipo_dependencia,
                    ep.nombre AS estatus,
                    p.annio_fundado AS fundacion,
                    es.nombre AS estado,
                    mc.nombre AS municipio,
                    pq.nombre AS parroquia,
                    p.direccion,
                    p.correo,
                    p.telefono_fijo,
                    p.telefono_otro,
                    zu.nombre AS zona_ubicacion,
                    cp.nombre AS clase_plantel,
                    c.nombre AS categoria,
                    ce.nombre AS condicion_estudio,
                    g.nombre AS tipo_matricula,
                    t.nombre AS turno,
                    m.nombre AS modalidad,
                    u.cedula AS dir_cedula,
                    u.nombre AS dir_nombre,
                    u.apellido AS dir_apellido,
                    u.username AS dir_usuario,
                    u.telefono AS dir_telefono,
                    u.telefono_celular AS dir_celular,
                    u.email AS dir_email,
                    u.twitter AS dir_twitter
                FROM
                    gplantel.plantel p
                    LEFT JOIN gplantel.zona_educativa ze ON p.zona_educativa_id = ze.id
                    LEFT JOIN public.estado es ON p.estado_id = es.id
                    LEFT JOIN public.municipio mc ON p.municipio_id = mc.id
                    LEFT JOIN public.parroquia pq ON p.parroquia_id = pq.id
                    LEFT JOIN gplantel.modalidad m ON p.modalidad_id = m.id
                    LEFT JOIN gplantel.tipo_dependencia td ON p.tipo_dependencia_id = td.id
                    LEFT JOIN gplantel.estatus_plantel ep ON p.estatus_plantel_id = ep.id
                    LEFT JOIN gplantel.clase_plantel cp ON p.clase_plantel_id = cp.id
                    LEFT JOIN gplantel.categoria c ON p.categoria_id = c.id
                    LEFT JOIN gplantel.condicion_estudio ce ON p.condicion_estudio_id = ce.id
                    LEFT JOIN gplantel.genero g ON p.genero_id = g.id
                    LEFT JOIN gplantel.turno t ON p.turno_id = t.id
                    LEFT JOIN seguridad.usergroups_user u ON p.director_actual_id = u.id
                    LEFT JOIN gplantel.zona_ubicacion zu ON p.zona_ubicacion_id = zu.id
                    LEFT JOIN gplantel.autoridad_plantel ap ON p.id=ap.plantel_id
                    LEFT JOIN gplantel.denominacion dn ON p.denominacion_id = dn.id
                WHERE
                    $where
                ORDER BY
                    $orderBy";

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
     //   echo "<pre>$sql</pre>";
        $resultado = $command->queryAll();
       // var_dump($resultado);
        // die();

        return $resultado;
        
    }
    
    private function getColumnFilter($column, $fecha=null){
        
        switch ($column) {
            case 'planteles':
                $where = "p.id IS NOT NULL";
                break;
            case 'con_director':
                $where = "p.id IS NOT NULL AND p.director_actual_id IS NOT NULL";
                break;
            case 'publ_sin_director':
                $where = "p.id IS NOT NULL AND p.director_actual_id IS NULL AND p.tipo_dependencia_id IN (1, 2, 3)";
                break;
            case 'publ_con_director':
                $where = "p.id IS NOT NULL AND p.director_actual_id IS NOT NULL AND p.tipo_dependencia_id IN (1, 2, 3)";
                break;
            case 'priv_sin_director':
                $where = "p.id IS NOT NULL AND p.director_actual_id IS NULL AND p.tipo_dependencia_id = 6";
                break;
            case 'priv_con_director':
                $where = "p.id IS NOT NULL AND p.director_actual_id IS NOT NULL AND p.tipo_dependencia_id = 6";
                break;
            case 'otros_sin_director':
                $where = "p.id IS NOT NULL AND p.director_actual_id IS NULL AND p.tipo_dependencia_id NOT IN (1, 2, 3, 6)";
                break;
            case 'otros_con_director':
                $where = "p.id IS NOT NULL AND p.director_actual_id IS NOT NULL AND p.tipo_dependencia_id NOT IN (1, 2, 3, 6)";
                break;
            case 'con_director_fecha':
                $where = "p.id IS NOT NULL AND p.director_actual_id IS NOT NULL AND to_char(ap.fecha_ini,'YYYY-MM-DD')='$fecha'";
                break;
            default:
                $where = "p.id IS NULL";
                break;
        }
        
        return $where;
        
    }
    
    private function getGeoDrillDownFilter($level, $dependency) {
        switch ($level) {
            case 'region':
                if ((int) $dependency !== 0)
                    $where = 'es.region_id = ' . $dependency . ' AND es.id != 45'; //No incluye Dependencias Federales (45)
                else
                    $where = 'es.id != 45'; //No incluye Dependencias Federales (45)
                break;
            case 'estado':
                $where = 'es.id = '.$dependency.' AND es.id != 45'; //No incluye Dependencias Federales (45)
                break;
            case 'municipio':
                $where = 'mc.id = '.$dependency.' AND es.id != 45'; //No incluye Dependencias Federales (45)
                break;
            default:
                $where = '1 = 1';
                break;
        }
        
        return $where;
        
    }
    
    
}

<?php

/**
 * Description of DirectoresPlantel
 *
 * @author Jose Gabriel Gonzalez
 */
class DirectoresPlantel extends CActiveRecord {


    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.autoridad_plantel';
    }

    public function reporteEstadistico($level, $dependency_id=null){

        $resultado = array();

        if(in_array($level,array('region', 'estado', 'municipio')) && (is_null($dependency_id) || is_numeric($dependency_id))){

            if($level=='region'){
                $camposSeleccionados = "r.id, r.nombre, 'AAA'||r.nombre AS titulo ";
                $camposSeleccionadosTotales = "0 AS id, 'TOTAL' AS nombre , 'ZZZTOTAL' AS titulo";
                $camposAgrupados = "r.id, r.nombre, titulo ";
                $where = '1 = 1';
                $orderBy = 'titulo ASC, nombre ASC';
            }
            elseif($level=='estado'){
                $camposSeleccionados = "e.region_id AS region_id, r.nombre AS region, e.id AS id, e.nombre, 'AAA'||e.nombre AS titulo  ";
                $camposSeleccionadosTotales = "$dependency_id AS region_id, 'X' AS region, 0 AS id, 'TOTAL' AS nombre , 'ZZZTOTAL' AS titulo";
                $camposAgrupados = "e.region_id, r.nombre, e.id, e.nombre, titulo  ";
                $where = 'e.id != 45 AND e.region_id = '.$dependency_id; // Excluye Dependencias Federales (Id=45)
                $orderBy = 'titulo ASC, nombre ASC';
            }elseif($level=='municipio'){
                $camposSeleccionados = "e.region_id AS region_id, r.nombre AS region, e.id AS estado_id, e.nombre AS estado, m.id, m.nombre, 'AAA'||m.nombre AS titulo  ";
                $camposSeleccionadosTotales = "0 AS region_id, 'X' AS region, $dependency_id AS estado_id, 'X' AS estado, 0 AS id, 'TOTAL' AS nombre , 'ZZZTOTAL' AS titulo";
                $camposAgrupados = "e.region_id, r.nombre, e.id, e.nombre, m.id, m.nombre, titulo  ";
                $where = 'm.estado_id = '.$dependency_id;
                $orderBy = 'titulo ASC, nombre ASC';
            }

            $sql = "SELECT  $camposSeleccionados
                            , SUM(CASE WHEN (p.id IS NOT NULL) THEN 1 ELSE 0 END) AS planteles
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NOT NULL) THEN 1 ELSE 0 END) AS con_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NULL) THEN 1 ELSE 0 END) AS sin_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NOT NULL AND p.tipo_dependencia_id IN (1, 2, 3)) THEN 1 ELSE 0 END) AS publ_con_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NULL AND p.tipo_dependencia_id IN (1, 2, 3)) THEN 1 ELSE 0 END) AS publ_sin_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NOT NULL AND p.tipo_dependencia_id = 6) THEN 1 ELSE 0 END) AS priv_con_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NULL AND p.tipo_dependencia_id = 6) THEN 1 ELSE 0 END) AS priv_sin_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NOT NULL AND p.tipo_dependencia_id NOT IN (1,2,3,6)) THEN 1 ELSE 0 END) AS otros_con_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NULL AND p.tipo_dependencia_id NOT IN (1,2,3,6)) THEN 1 ELSE 0 END) AS otros_sin_director
                    FROM public.region r
                        INNER JOIN public.estado e
                            ON r.id = e.region_id
                        LEFT JOIN gplantel.plantel p
                            ON e.id = p.estado_id
                        LEFT JOIN public.municipio m
                            ON p.municipio_id = m.id
                    WHERE
                        $where
                    GROUP BY
                        $camposAgrupados
                    UNION

                    SELECT  $camposSeleccionadosTotales
                            , SUM(CASE WHEN (p.id IS NOT NULL) THEN 1 ELSE 0 END) AS planteles
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NOT NULL) THEN 1 ELSE 0 END) AS con_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NULL) THEN 1 ELSE 0 END) AS sin_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NOT NULL AND p.tipo_dependencia_id IN (1, 2, 3)) THEN 1 ELSE 0 END) AS publ_con_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NULL AND p.tipo_dependencia_id IN (1, 2, 3)) THEN 1 ELSE 0 END) AS publ_sin_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NOT NULL AND p.tipo_dependencia_id = 6) THEN 1 ELSE 0 END) AS priv_con_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NULL AND p.tipo_dependencia_id = 6) THEN 1 ELSE 0 END) AS priv_sin_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NOT NULL AND p.tipo_dependencia_id NOT IN (1,2,3,6)) THEN 1 ELSE 0 END) AS otros_con_director
                            , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NULL AND p.tipo_dependencia_id NOT IN (1,2,3,6)) THEN 1 ELSE 0 END) AS otros_sin_director
                    FROM public.region r
                        INNER JOIN public.estado e
                            ON r.id = e.region_id
                        LEFT JOIN gplantel.plantel p
                            ON e.id = p.estado_id
                        LEFT JOIN public.municipio m
                            ON p.municipio_id = m.id
                    WHERE
                        $where
                    ORDER BY
                        $orderBy";

            //echo "<pre><code>$sql</code></pre>";

            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $resultado = $command->queryAll();

        }

        return $resultado;

    }


    public function reporteGrafico($estadoId=null){

        $resultado = array();
        $camposSeleccionados = "e.region_id AS id, r.nombre AS region, e.id AS estado_id, e.nombre, 'AAA'||e.nombre AS titulo  ";
        $camposAgrupados = "e.region_id, r.nombre, e.id, e.nombre, titulo  ";
        $where = 'e.id != 45';
        $orderBy = 'titulo ASC, e.nombre ASC';

        if(!is_null($estadoId) && is_numeric($estadoId)){
            $where .= " AND e.id = $estadoId ";
        }

        $sql = "SELECT  $camposSeleccionados
                        , SUM(CASE WHEN (p.id IS NOT NULL) THEN 1 ELSE 0 END) AS planteles
                        , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NOT NULL) THEN 1 ELSE 0 END) AS con_director
                        , SUM(CASE WHEN (p.id IS NOT NULL AND p.director_actual_id IS NULL) THEN 1 ELSE 0 END) AS sin_director
                FROM public.region r
                    INNER JOIN public.estado e
                        ON r.id = e.region_id
                    LEFT JOIN gplantel.plantel p
                        ON e.id = p.estado_id
                WHERE
                    $where
                GROUP BY
                    $camposAgrupados
                ORDER BY
                    $orderBy";

        //ld($sql);

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $resultado = $command->queryAll();

        return $resultado;

    }


}

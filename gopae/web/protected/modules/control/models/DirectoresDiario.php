<?php

/**
 * Description of DirectoresPlantel
 *
 * @author Jean Carlos Barboza
 */
class DirectoresDiario extends CActiveRecord {
    
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.autoridad_plantel';
    }
    
    public function reporteEstadistico($level, $dependency_id,$fecha){
      
        $resultado = array();
        
        if(in_array($level,array('region', 'estado')) && (is_null($dependency_id) || is_numeric($dependency_id) && is_string($fecha))){

            if($level=='estado'){


                $sql= "select a.id,a.nombre,a.capital,
                (
                select count(gplantel.autoridad_plantel.cargo_id) from gplantel.autoridad_plantel
                inner join gplantel.plantel on gplantel.autoridad_plantel.plantel_id=gplantel.plantel.id
                inner join estado on gplantel.plantel.estado_id=estado.id
                inner join region on estado.region_id=region.id and estado.region_id=$dependency_id
                where  estado.id=a.id and to_char(gplantel.autoridad_plantel.fecha_ini,'YYYY-MM-DD')='$fecha'
                ) cantidad_directores from estado a
                where a.region_id=$dependency_id ";
            }
            elseif($level=='region'){            
                    //$fecha=date("Y-m-d");
                    $sql = "select a.id,a.nombre,
                    (
                    select count(gplantel.autoridad_plantel.cargo_id) from gplantel.autoridad_plantel
                    inner join gplantel.plantel on gplantel.autoridad_plantel.plantel_id=gplantel.plantel.id
                    inner join estado on gplantel.plantel.estado_id=estado.id
                    inner join region on estado.region_id=region.id
                    where region.id=a.id and to_char(gplantel.autoridad_plantel.fecha_ini,'YYYY-MM-DD')='$fecha'
                    


                    ) cantidad_directores

                    from region a";

            }

            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $resultado = $command->queryAll();

        }
        return $resultado;
        
    }
    

    
}

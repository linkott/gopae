<?php

/**
 * This is the model class for table "nutricion.planificacion".
 *
 * The followings are the available columns in table 'nutricion.planificacion':
 * @property integer $id
 * @property integer $menu_nutricional_id
 * @property integer $plantel_id
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property boolean $allday
 * @property string $classname
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 * @property MenuNutricional $menuNutricional
 * @property integer $tipo_menu_id
 */
class Planificacion extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'nutricion.planificacion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('classname, usuario_ini_id, fecha_ini, estatus', 'required'),
            array('menu_nutricional_id, plantel_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('classname', 'length', 'max' => 50),
            array('estatus', 'length', 'max' => 1),
            array('fecha_inicio, fecha_fin, allday, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, menu_nutricional_id, plantel_id, fecha_inicio, fecha_fin, allday, classname, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, tipo_menu_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'menuNutricional' => array(self::BELONGS_TO, 'MenuNutricional', 'menu_nutricional_id'),
            'tipoMenu' => array(self::BELONGS_TO, 'TipoMenu', 'tipo_menu_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'menu_nutricional_id' => 'Menu Nutricional',
            'tipo_menu_id' => 'Tipo Menu',
            'plantel_id' => 'Plantel',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'allday' => 'Allday',
            'classname' => 'Classname',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('menu_nutricional_id', $this->menu_nutricional_id);
        $criteria->compare('tipo_menu_id', $this->tipo_menu_id);
        $criteria->compare('plantel_id', $this->plantel_id);
        $criteria->compare('fecha_inicio', $this->fecha_inicio, true);
        $criteria->compare('fecha_fin', $this->fecha_fin, true);
        $criteria->compare('allday', $this->allday);
        $criteria->compare('classname', $this->classname, true);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function planificacionActiva($id,$mes,$ano) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if (is_numeric($id)) {
            $sql = "SELECT pl.id FROM nutricion.planificacion pl
                    WHERE EXTRACT(MONTH FROM pl.fecha_inicio) = :mes AND EXTRACT(YEAR FROM pl.fecha_inicio) = :anio";
            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(':mes', $mes, PDO::PARAM_INT);
            $consulta->bindParam(':anio', $ano, PDO::PARAM_INT);
            $resultado = $consulta->queryAll();
            return $resultado;
        } else {
            return null;
        }
    }
    
//    public function cantidadDiasDisponibles($mes, $anio){
//        $sql = "SELECT COUNT(1) FROM nutricion.planificacion WHERE EXTRACT(MONTH FROM fecha_inicio) = :mes AND EXTRACT(YEAR FROM fecha_inicio) = :anio";
//        $consulta = Yii::app()->db->createCommand($sql);
//        $consulta->bindParam(':mes', $mes, PDO::PARAM_INT);
//        $consulta->bindParam(':anio', $anio, PDO::PARAM_INT);
//        $resultado = $consulta->queryAll();
//        return $resultado;
//    }

    public function agregarEvento($menu_nutricional_id, $tipoMenu, $plantel_id, $start, $end, $allDay, $className) {
        $usuario_ini_id = Yii::app()->user->id;
        $fecha_ini = date("Y-m-d H:i:s");
        $estatus = 'A';
        $sql = "
                INSERT INTO nutricion.planificacion(
                        menu_nutricional_id, tipo_menu_id ,plantel_id, fecha_inicio, fecha_fin, 
                        allday, classname, usuario_ini_id, fecha_ini, estatus)
                VALUES (" . $menu_nutricional_id . ", " . $tipoMenu . "," . $plantel_id . ", '" . $start . "', '" . $end . "', " . $allDay . ", 
                        '" . $className . "', " . $usuario_ini_id . ", '" . $fecha_ini . "', '" . $estatus . "') RETURNING id;";
        $consulta = Yii::app()->db->createCommand($sql);
        return $resultado = $consulta->execute();
    }

    public function eliminarPlanificacion($id) {
        $sql = "DELETE FROM nutricion.planificacion WHERE id = " . $id . " AND estatus = 'A'";
        $resultado = Yii::app()->db->createCommand($sql);
        return $resultado->execute();
    }
        
        public function actualizacionMes($plantel_id){
            $mes = date('m');
//            if($mesPasado == 1){
//                $mesPasado = 12;
//            }
//            else{
//                $mesPasado--;
//            }
            $anio = date('Y');
            $sql = "SELECT
                    COUNT(id)
                    FROM nutricion.planificacion
                    WHERE
                    EXTRACT(YEAR FROM fecha_inicio) = $anio AND
                    EXTRACT(MONTH FROM fecha_inicio) = $mes AND estatus = 'A'";
            $resultado = Yii::app()->db->createCommand($sql);
            $respuesta = $resultado->queryAll();
            if($respuesta > 0){
                $sql = "UPDATE nutricion.planificacion SET estatus = 'C' WHERE
                        EXTRACT(YEAR FROM fecha_inicio) = $anio AND
                        EXTRACT(MONTH FROM fecha_inicio) = $mes AND estatus = 'A'";
                $respuesta = Yii::app()->db->createCommand($sql);
                $r = $respuesta->execute();
            }
            return $r;
        }

    public function estatusPlanificacion($plantel_id) {
        $mes = date('m');
        $anio = date('Y');
        $sql = "
                SELECT * FROM nutricion.planificacion WHERE
                EXTRACT(YEAR FROM fecha_inicio) = $anio AND
                EXTRACT(MONTH FROM fecha_inicio) = $mes AND
                plantel_id = $plantel_id AND estatus = 'C'";
            $respuesta = Yii::app()->db->createCommand($sql);
            $r = $respuesta->queryAll();
            return $r;
        }
        
        public function guardarCambios($plantel_id){
            $mes = date('m') + 1;
            if($mes == 13){
                $mes = 1;
            }
            $anio = date('Y');
            $sql = "UPDATE nutricion.planificacion SET estatus = 'C' WHERE
                EXTRACT(YEAR FROM fecha_inicio) = $anio AND
                EXTRACT(MONTH FROM fecha_inicio) = $mes AND
                plantel_id = $plantel_id";
        $respuesta = Yii::app()->db->createCommand($sql);
        $r = $respuesta->queryAll();
        return $r;
    }
    
    public function limpiarEventos($plantel_id, $mes, $ano){
        $sql = "DELETE FROM nutricion.planificacion WHERE EXTRACT(YEAR FROM fecha_inicio) = " . $ano . " AND
                EXTRACT(MONTH FROM fecha_inicio) = " . $mes . " AND plantel_id=" . $plantel_id;
        $respuesta = Yii::app()->db->createCommand($sql);
        $r = $respuesta->execute();
    }
    
    public function asignarPlanificacion($plantel_id, $mes, $ano){
//        $sql = "DELETE FROM nutricion.planificacion WHERE EXTRACT(YEAR FROM fecha_inicio) = " . $ano . " AND
//                EXTRACT(MONTH FROM fecha_inicio) = " . $mes . " AND plantel_id=" . $plantel_id;
//        $respuesta = Yii::app()->db->createCommand($sql);
//        $respuesta->execute();
        
        $sql = "SELECT * FROM nutricion.planificacion WHERE EXTRACT(YEAR FROM fecha_inicio) = " . $ano . " AND
                EXTRACT(MONTH FROM fecha_inicio) = " . $mes . " AND plantel_id = " . $plantel_id;
        $resultado = Yii::app()->db->createCommand($sql);
        $resul = $resultado->queryAll();
        foreach ($resul AS $r){
            $date = date_format(date_create($r['fecha_inicio']), 'N');
            echo 'El día ' . $r['fecha_inicio'] . ' ' . $date . '<br>';
        }
        die();
        $numeroDia = date('N');
        if($numeroDia);
        
    }

    public function diasFeriados($fecha) {
        $sql = "SELECT sistema.dias_feriados('$fecha')";
        $respuesta = Yii::app()->db->createCommand($sql);
        return $respuesta->queryAll();
    }

    public function planificarPeriodo() {
        $usuario_id = Yii::app()->user->id;
        $username = Yii::app()->user->name;
        $ip = Utiles::getRealIP();
        
        $sql = "SELECT planificacion_anual_menu_pae('$ip', 'planificarPeriodo', $usuario_id, '$username')";
        $resultado = Yii::app()->db->createCommand($sql);
        return $resultado->execute();
    }
    
    public function mostrarPlanificacion($plantel_id, $periodo){
        
        $result = null;
//        $plantelIngesta = 0;
//        if($plantel_id != ''){
//            $plantelIngesta = PlantelIngesta::model()->findAll(array('condition' => 'plantel_id = ' . $plantel_id));
//            $plantelIngesta = count($plantelIngesta);
//        }

//        $indice = "planificacionPeriodo " . $periodo . "Plantel " .$plantel_id . "Ingestas" . $plantelIngesta;
//        $result = Yii::app()->cache->get($indice);
        
//        if(is_numeric($mes)){
//            if($mes > 0 && $mes <= 12){
//                if (!$result) {
                    if($plantel_id != '' && is_numeric($plantel_id)){
                        $sql = "SELECT p.* FROM nutricion.planificacion p INNER JOIN gplantel.plantel_ingesta pi ON pi.tipo_ingesta_id = p.tipo_menu_id WHERE pi.plantel_id = " . $plantel_id;
                    }
                    else{
                        $sql = "SELECT * FROM nutricion.planificacion";
                    }
                    $resultado = Yii::app()->db->createCommand($sql);
                    $result = $resultado->queryAll();
//                    Yii::app()->cache->set($indice, $result, 3600);
//                }
//            }
//        }
        return $result;
    }
    
    public function hayPlanificacion($fecha_inicio, $fecha_final){
        $sql = "SELECT * FROM nutricion.planificacion WHERE fecha_inicio BETWEEN '$fecha_inicio' AND '$fecha_final'";
        $resultado = Yii::app()->db->createCommand($sql);
        $result = $resultado->queryAll();
        return $result;
    }

    public function cantidadDiasPlanificados($mes, $anio){
        $resultado = null;
        if($this->isValidMonth($mes) && is_numeric($anio)){
            $mesAnio = (str_pad($mes, 2, '0', STR_PAD_LEFT)).'-'.$anio;
            $sql = "SELECT COUNT(p.id)
                      FROM nutricion.planificacion p
                     WHERE p.tipo_menu_id = 1 
                       AND p.estatus = 'A'
                       AND TO_CHAR(p.fecha_inicio, 'MM-YYYY') = :mesAnio";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":mesAnio", $mesAnio, PDO::PARAM_STR);
            $resultado = $command->queryScalar();
        }
        return $resultado;
    }
    
    /**
     * 
     * @param int $mes
     * @return boolean
     */
    public function isValidMonth($mes) {
        $result = false;

        if(is_numeric($mes) && in_array((int) $mes, array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12))){
            $result = true;
        }

        return $result;
    }  

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Planificacion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

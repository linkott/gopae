<?php

/**
 * This is the model class for table "gplantel.tipo_ubicacion_plantel".
 *
 * The followings are the available columns in table 'gplantel.tipo_ubicacion_plantel':
 * @property integer $id
 * @property integer $tipo_ubicacion_id
 * @property integer $plantel_id
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
 * @property TipoUbicacion $tipoUbicacion
 * @property Plantel $plantel
 */
class TipoUbicacionPlantel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.tipo_ubicacion_plantel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('usuario_ini_id, fecha_ini', 'required'),
            array('tipo_ubicacion_id, plantel_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('estatus', 'length', 'max' => 1),
            array('fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, tipo_ubicacion_id, plantel_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
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
            'tipoUbicacion' => array(self::BELONGS_TO, 'TipoUbicacion', 'tipo_ubicacion_id'),
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'tipo_ubicacion_id' => 'Tipo Ubicacion',
            'plantel_id' => 'Plantel',
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
        $criteria->compare('tipo_ubicacion_id', $this->tipo_ubicacion_id);
        $criteria->compare('plantel_id', $this->plantel_id);
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

    public function guardarTipoUbicacion($plantel_id, $fronteriza = null, $indigena = null, $dificil_acceso = null) {
        //    var_dump($fronteriza,$indigena,$dificil_acceso);die();
        $usuario = Yii::app()->user->id;
        $estatus = 'A';
        if ($fronteriza != null) {
            $sql = "INSERT INTO gplantel.tipo_ubicacion_plantel
                (tipo_ubicacion_id, plantel_id, usuario_ini_id, estatus)
                VALUES (:tipo_ubicacion_id, :plantel_id, :usuario_ini_id, :estatus) returning id";

            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":tipo_ubicacion_id", $fronteriza, PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guardoUbicacionFronteriza = $guard->queryScalar();
            // var_dump($control); die();
            // return $guardoUbicacionFronteriza;
        }
        if ($indigena != null) {
            $sql = "INSERT INTO gplantel.tipo_ubicacion_plantel
                (tipo_ubicacion_id, plantel_id, usuario_ini_id, estatus)
                VALUES (:tipo_ubicacion_id, :plantel_id, :usuario_ini_id, :estatus) returning id";

            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":tipo_ubicacion_id", $indigena, PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guardoUbicacionIndigena = $guard->queryScalar();
            // var_dump($control); die();
            //  return $guardoUbicacionIndigena;
        }
        if ($dificil_acceso != null) {
            $sql = "INSERT INTO gplantel.tipo_ubicacion_plantel
                (tipo_ubicacion_id, plantel_id, usuario_ini_id, estatus)
                VALUES (:tipo_ubicacion_id, :plantel_id, :usuario_ini_id, :estatus) returning id";

            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":tipo_ubicacion_id", $dificil_acceso, PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guardoUbicacionDificilA = $guard->queryScalar();
            // var_dump($control); die();
            //  return $guardoUbicacionDificilA;
        }
        //  var_dump($guardoUbicacionFronteriza,$guardoUbicacionIndigena,$guardoUbicacionDificilA); die();
    }

    public function prepararActualizacionTipoUbicacion($plantel_id, $fronteriza, $indigena, $dificil_acceso) {
        $resultadoFro = $this->buscarTipoUbicacion($plantel_id, 1);
        $resultadoInd = $this->buscarTipoUbicacion($plantel_id, 2);
        $resultadoDif = $this->buscarTipoUbicacion($plantel_id, 3);

        /* FRONTERIZA */
        if ($fronteriza == 1) {
            if ($resultadoFro['tipo_ubicacion_id'] != 1)
                $this->guardarTipoUbicacion($plantel_id, $fronteriza);
            else {
                if ($resultadoFro['estatus'] == "E") {
                    $this->actualizarTipoUbicacion($plantel_id, $fronteriza);
                }
            }
        } else {
            if ($resultadoFro['tipo_ubicacion_id'] == 1)
                $this->eliminarTipoUbicacion($plantel_id, 1);
            else {
                if ($resultadoFro['estatus'] == "E") {
                    $this->actualizarTipoUbicacion($plantel_id, $fronteriza);
                }
            }
        }
        /* FIN FRONTERIZA */
        /* INDIGENA */
        if ($indigena == 2) {
            if ($resultadoInd['tipo_ubicacion_id'] != 2)
                $this->guardarTipoUbicacion($plantel_id, null, $indigena);
            else {
                if ($resultadoInd['estatus'] == "E") {
                    $this->actualizarTipoUbicacion($plantel_id, $indigena);
                }
            }
        } else {
            if ($resultadoInd ['tipo_ubicacion_id'] == 2) {
                $this->eliminarTipoUbicacion($plantel_id, 2);
            }
        }
        /* FIN INDIGENA */
        /* DIFICIL ACCESO */
        if ($dificil_acceso == 3) {
            if ($resultadoDif['tipo_ubicacion_id'] != 3)
                $this->guardarTipoUbicacion($plantel_id, null, null, $dificil_acceso);
        }else {
            if ($resultadoDif['tipo_ubicacion_id'] == 3)
                $this->eliminarTipoUbicacion($plantel_id, 3);
            else {
                if ($resultadoDif['estatus'] == "E") {
                    $this->actualizarTipoUbicacion($plantel_id, $dificil_acceso);
                }
            }
        }
        /* FIN DIFICIL ACCESO */
    }

    public function buscarTipoUbicacion($plantel_id, $tipo_ubicacion_id = null) {
        if ($tipo_ubicacion_id != null) {
            $sql = "SELECT tipo_ubicacion_id , estatus FROM gplantel.tipo_ubicacion_plantel"
                    . " WHERE plantel_id = :plantel_id AND tipo_ubicacion_id = :tipo_ubicacion_id";
            $select = Yii::app()->db->createCommand($sql);
            $select->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $select->bindParam(":tipo_ubicacion_id", $tipo_ubicacion_id, PDO::PARAM_INT);
            return $select->queryRow();
        } elseif (is_numeric($tipo_ubicacion_id)) {
            $sql = "SELECT tipo_ubicacion_id , estatus FROM gplantel.tipo_ubicacion_plantel"
                    . " WHERE plantel_id = :plantel_id ";
            $select = Yii::app()->db->createCommand($sql);
            $select->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            return $select->queryRow();
        }
    }

    public function actualizarTipoUbicacion($plantel_id, $tipo_ubicacion_id) {
        $usuario = Yii::app()->user->id;
        $fecha = date("Y-m-d H:i:s");
        $estatus = "A";
        $sql = "UPDATE gplantel.tipo_ubicacion_plantel"
                . " SET usuario_act_id = :usuario_act_id,"
                . "fecha_act = :fecha_act,"
                . "estatus = :estatus"
                . " WHERE"
                . " plantel_id = :plantel_id AND tipo_ubicacion_id = :tipo_ubicacion_id";
        $update = Yii::app()->db->createCommand($sql);
        $update->bindParam(":usuario_act_id", $usuario, PDO::PARAM_INT);
        $update->bindParam(":fecha_act", $fecha, PDO::PARAM_INT);
        $update->bindParam(":estatus", $estatus, PDO::PARAM_INT);
        $update->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $update->bindParam(":tipo_ubicacion_id", $tipo_ubicacion_id, PDO::PARAM_INT);
        $update->execute();
    }

    public function eliminarTipoUbicacion($plantel_id, $tipo_ubicacion_id) {
        $usuario = Yii::app()->user->id;
        $fecha = date("Y-m-d H:i:s");
        $estatus = "E";
        $sql = "UPDATE gplantel.tipo_ubicacion_plantel"
                . " SET usuario_act_id = :usuario_act_id,"
                . "fecha_act = :fecha_act,"
                . "fecha_elim = :fecha_elim,"
                . "estatus = :estatus"
                . " WHERE"
                . " plantel_id = :plantel_id AND tipo_ubicacion_id = :tipo_ubicacion_id";
        $update = Yii::app()->db->createCommand($sql);
        $update->bindParam(":usuario_act_id", $usuario, PDO::PARAM_INT);
        $update->bindParam(":fecha_act", $fecha, PDO::PARAM_INT);
        $update->bindParam(":fecha_elim", $fecha, PDO::PARAM_INT);
        $update->bindParam(":estatus", $estatus, PDO::PARAM_INT);
        $update->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $update->bindParam(":tipo_ubicacion_id", $tipo_ubicacion_id, PDO::PARAM_INT);
        $update->execute();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TipoUbicacionPlantel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

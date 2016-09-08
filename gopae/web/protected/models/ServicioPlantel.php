<?php

/**
 * This is the model class for table "gplantel.servicio_plantel".
 *
 * The followings are the available columns in table 'gplantel.servicio_plantel':
 * @property string $id
 * @property integer $plantel_id
 * @property integer $servicio_id
 * @property integer $condicion_id
 * @property string $fecha_desde
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Usuario $usuarioAct
 * @property Usuario $usuarioIni
 * @property Plantel $plantel
 * @property Servicio $servicio
 * @property CondicionServicio $condicion
 */
class ServicioPlantel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.servicio_plantel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('plantel_id, servicio_id, condicion_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('estatus', 'length', 'max' => 1),
            array('fecha_desde, fecha_ini, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, plantel_id, servicio_id, condicion_id, fecha_desde, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
            'servicio' => array(self::BELONGS_TO, 'Servicio', 'servicio_id'),
            'condicion' => array(self::BELONGS_TO, 'CondicionServicio', 'condicion_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'plantel_id' => 'Plantel',
            'servicio_id' => 'Servicio',
            'condicion_id' => 'Condicion',
            'fecha_desde' => 'Fecha Desde',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('plantel_id', $this->plantel_id);
        $criteria->compare('servicio_id', $this->servicio_id);
        $criteria->compare('condicion_id', $this->condicion_id);
        $criteria->compare('fecha_desde', $this->fecha_desde, true);
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

    public function getServiciosBD($plantelId, $listaServicio) {

        $servicioId = array();
        for ($x = 0; $x < sizeof($listaServicio); $x++) {
            $idServicios = $listaServicio[$x];
            $idServicio = (int) $idServicios;
            // var_dump($idServicio);
            $sql = "SELECT servicio_id
                FROM gplantel.servicio_plantel
                WHERE plantel_id='$plantelId' and servicio_id='$idServicio'";
            $buscar = Yii::app()->db->createCommand($sql);
            $resultado = $buscar->queryScalar();
            // var_dump($resultado); die();
            if ($resultado != false) {
                $servicioId[$x] = $resultado;
                //var_dump($servicioId);
            }
        }
        // var_dump($servicioId);
        return $servicioId;
    }

    /* TRAEME TODOS LOS SERVICIOS DONDE EL PLANTEL SEA IGUAL AL ID_PLANTEL */

    public function obtenerServiciosPlantel($plantel_id) {
        $criteria = new CDbCriteria();

        $sql = "SELECT s.nombre servicio, c.nombre, t.fecha_desde FROM gplantel.servicio_plantel t
        LEFT JOIN gplantel.servicio s ON t.servicio_id = s.id
        LEFT JOIN gplantel.condicion_servicio c ON t.condicion_id = c.id
        WHERE t.plantel_id = :plantel_id AND t.estatus = 'A'";

        $con = Yii::app()->db->createCommand($sql);

        $con->bindParam(":plantel_id", $plantel_id, PDO::PARAM_STR);

        $resultado = $con->queryAll();
        return $resultado;
    }

///////////////////////Guardar Servicios/////////////////////////////////////////////

    public function guardarServicios($plantel_id, $existenciaRegistro) {

        // die();
        for ($x = 0; $x < sizeof($existenciaRegistro[0]); $x++) {
            //     for ($y = 0; $y < sizeof($existenciaRegistro[0]); $y++) {
            $sql = "INSERT INTO gplantel.servicio_plantel
                (condicion_id, servicio_id, plantel_id, estatus, usuario_ini_id)
                VALUES (:condicion_id, :servicio_id, :plantel_id, :estatus, :usuario_ini_id) returning id";

            $guard = Yii::app()->db->createCommand($sql);
            $estatus = 'A';
            $usuario = Yii::app()->user->id;
            $guard->bindParam(":condicion_id", $existenciaRegistro[1][$x], PDO::PARAM_INT);
            $guard->bindParam(":servicio_id", $existenciaRegistro[0][$x], PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario, PDO::PARAM_STR);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $control = $guard->queryScalar();
//            var_dump($control);
//            die();
            //  }
        }
//        var_dump($control);
//        die();
        return $control;
    }

///////////////////////////////////fin//////////////////////////////////////////////////
    //////////////////////Verificar si ya existe el servicio asignado a el plantel///////////

    public function buscarServicioPlantel($plantel_id, $servicios) {
        //var_dump($plantel_id); die();
        for ($x = 0; $x < sizeof($servicios); $x++) {
            $servicio_id = $servicios[$x]['servicio_id'];
            $servicio_id = (int) $servicio_id;
            // var_dump($servicio_id); die();
            $sql = "SELECT plantel_id, servicio_id
                FROM gplantel.servicio_plantel
                WHERE plantel_id='$plantel_id' and servicio_id='$servicio_id'";
            $buscar = Yii::app()->db->createCommand($sql);
            $rBuscar = $buscar->queryAll();
        }

        return $rBuscar;
        // var_dump($rBuscar); die();
    }

///////////////////////////////////////////fin////////////////////////////////////////////////

    public function getServiciosPlantel($plantel_id) {
        $sql = "SELECT servicio_id, condicion_id as calidad, fecha_desde
                FROM gplantel.servicio_plantel
                WHERE plantel_id = :plantel_id AND estatus = 'A'
                ORDER BY plantel_id ASC";

        $command = $this->getDbConnection()->createCommand($sql);
        $command->bindParam(':plantel_id', $plantel_id, PDO::PARAM_STR);
        return $command->queryAll();
    }

    public function agregarServicio($plantel_id, $servicio_id, $calidad_id, $fecha_desde = '') {
        $usuario = Yii::app()->user->id;
        $fecha_act = date('Y-m-d H:m:s');
        $sqlBusqueda = "SELECT estatus
                        FROM gplantel.servicio_plantel
                        WHERE
                        servicio_id = :servicio_id AND
                        plantel_id = :plantel_id";
        $command = $this->getDbConnection()->createCommand($sqlBusqueda);
        $command->bindParam(":servicio_id", $servicio_id, PDO::PARAM_STR);
        $command->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $estatusServicio = $command->queryScalar();
        if ($estatusServicio !== false) {
            $estatus = 'A';
            $sqlUpdate = "UPDATE gplantel.servicio_plantel
                            SET
                                usuario_act_id = :usuario_act_id,
                                fecha_act = :fecha_act,
                                estatus = :estatus
                            WHERE
                                servicio_id = :servicio_id AND
                                plantel_id = :plantel_id";
            $command = $this->getDbConnection()->createCommand($sqlUpdate);
            $command->bindParam(":servicio_id", $servicio_id, PDO::PARAM_STR);
            $command->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $command->bindParam(":usuario_act_id", $usuario, PDO::PARAM_STR);
            $command->bindParam(":fecha_act", $fecha_act, PDO::PARAM_INT);
            $command->bindParam(":estatus", $estatus, PDO::PARAM_INT);
            $command->execute();
        } else {
            $estatus = 'A';
            $sqlInsert = "INSERT INTO gplantel.servicio_plantel
                            (plantel_id, servicio_id, condicion_id, fecha_desde, usuario_ini_id, usuario_act_id,fecha_act, estatus)
                            VALUES
                            (:plantel_id, :servicio_id, :condicion_id, :fecha_desde, :usuario_ini_id, :usuario_act_id,:fecha_act, :estatus)";
            $command = $this->getDbConnection()->createCommand($sqlInsert);

            $command->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $command->bindParam(":servicio_id", $servicio_id, PDO::PARAM_STR);
            $command->bindParam(":condicion_id", $calidad_id, PDO::PARAM_STR);
            $command->bindParam(":fecha_desde", $fecha_desde, PDO::PARAM_STR);
            $command->bindParam(":usuario_ini_id", $usuario, PDO::PARAM_STR);
            $command->bindParam(":usuario_act_id", $usuario, PDO::PARAM_STR);
            $command->bindParam(":fecha_act", $fecha_act, PDO::PARAM_INT);
            $command->bindParam(":estatus", $estatus, PDO::PARAM_INT);
            $command->execute();
        }
        return $this->getServiciosPlantel($plantel_id);
    }

    public function eliminarServicio($plantel_id, $servicio_id) {
        $usuario = Yii::app()->user->id;
        $fecha_act = date('Y-m-d H:m:s');
        $estatus = 'I';
        $sqlUpdate = "UPDATE gplantel.servicio_plantel
                            SET
                                usuario_act_id = :usuario_act_id,
                                fecha_act = :fecha_act,
                                estatus = :estatus
                            WHERE
                                servicio_id = :servicio_id AND
                                plantel_id = :plantel_id";
        $command = $this->getDbConnection()->createCommand($sqlUpdate);
        $command->bindParam(":servicio_id", $servicio_id, PDO::PARAM_STR);
        $command->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $command->bindParam(":usuario_act_id", $usuario, PDO::PARAM_STR);
        $command->bindParam(":fecha_act", $fecha_act, PDO::PARAM_INT);
        $command->bindParam(":estatus", $estatus, PDO::PARAM_INT);
        $command->execute();
        return $this->getServiciosPlantel($plantel_id);
    }

    public function ActualizarServicio($plantel_id, $servicio_id, $calidad_id, $fecha_desde) {
        $usuario = Yii::app()->user->id;
        $fecha_act = date('Y-m-d H:m:s');
        $estatus = 'A';
        $sqlUpdate = "UPDATE gplantel.servicio_plantel
                            SET
                                condicion_id = :condicion_id,
                                usuario_act_id = :usuario_act_id,
                                fecha_act = :fecha_act,
                                fecha_desde = :fecha_desde,
                                estatus = :estatus
                            WHERE
                                servicio_id = :servicio_id AND
                                plantel_id = :plantel_id";
        $command = $this->getDbConnection()->createCommand($sqlUpdate);
        $command->bindParam(":condicion_id", $calidad_id, PDO::PARAM_STR);
        $command->bindParam(":usuario_act_id", $usuario, PDO::PARAM_STR);
        $command->bindParam(":fecha_act", $fecha_act, PDO::PARAM_INT);
        $command->bindParam(":fecha_desde", $fecha_desde, PDO::PARAM_INT);
        $command->bindParam(":estatus", $estatus, PDO::PARAM_INT);
        $command->bindParam(":servicio_id", $servicio_id, PDO::PARAM_STR);
        $command->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $command->execute();
        return $this->getServiciosPlantel($plantel_id);
    }

    public function verificacionExistencia($plantel_id, $servicios) {

        // $todo=array();
        $guardar = array();
        $guardoCalidad = array();
        $plantel_id = (int) $plantel_id;
        for ($x = 0; $x < sizeof($servicios); $x++) {
            $serviciosAgregado = $servicios[$x]['servicio_id'];
            $calidadAgregado = $servicios[$x]['calidad'];
            // var_dump($proyectosAgregado);die();
            $serviciosAgregad = (int) $serviciosAgregado;
            $calidadAgregad = (int) $calidadAgregado;
            if ($plantel_id != '') {
                $sql = "SELECT id from gplantel.servicio_plantel
                WHERE plantel_id=$plantel_id AND servicio_id=$serviciosAgregad";
                $guard = Yii::app()->db->createCommand($sql);
                $guardo = $guard->queryScalar();
            }

            if ($guardo == false) {
                array_push($guardar, $serviciosAgregad); //si no existe un servicio guardado en la tabla servicio_plantel guarda el id del servicio en un arreglo para luego llevarlo a insertarlo
                array_push($guardoCalidad, $calidadAgregad); //si no existe una calidad guardado en la tabla servicio_plantel guarda el id del servicio en un arreglo para luego llevarlo a insertarlo
            }
        }

        return array(
            $guardar,
            $guardoCalidad
        );
        //  var_dump($todo);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ServicioPlantel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

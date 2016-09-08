<?php

/**
 * This is the model class for table "gplantel.proyectos_endogenos_plantel".
 *
 * The followings are the available columns in table 'gplantel.proyectos_endogenos_plantel':
 * @property integer $id
 * @property integer $proyectos_endogenos_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $plantel_id
 *
 * The followings are the available model relations:
 * @property Plantel $plantel
 * @property ProyectosEndogenos $proyectosEndogenos
 */
class ProyectosEndogenosPlantel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.proyectos_endogenos_plantel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('proyectos_endogenos_id, usuario_ini_id, usuario_act_id, plantel_id', 'numerical', 'integerOnly' => true),
            array('estatus', 'length', 'max' => 1),
            array('fecha_ini, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, proyectos_endogenos_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, plantel_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
            'proyectosEndogenos' => array(self::BELONGS_TO, 'ProyectosEndogenos', 'proyectos_endogenos_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'proyectos_endogenos_id' => 'Proyectos Endogenos',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'plantel_id' => 'Plantel',
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
        $criteria->compare('proyectos_endogenos_id', $this->proyectos_endogenos_id);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('plantel_id', $this->plantel_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getProyectoBD($plantelId, $listaProyecto) {
        $proyectoEndogenoId = array();
        for ($x = 0; $x < sizeof($listaProyecto); $x++) {
            $idProyectos = $listaProyecto[$x];
            $idProyectosEndo = (int) $idProyectos;
            // var_dump($idProyectosEndo);
            $sql = "SELECT proyectos_endogenos_id from gplantel.proyectos_endogenos_plantel
                WHERE plantel_id=$plantelId AND proyectos_endogenos_id=$idProyectosEndo";
            $buscar = Yii::app()->db->createCommand($sql);
            $resultado = $buscar->queryScalar();
            if ($resultado != false) {
                $proyectoEndogenoId[$x] = $resultado;
                // var_dump($proyectoEndogenoId);
            }
        }
        // var_dump($proyectoEndogenoId);
        return $proyectoEndogenoId;
    }

////////////////////////guardar proyecto endogeno////////////////////////////

    public function guardarProyectosEndogenos($plantel_id, $existenciaRegistro) {

        for ($x = 0; $x < sizeof($existenciaRegistro); $x++) {
            $sql = "INSERT INTO gplantel.proyectos_endogenos_plantel
                (proyectos_endogenos_id, estatus, plantel_id, usuario_ini_id)
                VALUES (:proyectos_endogenos_id, :estatus, :plantel_id, :usuario_ini_id) returning id";

            $guard = Yii::app()->db->createCommand($sql);
            $usuario = Yii::app()->user->id;
            $estatus = 'A';
            $guard->bindParam(":proyectos_endogenos_id", $existenciaRegistro[$x], PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario, PDO::PARAM_STR);
            // $guard -> bindParam(":usuario_act_id", $this -> usuario_act_id, PDO::PARAM_INT);
            // $guard -> bindParam(":fecha_act", $this -> fecha_act, PDO::PARAM_INT);
            // $guard -> bindParam(":fecha_elim", $this -> fecha_elim, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guardo = $guard->queryScalar();
        }
        return $guardo;
    }

///////////////////////////////////////fin////////////////////////////////////////////
/////verifico si existe el proyecto endogeno en el mismo plantel que se registro/////

    public function verificacionExistencia($plantel_id, $proyectosAgregados) {

        // $todo=array();
        $guardar = array();
        $plantel_id = (int) $plantel_id;
        for ($x = 0; $x < sizeof($proyectosAgregados); $x++) {
            $proyectosAgregado = $proyectosAgregados[$x]['proyecto_endogeno_id'];
            // var_dump($proyectosAgregado);die();
            $proyectosAgregad = (int) $proyectosAgregado;
            $sql = "SELECT id from gplantel.proyectos_endogenos_plantel
                WHERE plantel_id=$plantel_id AND proyectos_endogenos_id=$proyectosAgregad";
            $guard = Yii::app()->db->createCommand($sql);
            $guardo = $guard->queryScalar();
            //    var_dump($guardo); die();
            /*       if($guardo !== false){
              $todo[$x]=$guardo;
              } */

            if ($guardo == false) {
                array_push($guardar, $proyectosAgregad); //si no existe un proyecto endogeno en guardado en la tabla proyectos_endogenos_plantel guarda el id del proyecto endogeno en un arreglo para luego llevarlo a insertarlo
            }
        }
        // var_dump($guardar);
        return $guardar;
        //  var_dump($todo);
    }

//  var_dump($guardar);
//////////////////////////////////fin/////////////////////////////////



    public function getProyectosEndogenos($plantel_id) {
        $sql = "SELECT proyectos_endogenos_id FROM gplantel.proyectos_endogenos_plantel
            WHERE plantel_id = :plantel_id AND estatus = 'A'
            ORDER BY plantel_id ASC";

        $command = $this->getDbConnection()->createCommand($sql);
        $command->bindParam(':plantel_id', $plantel_id, PDO::PARAM_STR);
        return $command->queryAll();
    }

    public function agregarProyectoEndogenoPlantel($proyecto_endogeno_id, $plantel_id) {
        $fecha = date("Y-m-d H:m:s");
        $usuario = 1;
        $sqlBusqueda = "SELECT estatus
                        FROM gplantel.proyectos_endogenos_plantel
                        WHERE
                        plantel_id = :plantel_id AND
                        proyectos_endogenos_id = :proyectos_endogenos_id";

        $commandBusqueda = $this->getDbConnection()->createCommand($sqlBusqueda);
        $commandBusqueda->bindParam(':plantel_id', $plantel_id, PDO::PARAM_STR);
        $commandBusqueda->bindParam(':proyectos_endogenos_id', $proyecto_endogeno_id, PDO::PARAM_STR);
        $estatusActual = $commandBusqueda->queryScalar();
        if (isset($estatusActual) && $estatusActual == 'E') {
            $estatus = 'A';
            $sqlUpdate = "UPDATE gplantel.proyectos_endogenos_plantel
                            SET
                            usuario_act_id = :usuario_act_id,
                            fecha_act = :fecha_act,
                            estatus = :estatus
                            WHERE plantel_id = :plantel_id AND proyectos_endogenos_id = :proyectos_endogenos_id";
            $commandUpdate = $this->getDbConnection()->createCommand($sqlUpdate);
            $commandUpdate->bindParam(':usuario_act_id', $usuario, PDO::PARAM_STR);
            $commandUpdate->bindParam(':fecha_act', $fecha, PDO::PARAM_STR);
            $commandUpdate->bindParam(':estatus', $estatus, PDO::PARAM_STR);
            $commandUpdate->bindParam(':plantel_id', $plantel_id, PDO::PARAM_STR);
            $commandUpdate->bindParam(':proyectos_endogenos_id', $proyecto_endogeno_id, PDO::PARAM_STR);
            $commandUpdate->queryScalar();
        } else
        if (isset($estatusActual) && $estatusActual == false) {
            $estatus = 'A';
            $sqlInsert = "INSERT INTO gplantel.proyectos_endogenos_plantel
                            (proyectos_endogenos_id, usuario_ini_id,usuario_act_id, fecha_act, estatus, plantel_id)
                            VALUES
                            (:proyectos_endogenos_id, :usuario_ini_id,:usuario_act_id, :fecha_act, :estatus, :plantel_id)";

            $commandInsert = $this->getDbConnection()->createCommand($sqlInsert);
            $commandInsert->bindParam(':proyectos_endogenos_id', $proyecto_endogeno_id, PDO::PARAM_STR);
            $commandInsert->bindParam(':usuario_ini_id', $usuario, PDO::PARAM_STR);
            $commandInsert->bindParam(':usuario_act_id', $usuario, PDO::PARAM_STR);
            $commandInsert->bindParam(':fecha_act', $fecha, PDO::PARAM_STR);
            $commandInsert->bindParam(':estatus', $estatus, PDO::PARAM_STR);
            $commandInsert->bindParam(':plantel_id', $plantel_id, PDO::PARAM_STR);
            $commandInsert->queryScalar();
        }
        return $this->getProyectosEndogenos($plantel_id);
    }

    public function eliminarProyectoEndogenoPlantel($proyecto_endogeno_id, $plantel_id) {
        $fecha = date("Y-m-d H:m:s");
        $usuario = 1;
        $estatus = 'E';
        $sqlUpdate = "UPDATE gplantel.proyectos_endogenos_plantel
                        SET
                        usuario_act_id = :usuario_act_id,
                        fecha_act = :fecha_act,
                        fecha_elim = :fecha_elim,
                        estatus = :estatus
                        WHERE plantel_id = :plantel_id AND proyectos_endogenos_id = :proyectos_endogenos_id";
        $commandUpdate = $this->getDbConnection()->createCommand($sqlUpdate);
        $commandUpdate->bindParam(':usuario_act_id', $usuario, PDO::PARAM_STR);
        $commandUpdate->bindParam(':fecha_act', $fecha, PDO::PARAM_STR);
        $commandUpdate->bindParam(':fecha_elim', $fecha, PDO::PARAM_STR);
        $commandUpdate->bindParam(':estatus', $estatus, PDO::PARAM_STR);
        $commandUpdate->bindParam(':plantel_id', $plantel_id, PDO::PARAM_STR);
        $commandUpdate->bindParam(':proyectos_endogenos_id', $proyecto_endogeno_id, PDO::PARAM_STR);
        $commandUpdate->queryScalar();
        return $this->getProyectosEndogenos($plantel_id);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProyectosEndogenosPlantel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

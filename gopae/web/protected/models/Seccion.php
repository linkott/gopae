<?php

/**
 * This is the model class for table "gplantel.seccion".
 *
 * The followings are the available columns in table 'gplantel.seccion':
 * @property integer $id
 * @property string $nombre
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property SeccionPlantel[] $seccionPlantels
 */
class Seccion extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.seccion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre', 'required', 'message' => 'El campo {attribute} no debe estar vacio'),
            array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 1),
            //  array('nombre', 'match', 'pattern' => '/^([^a-zñ ])+$/', 'message' => 'Por Favor Introduzca los datos correctos, La sección solo puede contener letras.'),
            //array('fecha_ini, fecha_act, fecha_elim', 'length', 'max'=>6),
            array('estatus', 'length', 'max' => 1),
            array('nombre', 'unique', 'message' => 'El campo {attribute} no se puede repetir'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'seccionPlantels' => array(self::HAS_MANY, 'SeccionPlantel', 'seccion_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
	    'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre de Sección',
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
        if (!is_numeric($this->nombre)) {
            $criteria->addSearchCondition('nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');
        }
        //$criteria->compare('nombre',$this->nombre);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        
        if ($this->estatus === 'A' || $this->estatus === 'E') {
            $criteria->compare('estatus', $this->estatus);
        }
        $sort = new CSort();
        $sort->defaultOrder = 'nombre ASC, estatus ASC';
        //Va a ordenar la tabla utilizando el campo id_representacion en forma descendente "DESC",

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => 10
            ),
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    public function validaNombreSeccion($nombre) {

        $sql = "SELECT id 
                    FROM gplantel.seccion
                    WHERE nombre = :nombre";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $resultado = $consulta->queryAll();
       // var_dump($resultado);
        return $resultado;
    }

    public function eliminarSeccion($idSeccion) {

        $usuario_id = Yii::app()->user->id;
        $estatus = 'E';
        $fecha = date('Y-m-d H:i:s');

        $sql = "UPDATE gplantel.seccion
                    SET estatus=:estatus, fecha_elim=:fecha_elim, usuario_act_id=:usuario_act_id
                    WHERE id=:id ";
        $guard = Yii::app()->db->createCommand($sql);

        $guard->bindParam(":usuario_act_id", $usuario_id, PDO::PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $guard->bindParam(":fecha_elim", $fecha, PDO::PARAM_INT);
        $guard->bindParam(":id", $idSeccion, PDO::PARAM_INT);
        $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando actualiza y 0 cuando no actualiza
        // var_dump($resulatadoGuardo); die();
        return $resulatadoGuardo;
    }

    public function activarSeccion($idSeccion) {

        $usuario_id = Yii::app()->user->id;
        $estatus = 'A';
        $fecha_ini = date('Y-m-d H:i:s');
        $fecha_elim= null;
        $fecha_act= null;
        $usuarioAct= null;

        $sql = "UPDATE gplantel.seccion
                    SET estatus=:estatus, fecha_act=:fecha_act, usuario_ini_id=:usuario_ini_id, fecha_ini=:fecha_ini, fecha_elim=:fecha_elim, usuario_act_id=:usuario_act_id
                    WHERE id=:id ";
        $guard = Yii::app()->db->createCommand($sql);

        $guard->bindParam(":usuario_ini_id", $usuario_id, PDO::PARAM_INT);
        $guard->bindParam(":usuario_act_id", $usuarioAct, PDO::PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $guard->bindParam(":fecha_act", $fecha_act, PDO::PARAM_INT);
        $guard->bindParam(":fecha_ini", $fecha_ini, PDO::PARAM_INT);
        $guard->bindParam(":fecha_elim", $fecha_elim, PDO::PARAM_INT);
        $guard->bindParam(":id", $idSeccion, PDO::PARAM_INT);
        $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando actualiza y 0 cuando no actualiza
        // var_dump($resulatadoGuardo); die();
        return $resulatadoGuardo;
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Seccion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

<?php

/**
 * This is the model class for table "gplantel.aula".
 *
 * The followings are the available columns in table 'gplantel.aula':
 * @property integer $id
 * @property string $nombre
 * @property string $observacion
 * @property integer $capacidad
 * @property integer $condicion_infraestructura_id
 * @property integer $tipo_aula_id
 * @property integer $plantel_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property CondicionInfraestructura $condicionInfraestructura
 * @property UsergroupsUser $usuarioIni
 * @property Plantel $plantel
 * @property TipoAula $tipoAula
 */
class Aula extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.aula';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, capacidad, condicion_infraestructura_id, tipo_aula_id', 'required', 'message' => 'El campo {attribute} esta vacio.'),
            array('capacidad, condicion_infraestructura_id, tipo_aula_id, plantel_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 20),
            array('observacion', 'length', 'max' => 200),
            array('estatus', 'length', 'max' => 1),
            array('capacidad', 'numerical', 'integerOnly' => true, 'min' => 1),
            array('fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, observacion, capacidad, condicion_infraestructura_id, tipo_aula_id, plantel_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'condicionInfraestructura' => array(self::BELONGS_TO, 'CondicionInfraestructura', 'condicion_infraestructura_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
            'tipoAula' => array(self::BELONGS_TO, 'TipoAula', 'tipo_aula_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'observacion' => 'Observacion',
            'capacidad' => 'Capacidad',
            'condicion_infraestructura_id' => 'Condicion Infraestructura',
            'tipo_aula_id' => 'Tipo Aula',
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
        $criteria->addSearchCondition('nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');

        //$criteria->compare('nombre',$this->nombre,true);
        $criteria->compare('observacion', $this->observacion, true);
        if (is_numeric($this->capacidad)) {
            if (strlen($this->capacidad) < 10) {
                $criteria->compare('capacidad', $this->capacidad);
            }
        }

        if (is_numeric($this->condicion_infraestructura_id)) {
            if (strlen($this->condicion_infraestructura_id) < 10) {
                $criteria->compare('condicion_infraestructura_id', $this->condicion_infraestructura_id);
            }
        }
        $criteria->compare('tipo_aula_id', $this->tipo_aula_id);

        //$criteria->compare('plantel_id',$this->plantel_id);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);

        $url = $_SERVER['REQUEST_URI'];
        $separarUrl = explode('/', $url);
        $separarUrl = $separarUrl[count($separarUrl) - 1];

        //$plantel_id = Yii::app()->getSession()->add('plantel_id', 46823);
        //$criteria->addCondition('plantel_id = 46823');

        if (isset($_GET['id']) && ($_GET['id'] != null)) {
            $plantel_id = base64_decode($_GET['id']);
            $criteria->addCondition('plantel_id = ' . $plantel_id);
        } else {
            if (isset($this->plantel_id)) {
                $plantel_id = (int) $this->plantel_id;
            } else {
                $plantel_id = Yii::app()->getSession()->get('plantel_id');
            }
            $criteria->addCondition('plantel_id = ' . $plantel_id);
        }

        $sort = new CSort();
        $sort->defaultOrder = 'estatus ASC, id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    public function validarAula($plantel_id, $nombre_aula) {
        if (is_numeric($plantel_id)) {
            $sql = "SELECT * FROM gplantel.aula a INNER JOIN
                gplantel.plantel p ON p.id = a.plantel_id
                WHERE a.nombre = '$nombre_aula' AND a.plantel_id = $plantel_id";
            $consulta = Yii::app()->db->createCommand($sql);
            $resultado = $consulta->queryAll();
            return $resultado;
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Aula the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

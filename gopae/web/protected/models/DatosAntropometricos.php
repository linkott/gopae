<?php

/**
 * This is the model class for table "matricula.datos_antropometricos".
 *
 * The followings are the available columns in table 'matricula.datos_antropometricos':
 * @property integer $id
 * @property double $estatura
 * @property double $peso
 * @property string $talla_camisa
 * @property integer $talla_pantalon
 * @property integer $talla_zapato
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $estudiante_id
 *
 * The followings are the available model relations:
 * @property Estudiante $estudiante
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class DatosAntropometricos extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'matricula.datos_antropometricos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('estatura, peso, talla_camisa, talla_pantalon, talla_zapato', 'required', 'on' => 'gestionDatosAntropometricos'),
            array('talla_pantalon, talla_zapato, usuario_ini_id, usuario_act_id, estudiante_id', 'numerical', 'integerOnly' => true),
            array('peso', 'numerical'),
            array('estatura', 'numerical', 'integerOnly' => true, 'on' => 'nuevoEstudiante'),
            array('estatura', 'rangoEstatura'),
            array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 6),
            array('estatus', 'length', 'max' => 1),
            array('talla_camisa', 'safe'),
            array('estatura,talla_pantalon,talla_zapato,talla_camisa,peso ','required','on'=>'CrearEstudianteCompleto'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, estatura, peso, talla_camisa, talla_pantalon, talla_zapato, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, estudiante_id', 'safe', 'on' => 'search'),
        );
    }

    public function rangoEstatura($propiedad, $params = null) {
        if (empty($this->estatura)) {
            
        } else if (!($this->estatura < 2.51 and $this->estatura > 0.39)) {
            $this->addError($propiedad, 'La estatura esta comprendida entre 0.40 y 2.50 metros');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'estudiante' => array(self::BELONGS_TO, 'Estudiante', 'estudiante_id'),
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
            'estatura' => 'Estatura',
            'peso' => 'Peso',
            'talla_camisa' => 'Talla Camisa',
            'talla_pantalon' => 'Talla Pantalon',
            'talla_zapato' => 'Talla Zapato',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'estudiante_id' => 'Estudiante',
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
        $criteria->compare('estatura', $this->estatura);
        $criteria->compare('peso', $this->peso);
        $criteria->compare('talla_camisa', $this->talla_camisa, true);
        $criteria->compare('talla_pantalon', $this->talla_pantalon);
        $criteria->compare('talla_zapato', $this->talla_zapato);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('estudiante_id', $this->estudiante_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DatosAntropometricos the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

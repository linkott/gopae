<?php

/**
 * This is the model class for table "titulo.estatus_titulo".
 *
 * The followings are the available columns in table 'titulo.estatus_titulo':
 * @property integer $id
 * @property string $nombre
 * @property integer $puede_volver
 * @property integer $punto_avance
 * @property integer $punto_final
 * @property integer $consecutivo
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property PapelMoneda[] $papelMonedas
 * @property Titulo[] $titulos
 * @property SeguimientoPapelMoneda[] $seguimientoPapelMonedas
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class EstatusTitulo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'titulo.estatus_titulo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('puede_volver, punto_avance, punto_final, consecutivo, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 150),
            array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 6),
            array('estatus', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, puede_volver, punto_avance, punto_final, consecutivo, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'papelMonedas' => array(self::HAS_MANY, 'PapelMoneda', 'estatus_actual_id'),
            'titulos' => array(self::HAS_MANY, 'Titulo', 'estatus_actual_id'),
            'seguimientoPapelMonedas' => array(self::HAS_MANY, 'SeguimientoPapelMoneda', 'estatus_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Este el campo primary key de la tabla.',
            'nombre' => 'Nombre de la estatus.',
            'puede_volver' => 'Puede volver a un estatus anterior.',
            'punto_avance' => 'Puede avanzar a un estatus siguiente.',
            'punto_final' => 'No puede cambiar de estatus.',
            'consecutivo' => 'Es la secuencia de los diferentes estatus.',
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
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('puede_volver', $this->puede_volver);
        $criteria->compare('punto_avance', $this->punto_avance);
        $criteria->compare('punto_final', $this->punto_final);
        $criteria->compare('consecutivo', $this->consecutivo);
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

    public function selectLiquidacion() {


        $sql = "SELECT id, nombre"
                . " FROM titulo.estatus_titulo"
                . " WHERE id=7 OR id=8 OR id=9 OR id=6 OR id=10"
                . " ORDER BY nombre ASC";
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EstatusTitulo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

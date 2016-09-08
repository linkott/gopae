<?php

/**
 * This is the model class for table "public.instructivo".
 *
 * The followings are the available columns in table 'public.instructivo':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $url
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class Instructivo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'public.instructivo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre, url', 'length', 'max' => 200),
            array('estatus', 'length', 'max' => 1),
            array('descripcion', 'safe'),
            array('id, nombre, descripcion, url, usuario_ini_id, usuario_act_id, fecha_ini, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usuarioAct' => array(self::BELONGS_TO, 'UserGroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UserGroupsUser', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'url' => 'Url',
            'usuario_ini_id' => 'Usuario Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_ini' => 'Fecha Ini',
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
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.nombre', strtoupper($this->nombre), true);
        $criteria->compare('t.descripcion', strtoupper($this->descripcion), true);
        $criteria->compare('t.url', $this->url, true);
        $criteria->compare('t.usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('t.usuario_act_id', $this->usuario_act_id);
        $criteria->compare('t.fecha_act', $this->fecha_act, true);
        $criteria->compare('t.fecha_elim', $this->fecha_elim, true);
        $criteria->compare('t.estatus', $this->estatus, true);
        if (strlen($this->fecha_ini) > 0 && Utiles::dateCheck($this->fecha_ini)) {
            $this->fecha_ini = Utiles::transformDate($this->fecha_ini);
            $criteria->addSearchCondition("TO_CHAR(t.fecha_ini, 'YYYY-MM-DD')", $this->fecha_ini, false, 'AND', '=');
        } else {
            $this->fecha_ini = '';
        }
        $sort = new CSort();
        $sort->defaultOrder = 't.fecha_ini DESC, t.id DESC, t.estatus ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort
        ));
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Instructivo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

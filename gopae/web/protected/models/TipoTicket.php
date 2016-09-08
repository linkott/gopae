<?php

/**
 * This is the model class for table "sistema.tipo_ticket".
 *
 * The followings are the available columns in table 'sistema.tipo_ticket':
 * @property integer $id
 * @property string $nombre
 * @property string $estatus
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property Integer $unidad_resp_ticket_id
 *
 * The followings are the available model relations:
 * @property Ticket[] $tickets
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class TipoTicket extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sistema.tipo_ticket';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, unidad_resp_ticket_id', 'required'),
            array('usuario_ini_id, usuario_act_id, unidad_resp_ticket_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 100),
            array('estatus', 'length', 'max' => 1),
            //array('fecha_ini, fecha_act, fecha_elim', 'length'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, estatus, usuario_ini_id, usuario_act_id, fecha_ini, fecha_act, fecha_elim, unidad_resp_ticket_id', 'safe', 'on' => 'search'),
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
            'unidadResponsable' => array(self::BELONGS_TO,'UnidadRespTicket','unidad_resp_ticket_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'estatus' => 'Estatus',
            'usuario_ini_id' => 'Usuario Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_ini' => 'Fecha Ini',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'unidad_resp_ticket_id' => 'Unidad Responsable'
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

        $criteria->with = array('unidadResponsable');

        $criteria->compare('t.id', $this->id);
        //$criteria->compare('nombre', strtoupper($this->nombre), true);
        $criteria->addSearchCondition('t.nombre','%'.$this->nombre. '%',false,'AND','ILIKE');
        $criteria->compare('t.estatus', $this->estatus, true);
        $criteria->compare('t.usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('t.usuario_act_id', $this->usuario_act_id);
        $criteria->compare('t.fecha_ini', $this->fecha_ini, true);
        $criteria->compare('t.fecha_act', $this->fecha_act, true);
        $criteria->compare('t.fecha_elim', $this->fecha_elim, true);

        if(is_numeric($this->unidad_resp_ticket_id)){
            $criteria->compare('t.unidad_resp_ticket_id', $this->unidad_resp_ticket_id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TipoTicket the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function buscar($id) {
        $sql = "SELECT * FROM sistema.tipo_ticket m
        LEFT JOIN seguridad.usergroups_user u ON u.id = m.usuario_ini_id
        WHERE m.id = " . $id;
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    public function nombre($id) {
        $sql = 'SELECT t.tipo_ticket_id as id FROM sistema.tipo_ticket tt
                INNER JOIN sistema.ticket t ON t.tipo_ticket_id = tt.id
                WHERE t.id = :id';
        //$sql="select nombre_tic from sistema.tipo_ticket where nombre_tic = :nombre";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

}

<?php

/**
 * This is the model class for table "sistema.unidad_grupo".
 *
 * The followings are the available columns in table 'sistema.unidad_grupo':
 * @property integer $id
 * @property integer $group_id
 * @property integer $unidad_resp_ticket_id
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $estatus
 * @property string $fecha_ini
 * @property string $fecha_act
 *
 * The followings are the available model relations:
 * @property UsergroupsGroup $group
 * @property UnidadRespTicket $unidadRespTicket
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class UnidadGrupo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sistema.unidad_grupo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, unidad_resp_ticket_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('estatus', 'length', 'max'=>1),
			array('fecha_ini, fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, group_id, unidad_resp_ticket_id, usuario_ini_id, usuario_act_id, estatus, fecha_ini, fecha_act, fecha_elim', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'group' => array(self::BELONGS_TO, 'UsergroupsGroup', 'group_id'),
			'unidadRespTicket' => array(self::BELONGS_TO, 'UnidadRespTicket', 'unidad_resp_ticket_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_id' => 'Group',
			'unidad_resp_ticket_id' => 'Unidad Resp Ticket',
			'usuario_ini_id' => 'Usuario Ini',
			'usuario_act_id' => 'Usuario Act',
			'estatus' => 'Estatus',
			'fecha_ini' => 'Fecha Ini',
			'fecha_act' => 'Fecha Act',
                        'fecha_elim' => 'Fecha Eli',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
               // var_dump(Yii::app()->getSession()->get('unidad')); die();
               // $criteria->addCondition($this->unidad_resp_ticket_id, Yii::app()->getSession()->get('unidad'));
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.group_id',$this->group_id);
		$criteria->compare('t.unidad_resp_ticket_id',Yii::app()->getSession()->get('id'));
		$criteria->compare('t.usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('t.usuario_act_id',$this->usuario_act_id);
		$criteria->compare('t.estatus',$this->estatus,true);
		$criteria->compare('t.fecha_ini',$this->fecha_ini,true);
		$criteria->compare('t.fecha_act',$this->fecha_act,true);
                $criteria->compare('t.fecha_elim',$this->fecha_elim,true);

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
	 * @return UnidadGrupo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function validaGrupoExistente($id){
            $resultado='';
            $sql="select g.id, u.id as grupo_id, g.groupname, g.description, ut.correo_unidad, ut.nombre, u.estatus  from sistema.unidad_grupo u
           inner join seguridad.usergroups_group g on g.id=u.group_id
           inner join sistema.unidad_resp_ticket ut on u.unidad_resp_ticket_id=ut.id 
            where  ut.id=:id and u.estatus!='E'";
           $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(':id', $id);
        $resultado = $consulta->queryAll();
        return $resultado;
        }
        
        public function eliminarGrupo($id){
            $resultado='';
            $sql="update sistema.unidad_grupo set estatus='E'  where id=$id";
            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(':id', $id);
        $resultado = $consulta->queryAll();
        return $resultado;
        }

        public function validaGrupoExistenteV($id){
            $resultado='';
            $sql="select g.id, u.id as grupo_id, g.groupname, g.description, ut.correo_unidad, ut.nombre, u.estatus  from sistema.unidad_grupo u
           inner join seguridad.usergroups_group g on g.id=u.group_id
           inner join sistema.unidad_resp_ticket ut on u.unidad_resp_ticket_id=ut.id
            where  ut.id=:id";
           $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(':id', $id);
        $resultado = $consulta->queryAll();
        return $resultado;
        }
        public function guardarGrupo($grupo,$id){
            $estatus='A';
        $sql = "INSERT INTO sistema.unidad_grupo
              (group_id, unidad_resp_ticket_id,estatus)
              VALUES ('" .$grupo. "', '" .$id. "','".$estatus."') returning id";
        //$group_id = 29;
        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":group_id", $grupo, PDO:: PARAM_STR);
        $guard->bindParam(":id", $id, PDO:: PARAM_INT);
        $resultado = $guard->queryScalar();
        }
}

<?php

/**
 * This is the model class for table "sistema.unidad_resp_ticket".
 *
 * The followings are the available columns in table 'sistema.unidad_resp_ticket':
 * @property integer $id
 * @property string $correo_unidad
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $telefono_unidad
 * @property string $nombre
 * @property string $correo_persona
 * @property string $telefono_persona
 * @property integer $usuario_autoridad_id
 * @property string $estatus
 * @property string $fecha_ini
 * @property string $fecha_act
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAutoridad
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property Ticket[] $tickets
 * @property Ticket[] $tickets1
 * @property DistribucionTicket[] $distribucionTickets
 */
class UnidadRespTicket extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sistema.unidad_resp_ticket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('nombre','unique'),
                        array('correo_unidad', 'email'),
			array('usuario_ini_id, usuario_act_id, usuario_autoridad_id', 'numerical', 'integerOnly'=>true),
			array('correo_unidad, nombre', 'length', 'max'=>100),
                        array('correo_unidad, nombre, telefono_unidad', 'required'),
			array('estatus', 'length', 'max'=>1),
			array('fecha_ini, fecha_act', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, correo_unidad, usuario_ini_id, usuario_act_id, telefono_unidad, nombre, correo_persona, telefono_persona, usuario_autoridad_id, estatus, fecha_ini, fecha_act', 'safe', 'on'=>'search'),
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
			'usuarioAutoridad' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_autoridad_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'UserGroupsUser', 'usuario_act_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UserGroupsUser', 'usuario_ini_id'),
			'tickets' => array(self::HAS_MANY, 'Ticket', 'bandeja_actual_id'),
			'tickets1' => array(self::HAS_MANY, 'Ticket', 'bandeja_anterior_id'),
			'distribucionTickets' => array(self::HAS_MANY, 'DistribucionTicket', 'unidad_resp_ticket_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'correo_unidad' => 'Correo Unidad',
			'usuario_ini_id' => 'Usuario Ini',
			'usuario_act_id' => 'Usuario Act',
			'telefono_unidad' => 'Telefono Unidad',
			'nombre' => 'Nombre',
			'usuario_autoridad_id' => 'Usuario Autoridad',
			'estatus' => 'Estatus',
			'fecha_ini' => 'Fecha Ini',
			'fecha_act' => 'Fecha Act',
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
		$criteria->compare('id',$this->id);
		$criteria->compare('correo_unidad',$this->correo_unidad,true);
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('telefono_unidad',$this->telefono_unidad,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('usuario_autoridad_id',$this->usuario_autoridad_id);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('fecha_act',$this->fecha_act,true);

                


        $sort = new CSort();
        $sort->defaultOrder = 'estatus ASC, id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
	}
        
        public static function getUnidadesResponsableUsuario($usuarioId, $usuarioCedula=null){
            
            $sql = "SELECT DISTINCT
                        un.id, un.nombre
                    FROM sistema.unidad_resp_ticket un INNER JOIN sistema.unidad_grupo ug ON ug.unidad_resp_ticket_id = un.id
                   INNER JOIN seguridad.usergroups_group g ON ug.group_id = g.id
                   INNER JOIN seguridad.usergroups_user u ON u.group_id = g.id WHERE ";
            
            if(is_numeric($usuarioId)){
                $sql .= ' u.id = :id ';
                $unidad = Yii::app()->db->createCommand($sql);
                $unidad->bindParam(":id", $usuarioId, PDO::PARAM_INT);
                $result = $unidad->queryAll();
            }elseif(is_numeric($usuarioId)){
                $sql .= ' u.cedula = :cedula ';
                $unidad = Yii::app()->db->createCommand($sql);
                $unidad->bindParam(":cedula", $usuarioCedula, PDO::PARAM_INT);
                $result = $unidad->queryAll();
            }else{
                $result = null;
            }
            
//            var_dump($usuarioId);
//            var_dump($sql);
//            var_dump($result);
//            die();
            
            return $result;
            
        }

        public function getDataUnidadResponsable($id){
        $sql = "select u.id, u.nombre from sistema.unidad_resp_ticket u where u.id=(select max(u.id) from sistema.unidad_resp_ticket u)";
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    public function getDataTipoTicket(){
        $sql = "select t.nombre, t.id from sistema.tipo_ticket t";
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }
    public function getDataEstado(){
        $sql = "select e.nombre, e.id from public.estado e";
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UnidadRespTicket the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}        
        
}

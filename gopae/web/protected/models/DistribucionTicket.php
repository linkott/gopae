<?php

/**
 * This is the model class for table "sistema.distribucion_ticket".
 *
 * The followings are the available columns in table 'sistema.distribucion_ticket':
 * @property integer $id
 * @property integer $tipo_ticket_id
 * @property integer $estado_id
 * @property integer $unidad_resp_ticket_id
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $estatus
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $correo_electronico
 * @property string $telefono
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property Estado $estado
 * @property TipoTicket $tipoTicket
 * @property UnidadRespTicket $unidadRespTicket
 */
class DistribucionTicket extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sistema.distribucion_ticket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        //array('correo_electronico,telefono', 'required'),
			array('tipo_ticket_id, estado_id, unidad_resp_ticket_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('estatus', 'length', 'max'=>1),
			array('correo_electronico', 'length', 'max'=>180),
			array('telefono', 'length', 'max'=>20),
			array('fecha_ini, fecha_act', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tipo_ticket_id, estado_id, unidad_resp_ticket_id, usuario_ini_id, usuario_act_id, estatus, fecha_ini, fecha_act, correo_electronico, telefono', 'safe', 'on'=>'search'),
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
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
			'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
			'tipoTicket' => array(self::BELONGS_TO, 'TipoTicket', 'tipo_ticket_id'),
			'unidadRespTicket' => array(self::BELONGS_TO, 'UnidadRespTicket', 'unidad_resp_ticket_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipo_ticket_id' => 'Tipo Ticket',
			'estado_id' => 'Estado',
			'unidad_resp_ticket_id' => 'Unidad Resp Ticket',
			'usuario_ini_id' => 'Usuario Ini',
			'usuario_act_id' => 'Usuario Act',
			'estatus' => 'Estatus',
			'fecha_ini' => 'Fecha Ini',
			'fecha_act' => 'Fecha Act',
			'correo_electronico' => 'Correo Electronico',
			'telefono' => 'Telefono',
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
		$criteria->compare('tipo_ticket_id',$this->tipo_ticket_id);
		$criteria->compare('estado_id',$this->estado_id);
		$criteria->compare('unidad_resp_ticket_id',Yii::app()->getSession()->get('id'));
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('fecha_act',$this->fecha_act,true);
		$criteria->compare('correo_electronico',$this->correo_electronico,true);
		$criteria->compare('telefono',$this->telefono,true);
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
	 * @return DistribucionTicket the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

         public function getDistribucion() {
        $resultado = NULL;
             $query = "select u.correo_unidad,
		       tip.nombre as nombre_tipo_ticket,
		       e.nombre,
		       tic.descripcion,
		       d.tipo_ticket_id
                    from sistema.unidad_resp_ticket u
                    inner join sistema.distribucion_ticket d
			on u.id=d.unidad_resp_ticket_id
                    inner join sistema.tipo_ticket tp
			on tp.id=d.tipo_ticket_id
                    inner join public.estado e
			on e.id=d.estado_id
                    inner join sistema.ticket tic
			on tp.id=tic.tipo_ticket_id
                    inner join sistema.tipo_ticket tip
			on tip.id=tic.tipo_ticket_id
	        where u.id=".Yii::app()->getSession()->get('id');
            echo "<pre>$query \n </pre>";
            $consulta = Yii::app()->db->createCommand($query);
            $consulta->bindParam(':ticket_id', $id);
            $resultado = $consulta->queryAll();
       return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 15,
            )
        ));
    }
    
    public function buscarDistribucion($id){
        $resultado = "";
             $query = "select d.id as distribucion_id, u.id, e.id as estado_id, d.correo_electronico,
		       tp.nombre as tipo_ticket,
		       e.nombre as estado,
                       u.nombre as unidad,
		       d.tipo_ticket_id,
                       d.telefono
                    from sistema.unidad_resp_ticket u
                    inner join sistema.distribucion_ticket d
			on u.id=d.unidad_resp_ticket_id
                    inner join sistema.tipo_ticket tp
			on tp.id=d.tipo_ticket_id
                    inner join public.estado e
			on e.id=d.estado_id  
	        where u.id=$id AND d.estatus!='E'";
            $consulta = Yii::app()->db->createCommand($query);
            $consulta->bindParam(':unidad_id', $id);
            $resultado = $consulta->queryAll();
            return $resultado;

}


public function buscarDistribucionC($id){
        $resultado = "";
             $query = "select u.id, e.id as estado_id, d.correo_electronico,
		       tp.nombre as tipo_ticket,
		       e.nombre as estado,
                       u.nombre as unidad,
		       d.tipo_ticket_id,
                       d.telefono
                    from sistema.unidad_resp_ticket u
                    inner join sistema.distribucion_ticket d
			on u.id=d.unidad_resp_ticket_id
                    inner join sistema.tipo_ticket tp
			on tp.id=d.tipo_ticket_id
                    inner join public.estado e
			on e.id=d.estado_id  
	        where u.id=$id";
            $consulta = Yii::app()->db->createCommand($query);
            $consulta->bindParam(':unidad_id', $id);
            $resultado = $consulta->queryAll();
            return $resultado;

}


    public function guardarDistribucion($distribucionTic) {
        $resultado='';
        $sql = "INSERT INTO sistema.distribucion_ticket
              (tipo_ticket_id, estado_id, unidad_resp_ticket_id,
              usuario_ini_id,fecha_ini, estatus, telefono,
              correo_electronico)
              VALUES ('".$distribucionTic['tipoTicket']."','".$distribucionTic['estado']."', '".$distribucionTic['id'] . "','".$distribucionTic['usuarioIni'] ."','" . $distribucionTic['fechaIni']."','". $distribucionTic['estatus'] ."','" . $distribucionTic['telefono'] . "','" . $distribucionTic['correo']."') returning id";
            $guard = Yii::app()->db->createCommand($sql);
            $resulatado= $guard->queryScalar();
            return $resultado;
}


 public function eliminarDistribucion($id){
            $resultado='';
            $sql="update sistema.distribucion_ticket set estatus='E'  where id=$id";
            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(':id', $id);
        $resultado = $consulta->queryAll();
        return $resultado;
        }
}

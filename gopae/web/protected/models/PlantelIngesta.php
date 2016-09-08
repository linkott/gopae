<?php

/**
 * This is the model class for table "gplantel.plantel_ingesta".
 *
 * The followings are the available columns in table 'gplantel.plantel_ingesta':
 * @property integer $id
 * @property integer $plantel_id
 * @property integer $tipo_ingesta_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $cantidad_comensales
 *
 * The followings are the available model relations:
 * @property Plantel $plantel
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 * @property TipoMenu $tipoIngesta
 */
class PlantelIngesta extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gplantel.plantel_ingesta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plantel_id, tipo_ingesta_id, usuario_ini_id, usuario_act_id, cantidad_comensales', 'numerical', 'integerOnly'=>true),
            array('plantel_id, tipo_ingesta_id', 'ECompositeUniqueValidator', 'attributesToAddError'=>'tipo_ingesta_id', 'message'=>'Este tipo de ingesta ya ha sido registrado en este plantel.'),
			array('estatus', 'length', 'max'=>1),
            array('plantel_id, tipo_ingesta_id, cantidad_comensales, usuario_ini_id', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, plantel_id, tipo_ingesta_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
			'tipoIngesta' => array(self::BELONGS_TO, 'TipoMenu', 'tipo_ingesta_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'plantel_id' => 'Plantel',
			'tipo_ingesta_id' => 'Tipo Ingesta',
			'usuario_ini_id' => 'Usuario Ini',
			'fecha_ini' => 'Fecha Ini',
			'usuario_act_id' => 'Usuario Act',
			'fecha_act' => 'Fecha Act',
			'fecha_elim' => 'Fecha Elim',
			'estatus' => 'Estatus',
            'cantidad_comensales' => 'Cantidad de Comensales',
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
		$criteria->compare('plantel_id',$this->plantel_id);

                if (isset($_GET['id']) && ($_GET['id'] != null)) {
                    $plantel_id = base64_decode($_GET['id']);
                    $criteria->compare('plantel_id', $plantel_id);
                }
        
		$criteria->compare('tipo_ingesta_id',$this->tipo_ingesta_id);
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('fecha_act',$this->fecha_act,true);
		$criteria->compare('fecha_elim',$this->fecha_elim,true);
		$criteria->compare('estatus',$this->estatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function obtenerTipoMenu($plantel_id){
            $cacheIndex = 'INGST:'.$plantel_id;
            $resultado = Yii::app()->cache->get($cacheIndex);

            if(!$resultado){
                if(is_numeric($plantel_id)){
                    $sql = "SELECT p.id, p.plantel_id, p.tipo_ingesta_id, p.cantidad_comensales, t.nombre FROM gplantel.plantel_ingesta p INNER JOIN nutricion.tipo_menu t ON t.id = p.tipo_ingesta_id WHERE t.estatus = 'A' AND p.plantel_id = " . addslashes($plantel_id).' ORDER BY p.tipo_ingesta_id';
                    $command = Yii::app()->db->createCommand($sql);
                    $resultado = $command->queryAll();
                    if($resultado){
                        Yii::app()->cache->set($cacheIndex, $resultado);
                    }
                }
                else{
                    return null;
                }
            }

            return $resultado;
        }
        
        public function eliminarIngesta($id){
            if(is_numeric($id)){
                $sql = "DELETE FROM gplantel.plantel_ingesta WHERE id = :id";
                $resultado = Yii::app()->db->createCommand($sql);
                $resultado->bindParam(":id", $id, PDO::PARAM_INT);
                $r = $resultado->execute();
                return $r;
            }
            else{
                return null;
            }
        }

    public function beforeInsert(){
        if((is_null($this->id) && !is_numeric($this->id)) || $this->isNewRecord) {
            $this->fecha_ini = date('Y-m-d H:i:s');
            $this->usuario_ini_id = Yii::app()->user->id;
        }
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlantelIngesta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

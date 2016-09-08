<?php

/**
 * This is the model class for table "gplantel.plantel_pae_notificacion".
 *
 * The followings are the available columns in table 'gplantel.plantel_pae_notificacion':
 * @property integer $id
 * @property integer $plantel_pae_id
 * @property string $observacion
 * @property string $pae_activo
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property PlantelPae $plantelPae
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 */
class PlantelPaeNotificacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gplantel.plantel_pae_notificacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plantel_pae_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('observacion', 'length', 'max'=>250),
			array('pae_activo', 'length', 'max'=>10),
			array('estatus', 'length', 'max'=>1),
			array('fecha_ini, fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, plantel_pae_id, observacion, pae_activo, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'plantelPae' => array(self::BELONGS_TO, 'PlantelPae', 'plantel_pae_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'plantel_pae_id' => 'Plantel Pae',
			'observacion' => 'Observacion',
			'pae_activo' => 'Pae Activo',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('plantel_pae_id',$this->plantel_pae_id);
		$criteria->compare('observacion',$this->observacion,true);
		$criteria->compare('pae_activo',$this->pae_activo,true);
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
        
        public function agregarNotificacion($plantel_id, $plantel_pae_id, $observacion, $pae_activo, $cambio_pae_activo, $motivo_inactividad){

            $usuario_ini_id = Yii::app()->user->id;
            $fecha_ini = date('Y-m-d H:i:s');
            $fecha_actualizacion = date('Y-m-d H:i:s');
            $estatus = 'A';
//            var_dump($pae_activo);die();
            $sql = "UPDATE gplantel.plantel_pae SET pae_activo = '$pae_activo', fecha_ultima_actualizacion = '$fecha_actualizacion' WHERE plantel_id = $plantel_id";
            $resultado = Yii::app()->db->createCommand($sql);
//            $resultado->bindParam(":pae_activo", $pae_activo, PDO::PARAM_STR);
//            $resultado->bindParam(":plantel_id", (int) $plantel_id, PDO::PARAM_INT);
            $resul = $resultado->execute();
            
            if($motivo_inactividad == ''){
                $sql = "INSERT INTO gplantel.plantel_pae_notificacion(plantel_pae_id, observacion, pae_activo, usuario_ini_id, fecha_ini, estatus)
                VALUES (:plantel_pae_id, :observacion, :cambio_pae_activo, :usuario_ini_id, :fecha_ini, :estatus)";
                $resultado = Yii::app()->db->createCommand($sql);
            }
            else if($motivo_inactividad != ''){
                $sql = "INSERT INTO gplantel.plantel_pae_notificacion(plantel_pae_id, observacion, pae_activo, usuario_ini_id, fecha_ini, estatus, motivo_id)
                VALUES (:plantel_pae_id, :observacion, :cambio_pae_activo, :usuario_ini_id, :fecha_ini, :estatus, :motivo_id)";
                $resultado = Yii::app()->db->createCommand($sql);
                $resultado->bindParam(":motivo_id", $motivo_inactividad, PDO::PARAM_INT);
            }
            
            $resultado->bindParam(":plantel_pae_id", $plantel_pae_id, PDO::PARAM_INT);
            $resultado->bindParam(":observacion", $observacion, PDO::PARAM_STR);
            $resultado->bindParam(":cambio_pae_activo", $cambio_pae_activo, PDO::PARAM_STR);
            $resultado->bindParam(":usuario_ini_id", $usuario_ini_id, PDO::PARAM_STR);
            $resultado->bindParam(":fecha_ini", $fecha_ini, PDO::PARAM_STR);
            $resultado->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $r[0] = $resultado->execute();
            $r[1] = $fecha_actualizacion;
            
            return $r;
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlantelPaeNotificacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

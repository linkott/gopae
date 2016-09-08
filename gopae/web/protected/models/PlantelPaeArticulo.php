<?php

/**
 * This is the model class for table "gplantel.plantel_pae_articulo".
 *
 * The followings are the available columns in table 'gplantel.plantel_pae_articulo':
 * @property integer $id
 * @property integer $plantel_id
 * @property integer $articulo_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $tipo_articulo_id
 *
 * The followings are the available model relations:
 * @property TipoArticulo $tipoArticulo
 * @property Articulo $articulo
 * @property Plantel $plantel
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 */
class PlantelPaeArticulo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gplantel.plantel_pae_articulo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plantel_id, articulo_id', 'required'),
			array('plantel_id, articulo_id, usuario_ini_id, usuario_act_id, tipo_articulo_id', 'numerical', 'integerOnly'=>true),
			array('estatus', 'length', 'max'=>1),
			array('fecha_ini, fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, plantel_id, articulo_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, tipo_articulo_id', 'safe', 'on'=>'search'),
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
			'tipoArticulo' => array(self::BELONGS_TO, 'TipoArticulo', 'tipo_articulo_id'),
			'articulo' => array(self::BELONGS_TO, 'Articulo', 'articulo_id'),
			'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
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
			'plantel_id' => 'Plantel',
			'articulo_id' => 'Articulo',
			'usuario_ini_id' => 'Usuario Ini',
			'fecha_ini' => 'Fecha Ini',
			'usuario_act_id' => 'Usuario Act',
			'fecha_act' => 'Fecha Act',
			'fecha_elim' => 'Fecha Elim',
			'estatus' => 'Estatus',
			'tipo_articulo_id' => 'Tipo Articulo',
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
	public function search($articulo_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('plantel_id',$this->plantel_id);
		$criteria->compare('articulo_id',$this->articulo_id);
                if($articulo_id){
                    $criteria->compare('tipo_articulo_id',$articulo_id);
                }
                else{
                    $criteria->compare('tipo_articulo_id',$this->articulo_id);
                }
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
        
        public function eliminarEquipo($id){
            if(is_numeric($id)){
                $sql = "DELETE FROM gplantel.plantel_pae_articulo WHERE id = :id";
                $resultado = Yii::app()->db->createCommand($sql);
                $resultado->bindParam(":id", $id, PDO::PARAM_INT);
                $r = $resultado->execute();
                return $r;
            }
            else{
                return null;
            }
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlantelPaeArticulo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

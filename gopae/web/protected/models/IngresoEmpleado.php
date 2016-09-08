<?php

/**
 * This is the model class for table "gestion_humana.ingreso_empleado".
 *
 * The followings are the available columns in table 'gestion_humana.ingreso_empleado':
 * @property string $id
 * @property string $nro_contrato
 * @property string $fecha_ingreso
 * @property integer $talento_humano_id
 * @property integer $categoria_ingreso_id
 * @property integer $tipo_cargo_nominal_id
 * @property integer $cargo_nominal_id
 * @property integer $estructura_organizativa_id
 * @property integer $condicion_nominal_id
 * @property integer $tipo_nomina_id
 * @property integer $plantel_id
 * @property string $observaciones
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $estatus
 * @property string $posee_numero_contrato
 *
 * The followings are the available model relations:
 * @property Plantel $plantel
 * @property EstructuraOrganizativa $estructuraOrganizativa
 * @property TipoNomina $tipoNomina
 * @property CondicionNominal $condicionNominal
 * @property CargoNominal $cargoNominal
 * @property TipoCargoNominal $tipoCargoNominal
 * @property CategoriaIngreso $categoriaIngreso
 * @property TalentoHumano $talentoHumano
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 */
class IngresoEmpleado extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gestion_humana.ingreso_empleado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_ingreso, talento_humano_id, categoria_ingreso_id, tipo_cargo_nominal_id, condicion_nominal_id, tipo_nomina_id, usuario_ini_id, fecha_ini', 'required'),
			array('talento_humano_id, categoria_ingreso_id, tipo_cargo_nominal_id, cargo_nominal_id, estructura_organizativa_id, condicion_nominal_id, tipo_nomina_id, plantel_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('nro_contrato', 'length', 'max'=>20),
			array('estatus', 'length', 'max'=>1),
			array('posee_numero_contrato', 'length', 'max'=>2),
			array('estatus', 'in', 'range'=>array('A', 'I', 'E'), 'allowEmpty'=>false, 'strict'=>true,),
			array('usuario_ini_id', 'default', 'value'=>Yii::app()->user->id, 'on'=>'insert'),
			array('usuario_act_id', 'default', 'value'=>Yii::app()->user->id, 'on'=>'update'),
                        array('fecha_ingreso, talento_humano_id', 'ECompositeUniqueValidator', 'attributesToAddError'=>'fecha_ingreso', 'message'=>'Esta persona ya posee un ingreso en esta fecha.'),
			array('observaciones', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nro_contrato, fecha_ingreso, talento_humano_id, categoria_ingreso_id, tipo_cargo_nominal_id, cargo_nominal_id, estructura_organizativa_id, condicion_nominal_id, tipo_nomina_id, plantel_id, observaciones, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, estatus, posee_numero_contrato', 'safe', 'on'=>'search'),
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
			'estructuraOrganizativa' => array(self::BELONGS_TO, 'EstructuraOrganizativa', 'estructura_organizativa_id'),
			'tipoNomina' => array(self::BELONGS_TO, 'TipoNomina', 'tipo_nomina_id'),
			'condicionNominal' => array(self::BELONGS_TO, 'CondicionNominal', 'condicion_nominal_id'),
			'cargoNominal' => array(self::BELONGS_TO, 'CargoNominal', 'cargo_nominal_id'),
			'tipoCargoNominal' => array(self::BELONGS_TO, 'TipoCargoNominal', 'tipo_cargo_nominal_id'),
			'categoriaIngreso' => array(self::BELONGS_TO, 'CategoriaIngreso', 'categoria_ingreso_id'),
			'talentoHumano' => array(self::BELONGS_TO, 'TalentoHumano', 'talento_humano_id'),
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
			'nro_contrato' => 'Nro Contrato',
			'fecha_ingreso' => 'Fecha Ingreso',
			'talento_humano_id' => 'Talento Humano',
			'categoria_ingreso_id' => 'Categoria Ingreso',
			'tipo_cargo_nominal_id' => 'Tipo Cargo Nominal',
			'cargo_nominal_id' => 'Cargo Nominal',
			'estructura_organizativa_id' => 'Estructura Organizativa',
			'condicion_nominal_id' => 'Condicion Nominal',
			'tipo_nomina_id' => 'Tipo Nomina',
			'plantel_id' => 'Plantel',
			'observaciones' => 'Observaciones',
			'usuario_ini_id' => 'Usuario Ini',
			'fecha_ini' => 'Fecha Ini',
			'usuario_act_id' => 'Usuario Act',
			'fecha_act' => 'Fecha Act',
			'estatus' => 'Estatus',
			'posee_numero_contrato' => 'Posee Numero Contrato',
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

		if(strlen($this->id)>0) $criteria->compare('id',$this->id,true);
		if(strlen($this->nro_contrato)>0) $criteria->compare('nro_contrato',$this->nro_contrato,true);
		if(Utiles::isValidDate($this->fecha_ingreso, 'y-m-d')) $criteria->compare('fecha_ingreso',$this->fecha_ingreso);
		// if(strlen($this->fecha_ingreso)>0) $criteria->compare('fecha_ingreso',$this->fecha_ingreso,true);
		if(is_numeric($this->talento_humano_id)) $criteria->compare('talento_humano_id',$this->talento_humano_id);
		if(is_numeric($this->categoria_ingreso_id)) $criteria->compare('categoria_ingreso_id',$this->categoria_ingreso_id);
		if(is_numeric($this->tipo_cargo_nominal_id)) $criteria->compare('tipo_cargo_nominal_id',$this->tipo_cargo_nominal_id);
		if(is_numeric($this->cargo_nominal_id)) $criteria->compare('cargo_nominal_id',$this->cargo_nominal_id);
		if(is_numeric($this->estructura_organizativa_id)) $criteria->compare('estructura_organizativa_id',$this->estructura_organizativa_id);
		if(is_numeric($this->condicion_nominal_id)) $criteria->compare('condicion_nominal_id',$this->condicion_nominal_id);
		if(is_numeric($this->tipo_nomina_id)) $criteria->compare('tipo_nomina_id',$this->tipo_nomina_id);
		if(is_numeric($this->plantel_id)) $criteria->compare('plantel_id',$this->plantel_id);
		if(strlen($this->observaciones)>0) $criteria->compare('observaciones',$this->observaciones,true);
		if(is_numeric($this->usuario_ini_id)) $criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		if(Utiles::isValidDate($this->fecha_ini, 'y-m-d')) $criteria->compare('fecha_ini',$this->fecha_ini);
		// if(strlen($this->fecha_ini)>0) $criteria->compare('fecha_ini',$this->fecha_ini,true);
		if(is_numeric($this->usuario_act_id)) $criteria->compare('usuario_act_id',$this->usuario_act_id);
		if(Utiles::isValidDate($this->fecha_act, 'y-m-d')) $criteria->compare('fecha_act',$this->fecha_act);
		// if(strlen($this->fecha_act)>0) $criteria->compare('fecha_act',$this->fecha_act,true);
		if(in_array($this->estatus, array('A', 'I', 'E'))) $criteria->compare('estatus',$this->estatus,true);
		if(strlen($this->posee_numero_contrato)>0) $criteria->compare('posee_numero_contrato',$this->posee_numero_contrato,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function ingresoMadreTrabajadora($talentoHumanoId,$poseeNumeroContrato,$nroContrato,$fechaIngreso,$categoriaIngresoId,$tipoCargoNominalId,$cargoNominalId,$estructuraOrganizativaId,$condicionNominalId,$tipoNominaId,$plantelId,$observacion, $usuarioIniId) {
            
            $sql = "SELECT gestion_humana.ingreso_empleado_madre_cocinera( 
                        ?::int,
                        ?::varchar,
                        ?::varchar,
                        ?::date,
                        ?::int,
                        ?::int,
                        ?::int,
                        ?::int,
                        ?::int,
                        ?::int,
                        ?::int,
                        ?::varchar,
                        ?::int
                    );";
            $guard = Yii::app()->db->createCommand($sql);

            $guard->bindParam(1,$talentoHumanoId,PDO::PARAM_INT);
            $guard->bindParam(2,$poseeNumeroContrato,PDO::PARAM_STR);
            $guard->bindParam(3,$nroContrato,PDO::PARAM_STR);
            $guard->bindParam(4,$fechaIngreso,PDO::PARAM_INT);
            $guard->bindParam(5,$categoriaIngresoId,PDO::PARAM_INT);
            $guard->bindParam(6,$tipoCargoNominalId,PDO::PARAM_INT);
            $guard->bindParam(7,$cargoNominalId,PDO::PARAM_INT);
            $guard->bindParam(8,$estructuraOrganizativaId,PDO::PARAM_INT);
            $guard->bindParam(9,$condicionNominalId,PDO::PARAM_INT);
            $guard->bindParam(10,$tipoNominaId,PDO::PARAM_INT);
            $guard->bindParam(11,$plantelId,PDO::PARAM_INT);
            $guard->bindParam(12,$observacion,PDO::PARAM_STR);
            $guard->bindParam(13, $usuarioIniId,PDO::PARAM_INT);
            
            /*
             *          :talentoHumanoId::int,
                        :poseeNumeroContrato::varchar,
                        :nroContrato::varchar,
                        :fechaIngreso::date,
                        :categoriaIngresoId::int,
                        :tipoCargoNominalId::int,
                        :cargoNominalId::int,
                        :estructuraOrganizativaId::int,
                        :condicionNominalId::int,
                        :tipoNominaId::int,
                        :plantelId::int,
                        :observacion::varchar,
                        :usuarioIniId::int
             * 
            $guard->bindParam(":talentoHumanoId",$talentoHumanoId,PDO::PARAM_INT);
            $guard->bindParam(":poseeNumeroContrato",$poseeNumeroContrato,PDO::PARAM_STR);
            $guard->bindParam(":nroContrato",$nroContrato,PDO::PARAM_STR);
            $guard->bindParam(":fechaIngreso",$fechaIngreso,PDO::PARAM_INT);
            $guard->bindParam(":categoriaIngresoId",$categoriaIngresoId,PDO::PARAM_INT);
            $guard->bindParam(":tipoCargoNominalId",$tipoCargoNominalId,PDO::PARAM_INT);
            $guard->bindParam(":cargoNominalId",$cargoNominalId,PDO::PARAM_INT);
            $guard->bindParam(":estructuraOrganizativaId",$estructuraOrganizativaId,PDO::PARAM_INT);
            $guard->bindParam(":condicionNominalId",$condicionNominalId,PDO::PARAM_INT);
            $guard->bindParam(":tipoNominaId",$tipoNominaId,PDO::PARAM_INT);
            $guard->bindParam(":plantelId",$plantelId,PDO::PARAM_INT);
            $guard->bindParam(":observacion",$observacion,PDO::PARAM_STR);
            $guard->bindParam(":usuarioIniId", $usuarioIniId,PDO::PARAM_INT);
            */
             

            $resultado = $guard->queryScalar();
            return $resultado;
            
        }
        
        public function beforeInsert()
	{
            parent::beforeSave();
            $this->fecha_ini = date('Y-m-d H:i:s');
            $this->usuario_ini_id = Yii::app()->user->id;
            $this->fecha_act = date('Y-m-d H:i:s');
            $this->usuario_act_id = Yii::app()->user->id;
            return true;
	}
        
        public function beforeUpdate()
	{
            parent::beforeSave();
            $this->fecha_act = date('Y-m-d H:i:s');
            $this->usuario_act_id = Yii::app()->user->id;
            return true;
	}
        
        public function beforeDelete(){
            parent::beforeSave();
            $this->fecha_act = date('Y-m-d H:i:s');
            $this->usuario_act_id = Yii::app()->user->id;
            // $this->fecha_eli = $this->fecha_act;
            $this->estatus = 'I';
            return true;
        }
        
        public function beforeActivate(){
            parent::beforeSave();
            $this->fecha_act = date('Y-m-d H:i:s');
            $this->usuario_act_id = Yii::app()->user->id;
            $this->estatus = 'A';
            return true;
        }
        
        public function __toString() {
            try {
                return (string) $this->id;
            } catch (Exception $exception) {
                return $exception->getMessage();
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IngresoEmpleado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

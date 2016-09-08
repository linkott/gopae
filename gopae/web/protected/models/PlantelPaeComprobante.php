<?php

/**
 * This is the model class for table "gplantel.plantel_pae_comprobante".
 *
 * The followings are the available columns in table 'gplantel.plantel_pae_comprobante':
 * @property integer $id
 * @property integer $plantel_id
 * @property string $codigo_seguridad
 * @property string $origen_autoridad
 * @property integer $cedula_autoridad
 * @property string $correo_autoridad
 * @property string $archivo_pdf
 * @property string $ultima_fecha_solicitud
 * @property integer $periodo_escolar_id
 * @property string $fecha_emision
 * @property string $fecha_caducidad
 * @property string $email_enviado
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property string $estatus
 * @property integer $usuario_act_id
 * @property string $fecha_act
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property PeriodoEscolar $periodoEscolar
 * @property Plantel $plantel
 * @property UsergroupsUser $usuarioIni
 */
class PlantelPaeComprobante extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gplantel.plantel_pae_comprobante';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plantel_id, codigo_seguridad, cedula_autoridad, correo_autoridad, archivo_pdf, ultima_fecha_solicitud, periodo_escolar_id, fecha_emision, fecha_caducidad, usuario_ini_id', 'required'),
			array('plantel_id, cedula_autoridad, periodo_escolar_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('codigo_seguridad', 'length', 'max'=>50),
			array('origen_autoridad, estatus', 'length', 'max'=>1),
			array('correo_autoridad', 'length', 'max'=>255),
			array('archivo_pdf', 'length', 'max'=>500),
			array('email_enviado', 'length', 'max'=>2),
			array('fecha_ini, fecha_act', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, plantel_id, codigo_seguridad, origen_autoridad, cedula_autoridad, correo_autoridad, archivo_pdf, ultima_fecha_solicitud, periodo_escolar_id, fecha_emision, fecha_caducidad, email_enviado, usuario_ini_id, fecha_ini, estatus, usuario_act_id, fecha_act', 'safe', 'on'=>'search'),
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
			'periodoEscolar' => array(self::BELONGS_TO, 'PeriodoEscolar', 'periodo_escolar_id'),
			'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
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
			'plantel_id' => 'Plantel',
			'codigo_seguridad' => 'Codigo Seguridad',
			'origen_autoridad' => 'Origen Autoridad',
			'cedula_autoridad' => 'Cedula Autoridad',
			'correo_autoridad' => 'Correo Autoridad',
			'archivo_pdf' => 'Archivo Pdf',
			'ultima_fecha_solicitud' => 'Ultima Fecha Solicitud',
			'periodo_escolar_id' => 'Periodo Escolar',
			'fecha_emision' => 'Fecha Emision',
			'fecha_caducidad' => 'Fecha Caducidad',
			'email_enviado' => 'Email Enviado',
			'usuario_ini_id' => 'Usuario Ini',
			'fecha_ini' => 'Fecha Ini',
			'estatus' => 'Estatus',
			'usuario_act_id' => 'Usuario Act',
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
		$criteria->compare('plantel_id',$this->plantel_id);
		$criteria->compare('codigo_seguridad',$this->codigo_seguridad,true);
		$criteria->compare('origen_autoridad',$this->origen_autoridad,true);
		$criteria->compare('cedula_autoridad',$this->cedula_autoridad);
		$criteria->compare('correo_autoridad',$this->correo_autoridad,true);
		$criteria->compare('archivo_pdf',$this->archivo_pdf,true);
		$criteria->compare('ultima_fecha_solicitud',$this->ultima_fecha_solicitud,true);
		$criteria->compare('periodo_escolar_id',$this->periodo_escolar_id);
		$criteria->compare('fecha_emision',$this->fecha_emision,true);
		$criteria->compare('fecha_caducidad',$this->fecha_caducidad,true);
		$criteria->compare('email_enviado',$this->email_enviado,true);
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('fecha_act',$this->fecha_act,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlantelPaeComprobante the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Get Comprobantes CNAE no enviados por correo. Estatus = A.
         */
        public static function getComprobantesCnaeNoEnviadosPorCorreo(){

            $sql = "SELECT c.id, c.codigo_seguridad, c.origen_autoridad, c.cedula_autoridad, c.correo_autoridad, 
                           c.archivo_pdf, c.ultima_fecha_solicitud, c.periodo_escolar_id, c.fecha_emision, 
                           c.fecha_caducidad, p.nombre AS plantel, p.cod_plantel, p.cod_cnae, c.email_enviado,
                           e.periodo AS periodo_escolar
                      FROM gplantel.plantel_pae_comprobante c 
                     INNER JOIN gplantel.plantel p 
                        ON c.plantel_id = p.id
                     INNER JOIN gplantel.periodo_escolar e
                        ON c.periodo_escolar_id = e.id
                     WHERE c.email_enviado = 'NO' 
                     ORDER BY c.fecha_emision
                     LIMIT 200;";

            $query = Yii::app()->db->createCommand($sql);
            $result = $query->queryAll();
            return $result;

        }
        
        public static function marcarComprobanteCnaeEnviado($id){
            $sql = "UPDATE gplantel.plantel_pae_comprobante SET email_enviado = 'SI', fecha_act = NOW() WHERE id = :id";
            $query = Yii::app()->db->createCommand($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            return $query->query();
        }
        
}

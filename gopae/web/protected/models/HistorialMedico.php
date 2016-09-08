<?php

/**
 * This is the model class for table "matricula.historial_medico".
 *
 * The followings are the available columns in table 'matricula.historial_medico':
 * @property integer $id
 * @property integer $enfermedad
 * @property string $nombre_enfermedad
 * @property integer $medicamento
 * @property string $nombre_medicamento
 * @property integer $alergia_medicamento
 * @property string $nombre_alergia_medicamento
 * @property integer $alergia_alimento
 * @property string $nombre_alergia_alimento
 * @property integer $bcg
 * @property integer $triple
 * @property integer $sarampion
 * @property integer $polio
 * @property integer $trivalente
 * @property integer $fiebre_amarilla
 * @property integer $hepatitisb
 * @property integer $toxoide
 * @property integer $tipo_sangre_id
 * @property integer $estudiante_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Estudiante $estudiante
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property TipoSangre $tipoSangre
 */
class HistorialMedico extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'matricula.historial_medico';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('enfermedad,
//                               medicamento,
//                               alergia_medicamento,
//                               alergia_alimento,
//                               bcg,
//                               triple,
//                               sarampion,
//                               polio,
//                               trivalente,
//                               fiebre_amarilla,
//                               hepatitisb,
//                               toxoide,
//                               tipo_sangre_id', 'required', 'on' => 'gestionHistorialMedico'),
			array('enfermedad, medicamento, alergia_medicamento, alergia_alimento, bcg, triple, sarampion, polio, trivalente, fiebre_amarilla, hepatitisb, toxoide, tipo_sangre_id, estudiante_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('fecha_ini, fecha_act, fecha_elim', 'length', 'max'=>6),
			array('estatus', 'length', 'max'=>1),
			array('nombre_enfermedad, nombre_medicamento, nombre_alergia_medicamento, nombre_alergia_alimento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, enfermedad, nombre_enfermedad, medicamento, nombre_medicamento, alergia_medicamento, nombre_alergia_medicamento, alergia_alimento, nombre_alergia_alimento, bcg, triple, sarampion, polio, trivalente, fiebre_amarilla, hepatitisb, toxoide, tipo_sangre_id, estudiante_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'estudiante' => array(self::BELONGS_TO, 'Estudiante', 'estudiante_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
			'tipoSangre' => array(self::BELONGS_TO, 'TipoSangre', 'tipo_sangre_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'enfermedad' => 'Enfermedad',
			'nombre_enfermedad' => 'Nombre Enfermedad',
			'medicamento' => 'Medicamento',
			'nombre_medicamento' => 'Nombre Medicamento',
			'alergia_medicamento' => 'Alergia Medicamento',
			'nombre_alergia_medicamento' => 'Nombre Alergia Medicamento',
			'alergia_alimento' => 'Alergia Alimento',
			'nombre_alergia_alimento' => 'Nombre Alergia Alimento',
			'bcg' => 'Bcg',
			'triple' => 'Triple',
			'sarampion' => 'Sarampion',
			'polio' => 'Polio',
			'trivalente' => 'Trivalente',
			'fiebre_amarilla' => 'Fiebre Amarilla',
			'hepatitisb' => 'Hepatitisb',
			'toxoide' => 'Toxoide',
			'tipo_sangre_id' => 'Tipo Sangre',
			'estudiante_id' => 'Estudiante',
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
		$criteria->compare('enfermedad',$this->enfermedad);
		$criteria->compare('nombre_enfermedad',$this->nombre_enfermedad,true);
		$criteria->compare('medicamento',$this->medicamento);
		$criteria->compare('nombre_medicamento',$this->nombre_medicamento,true);
		$criteria->compare('alergia_medicamento',$this->alergia_medicamento);
		$criteria->compare('nombre_alergia_medicamento',$this->nombre_alergia_medicamento,true);
		$criteria->compare('alergia_alimento',$this->alergia_alimento);
		$criteria->compare('nombre_alergia_alimento',$this->nombre_alergia_alimento,true);
		$criteria->compare('bcg',$this->bcg);
		$criteria->compare('triple',$this->triple);
		$criteria->compare('sarampion',$this->sarampion);
		$criteria->compare('polio',$this->polio);
		$criteria->compare('trivalente',$this->trivalente);
		$criteria->compare('fiebre_amarilla',$this->fiebre_amarilla);
		$criteria->compare('hepatitisb',$this->hepatitisb);
		$criteria->compare('toxoide',$this->toxoide);
		$criteria->compare('tipo_sangre_id',$this->tipo_sangre_id);
		$criteria->compare('estudiante_id',$this->estudiante_id);
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HistorialMedico the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

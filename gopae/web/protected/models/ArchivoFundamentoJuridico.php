<?php

/**
 * This is the model class for table "gplantel.archivo_fundamento_juridico".
 *
 * The followings are the available columns in table 'gplantel.archivo_fundamento_juridico':
 * @property integer $id
 * @property string $ruta
 * @property string $nombre
 * @property integer $fundamento_juridico_id
 * @property integer $usuario_ini_id
 * @property integer $usuario_elim_id
 * @property string $fecha_ini
 * @property string $fecha_elim
 *
 * The followings are the available model relations:
 * @property UsergroupsGroup $usuarioIni
 * @property UsergroupsGroup $usuarioElim
 * @property FundamentoJuridico $fundamentoJuridico
 */
class ArchivoFundamentoJuridico extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gplantel.archivo_fundamento_juridico';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fundamento_juridico_id, usuario_ini_id, usuario_elim_id', 'numerical', 'integerOnly'=>true),
			array('ruta, nombre', 'length', 'max'=>60),
			array('fecha_ini, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ruta, nombre, fundamento_juridico_id, usuario_ini_id, usuario_elim_id, fecha_ini, fecha_elim', 'safe', 'on'=>'search'),
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
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsGroup', 'usuario_ini_id'),
			'usuarioElim' => array(self::BELONGS_TO, 'UsergroupsGroup', 'usuario_elim_id'),
			'fundamentoJuridico' => array(self::BELONGS_TO, 'FundamentoJuridico', 'fundamento_juridico_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ruta' => 'Ruta',
			'nombre' => 'Nombre',
			'fundamento_juridico_id' => 'Fundamento Juridico',
			'usuario_ini_id' => 'Usuario Ini',
			'usuario_elim_id' => 'Usuario Elim',
			'fecha_ini' => 'Fecha Ini',
			'fecha_elim' => 'Fecha Elim',
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
	public function search($id) {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ruta',$this->ruta,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('fundamento_juridico_id', $id);
        $criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('usuario_elim_id',$this->usuario_elim_id);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('fecha_elim',$this->fecha_elim,true);

		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5,
            )
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArchivoFundamentoJuridico the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

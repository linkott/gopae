<?php

/**
 * This is the model class for table "proveduria.proveedor".
 *
 * The followings are the available columns in table 'proveduria.proveedor':
 * @property integer $id
 * @property string $rif
 * @property string $razon_social
 * @property integer $tipo_empresa_id
 * @property integer $capital_social
 * @property integer $tipo_sector_id
 * @property integer $banco_id
 * @property integer $tipo_cuenta_id
 * @property integer $numero_cuenta
 * @property string $titular_cuenta
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $parroquia_id
 * @property string $email
 * @property string $email_otro
 * @property integer $telefono_local
 * @property integer $telefono_celular
 * @property integer $telefono_otro
 * @property string $direccion
 * @property string $nil
 * @property string $ivss
 * @property string $inces
 * @property string $banavih
 * @property string $snc
 * @property string $solvencia_laboral
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property Parroquia $parroquia
 * @property Municipio $municipio
 * @property Estado $estado
 * @property TipoCuenta $tipoCuenta
 * @property TipoSector $tipoSector
 * @property TipoEmpresa $tipoEmpresa
 * @property Banco $banco
 */
class Proveedor extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'proveduria.proveedor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rif, razon_social, tipo_empresa_id, tipo_sector_id, estado_id, municipio_id, parroquia_id, email, telefono_celular, direccion, usuario_ini_id, fecha_ini, estatus, capacidad_distribucion', 'required'),
            array('tipo_empresa_id, tipo_sector_id, banco_id, tipo_cuenta_id, numero_cuenta, estado_id, municipio_id, parroquia_id, telefono_local, telefono_celular, telefono_otro, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('rif', 'length', 'max' => 14),
            array('rif_titular_cuenta', 'length', 'max' => 14),
            array('rif', 'unique'),
            array('id', 'unique', 'message' => 'Ya se realizo el registro'),
            array('capital_social', 'length', 'max' => 30),
            array('numero_cuenta', 'length', 'max' => 20),
            array('razon_social, titular_cuenta', 'length', 'max' => 160),
            array('email, email_otro', 'length', 'max' => 100),
            array('email, email_otro', 'email'),
            array('nil, ivss, inces, banavih, snc, solvencia_laboral', 'length', 'max' => 45),
            array('estatus', 'length', 'max' => 1),
            array('capital_social, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, rif, razon_social, tipo_empresa_id, capital_social, tipo_sector_id, banco_id, tipo_cuenta_id, numero_cuenta, titular_cuenta, estado_id, municipio_id, parroquia_id, email, email_otro, telefono_local, telefono_celular, telefono_otro, direccion, nil, ivss, inces, banavih, snc, solvencia_laboral, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'parroquia' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_id'),
            'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
            'Poblacion' => array(self::BELONGS_TO, 'Poblacion', 'poblacion_id'),
            'Urbanizacion' => array(self::BELONGS_TO, 'Urbanizacion', 'urbanizacion_id'),
            'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
            'tipoCuenta' => array(self::BELONGS_TO, 'TipoCuenta', 'tipo_cuenta_id'),
            'tipoSector' => array(self::BELONGS_TO, 'TipoSector', 'tipo_sector_id'),
            'tipoEmpresa' => array(self::BELONGS_TO, 'TipoEmpresa', 'tipo_empresa_id'),
            'tipoDocumento' => array(self::BELONGS_TO, 'TipoDocumento', 'tipo_documento_id'),
            'banco' => array(self::BELONGS_TO, 'Banco', 'banco_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'rif' => 'Rif',
            'razon_social' => 'Razon Social',
            'tipo_empresa_id' => 'Tipo Empresa',
            'capital_social' => 'Capital Social',
            'tipo_sector_id' => 'Tipo Sector',
            'banco_id' => 'Banco',
            'tipo_cuenta_id' => 'Tipo Cuenta',
            'numero_cuenta' => 'Numero Cuenta',
            'titular_cuenta' => 'Titular Cuenta',
            'estado_id' => 'Estado',
            'municipio_id' => 'Municipio',
            'parroquia_id' => 'Parroquia',
            'email' => 'Email',
            'email_otro' => 'Email Otro',
            'telefono_local' => 'Telfefono Local',
            'telefono_celular' => 'Telfono Celular',
            'telefono_otro' => 'Telfono Otro',
            'direccion' => 'Direccion',
            'nil' => 'Nil',
            'ivss' => 'Ivss',
            'inces' => 'Inces',
            'banavih' => 'Banavih',
            'snc' => 'Snc',
            'solvencia_laboral' => 'Solvencia Laboral',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'capacidad_distribucion' => 'Capacidad de Distribución'
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria; 
        
        $criteria->compare('id', $this->id);
        $criteria->compare('rif', strtoupper($this->rif), true);
        $criteria->compare('razon_social', strtoupper($this->razon_social), true);
        $criteria->compare('tipo_empresa_id', $this->tipo_empresa_id);
        $criteria->compare('capital_social', $this->capital_social, true);
        $criteria->compare('tipo_sector_id', $this->tipo_sector_id);
        $criteria->compare('banco_id', $this->banco_id);
        $criteria->compare('tipo_cuenta_id', $this->tipo_cuenta_id);
        $criteria->compare('numero_cuenta', $this->numero_cuenta);
        $criteria->compare('titular_cuenta', $this->titular_cuenta, true);
        $criteria->compare('estado_id', $this->estado_id);
        $criteria->compare('municipio_id', $this->municipio_id);
        $criteria->compare('parroquia_id', $this->parroquia_id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('email_otro', $this->email_otro, true);
        $criteria->compare('telefono_local', $this->telefono_local);
        $criteria->compare('telefono_celular', $this->telefono_celular);
        $criteria->compare('telefono_otro', $this->telefono_otro);
        $criteria->compare('direccion', $this->direccion, true);
        $criteria->compare('nil', $this->nil, true);
        $criteria->compare('ivss', $this->ivss, true);
        $criteria->compare('inces', $this->inces, true);
        $criteria->compare('banavih', $this->banavih, true);
        $criteria->compare('snc', $this->snc, true);
        $criteria->compare('solvencia_laboral', $this->solvencia_laboral, true);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);

        $sort = new CSort();
        $sort->defaultOrder = 'razon_social ASC, estatus ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => 15,
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Proveedor the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

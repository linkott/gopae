<?php

/**
 * This is the model class for table "matricula.representante".
 *
 * The followings are the available columns in table 'matricula.representante':
 * @property integer $id
 * @property integer $cedula_identidad
 * @property string $apellidos
 * @property string $fecha_nacimiento
 * @property integer $estado_nac_id
 * @property integer $municipio_nac_id
 * @property integer $parroquia_nac_id
 * @property string $direccion_nac
 * @property integer $pais_id
 * @property string $correo
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $parroquia_id
 * @property string $direccion_dom
 * @property integer $poblacion_id
 * @property integer $urbanizacion_id
 * @property integer $tipo_via_id
 * @property string $via
 * @property string $empresa
 * @property integer $telefono_empresa
 * @property integer $estado_civil_id
 * @property string $afinada_otro_id
 * @property integer $profesion_id
 * @property string $sexo
 * @property string $nacionalidad
 * @property string $telefono_movil
 * @property string $telefono_habitacion
 * @property string $repre_legal
 * @property integer $afinidad_id
 * @property string $descripcion_afinidad
 * @property string $descripcion_afinidad_otro
 *
 * The followings are the available model relations:
 * @property Estudiante[] $estudiantes
 * @property Estudiante[] $estudiantes1
 * @property EstadoCivil $estadoCivil
 * @property Pais $pais
 * @property Estado $estado
 * @property Estado $estadoNac
 * @property Municipio $municipio
 * @property Municipio $municipioNac
 * @property Parroquia $parroquia
 * @property Parroquia $parroquiaNac
 * @property Poblacion $poblacion
 * @property TipoVia $tipoVia
 * @property Urbanizacion $urbanizacion
 * @property Profesion $profesion
 * @property Afinidad $afinidad
 */
class Representante extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'matricula.representante';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cedula_identidad,
                   nombres,
                   apellidos,
                   fecha_nacimiento,
                   estado_civil_id,
                   sexo,
                   afinidad_id,
                   nacionalidad,
                   pais_id,
                   estado_id,
                   municipio_id,
                   parroquia_id,
                   poblacion_id,
                   urbanizacion_id', 'required', 'on' => 'gestionRepresentante'),
            array('cedula_identidad, estado_nac_id, municipio_nac_id, parroquia_nac_id, pais_id, estado_id, municipio_id, parroquia_id, poblacion_id, urbanizacion_id, tipo_via_id, telefono_empresa, estado_civil_id, profesion_id, afinidad_id,telefono_movil,telefono_habitacion', 'numerical', 'integerOnly' => true),
            array('direccion_nac', 'length', 'max' => 50),
            array(
                'nombres, apellidos, cedula_identidad, telefono_movil, estado_id',
                'required', 'message' => 'El campo del representante  {attribute} no debe estar vacio', 'on' => 'crearRepresentante'
            ),
            array(
                'telefono_movil, telefono_habitacion',
                'length', 'min' => 11, 'on' => 'crearRepresentante'
            ),
            array(
                'correo', 'email', 'on' => 'crearRepresentante'
            ),
            array('sexo, nacionalidad, repre_legal', 'length', 'max' => 1),
            array('descripcion_afinidad, descripcion_afinidad_otro', 'length', 'max' => 30),
            array('primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, fecha_nacimiento, correo, direccion_dom, via, empresa, afinada_otro_id, telefono_movil, telefono_habitacion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cedula_identidad, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, fecha_nacimiento, estado_nac_id, municipio_nac_id, parroquia_nac_id, direccion_nac, pais_id, correo, estado_id, municipio_id, parroquia_id, direccion_dom, poblacion_id, urbanizacion_id, tipo_via_id, via, empresa, telefono_empresa, estado_civil_id, afinada_otro_id, profesion_id, sexo, nacionalidad, telefono_movil, telefono_habitacion, repre_legal, afinidad_id, descripcion_afinidad, descripcion_afinidad_otro', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'estudiantes' => array(self::HAS_MANY, 'Estudiante', 'otro_represent_id'),
            'estudiantes1' => array(self::HAS_MANY, 'Estudiante', 'representante_id'),
            'estadoCivil' => array(self::BELONGS_TO, 'EstadoCivil', 'estado_civil_id'),
            'pais' => array(self::BELONGS_TO, 'Pais', 'pais_id'),
            'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
            'estadoNac' => array(self::BELONGS_TO, 'Estado', 'estado_nac_id'),
            'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
            'municipioNac' => array(self::BELONGS_TO, 'Municipio', 'municipio_nac_id'),
            'parroquia' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_id'),
            'parroquiaNac' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_nac_id'),
            'poblacion' => array(self::BELONGS_TO, 'Poblacion', 'poblacion_id'),
            'tipoVia' => array(self::BELONGS_TO, 'TipoVia', 'tipo_via_id'),
            'urbanizacion' => array(self::BELONGS_TO, 'Urbanizacion', 'urbanizacion_id'),
            'profesion' => array(self::BELONGS_TO, 'Profesion', 'profesion_id'),
            'afinidad' => array(self::BELONGS_TO, 'Afinidad', 'afinidad_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cedula_identidad' => 'Cédula Identidad',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'estado_nac_id' => 'Estado de nacimiento del representante',
            'municipio_nac_id' => 'Municipio de nacimiento del representante',
            'parroquia_nac_id' => 'Parroquia de nacimiento del representante',
            'direccion_nac' => 'Direccion de nacimiento del representante',
            'pais_id' => 'Pais de nacimiento',
            'correo' => 'Correo',
            'estado_id' => 'Estado de domicilio',
            'municipio_id' => 'Municipio de domicilio',
            'parroquia_id' => 'Parroquia de domicilio',
            'direccion_dom' => 'Direccion de domicilio',
            'poblacion_id' => 'Población de domicilio',
            'urbanizacion_id' => 'Urbanizacion de domicilio',
            'tipo_via_id' => 'Tipo de via de domicilio',
            'via' => 'Via de domicilio',
            'empresa' => 'Empresa',
            'telefono_empresa' => 'Telefono Empresa',
            'estado_civil_id' => 'Estado Civil',
            'afinada_otro_id' => 'Afinada Otro',
            'profesion_id' => 'Contiene el id de la tabla profesion',
            'sexo' => 'Genero', //'Contiene F si es femenino, M si es masculino',
            'nacionalidad' => 'Nacionalidad', //'Contiene V si es venezolano, E si es extrajero',
            'telefono_movil' => 'Telefono Movil',
            'telefono_habitacion' => 'Telefono Habitacion',
            'repre_legal' => 'Contiene S si es el representante es legal y N si no es legal',
            'afinidad_id' => 'Afinidad',
            'descripcion_afinidad' => 'Contiene la descipcion de la afinidad cuando en el campo afinidad_id contiene el id de otros',
            'descripcion_afinidad_otro' => 'Contiene la descripcion de la afinidad otro cuando en el campo afinidad_otro_id contiene el id de otros',
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
        $criteria->compare('cedula_identidad', $this->cedula_identidad);
        $criteria->compare('nombres', $this->nombres, true);
        $criteria->compare('apellidos', $this->apellidos, true);
        $criteria->compare('fecha_nacimiento', $this->fecha_nacimiento, true);
        $criteria->compare('estado_nac_id', $this->estado_nac_id);
        $criteria->compare('municipio_nac_id', $this->municipio_nac_id);
        $criteria->compare('parroquia_nac_id', $this->parroquia_nac_id);
        $criteria->compare('direccion_nac', $this->direccion_nac, true);
        $criteria->compare('pais_id', $this->pais_id);
        $criteria->compare('correo', $this->correo, true);
        $criteria->compare('estado_id', $this->estado_id);
        $criteria->compare('municipio_id', $this->municipio_id);
        $criteria->compare('parroquia_id', $this->parroquia_id);
        $criteria->compare('direccion_dom', $this->direccion_dom, true);
        $criteria->compare('poblacion_id', $this->poblacion_id);
        $criteria->compare('urbanizacion_id', $this->urbanizacion_id);
        $criteria->compare('tipo_via_id', $this->tipo_via_id);
        $criteria->compare('via', $this->via, true);
        $criteria->compare('empresa', $this->empresa, true);
        $criteria->compare('telefono_empresa', $this->telefono_empresa);
        $criteria->compare('estado_civil_id', $this->estado_civil_id);
        $criteria->compare('afinada_otro_id', $this->afinada_otro_id, true);
        $criteria->compare('profesion_id', $this->profesion_id);
        $criteria->compare('sexo', $this->sexo, true);
        $criteria->compare('nacionalidad', $this->nacionalidad, true);
        $criteria->compare('telefono_movil', $this->telefono_movil, true);
        $criteria->compare('telefono_habitacion', $this->telefono_habitacion, true);
        $criteria->compare('repre_legal', $this->repre_legal, true);
        $criteria->compare('afinidad_id', $this->afinidad_id);
        $criteria->compare('descripcion_afinidad', $this->descripcion_afinidad, true);
        $criteria->compare('descripcion_afinidad_otro', $this->descripcion_afinidad_otro, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }



    public function registrarRepresentante() {
         $sql = "INSERT INTO matricula.representante"
                . "(nombres, apellidos, correo, fecha_nacimiento, telefono_movil,telefono_habitacion,estado_id,usuario_ini_id,fecha_ini)"
                . "VALUES (:nombres, :apellidos, :correo, :fecha_nacimiento, :telefono_movil, :telefono_habitacion, :estado_id, :usuario_ini_id, :fecha_ini) returning id";
        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":tipo_ubicacion_id", $fronteriza, PDO::PARAM_INT);
        $guard->bindParam(":usuario_ini_id", $usuario, PDO::PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $guardoUbicacionFronteriza = $guard->queryScalar();
    }

/**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Representante the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

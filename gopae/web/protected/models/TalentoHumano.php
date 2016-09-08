<?php

/**
 * This is the model class for table "gestion_humana.talento_humano".
 *
 * The followings are the available columns in table 'gestion_humana.talento_humano':
 * @property string $id
 * @property string $origen
 * @property integer $cedula
 * @property string $rif
 * @property string $nombre
 * @property string $apellido
 * @property string $sexo
 * @property string $fecha_nacimiento
 * @property string $foto
 * @property string $telefono_fijo
 * @property string $telefono_celular
 * @property string $telefono_oficina
 * @property string $email_personal
 * @property string $email_corporativo
 * @property string $twitter
 * @property string $certificado_medico
 * @property string $manipulacion_alimentos
 * @property string $registro_militar
 * @property integer $grado_instruccion_id
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $parroquia_id
 * @property string $direccion
 * @property string $enfermedades
 * @property string $aptitudes
 * @property integer $mision_id
 * @property string $hijo_en_plantel
 * @property integer $cantidad_hijos
 * @property string $codigo_empleado
 * @property string $fecha_ingreso
 * @property integer $categoria_ingreso_id
 * @property string $username_corp
 * @property string $password_corp
 * @property string $numero_ivss
 * @property integer $estructura_organizativa_actual_id
 * @property integer $tipo_nomina_id
 * @property integer $condicion_actual_id
 * @property integer $tipo_cargo_actual_id
 * @property integer $cargo_actual_id
 * @property integer $plantel_actual_id
 * @property integer $tipo_serial_cuenta_id
 * @property integer $tipo_cuenta_id
 * @property integer $banco_id
 * @property string $numero_cuenta
 * @property string $origen_titular
 * @property integer $cedula_titular
 * @property string $nombre_titular
 * @property string $resultado_asignacion_ti
 * @property string $fecha_ultima_asistencia_reg
 * @property integer $ultima_asistencia_reg
 * @property string $fecha_egreso
 * @property string $observacion
 * @property string $usuario_ini_id
 * @property string $fecha_ini
 * @property string $usuario_act_id
 * @property string $fecha_act
 * @property string $busqueda
 * @property string $codigo_integridad
 * @property string $lateralidad
 * @property string $estatus
 * @property string $verificado_saime
 * @property string $habilidad_agropecuaria
 * @property integer $banco_tarjeta_alimentacion_id
 * @property integer $numero_tarjeta_alimentacion
 * @property date $fecha_entrega_tarjeta_alimentacion
 *
 * The followings are the available model relations:
 * @property CategoriaIngreso $categoriaIngreso
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 * @property TipoSerialCuenta $tipoSerialCuenta
 * @property TipoNomina $tipoNomina
 * @property TipoCuenta $tipoCuenta
 * @property TipoCargoNominal $tipoCargoActual
 * @property Plantel $plantelActual
 * @property Parroquia $parroquia
 * @property Municipio $municipio
 * @property Mision $mision
 * @property GradoInstruccion $gradoInstruccion
 * @property EstructuraOrganizativa $estructuraOrganizativaActual
 * @property Estado $estado
 * @property CondicionNominal $condicionActual
 * @property CargoNominal $cargoActual
 * @property Banco $banco
 * @property Banco $bancoAlimentacion
 * @property EstructuraOrganizativa[] $estructuraOrganizativas
 * @property FamiliarEmpleado[] $familiarEmpleados
 * @property DocumentoEmpleado[] $documentoEmpleados
 */
class TalentoHumano extends CActiveRecord {

    /**
     * ESTATUS DEL EMPLEADO EN LA EMPRESA
     * A = Aspirante (Esta persona aún no es un empleado de la empresa)
     * E = Empleado Activo (Esta persona es un empleado activo de la empresa ya sea por cualquier método de ingreso)
     * P = Pasivo (Esta persona forma parte de la nómina pasiva de la empresa, por ejemplo un jubilado o pensionado)
     * O = Otro/Egresado (Esta persona ha egresado en alguna oportunidad de la empresa, por algún motivo como despido, renuncia)
     * S = Se encuentra en Comisión de Servicio en Otra Institución
     * I = Inactivo, por algún motivo esta persona se encuentra inactiva en la empresa por motivo de Suspensión de Pago, Permiso no remunerado por estudios.
     */
    const ASPIRANTE = 'A';
    const EMPLEADO_ACTIVO = 'E';
    const EMPLEADO_PASIVO = 'P';
    const EN_COMISION_DE_SERVICIO = 'S';
    const EMPLEADO_INACTIVO = 'I';
    const OTRO = 'O';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gestion_humana.talento_humano';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('origen, cedula, nombre, apellido, fecha_nacimiento, estado_id, usuario_ini_id, fecha_ini, email_personal, certificado_medico', 'required'),
            array('banco_id, tipo_cuenta_id, numero_cuenta, origen_titular, cedula_titular, nombre_titular', 'required', 'on'=>'formDatosBancarios'),
            array('cedula, grado_instruccion_id, estado_id, municipio_id, parroquia_id, mision_id, cantidad_hijos, categoria_ingreso_id, estructura_organizativa_actual_id, tipo_nomina_id, condicion_actual_id, tipo_cargo_actual_id, cargo_actual_id, plantel_actual_id, tipo_serial_cuenta_id, tipo_cuenta_id, banco_id, diversidad_funcional_id, etnia_id, cedula_titular, ultima_asistencia_reg', 'numerical', 'integerOnly' => true),
            array('origen, sexo, origen_titular, estatus', 'length', 'max' => 1),
            array('rif, numero_ivss', 'length', 'max' => 20),
            array('nombre, apellido, codigo_integridad', 'length', 'max' => 50),
            array('foto, password_corp', 'length', 'max' => 255),
            array('telefono_fijo, telefono_celular, telefono_oficina', 'length', 'max' => 14),
            array('email_personal, email_corporativo, username_corp', 'length', 'max' => 120),
            array('twitter, nombre_titular', 'length', 'max' => 40),
            array('certificado_medico, manipulacion_alimentos, registro_militar, hijo_en_plantel, verificado_saime', 'length', 'max' => 2),
            array('codigo_empleado', 'length', 'max' => 15),
            array('numero_cuenta, numero_tarjeta_alimentacion', 'length', 'max' => 30),
            array('origen', 'in', 'range' => array('V', 'E', 'P'), 'allowEmpty' => false, 'strict' => true,),
            array('certificado_medico, manipulacion_alimentos, registro_militar, hijo_en_plantel, verificado_saime, habilidad_agropecuaria', 'in', 'range' => array('Si', 'No',), 'allowEmpty' => false, 'strict' => true,),
            array('lateralidad', 'in', 'range' => array('Z', 'D',), 'allowEmpty' => true, 'strict' => true,),
            array('estatus', 'in', 'range' => array('A', 'I', 'E', 'S', 'P', 'O'), 'allowEmpty' => false, 'strict' => true,),
            array('sexo', 'in', 'range' => array('M', 'F',), 'allowEmpty' => false, 'strict' => true,),
            array('usuario_ini_id', 'default', 'value' => Yii::app()->user->id, 'on' => 'insert'),
            array('usuario_act_id', 'default', 'value' => Yii::app()->user->id, 'on' => 'update'),
            array('email_personal, email_corporativo', 'email'),
            array('origen, cedula', 'ECompositeUniqueValidator', 'attributesToAddError'=>'cedula', 'message'=>'El número de cédula ingresado ya se encuentra registrado en el sistema.'),
            // array('cedula', 'checkCedulaExists'),
            array('banco_id', 'checkBanco'),
            array('estado_id', 'checkEstadoId'),
            array('municipio_id, parroquia', 'checkMunicipioId'),
            array('parroquia', 'checkParroquiaId'),
            array('fecha_nacimiento', 'checkFechaNacimiento'),
            array('direccion, enfermedades, aptitudes, resultado_asignacion_ti, observacion, usuario_act_id, busqueda', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, origen, cedula, rif, nombre, apellido, sexo, fecha_nacimiento, foto, telefono_fijo, telefono_celular, telefono_oficina, email_personal, email_corporativo, twitter, certificado_medico, manipulacion_alimentos, registro_militar, grado_instruccion_id, estado_id, municipio_id, parroquia_id, direccion, enfermedades, aptitudes, mision_id, hijo_en_plantel, cantidad_hijos, codigo_empleado, fecha_ingreso, categoria_ingreso_id, username_corp, password_corp, numero_ivss, estructura_organizativa_actual_id, tipo_nomina_id, condicion_actual_id, tipo_cargo_actual_id, cargo_actual_id, plantel_actual_id, tipo_serial_cuenta_id, tipo_cuenta_id, banco_id, numero_cuenta, origen_titular, cedula_titular, nombre_titular, resultado_asignacion_ti, fecha_ultima_asistencia_reg, ultima_asistencia_reg, fecha_egreso, observacion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, busqueda, codigo_integridad, estatus, verificado_saime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'categoriaIngreso' => array(self::BELONGS_TO, 'CategoriaIngreso', 'categoria_ingreso_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'tipoSerialCuenta' => array(self::BELONGS_TO, 'TipoSerialCuenta', 'tipo_serial_cuenta_id'),
            'tipoNomina' => array(self::BELONGS_TO, 'TipoNomina', 'tipo_nomina_id'),
            'diversidadFuncional' => array(self::BELONGS_TO, 'DiversidadFuncional', 'diversidad_funcional_id'),
            'etnia' => array(self::BELONGS_TO, 'Etnia', 'etnia_id'),
            'tipoCuenta' => array(self::BELONGS_TO, 'TipoCuenta', 'tipo_cuenta_id'),
            'tipoCargoActual' => array(self::BELONGS_TO, 'TipoCargoNominal', 'tipo_cargo_actual_id'),
            'plantelActual' => array(self::BELONGS_TO, 'Plantel', 'plantel_actual_id'),
            'parroquia' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_id'),
            'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
            'mision' => array(self::BELONGS_TO, 'Mision', 'mision_id'),
            'gradoInstruccion' => array(self::BELONGS_TO, 'GradoInstruccion', 'grado_instruccion_id'),
            'estructuraOrganizativaActual' => array(self::BELONGS_TO, 'EstructuraOrganizativa', 'estructura_organizativa_actual_id'),
            'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
            'condicionActual' => array(self::BELONGS_TO, 'CondicionNominal', 'condicion_actual_id'),
            'cargoActual' => array(self::BELONGS_TO, 'CargoNominal', 'cargo_actual_id'),
            'banco' => array(self::BELONGS_TO, 'Banco', 'banco_id'),
            'bancoAlimentacion' => array(self::BELONGS_TO, 'Banco', 'banco_tarjeta_alimentacion_id'),
            'estructuraOrganizativas' => array(self::HAS_MANY, 'EstructuraOrganizativa', 'autoridad_actual_id'),
            'familiarEmpleados' => array(self::HAS_MANY, 'FamiliarEmpleado', 'talento_humano_id'),
            'documentoEmpleados' => array(self::HAS_MANY, 'DocumentoEmpleado', 'talento_humano_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'origen' => 'Origen',
            'cedula' => 'Cédula de Identidad',
            'rif' => 'RIF',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'sexo' => 'Sexo',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'foto' => 'Foto',
            'telefono_fijo' => 'Teléfono Fijo',
            'telefono_celular' => 'Teléfono Celular',
            'telefono_oficina' => 'Teléfono Oficina',
            'email_personal' => 'Correo Electrónico Personal',
            'email_corporativo' => 'Email Corporativo',
            'twitter' => 'Twitter',
            'certificado_medico' => '¿Posee Certificado Médico Vigente?',
            'manipulacion_alimentos' => 'Curso de Manipulación Alimentos',
            'registro_militar' => 'Registro Militar',
            'grado_instruccion_id' => 'Grado Instrucción',
            'estado_id' => 'Estado',
            'municipio_id' => 'Municipio',
            'parroquia_id' => 'Parroquia',
            'direccion' => 'Dirección Referencial',
            'enfermedades' => 'Enfermedades y/o Alergias',
            'aptitudes' => 'Aptitudes',
            'mision_id' => 'Seleccione si ha participado en alguna Misión',
            'hijo_en_plantel' => '¿Posee Hijo en Plantel donde Labora?',
            'cantidad_hijos' => 'Cantidad de Hijos en el Plantel donde Labora',
            'codigo_empleado' => 'Código Empleado',
            'fecha_ingreso' => 'Fecha de Ingreso',
            'categoria_ingreso_id' => 'Categoria Ingreso',
            'username_corp' => 'Username Corp',
            'password_corp' => 'Password Corp',
            'numero_ivss' => 'Numero IVSS',
            'estructura_organizativa_actual_id' => 'Estructura Organizativa Actual',
            'tipo_nomina_id' => 'Tipo de Nomina',
            'condicion_actual_id' => 'Condición Actual',
            'tipo_cargo_actual_id' => 'Categoría de Cargo Actual',
            'cargo_actual_id' => 'Cargo Nominal Actual',
            'plantel_actual_id' => 'Plantel Actual',
            'tipo_serial_cuenta_id' => 'Tipo de Serial de la Cuenta',
            'tipo_cuenta_id' => 'Tipo de Cuenta',
            'banco_id' => 'Banco',
            'numero_cuenta' => 'Número de Cuenta',
            'banco_tarjeta_alimentacion_id' => 'Banco Bono de Alimentación',
            'numero_tarjeta_alimentacion' => 'Número de Tarjeta de Alimentación',
            'origen_titular' => 'Origen del Titular',
            'cedula_titular' => 'Cédula del Titular',
            'nombre_titular' => 'Nombre del Titular',
            'resultado_asignacion_ti' => 'Resultado Asignacion TI',
            'fecha_ultima_asistencia_reg' => 'Fecha Ultima Asistencia Reg',
            'ultima_asistencia_reg' => 'Ultima Asistencia Reg',
            'fecha_egreso' => 'Fecha de Egreso',
            'observacion' => 'Observación',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'busqueda' => 'Búsqueda',
            'codigo_integridad' => 'Código Integridad',
            'estatus' => 'Estatus',
            'verificado_saime' => 'Verificado en SAIME',
            'diversidad_funcional_id' => 'Diversidad Funcional',
            'etnia_id' => 'Etnia',
            'lateralidad' => 'Lateralidad',
            'habilidad_agropecuaria' => '¿Posee Habilidad Agropecuaria?',
        );
    }


    public function checkBanco($attribute, $params=null){
        if(!CBanco::getData('id', $this->banco_id)){
            $this->addError($attribute, 'El Banco Seleccionado no es válido.');
        }
    }

    public function checkEstadoId($attribute, $params=null){
        if(!is_numeric($this->estado_id) || !CEstado::getData('id', $this->estado_id)){
            $this->addError($attribute, 'El Estado seleccionado no es válido.');
        }
    }

    public function checkMunicipioId($attribute, $params=null){
        if(!is_numeric($this->municipio_id) || !CMunicipio::getData('id', $this->municipio_id)){
            $this->addError($attribute, 'El Municipio seleccionado no es válido.');
        }
    }

    public function checkParroquiaId($attribute, $params=null){
        if(!is_null($this->parroquia_id) && (!is_numeric($this->municipio_id) || !CParroquia::getData('id', $this->parroquia_id))){
            $this->addError($attribute, 'La Parroquia seleccionada no es válida.');
        }
    }

    public function checkCedulaExists($attribute, $params=null){
        if(!Saime::busquedaOrigenCedula($this->origen, $this->cedula)){
            $this->addError($attribute, 'El Documento de Identidad <b>'.$this->origen.'-'.$this->cedula.'</b> no se ha podido encontrar en nuestra base de datos.');
        }
    }

    public function checkFechaNacimiento($attribute, $params=null){
        $fechaNacimiento = new DateTime($this->$attribute);
        $today = new DateTime();
        if($fechaNacimiento>=$today){
            $this->addError($attribute, 'La fecha de nacimiento no puede ser mayor o igual al día de hoy.');
        }
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

        $criteria->alias = 't';

        $criteria->with = array(
            'estado' => array('alias' => 'e', 'select'=>'id, nombre'),
            'tipoCargoActual' => array('alias'=>'tca', 'select'=>'id, nombre'),
            'estructuraOrganizativaActual' => array('alias'=>'eoa', 'select'=>'id, nombre'),
        );

        if (strlen($this->id) > 0)
            $criteria->compare('t.id', $this->id, true);
        if (strlen($this->origen) > 0)
            $criteria->compare('t.origen', $this->origen, true);
        if (is_numeric($this->cedula))
            $criteria->compare('t.cedula', $this->cedula);
        if (strlen($this->rif) > 0)
            $criteria->compare('t.rif', $this->rif, true);
        if (strlen($this->nombre) > 0)
            $criteria->compare('t.nombre', $this->nombre, true);
        if (strlen($this->apellido) > 0)
            $criteria->compare('t.apellido', $this->apellido, true);
        if (strlen($this->sexo) > 0)
            $criteria->compare('t.sexo', $this->sexo, true);
        if (Utiles::isValidDate($this->fecha_nacimiento, 'y-m-d'))
            $criteria->compare('t.fecha_nacimiento', $this->fecha_nacimiento);
        // if(strlen($this->fecha_nacimiento)>0) $criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
        if (strlen($this->foto) > 0)
            $criteria->compare('t.foto', $this->foto, true);
        if (strlen($this->telefono_fijo) > 0)
            $criteria->compare('t.telefono_fijo', $this->telefono_fijo, true);
        if (strlen($this->telefono_celular) > 0)
            $criteria->compare('t.telefono_celular', $this->telefono_celular, true);
        if (strlen($this->telefono_oficina) > 0)
            $criteria->compare('t.telefono_oficina', $this->telefono_oficina, true);
        if (strlen($this->email_personal) > 0)
            $criteria->compare('t.email_personal', $this->email_personal, true);
        if (strlen($this->email_corporativo) > 0)
            $criteria->compare('t.email_corporativo', $this->email_corporativo, true);
        if (strlen($this->twitter) > 0)
            $criteria->compare('t.twitter', $this->twitter, true);
        if (strlen($this->certificado_medico) > 0)
            $criteria->compare('t.certificado_medico', $this->certificado_medico, true);
        if (strlen($this->manipulacion_alimentos) > 0)
            $criteria->compare('t.manipulacion_alimentos', $this->manipulacion_alimentos, true);
        if (strlen($this->registro_militar) > 0)
            $criteria->compare('t.registro_militar', $this->registro_militar, true);
        if (is_numeric($this->grado_instruccion_id))
            $criteria->compare('t.grado_instruccion_id', $this->grado_instruccion_id);
        if (is_numeric($this->estado_id))
            $criteria->compare('t.estado_id', $this->estado_id);
        if (is_numeric($this->municipio_id))
            $criteria->compare('t.municipio_id', $this->municipio_id);
        if (is_numeric($this->parroquia_id))
            $criteria->compare('t.parroquia_id', $this->parroquia_id);
        if (strlen($this->direccion) > 0)
            $criteria->compare('t.direccion', $this->direccion, true);
        if (strlen($this->enfermedades) > 0)
            $criteria->compare('t.enfermedades', $this->enfermedades, true);
        if (strlen($this->aptitudes) > 0)
            $criteria->compare('t.aptitudes', $this->aptitudes, true);
        if (is_numeric($this->mision_id))
            $criteria->compare('t.mision_id', $this->mision_id);
        if (strlen($this->hijo_en_plantel) > 0)
            $criteria->compare('t.hijo_en_plantel', $this->hijo_en_plantel, true);
        if (is_numeric($this->cantidad_hijos))
            $criteria->compare('t.cantidad_hijos', $this->cantidad_hijos);
        if (strlen($this->codigo_empleado) > 0)
            $criteria->compare('t.codigo_empleado', $this->codigo_empleado, true);
        if (Utiles::isValidDate($this->fecha_ingreso, 'y-m-d'))
            $criteria->compare('t.fecha_ingreso', $this->fecha_ingreso);
        // if(strlen($this->fecha_ingreso)>0) $criteria->compare('fecha_ingreso',$this->fecha_ingreso,true);
        if (is_numeric($this->categoria_ingreso_id))
            $criteria->compare('t.categoria_ingreso_id', $this->categoria_ingreso_id);
        if (strlen($this->username_corp) > 0)
            $criteria->compare('t.username_corp', $this->username_corp, true);
        if (strlen($this->password_corp) > 0)
            $criteria->compare('t.password_corp', $this->password_corp, true);
        if (strlen($this->numero_ivss) > 0)
            $criteria->compare('t.numero_ivss', $this->numero_ivss, true);
        if (is_numeric($this->estructura_organizativa_actual_id))
            $criteria->compare('t.estructura_organizativa_actual_id', $this->estructura_organizativa_actual_id);
        if (is_numeric($this->tipo_nomina_id))
            $criteria->compare('t.tipo_nomina_id', $this->tipo_nomina_id);
        if (is_numeric($this->condicion_actual_id))
            $criteria->compare('t.condicion_actual_id', $this->condicion_actual_id);
        if (is_numeric($this->tipo_cargo_actual_id))
            $criteria->compare('t.tipo_cargo_actual_id', $this->tipo_cargo_actual_id);
        if (is_numeric($this->cargo_actual_id))
            $criteria->compare('t.cargo_actual_id', $this->cargo_actual_id);
        if (is_numeric($this->plantel_actual_id))
            $criteria->compare('t.plantel_actual_id', $this->plantel_actual_id);
        if (is_numeric($this->tipo_serial_cuenta_id))
            $criteria->compare('t.tipo_serial_cuenta_id', $this->tipo_serial_cuenta_id);
        if (is_numeric($this->tipo_cuenta_id))
            $criteria->compare('t.tipo_cuenta_id', $this->tipo_cuenta_id);
        if (is_numeric($this->banco_id))
            $criteria->compare('t.banco_id', $this->banco_id);
        if (strlen($this->numero_cuenta) > 0)
            $criteria->compare('t.numero_cuenta', $this->numero_cuenta, true);
        if (strlen($this->origen_titular) > 0)
            $criteria->compare('t.origen_titular', $this->origen_titular, true);
        if (is_numeric($this->cedula_titular))
            $criteria->compare('t.cedula_titular', $this->cedula_titular);
        if (strlen($this->nombre_titular) > 0)
            $criteria->compare('t.nombre_titular', $this->nombre_titular, true);
        if (strlen($this->resultado_asignacion_ti) > 0)
            $criteria->compare('t.resultado_asignacion_ti', $this->resultado_asignacion_ti, true);
        if (Utiles::isValidDate($this->fecha_ultima_asistencia_reg, 'y-m-d'))
            $criteria->compare('t.fecha_ultima_asistencia_reg', $this->fecha_ultima_asistencia_reg);
        // if(strlen($this->fecha_ultima_asistencia_reg)>0) $criteria->compare('fecha_ultima_asistencia_reg',$this->fecha_ultima_asistencia_reg,true);
        if (is_numeric($this->ultima_asistencia_reg))
            $criteria->compare('t.ultima_asistencia_reg', $this->ultima_asistencia_reg);
        if (Utiles::isValidDate($this->fecha_egreso, 'y-m-d'))
            $criteria->compare('t.fecha_egreso', $this->fecha_egreso);
        // if(strlen($this->fecha_egreso)>0) $criteria->compare('fecha_egreso',$this->fecha_egreso,true);
        if (strlen($this->observacion) > 0)
            $criteria->compare('t.observacion', $this->observacion, true);
        if (strlen($this->usuario_ini_id) > 0)
            $criteria->compare('t.usuario_ini_id', $this->usuario_ini_id, true);
        if (Utiles::isValidDate($this->fecha_ini, 'y-m-d'))
            $criteria->compare('t.fecha_ini', $this->fecha_ini);
        // if(strlen($this->fecha_ini)>0) $criteria->compare('fecha_ini',$this->fecha_ini,true);
        if (strlen($this->usuario_act_id) > 0)
            $criteria->compare('t.usuario_act_id', $this->usuario_act_id, true);
        if (Utiles::isValidDate($this->fecha_act, 'y-m-d'))
            $criteria->compare('fecha_act', $this->fecha_act);
        // if(strlen($this->fecha_act)>0) $criteria->compare('fecha_act',$this->fecha_act,true);
        if (strlen($this->busqueda) > 0)
            $criteria->compare('t.busqueda', $this->busqueda, true);
        if (strlen($this->codigo_integridad) > 0)
            $criteria->compare('t.codigo_integridad', $this->codigo_integridad, true);
        if (in_array($this->estatus, array('A', 'I', 'E')))
            $criteria->compare('t.estatus', $this->estatus, true);
        if (strlen($this->verificado_saime) > 0)
            $criteria->compare('t.verificado_saime', $this->verificado_saime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave() {
        parent::beforeSave();
        $this->fecha_ini = date('Y-m-d H:i:s');
        $this->usuario_ini_id = Yii::app()->user->id;
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
        $this->direccion = Utiles::removeXSS($this->direccion);
        $this->enfermedades = Utiles::removeXSS($this->enfermedades);
        $this->observacion = Utiles::removeXSS($this->observacion);
        $this->aptitudes = Utiles::removeXSS($this->aptitudes);
        $this->resultado_asignacion_ti = Utiles::removeXSS($this->aptitudes);
        return true;
    }

    public function beforeUpdate() {
        parent::beforeSave();
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
        $this->direccion = Utiles::removeXSS($this->direccion);
        $this->enfermedades = Utiles::removeXSS($this->enfermedades);
        $this->observacion = Utiles::removeXSS($this->observacion);
        $this->aptitudes = Utiles::removeXSS($this->aptitudes);
        $this->resultado_asignacion_ti = Utiles::removeXSS($this->aptitudes);
        return true;
    }

    public function beforeDelete() {
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
        // $this->fecha_eli = $this->fecha_act;
        $this->estatus = 'I';
    }

    public function beforeActivate() {
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
        $this->estatus = 'A';
    }

    public function getIdByOrigenYCedula($origen, $cedula){
        $result = null;
        if(in_array($origen, array('V','E','T','P')) && is_numeric($cedula)){
            $sql = 'SELECT id FROM '.$this->tableName().' where origen = :origen AND cedula = :cedula LIMIT 1';
            $query = Yii::app()->db->createCommand($sql);
            $query->bindParam(':origen', $origen, PDO::PARAM_STR);
            $query->bindParam(':cedula', $cedula, PDO::PARAM_INT);
            $result = $query->queryScalar();
        }
        return $result;
    }

    /**
     *
     *  -- TABLA DE RESPUESTA QUE PODRÁ DAR LA FUNCION PL/PGSQL
     *  -- -------------------------------
     *  --  CODIGO | RESULTADO | MENSAJE
     *  -- -------------------------------
     *  --  S0000  | EXITO     | X Cumple con los requisitos básicos necesarios para ser asignada a un plantel como Madre Colaboradora.
     *  --  W0001  | ALERTA    | X La Madre Colaboradora ya se encuentra asignado a este plantel en el periodo actual.
     *  --  W0002  | ALERTA    | X Cédula de Identidad no registrada como Madre Colaboradora. X
     *  --  E0003  | ERROR     | X El Plantel no es beneficiario PAE.
     *  --  E0004  | ERROR     | X PAE Inactivo en el Plantel.
     *  --  E0005  | ERROR     | X Cédula de Identidad no existente en la base de datos SAIME.
     *  --  E0006  | ERROR     | X La Madre Colaboradora se encuentra asignado a otro plantel en el periodo actual.
     *  --  E0007  | ERROR     | X Sobrepasa la cantidad de Madres Colaboradoras Necesarias para la matricula del Plantel.
     *  --  E0008  | ERROR     | X No existe un periodo escolar activo en el sistema.
     *  -- -------------------------------
     *
     * @param string $origen
     * @param int $cedula
     * @param int $plantel
     * @param string $modulo
     * @return array
     */
    public function isValidToAsign($origen, $cedula, $plantel, $modulo){

        $result = array();
        $userId = Yii::app()->user->id;
        $userName = Yii::app()->user->name;
        $userIpAddress = Utiles::getRealIP();

        if(in_array($origen, array('V','E','T','P')) && is_numeric($cedula) && is_numeric($plantel) && strlen($modulo)>4){

            $sql = 'SELECT * FROM gplantel.validate_asignacion_madre_cocinera ('
                    . '    :origen::CHARACTER VARYING, '
                    . '    :cedula::INTEGER, '
                    . '    :plantel::INTEGER, '
                    . '    :modulo::CHARACTER VARYING, '
                    . '    :userid::INTEGER, '
                    . '    :username::CHARACTER VARYING, '
                    . '    :ipaddress::CHARACTER VARYING'
                    . ') AS f('
                    . '    "codigo" CHARACTER VARYING(15),'
                    . '    "resultado" CHARACTER VARYING(15),'
                    . '    "mensaje" CHARACTER VARYING(300)'
                    . ')';

            $query = Yii::app()->db->createCommand($sql);

            $query->bindParam(':origen', $origen, PDO::PARAM_STR);
            $query->bindParam(':cedula', $cedula, PDO::PARAM_INT);
            $query->bindParam(':plantel', $plantel, PDO::PARAM_INT);
            $query->bindParam(':modulo', $modulo, PDO::PARAM_INT);
            $query->bindParam(':userid', $userId, PDO::PARAM_INT);
            $query->bindParam(':username', $userName, PDO::PARAM_STR);
            $query->bindParam(':ipaddress', $userIpAddress, PDO::PARAM_STR);

            $queryResponse = $query->queryRow();

            $result = $queryResponse;

        }

        return $result;

    }
    
    public function getData(){
        $sql = "SELECT
                    th.origen, 
                    th.cedula, 
                    th.nombre_titular, 
                    th.sexo, 
                    th.fecha_nacimiento, 
                    th.nombre, 
                    th.apellido, 
                    e.nombre AS estado, 
                    th.numero_cuenta, 
                    th.estatus, 
                    th.fecha_ingreso, 
                    th.fecha_egreso, 
                    th.verificado_saime, 
                    s.origen AS origen_saime, 
                    s.cedula AS cedula_saime, 
                    s.primer_nombre AS primer_nombre_saime, 
                    s.segundo_nombre AS segundo_nombre_saime, 
                    s.primer_apellido AS _saime, 
                    s.segundo_apellido AS _saime, 
                    ci.nombre AS categoria_ingreso, 
                    cdn.nombre AS condicion_nominal, 
                    tn.nombre AS tipo_nomina, 
                    tcgn.nombre AS tipo_cargo, 
                    cgn.nombre AS cargo, 
                    tsc.nombre AS serial_cuenta, 
                    tc.nombre AS cuenta, 
                    b.nombre AS banco
                  FROM
                    gestion_humana.talento_humano th
                    LEFT JOIN auditoria.saime s ON th.origen = s.origen AND th.cedula = s.cedula
                    LEFT JOIN gestion_humana.cargo_nominal cgn ON th.cargo_actual_id = cgn.id
                    LEFT JOIN gestion_humana.tipo_cargo_nominal tcgn ON th.tipo_cargo_actual_id = tcgn.id
                    LEFT JOIN gestion_humana.condicion_nominal cdn ON th.condicion_actual_id = cdn.id
                    LEFT JOIN gestion_nomina.tipo_nomina tn ON th.tipo_nomina_id = tn.id
                    LEFT JOIN administrativo.banco b ON th.banco_id = b.id
                    LEFT JOIN administrativo.tipo_cuenta tc ON th.tipo_cuenta_id = tc.id
                    LEFT JOIN administrativo.tipo_serial_cuenta tsc ON th.tipo_serial_cuenta_id = tsc.id
                    LEFT JOIN public.estado e ON th.estado_id = e.id
                    LEFT JOIN gestion_humana.categoria_ingreso ci ON th.categoria_ingreso_id = ci.id";
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
     * @return TalentoHumano the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

<?php

/**
 * This is the model class for table "matricula.estudiante".
 *
 * The followings are the available columns in table 'matricula.estudiante':
 * @property integer $id
 * @property integer $cedula_escolar
 * @property integer $cedula_identidad
 * @property string $nombres
 * @property string $apellidos
 * @property string $fecha_nacimiento
 * @property string $correo
 * @property string $telefono_movil
 * @property string $telefono_habitacion
 * @property string $plantel_anterior_id
 * @property string $lateralidad_mano
 * @property string $identificacion_extranjera
 * @property string $ciudad_nacimiento
 * @property integer $pais_id
 * @property integer $etnia_id
 * @property integer $estado_civil_id
 * @property integer $diversidad_funcional_id
 * @property string $sexo
 * @property integer $condicion_vivienda_id
 * @property integer $zona_ubicacion_id
 * @property integer $tipo_vivienda_id
 * @property integer $ubicacion_vivienda_id
 * @property string $ingreso_familiar
 * @property integer $condicion_infraestructura_id
 * @property integer $beca
 * @property integer $canaima
 * @property string $serial_canaima
 * @property string $nacionalidad
 * @property integer $estado_nac_id
 * @property integer $municipio_nac_id
 * @property integer $parroquia_nac_id
 * @property string $direccion_nac
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $parroquia_id
 * @property string $direccion_dom
 * @property integer $poblacion_id
 * @property integer $urbanizacion_id
 * @property integer $tipo_via_id
 * @property string $via
 * @property integer $representante_id
 * @property string $plantel_actual_id
 * @property string $descripcion_afinidad
 * @property integer $otro_represent_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Genero $sexo
 * @property Representante $otroRepresent
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
 * @property Representante $representante
 * @property TipoVivienda $tipoVivienda
 * @property UbicacionVivienda $ubicacionVivienda
 * @property CondicionInfraestructura $condicionInfraestructura
 * @property ZonaUbicacion $zonaUbicacion
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property CondicionVivienda $condicionVivienda
 * @property DiversidadFuncional $diversidadFuncional
 * @property EstadoCivil $estadoCivil
 * @property Etnia $etnia
 * @property InscripcionEstudiante[] $inscripcionEstudiantes
 * @property DatosAntropometricos[] $datosAntropometricoses
 * @property HistorialMedico[] $historialMedicos
 */
class Estudiante extends CActiveRecord {

    public $cirepresentante; /* NO ELIMINAR JEAN CARLOS */

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'matricula.estudiante';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('cedula_identidad, cedula_escolar, nombres, apellidos, fecha_nacimiento', 'required'),
            array('nombres,
                   apellidos,
                   fecha_nacimiento,
                   estado_civil_id,
                   nacionalidad,
                   sexo,
                   pais_id,
                   estado_id,
                   municipio_id,
                   parroquia_id,
                   poblacion_id,
                   urbanizacion_id,
                   tipo_via_id,
                   via,
                   direccion_dom,
                   zona_ubicacion_id,
                   tipo_vivienda_id,
                   ubicacion_vivienda_id,
                   condicion_vivienda_id,
                   condicion_infraestructura_id,
                   beca,
                   canaima',
                'required', 'on' => 'gestionEstudiante'),
            array('cedula_escolar, pais_id, etnia_id, estado_civil_id, diversidad_funcional_id, condicion_vivienda_id, zona_ubicacion_id, tipo_vivienda_id, ubicacion_vivienda_id, condicion_infraestructura_id, beca, canaima, estado_nac_id, municipio_nac_id, parroquia_nac_id, estado_id, municipio_id, parroquia_id, poblacion_id, urbanizacion_id, tipo_via_id, representante_id, otro_represent_id, usuario_ini_id, usuario_act_id, estatus_id', 'numerical', 'integerOnly' => true),
            array('nombres, ciudad_nacimiento, descripcion_afinidad', 'length', 'min' => 3, 'max' => 120),
            array('nombres, apellidos', 'length', 'min' => 3, 'max' => 120, 'on' => 'crearEstudiante'),
            array('nombres, apellidos', 'length', 'min' => 3, 'max' => 120, 'on' => 'estudianteMayor'),
            array('cedula_escolar, estado_nac_id, representante_id, usuario_ini_id, usuario_act_id, estatus_id, plantel_actual_id, plantel_anterior_id', 'numerical', 'integerOnly' => true, 'on' => 'crearEstudiante'),
            array('correo', 'length', 'max' => 40),
            array('cedula_identidad', 'required', 'message' => 'La fecha de nacimiento del Estudiante indica que es mayor de edad, ingrese la Cédula de Identidad para continuar.', 'on' => 'estudianteMayor'),
            array('nombres, apellidos, cedula_escolar, fecha_nacimiento, sexo', 'required', 'on' => 'crearEstudiante'),
            array('nombres, apellidos, cedula_escolar, fecha_nacimiento, sexo', 'required', 'on' => 'estudianteMayor'),
            array('cedula_escolar', 'unique', 'on' => 'crearEstudiante'),
            array('cedula_identidad', 'unique', 'on' => 'crearEstudiante'),
            array('cedula_escolar', 'unique', 'on' => 'estudianteMayor'),
            array('cedula_identidad', 'unique', 'on' => 'estudianteMayor'),
            array('telefono_movil, telefono_habitacion, plantel_anterior_id, plantel_actual_id', 'length', 'max' => 15),
            array('lateralidad_mano', 'length', 'max' => 3),
            array('identificacion_extranjera', 'length', 'max' => 20),
            array('nacionalidad, estatus', 'length', 'max' => 1),
            array('direccion_nac', 'length', 'max' => 50),
            //array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 6),
            array('fecha_nacimiento, ingreso_familiar, serial_canaima, direccion_dom, via', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, estatud_id, cedula_escolar, cedula_identidad, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, fecha_nacimiento, correo, telefono_movil, telefono_habitacion, plantel_anterior_id, lateralidad_mano, identificacion_extranjera, ciudad_nacimiento, pais_id, etnia_id, estado_civil_id, diversidad_funcional_id, sexo, condicion_vivienda_id, zona_ubicacion_id, tipo_vivienda_id, ubicacion_vivienda_id, ingreso_familiar, condicion_infraestructura_id, beca, canaima, serial_canaima, nacionalidad, estado_nac_id, municipio_nac_id, parroquia_nac_id, direccion_nac, estado_id, municipio_id, parroquia_id, direccion_dom, poblacion_id, urbanizacion_id, tipo_via_id, via, representante_id, plantel_actual_id, descripcion_afinidad, otro_represent_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'otroRepresent' => array(self::BELONGS_TO, 'Representante', 'otro_represent_id'),
            'pais' => array(self::BELONGS_TO, 'Pais', 'pais_id'),
            'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
            'estadoNac' => array(self::BELONGS_TO, 'Estado', 'estado_nac_id'),
            'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
            'municipioNac' => array(self::BELONGS_TO, 'Municipio', 'municipio_nac_id'),
            'parroquia' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_id'),
            'parroquiaNac' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_nac_id'),
            /* CREANDO LAS RELACIONES DE LOS PLANTELES **BY ENRIQUEX** */
            'plantelActual' => array(self::BELONGS_TO, 'Plantel', 'plantel_actual_id'),
            'plantelAnterior' => array(self::BELONGS_TO, 'Plantel', 'plantel_anterior_id'),
            'gradoActual' => array(self::BELONGS_TO, 'Grado', 'grado_actual_id'),
            'gradoAnterior' => array(self::BELONGS_TO, 'Grado', 'grado_anterior_id'),
            /* FIN DE CREACION DE PLANTELES */
            'poblacion' => array(self::BELONGS_TO, 'Poblacion', 'poblacion_id'),
            'tipoVia' => array(self::BELONGS_TO, 'TipoVia', 'tipo_via_id'),
            'urbanizacion' => array(self::BELONGS_TO, 'Urbanizacion', 'urbanizacion_id'),
            'representante' => array(self::BELONGS_TO, 'Representante', 'representante_id'),
            'tipoVivienda' => array(self::BELONGS_TO, 'TipoVivienda', 'tipo_vivienda_id'),
            'ubicacionVivienda' => array(self::BELONGS_TO, 'UbicacionVivienda', 'ubicacion_vivienda_id'),
            'condicionInfraestructura' => array(self::BELONGS_TO, 'CondicionInfraestructura', 'condicion_infraestructura_id'),
            'zonaUbicacion' => array(self::BELONGS_TO, 'ZonaUbicacion', 'zona_ubicacion_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'condicionVivienda' => array(self::BELONGS_TO, 'CondicionVivienda', 'condicion_vivienda_id'),
            'diversidadFuncional' => array(self::BELONGS_TO, 'DiversidadFuncional', 'diversidad_funcional_id'),
            'estadoCivil' => array(self::BELONGS_TO, 'EstadoCivil', 'estado_civil_id'),
            'etnia' => array(self::BELONGS_TO, 'Etnia', 'etnia_id'),
            'inscripcionEstudiantes' => array(self::HAS_MANY, 'InscripcionEstudiante', 'estudiante_id'),
            'datosAntropometricoses' => array(self::HAS_MANY, 'DatosAntropometricos', 'estudiante_id'),
            'historialMedicos' => array(self::HAS_MANY, 'HistorialMedico', 'estudiante_id'),
            'estatusEstudiante' => array(self::BELONGS_TO, 'EstatusEstudiante', 'estatus_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cedula_escolar' => 'Cédula Escolar',
            'cedula_identidad' => 'Cédula de Identidad',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'correo' => 'Correo',
            'telefono_movil' => 'Teléfono Movil',
            'telefono_habitacion' => 'Teléfono Habitacion',
            'plantel_anterior_id' => 'Plantel al que pertenecía el estudiante',
            'lateralidad_mano' => 'Lateralidad de la mano',
            'identificacion_extranjera' => 'Identificacion Extranjera',
            'ciudad_nacimiento' => 'Ciudad de Nacimiento',
            'pais_id' => 'Pais de nacimiento',
            'etnia_id' => 'etnia a la pertenece el estudiante',
            'estado_civil_id' => 'Estado Civil',
            'diversidad_funcional_id' => 'Diversidad Funcional',
            'sexo' => 'Genero',
            'condicion_vivienda_id' => 'Condicion Vivienda',
            'zona_ubicacion_id' => 'Zona Ubicacion',
            'tipo_vivienda_id' => 'Tipo Vivienda',
            'ubicacion_vivienda_id' => 'Ubicacion Vivienda',
            'ingreso_familiar' => 'Ingreso Familiar',
            'condicion_infraestructura_id' => 'Condicion Infraestructura',
            'beca' => 'Beca',
            'canaima' => 'Canaima',
            'serial_canaima' => 'Serial Canaima',
            'nacionalidad' => 'Nacionalidad',
            'estado_nac_id' => 'Estado de nacimiento del estudiante',
            'municipio_nac_id' => 'Municipio de nacimiento del estudiante',
            'parroquia_nac_id' => 'Parroquia de nacimiento del estudiante',
            'direccion_nac' => 'Direccion de nacimiento del estudiante',
            'estado_id' => 'Estado de domicilio',
            'municipio_id' => 'Municipio de domicilio',
            'parroquia_id' => 'Parroquia de domicilio',
            'direccion_dom' => 'Direccion de domicilio',
            'poblacion_id' => 'Población de domicilio',
            'urbanizacion_id' => 'Urbanizacion de domicilio',
            'tipo_via_id' => 'Tipo de via de domicilio',
            'via' => 'Via de domicilio',
            'representante_id' => 'Representante legal del estudiante',
            'plantel_actual_id' => 'código del plantel al que pertenece el estudiante',
            'descripcion_afinidad' => 'descripcion de la afinidad de otro representante.',
            'otro_represent_id' => 'Otro Representante',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'estatus_id' => 'Estatus Actual del estudiante',
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
        $groupId = Yii::app()->user->group;
        $usuarioId = Yii::app()->user->id;

        $criteria = new CDbCriteria;
        if (!isset($_GET['Estudiante'])) {
            $this->id = 0;
        } else {
            $estudiante = $_GET['Estudiante'];
            if (!isset($estudiante['cedula_identidad_representante'])) {
                if (
                        $estudiante['apellidos'] == '' &&
                        $estudiante['cedula_escolar'] == '' &&
                        $estudiante['cedula_identidad'] == '' &&
                        $estudiante['nombres'] == '' &&
                        $estudiante['plantel_actual_id'] == '' &&
                        $estudiante['representante_id'] == '') {
                    $this->id = 0;
                }
            } else {
                if (
                        $estudiante['apellidos'] == '' &&
                        $estudiante['cedula_escolar'] == '' &&
                        $estudiante['cedula_identidad'] == '' &&
                        $estudiante['cedula_identidad_representante'] == '' &&
                        $estudiante['nombres'] == '' &&
                        $estudiante['codigo_plantel'] == '' &&
                        $estudiante['estado_id'] == '') {
                    $this->id = 0;
                }
            }
        }

        $criteria->compare('t.id', $this->id);
        if (is_numeric($this->cedula_escolar)) {
            if (strlen($this->cedula_escolar) <= 20) {
                $criteria->compare('cedula_escolar', $this->cedula_escolar);
            }
        }
        if (is_numeric($this->cedula_identidad)) {
            if (strlen($this->cedula_identidad) <= 15) {
                $criteria->compare('t.cedula_identidad', $this->cedula_identidad);
            }
        }
        $nombres = NULL;
        $apellidos = NULL;
        if (isset($_GET['Estudiante']['nombres'])) {
            $nombres = $_GET['Estudiante']['nombres'];
        }
        if (isset($_GET['Estudiante']['apellidos'])) {
            $apellidos = $_GET['Estudiante']['apellidos'];
        }
        if ($nombres != NULL || $apellidos != NULL) {
            $criteria->addCondition("t.busqueda @@ plainto_tsquery(:configuracion, :busqueda)");
            $criteria->params = array_merge($criteria->params, array(':configuracion' => 'pg_catalog.spanish'));
            $criteria->params = array_merge($criteria->params, array(':busqueda' => $nombres . ' ' . $apellidos));
        }

        if (isset($_GET['Estudiante'])) {
            $codigo_plantel = '';
            $cedula_representante = '';
            if ($this->plantel_actual_id) {
                $codigo_plantel = $this->plantel_actual_id;
            } else if (isset($_GET['Estudiante']['codigo_plantel'])) {
                $codigo_plantel = $_GET['Estudiante']['codigo_plantel'];
            }
            if ($this->representante_id) {
                $cedula_representante = $this->representante_id;
            } else if (isset($_GET['Estudiante']['cedula_identidad_representante'])) {
                $cedula_representante = $_GET['Estudiante']['cedula_identidad_representante'];
            }

            if ($cedula_representante) {
                if ($cedula_representante != '') {
                    if (is_numeric($cedula_representante)) {
                        $criteria->join .= " LEFT JOIN matricula.representante r ON r.id = t.representante_id";
                        $criteria->addCondition("r.cedula_identidad = :cedula_identidad");
                        $criteria->params = array_merge($criteria->params, array(':cedula_identidad' => (int) $cedula_representante));
                    }
                }
            }
            if ($codigo_plantel != '') {
                $criteria->join .= " LEFT JOIN gplantel.plantel p ON p.id = t.plantel_actual_id";
                $criteria->addCondition("p.cod_plantel ILIKE :cod_plantel");
                $criteria->params = array_merge($criteria->params, array(':cod_plantel' => $codigo_plantel));
            }
        }
        /**
         * Si el usuario es Director (29)
         */
        if ($groupId == UserGroups::DIRECTOR) {
            $plantel_id = NULL;
            if (isset($_REQUEST['Estudiante']['plantel_id'])) {
                $plantel_id = $_REQUEST['Estudiante']['plantel_id'];
            }
            if ($plantel_id != NULL) {
                $criteria->join .= " LEFT JOIN gplantel.autoridad_plantel ON t.plantel_actual_id = gplantel.autoridad_plantel.plantel_id ";
                $criteria->addCondition("gplantel.autoridad_plantel.usuario_id = :usuario AND t.plantel_actual_id = :plantel_id");
                $criteria->params = array_merge($criteria->params, array(':usuario' => (int) $usuarioId));
                $criteria->params = array_merge($criteria->params, array(':plantel_id' => (int) $plantel_id));
            }
        }

        $criteria->compare('fecha_nacimiento', $this->fecha_nacimiento, true);
        $criteria->compare('correo', $this->correo, true);
        $criteria->compare('telefono_movil', $this->telefono_movil, true);
        $criteria->compare('telefono_habitacion', $this->telefono_habitacion, true);
        $criteria->compare('plantel_anterior_id', $this->plantel_anterior_id, true);
        $criteria->compare('lateralidad_mano', $this->lateralidad_mano, true);
        $criteria->compare('identificacion_extranjera', $this->identificacion_extranjera, true);
        $criteria->compare('ciudad_nacimiento', $this->ciudad_nacimiento, true);
        $criteria->compare('pais_id', $this->pais_id);
        $criteria->compare('etnia_id', $this->etnia_id);
        $criteria->compare('estado_civil_id', $this->estado_civil_id);
        $criteria->compare('diversidad_funcional_id', $this->diversidad_funcional_id);
        $criteria->compare('sexo', $this->sexo);
        $criteria->compare('condicion_vivienda_id', $this->condicion_vivienda_id);
        $criteria->compare('zona_ubicacion_id', $this->zona_ubicacion_id);
        $criteria->compare('tipo_vivienda_id', $this->tipo_vivienda_id);
        $criteria->compare('ubicacion_vivienda_id', $this->ubicacion_vivienda_id);
        $criteria->compare('ingreso_familiar', $this->ingreso_familiar, true);
        $criteria->compare('condicion_infraestructura_id', $this->condicion_infraestructura_id);
        $criteria->compare('beca', $this->beca);
        $criteria->compare('canaima', $this->canaima);
        $criteria->compare('serial_canaima', $this->serial_canaima, true);
        $criteria->compare('nacionalidad', $this->nacionalidad, true);
        $criteria->compare('estado_nac_id', $this->estado_nac_id);
        $criteria->compare('municipio_nac_id', $this->municipio_nac_id);
        $criteria->compare('parroquia_nac_id', $this->parroquia_nac_id);
        $criteria->compare('direccion_nac', $this->direccion_nac, true);
        if (is_numeric($this->estado_id)) {
            if (strlen($this->estado_id) <= 10) {
                $criteria->compare('estado_id', $this->estado_id);
            }
        }
        $criteria->compare('municipio_id', $this->municipio_id);
        $criteria->compare('parroquia_id', $this->parroquia_id);
        $criteria->compare('direccion_dom', $this->direccion_dom, true);
        $criteria->compare('poblacion_id', $this->poblacion_id);
        $criteria->compare('urbanizacion_id', $this->urbanizacion_id);
        $criteria->compare('tipo_via_id', $this->tipo_via_id);
        $criteria->compare('via', $this->via, true);
//        $criteria->compare('representante_id', $this->representante_id);

        $plantel_id = NULL;
        if (isset($_REQUEST['Estudiante']['plantel_id'])) {
            $plantel_id = $_REQUEST['Estudiante']['plantel_id'];
        }
        if ($plantel_id != NULL) {
            $criteria->compare('plantel_actual_id', $plantel_id);
        }
        $criteria->compare('descripcion_afinidad', $this->descripcion_afinidad, true);
        $criteria->compare('otro_represent_id', $this->otro_represent_id);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('estatus_id', $this->estatus_id, true);
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function obtenerPaises() {
        $sql = 'SELECT id, nombre FROM pais';
        $resultado = Yii::app()->db->createCommand($sql);
        return $resultado->queryAll();
    }

    public function obtenerDatosPais($id) {
        if (is_numeric($id)) {
            $sql = 'SELECT nombre FROM pais WHERE id = ' . $id;
            $resultado = Yii::app()->db->createCommand($sql);
            return $resultado->queryAll();
        } else {
            return null;
        }
    }

    public function obtenerDatosEtnia($id) {
        if (is_numeric($id)) {
            $sql = 'SELECT nombre FROM etnia WHERE id = ' . $id;
            $resultado = Yii::app()->db->createCommand($sql);
            return $resultado->queryAll();
        } else {
            return null;
        }
    }

    public function obtenerCondicionVivienda() {
        $sql = 'SELECT id, nombre FROM condicion_vivienda ORDER BY nombre ASC';
        $resultado = Yii::app()->db->createCommand($sql);
        return $resultado->queryAll();
    }

    public function obtenerTipoVivienda() {
        $sql = 'SELECT id, nombre FROM tipo_vivienda ORDER BY nombre ASC';
        $resultado = Yii::app()->db->createCommand($sql);
        return $resultado->queryAll();
    }

    public function obtenerUbicacionVivienda() {
        $sql = 'SELECT id, nombre FROM ubicacion_vivienda ORDER BY nombre ASC';
        $resultado = Yii::app()->db->createCommand($sql);
        return $resultado->queryAll();
    }

    public function obtenerEtnia() {
        $sql = 'SELECT id, nombre FROM etnia ORDER BY nombre ASC';
        $resultado = Yii::app()->db->createCommand($sql);
        return $resultado->queryAll();
    }

    public function obtenerDiversidadFuncional() {
        $sql = 'SELECT id, nombre FROM diversidad_funcional ORDER BY nombre ASC';
        $resultado = Yii::app()->db->createCommand($sql);
        return $resultado->queryAll();
    }

    public function obtenerTipoSangre() {
        $sql = 'SELECT id, nombre FROM tipo_sangre';
        $resultado = Yii::app()->db->createCommand($sql);
        return $resultado->queryAll();
    }

    public function obtenerProfesion() {
        $sql = 'SELECT id, nombre FROM profesion';
        $resultado = Yii::app()->db->createCommand($sql);
        return $resultado->queryAll();
    }

    public function optenerEstatusDirector($usuario_id, $plantel_actual_id) {
        if (is_numeric($usuario_id)) {
            $sql = "SELECT plantel_id FROM gplantel.autoridad_plantel WHERE usuario_id = :usuario_id AND plantel_id = :plantel_id AND estatus = 'A'";
            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $consulta->bindParam(":plantel_id", $plantel_actual_id, PDO::PARAM_INT);
            $resultado = $consulta->queryAll();
        }
        if ($resultado == '' || $resultado == NULL) {
            $resultado[0]['plantel_id'] = '';
        }
        return $resultado;
    }
    
    public function historicoEstudiante($cedula_estudiante, $estudiante_id) {
        if($cedula_estudiante == '') {
            $cedula_estudiante = 'NULL';
        }
        if($estudiante_id == '') {
            $estudiante_id = 'NULL';
        }
            $sql = 'SELECT
                        p.cod_plantel AS cod_plantel,
                        p.nombre AS nombre_plantel,
                        g.nombre AS nombre_grado,
                        s.nombre AS nombre_seccion,
                        m.nombre AS nombre_modalidad,
                        pe.periodo,
                        e.inscripcion_regular::text || e.repitiente::text || e.repitiente_completo::text || materia_pendiente::text || e.diferido::text || e.doble_inscripcion::text AS escolaridad,
                        es.nombre AS nombre_estado,
                        e.observacion AS observacion
                    FROM matricula.inscripcion_estudiante e
                        LEFT JOIN gplantel.plantel p ON p.id = e.plantel_id
                        LEFT JOIN gplantel.grado g ON g.id = e.grado_id
                        LEFT JOIN gplantel.seccion_plantel_periodo spp ON spp.id = e.seccion_plantel_periodo_id
                        LEFT JOIN gplantel.seccion_plantel sp ON sp.id = spp.seccion_plantel_id
                        LEFT JOIN gplantel.seccion s ON s.id = sp.seccion_id
                        LEFT JOIN gplantel.modalidad m ON m.id = p.modalidad_id
                        LEFT JOIN estado es ON es.id = p.estado_id
                        LEFT JOIN gplantel.periodo_escolar pe ON pe.id = e.periodo_id
                        WHERE estudiante_id = ' . $estudiante_id . '
                    UNION
                    SELECT
                        p.cod_plantel AS cod_plantel,
                        p.nombre AS nombre_plantel,
                        a.s_grado_nombre AS nombre_grado,
                        a.cseccion AS nombre_seccion,
                        a.s_modalidad_nombre AS nombre_modalidad,
                        a.s_periodo_nombre AS nombre_periodo,
                        a.s_escolaridad_nombre AS escolaridad,
                        es.nombre AS nombre_estado,
                        a.dobservacion AS observacion
                    FROM legacy.talumno_acad a
                        LEFT JOIN gplantel.plantel p on p.cod_plantel = a.cdea
                        LEFT JOIN estado es ON es.id = p.estado_id
                        WHERE calumno = ' . $cedula_estudiante . '
                    ORDER BY periodo DESC limit 10;';
            $resultado = Yii::app()->db->createCommand($sql);
            return $resultado->queryAll();
    }

    public function obtenerYAsignarRepresentanteAlEstudiante($cedulaEscolar, $cedulaRepresentante) {
        $groupId = Yii::app()->user->group;
        $usuarioId = Yii::app()->user->id;
        $estatus_id = '';
        if ($groupId == UserGroups::DIRECTOR) {
            /* BUSQUEDA DEL ESTATUS DEL ESTATUS_ESTUDIANTE (ASIGNADO) */
            $sql = "SELECT id FROM matricula.estatus_estudiante WHERE nombre ILIKE '%ASIGNADO%'";
            $busqueda = Yii::app()->db->createCommand($sql);
            $estatus_id = $busqueda->queryAll();
        } else {

            /* BUSQUEDA DEL ESTATUS DEL ESTATUS_ESTUDIANTE (REGISTRADO) */
            $sql = "SELECT id FROM matricula.estatus_estudiante WHERE nombre ILIKE '%REGISTRADO%'";
            $busqueda = Yii::app()->db->createCommand($sql);
            $estatus_id = $busqueda->queryAll();
        }
        if (isset($cedulaEscolar)) {
            if (is_numeric($cedulaEscolar) || is_numeric($cedulaRepresentante)) {
                $sql = 'SELECT id FROM matricula.representante WHERE cedula_identidad = ' . $cedulaRepresentante . ' ORDER BY id DESC';
                $resultado = Yii::app()->db->createCommand($sql);
                $r = $resultado->queryAll();

                $sql = 'UPDATE matricula.estudiante SET representante_id = ' . $r[0]['id'] .
                        ', estatus_id = ' . $estatus_id[0]['id'] . '
                        WHERE cedula_escolar = ' . $cedulaEscolar;
                $resultado = Yii::app()->db->createCommand($sql);
                return $resultado->execute();
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function obtenerEstudiantesPorInscripccion($plantel_id, $periodo_actual, $seccion_plantel_id) {
        $gradosPrescolar [] = 3;
        $gradosPrescolar [] = 4;
        $gradosPrescolar [] = 7;
        $gradosPrescolar [] = 8;
        $gradosPrescolar [] = 11;
        $gradosPrescolar [] = 12;
        $periodo_anterior = ($periodo_actual['anio_inicio'] - 1) . '-' . ($periodo_actual['anio_fin'] - 1);

        $periodo_anterior_id = PeriodoEscolar::model()->obtenerPeriodoAnterior($periodo_anterior);
        $datosSeccion = SeccionPlantel::model()->obtenerDatosSeccion($seccion_plantel_id, $plantel_id);
        if ($periodo_actual['id'] == 14) {
//            $sql = "SELECT e.id, upper(e.nombres) || ' ' || upper(e.apellidos) as nom_completo, e.cedula_escolar, e.fecha_nacimiento , r.cedula_identidad"
//                    . " FROM matricula.estudiante e"
//                    . " LEFT JOIN matricula.representante r on (e.representante_id = r.id)"
//                    . " INNER JOIN matricula.inscripcion_estudiante ie on (ie.estudiante_id = e.id)"
//                    . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.id = ie.seccion_plantel_periodo_id)"
//                    . " INNER JOIN gplantel.seccion_plantel spl on (spl.id = spp.seccion_plantel_id)"
//                    . " INNER JOIN gplantel.grado g on (spl.grado_id = g.id)"
//                    . " INNER JOIN gplantel.periodo_escolar pe on (pe.id = spp.periodo_id)"
//                    . " WHERE  spp.periodo_id = :periodo_id  AND spl.plantel_id = :plantel_id"
//                    . " AND (ie.estudiante_id not in ("
//                    . "     SELECT iest.estudiante_id from matricula.inscripcion_estudiante iest"
//                    . "     INNER JOIN gplantel.seccion_plantel_periodo spp_i on (spp_i.id = iest.seccion_plantel_periodo_id)"
//                    . "     INNER JOIN gplantel.seccion_plantel spl_i on (spl_i.id = spp_i.seccion_plantel_id)"
//                    . "     WHERE spp_i.periodo_id = :periodo_actual_id AND spl_i.plantel_id = :plantel_id)"
//                    . " )"
//                    . " AND g.consecutivo =
//                              (SELECT (g_i.consecutivo-1) FROM gplantel.grado g_i INNER JOIN  gplantel.seccion_plantel spl_i on (spl_i.grado_id = g_i.id)"
//                    . "        WHERE spl_i.id = :seccion_plantel_id"
//                    . "        )"
//                    . " ORDER BY e.cedula_escolar ASC, r.cedula_identidad ASC";
            if (in_array($datosSeccion['id'], $gradosPrescolar)) {
                $sql = "SELECT "
                        . " DISTINCT me.id, upper(me.nombres) || ' ' || upper(me.apellidos) as nom_completo, me.cedula_escolar, me.fecha_nacimiento , me.cedula_identidad, 'no' as nuevoRegistro"
                        . " FROM matricula.estudiante me "
                        . " INNER JOIN gplantel.plantel p on me.plantel_actual_id=p.id "
                        . " INNER JOIN matricula.inscripcion_historico ih on me.sigue_id=ih.s_alumno_id "
                        . " where "
                        . " ih.fperiodoescolar_id=:periodo_anterior_id "
                        . " AND me.plantel_actual_id = :plantel_id "
                        . " AND ih.grado_id = 0 "
                        . " AND me.id not in (select m_ie.estudiante_id from matricula.inscripcion_estudiante m_ie "
                        . " inner join gplantel.seccion_plantel_periodo  spp_i on (spp_i.id = m_ie.seccion_plantel_periodo_id) "
                        . " where spp_i.periodo_id = :periodo_actual_id) "
                        . " ORDER BY me.cedula_identidad ASC";
                $busqueda = Yii::app()->db->createCommand($sql);
            } else {

                $sql = "SELECT "
                        . " DISTINCT me.id, upper(me.nombres) || ' ' || upper(me.apellidos) as nom_completo, me.cedula_escolar, me.fecha_nacimiento , me.cedula_identidad, 'no' as nuevoRegistro"
                        . " FROM matricula.estudiante me "
                        . " INNER JOIN gplantel.plantel p on me.plantel_actual_id=p.id "
                        . " INNER JOIN matricula.inscripcion_historico ih on me.sigue_id=ih.s_alumno_id "
                        . " INNER JOIN gplantel.grado g on (ih.grado_id = g.id) "
                        . " where "
                        . " ih.fperiodoescolar_id=:periodo_anterior_id "
                        . " AND me.plantel_actual_id = :plantel_id "
                        . " AND g.consecutivo =
                              (SELECT (g_i.consecutivo-1) FROM gplantel.grado g_i INNER JOIN  gplantel.seccion_plantel spl_i on (spl_i.grado_id = g_i.id)"
                        . "        WHERE spl_i.id = :seccion_plantel_id"
                        . "        )"
                        . " AND me.id not in (select m_ie.estudiante_id from matricula.inscripcion_estudiante m_ie "
                        . " inner join gplantel.seccion_plantel_periodo  spp_i on (spp_i.id = m_ie.seccion_plantel_periodo_id) "
                        . " where spp_i.periodo_id = :periodo_actual_id)"
                        . " ORDER BY me.cedula_identidad ASC";
//                echo '<br>' . $sql;
//                echo '<br>' . $periodo_anterior_id;
//                echo '<br>' . $periodo_actual['id'];
//                echo '<br>' . $plantel_id;
//                echo '<br>' . $seccion_plantel_id;
                $busqueda = Yii::app()->db->createCommand($sql);
                $busqueda->bindParam(":seccion_plantel_id", $seccion_plantel_id, PDO::PARAM_INT);
            }
            $busqueda->bindParam(":periodo_anterior_id", $periodo_anterior_id, PDO::PARAM_INT);
            $busqueda->bindParam(":periodo_actual_id", $periodo_actual['id'], PDO::PARAM_INT);
            $busqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);

            $resultadoEstudiantes = $busqueda->queryAll();
        } else {

            $sql = "SELECT DISTINCT e.id, upper(e.nombres) || ' ' || upper(e.apellidos) as nom_completo, e.cedula_escolar, e.fecha_nacimiento , me.cedula_identidad, 'no' as nuevoRegistro"
                    . " FROM matricula.estudiante e"
                    . " INNER JOIN matricula.inscripcion_estudiante ie on (ie.estudiante_id = e.id)"
                    . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.id = ie.seccion_plantel_periodo_id)"
                    . " INNER JOIN gplantel.seccion_plantel spl on (spl.id = spp.seccion_plantel_id)"
                    . " INNER JOIN gplantel.grado g on (spl.grado_id = g.id)"
                    . " INNER JOIN gplantel.periodo_escolar pe on (pe.id = spp.periodo_id)"
                    . " WHERE  spp.periodo_id = :periodo_id  AND spl.plantel_id = :plantel_id"
                    . " AND (ie.estudiante_id not in ("
                    . "     SELECT iest.estudiante_id from matricula.inscripcion_estudiante iest"
                    . "     INNER JOIN gplantel.seccion_plantel_periodo spp_i on (spp_i.id = iest.seccion_plantel_periodo_id)"
                    . "     INNER JOIN gplantel.seccion_plantel spl_i on (spl_i.id = spp_i.seccion_plantel_id)"
                    . "     WHERE spp_i.periodo_id = :periodo_actual_id AND spl_i.plantel_id = :plantel_id)"
                    . " )"
                    . " AND g.consecutivo =
                              (SELECT (g_i.consecutivo-1) FROM gplantel.grado g_i INNER JOIN  gplantel.seccion_plantel spl_i on (spl_i.grado_id = g_i.id)"
                    . "        WHERE spl_i.id = :seccion_plantel_id"
                    . "        )"
                    . " ORDER BY e.cedula_escolar ASC, r.cedula_identidad ASC";


            $busqueda = Yii::app()->db->createCommand($sql);

            $busqueda->bindParam(":periodo_id", $periodo_anterior_id, PDO::PARAM_INT);
            $busqueda->bindParam(":periodo_actual_id", $periodo_actual['id'], PDO::PARAM_INT);
            $busqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $busqueda->bindParam(":seccion_plantel_id", $seccion_plantel_id, PDO::PARAM_INT);
            $resultadoEstudiantes = $busqueda->queryAll();
        }

        return $resultadoEstudiantes;
    }

    public function obtenerDatosEstudiantes($estudiantes, $nuevoRegistro) {
        $estudiantes_imploded = implode(',', $estudiantes);
        if ($nuevoRegistro == 'si') {
            $sql = "SELECT e.id, upper(e.nombres) || ' ' || upper(e.apellidos) as nom_completo, e.cedula_escolar, e.cedula_identidad as cedula_estudiante, e.fecha_nacimiento, 'si' as nuevoRegistro"
                    . " FROM matricula.estudiante e"
                    . " WHERE e.id IN ($estudiantes_imploded)"
                    . " ORDER BY e.cedula_escolar ASC";
        } else {
            $sql = "SELECT e.id, upper(e.nombres) || ' ' || upper(e.apellidos) as nom_completo, e.cedula_escolar, e.cedula_identidad as cedula_estudiante, e.fecha_nacimiento, 'no' as nuevoRegistro"
                    . " FROM matricula.estudiante e"
                    . " WHERE e.id IN ($estudiantes_imploded)"
                    . " ORDER BY e.cedula_escolar ASC";
        }
        $busqueda = Yii::app()->db->createCommand($sql);

        $resultadoEstudiantes = $busqueda->queryAll();

        return $resultadoEstudiantes;
    }

    public function actualizarDatosEstudiantes($model) {

        $plantel_actual_id = (int) $model->plantel_actual_id;
        $fecha = $model->fecha_act;
        $usuario_act_id = (int) $model->usuario_act_id;
        $estatus = 1;

        $sql = "UPDATE matricula.estudiante e"
                . " SET"
                . " plantel_anterior_id = e.plantel_actual_id,"
                . " plantel_actual_id = :plantel_actual_id,"
                . " estatus = :estatus,"
                . " usuario_act_id = :usuario_act_id,"
                . " fecha_act = :fecha_act";

        $actualizacion = Yii::app()->db->createCommand($sql);
        $actualizacion->bindParam(":plantel_actual_id", $plantel_actual_id, PDO::PARAM_INT);
        $actualizacion->bindParam(":estatus", $estatus, PDO::PARAM_INT);
        $actualizacion->bindParam(":usuario_act_id", $usuario_act_id, PDO::PARAM_INT);
        $actualizacion->bindParam(":fecha_act", $fecha, PDO::PARAM_STR);
        $resultadoEstudiantes = $actualizacion->execute();
        return $resultadoEstudiantes;
    }

    public function calcularEdad($fecha_nacimiento) {
        list($ano, $mes, $dia) = explode("-", $fecha_nacimiento);
        $ano_diferencia = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia = date("d") - $dia;
        if ($dia_diferencia > 0 && $mes_diferencia < 0) {
            $ano_diferencia = $ano_diferencia - 1;
        }
        /* ASI ESTABA ANTES */
//        if (date("m") == $mes && date("d") < $dia) {
//            $ano_diferencia = $ano_diferencia - 1;
//        }
        /* MODIFICADO POR ENRIQUEX */
        if (date("m") <= $mes) {
            $ano_diferencia = $ano_diferencia - 1;
        }
        $edadCalculada = $ano_diferencia;
        return $edadCalculada;
    }

    /* -------------------------------------------JEAN--------------------------------------------------- */

    public function buscarEstudiante($cedula_escolar = '', $cedula_identidad = '', $nombres = '', $apellidos = '', $cirepresentante = '', $busquedaCompleta, $seccion_plantel_id, $plantel_id) {
        $where = '';
        $whereinscrito = '';
        if ($cedula_escolar !== '') {

            $where = "me.cedula_escolar=$cedula_escolar ";
            $whereinscrito = "e.cedula_escolar=$cedula_escolar";
        }

        if ($cedula_identidad !== '') {
            if ($where !== '') {
                $where .= " and me.cedula_identidad=$cedula_identidad";
                $whereinscrito .= "and e.cedula_identidad=$cedula_identidad";
            } else {
                $where = " me.cedula_identidad=$cedula_identidad";
                $whereinscrito = "e.cedula_identidad=$cedula_identidad";
            }
        }


        if ($nombres !== '' && $apellidos !== '') {
            $nombres = trim($nombres);
            $apellidos = trim($apellidos);
            $apellido1 = '';
            $apellido2 = '';
            $apellido3 = '';
            $nombre1 = '';
            $nombre2 = '';
            $nombre3 = '';

            // list($apellido1, $apellido2, $apellido3) = explode(" ", $apellidos);
            $apellidos_exploded = explode(" ", $apellidos);
            $apellido1 = isset($apellidos_exploded[0]) ? $apellidos_exploded[0] : '';
            $apellido2 = isset($apellidos_exploded[1]) ? $apellidos_exploded[1] : '';
            $apellido3 = isset($apellidos_exploded[2]) ? $apellidos_exploded[2] : '';
            // list($nombre1, $nombre2, $nombre3) = explode(" ", $nombres);
            $nombres_exploded = explode(" ", $nombres);
            $nombre1 = isset($nombres_exploded[0]) ? $nombres_exploded[0] : '';
            $nombre2 = isset($nombres_exploded[1]) ? $nombres_exploded[1] : '';
            $nombre3 = isset($nombres_exploded[2]) ? $nombres_exploded[2] : '';
            if ($where !== '') {

                $where .= " and busqueda @@ plainto_tsquery('pg_catalog.spanish', '" . "$nombre1 " . " $nombre2" . " $nombre3" . " $apellido1" . " $apellido2" . " $apellido3" . "')";
//                $where .= ' and busqueda @@ TO_tsquery(' . "'" . '"pg_catalog.spanish"' . "," . '"' . $nombre1 . '" & "' . $nombre2 . '" & "' . $nombre3 . '" & "' . $apellido1 . '" & "' . $apellido2 . '" & "' . $apellido3 . '"' . "'" . ')';
            } else {


                $where .= " busqueda @@ plainto_tsquery('pg_catalog.spanish', '" . "$nombre1 " . " $nombre2" . " $nombre3" . " $apellido1" . " $apellido2" . " $apellido3" . "')";
//                $where .= ' busqueda @@ TO_tsquery(' . "'" . '"pg_catalog.spanish"' . "," . '"' . $nombre1 . '" & "' . $nombre2 . '" & "' . $nombre3 . '" & "' . $apellido1 . '" & "' . $apellido2 . '" & "' . $apellido3 . '"' . "'" . ')';
                //    $where = " me.nombres like '$nombres%'";
            }
        }
//pg_catalog.spanish

        if ($cirepresentante !== '') {
            if ($where !== '') {
                $where .= " and mr.cedula_identidad = $cirepresentante ";
            } else {
                $where = " mr.cedula_identidad = $cirepresentante";
            }
        }

        $gradosPrescolar [] = 3;
        $gradosPrescolar [] = 4;
        $gradosPrescolar [] = 7;
        $gradosPrescolar [] = 8;
        $gradosPrescolar [] = 11;
        $gradosPrescolar [] = 12;
        $nombres = strtoupper($nombres);
        $apellidos = strtoupper($apellidos);
        $periodo_Escolar = PeriodoEscolar::model()->getPeriodoActivo();
        $periodo_Escolar_id = $periodo_Escolar['id'];

        $periodo_Escolar_anterior_id = $periodo_Escolar_id - 1;
        $datosSeccion = SeccionPlantel::model()->obtenerDatosSeccion($seccion_plantel_id, $plantel_id);
        // $periodo_Escolar_id = null;
        //     $periodo_Escolar_id = 15;

        if ($whereinscrito) {

            $sql = "select e.nombres as nombre_estudiante, e.apellidos as apellido_estudiante,p.nombre as nombre_plantel,p.cod_estadistico as codigo_estadistico,
s.nombre as nombre_seccion, g.nombre as nombre_grado
from matricula.estudiante e
inner join matricula.inscripcion_estudiante ie on ie.estudiante_id=e.id
inner join gplantel.plantel p on p.id=e.plantel_actual_id
inner join gplantel.grado g on g.id=e.grado_actual_id
inner join gplantel.seccion_plantel_periodo spp on spp.id = ie.seccion_plantel_periodo_id
inner join gplantel.seccion_plantel sp on sp.id =spp.seccion_plantel_id
inner join gplantel.seccion s on sp.seccion_id = s.id
where $whereinscrito 
and spp.periodo_id=$periodo_Escolar_id
and e.plantel_actual_id=$plantel_id";


        $guard = Yii::app()->db->createCommand($sql);
        $buscarEstudiante = $guard->queryAll();
        
        if ($buscarEstudiante) {
                $verificacion = 1;

                return array($buscarEstudiante, $verificacion);
            } else {


                if ($periodo_Escolar_id != NULL) {
                    if ($busquedaCompleta == 0) {
                        if ($periodo_Escolar_id == 14) {

                            if (in_array($datosSeccion['id'], $gradosPrescolar)) {
                                $sql = "SELECT "
                                        . " DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
                me.id, p.nombre as plantel_nombre, p.cod_plantel, ih.grado_id"
                                        //  . " me.id, upper(me.nombres) || ' ' || upper(me.apellidos) as nom_completo, me.cedula_escolar, me.fecha_nacimiento, mr.cedula_identidad, 'no' as nuevoRegistro"
                                        . " FROM matricula.estudiante me "
                                        . " LEFT JOIN matricula.representante mr on me.representante_id = mr.id "
                                        . " INNER JOIN gplantel.plantel p on me.plantel_actual_id = p.id "
                                        . " INNER JOIN matricula.inscripcion_historico ih on me.sigue_id = ih.s_alumno_id "
                                        . " WHERE $where"
                                        . " AND ih.fperiodoescolar_id = $periodo_Escolar_anterior_id "
                                        . " AND me.plantel_actual_id = $plantel_id "
                                        . " AND ih.grado_id = 0 "
                                        . " AND me.id not in (select m_ie.estudiante_id from matricula.inscripcion_estudiante m_ie "
                                        . " inner join gplantel.seccion_plantel_periodo spp_i on (spp_i.id = m_ie.seccion_plantel_periodo_id) "
                                        . " where spp_i.periodo_id = $periodo_Escolar_id) ";
                                $guard = Yii::app()->db->createCommand($sql);

                                $buscarEstudiante = $guard->queryAll();

                                //   var_dump($buscarEstudiante);
                            } else {


                                $sql = "SELECT DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
                mr.nombres AS representante, me.representante_id,
                me.id, p.nombre as plantel_nombre, p.cod_plantel, ih.grado_id
                FROM matricula.estudiante me
                LEFT JOIN matricula.representante mr ON (me.representante_id = mr.id)
                INNER JOIN gplantel.plantel p ON (me.plantel_actual_id = p.id)
                INNER JOIN matricula.inscripcion_historico ih ON (me.sigue_id = ih.s_alumno_id)
                INNER JOIN gplantel.grado g ON (ih.grado_id = g.id)
                WHERE $where
                AND ih.fperiodoescolar_id = $periodo_Escolar_anterior_id
                AND me.id not in (
                SELECT m_ie.estudiante_id
                FROM matricula.inscripcion_estudiante m_ie
                INNER JOIN gplantel.seccion_plantel_periodo spp_i ON (spp_i.id = m_ie.seccion_plantel_periodo_id)
                WHERE spp_i.periodo_id = $periodo_Escolar_id)
                AND g.consecutivo = (SELECT DISTINCT (g_i.consecutivo-1)as consecutivo
                FROM gplantel.grado g_i
                INNER JOIN gplantel.seccion_plantel spl_i ON (spl_i.grado_id = g_i.id)
                WHERE spl_i.id = $seccion_plantel_id) LIMIT 1";

//                    $sql = "SELECT DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
//                                    me.id, p.nombre as plantel_nombre, p.cod_plantel
//                                    FROM matricula.estudiante me
//                                    LEFT JOIN matricula.representante mr ON (me.representante_id=mr.id)
//                                    INNER JOIN gplantel.plantel p ON (me.plantel_actual_id=p.id)
//                                    INNER JOIN matricula.inscripcion_historico ih ON (me.sigue_id=ih.s_alumno_id)
//                                    WHERE $where
//                                    AND ih.fperiodoescolar_id=$periodo_Escolar_anterior_id
//                                    AND me.id not in (
//                                                            SELECT m_ie.estudiante_id
//                                                            FROM matricula.inscripcion_estudiante m_ie
//                                                            INNER JOIN gplantel.seccion_plantel_periodo  spp_i ON (spp_i.id = m_ie.seccion_plantel_periodo_id)
//                                                            WHERE spp_i.periodo_id < $periodo_Escolar_id) ";

                                $guard = Yii::app()->db->createCommand($sql);

//                        die();
                                $buscarEstudiante = $guard->queryAll();
                            }
                        } else {

                            $sql = " SELECT  DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
                                        me.id, p.nombre as plantel_nombre, p.cod_plantel
                                        FROM matricula.estudiante me
                                        LEFT JOIN matricula.representante mr ON (me.representante_id=mr.id)
                                        INNER JOIN gplantel.plantel p ON (me.plantel_actual_id=p.id)
                                        INNER JOIN matricula.inscripcion_estudiante ie ON (ie.estudiante_id=me.id)
                                        INNER JOIN gplantel.seccion_plantel_periodo spp ON (ie.seccion_plantel_periodo_id=spp.id)
                                        INNER JOIN gplantel.grado g ON (me.grado_actual_id=g.id)
                                        WHERE $where
                                        AND g.consecutivo =
			(SELECT DISTINCT (g_i.consecutivo-1)as consecutivo
			FROM gplantel.grado g_i
			INNER JOIN  gplantel.seccion_plantel spl_i ON (spl_i.grado_id = g_i.id)
			WHERE spl_i.id = $seccion_plantel_id
			)
                                        AND spp.periodo_id < $periodo_Escolar_id";

                            $guard = Yii::app()->db->createCommand($sql);

                            $buscarEstudiante = $guard->queryAll();
                            // }
                        }

                        if ($buscarEstudiante == array()) {

                            $verificacion = 0;

                            return array(FALSE, $verificacion); // Retorna false cuando la busqueda no es encontrada
                        } else {
                            $verificacion = 0;

                            return array($buscarEstudiante, $verificacion); // Retorna un array con el resultado de la busqueda
                        }
                    } else {


                        if (in_array($datosSeccion['id'], $gradosPrescolar)) {
                            $sql = "SELECT "
                                    . " DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
                                    me.id, p.nombre as plantel_nombre, p.cod_plantel, ih.grado_id"
                                    //  . " me.id, upper(me.nombres) || ' ' || upper(me.apellidos) as nom_completo, me.cedula_escolar, me.fecha_nacimiento , mr.cedula_identidad, 'no' as nuevoRegistro"
                                    . " FROM matricula.estudiante me "
                                    . " LEFT JOIN matricula.representante mr on me.representante_id=mr.id "
                                    . " INNER JOIN gplantel.plantel p on me.plantel_actual_id=p.id "
                                    . " INNER JOIN matricula.inscripcion_historico ih on me.sigue_id=ih.s_alumno_id "
                                    . " WHERE $where"
                                    . " AND ih.fperiodoescolar_id=$periodo_Escolar_anterior_id "
                                    . " AND me.plantel_actual_id = $plantel_id "
                                    . " AND ih.grado_id = 0 "
                                    . " AND me.id not in (select m_ie.estudiante_id from matricula.inscripcion_estudiante m_ie "
                                    . " inner join gplantel.seccion_plantel_periodo  spp_i on (spp_i.id = m_ie.seccion_plantel_periodo_id) "
                                    . " where spp_i.periodo_id = $periodo_Escolar_id) ";

                            $guard = Yii::app()->db->createCommand($sql);
                            $buscarEstudiante = $guard->queryAll();
                            //   var_dump($buscarEstudiante);
                        } else {

                            $sql = "SELECT  DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
                                    me.id, p.nombre AS plantel_nombre, p.cod_plantel
                                    FROM matricula.estudiante me
                                    LEFT JOIN matricula.representante mr ON (me.representante_id=mr.id)
                                    LEFT JOIN gplantel.plantel p ON (me.plantel_actual_id=p.id)
                                    LEFT JOIN legacy.talumno_acad taa ON (me.sigue_id=taa.s_alumno_id)
                                    INNER JOIN gplantel.grado g ON (me.grado_actual_id=g.id)
                                    WHERE $where
                                    AND taa.fperiodoescolar <> '$periodo_Escolar_id'
                                    AND me.id NOT IN (
                                                            SELECT m_ie.estudiante_id
                                                            FROM matricula.inscripcion_estudiante m_ie
                                                            INNER JOIN gplantel.seccion_plantel_periodo  spp_i ON (spp_i.id = m_ie.seccion_plantel_periodo_id)
                                                            WHERE spp_i.periodo_id=$periodo_Escolar_id)
                                   AND g.consecutivo =
			(SELECT DISTINCT (g_i.consecutivo-1)as consecutivo
			FROM gplantel.grado g_i
			INNER JOIN  gplantel.seccion_plantel spl_i ON (spl_i.grado_id = g_i.id)
			WHERE spl_i.id = $seccion_plantel_id
			) ";
                            $guard = Yii::app()->db->createCommand($sql);

                            $buscarEstudiante = $guard->queryAll();
                        }

                        if ($buscarEstudiante == array()) {
                            $verificacion = 0;

                            return array(false, $verificacion);
                            // Retorna false cuando la busqueda no es encontrada
                        } else {
                            $verificacion = 0;

                            return array($buscarEstudiante, $verificacion);
// Retorna un array con el resultado de la busqueda
                        }
                    }
                } else {
                    return '1'; // Retorna 1 si la variable sesión esta resultando nulo
                }
            }
        } else {


            if ($periodo_Escolar_id != NULL) {
            if ($busquedaCompleta == 0) {
                if ($periodo_Escolar_id == 14) {

                    if (in_array($datosSeccion['id'], $gradosPrescolar)) {
                        $sql = "SELECT "
                                . " DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
                me.id, p.nombre as plantel_nombre, p.cod_plantel, ih.grado_id"
                                //  . " me.id, upper(me.nombres) || ' ' || upper(me.apellidos) as nom_completo, me.cedula_escolar, me.fecha_nacimiento, mr.cedula_identidad, 'no' as nuevoRegistro"
                                . " FROM matricula.estudiante me "
                                . " LEFT JOIN matricula.representante mr on me.representante_id = mr.id "
                                . " INNER JOIN gplantel.plantel p on me.plantel_actual_id = p.id "
                                . " INNER JOIN matricula.inscripcion_historico ih on me.sigue_id = ih.s_alumno_id "
                                . " WHERE $where"
                                . " AND ih.fperiodoescolar_id = $periodo_Escolar_anterior_id "
                                . " AND me.plantel_actual_id = $plantel_id "
                                . " AND ih.grado_id = 0 "
                                . " AND me.id not in (select m_ie.estudiante_id from matricula.inscripcion_estudiante m_ie "
                                . " inner join gplantel.seccion_plantel_periodo spp_i on (spp_i.id = m_ie.seccion_plantel_periodo_id) "
                                . " where spp_i.periodo_id = $periodo_Escolar_id) ";
                        $guard = Yii::app()->db->createCommand($sql);

                        $buscarEstudiante = $guard->queryAll();

                        //   var_dump($buscarEstudiante);
                    } else {


                        $sql = "SELECT DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
                mr.nombres AS representante, me.representante_id,
                me.id, p.nombre as plantel_nombre, p.cod_plantel, ih.grado_id
                FROM matricula.estudiante me
                LEFT JOIN matricula.representante mr ON (me.representante_id = mr.id)
                INNER JOIN gplantel.plantel p ON (me.plantel_actual_id = p.id)
                INNER JOIN matricula.inscripcion_historico ih ON (me.sigue_id = ih.s_alumno_id)
                INNER JOIN gplantel.grado g ON (ih.grado_id = g.id)
                WHERE $where
                AND ih.fperiodoescolar_id = $periodo_Escolar_anterior_id
                AND me.id not in (
                SELECT m_ie.estudiante_id
                FROM matricula.inscripcion_estudiante m_ie
                INNER JOIN gplantel.seccion_plantel_periodo spp_i ON (spp_i.id = m_ie.seccion_plantel_periodo_id)
                WHERE spp_i.periodo_id = $periodo_Escolar_id)
                AND g.consecutivo = (SELECT DISTINCT (g_i.consecutivo-1)as consecutivo
                FROM gplantel.grado g_i
                INNER JOIN gplantel.seccion_plantel spl_i ON (spl_i.grado_id = g_i.id)
                WHERE spl_i.id = $seccion_plantel_id) LIMIT 1";

//                    $sql = "SELECT DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
//                                    me.id, p.nombre as plantel_nombre, p.cod_plantel
//                                    FROM matricula.estudiante me
//                                    LEFT JOIN matricula.representante mr ON (me.representante_id=mr.id)
//                                    INNER JOIN gplantel.plantel p ON (me.plantel_actual_id=p.id)
//                                    INNER JOIN matricula.inscripcion_historico ih ON (me.sigue_id=ih.s_alumno_id)
//                                    WHERE $where
//                                    AND ih.fperiodoescolar_id=$periodo_Escolar_anterior_id
//                                    AND me.id not in (
//                                                            SELECT m_ie.estudiante_id
//                                                            FROM matricula.inscripcion_estudiante m_ie
//                                                            INNER JOIN gplantel.seccion_plantel_periodo  spp_i ON (spp_i.id = m_ie.seccion_plantel_periodo_id)
//                                                            WHERE spp_i.periodo_id < $periodo_Escolar_id) ";

                        $guard = Yii::app()->db->createCommand($sql);

//                        die();
                        $buscarEstudiante = $guard->queryAll();
                    }
                } else {

                    $sql = " SELECT  DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
                                        me.id, p.nombre as plantel_nombre, p.cod_plantel
                                        FROM matricula.estudiante me
                                        LEFT JOIN matricula.representante mr ON (me.representante_id=mr.id)
                                        INNER JOIN gplantel.plantel p ON (me.plantel_actual_id=p.id)
                                        INNER JOIN matricula.inscripcion_estudiante ie ON (ie.estudiante_id=me.id)
                                        INNER JOIN gplantel.seccion_plantel_periodo spp ON (ie.seccion_plantel_periodo_id=spp.id)
                                        INNER JOIN gplantel.grado g ON (me.grado_actual_id=g.id)
                                        WHERE $where
                                        AND g.consecutivo =
			(SELECT DISTINCT (g_i.consecutivo-1)as consecutivo
			FROM gplantel.grado g_i
			INNER JOIN  gplantel.seccion_plantel spl_i ON (spl_i.grado_id = g_i.id)
			WHERE spl_i.id = $seccion_plantel_id
			)
                                        AND spp.periodo_id < $periodo_Escolar_id";

                    $guard = Yii::app()->db->createCommand($sql);

                    $buscarEstudiante = $guard->queryAll();
                    // }
                }

                if ($buscarEstudiante == array()) {

                        $verificacion = 0;

                        return array(false, $verificacion);
                        return false; // Retorna false cuando la busqueda no es encontrada
                    } else {
                        $verificacion = 0;

                        return array($buscarEstudiante, $verificacion);
                        // Retorna un array con el resultado de la busqueda
                    }
                } else {


                if (in_array($datosSeccion['id'], $gradosPrescolar)) {
                    $sql = "SELECT "
                            . " DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
                                    me.id, p.nombre as plantel_nombre, p.cod_plantel, ih.grado_id"
                            //  . " me.id, upper(me.nombres) || ' ' || upper(me.apellidos) as nom_completo, me.cedula_escolar, me.fecha_nacimiento , mr.cedula_identidad, 'no' as nuevoRegistro"
                            . " FROM matricula.estudiante me "
                            . " LEFT JOIN matricula.representante mr on me.representante_id=mr.id "
                            . " INNER JOIN gplantel.plantel p on me.plantel_actual_id=p.id "
                            . " INNER JOIN matricula.inscripcion_historico ih on me.sigue_id=ih.s_alumno_id "
                            . " WHERE $where"
                            . " AND ih.fperiodoescolar_id=$periodo_Escolar_anterior_id "
                            . " AND me.plantel_actual_id = $plantel_id "
                            . " AND ih.grado_id = 0 "
                            . " AND me.id not in (select m_ie.estudiante_id from matricula.inscripcion_estudiante m_ie "
                            . " inner join gplantel.seccion_plantel_periodo  spp_i on (spp_i.id = m_ie.seccion_plantel_periodo_id) "
                            . " where spp_i.periodo_id = $periodo_Escolar_id) ";

                    $guard = Yii::app()->db->createCommand($sql);
                    $buscarEstudiante = $guard->queryAll();
                    //   var_dump($buscarEstudiante);
                } else {

                    $sql = "SELECT  DISTINCT me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
                                    me.id, p.nombre AS plantel_nombre, p.cod_plantel
                                    FROM matricula.estudiante me
                                    LEFT JOIN matricula.representante mr ON (me.representante_id=mr.id)
                                    LEFT JOIN gplantel.plantel p ON (me.plantel_actual_id=p.id)
                                    LEFT JOIN legacy.talumno_acad taa ON (me.sigue_id=taa.s_alumno_id)
                                    INNER JOIN gplantel.grado g ON (me.grado_actual_id=g.id)
                                    WHERE $where
                                    AND taa.fperiodoescolar <> '$periodo_Escolar_id'
                                    AND me.id NOT IN (
                                                            SELECT m_ie.estudiante_id
                                                            FROM matricula.inscripcion_estudiante m_ie
                                                            INNER JOIN gplantel.seccion_plantel_periodo  spp_i ON (spp_i.id = m_ie.seccion_plantel_periodo_id)
                                                            WHERE spp_i.periodo_id=$periodo_Escolar_id)
                                   AND g.consecutivo =
			(SELECT DISTINCT (g_i.consecutivo-1)as consecutivo
			FROM gplantel.grado g_i
			INNER JOIN  gplantel.seccion_plantel spl_i ON (spl_i.grado_id = g_i.id)
			WHERE spl_i.id = $seccion_plantel_id
			) ";
                    $guard = Yii::app()->db->createCommand($sql);

                    $buscarEstudiante = $guard->queryAll();
                }

                if ($buscarEstudiante == array()) {
                        $verificacion = 0;

                        return array(false, $verificacion);
                        // Retorna false cuando la busqueda no es encontrada
                    } else {
                        $verificacion = 0;

                        return array($buscarEstudiante, $verificacion);
                        // Retorna un array con el resultado de la busqueda
                    }
                }
        } else {
            return '1'; // Retorna 1 si la variable sesión esta resultando nulo
        }
        }
    }

    /* --------------------------------- FIN------------------------------ */

    /**
     * Funcion que busca al estudiante mediante la Cédula de Identidad.
     *
     * @author Meylin Guillén
     * @param string $origen Indica la nacionalidad ingresada con la CI desde un formulario (V ó E)
     * @param int $cedula Numero de Cédula obtenido desde el controlador
     *
     */
    public function busquedaSaime($origen, $cedula) {
        $cedulaInt = $cedula;
        $sql = "SELECT cedula, (primer_nombre || ' ' || segundo_nombre) AS nombre, (primer_apellido || ' ' || segundo_apellido) AS apellido , fecha_nacimiento AS fecha "
                . " FROM auditoria.saime s"
                . " WHERE "
                . " s.cedula= :cedula AND "
                . " s.origen= :origen ";

        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":cedula", $cedulaInt, PDO::PARAM_INT);
        $buqueda->bindParam(":origen", $origen, PDO::PARAM_INT);
        $resultadoCedula = $buqueda->queryRow();

        if ($resultadoCedula !== array()) {
            return $resultadoCedula;
        } else {
            return false;
        }
    }

    //-------------------------------------------------------------------fin

    public function buscarEstudianteNuevo($cedula) {
        $sql = "SELECT *
                     FROM matricula.estudiante e
                     WHERE
                     e.cedula_identidad=:cedula";
        $select = Yii::app()->db->createCommand($sql);
        $select->bindParam(":cedula", $cedula, PDO:: PARAM_INT);
        $resultado = $select->queryAll();
        return ($resultado);
    }

    public function datosEstudianteInscrito($id) {
        $sql = "SELECT *
                     FROM matricula.estudiante e
                     WHERE
                     e.id=:id";
        $select = Yii::app()->db->createCommand($sql);
        $select->bindParam(":id", $id, PDO:: PARAM_INT);
        $resultado = $select->queryAll();
        return $resultado;
    }

    /**
     * Funcion que busca al estudiante que se intenta registrar sin cédula de identidad, llamando a una funcion sql.
     * Busca los siguientes casos:
     * 1- Si el representante tiene a un estudiante relacionado con la misma fecha de nacimiento y el mismo nombre y apellido.
     * 2- Si la cedula escolar asociada a ese estudiante ya esta registrada
     * 3- Si no existe ninguna coincidencia (Caso exitoso que permite el registro)
     *
     * @author Meylin Guillén
     * @param modelo $mEstudiante Modelo Estudiante cargado desde el controlador, tomando los atributos : cedula_escolar, nombres, apellidos, representante_id, fecha_nacimiento.
     *
     */
    public function validarEstudiante($mEstudiante) {
        $cedula_escolar = $mEstudiante['cedula_escolar'];
        $nombres = $mEstudiante['nombres'];
        $apellidos = $mEstudiante['apellidos'];
        $representante_id = $mEstudiante['representante_id'];
        $fecha_nacimiento = $mEstudiante['fecha_nacimiento'];

        $sql = "SELECT
            matricula.existe_estudiante(
            :cedula_escolar,
            :nombres ,
            :apellidos ,
            :representante,
            :fecha_nacimiento
            ) AS existe;";
        $select = Yii::app()->db->createCommand($sql);
        $select->bindParam(":cedula_escolar", $cedula_escolar, PDO:: PARAM_INT);
        $select->bindParam(":nombres", $nombres, PDO:: PARAM_STR);
        $select->bindParam(":apellidos", $apellidos, PDO:: PARAM_STR);
        $select->bindParam(":representante", $representante_id, PDO:: PARAM_INT);
        $select->bindParam(":fecha_nacimiento", $fecha_nacimiento, PDO:: PARAM_INT);

        $resultado = $select->queryAll();
        return ($resultado);
    }

    public function inscribirEstudiantes($estudiantes, $plantel_id, $seccion_plantel_id, $periodo, $modulo, $inscripcion_regular = '{0}', $doble_inscripcion = '{0}', $repitiente_completo = '{0}', $materia_pendiente = '{0}', $observacion = '{NULL}') {
        $usuario_id = Yii::app()->user->id;
        $username = Yii::app()->user->name;
        $ip = Utiles::getRealIP();
        $sql = "SELECT matricula.inscribir_estudiantes(:estudiantes, :seccion_plantel_id, :plantel_id, :periodo_id, :usuario_id, :direccion_ip, :username, :modulo, :inscripcion_regular, :doble_inscripcion, :repitiente_completo, :materia_pendiente, :observacion)";

        $inscripcionEstudiante = Yii::app()->db->createCommand($sql);
        $inscripcionEstudiante->bindParam(":estudiantes", $estudiantes, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":seccion_plantel_id", $seccion_plantel_id, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":periodo_id", $periodo, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":direccion_ip", $ip, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":username", $username, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":modulo", $modulo, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":inscripcion_regular", $inscripcion_regular, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":doble_inscripcion", $doble_inscripcion, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":repitiente_completo", $repitiente_completo, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":materia_pendiente", $materia_pendiente, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":observacion", $observacion, PDO::PARAM_INT);

        $resultado = $inscripcionEstudiante->execute();
        
    }

    public function inscribirEstudiante($estudiantes, $plantel_id, $seccion_plantel_id, $periodo, $modulo, $inscripcion_regular, $doble_inscripcion, $repitiente = '{0}', $observacion = '') {
        $usuario_id = Yii::app()->user->id;
        $username = Yii::app()->user->name;
        $ip = Utiles::getRealIP();
//        var_dump($estudiantes, $seccion_plantel_id, $plantel_id, $periodo, $usuario_id, $ip, $username, $modulo, $observacion, $inscripcion_regular, $doble_inscripcion);
//        die();
        $sql = "SELECT matricula.inscribir_estudiante(:estudiantes, :seccion_plantel_id, :plantel_id, :periodo_id, :usuario_id, :direccion_ip, :username, :modulo,:observacion, :inscripcion_regular, :doble_inscripcion, :repitiente)";

        $inscripcionEstudiante = Yii::app()->db->createCommand($sql);
        $inscripcionEstudiante->bindParam(":estudiantes", $estudiantes, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":seccion_plantel_id", $seccion_plantel_id, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":periodo_id", $periodo, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":direccion_ip", $ip, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":username", $username, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":modulo", $modulo, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":inscripcion_regular", $inscripcion_regular, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":doble_inscripcion", $doble_inscripcion, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":repitiente", $repitiente, PDO::PARAM_INT);
        $inscripcionEstudiante->bindParam(":observacion", $observacion, PDO::PARAM_INT);

        $resultado = $inscripcionEstudiante->execute();
    }

    /**
     * Permite obtener los datos básicos de un estudiante.
     * Si el estudiante no existe  o si el valor del parametro que recibe no es numerico RETORNA NULL
     * @author Ignacio Salazar
     * @param integer $estudiante_id ID del estudiante
     * @return array  Retorna un arreglo con los siguientes indices (nombres, apellidos, fecha_nacimiento, grado_actual, grado_actual_id, cedula_identidad, cedula_escolar)
     */
    public function getDatosEstudiante($estudiante_id) {
        $resultado = null;
        if (is_numeric($estudiante_id)) {
            $sql = "    SELECT "
                    . "     upper(me.nombres) nombres,"
                    . "     upper(me.apellidos) apellidos,"
                    . "     me.fecha_nacimiento, "
                    . "     g.nombre grado_actual, "
                    . "     g.id grado_actual_id, "
                    . "     me.cedula_identidad, "
                    . "     me.cedula_escolar,"
                    . "     p.nombre plantel_actual"
                    . " FROM"
                    . "     matricula.estudiante me"
                    . " LEFT JOIN gplantel.grado g on (g.id = me.grado_actual_id)"
                    . " LEFT JOIN gplantel.plantel p on (p.id = me.plantel_actual_id)"
                    . " WHERE "
                    . "     me.id = :estudiante_id"
                    . " ORDER BY me.cedula_identidad ASC";
            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":estudiante_id", $estudiante_id, PDO:: PARAM_INT);

            $resultado = $busqueda->queryRow();
            if ($resultado == array())
                $resultado = null;
        }

        return ($resultado);
    }

    /*     * ********************************************** */

    //
    //SELECT  me.cedula_escolar, me.cedula_identidad, me.nombres, me.apellidos,
    //mr.nombres as representante,me.representante_id,mr.id
    //
        //  FROM matricula.estudiante me
    // INNER JOIN matricula.representante mr on me.representante_id=mr.id
    // where me.cedula_escolar=22 or me.cedula_identidad = null or mr.cedula_identidad=null or
    // me.nombres ilike '%null%' or me.apellidos ilike '%null%';


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    public function verificacionInscrito($cedula_escolar = '', $cedula_identidad = '', $nombres = '', $apellidos = '', $cirepresentante = '', $busquedaCompleta, $seccion_plantel_id, $plantel_id) {
        $where = '';
        if ($cedula_escolar !== '') {

            $where = "me.cedula_escolar=$cedula_escolar ";
        }

        if ($cedula_identidad !== '') {
            if ($where !== '') {
                $where .= " and me.cedula_identidad=$cedula_identidad";
            } else {
                $where = " me.cedula_identidad=$cedula_identidad";
            }
        }

        if ($nombres !== '' && $apellidos !== '') {
            $nombres = trim($nombres);
            $apellidos = trim($apellidos);
            $apellido1 = '';
            $apellido2 = '';
            $apellido3 = '';
            $nombre1 = '';
            $nombre2 = '';
            $nombre3 = '';

            // list($apellido1, $apellido2, $apellido3) = explode(" ", $apellidos);
            $apellidos_exploded = explode(" ", $apellidos);
            $apellido1 = isset($apellidos_exploded[0]) ? $apellidos_exploded[0] : '';
            $apellido2 = isset($apellidos_exploded[1]) ? $apellidos_exploded[1] : '';
            $apellido3 = isset($apellidos_exploded[2]) ? $apellidos_exploded[2] : '';
            // list($nombre1, $nombre2, $nombre3) = explode(" ", $nombres);
            $nombres_exploded = explode(" ", $nombres);
            $nombre1 = isset($nombres_exploded[0]) ? $nombres_exploded[0] : '';
            $nombre2 = isset($nombres_exploded[1]) ? $nombres_exploded[1] : '';
            $nombre3 = isset($nombres_exploded[2]) ? $nombres_exploded[2] : '';
            if ($where !== '') {

                $where .= " and busqueda @@ plainto_tsquery('pg_catalog.spanish', '" . "$nombre1 " . " $nombre2" . " $nombre3" . " $apellido1" . " $apellido2" . " $apellido3" . "')";
//                $where .= ' and busqueda @@ TO_tsquery(' . "'" . '"pg_catalog.spanish"' . "," . '"' . $nombre1 . '" & "' . $nombre2 . '" & "' . $nombre3 . '" & "' . $apellido1 . '" & "' . $apellido2 . '" & "' . $apellido3 . '"' . "'" . ')';
            } else {


                $where .= " busqueda @@ plainto_tsquery('pg_catalog.spanish', '" . "$nombre1 " . " $nombre2" . " $nombre3" . " $apellido1" . " $apellido2" . " $apellido3" . "')";
//                $where .= ' busqueda @@ TO_tsquery(' . "'" . '"pg_catalog.spanish"' . "," . '"' . $nombre1 . '" & "' . $nombre2 . '" & "' . $nombre3 . '" & "' . $apellido1 . '" & "' . $apellido2 . '" & "' . $apellido3 . '"' . "'" . ')';
                //    $where = " me.nombres like '$nombres%'";
            }
        }
//pg_catalog.spanish

        if ($cirepresentante !== '') {
            if ($where !== '') {
                $where .= " and mr.cedula_identidad = $cirepresentante ";
            } else {
                $where = " mr.cedula_identidad = $cirepresentante";
            }
        }

        $gradosPrescolar [] = 3;
        $gradosPrescolar [] = 4;
        $gradosPrescolar [] = 7;
        $gradosPrescolar [] = 8;
        $gradosPrescolar [] = 11;
        $gradosPrescolar [] = 12;
        $nombres = strtoupper($nombres);
        $apellidos = strtoupper($apellidos);
        $periodo_Escolar = PeriodoEscolar::model()->getPeriodoActivo();
        $periodo_Escolar_id = $periodo_Escolar['id'];

        $sql = "";


        $guard = Yii::app()->db->createCommand($sql);
        $buscarEstudiante = $guard->queryAll();
    }
    /**
     * Eliminación Lógica de un Estudiante.
     * 
     * @param integer $id
     * @param string $accion 'A'=Activar, 'E'=Inactivar
     * @param integer $inscripcion_id 
     */
    public function cambiarEstatusEstudiante($id, $accion, $inscripcion_id) {

        $result = new stdClass();
        $result->isSuccess = false;
        $result->message = 'No existe el Estudiante Indicado.';
        $nombres = '';
        $apellidos = '';

        if (in_array($accion, array('E', 'A'))) {

            if (is_numeric($id)) {

                $estudiante = $this->findByPk($id);

                if ($estudiante) {
                    $result->message = 'Ha ocurrido un error en el Proceso.';
                    $estudiante->estatus_id = 4; // ASIGNADO
                    $estudiante->usuario_act_id = Yii::app()->user->id;
                    $estudiante->grado_actual_id = $estudiante->grado_anterior_id;

                    if ($accion == 'E') {
                        $estudiante->fecha_elim = date('Y-m-d H:i:s');
                    }

                    if ($estudiante->update()) {

                        $asignatura_estudiante = AsignaturaEstudiante::model()->inactivarAsignaturaEstudiante($inscripcion_id);
                        if ($asignatura_estudiante != null) {
                            $inscripcion_estudiante = InscripcionEstudiante::model()->inactivarInscripcionEstudiante($inscripcion_id);
                            if ($inscripcion_estudiante) {
                                $messageUsers = 'El Estudiante ha sido ' . strtr($accion, array('A' => 'incluido.', 'E' => 'excluido.'));
                                $result->isSuccess = true;
                                $nombres = (isset($estudiante->nombres) AND $estudiante->nombres != '') ? $estudiante->nombres : '';
                                $apellidos = (isset($estudiante->apellidos) AND $estudiante->apellidos != '') ? $estudiante->apellidos : '';
                                $result->message = 'Se ha ' . strtr($accion, array('A' => 'incluido', 'E' => 'excluido')) . ' el Estudiante ' . $nombres . ' ' . $apellidos;
                            }
                        }
                    }
                }
            }
        } else {
            $result->message = 'No se ha especificado la acción a tomar sobre el Estudiante, recargue la página e intentelo de nuevo.';
        }

        return $result;
    }

    public function estudiantesMatriculadosSeccion($seccionId) {
        $estatus = 'A';
        $estatus_id = 1; // MATRICULADO
        $resultado = null;
//        $sql = "SELECT  e.id,e.cedula_identidad, e.cedula_escolar, e.fecha_nacimiento, e.nombres || ' ' || e.apellidos as nomApe, ie.estatus, ie.id as inscripcion_id"
//                . " FROM"
//                . " gplantel.seccion_plantel sp"
//                . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.seccion_plantel_id = sp.id)"
//                . " INNER JOIN matricula.inscripcion_estudiante ie on (spp.id = ie.seccion_plantel_periodo_id)"
//                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
//                . " LEFT JOIN matricula.representante r on (r.id = e.representante_id)"
//                . " WHERE spp.seccion_plantel_id = :seccion_plantel_id"
//                . " AND ie.estatus= :estatus"
//                . " ORDER BY ie.id DESC";
        if (is_numeric($seccionId)) {
            $sql = "    SELECT "
                    . " me.nacionalidad,"
                    . " me.cedula_identidad, "
                    . " me.cedula_escolar, "
                    . " me.nombres, "
                    . " me.apellidos, "
                    . " me.fecha_nacimiento, "
                    . " me.sexo, "
                    . " mie.inscripcion_regular,"
                    . " mie.materia_pendiente,"
                    . " mie.repitiente,"
                    . " mie.doble_inscripcion,"
                    . " mie.observacion"
                    . " FROM matricula.estudiante me"
                    . " INNER JOIN matricula.inscripcion_estudiante mie ON (me.id = mie.estudiante_id)"
                    . " INNER JOIN gplantel.seccion_plantel_periodo spp_i on (spp_i.id = mie.seccion_plantel_periodo_id)"
                    . " INNER JOIN gplantel.seccion_plantel spl on (spl.id = spp_i.seccion_plantel_id)"
                    . " WHERE spl.id = :seccion_plantel_id AND mie.estatus = :estatus AND me.estatus_id = :estatus_id"
                    . " ORDER BY me.cedula_identidad ASC ";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":seccion_plantel_id", $seccionId, PDO::PARAM_INT);
            $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $buqueda->bindParam(":estatus_id", $estatus_id, PDO::PARAM_STR);
            $resultado = $buqueda->queryAll();
        }

        return $resultado;

    }

}

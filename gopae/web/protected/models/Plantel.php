<?php

/**
 * This is the model class for table "gplantel.plantel".
 *
 * The followings are the available columns in table 'gplantel.plantel':
 * @property string $id
 * @property bigint $cod_estadistico
 * @property string $cod_plantel
 * @property integer $planta_fisica_id
 * @property string $nombre
 * @property integer $denominacion_id
 * @property integer $tipo_dependencia_id
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $parroquia_id
 * @property integer $localidad_id
 * @property integer $poblacion_id
 * @property integer $urbanizacion_id
 * @property integer $tipo_via_id
 * @property integer $via
 * @property string $direccion
 * @property integer $distrito_id
 * @property integer $zona_educativa_id
 * @property integer $modalidad_id
 * @property integer $nivel_id
 * @property integer $condicion_estudio_id
 * @property string $correo
 * @property string $telefono_fijo
 * @property string $telefono_otro
 * @property integer $director_actual_id
 * @property integer $director_supl_actual_id
 * @property integer $subdirector_actual_id
 * @property integer $subdirector_supl_actual_id
 * @property integer $coordinador_actual_id
 * @property integer $coordinador_supl_actual_id
 * @property integer $clase_plantel_id
 * @property integer $condicion_infra_id
 * @property integer $categoria_id
 * @property boolean $posee_electricidad
 * @property boolean $posee_edificacion
 * @property string $logo
 * @property string $observacion
 * @property boolean $es_tecnica
 * @property integer $especialidad_tec_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $estatus_plantel_id
 * @property double $latitud
 * @property double $longitud
 * @property integer $annio_fundado
 * @property integer $turno_id
 * @property integer $genero_id
 * @property integer $zona_ubicacion_id
 * @property string $nfax
 * @property string $codigo_ner
 * @property string $cod_plantelNer  // NO ELIMINAR (IGNACIO)
 * @property string $cod_cnae
 * @property string $registro_cnae
 * @property string $sin_codigo_dea
 * @property string $es_beneficiario_pae
 * @property integer $otras_sedes
 * @property string $posee_cbit
 * @property string $cbit_con_internet
 * @property string $consejo_comunal
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $coordinadorActual
 * @property Categoria $categoria
 * @property ClasePlantel $clasePlantel
 * @property CondicionEstudio $condicionEstudio
 * @property CondicionInfraestructura $condicionInfra
 * @property Denominacion $denominacion
 * @property UsergroupsUser $directorActual
 * @property Distrito $distrito
 * @property EspecialidadTecnica $especialidadTec
 * @property Estado $estado
 * @property EstatusPlantel $estatusPlantel
 * @property Localidad $localidad
 * @property Modalidad $modalidad
 * @property Municipio $municipio
 * @property Nivel $nivel
 * @property PlantaFisica $plantaFisica
 * @property Parroquia $parroquia
 * @property TipoDependencia $tipoDependencia
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property ZonaEducativa $zonaEducativa
 * @property ZonaUbicacion $zonaUbicacion
 * @property Turno $turno
 * @property UsergroupsUser $subdirectorActual
 * @property ProyectosEndogenosPlantel[] $proyectosEndogenosPlantels
 * @property AutoridadPlantel[] $autoridadPlantels
 * @property NivelPlantel[] $nivelPlantels
 * @property TurnoPlantel[] $turnoPlantels
 * @property ServicioPlantel[] $servicioPlantels
 * @property DependenciaNominalPlantel[] $dependenciaNominalPlantels
 */
class Plantel extends CActiveRecord {

    public $cod_plantelNer; // NO ELIMINAR (IGNACIO)
    
    public $matricula_simoncito;
    
    public $matricula_general;
    
    public $pae_activo;
    
    public $tiene_director_registrado;

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'gplantel.plantel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.zona_ubicacion_id

        return array(
            array('cod_estadistico, planta_fisica_id, denominacion_id, tipo_dependencia_id, estado_id, municipio_id, parroquia_id, localidad_id, zona_educativa_id, modalidad_id, nivel_id, condicion_estudio_id, director_actual_id, director_supl_actual_id, subdirector_actual_id, subdirector_supl_actual_id, coordinador_actual_id, coordinador_supl_actual_id, clase_plantel_id, condicion_infra_id, categoria_id, especialidad_tec_id, usuario_ini_id, usuario_act_id, estatus_plantel_id, annio_fundado, turno_id, genero_id, zona_ubicacion_id', 'numerical', 'integerOnly' => true),
            //faltata distrito_id arriba ^
            /* VALIDACIONES DE REGISTRAR PLANTEL */
            array('direccion, nombre, genero_id, correo, telefono_fijo, telefono_otro, latitud, longitud, cod_estadistico, denominacion_id, tipo_dependencia_id, estado_id, municipio_id, zona_educativa_id, condicion_estudio_id, clase_plantel_id, categoria_id,  estatus_plantel_id, annio_fundado, turno_id, zona_ubicacion_id, nfax, cod_plantelNer, codigo_ner ,parroquia_id', 'required', 'message' => 'El campo {attribute} no debe estar vacio', 'on' => 'crearDatosGeneralesNer'),
            array('direccion, nombre, genero_id, correo, telefono_fijo, telefono_otro, latitud, longitud, cod_estadistico, denominacion_id, tipo_dependencia_id, estado_id, municipio_id, zona_educativa_id, condicion_estudio_id, clase_plantel_id, categoria_id,  estatus_plantel_id, annio_fundado, turno_id, zona_ubicacion_id, nfax, cod_plantel, parroquia_id', 'required', 'message' => 'El campo {attribute} no debe estar vacio', 'on' => 'crearDatosGeneralesSNer'),
            // falta distrito_id, localidad_id arriba ^
            // array('cod_estadistico, annio_fundado, latitud, longitud', 'match', 'pattern' => '/^([0-9].)+$/', 'message' => 'Por Favor Introduzca los datos correctos, solo puede contener números.'),
            array('cod_plantel', 'length', 'max' => 16),
            array('cod_plantel', 'length', 'min' => 4),
            array('codigo_ner', 'length', 'max' => 16),
            array('cod_cnae', 'length', 'max' => 16),
            array('nombre', 'length', 'max' => 150),
            array('correo', 'length', 'max' => 100),
            array('annio_fundado', 'length', 'max' => 4),
            array('logo', 'length', 'max' => 255),
            array('estatus, sin_codigo_dea, registro_cnae', 'length', 'max' => 1),
            array('nfax', 'length', 'max' => 17),
            array('codigo_ner', 'length', 'max' => 15),
            array('telefono_fijo, telefono_otro', 'length', 'max' => 11),
            array('denominacion_id', 'length', 'max' => 7),
            array('zona_educativa_id', 'length', 'max' => 7),
            array('tipo_dependencia_id', 'length', 'max' => 7),
            array('distrito_id', 'length', 'max' => 7),
            array('estatus_plantel_id', 'length', 'max' => 7),
            array('estado_id', 'length', 'max' => 7),
            array('municipio_id', 'length', 'max' => 7),
            array('parroquia_id', 'length', 'max' => 7),
            /* ALEXIS Agregue  variables :P */
            array('poblacion_id', 'length', 'max' => 7),
            array('urbanizacion_id', 'length', 'max' => 7),
            array('via', 'length', 'max' => 160),
            array('consejo_comunal', 'length', 'max'=>255),
            array('tipo_via_id', 'length', 'max' => 7),
            /*             * ***************************************** */
            array('zona_ubicacion_id', 'length', 'max' => 7),
            array('clase_plantel_id', 'length', 'max' => 7),
            array('categoria_id', 'length', 'max' => 7),
            array('condicion_estudio_id', 'length', 'max' => 7),
            array('genero_id', 'length', 'max' => 7),
            array('turno_id', 'length', 'max' => 7),
            array('modalidad_id', 'length', 'max' => 7),
            array('nombre', 'length', 'min' => 4),
            array('otras_sedes', 'numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>20),
            //  array('nombre, direccion', 'match', 'pattern' => '/^([^a-zA-Z0-9])+$/', 'message' => 'Por Favor Introduzca los datos correctos, El campo {attribute} solo puede contener números y letras.'),
            array('cod_estadistico, cod_plantel', 'unique', 'message' => 'El campo {attribute} ya existe'),
            array('correo', 'email'),
            array('direccion, posee_electricidad, posee_edificacion, observacion, es_tecnica, fecha_ini, fecha_act, fecha_elim', 'safe'),
            array('es_beneficiario_pae, posee_cbit, cbit_con_internet', 'length', 'max' => 2, 'min'=> 2),
            array('es_beneficiario_pae, posee_cbit, cbit_con_internet', 'in', 'range'=>array('','SI', 'NO'),),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('nombre, denominacion_id, zona_educativa_id, tipo_dependencia_id, estado_id, municipio_id, parroquia_id, direccion, telefono_fijo, turno_id, genero_id, otras_sedes, consejo_comunal, es_beneficiario_pae', 'required', 'message' => 'El campo {attribute} no debe estar vacio', 'on' => 'createFromCnae' ),
            array('id, cod_estadistico, cod_plantel, planta_fisica_id, nombre, denominacion_id, tipo_dependencia_id, estado_id, municipio_id, parroquia_id, localidad_id, direccion, distrito_id, zona_educativa_id, modalidad_id, nivel_id, condicion_estudio_id, correo, telefono_fijo, telefono_otro, director_actual_id, director_supl_actual_id, subdirector_actual_id, subdirector_supl_actual_id, coordinador_actual_id, coordinador_supl_actual_id, clase_plantel_id, condicion_infra_id, categoria_id, posee_electricidad, posee_edificacion, logo, observacion, es_tecnica, especialidad_tec_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, estatus_plantel_id, latitud, longitud, annio_fundado, turno_id, genero_id, zona_ubicacion_id, nfax, codigo_ner', 'safe', 'on' => 'search'),
            /* escenarios para validar actualización de datos generales  NO ELIMINAR (IGNACIO) */
            array('direccion, nombre, genero_id, correo, telefono_fijo, telefono_otro, cod_plantelNer, codigo_ner, cod_estadistico, denominacion_id, tipo_dependencia_id, estado_id, municipio_id, parroquia_id, zona_educativa_id, condicion_estudio_id, clase_plantel_id, categoria_id, estatus_plantel_id, annio_fundado, turno_id', 'required', 'message' => 'El campo {attribute} no debe estar vacío', 'on' => 'updateDatosGeneralesNer'),
            array('cod_estadistico', 'numerical', 'integerOnly' => true, 'message' => 'El campo {attribute} debe contener números', 'on' => 'createFromCnae' ),
            array('cod_plantel', 'validarCodigoPlantelNer', 'on' => 'updateDatosGeneralesNer, crearDatosGeneralesNer'),
            array('direccion, nombre, genero_id, correo, telefono_fijo, telefono_otro, cod_plantel, cod_estadistico, denominacion_id, tipo_dependencia_id, estado_id, municipio_id, parroquia_id, zona_educativa_id, condicion_estudio_id, clase_plantel_id, categoria_id, estatus_plantel_id, annio_fundado, turno_id', 'required', 'message' => 'El campo {attribute} no debe estar vacio', 'on' => 'updateDatosGeneralesSNer'),
            array('cod_plantel', 'validarCodigoPlantel', 'on' => 'updateDatosGeneralesSNer, crearDatosGeneralesSNer'),
        );
    }

    public function validarCodigoPlantelNer($attr, $params) {
        if (strlen($this->cod_plantel) != 4) {
            $this->addError('cod_plantel', 'El Código del Plantel Ner debe poseer 4 caracteres.');
        }
    }

    public function validarCodigoPlantel($attr, $params) {
        if (strlen($this->cod_plantel) != 10) {
            $this->addError('cod_plantel', 'El Código del Plantel debe poseer 10 caracteres.');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'genero' => array(self::BELONGS_TO, 'Genero', 'genero_id'),
            'coordinadorActual' => array(self::BELONGS_TO, 'UsergroupsUser', 'coordinador_actual_id'),
            'categoria' => array(self::BELONGS_TO, 'Categoria', 'categoria_id'),
            'clasePlantel' => array(self::BELONGS_TO, 'ClasePlantel', 'clase_plantel_id'),
            'condicionEstudio' => array(self::BELONGS_TO, 'CondicionEstudio', 'condicion_estudio_id'),
            'condicionInfra' => array(self::BELONGS_TO, 'CondicionInfraestructura', 'condicion_infra_id'),
            'denominacion' => array(self::BELONGS_TO, 'Denominacion', 'denominacion_id'),
            'directorActual' => array(self::BELONGS_TO, 'UsergroupsUser', 'director_actual_id'),
            'distrito' => array(self::BELONGS_TO, 'Distrito', 'distrito_id'),
            'especialidadTec' => array(self::BELONGS_TO, 'EspecialidadTecnica', 'especialidad_tec_id'),
            'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
            'estatusPlantel' => array(self::BELONGS_TO, 'EstatusPlantel', 'estatus_plantel_id'),
            'localidad' => array(self::BELONGS_TO, 'Localidad', 'localidad_id'),
            'modalidad' => array(self::BELONGS_TO, 'Modalidad', 'modalidad_id'),
            'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
            'nivel' => array(self::BELONGS_TO, 'Nivel', 'nivel_id'),
            'plantaFisica' => array(self::BELONGS_TO, 'PlantaFisica', 'planta_fisica_id'),
            'parroquia' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_id'),
            /*             * ****************************ALEXIS RELACIONES************************** */
            'poblacion' => array(self::BELONGS_TO, 'Poblacion', 'poblacion_id'),
            'urbanizacion' => array(self::BELONGS_TO, 'Urbanizacion', 'urbanizacion_id'),
            'tipo_via' => array(self::BELONGS_TO, 'TipoVia', 'tipo_via_id'),
            'vias' => array(self::BELONGS_TO, 'Via', 'via'),
            /* ***************************************************************** */
            'tipoDependencia' => array(self::BELONGS_TO, 'TipoDependencia', 'tipo_dependencia_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'zonaEducativa' => array(self::BELONGS_TO, 'ZonaEducativa', 'zona_educativa_id'),
            'zonaUbicacion' => array(self::BELONGS_TO, 'ZonaUbicacion', 'zona_ubicacion_id'),
            'turno' => array(self::BELONGS_TO, 'Turno', 'turno_id'),
            'subdirectorActual' => array(self::BELONGS_TO, 'UsergroupsUser', 'subdirector_actual_id'),
            'proyectosEndogenosPlantels' => array(self::HAS_MANY, 'ProyectosEndogenosPlantel', 'plantel_id'),
            'autoridadPlantels' => array(self::HAS_MANY, 'AutoridadPlantel', 'plantel_id'),
            'nivelPlantels' => array(self::HAS_MANY, 'NivelPlantel', 'plantel_id'),
            'turnoPlantels' => array(self::HAS_MANY, 'TurnoPlantel', 'plantel_id'),
            'servicioPlantels' => array(self::HAS_MANY, 'ServicioPlantel', 'plantel_id'),
            'dependenciaNominalPlantels' => array(self::HAS_MANY, 'DependenciaNominalPlantel', 'plantel_id'),
            'plantelPae' => array(self::HAS_MANY, 'PlantelPae', 'plantel_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cod_estadistico' => 'Código Estadistico',
            'cod_plantel' => 'Código DEA',
            'planta_fisica_id' => 'Planta Fisica',
            'nombre' => 'Nombre de la Institución Educativa',
            'denominacion_id' => 'Denominación',
            'tipo_dependencia_id' => 'Tipo Dependencia',
            'estado_id' => 'Estado',
            'municipio_id' => 'Municipio',
            'parroquia_id' => 'Parroquia',
            /* ****************** ALEXIS EDITE************************** */
            'poblacion_id' => 'Población',
            'urbanizacion_id' => 'Urbanización',
            'via' => 'Nombre de la Via',
            'tipo_via_id' => "Tipo de Via",
            /*             * *************************************************** */
            'direccion' => 'Dirección Referencial',
            'distrito_id' => 'Distrito',
            'zona_educativa_id' => 'Zona Educativa',
            'modalidad_id' => 'Modalidad',
            'nivel_id' => 'Nivel',
            'condicion_estudio_id' => 'Condición Estudio',
            'correo' => 'Correo',
            'telefono_fijo' => 'Telefono Fijo',
            'telefono_otro' => 'Telefono Otro',
            'director_actual_id' => 'Director Actual',
            'director_supl_actual_id' => 'Director Supl Actual',
            'subdirector_actual_id' => 'Subdirector Actual',
            'subdirector_supl_actual_id' => 'Subdirector Supl Actual',
            'coordinador_actual_id' => 'Coordinador Actual',
            'coordinador_supl_actual_id' => 'Coordinador Supl Actual',
            'clase_plantel_id' => 'Clase de Plantel',
            'condicion_infra_id' => 'Condicion Infra',
            'categoria_id' => 'Categoria',
            'posee_electricidad' => 'Posee Electricidad',
            'posee_edificacion' => 'Posee Edificacion',
            'logo' => 'Logo',
            'observacion' => 'Observación',
            'es_tecnica' => 'Es Tecnica',
            'especialidad_tec_id' => 'Especialidad Tec',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'estatus_plantel_id' => 'Estatus Plantel',
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
            'annio_fundado' => 'Año de Fundación',
            'turno_id' => 'Turno',
            'genero_id' => 'Tipo Matricula',
            'zona_ubicacion_id' => 'Zona Ubicación',
            'nfax' => 'Nº Fax',
            'codigo_ner' => 'Código NER',
            'cod_plantelNer' => 'Código NER',
            'cod_cnae' => 'Código CNAE',
            'es_beneficiario_pae' => 'Es beneficiario del PAE',
            'otras_sedes' => 'Cantidad de sedes distantes a la sede Principal',
            'posee_cbit' => 'Posee espacio de tecnología CBIT',
            'cbit_con_internet' => 'El CBIT posee Internet',
            'consejo_comunal' => 'Nombre de Consejo Comunal Contralor',
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
        $groupId = Yii::app()->user->group;
        $usuarioId = Yii::app()->user->id;
        $userEstadoId = Yii::app()->user->estado;
        //var_dump($userEstadoId);die();
        
        $criteria->with = array('estado'=>array('alias'=>'es'), 'denominacion'=>array('alias'=>'d'), 'plantelPae'=>array('alias'=>'ae', 'together'=>true), 'estatusPlantel'=>array('alias'=>'ep'), 'tipoDependencia'=>array('alias'=>'td'), 'municipio'=>array('alias'=>'munc'),);
        
        $criteria->select = 't.id, t.cod_estadistico, t.cod_plantel, t.planta_fisica_id, t.nombre, t.denominacion_id, t.tipo_dependencia_id, '
                . 't.estado_id, t.municipio_id, t.parroquia_id, t.zona_educativa_id, t.modalidad_id, t.usuario_ini_id, t.fecha_ini, t.usuario_act_id, '
                . 't.fecha_act, t.fecha_elim, t.estatus, t.estatus_plantel_id, t.director_actual_id ';
        
        $criteria->compare('id', $this->id, true);

        //$criteria->compare('id', $this->id, true);

        if (is_numeric($this->cod_estadistico)) {
            if (strlen($this->cod_estadistico) < 16) {
                $criteria->compare('cod_estadistico', $this->cod_estadistico);
            }
        }
        
        if($this->tiene_director_registrado=='SI'){
            $criteria->addCondition("(t.director_actual_id IS NOT NULL)");
        }
        elseif($this->tiene_director_registrado=='NO'){
            $criteria->addCondition("(t.director_actual_id IS NULL)");
        }

        //$criteria->compare('cod_plantel', $this->cod_plantel, true);
        $criteria->addSearchCondition('t.cod_plantel', '%' . addslashes($this->cod_plantel). '%', false, 'AND', 'ILIKE');

        $criteria->compare('planta_fisica_id', $this->planta_fisica_id);
        $criteria->addSearchCondition('t.nombre', '%' . addslashes($this->nombre) . '%', false, 'AND', 'ILIKE');

        #$criteria->compare('nombre',$this->nombre,true);
        if (is_numeric($this->denominacion_id)) {
            if (strlen($this->tipo_dependencia_id) < 10) {
                $criteria->compare('denominacion_id', $this->denominacion_id);
            }
        }

        if (is_numeric($this->tipo_dependencia_id)) {
            if (strlen($this->tipo_dependencia_id) < 10) {
                $criteria->compare('tipo_dependencia_id', $this->tipo_dependencia_id);
            }
        }

        //if (is_numeric($this->estado_id) || $this->estado_id == '') {
        //    if (strlen($this->estado_id) < 10) {
        //        // Lógica de Permisología
        //        if (in_array(Yii::app()->user->group, array(UserGroups::DIRECTOR, UserGroups::COOR_NAC_PAE, UserGroups::ADMIN_NAC_PAE, UserGroups::DESARROLLADOR, UserGroups::root))) {
        //            $criteria->compare('t.estado_id', $this->estado_id, false);
        //        } else {
        //            $criteria->compare('t.estado_id', Yii::app()->user->estado, false);
        //        }
        //    }
        //}
        
        if (is_numeric($this->estado_id)) {
            if (strlen($this->estado_id) < 10) {
                $criteria->compare('t.estado_id', $this->estado_id);
            }
        }
        
        if (is_numeric($this->municipio_id)) {
            if (strlen($this->municipio_id) < 10) {
                $criteria->compare('t.municipio_id', $this->municipio_id);
            }
        }
        /*         * **********************ALEXIS AGREGUE ***************************************** */
        if (is_numeric($this->poblacion_id)) {
            if (strlen($this->poblacion_id) < 10) {
                $criteria->compare('t.poblacion_id', $this->poblacion_id);
            }
        }

        if (is_numeric($this->urbanizacion_id)) {
            if (strlen($this->urbanizacion_id) < 10) {
                $criteria->compare('urbanizacion_id', $this->urbanizacion_id);
            }
        }
        if (is_numeric($this->tipo_via_id)) {
            if (strlen($this->tipo_via_id) < 10) {
                $criteria->compare('tipo_via_id', $this->tipo_via_id);
            }
        }

        if (is_numeric($this->via)) {
            if (strlen($this->via) < 10) {
                $criteria->compare('urbanizacion_id', $this->via);
            }
        }
        /*         * ****************************************************************************** */
        if (is_numeric($this->estatus_plantel_id)) {
            if (strlen($this->estatus_plantel_id) < 10) {
                $criteria->compare('t.estatus_plantel_id', $this->estatus_plantel_id);
            }
        }
        
        // var_dump($this->pae_activo); die();
        
        if(in_array($this->pae_activo, array('SI', 'NO'))){
            if($this->pae_activo=='SI'){
                $criteria->addCondition("(ae.pae_activo='SI')");
            }else{
                $criteria->addCondition("(ae.pae_activo IS NULL OR ae.pae_activo='NO')");
            }
        }
        
        #$criteria->together=true;

        /**
         * La variable "t" representa "gplantel.plantel"
         
            $criteria->join = ' LEFT JOIN gplantel.estatus_plantel ep ON t.estatus_plantel_id = ep.id ';
            $criteria->join .= 'LEFT JOIN gplantel.tipo_dependencia td ON t.tipo_dependencia_id = td.id ';
            $criteria->join .= 'LEFT JOIN estado es ON t.estado_id = es.id ';
            $criteria->join .= 'LEFT JOIN municipio munc ON t.municipio_id = munc.id ';
         * 
         */
        
        
//        $criteria->select .= ', ep.nombre AS estatus_plantel, td.nombre AS tipo_dependencia, es.nombre AS estado, es.nombre, munc.nombre AS municipio, '
//                . 'munc.nombre, ae.pae_activo, ae.matricula_general, ae.matricula_simoncito';
        
        /**
         * Si el usuario es coordinador de la zona educativa (25)
         */
        if ($groupId == 25) {
            $criteria->join .= " LEFT JOIN gplantel.autoridad_zona_educativa ze ON t.zona_educativa_id = ze.zona_educativa_id ";
            $criteria->addCondition("ze.usuario_id = :usuario");
            $criteria->params = array_merge($criteria->params, array(':usuario' => (int) $usuarioId));
//            $criteria->select .= ', ze.nombre';
        }

        /**
         * Si el usuario es coordinador de control de estudio y evaluacion de plantel (26)
         * Si el usuario es Director (29)
         * Si el usuario ees secretaria o transcriptor
         */
       // if (($groupId == 26) || ($groupId == 29) || ($groupId == 30)) {
       //     $criteria->join .= " LEFT JOIN gplantel.autoridad_plantel ap ON t.id = ap.plantel_id ";
       //     $criteria->addCondition("ap.usuario_id = :usuario AND ap.estatus = 'A'");
       //     $criteria->params = array_merge($criteria->params, array(':usuario' => (int) $usuarioId));
//     //       $criteria->select .= ', ap.cargo_id';
//     //       $criteria->bindParam(":usuario", $usuarioId, PDO::PARAM_INT);
       // }

        if ($groupId == UserGroups::MISION_RIBAS_NAC) {
            //$criteria->join .= " LEFT JOIN gplantel.denominacion d ON d.id = t.denominacion_id ";
            $criteria->addCondition("d.id = :denomid");
            $criteria->params = array_merge($criteria->params, array(':denomid' => UserGroups::DENOMINACION_ID));
//            $criteria->select .= ', d.nombre AS denominacion, d.nombre';
        }

        if ($groupId == UserGroups::MISION_RIBAS_REG) {
            //$criteria->join .= " LEFT JOIN gplantel.denominacion d ON d.id = t.denominacion_id ";
            $criteria->addCondition('t.estado_id = :estado_id');
            $criteria->addCondition("d.id = :denomid");
            $criteria->params = array_merge($criteria->params, array(':denomid' => UserGroups::DENOMINACION_ID));
            $criteria->params = array_merge($criteria->params, array(':estado_id' => $userEstadoId));
//            $criteria->select .= ', d.nombre AS denominacion, d.nombre';
        }

        $criteria->compare('es_beneficiario_pae',$this->es_beneficiario_pae, true);

        //var_dump($usuarioId);
        //var_dump($criteria->params);
        //die();

        $criteria->compare('parroquia_id', $this->parroquia_id);
        $criteria->compare('localidad_id', $this->localidad_id);
        $criteria->compare('direccion', $this->direccion, true);
        $criteria->compare('distrito_id', $this->distrito_id);
        $criteria->compare('zona_educativa_id', $this->zona_educativa_id);
        $criteria->compare('modalidad_id', $this->modalidad_id);
        $criteria->compare('nivel_id', $this->nivel_id);
        $criteria->compare('condicion_estudio_id', $this->condicion_estudio_id);
        $criteria->compare('correo', $this->correo, true);
        $criteria->compare('telefono_fijo', $this->telefono_fijo, true);
        $criteria->compare('telefono_otro', $this->telefono_otro, true);
        $criteria->compare('director_actual_id', $this->director_actual_id);
        $criteria->compare('director_supl_actual_id', $this->director_supl_actual_id);
        $criteria->compare('subdirector_actual_id', $this->subdirector_actual_id);
        $criteria->compare('subdirector_supl_actual_id', $this->subdirector_supl_actual_id);
        $criteria->compare('coordinador_actual_id', $this->coordinador_actual_id);
        $criteria->compare('coordinador_supl_actual_id', $this->coordinador_supl_actual_id);
        $criteria->compare('clase_plantel_id', $this->clase_plantel_id);
        $criteria->compare('condicion_infra_id', $this->condicion_infra_id);
        $criteria->compare('categoria_id', $this->categoria_id);
        $criteria->compare('posee_electricidad', $this->posee_electricidad);
        $criteria->compare('posee_edificacion', $this->posee_edificacion);
        $criteria->compare('logo', $this->logo, true);
        $criteria->compare('observacion', $this->observacion, true);
        $criteria->compare('es_tecnica', $this->es_tecnica);
        $criteria->compare('especialidad_tec_id', $this->especialidad_tec_id);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('latitud', $this->latitud);
        $criteria->compare('longitud', $this->longitud);
        $criteria->compare('annio_fundado', $this->annio_fundado);
        $criteria->compare('turno_id', $this->turno_id);
        $criteria->compare('genero_id', $this->genero_id);
        $criteria->compare('zona_ubicacion_id', $this->zona_ubicacion_id);
        $criteria->compare('nfax', $this->nfax, true);
        $criteria->compare('codigo_ner', $this->codigo_ner, true);

        /* BUSQUEDA POR CEDULA DEL DIRECTOR */
        if (isset($_REQUEST['Plantel']['cedula_director'])) {
            $cedulaDirectorSearch = $_REQUEST['Plantel']['cedula_director'];
            if (is_numeric($cedulaDirectorSearch)) {
                if (strlen($cedulaDirectorSearch) < 10) {
                    $criteria->join .= ' INNER JOIN gplantel.autoridad_plantel ON t.id = gplantel.autoridad_plantel.plantel_id ';
                    $criteria->join .= ' INNER JOIN seguridad.usergroups_user ON seguridad.usergroups_user.id =  gplantel.autoridad_plantel.usuario_id ';
                    $criteria->addCondition("seguridad.usergroups_user.cedula = :cedula AND seguridad.usergroups_user.group_id = 29 AND gplantel.autoridad_plantel.estatus = 'A'");
                    $criteria->params = array_merge($criteria->params, array(':cedula' => (int) $cedulaDirectorSearch));
                }
            }
        }

        $criteria->order = 't.estado_id ASC, t.fecha_act DESC, t.fecha_ini DESC';
        //$criteria->addCondition('estatus_plantel_id = 1');
        
        // var_dump($criteria); die();
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * AUTORIDAD DIRECTOR
     * CON ESTE METODO PUEDO IDENTIFICAR SI EL DIRECTOR ES PROPIETRARIO DEL PLANTEL A CONSULTAR
     */
    public function datosPlantel($plantel_id) {
        $usuario_id = Yii::app()->user->id;
        if (is_numeric($plantel_id)) {
            $sql = "SELECT p.id, nombre FROM gplantel.plantel p
                    INNER JOIN gplantel.autoridad_plantel ap ON ap.plantel_id = p.id
                    WHERE p.id = :plantel_id AND ap.usuario_id = :usuario_id AND ap.estatus = 'A'";
            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $consulta->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $resultado = $consulta->queryAll();
            return $resultado;
        } else {
            return null;
        }
    }

    
    
    /* ESTA FUNCION TE PERMITE DETERMINAR SI EL USUARIO SESSION NO PERTENECE A ESE PLANTEL */

    public function identificacionUsuario($usuarioId, $plantelId, $tipo) {
        $resultado = 0;
        /* USUARIOS DE AUTORIDAD PLANTEL */
        if ($tipo == 1) {
            $sql = "SELECT * FROM gplantel.autoridad_plantel WHERE usuario_id = :usuario AND plantel_id = :id";
        }
        /* USUARIOS DE LAS ZONAS EDUCATIVA */
        if ($tipo == 2) {
            $sql = "SELECT * FROM gplantel.plantel p
                LEFT JOIN gplantel.autoridad_zona_educativa z ON z.zona_educativa_id = p.zona_educativa_id
                WHERE z.usuario_id = :usuario AND p.id = :id";
        }
        if ((is_numeric($usuarioId)) && (is_numeric($plantelId))) {
            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(":usuario", $usuarioId, PDO::PARAM_INT);
            $consulta->bindParam(":id", $plantelId, PDO::PARAM_INT);
            $resultado = $consulta->execute();
        }

        return $resultado;
    }

    /* ESTA FUNCION ES PARA HACER UN findAll PARA EL USUARIO COORDINADOR DE ZONA */

    public function estadoId($usuarioId) {
        $sql = "SELECT DISTINCT gplantel.plantel.estado_id FROM gplantel.plantel
        LEFT JOIN gplantel.zona_educativa z ON z.id = gplantel.plantel.zona_educativa_id
        LEFT JOIN gplantel.autoridad_zona_educativa a ON a.zona_educativa_id = z.id
        WHERE a.usuario_id = " . $usuarioId;

        $resultado = Yii::app()->db->createCommand($sql);
        $r = $resultado->queryAll();

        $estadoId = 'null';

        if (is_array($r) && isset($r[0]) && array_key_exists('estado_id', $r[0])) {
            $estadoId = $r[0]['estado_id'];
        }

        return $estadoId;
    }

    /* ESTA FUNCION TE OBTIENE EL TIPO DE UBICACION DE UN PLANTEL EN ESPECIFICO */

    public function obtenerTipoUbicacion($id) {
        $sql = 'SELECT gplantel.tipo_ubicacion.nombre FROM gplantel.tipo_ubicacion
        LEFT JOIN gplantel.tipo_ubicacion_plantel ON gplantel.tipo_ubicacion_plantel.tipo_ubicacion_id = gplantel.tipo_ubicacion.id
        LEFT JOIN gplantel.plantel ON gplantel.plantel.id = tipo_ubicacion_plantel.plantel_id
        WHERE plantel_id = ' . $id;

        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    public function validarTipoDependencia($plantel_id) {
        $sql = "SELECT p.tipo_dependencia_id"
                . " FROM gplantel.plantel p "
                . " INNER JOIN gplantel.tipo_dependencia d_n on (d_n.id = p.tipo_dependencia_id)"
                . " WHERE p.id = :plantel_id";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $resultado = $consulta->queryScalar();
        return $resultado;
    }

    public function esBeneficiarioPae(){
        return ($this->es_beneficiario_pae=='SI');
    }

    public function validarAutoridad($tipo_dependencia, $usuario_id, $plantel_id, $seguro = false) {
        $resultadoUsuario = array();
        if ($seguro) {
            if ($tipo_dependencia !== 6) { // NO ES PRIVADO
                $sql = "    SELECT distinct a_p.plantel_id , 'plantel' as entidad"
                        . "     FROM gplantel.plantel p"
                        . "     INNER JOIN gplantel.autoridad_plantel a_p ON (a_p.plantel_id = p.id)"
                        . " WHERE a_p.usuario_id = :usuario_id  AND p.tipo_dependencia_id <> 6 "
                        . "-- UNION SOBRE LA TABLA ZONA EDUCATIVA--"
                        . " UNION "
                        . " SELECT distinct a_z.zona_educativa_id , 'zona' as entidad"
                        . "     FROM gplantel.autoridad_zona_educativa a_z "
                        . " WHERE a_z.usuario_id = :usuario_id  "
                        . "-- FIN UNION SOBRE LA TABLA ZONA EDUCATIVA--"
                        . "-- UNION SOBRE LA TABLA DISTRITO--"
                        . " UNION "
                        . " SELECT distinct a_d.distrito_id , 'distrito' as entidad"
                        . "     FROM gplantel.autoridad_distrito a_d "
                        . " WHERE a_d.usuario_id = :usuario_id "
                        . "-- FIN UNION SOBRE LA TABLA DISTRITO--";
                $buqueda = Yii::app()->db->createCommand($sql);
                $buqueda->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
                $resultadoUsuario = $buqueda->queryAll(); //queryScalar= Es para obtener un solo valor
            }
        } else {
            $resultado = AutoridadPlantel::model()->validarUsuarioEnPlantel($usuario_id, $plantel_id);
            if ($resultado) {
                return null;
            } else
                return array();
        }

        return $resultadoUsuario;
    }

    public function guardarTipoUbicacion($plantel_id, $fronteriza, $indigena, $dificil_acceso) {
        //    var_dump($fronteriza,$indigena,$dificil_acceso);die();
        $usuario = Yii::app()->user->id;
        $estatus = 'A';
        if ($fronteriza != null) {
            $sql = "INSERT INTO gplantel.tipo_ubicacion_plantel
               (tipo_ubicacion_id, plantel_id, usuario_ini_id, estatus)
               VALUES (:tipo_ubicacion_id, :plantel_id, :usuario_ini_id, :estatus) returning id";

            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":tipo_ubicacion_id", $fronteriza, PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guardoUbicacionFronteriza = $guard->queryScalar();
            // var_dump($control); die();
            // return $guardoUbicacionFronteriza;
        }
        if ($indigena != null) {
            $sql = "INSERT INTO gplantel.tipo_ubicacion_plantel
               (tipo_ubicacion_id, plantel_id, usuario_ini_id, estatus)
               VALUES (:tipo_ubicacion_id, :plantel_id, :usuario_ini_id, :estatus) returning id";

            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":tipo_ubicacion_id", $indigena, PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guardoUbicacionIndigena = $guard->queryScalar();
            // var_dump($control); die();
            //  return $guardoUbicacionIndigena;
        }
        if ($dificil_acceso != null) {
            $sql = "INSERT INTO gplantel.tipo_ubicacion_plantel
               (tipo_ubicacion_id, plantel_id, usuario_ini_id, estatus)
               VALUES (:tipo_ubicacion_id, :plantel_id, :usuario_ini_id, :estatus) returning id";

            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":tipo_ubicacion_id", $dificil_acceso, PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guardoUbicacionDificilA = $guard->queryScalar();
            // var_dump($control); die();
            //  return $guardoUbicacionDificilA;
        }
        //  var_dump($guardoUbicacionFronteriza,$guardoUbicacionIndigena,$guardoUbicacionDificilA); die();
    }

/////////////////////////////////validar codigo estadistico///////////////////////////////

    public function validarCodEstadisticoRegistrar($cod_estadistico) {
        $sql = "SELECT id
                   FROM gplantel.plantel
                   WHERE
                   cod_estadistico = :cod_estadistico";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':cod_estadistico', $cod_estadistico, PDO::PARAM_INT);
        $result1 = $commandBusqueda->execute(); //execute de vuelve 1 si lo encuentra y 0 sino
        return $result1;
    }

/////////////////////////////////////////fin//////////////////////////////////////////////

    public function obtenerDatosIdentificacion($plantel_id) {
        if (is_numeric($plantel_id)) {
            $sql = "SELECT p.cod_plantel, p.cod_estadistico, p.nombre nom_plantel,d.nombre denominacion, z.nombre zona_educativa, e.nombre estado, p.direccion, m.nombre municipio,  p.telefono_fijo, p.telefono_otro"
                    . " FROM gplantel.plantel p "
                    . " INNER JOIN gplantel.zona_educativa z on (z.id = p.zona_educativa_id)"
                    . " INNER JOIN public.estado e on (e.id = p.estado_id)"
                    . " LEFT JOIN gplantel.denominacion d on (d.id = p.denominacion_id)"
                    . " LEFT JOIN public.municipio m on (m.id = p.municipio_id)"
                    . " WHERE p.id = :plantel_id";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(':plantel_id', $plantel_id, PDO::PARAM_INT);
            $res = $command->queryRow();
            if ($res !== array())
                return $res;
            else
                return false;
        } else
            return null;
    }

    public function buscarEstado($zona_educacion_id) {

        $sql = "SELECT estado_id
                    FROM gplantel.zona_educativa
                    WHERE id=:zona_educativa_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':zona_educativa_id', $zona_educacion_id, PDO::PARAM_INT);
        $result1 = $commandBusqueda->queryRow(); //execute de vuelve 1 si lo encuentra y 0 sino
        $result = $result1['estado_id'];
        // var_dump($result1['estado_id']); die();
        return $result;
    }

    public function obtenerFechaFundacion($plantel_id) {
        $sql = "SELECT annio_fundado
                   FROM gplantel.plantel
                   WHERE id=:id_plantel";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':id_plantel', $plantel_id, PDO::PARAM_INT);
        $result1 = $commandBusqueda->queryRow(); //execute de vuelve 1 si lo encuentra y 0 sino
        $result = $result1['annio_fundado'];
        return $result;
    }

/////////////////////////validar codigo del plantel///////////////////////////////////

    public function validarCodPlantelRegistrar($cod_plantel) {
        $sql = "SELECT id
                   FROM gplantel.plantel
                   WHERE
                   cod_plantel = :cod_plantel";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':cod_plantel', $cod_plantel, PDO::PARAM_STR);
        $result2 = $commandBusqueda->execute();
        return $result2;
    }

///////////////////////////////////////fin///////////////////////////////////////////////////





    public function verificarExistenciaPlantel($cod_estadistico, $cod_plantel) {

        $cod_estadistico = (int) $cod_estadistico;

        $sql = "SELECT id
               FROM gplantel.plantel
               WHERE cod_estadistico='$cod_estadistico' and cod_plantel='$cod_plantel'";
        $buscar = Yii::app()->db->createCommand($sql);
        $rBuscar = $buscar->execute();
//var_dump($rBuscar); die();
        return $rBuscar;
        // var_dump($rBuscar); die();
    }

    public function validarCodEstadistico($plantel_id, $cod_estadistico) {
        $sql = "SELECT id
                   FROM gplantel.plantel
                   WHERE
                   cod_estadistico = :cod_estadistico AND id <> :plantel_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':plantel_id', $plantel_id, PDO::PARAM_STR);
        $commandBusqueda->bindParam(':cod_estadistico', $cod_estadistico, PDO::PARAM_STR);
        $result = $commandBusqueda->execute();
        return ($result > 0);
    }

    public function validarCodPlantel($plantel_id, $cod_plantel) {
        $sql = "SELECT id
                   FROM gplantel.plantel
                   WHERE
                   cod_plantel = :cod_plantel AND id <> :plantel_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':plantel_id', $plantel_id, PDO::PARAM_STR);
        $commandBusqueda->bindParam(':cod_plantel', $cod_plantel, PDO::PARAM_STR);
        $result = $commandBusqueda->execute();
        return ($result > 0);
    }

    public function agregarLogo($plantel_id, $filename) {
        $sql = "UPDATE gplantel.plantel
                   SET logo = :logo
                   WHERE
                   id = :plantel_id";
        $commandUpdate = $this->getDbConnection()->createCommand($sql);
        $commandUpdate->bindParam(':plantel_id', $plantel_id, PDO::PARAM_STR);
        $commandUpdate->bindParam(':logo', $filename, PDO::PARAM_STR);
        $result = $commandUpdate->execute();
        return ($result > 0);
    }

    /* VALIDACION QUE EXISTA EL ID DE LOS DROPDOWNLIST */

    public function validarExistenciaDenominacion($denominacion_id) {
        $sql = "SELECT id
                   FROM gplantel.denominacion
                   WHERE
                   id = :denominacion_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':denominacion_id', $denominacion_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaZonaEducativa($zona_educativa_id) {
        $estado = $this->buscarEstado($zona_educativa_id);
        $sql = "SELECT id
                   FROM gplantel.zona_educativa
                   WHERE
                   id = :zona_educativa_id"; //AND estado_id=:estado_id
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':zona_educativa_id', $zona_educativa_id, PDO::PARAM_INT);
        // $commandBusqueda->bindParam(':estado_id', $estado, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaTipoDependencia($tipo_dependencia_id) {
        $sql = "SELECT id
                   FROM gplantel.tipo_dependencia
                   WHERE
                   id = :tipo_dependencia_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':tipo_dependencia_id', $tipo_dependencia_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaDistrito($distrito_id) {
        $sql = "SELECT id
                   FROM gplantel.distrito
                   WHERE
                   id = :distrito_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':distrito_id', $distrito_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaTurno($turno_id) {
        $sql = "SELECT id
                   FROM gplantel.turno
                   WHERE
                   id = :turno_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':turno_id', $turno_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaEstado($estado_id) {
        $sql = "SELECT id
                   FROM estado
                   WHERE
                   id = :estado_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaMunicipio($municipio_id) {
        $sql = "SELECT id
                   FROM municipio
                   WHERE
                   id = :municipio_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':municipio_id', $municipio_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaParroquia($parroquia_id) {
        $sql = "SELECT id
                   FROM parroquia
                   WHERE
                   id = :parroquia_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':parroquia_id', $parroquia_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaZonaUbicacion($zona_ubicacion_id) {
        $sql = "SELECT id
                   FROM gplantel.zona_ubicacion
                   WHERE
                   id = :zona_ubicacion_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':zona_ubicacion_id', $zona_ubicacion_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaClasePlantel($clase_plantel_id) {
        $sql = "SELECT id
                   FROM gplantel.clase_plantel
                   WHERE
                   id = :clase_plantel_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':clase_plantel_id', $clase_plantel_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaCategoria($categoria_id) {
        $sql = "SELECT id
                   FROM gplantel.categoria
                   WHERE
                   id = :categoria_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaCondicionEstudio($condicion_estudio_id) {
        $sql = "SELECT id
                   FROM gplantel.condicion_estudio
                   WHERE
                   id = :condicion_estudio_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':condicion_estudio_id', $condicion_estudio_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaGenero($genero_id) {
        $sql = "SELECT id
                   FROM gplantel.genero
                   WHERE
                   id = :genero_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':genero_id', $genero_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function validarExistenciaModalidad($modalidad_id) {
        $sql = "SELECT id
                   FROM gplantel.modalidad
                   WHERE
                   id = :modalidad_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':modalidad_id', $modalidad_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    /*     * ***********ALEXIS**************** */

    public function validarExistenciaPoblacion($poblacion_id) {
        $sql = "SELECT id
                   FROM poblacion
                   WHERE
                   id = :poblacion_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':poblacion_id', $poblacion_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute();
        return $result;
    }

    public function validarExistenciaUrbanizacion($urbanizacion_id) {
        $sql = "SELECT id
                   FROM urbanizacion
                   WHERE
                   id = :urbanizacion_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':urbanizacion_id', $urbanizacion_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute();
        return $result;
    }

    public function validarExistenciaTipoVia($tipo_via_id) {
        $sql = "SELECT id
                   FROM tipo_via
                   WHERE
                   id = :tipo_via_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':tipo_via_id', $tipo_via_id, PDO::PARAM_INT);
        $result = $commandBusqueda->execute();
        return $result;
    }

    /*     * *************************************************************************** */

    /* FIN */


    /*     * *****************************AGREGAR Para mi drop list ALEXIS********************************************** */

    public function obtenerPoblacion($parroquia) {

        $result = null;

        if(is_numeric($parroquia)) {

            $cacheIndex = 'Pobls:Prrq:'.$parroquia;

            $result = Yii::app()->cache->get($cacheIndex);

            if(!$result){
                $sql = "SELECT DISTINCT poblacion.nombre AS nombre ,poblacion.id AS id
                          FROM poblacion
                         INNER JOIN sector ON poblacion.id=sector.poblacion_id
                         WHERE sector.parroquia_id=$parroquia
                         ORDER BY nombre ASC";
                $commandBusqueda = $this->getDbConnection()->createCommand($sql);
                $commandBusqueda->bindParam('parroquia', $parroquia, PDO::PARAM_INT);
                $result = $commandBusqueda->queryAll();
                if(is_array($result) && count($result)>0){
                    Yii::app()->cache->set($cacheIndex, $result, 86400);
                }
            }
        }
        return $result;
    }

    public function obtenerUrbanizacion($parroquia) {

        $result = null;

        if(is_numeric($parroquia)) {

            $cacheIndex = 'Urbs:Prrq:'.$parroquia;

            // Yii::app()->cache->delete($cacheIndex);

            $result = Yii::app()->cache->get($cacheIndex);

            if(!$result){
                $sql = "SELECT DISTINCT urbanizacion.nombre as nombre ,urbanizacion.id as id
                    from urbanizacion
                    inner join sector_urbanizacion on urbanizacion.id=sector_urbanizacion.urbanizacion_id
                    inner join sector on sector.id=sector_urbanizacion.sector_id
                    where sector.parroquia_id=$parroquia order by nombre ASC";
                $commandBusqueda = $this->getDbConnection()->createCommand($sql);
                $commandBusqueda->bindParam('parroquia', $parroquia, PDO::PARAM_INT);
                $result = $commandBusqueda->queryAll(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
                if(is_array($result) && count($result)>0){
                    Yii::app()->cache->set($cacheIndex, $result, 86400);
                }
                return $result;
            }
        }
    }

    public function obtenerTipoVia() {

        $sql = "SELECT DISTINCT
              tv.nb_tipo_via as nombre,
              tv.id as id
            FROM
              public.tipo_via tv
            ORDER BY tv.nb_tipo_via ASC;";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        //$commandBusqueda->bindParam('parroquia', $parroquia, PDO::PARAM_INT);
        $result = $commandBusqueda->queryAll(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
        // var_dump($result);die();
        return $result;
    }

    public function obtenerVia($parroquia_id, $term) {

        $qtxt = "SELECT DISTINCT via.nombre as nombre
                 FROM  public.sector,
                 public.sector_via,
                 public.via
                 WHERE
                 via.nombre LIKE :username AND
                  sector.id = sector_via.sector_id AND
  sector_via.via_id = via.id AND
  sector.parroquia_id = :id
ORDER BY via.nombre ASC limit 10";
        $command = Yii::app()->db->createCommand($qtxt);
        $command->bindValue(":username", '%' . $term . '%', PDO::PARAM_STR);
        $command->bindValue(":id", $parroquia_id, PDO::PARAM_STR);

        $res = $command->queryColumn();

        return $res;
    }

    /**
     * Permite obtener los datos de las autoridades para generar el formato del reporte de matricula
     * Retorna NULL cuando no encuentra conincidencias o cuando no es numerico el plantel_id
     * @author Ignacio Salazar
     * @param type $plantel_id
     * @return type array Retorna un arreglo unidimensional con los siguientes indices (nombres_director, apellidos_director, cedula_director, nombres_zona, apellidos_zona, cedula_zona)
     */
    public function getDatosAutoridadReporte($plantel_id) {
        $resultado = null;
        $sql = '';
        $cacheIndex = 'AUTR:'.$plantel_id;

        $resultado = Yii::app()->cache->get($cacheIndex);

        if(!$resultado){

            if (is_numeric($plantel_id)) {
                $sql = "SELECT u_ud.nombre nombres_director, "
                    . " u_ud.apellido apellidos_director, "
                    . " u_ud.cedula cedula_director,"
                    . " u_uz.nombre nombres_zona, "
                    . " u_uz.apellido apellidos_zona, "
                    . " u_uz.cedula cedula_zona "
                    . " FROM gplantel.plantel p "
                    . " LEFT JOIN gplantel.autoridad_plantel a on (a.usuario_id = p.director_actual_id)"
                    . " LEFT JOIN gplantel.autoridad_zona_educativa z on (z.zona_educativa_id = p.zona_educativa_id)"
                    . " LEFT JOIN seguridad.usergroups_user u_ud on ( u_ud.id = p.director_actual_id)"
                    . " LEFT JOIN seguridad.usergroups_user u_uz on ( u_uz.id = z.usuario_id)"
                    . " WHERE p.id = :plantel_id"
                    . " LIMIT 1";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":plantel_id", $plantel_id, PDO::PARAM_STR);

                $resultado = $command->queryRow();

                if($resultado){
                    Yii::app()->cache->set($cacheIndex, $resultado);
                }

                if ($resultado == array())
                    $resultado = null;
            }

        }

        return $resultado;
    }
    // NO USAR ESTA FUNCION
    public function getCodigoCNAE(){
        $sql = "SELECT gplantel.get_cod_cnae(:estado, :municipio, :parroquia) AS cod_cnae;";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":estado", $this->estado_id, PDO::PARAM_INT);
        $command->bindValue(":municipio", $this->municipio_id, PDO::PARAM_INT);
        $command->bindValue(":parroquia", $this->parroquia_id, PDO::PARAM_INT);
        $resultado = $command->queryRow();
        return $resultado['cod_cnae'];
    }


    public function beforeSave(){
        parent::beforeSave();
        $cleans = array('('=>'', ')'=>'', ' '=>'','-'=>'');
        $this->telefono_fijo = strtr($this->telefono_fijo, $cleans);
        $this->telefono_otro = strtr($this->telefono_otro, $cleans);
        // $this->cod_cnae = $this->getCodigoCNAE();
        // var_dump($this->cod_cnae);
        return true;
    }


    public function beforeUpdate(){
        parent::beforeSave();
        $cleans = array('('=>'', ')'=>'', ' '=>'','-'=>'');
        $this->telefono_fijo = strtr($this->telefono_fijo, $cleans);
        $this->telefono_otro = strtr($this->telefono_otro, $cleans);
        return true;
    }
    
    
    public function getCodCnaeByPlantelId($id){
        $cacheIndex = 'PLCODCNAE:'.$id;
        $resultado = Yii::app()->cache->get($cacheIndex);
        if(is_numeric($id)){
            $sql = " SELECT cod_cnae FROM gplantel.plantel WHERE id = :plantelId ";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":plantelId", $id, PDO::PARAM_INT);
            $resultado = trim($command->queryScalar());
            
            if($resultado && strlen($resultado)>1){
                Yii::app()->cache->set($cacheIndex, $resultado);
            }
        }
        return $resultado;
    }

    /*     * ******************************************************************************************************** */

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->db;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Plantel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function actualizarGeoreferencia($id, $latitud, $longitud){
        $resultado=null;
        if(is_numeric($latitud) && is_numeric($longitud) && is_numeric($id)) {
            $sql = "UPDATE gplantel.plantel SET latitud=:latitud_vi, longitud=:longitud_vi WHERE id=:id_vi;";
            $connection = Yii::app()->db;
            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":latitud_vi", $latitud, PDO::PARAM_STR);
            $command->bindParam(":longitud_vi", $longitud, PDO::PARAM_STR);
            $command->bindParam(":id_vi",$id, PDO::PARAM_INT);
            $resultado = $command->execute();
        }
        return $resultado;
    }
}

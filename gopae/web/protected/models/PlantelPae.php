<?php

/**
 * This is the model class for table "gplantel.plantel_pae".
 *
 * The followings are the available columns in table 'gplantel.plantel_pae':
 * @property integer $id
 * @property integer $plantel_id
 * @property string $pae_activo
 * @property string $fecha_inicio
 * @property string $fecha_ultima_actualizacion
 * @property integer $matricula_general
 * @property string $posee_simoncito
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $tipo_servicio_pae_id
 * @property integer $matricula_pequena
 * @property integer $matricula_mediana
 * @property integer $matricula_grande
 * @property string $posee_area_cocina
 * @property integer $condicion_servicio_id
 * @property string $posee_area_produccion_agricola
 * @property integer $matricula_simoncito
 * @property integer $hectareas_produccion
 * @property string $edito_matricula
 * @property string $posee_maternal
 * @property string $imparte_educacion_preescolar
 * @property string $imparte_educacion_primaria
 * @property string $imparte_educacion_media_general
 * @property string $imparte_educºacion_tecnica
 * @property string $imparte_educacion_especial
 * @property integer $matricula_maternal
 * @property integer $matricula_preescolar
 * @property integer $matricula_educacion_primaria
 * @property integer $matricula_educacion_media_general
 * @property integer $matricula_educacion_tecnica
 * @property integer $matricula_educacion_especial
 * @property integer $matricula_docente_obrero
 * @property string $posee_permiso_sanitario_vigente
 * @property string $posee_proveedor_complementario
 * @property integer $proveedor_actual_id
 * @property integer $cantidad_madres_procesadoras
 * @property string $comprobante_emitido
 * @property date $fecha_emision_comprobante
 *
 * The followings are the available model relations:
 * @property Proveedor $proveedorActual
 * @property TipoServicioPae $tipoServicioPae
 * @property Plantel $plantel
 * @property UsergroupsUser $usuarioIni
 * @property CondicionServicio $condicionServicio
 * @property UsergroupsUser $usuarioAct
 * @property PlantelPaeNotificacion[] $plantelPaeNotificacions
 */
class PlantelPae extends CActiveRecord {

    public static $cantidadDeAlumnosPorColaboradora = 70;
    public static $cantidadDeAlumnosPorCocinera = 70;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.plantel_pae';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('plantel_id, pae_activo', 'required'),
            array('plantel_id, matricula_general, usuario_ini_id, usuario_act_id, tipo_servicio_pae_id, matricula_pequena, matricula_mediana, matricula_grande, condicion_servicio_id, proveedor_actual_id', 'numerical', 'integerOnly'=>true),
            array('pae_activo, posee_simoncito, posee_area_cocina, posee_area_produccion_agricola, edito_matricula, posee_maternal, imparte_educacion_preescolar, imparte_educacion_primaria, imparte_educacion_media_general, imparte_educacion_tecnica, imparte_educacion_especial, posee_permiso_sanitario_vigente, posee_proveedor_complementario', 'length', 'max'=>2),
            array('estatus', 'length', 'max'=>1),
            array('hectareas_produccion', 'numerical', 'integerOnly'=>false, 'min'=>0),
            array('pae_activo, posee_simoncito, posee_area_cocina, posee_area_produccion_agricola, edito_matricula, posee_maternal, imparte_educacion_preescolar, imparte_educacion_primaria, imparte_educacion_media_general, imparte_educacion_tecnica, imparte_educacion_especial, posee_permiso_sanitario_vigente, posee_proveedor_complementario', 'in', 'range'=>array('','SI', 'NO'),),
            array('cantidad_madres_procesadoras, matricula_simoncito, matricula_maternal, matricula_preescolar, matricula_educacion_primaria, matricula_educacion_media_general, matricula_educacion_tecnica, matricula_educacion_especial, matricula_docente_obrero', 'numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>9999),
            array('tipo_servicio_pae_id, estatus, pae_activo, posee_simoncito, posee_area_cocina, posee_area_produccion_agricola, edito_matricula, posee_maternal, imparte_educacion_preescolar, imparte_educacion_primaria, imparte_educacion_media_general, imparte_educacion_tecnica, imparte_educacion_especial, posee_permiso_sanitario_vigente, posee_proveedor_complementario, matricula_simoncito, matricula_maternal, matricula_preescolar, matricula_educacion_primaria, matricula_educacion_media_general, matricula_educacion_tecnica, matricula_educacion_especial, cantidad_madres_procesadoras', 'required'),
            array('fecha_inicio, fecha_ultima_actualizacion, fecha_ini, fecha_act, fecha_elim, hectareas_produccion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, plantel_id, pae_activo, fecha_inicio, fecha_ultima_actualizacion, matricula_general, posee_simoncito, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, tipo_servicio_pae_id, matricula_pequena, matricula_mediana, matricula_grande, posee_area_cocina, condicion_servicio_id, posee_area_produccion_agricola, matricula_simoncito, hectareas_produccion, edito_matricula, posee_maternal, imparte_educacion_preescolar, imparte_educacion_primaria, imparte_educacion_media_general, imparte_educacion_tecnica, imparte_educacion_especial, matricula_maternal, matricula_preescolar, matricula_educacion_primaria, matricula_educacion_media_general, matricula_educacion_tecnica, matricula_educacion_especial, posee_permiso_sanitario_vigente, posee_proveedor_complementario, proveedor_actual_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'proveedorActual' => array(self::BELONGS_TO, 'Proveedor', 'proveedor_actual_id'),
            'tipoServicioPae' => array(self::BELONGS_TO, 'TipoServicioPae', 'tipo_servicio_pae_id'),
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'condicionServicio' => array(self::BELONGS_TO, 'CondicionServicio', 'condicion_servicio_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'plantelPaeNotificaciones' => array(self::HAS_MANY, 'PlantelPaeNotificacion', 'plantel_pae_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'plantel_id' => 'Plantel',
            'pae_activo' => 'Pae Activo',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_ultima_actualizacion' => 'Fecha Última Actualización',
            'matricula_general' => 'Matricula General',
            'posee_simoncito' => 'Posee Simoncito',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'tipo_servicio_pae_id' => 'Tipo Servicio Pae',
            'matricula_pequena' => 'Matricula Pequena',
            'matricula_mediana' => 'Matricula Mediana',
            'matricula_grande' => 'Matricula Grande',
            'posee_area_cocina' => 'Posee Área Cocina',
            'condicion_servicio_id' => 'Condición Servicio',
            'posee_area_produccion_agricola' => '¿Posee Area Producción Agricola?',
            'matricula_simoncito' => 'Matricula Simoncito',
            'hectareas_produccion' => 'Hectareas Producción',
            'edito_matricula' => 'Edito Matricula',
            'posee_maternal' => '¿Posee Maternal?',
            'imparte_educacion_preescolar' => '¿Imparte Educación Preescolar?',
            'imparte_educacion_primaria' => '¿Imparte Educación Primaria?',
            'imparte_educacion_media_general' => '¿Imparte Educación Media General?',
            'imparte_educacion_tecnica' => '¿Imparte Educación Técnica?',
            'imparte_educacion_especial' => '¿Imparte Educación Especial?',
            'matricula_maternal' => 'Matricula Maternal',
            'matricula_preescolar' => 'Matricula en Preescolar',
            'matricula_educacion_primaria' => 'Matricula en Educación Primaria',
            'matricula_educacion_media_general' => 'Matricula en Educación Media General',
            'matricula_educacion_tecnica' => 'Matricula en Educación Técnica',
            'matricula_educacion_especial' => 'Matricula en Educación Especial',
            'posee_permiso_sanitario_vigente' => '¿Posee Permiso Sanitario Vigente?',
            'posee_proveedor_complementario' => '¿Posee Proveedor Complementario?',
            'proveedor_actual_id' => 'Proveedor Actual',
            'cantidad_madres_procesadoras' => 'Cantidad de Madres Procesadoras',
            'matricula_docente_obrero'=>'Matricula Docentes y Obreros',
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
        $criteria->compare('plantel_id', $this->plantel_id);
        $criteria->compare('pae_activo', $this->pae_activo, true);
        $criteria->compare('fecha_inicio', $this->fecha_inicio, true);
        $criteria->compare('fecha_ultima_actualizacion', $this->fecha_ultima_actualizacion, true);
        $criteria->compare('matricula_general', $this->matricula_general);
        $criteria->compare('posee_simoncito', $this->posee_simoncito, true);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('tipo_servicio_pae_id', $this->tipo_servicio_pae_id);
        $criteria->compare('matricula_pequena', $this->matricula_pequena);
        $criteria->compare('matricula_mediana', $this->matricula_mediana);
        $criteria->compare('matricula_grande', $this->matricula_grande);
        $criteria->compare('posee_area_cocina', $this->posee_area_cocina, true);
        $criteria->compare('condicion_servicio_id', $this->condicion_servicio_id);
        $criteria->compare('posee_area_produccion_agricola',$this->posee_area_produccion_agricola,true);
        $criteria->compare('matricula_simoncito',$this->matricula_simoncito);
        $criteria->compare('hectareas_produccion',$this->hectareas_produccion,true);
        $criteria->compare('edito_matricula',$this->edito_matricula,true);
        $criteria->compare('posee_maternal',$this->posee_maternal,true);
        $criteria->compare('imparte_educacion_preescolar',$this->imparte_educacion_preescolar,true);
        $criteria->compare('imparte_educacion_primaria',$this->imparte_educacion_primaria,true);
        $criteria->compare('imparte_educacion_media_general',$this->imparte_educacion_media_general,true);
        $criteria->compare('imparte_educacion_tecnica',$this->imparte_educacion_tecnica,true);
        $criteria->compare('imparte_educacion_especial',$this->imparte_educacion_especial,true);
        $criteria->compare('matricula_maternal',$this->matricula_maternal);
        $criteria->compare('matricula_preescolar',$this->matricula_preescolar);
        $criteria->compare('matricula_educacion_primaria',$this->matricula_educacion_primaria);
        $criteria->compare('matricula_educacion_media_general',$this->matricula_educacion_media_general);
        $criteria->compare('matricula_educacion_tecnica',$this->matricula_educacion_tecnica);
        $criteria->compare('matricula_educacion_especial',$this->matricula_educacion_especial);
        $criteria->compare('posee_permiso_sanitario_vigente',$this->posee_permiso_sanitario_vigente,true);
        $criteria->compare('posee_proveedor_complementario',$this->posee_proveedor_complementario,true);
        $criteria->compare('proveedor_actual_id',$this->proveedor_actual_id);
        $criteria->compare('cantidad_madres_procesadoras', $this->cantidad_madres_procesadoras);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function activarPae($plantel_id, $posee_simoncito, $tipo_servicio_pae, $posee_area_cocina, $condicion_servicio_id, $posee_area_produccion_agricola, $hectareas_produccion, $matricula_general, $matricula_simoncito) {
        $usuario_id = Yii::app()->user->id;
        $estatus = 'A';
        $fecha_ini = date('Y-m-d H:i:s');

        $sql = "INSERT INTO gplantel.plantel_pae(
                        plantel_id, pae_activo, fecha_inicio, fecha_ultima_actualizacion, posee_simoncito, usuario_ini_id, fecha_ini,
                        estatus, tipo_servicio_pae_id, posee_area_cocina, condicion_servicio_id, posee_area_produccion_agricola, hectareas_produccion, matricula_general, matricula_simoncito, edito_matricula)
                VALUES (
                :plantel_id,
                'SI',
                :fecha_ini,
                :fecha_ini,
                :posee_simoncito,
                :usuario_id,
                :fecha_ini,
                :estatus,
                :tipo_servicio_pae,
                :posee_area_cocina,
                :condicion_servicio_id,
                :posee_area_produccion_agricola,
                :hectareas_produccion,
                :matricula_general,
                :matricula_simoncito, 'SI') RETURNING *;";
        $resultado = Yii::app()->db->createCommand($sql);
        $resultado->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $resultado->bindParam(":fecha_ini", $fecha_ini, PDO::PARAM_INT);
        $resultado->bindParam(":posee_simoncito", $posee_simoncito, PDO::PARAM_STR);
        $resultado->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
        $resultado->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $resultado->bindParam(":tipo_servicio_pae", $tipo_servicio_pae, PDO::PARAM_INT);
        $resultado->bindParam(":posee_area_cocina", $posee_area_cocina, PDO::PARAM_STR);
        $resultado->bindParam(":condicion_servicio_id", $condicion_servicio_id, PDO::PARAM_INT);
        $resultado->bindParam(":posee_area_produccion_agricola", $posee_area_produccion_agricola, PDO::PARAM_STR);
        $resultado->bindParam(":hectareas_produccion", $hectareas_produccion, PDO::PARAM_INT);
        $resultado->bindParam(":matricula_general", $matricula_general, PDO::PARAM_INT);
        $resultado->bindParam(":matricula_simoncito", $matricula_simoncito, PDO::PARAM_INT);
        return $resultado->queryAll();
    }

    public function modificarPae($id, $plantel_id,
            $posee_simoncito, $tipo_servicio_pae,
            $posee_area_cocina, $condicion_servicio_id,
            $posee_area_produccion_agricola, $hectareas_produccion,
            $matricula_general, $matricula_simoncito,
            $edito_matricula) {
        $usuario_act_id = Yii::app()->user->id;
        $estatus = 'A';
        if(is_numeric($hectareas_produccion)){
            $fecha_act = date('Y-m-d H:i:s'); $sql = "SELECT * FROM gplantel.plantel_pae WHERE plantel_id = $plantel_id";
            $respuesta = Yii::app()->db->createCommand($sql);
            $r = $respuesta->queryAll();
//            var_dump($this->hasPermissionToEditMatricula($edito_matricula));die();
            if($this->hasPermissionToEditMatricula($edito_matricula)){
                $sql = "UPDATE gplantel.plantel_pae
                    SET
                    matricula_general = :matricula_general,
                    matricula_simoncito = :matricula_simoncito,
                    tipo_servicio_pae_id = :tipo_servicio_pae_id,
                    posee_simoncito = :posee_simoncito,
                    usuario_act_id = :usuario_act_id,
                    fecha_act = :fecha_act,
                    posee_area_cocina = :posee_area_cocina,
                    condicion_servicio_id= :condicion_servicio_id,
                    posee_area_produccion_agricola = :posee_area_produccion_agricola,
                    hectareas_produccion = :hectareas_produccion,
                    edito_matricula = 'SI'
                  WHERE id = :plantel_pae_id AND plantel_id = :plantel_id RETURNING *;";

                $resultado = Yii::app()->db->createCommand($sql);
                $resultado->bindParam(":matricula_general", $matricula_general, PDO::PARAM_INT);
                $resultado->bindParam(":matricula_simoncito", $matricula_simoncito, PDO::PARAM_INT);
                $resultado->bindParam(":posee_simoncito", $posee_simoncito, PDO::PARAM_STR);
                $resultado->bindParam(":tipo_servicio_pae_id", $tipo_servicio_pae, PDO::PARAM_INT);
            }

            else if($r[0]['tipo_servicio_pae_id'] == null){
                $sql = "UPDATE gplantel.plantel_pae SET
                    tipo_servicio_pae_id = :tipo_servicio_pae_id,
                    usuario_act_id = :usuario_act_id,
                    fecha_act = :fecha_act,
                    posee_area_cocina = :posee_area_cocina,
                    condicion_servicio_id= :condicion_servicio_id,
                    posee_area_produccion_agricola = :posee_area_produccion_agricola,
                    hectareas_produccion = :hectareas_produccion,
                    edito_matricula = 'SI'
                  WHERE id = :plantel_pae_id AND plantel_id = :plantel_id RETURNING *;";
                $resultado = Yii::app()->db->createCommand($sql);
                $resultado->bindParam(":tipo_servicio_pae_id", $tipo_servicio_pae, PDO::PARAM_INT);
            }
            else{
//                echo 3;
                $sql = "UPDATE gplantel.plantel_pae SET
                    usuario_act_id = :usuario_act_id,
                    fecha_act = :fecha_act,
                    posee_area_cocina = :posee_area_cocina,
                    condicion_servicio_id= :condicion_servicio_id,
                    posee_area_produccion_agricola = :posee_area_produccion_agricola,
                    hectareas_produccion = :hectareas_produccion,
                    edito_matricula = 'SI'
                  WHERE id = :plantel_pae_id AND plantel_id = :plantel_id RETURNING *;";
                $resultado = Yii::app()->db->createCommand($sql);
            }

            $resultado->bindParam(":usuario_act_id", $usuario_act_id, PDO::PARAM_INT);
            $resultado->bindParam(":fecha_act", $fecha_act, PDO::PARAM_STR);
            $resultado->bindParam(":posee_area_cocina", $posee_area_cocina, PDO::PARAM_STR);
            $resultado->bindParam(":condicion_servicio_id", $condicion_servicio_id, PDO::PARAM_INT);
            $resultado->bindParam(":posee_area_produccion_agricola", $posee_area_produccion_agricola, PDO::PARAM_STR);
            $resultado->bindParam(":hectareas_produccion", $hectareas_produccion, PDO::PARAM_INT);
            $resultado->bindParam(":plantel_pae_id", $id, PDO::PARAM_INT);
            $resultado->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);

            Yii::app()->cache->delete("plantelPaeId$plantel_id");

            return $resultado->queryAll();
        }
        else{
            return null;
        }
    }

    public function hasPermissionToEditMatricula($edito_matricula){
        $result = false;
        $editoMatricula = $edito_matricula;
        list($fechaIniMatricula, $fechaFinMatricula) = $this->getFechasCantidadMatricula();
        $dateIniMatricula = new Datetime($fechaIniMatricula);
        $dateFinMatricula = new Datetime($fechaFinMatricula);
        $today = new Datetime('2014-09-20');

        if($editoMatricula == 'NO' && ($today >= $dateIniMatricula && $today <= $dateFinMatricula)){
            $result = true;
        }
        return $result;
    }

    public function getFechasCantidadMatricula(){
        $modelConfiguracion = $this->getFechasCantMatricula();

        $fechaIniMatricula = $modelConfiguracion[0]['valor_date'];
        $fechaFinMatricula = $modelConfiguracion[1]['valor_date'];

        return array($fechaIniMatricula, $fechaFinMatricula);
    }

    public function getFechasCantMatricula(){
       $resultado = Yii::app()->cache->get('FechasCantMatricula');

       if(!$resultado){
            $sql="select c.valor_date from sistema.configuracion c where c.nombre = 'FECHA_INI_MATRIC' OR c.nombre = 'FECHA_FIN_MATRIC' ORDER BY c.valor_date ASC";
            $consulta=Yii::app()->db->createCommand($sql);
            $resultado=$consulta->queryAll();
            Yii::app()->cache->set('FechasCantMatricula', $resultado, 86400);
       }
       return $resultado;
   }
    /**
     * Permite obtener los Datos del Plantel Beneficiario del PAE con detalle, el resultado de la consulta es guardado en cache por 3600 Seg.
     * Si los datos están aún en cache cuando se vuelva a realizar la llamada a este método se tomarán los datos de la cache y no se realizará la consulta a la Base de Datos.
     *
     * @param integer $plantelId
     * @return array Arreglo asociativo de Datos del Plantel Beneficiario del PAE.
     */
    public function getDataPlantelPae($plantelId){
        $result = null;

        $indice = "plantelPaeId$plantelId";
        $result = Yii::app()->cache->get($indice);

        if (is_numeric($plantelId) && !$result) {

            $sql = "SELECT
                        p.id,
                        p.cod_estadistico,
                        p.cod_plantel,
                        p.nombre AS nombre_plantel,
                        p.denominacion_id,
                        p.tipo_dependencia_id,
                        p.estado_id,
                        p.municipio_id,
                        p.parroquia_id,
                        p.zona_educativa_id,
                        p.modalidad_id,
                        p.clase_plantel_id,
                        pp.pae_activo,
                        pp.fecha_inicio,
                        pp.fecha_ultima_actualizacion,
                        pp.matricula_general,
                        pp.posee_simoncito,
                        pp.tipo_servicio_pae_id,
                        pp.fecha_ultima_actualizacion,
                        ts.nombre AS tipo_servicio_pae,
                        pp.matricula_pequena,
                        pp.matricula_mediana,
                        pp.matricula_grande,
                        pp.posee_area_cocina,
                        pp.condicion_servicio_id,
                        cs.nombre AS condicion_servicio_pae,
                        dn.nombre AS denominacion,
                        td.nombre AS dependencia,
                        es.co_edo_asap AS co_edo,
                        es.nombre AS estado,
                        es.capital AS estado_capital,
                        mc.co_munc_asap AS co_munc,
                        mc.nombre AS municipio,
                        mc.capital AS municipio_capital,
                        mc.in_reg AS municipio_region,
                        pr.co_prrq_asap AS co_prrq,
                        pr.nombre AS parroquia,
                        ze.nombre AS zona_educativa,
                        md.nombre AS modalidad_educativa,
                        cp.nombre AS clase_plantel
                    FROM gplantel.plantel p
                       INNER JOIN gplantel.plantel_pae pp ON p.id = pp.plantel_id
                        LEFT JOIN gplantel.denominacion dn ON p.denominacion_id = dn.id
                        LEFT JOIN gplantel.clase_plantel cp ON p.clase_plantel_id = cp.id
                        LEFT JOIN gplantel.modalidad md ON p.modalidad_id = md.id
                        LEFT JOIN gplantel.zona_educativa ze ON p.zona_educativa_id = ze.id
                        LEFT JOIN public.estado es ON p.estado_id = es.id
                        LEFT JOIN public.municipio mc ON p.municipio_id = mc.id
                        LEFT JOIN public.parroquia pr ON p.parroquia_id = pr.id
                        LEFT JOIN gplantel.tipo_dependencia td ON p.tipo_dependencia_id = td.id
                        LEFT JOIN gplantel.tipo_servicio_pae ts ON pp.tipo_servicio_pae_id = ts.id
                        LEFT JOIN gplantel.condicion_servicio cs ON pp.condicion_servicio_id = cs.id
                    WHERE p.id = :plantel_id";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam('plantel_id', $plantelId);
            $result = $command->queryRow();
            Yii::app()->cache->set($indice, $result, 3600);

        }
        return $result;
    }

    /**
     * Permite obtener los Datos del Plantel sin importar si es beneficiario del PAE o no con detalle, el resultado de la consulta es guardado en cache por 3600 Seg.
     * Si los datos están aún en cache cuando se vuelva a realizar la llamada a este método se tomarán los datos de la cache y no se realizará la consulta a la Base de Datos.
     *
     * @param integer $plantelId
     * @return array Arreglo asociativo de Datos del Plantel Beneficiario del PAE.
     */
    public function getDataPlantelSinPae($plantelId){
        $result = null;

        $indice = "plantelIdSinPae$plantelId";
        $result = Yii::app()->cache->get($indice);

        if (is_numeric($plantelId) && !$result) {

            $sql = "SELECT
                        p.id,
                        p.cod_estadistico,
                        p.cod_plantel,
                        p.nombre AS nombre_plantel,
                        p.denominacion_id,
                        p.tipo_dependencia_id,
                        p.estado_id,
                        p.municipio_id,
                        p.parroquia_id,
                        p.zona_educativa_id,
                        p.modalidad_id,
                        p.clase_plantel_id,
                        p.latitud,
                        p.longitud,
                        pp.pae_activo,
                        pp.fecha_inicio,
                        pp.fecha_ultima_actualizacion,
                        pp.matricula_general,
                        pp.posee_simoncito,
                        pp.tipo_servicio_pae_id,
                        pp.fecha_ultima_actualizacion,
                        ts.nombre AS tipo_servicio_pae,
                        pp.matricula_pequena,
                        pp.matricula_mediana,
                        pp.matricula_grande,
                        pp.posee_area_cocina,
                        pp.condicion_servicio_id,
                        cs.nombre AS condicion_servicio_pae,
                        dn.nombre AS denominacion,
                        td.nombre AS dependencia,
                        es.co_edo_asap AS co_edo,
                        es.nombre AS estado,
                        es.capital AS estado_capital,
                        mc.co_munc_asap AS co_munc,
                        mc.nombre AS municipio,
                        mc.capital AS municipio_capital,
                        mc.in_reg AS municipio_region,
                        pr.co_prrq_asap AS co_prrq,
                        pr.nombre AS parroquia,
                        ze.nombre AS zona_educativa,
                        md.nombre AS modalidad_educativa,
                        cp.nombre AS clase_plantel
                    FROM gplantel.plantel p
                        LEFT JOIN gplantel.plantel_pae pp ON p.id = pp.plantel_id
                        LEFT JOIN gplantel.denominacion dn ON p.denominacion_id = dn.id
                        LEFT JOIN gplantel.clase_plantel cp ON p.clase_plantel_id = cp.id
                        LEFT JOIN gplantel.modalidad md ON p.modalidad_id = md.id
                        LEFT JOIN gplantel.zona_educativa ze ON p.zona_educativa_id = ze.id
                        LEFT JOIN public.estado es ON p.estado_id = es.id
                        LEFT JOIN public.municipio mc ON p.municipio_id = mc.id
                        LEFT JOIN public.parroquia pr ON p.parroquia_id = pr.id
                        LEFT JOIN gplantel.tipo_dependencia td ON p.tipo_dependencia_id = td.id
                        LEFT JOIN gplantel.tipo_servicio_pae ts ON pp.tipo_servicio_pae_id = ts.id
                        LEFT JOIN gplantel.condicion_servicio cs ON pp.condicion_servicio_id = cs.id
                    WHERE p.id = :plantel_id";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam('plantel_id', $plantelId);
            $result = $command->queryRow();
            Yii::app()->cache->set($indice, $result, 3600);

        }
        return $result;
    }

    public function datosPlantelOrdenCompra($plantel_id,$mes,$anio) {
        if (is_numeric($plantel_id)) {
            $sql = "SELECT p.id as plantel_id,
                           z.id as zona_id,
                           p.nombre as plantel_nombre,
                           z.nombre as zona_nombre,
                           pv.razon_social as proveedor_nombre,
                           pv.id as proveedor_id,
                           pap.pae_activo,
                           oc.id as orden_compra,
                           e.nombre as estado,
                           m.nombre as municipio,
                           list(pi.tipo_ingesta_id::TEXT) as tipo_menu,
                           pap.tipo_servicio_pae_id as tipo_servicio,
                           pap.matricula_general as matricula_general,
                           pap.matricula_simoncito as matricula_simoncito
                    FROM gplantel.plantel p
                    LEFT JOIN gplantel.zona_educativa z ON z.id = p.zona_educativa_id
                    LEFT JOIN gplantel.plantel_proveedor pp ON pp.plantel_id = p.id
                    LEFT JOIN proveduria.proveedor pv ON pv.id = pp.proveedor_id
                    LEFT JOIN gplantel.plantel_pae pap ON pap.plantel_id = p.id
                    LEFT JOIN gplantel.plantel_ingesta pi ON pi.plantel_id = p.id
                    LEFT JOIN public.estado e ON e.id = p.estado_id
                    LEFT JOIN public.municipio m ON m.id = p.municipio_id
                    LEFT JOIN administrativo.orden_compra oc ON oc.dependencia = p.id AND oc.mes = :mes AND oc.anio = :anio
                    WHERE p.id = :plantel_id 
                    GROUP BY p.id,z.id,p.nombre,
                           z.nombre,pv.razon_social,
                           pv.id,
                           pap,
                           oc.id,
                           e.nombre,
                           m.nombre,
                            pap.pae_activo,
                           pap.tipo_servicio_pae_id,
                           pap.matricula_general,
                           pap.matricula_simoncito ";
            $consulta = Yii::app()->db->createCommand($sql);
       
            $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $consulta->bindParam(":mes", $mes, PDO::PARAM_STR);
            $consulta->bindParam(":anio", $anio, PDO::PARAM_INT);
            $resultado = $consulta->queryAll();
            return $resultado;
        } else {
            return null;
        }
    }

    public static function calcularNecesidadDeColaboradoras($matriculaGeneral, $matriculaSimoncito = 0) {
        $resultado = 0;
        if(is_numeric($matriculaGeneral) && is_numeric($matriculaSimoncito) && ($matriculaGeneral+$matriculaSimoncito)>0){
            $cantidad = ($matriculaGeneral+$matriculaSimoncito)/self::$cantidadDeAlumnosPorColaboradora;
            $resultado = ceil($cantidad);
        }
        return $resultado;
    }
    
    public static function calcularNecesidadDeCocineras($matriculaGeneral, $matriculaSimoncito = 0) {
        $resultado = 0;
        if(is_numeric($matriculaGeneral) && is_numeric($matriculaSimoncito) && ($matriculaGeneral+$matriculaSimoncito)>0){
            $cantidad = ($matriculaGeneral+$matriculaSimoncito)/self::$cantidadDeAlumnosPorColaboradora;
            $resultado = ceil($cantidad);
        }
        return $resultado;
    }

    public function beforeActivate(){
        $this->pae_activo = 'SI';
        if((is_null($this->id) && !is_numeric($this->id)) || $this->isNewRecord) {
            $this->fecha_inicio = date('Y-m-d');
            $this->fecha_ini = date('Y-m-d H:i:s');
            $this->usuario_ini_id = Yii::app()->user->id;
        }
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
        $this->fecha_ultima_actualizacion = date('Y-m-d H:i:s');
        $this->matricula_simoncito = (int)$this->matricula_maternal+(int)$this->matricula_preescolar;
        $this->matricula_pequena = (int)$this->matricula_simoncito;
        $this->matricula_mediana = (int)$this->matricula_educacion_primaria;
        $this->matricula_grande = (int)$this->matricula_educacion_media_general+(int)$this->matricula_educacion_tecnica;
        $this->matricula_general = $this->matricula_pequena+$this->matricula_mediana+$this->matricula_grande+(int)$this->matricula_educacion_especial+(int)$this->matricula_docente_obrero;
        $this->edito_matricula = 'SI';
    }

    /**
     * Este método llamará a un procedimiento almacenado donde verificará lo siguiente:
     *
     *   1.- Posee los datos generales cargados.
     *   2.- Posee Matricula PAE y el tipo de proveedor cargados, la fecha de actualización es mayor a la fecha de inicio.
     *   3.- Posee Ingestas cargadas.
     *   4.- Posee sus autoridades cargadas y verificadas (Presentó su documento de identidad al ser registrada).
     *
     * @param integer $plantelId
     */
    public function puedeObtenerComprobantePae($plantelId=null, $modulo=null){
        
        $result = null;
        $resultAsoc = null;
        
        if(is_numeric($plantelId)){
            $this->plantel_id = $plantelId;
        }
        
        if(is_null($modulo)){
            $modulo = 'registroUnico.plantelesPae.comprobante';
        }
        
        $plantel = $this->plantel_id;
        $result = array();
        $userId = Yii::app()->user->id;
        $userName = Yii::app()->user->name;
        $userIpAddress = Utiles::getRealIP();

        if(is_numeric($plantel) && strlen($modulo)>4){
            
            $sql = 'SELECT gplantel.puede_obtener_comprobante_pae(:plantel, :modulo, :userid, :username, :ipaddress) AS result';
            
            // echo "SELECT gplantel.puede_obtener_comprobante_pae($plantel, '$modulo', $userId, '$userName', '$userIpAddress') AS result";
            
            $query = Yii::app()->db->createCommand($sql);
            
            $query->bindParam(':plantel', $plantel, PDO::PARAM_INT);
            $query->bindParam(':modulo', $modulo, PDO::PARAM_INT);
            $query->bindParam(':userid', $userId, PDO::PARAM_INT);
            $query->bindParam(':username', $userName, PDO::PARAM_STR);
            $query->bindParam(':ipaddress', $userIpAddress, PDO::PARAM_STR);
            
            $queryResponse = $query->queryRow();
            $output = array();
            $result = Utiles::pgArrayParse($queryResponse['result'], $output);
            // ld($result);
            if(count($result)==1){
                $result = Utiles::fromPgArrayToPhpArray($result[0]);
                // ld($result);
            }

            if(count($result)==8){
                // ARRAY[result_v, mensaje_v, codigo_seguridad_v, origen_autoridad, cedula_autoridad::TEXT, correo_autoridad, archivo_pdf]
                $resultAsoc['codigo'] = trim($result[0]);
                $resultAsoc['mensaje'] = $result[1];
                $resultAsoc['codigo_seguridad'] = $result[2];
                $resultAsoc['origen_autoridad'] = $result[3];
                $resultAsoc['cedula_autoridad'] = $result[4];
                $resultAsoc['correo_autoridad'] = $result[5];
                $resultAsoc['fecha_vencimiento'] = $result[6];
                $resultAsoc['archivo_pdf'] = $result[7];
                $resultAsoc['url_archivo_pdf'] = Yii::app()->createUrl(str_replace('//', '/', Yii::app()->params['urlDownloadComprobanteCnae'].DIRECTORY_SEPARATOR.$resultAsoc['archivo_pdf']),array());
            }
            
        }
        
        return $resultAsoc;

    }

    public function getDataParaComprobante($cache=true, $plantelId = null){
        
        $indice = "ComprobanteCnae:$plantelId";
        $result = Yii::app()->cache->get($indice);
        $where = '';

        if(is_numeric($plantelId)){
            $where = 'WHERE p.id = :plantelId';
        }

        if (!$result || !$cache) {

            $sql = "SELECT  p.cod_plantel,
                            p.cod_estadistico,
                            p.nombre AS nombre_plantel,
                            p.annio_fundado,
                            p.cod_cnae,
                            p.codigo_ner,
                            p.registro_cnae,
                            p.direccion,
                            p.consejo_comunal,
                            d.nombre AS denominacion,
                            td.nombre AS dependencia,
                            e.nombre AS estado,
                            e.capital AS estado_capital,
                            m.nombre AS municipio,
                            m.capital AS municipio_capital,
                            z.nombre AS zona_educativa,
                            pp.pae_activo,
                            ts.nombre AS tipo_servicio_pae,
                            pr.razon_social AS razon_social_proveedor_actual,
                            pr.abreviatura AS siglas_proveedor_actual,
                            (SELECT string_agg(tm.nombre, ' | ') FROM gplantel.plantel_ingesta pi INNER JOIN nutricion.tipo_menu tm ON pi.tipo_ingesta_id = tm.id GROUP BY pi.plantel_id HAVING pi.plantel_id = p.id) AS ingestas,
                            pp.cantidad_madres_procesadoras,
                            pp.matricula_maternal,
                            pp.matricula_preescolar,
                            pp.matricula_educacion_primaria,
                            pp.matricula_educacion_media_general,
                            pp.matricula_educacion_tecnica,
                            pp.matricula_docente_obrero,
                            u.origen AS origen_director,
                            u.cedula AS cedula_director,
                            u.apellido AS apellido_director,
                            u.nombre AS nombre_director,
                            u.telefono AS telefono_director,
                            u.email AS email_director,
                            (SELECT ec.origen FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A') AS origen_enlace_cnae,
                            (SELECT ec.cedula FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A') AS cedula_enlace_cnae,
                            (SELECT ec.apellido FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A') AS apellido_enlace_cnae,
                            (SELECT ec.nombre FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A') AS nombre_enlace_cnae,
                            (SELECT ec.telefono FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A') AS telefono_enlace_cnae,
                            (SELECT ec.email FROM gplantel.autoridad_plantel ap INNER JOIN seguridad.usergroups_user ec ON ap.usuario_id = ec.id WHERE ap.plantel_id = p.id AND ap.cargo_id = 27 AND ap.estatus = 'A') AS email_enlace_cnae
                          FROM gplantel.plantel p
                            INNER JOIN gplantel.plantel_pae pp ON pp.plantel_id = p.id
                            LEFT JOIN public.estado e ON p.estado_id = e.id
                            LEFT JOIN gplantel.zona_educativa z ON p.zona_educativa_id = z.id
                            LEFT JOIN public.municipio m ON p.municipio_id = m.id
                            LEFT JOIN seguridad.usergroups_user u ON p.director_actual_id = u.id
                            LEFT JOIN gplantel.denominacion d ON p.denominacion_id = d.id
                            LEFT JOIN gplantel.tipo_dependencia td ON p.tipo_dependencia_id = td.id
                            LEFT JOIN gplantel.tipo_servicio_pae ts ON pp.tipo_servicio_pae_id = ts.id
                            LEFT JOIN proveduria.proveedor pr ON pp.proveedor_actual_id = pr.id
                         $where
                    ";
            $query = Yii::app()->db->createCommand($sql);
            
            if(is_numeric($plantelId)){
                $query->bindParam(':plantelId', $plantelId, PDO::PARAM_INT);
                $result = $query->queryRow();
            }else{
                $result = $query->queryAll();
            }

            Yii::app()->cache->set($indice, $result, 3600);
        }
        
        return $result;
        
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PlantelPae the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

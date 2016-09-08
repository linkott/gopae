<?php

/**
 * This is the model class for table "gplantel.planes_grados_asignaturas".
 *
 * The followings are the available columns in table 'gplantel.planes_grados_asignaturas':
 * @property integer $id
 * @property integer $plan_id
 * @property integer $grado_id
 * @property integer $asignatura_id
 * @property integer $modalidad_id
 * @property integer $orden
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Grado $grado
 * @property Plan $plan
 * @property Asignatura $asignatura
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class PlanesGradosAsignaturas extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.planes_grados_asignaturas';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('plan_id, grado_id, asignatura_id, modalidad_id, orden, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 20),
            array('estatus', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, plan_id, grado_id, asignatura_id, modalidad_id, orden, usuario_ini_id, usuario_act_id, fecha_ini, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'grado' => array(self::BELONGS_TO, 'Grado', 'grado_id'),
            'plan' => array(self::BELONGS_TO, 'Plan', 'plan_id'),
            'asignatura' => array(self::BELONGS_TO, 'Asignatura', 'asignatura_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'plan_id' => 'Plan',
            'grado_id' => 'Grado',
            'asignatura_id' => 'Asignatura',
            'modalidad_id' => 'Modalidad',
            'orden' => 'Orden',
            'usuario_ini_id' => 'Usuario Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_ini' => 'Fecha Ini',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('plan_id', $this->plan_id);
        $criteria->compare('grado_id', $this->grado_id);
        $criteria->compare('asignatura_id', $this->asignatura_id);
        $criteria->compare('modalidad_id', $this->modalidad_id);
        $criteria->compare('orden', $this->orden);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param integer $plan_id ID del plan al cual se le buscara los grados.
     * @return Array Devuelve un array con el grado_id y nombre del grado
     */
    public function getGradosPlan($plan_id) {
        if (is_numeric($plan_id)) {
            $sql = "SELECT distinct pag.grado_id, pag.plan_id, g.nombre"
                    . " FROM gplantel.planes_grados_asignaturas pag"
                    . " INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                    . " WHERE pag.plan_id = :plan_id"
                    . " ORDER BY nombre ASC";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);

            $resultadoGrados = $buqueda->queryAll();
            if ($resultadoGrados !== array())
                return $resultadoGrados;
            else
                return null;
        } else
            return null;
    }

    /**
     * @param integer $cod_plan CODIGO del plan al cual se le buscara los grados.
     * @return Array Devuelve un array con el grado_id y nombre del grado
     */
    public function getGradosPlanCodPlan($cod_plan) {
        if (is_numeric($cod_plan)) {
            $sql = "SELECT distinct pag.grado_id, g.nombre, p.id"
                    . " FROM gplantel.planes_grados_asignaturas pag"
                    . " INNER JOIN gplantel.plan p on (p.id = pag.plan_id)"
                    . " INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                    . " WHERE p.cod_plan = :cod_plan"
                    . " ORDER BY nombre ASC";

            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":cod_plan", $cod_plan, PDO::PARAM_INT);

            $resultadoGrados = $buqueda->queryAll();
            if ($resultadoGrados !== array())
                return $resultadoGrados;
            else
                return null;
        } else
            return null;
    }

    public function getAsignaturasGrados($grado_id, $plan_id) {
        if (is_numeric($plan_id) && is_numeric($grado_id)) {
            $sql = "SELECT distinct pag.id,pag.grado_id,"
                    . "   pag.plan_id,"
                    . "   pag.asignatura_id,"
                    . "   a.nombre,"
                    . "   pag.estatus,"
                    . "   (select g.nombre || ';' || a.nombre"
                    . "   from gplantel.asignatura_predecesor ap"
                    . "       inner join gplantel.planes_grados_asignaturas pag_ on (ap.pgrado_asignatura_id = pag.id)"
                    . "       inner join gplantel.planes_grados_asignaturas pag_a on (ap.prelacion_id = pag_a.id)"
                    . "        inner join gplantel.grado g on (g.id = pag_a.grado_id)"
                    . "       inner join gplantel.asignatura a on (a.id = pag_a.asignatura_id)"
                    . "       WHERE pag_a.plan_id = :plan_id  LIMIT 1) as prelacion"
                    . "   FROM gplantel.planes_grados_asignaturas pag"
                    . "   INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                    . "   INNER JOIN gplantel.asignatura a on (pag.asignatura_id = a.id)"
                    . "   WHERE pag.plan_id = :plan_id AND pag.grado_id = :grado_id AND pag.estatus = 'A'"
                    . "   ORDER BY pag.estatus ASC";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);
            $buqueda->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
            $resultadoAsignaturas = $buqueda->queryAll();
            if ($resultadoAsignaturas !== array())
                return $resultadoAsignaturas;
            else
                return null;
        } else
            return null;
    }

    /**
     * Permite obtener las asignaturas del grado anterior al que se va a inscribir el estudiante
     * Esta funcion se usa en la inscripción individual, cuando buscan a un estudiante y dicho estudiante posee materias pendientes.
     * Si seccion_plantel_id en el periodo_actual_id no existe  o si el valor del parametro que recibe no es numerico RETORNA NULL
     * @author Ignacio Salazar
     * @param integer $seccion_plantel_id ID de la seccion_plantel
     * @return array  Retorna un arreglo con los siguientes indices (id -> {asignatura_id}, nombre)
     */
    public function getAsignaturasSeccionPlantel($seccion_plantel_id) {
        if (is_numeric($seccion_plantel_id)) {
            $periodo_escolar_actual = PeriodoEscolar::model()->getPeriodoActivo();
            $periodo_actual_id = isset($periodo_escolar_actual) AND $periodo_escolar_actual['id'] != null AND $periodo_escolar_actual != '' ? $periodo_escolar_actual ['id'] : null;

            $sql = "SELECT distinct pag.asignatura_id as id,a.nombre,"
                    . "   from gplantel.asignatura_predecesor ap"
                    . "       inner join gplantel.planes_grados_asignaturas pag_ on (ap.pgrado_asignatura_id = pag.id)"
                    . "       inner join gplantel.planes_grados_asignaturas pag_a on (ap.prelacion_id = pag_a.id)"
                    . "        inner join gplantel.grado g on (g.id = pag_a.grado_id)"
                    . "       inner join gplantel.asignatura a on (a.id = pag_a.asignatura_id)"
                    . "       WHERE pag_a.plan_id = :plan_id  LIMIT 1) as prelacion"
                    . "   FROM gplantel.planes_grados_asignaturas pag"
                    . "   INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                    . "   INNER JOIN gplantel.asignatura a on (pag.asignatura_id = a.id)"
                    . "   WHERE pag.plan_id = :plan_id AND pag.grado_id = :grado_id"
                    . "   ORDER BY pag.estatus ASC";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);
            $buqueda->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
            $resultadoAsignaturas = $buqueda->queryAll();
            if ($resultadoAsignaturas !== array())
                return $resultadoAsignaturas;
            else
                return null;
        } else
            return null;
    }

    public function getAsignaturasAsistencia($grado_id, $plan_id, $lapso) {



        $sql = "SELECT distinct pag.id,pag.grado_id,"
                . "   pag.plan_id,"
                . "   pag.asignatura_id,"
                . "   a.nombre as asignaturas,"
                . "   pag.estatus,"
                . "   aas.total_clases,"
                . "   aas.lapso,"
                . "   (select g.nombre || ';' || a.nombre"
                . "   from gplantel.asignatura_predecesor ap"
                . "       inner join gplantel.planes_grados_asignaturas pag_ on (ap.pgrado_asignatura_id = pag.id)"
                . "       inner join gplantel.planes_grados_asignaturas pag_a on (ap.prelacion_id = pag_a.id)"
                . "        inner join gplantel.grado g on (g.id = pag_a.grado_id)"
                . "       inner join gplantel.asignatura a on (a.id = pag_a.asignatura_id)"
                . "       WHERE pag_a.plan_id = :plan_id  LIMIT 1) as prelacion"
                . "   FROM gplantel.planes_grados_asignaturas pag"
                . "   INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                . "   INNER JOIN gplantel.asignatura a on (pag.asignatura_id = a.id)"
                . "   LEFT JOIN matricula.asistencia_asignatura_seccion aas on (aas.asignatura_id = pag.asignatura_id and aas.lapso = :lapso)"
                . "   WHERE pag.plan_id = :plan_id AND pag.grado_id = :grado_id AND pag.estatus='A'"
                . "   ORDER BY a.nombre ASC";
        //cambien el order by ORDER BY pag.estatus ASC
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);
        $buqueda->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
        $buqueda->bindParam(":lapso", $lapso, PDO::PARAM_INT);

        $resultadoAsignaturas = $buqueda->queryAll();

        return new CArrayDataProvider($resultadoAsignaturas, array(
            'pagination' => array(
                'pageSize' => 15,
            )
        ));
    }

    public function getAsignaturasAsistenciaListado($grado_id, $plan_id, $lapso) {


        $sql = "SELECT distinct pag.id,pag.grado_id,"
                . "   pag.plan_id,"
                . "   pag.asignatura_id,"
                . "   a.nombre as asignaturas,"
                . "   pag.estatus,"
                . "   aas.total_clases,"
                . "   aas.lapso,"
                . "   (select g.nombre || ';' || a.nombre"
                . "   from gplantel.asignatura_predecesor ap"
                . "       inner join gplantel.planes_grados_asignaturas pag_ on (ap.pgrado_asignatura_id = pag.id)"
                . "       inner join gplantel.planes_grados_asignaturas pag_a on (ap.prelacion_id = pag_a.id)"
                . "        inner join gplantel.grado g on (g.id = pag_a.grado_id)"
                . "       inner join gplantel.asignatura a on (a.id = pag_a.asignatura_id)"
                . "       WHERE pag_a.plan_id = :plan_id LIMIT 1) as prelacion"
                . "   FROM gplantel.planes_grados_asignaturas pag"
                . "   INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                . "   INNER JOIN gplantel.asignatura a on (pag.asignatura_id = a.id and a.estatus = 'A')"
                . "   LEFT JOIN matricula.asistencia_asignatura_seccion aas on (aas.asignatura_id = pag.asignatura_id and aas.lapso = :lapso)"
                . "   WHERE pag.plan_id = :plan_id AND pag.grado_id = :grado_id AND pag.estatus='A' "
                . "   ORDER BY a.nombre ASC";

        //cambien el order by ORDER BY pag.estatus ASC
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);
        $buqueda->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
        $buqueda->bindParam(":lapso", $lapso, PDO::PARAM_INT);

        $resultadoAsignaturas = $buqueda->queryAll();

        return $resultadoAsignaturas;
    }

    public function getAsignaturasAsistenciaList($grado_id, $plan_id, $lapso) {

        $sql = "SELECT distinct pag.id,pag.grado_id,"
                . "   pag.plan_id,"
                . "   pag.asignatura_id,"
                . "   a.nombre as asignaturas,"
                . "   pag.estatus,"
                . "   aas.total_clases,"
                . "   aas.lapso,"
                . "   (select g.nombre || ';' || a.nombre"
                . "   from gplantel.asignatura_predecesor ap"
                . "       inner join gplantel.planes_grados_asignaturas pag_ on (ap.pgrado_asignatura_id = pag.id)"
                . "       inner join gplantel.planes_grados_asignaturas pag_a on (ap.prelacion_id = pag_a.id)"
                . "        inner join gplantel.grado g on (g.id = pag_a.grado_id)"
                . "       inner join gplantel.asignatura a on (a.id = pag_a.asignatura_id)"
                . "       WHERE pag_a.plan_id = :plan_id  LIMIT 1) as prelacion"
                . "   FROM gplantel.planes_grados_asignaturas pag"
                . "   INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                . "   INNER JOIN gplantel.asignatura a on (pag.asignatura_id = a.id AND pag.estatus='A')"
                . "   LEFT JOIN matricula.asistencia_asignatura_seccion aas on (aas.asignatura_id = pag.asignatura_id and aas.lapso = :lapso)"
                . "   WHERE pag.plan_id = :plan_id AND pag.grado_id = :grado_id AND pag.estatus='A'"
                . "   ORDER BY a.nombre ASC";
        //cambien el order by ORDER BY pag.estatus ASC
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);
        $buqueda->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
        $buqueda->bindParam(":lapso", $lapso, PDO::PARAM_INT);

        $resultadoAsignaturas = $buqueda->queryAll();

        return new CArrayDataProvider($resultadoAsignaturas, array(
            'pagination' => array(
                'pageSize' => 15,
            )
        ));
    }

    public function getAsignaturasAsistenciaArray($grado_id, $plan_id) {



        $sql = "SELECT distinct pag.id,pag.grado_id,"
                . "   pag.plan_id,"
                . "   pag.asignatura_id,"
                . "   a.nombre as asignaturas,"
                . "   pag.estatus,"
                . "   (select g.nombre || ';' || a.nombre"
                . "   FROM gplantel.asignatura_predecesor ap"
                . "   INNER JOIN gplantel.planes_grados_asignaturas pag_ on (ap.pgrado_asignatura_id = pag.id)"
                . "   INNER JOIN gplantel.planes_grados_asignaturas pag_a on (ap.prelacion_id = pag_a.id)"
                . "   INNER JOIN gplantel.grado g on (g.id = pag_a.grado_id)"
                . "   INNER JOIN gplantel.asignatura a on (a.id = pag_a.asignatura_id)"
                . "   WHERE pag_a.plan_id = :plan_id  LIMIT 1) as prelacion"
                . "   FROM gplantel.planes_grados_asignaturas pag"
                . "   INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                . "   INNER JOIN gplantel.asignatura a on (pag.asignatura_id = a.id AND a.estatus='A')"
                . "   WHERE pag.plan_id = :plan_id AND pag.grado_id = :grado_id AND pag.estatus='A'"
                . "   ORDER BY a.nombre ASC";
        //cambien el order by ORDER BY pag.estatus ASC
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);
        $buqueda->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
        $resultadoAsignaturas = $buqueda->queryAll();

        return $resultadoAsignaturas;
    }

    public function getAsignaturasGradosPlan($grado_id, $plan_id) {
        if (is_numeric($plan_id) && is_numeric($grado_id)) {
            $sql = "SELECT distinct"
                    . "   pag.asignatura_id"
                    . "   FROM gplantel.planes_grados_asignaturas pag"
                    . "   WHERE pag.plan_id = :plan_id AND pag.grado_id = :grado_id AND pag.estatus = 'A'"
                    . "   ORDER BY pag.asignatura_id ASC";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);
            $buqueda->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
            $resultadoAsignaturas = $buqueda->queryColumn();
            if ($resultadoAsignaturas !== array())
                return $resultadoAsignaturas;
            else
                return null;
        } else
            return null;
    }

    public function getAsignaturasGradosPlanSinEstatus($grado_id, $plan_id) {
        if (is_numeric($plan_id) && is_numeric($grado_id)) {
            $sql = "SELECT distinct"
                    . "   pag.asignatura_id"
                    . "   FROM gplantel.planes_grados_asignaturas pag"
                    . "   WHERE pag.plan_id = :plan_id AND pag.grado_id = :grado_id"
                    . "   ORDER BY pag.asignatura_id ASC";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);
            $buqueda->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
            $resultadoAsignaturas = $buqueda->queryColumn();
            if ($resultadoAsignaturas !== array())
                return $resultadoAsignaturas;
            else
                return null;
        } else
            return null;
    }

    public function getAsignaturasGradosCodPlan($grado_id, $cod_plan) {
        if (is_numeric($grado_id) && is_numeric($cod_plan)) {
            $sql = "SELECT distinct pag.grado_id, pag.plan_id,pag.asignatura_id, a.nombre, pag.estatus"
                    . " FROM gplantel.planes_grados_asignaturas pag"
                    . " INNER JOIN gplantel.plan p on (p.id = pag.plan_id)"
                    . " INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                    . " INNER JOIN gplantel.asignatura a on (pag.asignatura_id = a.id)"
                    . " WHERE p.cod_plan = :cod_plan AND pag.grado_id = :grado_id"
                    . " ORDER BY pag.estatus ASC";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":cod_plan", $cod_plan, PDO::PARAM_INT);
            $buqueda->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
            $resultadoAsignaturas = $buqueda->queryAll();
            if ($resultadoAsignaturas !== array())
                return $resultadoAsignaturas;
            else
                return null;
        } else
            return null;
    }

    /**
     * Eliminación Lógica de Asignaturas.
     *
     * @param integer $plan_id
     * @param integer $grado_id
     * @param integer $asignatura
     * @param string $accion 'A'=Activar, 'I'=Inactivar
     */
    public function cambiarEstatusAsignatura($plan_id, $grado_id, $asignatura, $accion) {

        $result = new stdClass();
        $result->isSuccess = false;
        $result->message = 'No existe la Asignatura Indicada.';
        $resultadoEliminarAP = null;

        if (in_array($accion, array('I', 'A'))) {

            if (is_numeric($plan_id) and is_numeric($grado_id) and is_numeric($asignatura)) {

                $planesGradosAsignaturas = $this->findByAttributes(array('grado_id' => $grado_id
                    , 'plan_id' => $plan_id, 'asignatura_id' => $asignatura));

                if ($planesGradosAsignaturas) {

                    $result->message = 'Ha ocurrido un error en el Proceso.';
                    if ($accion == 'I') {
                        $accion_n = 'E';
                        $planesGradosAsignaturas->estatus = $accion_n;
                    } else {
                        $planesGradosAsignaturas->estatus = $accion;
                    }

                    $planesGradosAsignaturas->usuario_act_id = Yii::app()->user->id;

                    if ($accion == 'I') {
                        $planesGradosAsignaturas->fecha_elim = date('Y-m-d H:i:s');
                    }

                    if ($planesGradosAsignaturas->update()) {

                        if ($accion == 'I') {
                            $resultadoEliminarAP = AsignaturaPredecesor::model()->eliminar($planesGradosAsignaturas->id);
                            
                        }
                        if ($resultadoEliminarAP) {
                            $messageUsers = 'El Proceso de Matriculación y Calificación con esta Asignatura ha sido ' . strtr($accion, array('A' => 're-activado.', 'I' => 'inactivado.'));
                            $result->isSuccess = true;
                            $result->message = 'Se ha ' . strtr($accion, array('A' => 'activado', 'I' => 'inactivado')) . ' la Asignatura ' . $planesGradosAsignaturas->asignatura->nombre . '. ' . $messageUsers;
                        } else if ($resultadoEliminarAP == null OR $resultadoEliminarAP == false) {
                            $result->message = 'Ha ocurrido un error en el Proceso.';
                            $result->isSuccess = false;
                        } else {
                            $messageUsers = 'El Proceso de Matriculación y Calificación con esta Asignatura ha sido ' . strtr($accion, array('A' => 're-activado.', 'I' => 'inactivado.'));
                            $result->isSuccess = true;
                            $result->message = 'Se ha ' . strtr($accion, array('A' => 'activado', 'I' => 'inactivado')) . ' la Asignatura ' . $planesGradosAsignaturas->asignatura->nombre . '. ' . $messageUsers;
                        }
                    }
                }
            }
        } else {
            $result->message = 'No se ha especificado la acción a tomar sobre la Asignatura cierre la ventana e intentelo de nuevo.';
        }

        return $result;
    }

    public function getGradoPlanSeccion($seccion_plantel_id) {

        if (is_numeric($seccion_plantel_id)) {
            $sql = "SELECT distinct pag.asignatura_id"
                    . " FROM "
                    . " gplantel.planes_grados_asignaturas pag"
                    . " INNER JOIN gplantel.plan pl on (pl.id = pag.plan_id)"
                    . " INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                    . " INNER JOIN gplantel.asignatura a on (pag.asignatura_id = a.id)"
                    . " INNER JOIN gplantel.seccion_plantel sp on (sp.grado_id = pag.grado_id AND sp.plan_id = pag.plan_id)"
                    . " WHERE sp.id = :seccion_plantel_id"
                    . " ORDER BY pag.asignatura_id ASC";
            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":seccion_plantel_id", $seccion_plantel_id, PDO::PARAM_INT);
            $resultadoPlanesAsignados = $busqueda->queryColumn();
            return $resultadoPlanesAsignados;
        } else
            return null;
    }

    public function getGrado($verificarExistenciaPlan) {

        $estatus = 'A';
        $plan_id = $verificarExistenciaPlan[0]['plan_id'];

        $sql = "SELECT distinct pag.grado_id, g.nombre"
                . " FROM gplantel.planes_grados_asignaturas pag"
                . " INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                . " WHERE pag.plan_id = :plan_id"
                . " AND g.estatus= :estatus"
                . " ORDER BY nombre ASC";
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);

        $resultadoGrados = $buqueda->queryAll();
//   var_dump($resultadoGrados); die();
        if ($resultadoGrados !== array())
            return $resultadoGrados;
        else
            return false;
    }

    /**
     * Sirve para traer datos y poder generar un dropDownList al momento de asignar planes a un plantel
     * @param integer $plantel_id ID del plantel al cual se le buscara los planes disponibles.
     * @return Array Devuelve un array con el plan_id y nombre del plan
     */
    public function getPlanesPorModalidad($plantel_id) {
        if (is_numeric($plantel_id)) {
            $sql = "SELECT distinct pag.plan_id, pl.nombre || ' [' || m.nombre ||'][' || pl.dopcion || ']'   "
                    . " FROM "
                    . " gplantel.planes_grados_asignaturas pag"
                    . " INNER JOIN gplantel.plan pl on (pl.id = pag.plan_id)"
                    . " INNER JOIN gplantel.mencion m on (pl.mencion_id = m.id)"
                    . " INNER JOIN gplantel.plantel p on (p.id = :plantel_id)"
                    //. " INNER JOIN gplantel.plantel p on (p.id = )"
                    . " WHERE p.id = :plantel_id"
                    . " ORDER BY pl.nombre || ' [' || m.nombre ||'][' || pl.dopcion || ']' ASC";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);

            $resultadoPlanes = $buqueda->queryAll();
            if ($resultadoPlanes !== array())
                return $resultadoPlanes;
            else
                return null;
        } else
            return null;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PlanesGradosAsignaturas the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

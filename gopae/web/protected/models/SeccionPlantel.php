<?php

/**
 * This is the model class for table "gplantel.seccion_plantel".
 *
 * The followings are the available columns in table 'gplantel.seccion_plantel':
 * @property integer $id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $plantel_id
 * @property integer $grado_id
 * @property integer $plan_id
 * @property integer $capacidad
 * @property integer $turno_id
 * @property integer $seccion_id
 * @property integer $nivel_id
 *
 * The followings are the available model relations:
 * @property SeccionPlantelPeriodo[] $seccionPlantelPeriodos
 * @property Nivel $nivel
 * @property Plan $plan
 * @property Grado $grado
 * @property Plantel $plantel
 * @property Turno $turno
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property SeccionPlantel $seccion
 * @property SeccionPlantel[] $seccionPlantels
 */
class SeccionPlantel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.seccion_plantel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('seccion_id, grado_id, plan_id, nivel_id, capacidad, turno_id', 'required', 'message' => 'El campo {attribute} no debe estar vacio'),
            array('plantel_id, grado_id, plan_id, capacidad, turno_id, seccion_id, nivel_id', 'numerical', 'integerOnly' => true),
            //  array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 6),
            array('estatus', 'length', 'max' => 1),
            array('capacidad', 'length', 'max' => 3),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, plantel_id, grado_id, plan_id, capacidad, turno_id, seccion_id, nivel_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'seccionPlantelPeriodos' => array(self::HAS_MANY, 'SeccionPlantelPeriodo', 'seccion_plantel_id'),
            'nivel' => array(self::BELONGS_TO, 'Nivel', 'nivel_id'),
            'plan' => array(self::BELONGS_TO, 'Plan', 'plan_id'),
            'grado' => array(self::BELONGS_TO, 'Grado', 'grado_id'),
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
            'turno' => array(self::BELONGS_TO, 'Turno', 'turno_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'seccion' => array(self::BELONGS_TO, 'Seccion', 'seccion_id'),
            'seccionPlantels' => array(self::HAS_MANY, 'SeccionPlantel', 'seccion_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'plantel_id' => 'Plantel',
            'grado_id' => 'Grado',
            'plan_id' => 'Plan',
            'capacidad' => 'Capacidad',
            'turno_id' => 'Turno',
            'seccion_id' => 'Sección',
            'nivel_id' => 'Nivel',
        );
    }

    public function validarSeccion($seccion_id) {
        $estatus = 'A';
        $sql = "SELECT id
                    FROM gplantel.seccion
                    WHERE id=:seccion_id AND estatus=:estatus";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':seccion_id', $seccion_id, PDO::PARAM_INT);
        $commandBusqueda->bindParam(':estatus', $estatus, PDO::PARAM_STR);
        $result = $commandBusqueda->execute(); //queryScalar devuelve el nombre si lo consigue si no lo encuentra devuelve false
        //  var_dump($result); die();
        return $result;
    }

    public function validarNivelPlanGrado($plantel_id, $nivel_id, $plan_id, $grado_id) {

        $estatus = 'A';
        $sql = "SELECT distinct nplantel.nivel_id, npl.plan_id, pag.grado_id"
                . " FROM "
                . " gplantel.nivel_plantel nplantel"
                . " INNER JOIN gplantel.nivel_plan npl on (nplantel.nivel_id = npl.nivel_id)"
                . " INNER JOIN gplantel.plantel p on (p.id = nplantel.plantel_id)"
                . " INNER JOIN gplantel.nivel n on (nplantel.nivel_id = n.id AND npl.nivel_id = n.id)"
                . " INNER JOIN gplantel.plan plan on (npl.plan_id = plan.id)"
                . " INNER JOIN gplantel.planes_grados_asignaturas pag on (pag.plan_id = plan.id)"
                . " INNER JOIN gplantel.grado g on (pag.grado_id = g.id)"
                . " WHERE nplantel.plantel_id = :plantel_id"
                // . " AND nplantel.nivel_id= '3'"
                . " AND n.id=:nivel_id"
                . " AND n.estatus=:estatus"
                // . " AND npl.nivel_id='3'"
                . " AND plan.id=:plan_id"
                . " AND plan.estatus=:estatus"
                // . " AND npl.plan_id= '176'"
                // . " AND pag.plan_id = '176'"
                . " AND g.estatus=:estatus"
                . " AND g.id=:grado_id";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':plantel_id', $plantel_id, PDO::PARAM_INT);
        $commandBusqueda->bindParam(':nivel_id', $nivel_id, PDO::PARAM_INT);
        $commandBusqueda->bindParam(':plan_id', $plan_id, PDO::PARAM_INT);
        $commandBusqueda->bindParam(':grado_id', $grado_id, PDO::PARAM_STR);
        $commandBusqueda->bindParam(':estatus', $estatus, PDO::PARAM_INT);
        $result = $commandBusqueda->execute(); //execute devuelve el 1 si lo consigue si no lo encuentra devuelve 0
        // var_dump($result);
        //die();
        return $result;
    }

    public function validarTurno($turno_id) {
        $estatus = 'A';
        $sql = "SELECT id
                    FROM gplantel.turno
                    WHERE id=:turno_id AND estatus=:estatus";
        $commandBusqueda = $this->getDbConnection()->createCommand($sql);
        $commandBusqueda->bindParam(':turno_id', $turno_id, PDO::PARAM_INT);
        $commandBusqueda->bindParam(':estatus', $estatus, PDO::PARAM_STR);
        $result = $commandBusqueda->execute(); //queryScalar devuelve el nombre si lo consigue si no lo encuentra devuelve false
        //   var_dump($result); die();
        return $result;
    }

    public function guardarSeccion($secciones) {

        $usuario_id = Yii::app()->user->id;
        $estatus = 'A';
        foreach ($secciones as $key => $value) {
            $sql = "INSERT INTO gplantel.seccion_plantel
                (plantel_id, usuario_ini_id,grado_id,turno_id, estatus, seccion_id, capacidad, nivel_id, plan_id)
                VALUES (:plantel_id, :usuario_ini_id, :grado_id, :turno_id, :estatus, :seccion_id, :capacidad, :nivel_id, :plan_id) returning id";
            $guard = Yii::app()->db->createCommand($sql);

            $guard->bindParam(":plantel_id", $value['plantel_id'], PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario_id, PDO::PARAM_INT);
            $guard->bindParam(":grado_id", $value['grado_id'], PDO::PARAM_INT);
            $guard->bindParam(":turno_id", $value['turno_id'], PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":seccion_id", $value['seccion_id'], PDO::PARAM_INT);
            $guard->bindParam(":capacidad", $value['capacidad'], PDO::PARAM_INT);
            $guard->bindParam(":nivel_id", $value['nivel_id'], PDO::PARAM_INT);
            $guard->bindParam(":plan_id", $value['plan_id'], PDO::PARAM_INT);
            $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando guarda
        }
        return $resulatadoGuardo;
    }

    public function actualizoSeccion($secciones) {
        $usuario_id = Yii::app()->user->id;
        $estatus = 'A';
        $fecha = date('Y-m-d H:i:s');

        foreach ($secciones as $key => $value) {
            $sql = "UPDATE gplantel.seccion_plantel
                    SET plantel_id=:plantel_id, nivel_id=:nivel_id, plan_id=:plan_id, usuario_act_id=:usuario_act_id, grado_id=:grado_id, turno_id=:turno_id, estatus=:estatus, seccion_id=:seccion_id, capacidad=:capacidad, fecha_act=:fecha_act
                    WHERE id=:id ";
            $guard = Yii::app()->db->createCommand($sql);

            $guard->bindParam(":plantel_id", $value['plantel_id'], PDO::PARAM_INT);
            $guard->bindParam(":nivel_id", $value['nivel_id'], PDO::PARAM_INT);
            $guard->bindParam(":plan_id", $value['plan_id'], PDO::PARAM_INT);
            $guard->bindParam(":usuario_act_id", $usuario_id, PDO::PARAM_INT);
            $guard->bindParam(":grado_id", $value['grado_id'], PDO::PARAM_INT);
            $guard->bindParam(":turno_id", $value['turno_id'], PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":seccion_id", $value['seccion_id'], PDO::PARAM_INT);
            $guard->bindParam(":capacidad", $value['capacidad'], PDO::PARAM_INT);
            $guard->bindParam(":fecha_act", $fecha, PDO::PARAM_INT);
            $guard->bindParam(":id", $value['id'], PDO::PARAM_INT);
            $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando guarda
        }
        return $resulatadoGuardo;
    }

    public function eliminarSeccion($seccionId) {

        $usuario_id = Yii::app()->user->id;
        $estatus = 'E';
        $fecha = date('Y-m-d H:i:s');

        $sql = "UPDATE gplantel.seccion_plantel
                    SET estatus=:estatus, fecha_elim=:fecha_elim, usuario_act_id=:usuario_act_id
                    WHERE id=:id ";
        $guard = Yii::app()->db->createCommand($sql);

        $guard->bindParam(":usuario_act_id", $usuario_id, PDO::PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $guard->bindParam(":fecha_elim", $fecha, PDO::PARAM_INT);
        $guard->bindParam(":id", $seccionId, PDO::PARAM_INT);
        $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando guarda

        return $resulatadoGuardo;
    }

    public function validacionSeccion($secciones) {
        // var_dump($secciones);
        $estatus = 'A';

        if ($secciones != array()) {
            // var_dump($secciones);
            foreach ($secciones as $key => $value) {
                $sql = "SELECT *
                    FROM gplantel.seccion_plantel
                    WHERE plantel_id=:plantel_id AND grado_id=:grado_id AND turno_id=:turno_id AND estatus=:estatus AND seccion_id=:seccion_id AND nivel_id=:nivel_id AND plan_id=:plan_id";
                $guard = Yii::app()->db->createCommand($sql);

                $guard->bindParam(":plantel_id", $value['plantel_id'], PDO::PARAM_INT);
                $guard->bindParam(":grado_id", $value['grado_id'], PDO::PARAM_INT);
                $guard->bindParam(":turno_id", $value['turno_id'], PDO::PARAM_INT);
                $guard->bindParam(":nivel_id", $value['nivel_id'], PDO::PARAM_INT);
                $guard->bindParam(":plan_id", $value['plan_id'], PDO::PARAM_INT);
                $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
                $guard->bindParam(":seccion_id", $value['seccion_id'], PDO::PARAM_INT);
                $resulatadoGuardo = $guard->queryAll(); //devuelve un array con los id de los registros que existen, sino devuelve un array vacio.
                //  var_dump($resulatadoGuardo);
            }
            //var_dump($resulatadoGuardo);
            return $resulatadoGuardo;
        }
    }

    public function validacionUnicoGradoSeccion($secciones) {
        // var_dump($secciones);
        $estatus = 'A';
        foreach ($secciones as $key => $value) {
            $sql = "SELECT *
                    FROM gplantel.seccion_plantel
                    WHERE plantel_id=:plantel_id AND nivel_id=:nivel_id AND plan_id=:plan_id AND grado_id=:grado_id AND estatus=:estatus AND seccion_id=:seccion_id";
            $guard = Yii::app()->db->createCommand($sql);

            $guard->bindParam(":plantel_id", $value['plantel_id'], PDO::PARAM_INT);
            $guard->bindParam(":nivel_id", $value['nivel_id'], PDO::PARAM_INT);
            $guard->bindParam(":plan_id", $value['plan_id'], PDO::PARAM_INT);
            $guard->bindParam(":grado_id", $value['grado_id'], PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":seccion_id", $value['seccion_id'], PDO::PARAM_INT);
            $resulatadoGuardo = $guard->queryAll(); //devuelve un array con los id de los registros que existen, sino devuelve un array vacio.
            //  var_dump($resulatadoGuardo);
        }
        //var_dump($resulatadoGuardo);
        return $resulatadoGuardo;
    }

    public function validacionUniqueGradoSeccionTurno($secciones) {
        // var_dump($secciones);
        $estatus = 'A';
        foreach ($secciones as $key => $value) {
            $sql = "SELECT id
                    FROM gplantel.seccion_plantel
                    WHERE plantel_id=:plantel_id  AND grado_id=:grado_id AND turno_id=:turno_id AND estatus=:estatus AND seccion_id=:seccion_id";
            $guard = Yii::app()->db->createCommand($sql);

            $guard->bindParam(":plantel_id", $value['plantel_id'], PDO::PARAM_INT);
            $guard->bindParam(":grado_id", $value['grado_id'], PDO::PARAM_INT);
            $guard->bindParam(":turno_id", $value['turno_id'], PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":seccion_id", $value['seccion_id'], PDO::PARAM_INT);
            $resulatadoGuardo = $guard->queryAll(); //devuelve un array con los id de los registros que existen, sino devuelve un array vacio.
            //  var_dump($resulatadoGuardo);
        }
        //var_dump($resulatadoGuardo);
        return $resulatadoGuardo;
    }

    /* Ignacio */

    public function obtenerDatosSeccion($seccion, $plantel_id) {
        $sql = "SELECT s.nombre seccion, g.nombre grado, g.id, p.nombre plan_estudio, p.cod_plan,"
                . "(select count(ie.id) FROM matricula.inscripcion_estudiante ie"
                . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.id = ie.seccion_plantel_periodo_id)"
                . " INNER JOIN gplantel.seccion_plantel spi on (spi.id = spp.seccion_plantel_id)"
                . " WHERE spi.id =:seccion_plantel_id AND spi.plantel_id =:plantel_id )AS cant_estudiantes"
                . " FROM gplantel.seccion_plantel sp"
                . " INNER JOIN gplantel.seccion s ON (s.id = sp.seccion_id)"
                . " INNER JOIN gplantel.grado g ON (g.id = sp.grado_id)"
                . " INNER JOIN gplantel.plan p ON (p.id = sp.plan_id)"
                . " WHERE sp.plantel_id = :plantel_id AND sp.id = :seccion_plantel_id";
        $busqueda = Yii::app()->db->createCommand($sql);
        $busqueda->bindParam(":seccion_plantel_id", $seccion, PDO::PARAM_INT);
        $busqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_STR);
        $resulatadoBusqueda = $busqueda->queryRow();
        if ($resulatadoBusqueda !== array())
            return $resulatadoBusqueda;
        else
            return false;
    }

    public function cargarDetallesSeccion($seccion, $plantel_id) {
        $sql = "SELECT s.nombre as seccion, n.nombre as nivel, p.nombre as plan, g.nombre as grado, t.nombre as turno, sp.capacidad as capacidad, p.id as plan_id, sp.id as seccion_id, g.id as grado_id"
                . " FROM gplantel.seccion_plantel sp"
                . " INNER JOIN gplantel.seccion s ON (s.id = sp.seccion_id)"
                . " INNER JOIN gplantel.grado g ON (g.id = sp.grado_id)"
                . " INNER JOIN gplantel.nivel n ON (n.id = sp.nivel_id)"
                . " INNER JOIN gplantel.plan p ON (p.id = sp.plan_id)"
                . " INNER JOIN gplantel.turno t ON (t.id = sp.turno_id)"
                . " WHERE sp.plantel_id = :plantel_id AND sp.id =:seccion_plantel_id";
        $busqueda = Yii::app()->db->createCommand($sql);
        $busqueda->bindParam(":seccion_plantel_id", $seccion, PDO::PARAM_INT);
        $busqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_STR);
        $resulatadoBusqueda = $busqueda->queryAll();
        if ($resulatadoBusqueda !== array())
            return $resulatadoBusqueda;
        else
            return false;
    }

    /*  fin */

    /* LLENO LOS DROPDOWNLIST (PLAN Y NIVEL) DEL INDEX DE SECCION PLANTEL */

    public function llenarDropDown_plan_id($plantel_id) {

        $estatus = 'A';
        $sql = "SELECT DISTINCT npl.plan_id, p.nombre || ' [' || m.nombre ||'][' || p.dopcion || ']' as nombre, p.nombre as nombrePlan"
                . " FROM "
                . " gplantel.nivel_plan npl"
                . " INNER JOIN gplantel.nivel n on (npl.nivel_id = n.id)"
                . " INNER JOIN gplantel.nivel_plantel np on (np.nivel_id = n.id)"
                . " INNER JOIN gplantel.plan p on (npl.plan_id = p.id)"
                . " LEFT JOIN gplantel.mencion m on (p.mencion_id = m.id)"
                . " WHERE np.plantel_id IN ($plantel_id)"
                . " AND p.estatus= :estatus"
                . " ORDER BY npl.plan_id ASC";
        $busqueda = Yii::app()->db->createCommand($sql);
        $busqueda->bindParam(":estatus", $estatus, PDO::PARAM_INT);
        $resultado = $busqueda->queryAll();
        $result = array();
        $resulta = array();
        foreach ($resultado as $r) {
            $nom = $r['nombre'];
            $nomPlan = $r['nombreplan'];
            $plan_id = $r['plan_id'];

            if ($nom == null) {
                $result = $nomPlan;
            } else {
                $result = $nom;
            }
            $resulta [] = array(
                'nombre' => $result,
                'plan_id' => $plan_id
            );
        }
        //  var_dump($resulta);
        //die()

        return $resulta;
    }

    public function llenarDropDown_nivel_id($plantel_id) {

        $estatus = 'A';
        $sql = "SELECT DISTINCT nplantel.nivel_id, n.nombre"
                . " FROM "
                . " gplantel.nivel_plantel nplantel"
                . " INNER JOIN gplantel.plantel p on (p.id = nplantel.plantel_id)"
                . " INNER JOIN gplantel.modalidad_nivel mn on (p.modalidad_id = mn.modalidad_id AND nplantel.nivel_id = mn.nivel_id)"
                . " INNER JOIN gplantel.nivel n on (nplantel.nivel_id = n.id)"
                . " WHERE nplantel.plantel_id = :plantel_id"
                . " AND n.estatus= :estatus"
                . " ORDER BY nplantel.nivel_id ASC";
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_INT);
        $resultadoNiveles = $buqueda->queryAll();
        return $resultadoNiveles;
    }

    /* FIN */

    public function listaEstudiantesInscriptosEnSeccion($seccionId) {

        $estatus = 'A';
        $sql = "SELECT  e.cedula_escolar, e.fecha_nacimiento, e.nombres || ' ' || e.apellidos as nomApe, r.cedula_identidad"
                . " FROM"
                . " gplantel.seccion_plantel sp"
                . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.seccion_plantel_id = sp.id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (spp.id = ie.seccion_plantel_periodo_id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " LEFT JOIN matricula.representante r on (r.id = e.representante_id)"
                . " WHERE spp.seccion_plantel_id = :seccion_plantel_id"
                . " AND ie.estatus= :estatus"
                . " ORDER BY ie.id DESC";
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":seccion_plantel_id", $seccionId, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $resultado = $buqueda->queryAll();
        //   var_dump($resultado); die();
        return $resultado;
    }

    public function existeEstudiantesInscriptosEnSeccion($seccionId) {
        /* Modificar para que traiga la cedula escolar o pasaporte o cedula */
        $estatus = 'A';
        $sql = "SELECT  e.id,COALESCE(e.cedula_identidad, e.cedula_escolar ) as cedula_escolar, e.fecha_nacimiento, e.nombres || ' ' || e.apellidos as nomApe, r.cedula_identidad"
                . " FROM"
                . " gplantel.seccion_plantel sp"
                . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.seccion_plantel_id = sp.id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (spp.id = ie.seccion_plantel_periodo_id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " LEFT JOIN matricula.representante r on (r.id = e.representante_id)"
                . " WHERE spp.seccion_plantel_id = :seccion_plantel_id"
                . " AND ie.estatus= :estatus"
                . " ORDER BY ie.id DESC";
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":seccion_plantel_id", $seccionId, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $resultado = $buqueda->queryAll();
        //   var_dump($resultado); die();


        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 15,
            )
        ));
    }

    public function existeEstudiantesInscritosIndividualEnSeccion($seccionId) {
        /* Modificar para que traiga la cedula escolar o pasaporte o cedula */
        $estatus = 'A';
        $sql = "SELECT  e.id,e.cedula_identidad, e.cedula_escolar, e.fecha_nacimiento, e.nombres || ' ' || e.apellidos as nomApe, ie.estatus, ie.id as inscripcion_id"
                . " FROM"
                . " gplantel.seccion_plantel sp"
                . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.seccion_plantel_id = sp.id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (spp.id = ie.seccion_plantel_periodo_id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " LEFT JOIN matricula.representante r on (r.id = e.representante_id)"
                . " WHERE spp.seccion_plantel_id = :seccion_plantel_id"
                . " AND ie.estatus= :estatus"
                . " ORDER BY ie.id DESC";
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":seccion_plantel_id", $seccionId, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $resultado = $buqueda->queryAll();
        //   var_dump($resultado); die();


        return new CArrayDataProvider($resultado, array(
            'sort' => array(
                'defaultOrder' => 'cedula_identidad ASC',
            ),
            'pagination' => array(
                'pageSize' => 15,
            )
        ));
    }

    public function existeEstudiantesInscritosEnSeccion($seccionId) {

        $estatus = 'A';
        $sql = "SELECT  count(e.id)"
                . " FROM"
                . " gplantel.seccion_plantel sp"
                . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.seccion_plantel_id = sp.id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (spp.id = ie.seccion_plantel_periodo_id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " LEFT JOIN matricula.representante r on (r.id = e.representante_id)"
                . " WHERE spp.seccion_plantel_id = :seccion_plantel_id"
                . " AND ie.estatus= :estatus"
                . " GROUP BY e.id";
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":seccion_plantel_id", $seccionId, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $resultado = $buqueda->queryScalar();
        //   var_dump($resultado); die();


        return $resultado;
    }

    public function calcularInscritosPorSeccion($seccionId) {


        $sql = "SELECT  count(distinct e.id)"
                . " FROM gplantel.seccion_plantel sp"
                . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.seccion_plantel_id = sp.id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (spp.id = ie.seccion_plantel_periodo_id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " LEFT JOIN matricula.representante r on (r.id = e.representante_id)"
                . " WHERE spp.seccion_plantel_id=:seccion_plantel_id";
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":seccion_plantel_id", $seccionId, PDO::PARAM_INT);

        $resultado = $buqueda->queryRow();
        //   var_dump($resultado); die();
        return $resultado;
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
    public function search($plantel_id) {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        //  $criteria->compare('estatus', $this->estatus, true);
        // $criteria->compare('plan_id', $this->plan_id);
        // $criteria->compare('nivel_id', $this->nivel_id);

        if (is_numeric($this->plan_id)) {
            if (strlen($this->plan_id) < 7) {
                $criteria->compare('plan_id', $this->plan_id);
            }
        }

        if (is_numeric($this->nivel_id)) {
            if (strlen($this->nivel_id) < 7) {
                $criteria->compare('nivel_id', $this->nivel_id);
            }
        }

        if ($this->estatus === 'A' || $this->estatus === 'E') {
            $criteria->compare('estatus', $this->estatus);
        }

        $criteria->compare('plantel_id', $plantel_id); // filtro que los registro que muestro sean del plantel que se selecciono.

        if (is_numeric($this->grado_id)) {
            if (strlen($this->grado_id) < 7) {
                $criteria->compare('grado_id', $this->grado_id);
            }
        }

        if (is_numeric($this->capacidad)) {
            if (strlen($this->capacidad) <= 3) {
                $criteria->compare('to_char( t.capacidad,\'999\' )', $this->capacidad, true);
                // $criteria->addSearchCondition('capacidad', '%' . $this->capacidad . '%', false, 'AND', 'ILIKE');
            }
        }

        if (is_numeric($this->turno_id)) {
            if (strlen($this->turno_id) < 7) {
                $criteria->compare('turno_id', $this->turno_id);
            }
        }

        if (is_numeric($this->seccion_id)) {
            if (strlen($this->seccion_id) < 7) {
                $criteria->compare('seccion_id', $this->seccion_id);
            }
        }
        $sort = new CSort();
        $sort->defaultOrder = 'estatus ASC, fecha_ini DESC';
        //Va a ordenar la tabla utilizando el campo id_representacion en forma descendente "DESC",

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => 10
            ),
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeccionPlantel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

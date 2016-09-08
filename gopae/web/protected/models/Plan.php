<?php

/**
 * This is the model class for table "gplantel.plan".
 *
 * The followings are the available columns in table 'gplantel.plan':
 * @property integer $id
 * @property string $nombre
 * @property integer $cod_plan
 * @property integer $mencion_id
 * @property integer $credencial_id
 * @property integer $fund_juridico_id
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property string $dopcion
 * @property integer $nivel_id
 * @property integer $tipo_documento_id
 *
 * The followings are the available model relations:
 * @property Credencial $credencial
 * @property Mencion $mencion
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property TipoDocumento $tipoDocumento
 * @property PlanesGradosAsignaturas[] $planesGradosAsignaturases
 * @property NivelPlan[] $nivelPlans
 */
class Plan extends CActiveRecord {

    public $nivel_id, $dopcion;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.plan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('nombre, credencial_id,nivel_id,fund_juridico_id, cod_plan,tipo_documento_id', 'required', 'on' => 'crear', 'message' => 'El campo {attribute} no debe estar vacio'),
            array('nombre, credencial_id,fund_juridico_id, cod_plan,tipo_documento_id', 'required', 'on' => 'modificar', 'message' => 'El campo {attribute} no debe estar vacio'),
            array('cod_plan, mencion_id, tipo_documento_id, credencial_id, fund_juridico_id, nivel_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 100),
            array('cod_plan', 'unique', 'on' => 'crear'),
            array('cod_plan', 'validarCodPlan', 'on' => 'crear'),
            array('nivel_id', 'validarGradosNivel', 'on' => 'crear'),
            array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 19),
            array('estatus', 'length', 'max' => 1),
            // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
            array('id, nombre, cod_plan, tipo_documento_id, mencion_id, credencial_id, fund_juridico_id, usuario_ini_id, usuario_act_id, fecha_ini, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return boolean Verdadero si posee 5 digitos sino Falso.
     */
    public function validarCodPlan() {

        if ($this->cod_plan !== '' && $this->cod_plan !== null) {
            $primer_digito = substr($this->cod_plan, 0, 1);
            if (strlen($this->cod_plan) !== 5 && strlen($this->cod_plan) !== 8) {
                $this->addError('cod_plan', 'El Código del Plan debe poseer 5 digitos u 8 digitos.');
            }
            if ($primer_digito == 0) {
                $this->addError('cod_plan', 'El Código del Plan no puede comenzar con (cero).');
            }
        }
    }

    /**
     * @return boolean Verdadero el nivel posee grados asociados.
     */
    public function validarGradosNivel() {
        if ($this->nivel_id !== null && $this->nivel_id !== '')
            if (is_numeric($this->nivel_id)) {

                $sql = "SELECT COUNT(id) FROM gplantel.nivel_grado"
                        . " WHERE nivel_id = :nivel_id";
                $busqueda = Yii::app()->db->createCommand($sql);
                $busqueda->bindParam(":nivel_id", $this->nivel_id, PDO::PARAM_INT);

                $cant_grados = $busqueda->queryScalar();
                if (!$cant_grados > 0) {
                    $this->addError('nivel_id', 'El Nivel que ha seleccionado no posee Grados asociados.');
                }
            } else {
                $this->addError('nivel_id', 'El Nivel que ha seleccionado no posee el formato correcto.');
            }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'seccionPlantels' => array(self::HAS_MANY, 'SeccionPlantel', 'plan_id'),
            'planesGradosAsignaturases' => array(self::HAS_MANY, 'PlanesGradosAsignaturas', 'plan_id'),
            'credencial' => array(self::BELONGS_TO, 'Credencial', 'credencial_id'),
            'mencion' => array(self::BELONGS_TO, 'Mencion', 'mencion_id'),
            'tipoDocumento' => array(self::BELONGS_TO, 'TipoDocumento', 'tipo_documento_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'nivelPlans' => array(self::HAS_MANY, 'NivelPlan', 'plan_id'),
        );
    }

    public function getGradosPlan($id) {
        $resultado = null;
        $sql = "SELECT "
                . " g.id as grado_id, p.id as plan_id, g.nombre, "
                . " (SELECT count(asignatura_id) from gplantel.planes_grados_asignaturas pag where pag.plan_id = :plan_id and pag.grado_id = g.id) as cantidad_asignaturas"
                . " FROM gplantel.plan p"
                . " INNER JOIN gplantel.nivel_plan np on (np.plan_id = p.id)"
                . " INNER JOIN gplantel.nivel_grado ng on (ng.nivel_id = np.nivel_id)"
                . " INNER JOIN gplantel.grado g on (g.id = ng.grado_id)"
                . " WHERE p.id = :plan_id"
                . " ORDER BY p.nombre ASC";

        $busqueda = Yii::app()->db->createCommand($sql);
        $busqueda->bindParam(":plan_id", $id, PDO::PARAM_INT);
        $resultado = $busqueda->queryAll();
        return $resultado;
    }

    protected function afterSave() {
        $usuario = Yii::app()->user->id;
        $fecha = date('Y-m-d H:i:s');
//        parent::afterSave();
//        //if ($this->isNewRecord) {
//        $nivelPlan = new NivelPlan();
//        $nivelPlan->nivel_id = $this->nivel_id;
//        $nivelPlan->plan_id = $this->id;
//        $nivelPlan->usuario_ini_id = $this->usuario_ini_id;
//        $nivelPlan->fecha_ini = $this->fecha_ini;
//        $nivelPlan->estatus = 'A';
//        $nivelPlan->isNewRecord = false;
//        $nivelPlan->save(false);
//        //        } else {
////
////        }
        if ($this->isNewRecord) {
            $nivelPlan = new NivelPlan();
            $nivelPlan->nivel_id = $this->nivel_id;
            $nivelPlan->plan_id = $this->id;
            $nivelPlan->usuario_ini_id = $this->usuario_ini_id;
            $nivelPlan->fecha_ini = $this->fecha_ini;
            $nivelPlan->estatus = 'A';
            $nivelPlan->save(false);
        }
        
        parent::afterSave();
    }

    public function getDatosPlan($plan_id) {
        $criteria = new CDbCriteria;
        $criteria->alias = "p";
        $criteria->with = array(
            "credencial" => array("select" => "nombre"),
            "mencion" => array("select" => "nombre"),
        );
        $criteria->addCondition("p.id = :id");
        $criteria->params = array('id' => $plan_id);
        return $this->find($criteria);
    }

    public function getDatosPlanes($plan_ids) {
        if (is_array($plan_ids)) {
            $planesString = implode(',', $plan_ids);
            $sql = "SELECT DISTINCT p.id as id, p.cod_plan || ' - ' || p.nombre || ' [' || m.nombre ||'][' || p.dopcion || ']' as nombre"
                    . " FROM "
                    . " gplantel.plan p"
                    . " LEFT JOIN gplantel.mencion m on (p.mencion_id = m.id)"
                    . " WHERE p.id IN ($planesString)"
                    . " ORDER BY nombre ASC";

            $busqueda = Yii::app()->db->createCommand($sql);

            $resultadoPlanes = $busqueda->queryAll();
            if ($resultadoPlanes !== array())
                return $resultadoPlanes;
            else
                return array();
        } else
            return array();
    }

    public function getPlanSeccionPlantel($plantel_id, $seccion_plantel_id) {

        if (is_numeric($plantel_id)) {
            $sql = "SELECT p.cod_plan, p.id, n.permite_materia_pendiente"
                    . " FROM "
                    . " gplantel.plan p"
                    . " INNER JOIN gplantel.seccion_plantel sp on (p.id = sp.plan_id)"
                    . " INNER JOIN gplantel.nivel n on (n.id= sp.nivel_id)"
                    . " WHERE sp.plantel_id = :plantel_id AND sp.id = :seccion_plantel_id";
            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $busqueda->bindParam(":seccion_plantel_id", $seccion_plantel_id, PDO::PARAM_INT);

            $resultadoPlanesAsignados = $busqueda->queryScalar();
            return $resultadoPlanesAsignados;
        } else
            return null;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'cod_plan' => 'Código del Plan',
            'mencion_id' => 'Mención',
            'credencial_id' => 'Credencial',
            'fund_juridico_id' => 'Fundamento Juridico',
            'usuario_ini_id' => 'Usuario Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_ini' => 'Fecha Ini',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'nivel_id' => 'Nivel',
            'tipo_documento_id' => 'Documento que Otorga'
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
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('cod_plan', $this->cod_plan);
        $criteria->compare('mencion_id', $this->mencion_id);
        $criteria->compare('credencial_id', $this->credencial_id);
        $criteria->compare('fund_juridico_id', $this->fund_juridico_id);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('tipo_documento_id', $this->tipo_documento_id, true);

        $criteria->order = "nombre ASC, estatus ASC";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
        ));
    }

    public function searchPlanDisponiblesNivel($nivel_id) {
// @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;


        if (is_numeric($nivel_id)) {
            $criteria->condition = " t.id NOT IN (SELECT plan_id FROM gplantel.nivel_plan n WHERE n.nivel_id = $nivel_id)";
        }

        $criteria->compare('t.id', $this->id);
        $criteria->addSearchCondition('t.nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');

        $criteria->addSearchCondition("TO_CHAR(t.cod_plan, 'FM999999999999999999')", $this->cod_plan . '%', false, 'AND', 'ILIKE');

        $criteria->join .= 'LEFT JOIN gplantel.mencion m on m.id = t.mencion_id ';
        $criteria->compare('t.mencion_id', $this->mencion_id);
        $criteria->compare('t.credencial_id', $this->credencial_id);
        $criteria->compare('t.fund_juridico_id', $this->fund_juridico_id);
        $criteria->compare('t.usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('t.usuario_act_id', $this->usuario_act_id);
        $criteria->compare('t.fecha_ini', $this->fecha_ini, true);
        $criteria->compare('t.fecha_act', $this->fecha_act, true);
        $criteria->compare('t.fecha_elim', $this->fecha_elim, true);
        $criteria->compare('t.estatus', $this->estatus, true);
        $criteria->compare('t.tipo_documento_id', $this->tipo_documento_id, true);
        $criteria->order = "t.fecha_ini asc, t.fecha_act desc, t.cod_plan asc";
//        $criteria->select=array(
//            't.nombre',
//            't.credencial_id',
//            't.fund_juridico_id',
//            't.usuario_ini_id',
//            't.usuario_act_id',
//            't.mencion_id',
//            't.fecha_ini',
//            't.fecha_act',
//            't.fecha_elim',
//            't.estatus',
//            't.tipo_documento_id',
//            't.cod_plan',
//            't.id',
//            'm.nombre as mencion'
//            );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Plan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

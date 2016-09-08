<?php

/**
 * This is the model class for table "gplantel.plan_plantel".
 *
 * The followings are the available columns in table 'gplantel.plan_plantel':
 * @property string $id
 * @property integer $plantel_id
 * @property integer $plan_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property string $plan 
 * @property string $mencion
 * @property string $credencial
 * @property string $fund_juridico 
 * @property integer $cod_plan 
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class PlanPlantel extends CActiveRecord {

    public $fund_juridico;
    public $plan;
    public $mencion;
    public $credencial;
    public $cod_plan;

    public function tableName() {
        return 'gplantel.plan_plantel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('plantel_id, plan_id', 'required', 'message' => 'El Campo {attribute} No Debe Estar Vacio', 'on' => 'asignarPlan'),
            array('plantel_id, plan_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 6),
            array('estatus', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, plantel_id, plan_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
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
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'planteles' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
            'planes' => array(self::BELONGS_TO, 'Plan', 'plan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'plantel_id' => 'Plantel',
            'plan_id' => 'Plan de Estudio',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'plan' => 'Plan de Estudio',
            'credencial_id' => 'Credencial',
            'mencion_id' => 'Mencion'
        );
    }

    public function getPlanesDisponibles($planes_niveles_plantel) {
        if (is_array($planes_niveles_plantel)) {
            $planes_niveles_plantelString = implode(',', $planes_niveles_plantel);
            $sql = "SELECT DISTINCT pl.id, pl.nombre || ' [' || m.nombre ||'][' || pl.dopcion || ']' as nombre"
                    . " FROM "
                    . " gplantel.plan_plantel pp"
                    . " INNER JOIN gplantel.plan pl on (pl.id = pp.plan_id)"
                    . " INNER JOIN gplantel.mencion m on (pl.mencion_id = m.id)"
                    . " WHERE pp.plan_id NOT IN ($planes_niveles_plantelString)"
                    . " ORDER BY nombre ASC";
            $busqueda = Yii::app()->db->createCommand($sql);
            //$busqueda->bindParam(":niveles_plantel", $niveles_plantel, PDO::PARAM_LOB);

            $resultadoPlanesDispPlantel = $busqueda->queryAll();
            if ($resultadoPlanesDispPlantel !== array())
                return $resultadoPlanesDispPlantel;
            else
                return false;
        } else
            return null;
    }

    public function getPlanesAsignados($plantel_id) {

        if (is_numeric($plantel_id)) {
            $sql = "SELECT DISTINCT pp.plan_id"
                    . " FROM "
                    . " gplantel.plan_plantel pp"
                    . " INNER JOIN gplantel.plan pl on (pl.id = pp.plan_id)"
                    . " WHERE pp.plantel_id = :plantel_id"
                    . " ORDER BY pp.plan_id ASC";
            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);

            $resultadoPlanesAsignados = $busqueda->queryColumn();
            return $resultadoPlanesAsignados;
        } else
            return null;
    }

   

    /**
     * Eliminación Lógica de Planes de Estudios.
     * 
     * @param integer $id
     * @param string $accion 'A'=Activar, 'E'=Inactivar
     */
    public function cambiarEstatusPlanPlantel($id, $accion) {

        $result = new stdClass();
        $result->isSuccess = false;
        $result->message = 'No existe el Plan de Estudio Indicado.';

        if (in_array($accion, array('E', 'A'))) {

            if (is_numeric($id)) {

                $plan = $this->findByPk($id);

                if ($plan) {

                    $result->message = 'Ha ocurrido un error en el Proceso.';

                    $plan->estatus = $accion;
                    $plan->usuario_act_id = Yii::app()->user->id;

                    if ($accion == 'E') {
                        $plan->fecha_elim = date('Y-m-d H:i:s');
                    }

                    if ($plan->update()) {

                        $messageUsers = 'El Proceso de Matriculación con este Plan de Estudio ha sido ' . strtr($accion, array('A' => 're-activado.', 'E' => 'inactivado.'));
                        $result->isSuccess = true;
                        $result->message = 'Se ha ' . strtr($accion, array('A' => 'activado', 'E' => 'inactivado')) . ' el Plan de Estudio ' . $plan->planes->nombre . '. ' . $messageUsers;
                    }
                }
            }
        } else {
            $result->message = 'No se ha especificado la acción a tomar sobre el Plan de Estudio, recargue la página e intentelo de nuevo.';
        }

        return $result;
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
        $criteria->alias = "p_p";

        $criteria->join .= " INNER JOIN gplantel.plantel p ON (p.id = p_p.plantel_id)";
        $criteria->join .= " INNER JOIN gplantel.plan pl ON (p_p.plan_id = pl.id)";
        $criteria->join .= " LEFT JOIN gplantel.mencion m ON (m.id = pl.mencion_id)";
        $criteria->join .= " LEFT JOIN gplantel.credencial c ON (c.id = pl.credencial_id)";
        $criteria->join .= " LEFT JOIN gplantel.fundamento_juridico f_j ON (f_j.id = pl.fund_juridico_id)";

        /* VALIDACIONES */

        if (is_numeric($this->cod_plan))
            $criteria->compare('cod_plan', $this->cod_plan);

        if ($this->plan !== '' && $this->plan !== null)
            $criteria->addSearchCondition('pl.nombre', '%' . $this->plan . '%', false, 'AND', 'ILIKE');

        if ($this->mencion !== '' && $this->mencion !== null)
            $criteria->addSearchCondition('m.nombre', '%' . $this->mencion . '%', false, 'AND', 'ILIKE');

        if ($this->credencial !== '' && $this->credencial !== null)
            $criteria->addSearchCondition('c.nombre', '%' . $this->credencial . '%', false, 'AND', 'ILIKE');

        if ($this->fund_juridico !== '' && $this->fund_juridico !== null)
            $criteria->addSearchCondition('f_j.nombre', '%' . $this->fund_juridico . '%', false, 'AND', 'ILIKE');

        if (is_string($this->estatus) && strlen($this->estatus) == 1)
            $criteria->compare('p_p.estatus', $this->estatus, true);

        /* FIN VALIDACIONES */

        $criteria->compare('plantel_id', $this->plantel_id);
        //$criteria->compare('plan_id', $this->plan_id);
        //$criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        //$criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->order = "p_p.estatus ASC";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PlanPlantel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

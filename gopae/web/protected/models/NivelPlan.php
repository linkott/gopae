<?php

/**
 * This is the model class for table "gplantel.nivel_plan".
 *
 * The followings are the available columns in table 'gplantel.nivel_plan':
 * @property integer $id
 * @property integer $nivel_id
 * @property integer $plan_id
 *
 * The followings are the available model relations:
 * @property Nivel $nivel
 */
class NivelPlan extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.nivel_plan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nivel_id, plan_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nivel_id, plan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'nivel' => array(self::BELONGS_TO, 'Nivel', 'nivel_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nivel_id' => 'Nivel',
            'plan_id' => 'Plan',
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
        $criteria->compare('nivel_id', $this->nivel_id);
        $criteria->compare('plan_id', $this->plan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getPlanesNivelPlantel($niveles_plantel) {
        if (is_array($niveles_plantel)) {
            $niveles_plantelString = implode(',', $niveles_plantel);
            $sql = "SELECT DISTINCT npl.plan_id"
                    . " FROM "
                    . " gplantel.nivel_plan npl"
                    . " INNER JOIN gplantel.nivel n on (npl.nivel_id = n.id)"
                    . " INNER JOIN gplantel.nivel_plantel np on (np.nivel_id = n.id)"
                    . " INNER JOIN gplantel.plan p on (npl.plan_id = p.id)"
                    //. " INNER JOIN gplantel.plantel p on (p.id = )"
                    . " WHERE np.nivel_id IN ($niveles_plantelString)"
                    . " ORDER BY npl.plan_id ASC";
            $busqueda = Yii::app()->db->createCommand($sql);
            //$busqueda->bindParam(":niveles_plantel", $niveles_plantel, PDO::PARAM_LOB);

            $resultadoPlanesNivelPlantel = $busqueda->queryColumn();
            if ($resultadoPlanesNivelPlantel !== array())
                return $resultadoPlanesNivelPlantel;
            else
                return false;
        } else
            return null;
    }

    public function getPlan($verificarExistenciaNivel, $plantel_id) {

        $estatus = 'A';
        $nivel_id = $verificarExistenciaNivel[0]['nivel_id'];
        //var_dump($nivel_id);
        $sql = "SELECT DISTINCT npl.plan_id, p.nombre || ' [' || m.nombre ||'] [' || p.dopcion || ']' as nombre, p.nombre as nombrePlan"
                . " FROM "
                . " gplantel.nivel_plan npl"
                . " INNER JOIN gplantel.nivel n on (npl.nivel_id = n.id)"
                . " INNER JOIN gplantel.nivel_plantel np on (np.nivel_id = n.id)"
                . " INNER JOIN gplantel.plan p on (npl.plan_id = p.id)"
                . " INNER JOIN gplantel.plan_plantel pp on (npl.plan_id = pp.plan_id AND p.id = pp.plan_id)"
                . " LEFT JOIN gplantel.mencion m on (p.mencion_id = m.id)"
                . " WHERE npl.nivel_id = :nivel_id"
                . " AND p.estatus= :estatus"
                . " AND np.plantel_id= :plantel_id"
                . " ORDER BY npl.plan_id ASC";


        $busqueda = Yii::app()->db->createCommand($sql);
        $busqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $busqueda->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);
        $busqueda->bindParam(":estatus", $estatus, PDO::PARAM_INT);
        $resultadoPlanesNivelPlantel = $busqueda->queryAll();
        //var_dump($resultadoPlanesNivelPlantel);
        //die();

        if ($resultadoPlanesNivelPlantel !== array()) {
            return $resultadoPlanesNivelPlantel;
        } else {
            return false;
        }
    }

    public function verificarExistenciaPlan($plan_dropDown_id, $nivel_dropDown_id) {

        $estatus = 'A';
        if ($plan_dropDown_id != null && $nivel_dropDown_id != null) {
            if (is_numeric($plan_dropDown_id) && is_numeric($nivel_dropDown_id)) {
                $sql = "SELECT DISTINCT npl.plan_id, p.nombre || ' [' || m.nombre ||'][' || p.dopcion || ']' as nombre, p.nombre as nombrePlan"
                        . " FROM "
                        . " gplantel.nivel_plan npl"
                        . " INNER JOIN gplantel.nivel n on (npl.nivel_id = n.id)"
                        . " INNER JOIN gplantel.nivel_plantel np on (np.nivel_id = n.id)"
                        . " INNER JOIN gplantel.plan p on (npl.plan_id = p.id)"
                        . " LEFT JOIN gplantel.mencion m on (p.mencion_id = m.id)"
                        . " WHERE np.nivel_id IN ($nivel_dropDown_id)"
                        . " AND npl.plan_id IN ($plan_dropDown_id)"
                        . " AND p.estatus= :estatus"
                        . " ORDER BY npl.plan_id ASC";
                $busqueda = Yii::app()->db->createCommand($sql);
                $busqueda->bindParam(":estatus", $estatus, PDO::PARAM_INT);

                $resultadoPlanesNivelPlantel = $busqueda->queryAll();
                // var_dump($resultadoPlanesNivelPlantel); die();
                if ($resultadoPlanesNivelPlantel !== array()) {

                    return $resultadoPlanesNivelPlantel;
                } else {
                    return false;
                }
            }
            return false;
        } else {
            return false;
        }
    }

    public function obtenerPlanNivel($nivel_id) {

        if (is_numeric($nivel_id)) {
            $sql = "SELECT DISTINCT npl.plan_id as id, p.nombre as nombre, n.id as nivel_id, p.id as plan_id, p.cod_plan, p.mencion_id, m.nombre as mencion, p.dopcion"
                    . " FROM "
                    . " gplantel.nivel_plan npl"
                    . " INNER JOIN gplantel.nivel n on (npl.nivel_id = n.id)"
                    . " INNER JOIN gplantel.plan p on (npl.plan_id = p.id)"
                    . " LEFT JOIN gplantel.mencion m on (m.id = p.mencion_id)"
                    . " WHERE npl.nivel_id=:nivel_id"
                    . " ORDER BY npl.plan_id ASC";
            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);

            $resultadoPlanesNivel = $busqueda->queryAll();

            return $resultadoPlanesNivel;
        }
    }

    public function obtenerNivelesPlan($plan_id) {

        if (is_numeric($plan_id)) {
            $sql = "SELECT DISTINCT npl.nivel_id as id, n.nombre as nombre"
                    . " FROM "
                    . " gplantel.nivel_plan npl"
                    . " INNER JOIN gplantel.nivel n on (npl.nivel_id = n.id)"
                    . " INNER JOIN gplantel.plan p on (npl.plan_id = p.id)"
                    . " WHERE npl.plan_id=:plan_id"
                    . " ORDER BY npl.nivel_id ASC";
            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":plan_id", $plan_id, PDO::PARAM_INT);

            $resultadoNivelesPlan = $busqueda->queryAll();
            return $resultadoNivelesPlan;
        } else
            return null;
    }

    public function eliminarPlanNivel($plan_nivel_id, $nivel_id) {

        if (is_numeric($plan_nivel_id)) {
            $sql = "DELETE"
                    . " FROM "
                    . " gplantel.nivel_plan"
                    . " WHERE plan_id=:plan_nivel_id AND nivel_id=:nivel_id";
            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":plan_nivel_id", $plan_nivel_id, PDO::PARAM_INT);
            $busqueda->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);

            $resultadoPlanesNivel = $busqueda->execute();

            return $resultadoPlanesNivel;
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NivelPlan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

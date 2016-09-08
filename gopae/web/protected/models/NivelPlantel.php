<?php

/**
 * This is the model class for table "gplantel.nivel_plantel".
 *
 * The followings are the available columns in table 'gplantel.nivel_plantel':
 * @property string $id
 * @property integer $plantel_id
 * @property integer $nivel_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Plantel $plantel
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class NivelPlantel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.nivel_plantel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('plantel_id, nivel_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 6),
            array('estatus', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, plantel_id, nivel_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'nivel' => array(self::BELONGS_TO, 'Nivel', 'nivel_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'plantel_id' => 'Plantel',
            'nivel_id' => 'Nivel',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
        );
    }

    public function getNiveles($plantel_id, $tipo = 'C') {
        if (is_numeric($plantel_id)) {
            $sql = "SELECT nplantel.nivel_id, n.nombre "
                    . " FROM "
                    . " gplantel.nivel_plantel nplantel"
                    . " INNER JOIN gplantel.plantel p on (p.id = nplantel.plantel_id)"
                    . "INNER JOIN gplantel.nivel n on (nplantel.nivel_id = n.id)"
                    //. " INNER JOIN gplantel.plantel p on (p.id = )"
                    . " WHERE nplantel.plantel_id = :plantel_id"
                    . " ORDER BY  nplantel.nivel_id ASC";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            if ($tipo == 'C')
                $resultadoNiveles = $buqueda->queryColumn();
            else
                $resultadoNiveles = $buqueda->queryAll();
            //var_dump($resultadoNiveles);
            if ($resultadoNiveles !== array())
                return $resultadoNiveles;
            else
                return false;
        } else
            return null;
    }

    public function nivelPlantel($plantel_id) {

        $estatus = 'A';
        if (is_numeric($plantel_id) && $plantel_id != null) {
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
            $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);

            $resultadoNiveles = $buqueda->queryAll();
            //var_dump($resultadoNiveles);
            if ($resultadoNiveles !== array())
                return $resultadoNiveles;
            else
                return false;
        } else
            return null;
    }

    public function verificarExistenciaNivelPlantel($plantel_id, $nivel_dropDown_id) {

        $estatus = 'A';
        if ($nivel_dropDown_id != null && $plantel_id != null) {
            $sql = "SELECT nplantel.nivel_id, n.nombre"
                    . " FROM "
                    . " gplantel.nivel_plantel nplantel"
                    . " INNER JOIN gplantel.plantel p on (p.id = nplantel.plantel_id)"
                    . "INNER JOIN gplantel.nivel n on (nplantel.nivel_id = n.id)"
                    . " WHERE nplantel.plantel_id = :plantel_id"
                    . " AND nplantel.nivel_id= :nivel_id"
                    . " AND n.estatus= :estatus"
                    . " ORDER BY  nplantel.nivel_id ASC";
            
//            var_dump($sql);
//            die();
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $buqueda->bindParam(":nivel_id", $nivel_dropDown_id, PDO::PARAM_INT);
            $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $resultadoNiveles = $buqueda->queryAll();
            //   var_dump($resultadoNiveles); die();
            if ($resultadoNiveles !== array())
                return $resultadoNiveles;
            else
                return false;
        }else {
            return false;
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

        $criteria->compare('id', $this->id, true);

        $plantel_id = base64_decode($_GET['id']);
        //echo base64_decode('MjgwNDY=');
        if (is_numeric($plantel_id)) {
            $criteria->compare('plantel_id', $plantel_id);
        }
        if (is_numeric($this->nivel_id)) {
            if (strlen($this->nivel_id)) {
                $criteria->compare('nivel_id', $this->nivel_id);
            }
        }
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /*     * QUERY DESARROLLADO POR ENRIQUEX00* */

    public function getNivelesModalidad($id) {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $sql = 'SELECT  n.id, n.nombre FROM gplantel.nivel n
                INNER JOIN gplantel.modalidad_nivel mn ON mn.nivel_id = n.id
                INNER JOIN gplantel.plantel p ON p.modalidad_id = mn.modalidad_id
                WHERE p.id = :id AND mn.modalidad_id = (SELECT modalidad_id FROM gplantel.plantel p WHERE p.id = :id)';

            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":id", $id, PDO::PARAM_INT);
            $resultadoNiveles = $buqueda->queryAll();

            return $resultadoNiveles;
        }
    }

    public function registroNivel($plantel_id, $nivel_id, $user_id) {

        $estatus = "A";
        $plantel_id = base64_decode($plantel_id);

        if ((is_numeric($plantel_id)) && (is_numeric($nivel_id))) {
            $sql = "SELECT * from gplantel.nivel_plantel np WHERE
                np.plantel_id = :plantel_id AND np.nivel_id = :nivel_id";

            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guard->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);
            $consulto = $guard->queryAll();

            if ($consulto == null) {
                $sql = "INSERT INTO gplantel.nivel_plantel
                   (plantel_id, nivel_id, usuario_ini_id, estatus)
                   VALUES (:plantel_id, :nivel_id, :usuario_ini_id, :estatus)";

                $guard = Yii::app()->db->createCommand($sql);
                $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
                $guard->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);
                $guard->bindParam(":usuario_ini_id", $user_id, PDO::PARAM_INT);
                $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
                $guardoNivel = $guard->execute();
                return $guardoNivel;
            } else if ($consulto != null) {
                return $consulto;
            }
        }
    }

    public function eliminarNivel($id) {
        if (is_numeric($id)) {
            $sql = "DELETE FROM gplantel.nivel_plantel WHERE id = :id";
            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":id", $id, PDO::PARAM_INT);
            $eliminoNivel = $guard->execute();

            return $eliminoNivel;
        } else {
            return false;
        }
    }

    /*     * FIN DEL CODIGO DESARROLLADO POR ENRRIQUEX00* */

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NivelPlantel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

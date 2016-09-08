<?php

/**
 * This is the model class for table "gplantel.cocinera_plantel".
 *
 * The followings are the available columns in table 'gplantel.cocinera_plantel':
 * @property string $id
 * @property string $talento_humano_id
 * @property integer $plantel_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 * @property Plantel $plantel
 * @property TalentoHumano $talentoHumano
 */
class CocineraPlantel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.cocinera_plantel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('plantel_id, usuario_ini_id, fecha_ini, fecha_act, estatus', 'required'),
            array('plantel_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('estatus', 'length', 'max' => 1),
            array('estatus', 'in', 'range' => array('A', 'I', 'E'), 'allowEmpty' => false, 'strict' => true,),
            array('usuario_ini_id', 'default', 'value' => Yii::app()->user->id, 'on' => 'insert'),
            array('usuario_act_id', 'default', 'value' => Yii::app()->user->id, 'on' => 'update'),
            array('talento_humano_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, talento_humano_id, plantel_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
            'talentoHumano' => array(self::BELONGS_TO, 'TalentoHumano', 'talento_humano_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'talento_humano_id' => 'Talento Humano',
            'plantel_id' => 'Plantel',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
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

        if (strlen($this->id) > 0)
            $criteria->compare('id', $this->id, true);
        if (strlen($this->talento_humano_id) > 0)
            $criteria->compare('talento_humano_id', $this->talento_humano_id, true);
        if (is_numeric($this->plantel_id))
            $criteria->compare('plantel_id', $this->plantel_id);
        if (is_numeric($this->usuario_ini_id))
            $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        if (Utiles::isValidDate($this->fecha_ini, 'y-m-d'))
            $criteria->compare('fecha_ini', $this->fecha_ini);
        // if(strlen($this->fecha_ini)>0) $criteria->compare('fecha_ini',$this->fecha_ini,true);
        if (is_numeric($this->usuario_act_id))
            $criteria->compare('usuario_act_id', $this->usuario_act_id);
        if (Utiles::isValidDate($this->fecha_act, 'y-m-d'))
            $criteria->compare('fecha_act', $this->fecha_act);
        // if(strlen($this->fecha_act)>0) $criteria->compare('fecha_act',$this->fecha_act,true);
        if (Utiles::isValidDate($this->fecha_elim, 'y-m-d'))
            $criteria->compare('fecha_elim', $this->fecha_elim);
        // if(strlen($this->fecha_elim)>0) $criteria->compare('fecha_elim',$this->fecha_elim,true);
        if (in_array($this->estatus, array('A', 'I', 'E')))
            $criteria->compare('estatus', $this->estatus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function busquedaPorPlantel($plantel_id) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('colaborador_id', $this->colaborador_id);
        $criteria->compare('plantel_id', $plantel_id);
        $criteria->compare('periodo_id', $this->periodo_id);
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

    public function existeCocineraPlantel($cocineraId) {

        $resultado = array();

        if (is_numeric($cocineraId) && is_numeric($periodoEscolarId)) {
            $sql = "SELECT cp.id, cp.talento_humano_id, cp.plantel_id, cp.periodo_id "
                    . "FROM gplantel.cocinera_plantel cp "
                    . "WHERE cp.talento_humano_id = :colaborador "
                    . "AND cp.estatus = 'A'";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":colaborador", $cocineraId, PDO::PARAM_INT);

            $resultado = $command->queryRow();
        }

        return $resultado;
    }

    public function existeColaboradorPlantelByCedula($origen, $cedula) {

        $resultado = array();

        if (in_array($origen, array('V', 'E', 'P', 'T')) && is_numeric($cedula)) {
            $sql = "SELECT cp.id, cp.talento_humano_id, cp.plantel_id, cp.periodo_id "
                    . "FROM gplantel.cocinera_plantel cp "
                    . "INNER JOIN gestion_humana.talento_humano c ON cp.talento_humano_id = c.id "
                    . "WHERE c.origen = :origen "
                    . "AND c.cedula = :cedula "
                    . "AND estatus = 'A'";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":origen", $origen, PDO::PARAM_STR);
            $command->bindParam(":cedula", $cedula, PDO::PARAM_INT);

            $resultado = $command->queryRow();
        }

        return $resultado;
    }

    public function getListaCocinerasPlantel($plantelId) {

        $resultado = array();

        if (is_numeric($plantelId)) {

            $index = $this->getIndexCocinerasPlantel($plantelId);
            $resultado = Yii::app()->cache->get($index);

            if (!$resultado) {

                $sql = "SELECT cp.id AS cocinera_plantel_id, cp.talento_humano_id, cp.plantel_id, p.cod_estadistico, p.cod_plantel,
                               TO_CHAR(cp.fecha_act, 'DD-MM-YYYY') AS fecha_act_cp,
                               p.nombre AS nombre_plantel, c.id AS talento_humano_id,
                               c.origen, c.cedula, c.fecha_nacimiento, c.nombre, c.apellido, c.sexo, c.telefono_fijo, c.telefono_celular,
                               c.email_personal, c.estado_id, c.municipio_id, c.certificado_medico,
                               c.manipulacion_alimentos, c.parroquia_id, TO_CHAR(c.fecha_ultima_asistencia_reg, 'DD-MM-YYYY') AS fecha_ultima_asistencia_reg,
                               c.ultima_asistencia_reg, u.id AS usr_act_id, u.cedula AS usr_act_cedula,
                               u.nombre AS usr_act_nombre, u.apellido AS usr_act_apellido
                         FROM gplantel.cocinera_plantel cp
                            LEFT JOIN gplantel.plantel p ON cp.plantel_id = p.id
                            LEFT JOIN gestion_humana.talento_humano c ON cp.talento_humano_id = c.id 
                            LEFT JOIN seguridad.usergroups_user u ON cp.usuario_act_id = u.id 
                        WHERE cp.plantel_id = :plantel AND cp.estatus = 'A' ORDER BY c.cedula";

                $command = Yii::app()->db->createCommand($sql);
                $command->bindParam(":plantel", $plantelId, PDO::PARAM_INT);

                $resultado = $command->queryAll();

                if (count($resultado) > 0) {
                    Yii::app()->cache->set($index, $resultado, 36800);
                }
            }
        }

        return $resultado;
    }

    /**
     * 
     * Me permite verificar si un plantel tiene el permiso de editar los datos de un Colaborador
     * 
     * @param type $colaboradorPlantelId
     * @param type $plantelId
     * @return type
     */
    public function getCocineraPlantelByPlantel($cocineraPlantelId, $plantelId) {
        
        $cacheIndex = 'COCPL-PL:'.$cocineraPlantelId.':'.$plantelId;
        
        $resultado = Yii::app()->cache->get($cacheIndex);
        
        if(!$resultado){
        
            if (is_numeric($cocineraPlantelId) && is_numeric($plantelId)) {

                $sql = 'SELECT 
                            cp.id,
                            cp.talento_humano_id, 
                            cp.plantel_id
                          FROM 
                            gplantel.cocinera_plantel cp
                            INNER JOIN gestion_humana.talento_humano c ON c.id = cp.talento_humano_id
                          WHERE 1 = 1 
                            AND c.plantel_actual_id = :plantel
                            AND cp.id = :cocinera_plantel';

                $command = Yii::app()->db->createCommand($sql);
                $command->bindParam(":cocinera_plantel", $cocineraPlantelId, PDO::PARAM_INT);
                $command->bindParam(":plantel", $plantelId, PDO::PARAM_INT);

                $resultado = $command->queryRow();
                
                if ($resultado!=array() && $resultado!=null) {
                    Yii::app()->cache->set($cacheIndex, $resultado, 36800);
                }
            }
        
        }

        return $resultado;
    }

    public function desvincular($id, $plantelId, $colaboradorId=null) {

        $resultado = true;

        if (is_numeric($id)) {

            $userId = Yii::app()->user->id;

            $sql = "UPDATE gplantel.cocinera_plantel SET estatus = 'E', usuario_act_id = :user, fecha_act = NOW() WHERE id = :id";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":user", $userId, PDO::PARAM_INT);
            $command->bindParam(":id", $id, PDO::PARAM_INT);

            $command->queryRow();
            
            $cacheIndex = 'COCPL-PL:'.$colaboradorId.':'.$plantelId;
            Yii::app()->cache->delete($cacheIndex);
            $this->deleteCacheListaCocineras($plantelId);
        }

        return $resultado;
    }

    /**
     * 
     *  -- TABLA DE RESPUESTA QUE PODRÁ DAR LA FUNCION PL/PGSQL
     *  -- ------------------------------------------------------------------------------------------------------------------
     *  --  CODIGO | RESULTADO | MENSAJE
     *  -- ------------------------------------------------------------------------------------------------------------------
     *  --  S0000  | EXITO     | X Madre Colaboradora Asignada al Plantel.
     *  --  S0001  | EXITO     | X Madre Colaboradora Re-Asignada al Plantel.
     *  --  E0002  | ERROR     | X Colaboradora no registrada en base de datos
     *  --  E0003  | ERROR     | X La Madre Colaboradora se encuentra asignado a otro plantel en el periodo actual.
     *  -- ------------------------------------------------------------------------------------------------------------------
     * 
     * @param string $origen
     * @param int $cedula
     * @param int $plantel
     * @param string $modulo
     * @return array
     */
    public function registrarAsignacion($cocineraId, $plantelId, $modulo) {

        $result = array();
        $userId = Yii::app()->user->id;
        $userName = Yii::app()->user->name;
        $userIpAddress = Utiles::getRealIP();

        if (is_numeric($cocineraId) && is_numeric($plantelId) && strlen($modulo) > 4) {

            $sql = 'SELECT gplantel.asignar_madre_cocinera(:cocinera_id, :plantel, :modulo, :userid, :username, :ipaddress) AS result';

            $query = Yii::app()->db->createCommand($sql);
            //$query->bindParam(':seriales', $serialesPg);

            $query->bindParam(':cocinera_id', $cocineraId, PDO::PARAM_INT);
            $query->bindParam(':plantel', $plantelId, PDO::PARAM_INT);
            $query->bindParam(':modulo', $modulo, PDO::PARAM_INT);
            $query->bindParam(':userid', $userId, PDO::PARAM_INT);
            $query->bindParam(':username', $userName, PDO::PARAM_STR);
            $query->bindParam(':ipaddress', $userIpAddress, PDO::PARAM_STR);

            $queryResponse = $query->queryRow();
            $output = array();
            $result = Utiles::pgArrayParse($queryResponse['result'], $output);

            if (count($result) == 3) {
                $result['codigo'] = $result[0];
                $result['resultado'] = $result[1];
                $result['mensaje'] = $result[2];
            }

            $this->deleteCacheListaCocineras($plantelId);
        }

        return $result;
    }
    
    public function deleteCacheListaCocineras($plantelId){
        $index = $this->getIndexCocinerasPlantel($plantelId);
        Yii::app()->cache->delete($index);
    }
    
    public function getIndexCocinerasPlantel($plantelId){
        return "PLANTEL:COCINERA:{$plantelId}";
    }
    

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->fecha_ini = date('Y-m-d H:i:s');
                $this->usuario_ini_id = Yii::app()->user->id;
                $this->fecha_act = date('Y-m-d H:i:s');
                $this->usuario_act_id = Yii::app()->user->id;
            } else {
                $this->fecha_act = date('Y-m-d H:i:s');
                $this->usuario_act_id = Yii::app()->user->id;
            }
            $this->estatus = 'A';
            return true;
        } else {
            return false;
        }
    }

    public function beforeInsert() {
        parent::beforeSave();
        $this->fecha_ini = date('Y-m-d H:i:s');
        $this->usuario_ini_id = Yii::app()->user->id;
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
        return true;
    }

    public function beforeUpdate() {
        parent::beforeSave();
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
        return true;
    }

    public function beforeDelete() {
        parent::beforeSave();
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
        // $this->fecha_eli = $this->fecha_act;
        $this->estatus = 'I';
        return true;
    }

    public function beforeActivate() {
        parent::beforeSave();
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
        $this->estatus = 'A';
        return true;
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
     * @return CocineraPlantel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

<?php

/**
 * This is the model class for table "gplantel.colaborador_plantel".
 *
 * The followings are the available columns in table 'gplantel.colaborador_plantel':
 * @property integer $id
 * @property integer $colaborador_id
 * @property integer $plantel_id
 * @property integer $periodo_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property PeriodoEscolar $periodo
 * @property Colaborador $colaborador
 * @property Plantel $plantel
 */
class ColaboradorPlantel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.colaborador_plantel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('colaborador_id, plantel_id, periodo_id, usuario_ini_id, fecha_ini, estatus', 'required'),
            array('colaborador_id, plantel_id, periodo_id, estatus', 'ECompositeUniqueValidator', 'attributesToAddError'=>'colaborador_id', 'message'=>'La Madres Colaboradora ya ha sido registrada en este Plantel en el Periodo Actual.'),
            array('colaborador_id, plantel_id, periodo_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('estatus', 'length', 'max' => 1),
            array('fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, colaborador_id, plantel_id, periodo_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
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
            'periodo' => array(self::BELONGS_TO, 'PeriodoEscolar', 'periodo_id'),
            'colaborador' => array(self::BELONGS_TO, 'Colaborador', 'colaborador_id'),
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'colaborador_id' => 'Colaborador',
            'plantel_id' => 'Plantel',
            'periodo_id' => 'Periodo',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('colaborador_id', $this->colaborador_id);
        $criteria->compare('plantel_id', $this->plantel_id);
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

    public function existeColaboradorPlantel($colaboradorId, $periodoEscolarId){

        $resultado = array();

        if(is_numeric($colaboradorId) && is_numeric($periodoEscolarId)){
            $sql = "SELECT cp.id, cp.colaborador_id, cp.plantel_id, cp.periodo_id "
                   . "FROM gplantel.colaborador_plantel cp "
                  . "WHERE cp.colaborador_id = :colaborador "
                    . "AND cp.periodo_id = :periodo "
                    . "AND cp.estatus = 'A'";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":colaborador", $colaboradorId, PDO::PARAM_INT);
            $command->bindParam(":periodo", $periodoEscolarId, PDO::PARAM_INT);

            $resultado = $command->queryRow();
        }

        return $resultado;

    }
    
    public function existeColaboradorPlantelByCedula($origen, $cedula, $periodoEscolarId){

        $resultado = array();

        if(in_array($origen, array('V', 'E', 'P', 'T')) && is_numeric($cedula) && is_numeric($periodoEscolarId)){
            $sql = "SELECT cp.id, cp.colaborador_id, cp.plantel_id, cp.periodo_id "
                   . "FROM gplantel.colaborador_plantel cp "
                  . "INNER JOIN gplantel.colaborador c ON cp.colaborador_id = c.id "
                  . "WHERE c.origen = :origen "
                    . "AND c.cedula = :cedula "
                    . "AND cp.periodo_id = :periodo "
                    . "AND estatus = 'A'";

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":origen", $origen, PDO::PARAM_STR);
            $command->bindParam(":cedula", $cedula, PDO::PARAM_INT);
            $command->bindParam(":periodo", $periodoEscolarId, PDO::PARAM_INT);

            $resultado = $command->queryRow();
        }

        return $resultado;

    }

    public function getListaColaboradoresPlantel($plantelId, $periodoEscolarId){

        $resultado = array();
        
        if(is_numeric($plantelId) && is_numeric($periodoEscolarId)){
            
            $index = "pl{$plantelId}pr{$periodoEscolarId}";
            $resultado = Yii::app()->cache->get($index);
            
            if(!$resultado){

                $sql = "SELECT cp.id AS colaborador_plantel_id, cp.colaborador_id, cp.plantel_id, cp.periodo_id, p.cod_estadistico, p.cod_plantel,
                               TO_CHAR(cp.fecha_act, 'DD-MM-YYYY') AS fecha_act_cp,
                               p.nombre AS nombre_plantel, pe.periodo, pe.anio_inicio, pe.anio_fin, c.id AS colaborador_id,
                               c.origen, c.cedula, c.fecha_nacimiento, c.nombre, c.apellido, c.sexo, c.telefono, c.telefono_celular,
                               c.email, c.estado_id, c.municipio_id, c.certificado_medico,
                               c.manipulacion_alimentos, c.parroquia_id, TO_CHAR(c.fecha_ultima_asistencia_reg, 'DD-MM-YYYY') AS fecha_ultima_asistencia_reg,
                               c.ultima_asistencia_reg, u.id AS usr_act_id, u.cedula AS usr_act_cedula,
                               u.nombre AS usr_act_nombre, u.apellido AS usr_act_apellido
                         FROM gplantel.colaborador_plantel cp
                            LEFT JOIN gplantel.plantel p ON cp.plantel_id = p.id
                            LEFT JOIN gplantel.periodo_escolar pe ON cp.periodo_id = pe.id
                            LEFT JOIN gplantel.colaborador c ON cp.colaborador_id = c.id 
                            LEFT JOIN seguridad.usergroups_user u ON cp.usuario_act_id = u.id 
                        WHERE cp.plantel_id = :plantel AND cp.periodo_id = :periodo AND cp.estatus = 'A' ORDER BY c.cedula, c.sexo, c.apellido, c.nombre";

                $command = Yii::app()->db->createCommand($sql);
                $command->bindParam(":plantel", $plantelId, PDO::PARAM_INT);
                $command->bindParam(":periodo", $periodoEscolarId, PDO::PARAM_INT);

                $resultado = $command->queryAll();

                if(count($resultado)>0){
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
    public function getColaboradorPlantelByPlantel($colaboradorPlantelId, $plantelId){
        
        $resultado = null;
        
        if(is_numeric($colaboradorPlantelId) && is_numeric($plantelId)){
            
            $sql = 'SELECT 
                        cp.id,
                        cp.colaborador_id, 
                        cp.plantel_id
                      FROM 
                        gplantel.colaborador_plantel cp
                        INNER JOIN gplantel.colaborador c ON c.id = cp.colaborador_id
                      WHERE 1 = 1 
                        AND c.plantel_actual_id = :plantel
                        AND cp.id = :colaborador_plantel';
            
            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":colaborador_plantel", $colaboradorPlantelId, PDO::PARAM_INT);
            $command->bindParam(":plantel", $plantelId, PDO::PARAM_INT);
            
            $resultado = $command->queryRow();
            
        }
        
        return $resultado;
    }
    
    public function desvincular($id, $plantelId){
        
        $resultado = true;
        
        if(is_numeric($id)){
            
            $userId = Yii::app()->user->id;
            
            $sql = "UPDATE gplantel.colaborador_plantel SET estatus = 'E', usuario_act_id = :user, fecha_act = NOW() WHERE id = :id";
            
            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":user", $userId, PDO::PARAM_INT);
            $command->bindParam(":id", $id, PDO::PARAM_INT);

            $command->queryRow();
            
            $this->deleteCacheListaColaboradoras($plantelId);

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
    public function registrarAsignacion($colaboradorId, $plantelId, $modulo){
        
        $result = array();
        $userId = Yii::app()->user->id;
        $userName = Yii::app()->user->name;
        $userIpAddress = Utiles::getRealIP();

        if(is_numeric($colaboradorId) && is_numeric($plantelId) && strlen($modulo)>4){
            
            $sql = 'SELECT gplantel.asignar_madre_colaboradora(:colaborador_id, :plantel, :modulo, :userid, :username, :ipaddress) AS result';
            
            $query = Yii::app()->db->createCommand($sql);
            //$query->bindParam(':seriales', $serialesPg);

            $query->bindParam(':colaborador_id', $colaboradorId, PDO::PARAM_INT);
            $query->bindParam(':plantel', $plantelId, PDO::PARAM_INT);
            $query->bindParam(':modulo', $modulo, PDO::PARAM_INT);
            $query->bindParam(':userid', $userId, PDO::PARAM_INT);
            $query->bindParam(':username', $userName, PDO::PARAM_STR);
            $query->bindParam(':ipaddress', $userIpAddress, PDO::PARAM_STR);
            
            $queryResponse = $query->queryRow();
            $output = array();
            $result = Utiles::pgArrayParse($queryResponse['result'], $output);
            
            if(count($result)==3){
                $result['codigo'] = $result[0];
                $result['resultado'] = $result[1];
                $result['mensaje'] = $result[2];
            }

            $this->deleteCacheListaColaboradoras($plantelId);

        }
        
        return $result;
        
    }    

    public function beforeSave(){
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->fecha_ini=date('Y-m-d H:i:s');
                $this->usuario_ini_id=Yii::app()->user->id;
            }
            else{
                $this->fecha_act=date('Y-m-d H:i:s');
                $this->usuario_act_id=Yii::app()->user->id;
            }
            $this->estatus = 'A';
            return true;
        }else{
            return false;
        }
    }

    public function beforeUpdate(){
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->fecha_ini=date('Y-m-d H:i:s');
                $this->usuario_ini_id=Yii::app()->user->id;
            }
            else{
                $this->fecha_act=date('Y-m-d H:i:s');
                $this->usuario_act_id=Yii::app()->user->id;
            }
            return true;
        }else{
            return false;
        }
    }
    
    public function deleteCacheListaColaboradoras($plantelId){
        $periodoEscolar = PeriodoEscolar::model()->getPeriodoActivo();
        $periodoEscolarId = $periodoEscolar['id'];
        $index = "pl{$plantelId}pr{$periodoEscolarId}";
        Yii::app()->cache->delete($index);
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ColaboradorPlantel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
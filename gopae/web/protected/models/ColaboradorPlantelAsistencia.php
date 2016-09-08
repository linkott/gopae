<?php

/**
 * This is the model class for table "gplantel.colaborador_plantel_asistencia".
 *
 * The followings are the available columns in table 'gplantel.colaborador_plantel_asistencia':
 * @property string $id
 * @property string $colaborador_plantel_id
 * @property integer $mes
 * @property integer $anio
 * @property integer $cant_asistencia
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property ColaboradorPlantel $colaboradorPlantel
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 */
class ColaboradorPlantelAsistencia extends CActiveRecord {

    /**
     * @var array
     */
    public $stats;

    /**
     * @var string
     */
    public $resultGlobal;
    
    /**
     * @var string
     */
    public $mensaje;
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.colaborador_plantel_asistencia';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mes, anio, usuario_ini_id, fecha_ini', 'required'),
            array('mes, anio, cant_asistencia, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('estatus', 'length', 'max' => 1),
            array('colaborador_plantel_id, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, colaborador_plantel_id, mes, anio, cant_asistencia, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'colaboradorPlantel' => array(self::BELONGS_TO, 'ColaboradorPlantel', 'colaborador_plantel_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'colaborador_plantel_id' => 'Colaborador Plantel',
            'mes' => 'Mes',
            'anio' => 'Anio',
            'cant_asistencia' => 'Cant Asistencia',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('colaborador_plantel_id', $this->colaborador_plantel_id, true);
        $criteria->compare('mes', $this->mes);
        $criteria->compare('anio', $this->anio);
        $criteria->compare('cant_asistencia', $this->cant_asistencia);
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

    public function getListaColaboradoresPlantelAsistencia($plantelId, $periodoEscolarId, $mes, $anio) {

        $resultado = array();
        
        // Yii::app()->cache->delete("pl{$plantelId}pr{$periodoEscolarId}mc{$mes}-{$anio}");
        
        if (is_numeric($plantelId) && is_numeric($periodoEscolarId) && is_numeric($mes) && is_numeric($mes)) {

            $index = "pl{$plantelId}pr{$periodoEscolarId}mc{$mes}-{$anio}";
            $resultado = Yii::app()->cache->get($index);

            if (!$resultado) {

                $sql = "SELECT cp.id AS colaborador_plantel_id, cp.colaborador_id, cp.plantel_id, cp.periodo_id, p.cod_estadistico, p.cod_plantel,
                               TO_CHAR(cp.fecha_act, 'DD-MM-YYYY') AS fecha_act_cp,
                               cpa.cant_asistencia AS asistencia, cpa.mes, cpa.anio,
                               ua.id AS usr_ini_id, ua.cedula AS usr_ini_cedula,
                               ua.nombre AS usr_ini_nombre, ua.apellido AS usr_ini_apellido,
                               p.nombre AS nombre_plantel, pe.periodo, pe.anio_inicio, pe.anio_fin, c.id AS colaborador_id,
                               c.origen, c.cedula, c.fecha_nacimiento, c.nombre, c.apellido, c.sexo, c.telefono, c.telefono_celular,
                               c.email, c.estado_id, c.municipio_id, c.certificado_medico,
                               c.manipulacion_alimentos, c.parroquia_id, TO_CHAR(c.fecha_ultima_asistencia_reg, 'DD-MM-YYYY') AS fecha_ultima_asistencia_reg,
                               c.ultima_asistencia_reg, u.id AS usr_act_id, u.cedula AS usr_act_cedula,
                               u.nombre AS usr_act_nombre, u.apellido AS usr_act_apellido
                         FROM gplantel.colaborador_plantel_asistencia cpa
                           INNER JOIN gplantel.colaborador_plantel cp ON cp.id = cpa.colaborador_plantel_id
                           INNER JOIN seguridad.usergroups_user ua ON cpa.usuario_ini_id = ua.id
                            LEFT JOIN gplantel.plantel p ON cp.plantel_id = p.id
                            LEFT JOIN gplantel.periodo_escolar pe ON cp.periodo_id = pe.id
                            LEFT JOIN gplantel.colaborador c ON cp.colaborador_id = c.id
                            LEFT JOIN seguridad.usergroups_user u ON cp.usuario_act_id = u.id
                        WHERE cp.plantel_id = :plantel AND cp.periodo_id = :periodo AND cpa.mes = :mes AND cpa.anio = :anio
                        ORDER BY c.origen, c.cedula, c.sexo, c.apellido, c.nombre";

                $command = Yii::app()->db->createCommand($sql);
                $command->bindParam(":plantel", $plantelId, PDO::PARAM_INT);
                $command->bindParam(":periodo", $periodoEscolarId, PDO::PARAM_INT);
                $command->bindParam(":mes", $mes, PDO::PARAM_INT);
                $command->bindParam(":anio", $anio, PDO::PARAM_INT);

                $resultado = $command->queryAll();

                if (count($resultado) > 0) {
                    Yii::app()->cache->set($index, $resultado, 36800);
                }
            }
        }

        return $resultado;
    }
    
    /**
     * $sql = "SELECT gplantel.registro_asistencia_madres_colaboradoras($colaboradorPlantelId, $colaboradorAsistencia, $mes, $anio, $modulo, $usuario_id, $username, $ip)";
     * 
     * @param array(int) $colaboradorasPlantelId
     * @param array(int) $cantAsistencias
     * @param int $mes
     * @param int $anio
     * @param int $diasPlanificados
     * @param string $modulo
     * @param int $usuarioId
     * @param string $username
     * @param string $direccionIp
     * @param int $plantelId
     * @return array
     */
    public function registroAsistenciaMadresColaboradoras($colaboradorasPlantelId, $cantAsistencias, $mes, $anio, $diasPlanificados, $modulo, $usuarioId, $username, $direccionIp, $plantelId) {
        
        $diasPlanificados = (int) $diasPlanificados;
        
        $this->resultGlobal = 'ERROR';
        $response = new stdClass();
        
        if($diasPlanificados>0 && is_numeric($usuarioId) && is_array($colaboradorasPlantelId) && is_array($cantAsistencias) && count($colaboradorasPlantelId)>0 && count($cantAsistencias)>0){
        
            $direccionIp = Utiles::getRealIP();
            $userName = Yii::app()->user->name;
            $usuarioId = Yii::app()->user->id;

            $response->data = array();

            $colaboradorasPlantelIdPg = Utiles::toPgArray($colaboradorasPlantelId);
            $cantAsistenciasPg = Utiles::toPgArray($cantAsistencias);
            
            $sql = "SELECT gplantel.registro_asistencia_madres_colaboradoras($colaboradorasPlantelIdPg, $cantAsistenciasPg, :mes, :anio, :module,  :userid, :username, :ipaddress) AS result";
            
            //var_dump($sql); die();
            
            $query = Yii::app()->db->createCommand($sql);
            
            $query->bindParam(':mes', $mes, PDO::PARAM_INT);
            $query->bindParam(':anio', $anio, PDO::PARAM_INT);
            $query->bindParam(':module', $modulo, PDO::PARAM_STR);
            $query->bindParam(':userid', $usuarioId, PDO::PARAM_INT);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':ipaddress', $direccionIp, PDO::PARAM_STR);

            $queryResponse = $query->queryRow();

            $output = array();
            $this->stats['exitos'] = 0;
            $this->stats['alertas'] = 0;
            $this->stats['errores'] = 0;
            $this->resultGlobal = true;
            
            $response->data = $this->responseSeparate(Utiles::pgArrayParse($queryResponse['result'], $output));
            
            $response->stats = $this->stats;
            
            $this->mensaje = "El Registro de Asistencias de Madres y Padres Colaboradores del mes $mes/$anio se ha efectuado de forma exitosa.";
            
            $this->deleteCacheListaAsistenciaColaboradoras($plantelId, $mes, $anio);
            
        }
        else{
            $this->mensaje = 'Los Datos suministrados no son v&aacute;lidos para continuar con la operaci&oacute;n.';
        }
        
        return array($this->resultGlobal, $this->mensaje, $response);
        
    }

    /**
     * @param array $input
     *
     **/
    private function responseSeparate($input){
        $i=0;
        $c=count($input)-1;
        $output=array();

        while($i<=$c){

            $splitter[$i]=explode(",", str_replace("}", '', str_replace('{', '', $input[$i])));
            
            $output[$i]['resultado'] = trim(str_replace('"', '', $splitter[$i][0]));
            $output[$i]['cedula'] = trim($splitter[$i][1]);
            $output[$i]['nombre'] = trim(str_replace('"', '', $splitter[$i][2]));
            $output[$i]['apellido'] = trim(str_replace('"', '', $splitter[$i][3]));
            $output[$i]['asistencia'] = trim(str_replace('"', '', $splitter[$i][4]));
            $output[$i]['mensaje'] = Utiles::onlyTextString($splitter[$i][5]);

            if($output[$i]['resultado']=='EXITOSO'){
                $this->stats['exitos'] = $this->stats['exitos'] + 1;
            }elseif ($output[$i]['resultado']=='ALERTA') {
                $this->stats['alertas'] = $this->stats['alertas'] + 1;
                $this->resultGlobal = false;
            }else{
                $this->stats['errores'] = $this->stats['errores'] + 1;
                $this->resultGlobal = false;
            }

            $i++;

        }
        return $output;
    }
    
    public function deleteCacheListaAsistenciaColaboradoras($plantelId, $mes, $anio){
        $periodoEscolar = PeriodoEscolar::model()->getPeriodoActivo();
        $periodoEscolarId = $periodoEscolar['id'];
        $index = "pl{$plantelId}pr{$periodoEscolarId}mc{$mes}-{$anio}";
        Yii::app()->cache->delete($index);
        $index = "pl{$plantelId}pr{$periodoEscolarId}";
        Yii::app()->cache->delete($index);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ColaboradorPlantelAsistencia the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

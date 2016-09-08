<?php

/**
 * This is the model class for table "gplantel.periodo_escolar".
 *
 * The followings are the available columns in table 'gplantel.periodo_escolar':
 * @property integer $id
 * @property string $periodo
 * @property integer $anio_inicio
 * @property integer $anio_fin
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property AutoridadPlantel[] $autoridadPlantels
 * @property Usuario $usuarioAct
 * @property Usuario $usuarioIni
 */
class PeriodoEscolar extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.periodo_escolar';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('periodo', 'required'),
            array('periodo', 'unique'),
            array('anio_inicio, anio_fin, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('periodo', 'length', 'max' => 20),
            array('estatus', 'length', 'max' => 1),
            array('fecha_ini, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, periodo, anio_inicio, anio_fin, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'autoridadPlantels' => array(self::HAS_MANY, 'AutoridadPlantel', 'periodo_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'periodo' => 'Periodo',
            'anio_inicio' => 'Anio Inicio',
            'anio_fin' => 'Anio Fin',
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
        $criteria->compare('periodo', $this->periodo, true);
        $criteria->compare('anio_inicio', $this->anio_inicio);
        $criteria->compare('anio_fin', $this->anio_fin);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);

        $sort = new CSort();
        $sort->defaultOrder = 'estatus ASC, id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort
        ));
    }
    /**
     * Obtiene el Periodo Escolar Actualmente Activo
     * 
     * @return PeriodoEscolar
     */
    public function getPeriodoActivo($chached=true) {

        $table = $this->tableName();
        $indice = 'periodoEscolarActivo';
        $periodo = Yii::app()->cache->get($indice);
        
        if($periodo && $chached){
           return $periodo; 
        }
        else{
            $periodo = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from($table)
                    ->where('estatus = :estatus', array(':estatus' => 'A'))
                    ->queryRow();
            if($periodo && $periodo !== array()){
                Yii::app()->cache->set('periodoEscolarActivo', $periodo, 86400);
            }
        }
        
        return $periodo;
    }
    /**
     * Obtiene el Periodo Escolar Anterior al Actualmente Activo
     *
     * @return id 
     */
    public function obtenerPeriodoAnterior($periodo) {

        $table = $this->tableName();

        $periodo = Yii::app()->db->createCommand()
                ->select('id')
                ->from($table)
                ->where('estatus = :estatus AND periodo = :periodo', array(':estatus' => 'I', ':periodo' => $periodo))
                ->queryScalar();

        return $periodo;
    }
    /**
     *
 * Esta funcion me permite buscar los datos de auditoria en un periodo escolar. muestra aquel usuario que creo un nuevo periodo escolar junto con la fecha de creacion.
     * @param int
     * @return string
     * @author Richard Massri
 */
    public function buscar($id) {
        $sql = "SELECT * FROM gplantel.periodo_escolar m
        LEFT JOIN seguridad.usergroups_user u ON u.id = m.usuario_ini_id
        WHERE m.id = " . $id;
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }
    /**
     * Esta función permite inactivar todos los periodos anteriores. Es decir al crear una periodo escolar el periodo anterior existente se inactiva.
     * @param int
     * @return string
     * @author Richard Massri
    */
    function Inactivar_todo($id) {

        $sql2 = "update gplantel.periodo_escolar set estatus='I' where id!=(select max(id) from gplantel.periodo_escolar)";
        $consulta2 = Yii::app()->db->createCommand($sql2);
        $resultado2 = $consulta2->queryAll();
        return $resultado2;
    }
    /**
     * Esta funcion me permite buscar los datos de auditoria en un periodo escolar. muestra aquel usuario que creo actualizo un  periodo escolar junto con la fecha de creacion.
     * @param int
     * @return string
     * @author Richard Massri
     */
    public function buscar2($id) {
        $sql2 = "SELECT * FROM gplantel.periodo_escolar m
        LEFT JOIN seguridad.usergroups_user u ON u.id = m.usuario_act_id
        WHERE m.id = " . $id;
        $consulta2 = Yii::app()->db->createCommand($sql2);
        $resultado2 = $consulta2->queryAll();
        return $resultado2;
    }

    /**
     * funcion que permite cambiar la fecha por cada año en un periodo escolar.
     * @param int
     * @return string
     * @author Richard Massri
     *
     */
    function fechaCambia($id) {

        $sql3 = "select periodo_escolar.anio_inicio,periodo_escolar.anio_fin  from gplantel.periodo_escolar where id=(select max(id) from gplantel.periodo_escolar);";
        $consulta3 = Yii::app()->db->createCommand($sql3);
        $resultado3 = $consulta3->queryAll();
        return $resultado3;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PeriodoEscolar the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

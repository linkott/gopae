<?php

/**
 * This is the model class for table "matricula.calificacion_asignatura_estudiante".
 *
 * The followings are the available columns in table 'matricula.calificacion_asignatura_estudiante':
 * @property integer $id
 * @property integer $asignatura_estudiante_id
 * @property integer $lapso
 * @property double $calif_cuantitativa
 * @property integer $influye_en_promedio
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property string $resumen_evaluativo
 * @property integer $calif_nominal
 * @property integer $asistencia
 * @property string $observacion
 * @property string $id_compuesta
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property AsignaturaEstudiante $asignaturaEstudiante
 * @property CalificacionNominal $califNominal
 * @property UsergroupsUser $usuarioIni
 */
class CalificacionAsignaturaEstudiante extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'matricula.calificacion_asignatura_estudiante';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
            //agregar escenarios de calificacion ALEXIS
		return array(
			array('asignatura_estudiante_id, lapso, calif_cuantitativa, influye_en_promedio, usuario_ini_id, fecha_ini', 'required', 'on'=>'regularMediaGeneral'),
                        array('asignatura_estudiante_id, lapso, usuario_ini_id, fecha_ini', 'required', 'on'=>'regularBasica'),
                        array('asignatura_estudiante_id, lapso,calif_nominal, usuario_ini_id, fecha_ini', 'required', 'on'=>'regularBasica3lapso'),    
                        array('asignatura_estudiante_id, lapso, calif_cuantitativa, influye_en_promedio, usuario_ini_id, usuario_act_id, asistencia', 'numerical', 'integerOnly'=>true),
			array('estatus', 'length', 'max'=>1),
                        array('id_compuesta','unique','message'=>'Ya se ha evaluado durante este lapso'),
			array('fecha_act, fecha_elim, resumen_evaluativo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, asignatura_estudiante_id, lapso, calif_cuantitativa, influye_en_promedio, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, resumen_evaluativo, calif_nominal, asistencia', 'safe', 'on'=>'search'),
		);
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
			'asignaturaEstudiante' => array(self::BELONGS_TO, 'AsignaturaEstudiante', 'asignatura_estudiante_id'),
			'califNominal' => array(self::BELONGS_TO, 'CalificacionNominal', 'calif_nominal'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'asignatura_estudiante_id' => 'Asignatura Estudiante',
			'lapso' => 'Lapso',
			'calif_cuantitativa' => 'Calif Cuantitativa',
			'influye_en_promedio' => 'Influye En Promedio',
			'usuario_ini_id' => 'Usuario Ini',
			'fecha_ini' => 'Fecha Ini',
			'usuario_act_id' => 'Usuario Act',
			'fecha_act' => 'Fecha Act',
			'fecha_elim' => 'Fecha Elim',
			'estatus' => 'Estatus',
			'resumen_evaluativo' => 'Resumen Evaluativo',
			'calif_nominal' => 'Calif Nominal',
			'asistencia' => 'Asistencia',
			'observacion' => 'Observacion',
			'id_compuesta' => 'Id Compuesta',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('asignatura_estudiante_id',$this->asignatura_estudiante_id);
		$criteria->compare('lapso',$this->lapso);
		$criteria->compare('calif_cuantitativa',$this->calif_cuantitativa);
		$criteria->compare('influye_en_promedio',$this->influye_en_promedio);
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('fecha_act',$this->fecha_act,true);
		$criteria->compare('fecha_elim',$this->fecha_elim,true);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('resumen_evaluativo',$this->resumen_evaluativo,true);
		$criteria->compare('calif_nominal',$this->calif_nominal);
		$criteria->compare('asistencia',$this->asistencia);
		$criteria->compare('observacion',$this->observacion,true);
		$criteria->compare('id_compuesta',$this->id_compuesta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public function cargarCalificacionRegularMediaGeneral($asignaturas, $asistencia, $notas,$observaciones,$lapsoEncode){
        $usuario_ini = Yii::app()->user->id;

        $observacionesDecoded=Utiles::toPgArray($observaciones)."::TEXT[]";
        $asignaturasDecoded=Utiles::toPgArray($asignaturas);
        $asistenciaDecoded=Utiles::toPgArray($asistencia);
        $notasDecoded=Utiles::toPgArray($notas)."::REAL[]";
        $lapso=array(base64_decode($lapsoEncode));
        
        $lapsoDecoded=Utiles::toPgArray($lapso)."::SMALLINT[]";

        $sql = "SELECT matricula.cargar_nota_regular_media_general($asignaturasDecoded, $asistenciaDecoded, $notasDecoded, :usuario_ini, $observacionesDecoded,$lapsoDecoded)";
        
        $inscripcionEstudiante = Yii::app()->db->createCommand($sql);
        $inscripcionEstudiante->bindParam(":usuario_ini", $usuario_ini, PDO::PARAM_INT);
        $resultado = $inscripcionEstudiante->execute();
        
        return $resultado;

        }
        
        
        public function cargarTotalClasesAsignatura($asignaturas, $totalClases,$seccion,$lapsoEncode){
        $usuario_ini = Yii::app()->user->id;

        $asignaturasDecoded=Utiles::toPgArray($asignaturas);
        $totalClasesDecoded=Utiles::toPgArray($totalClases);

        $sql = "SELECT matricula.cargar_total_clases($asignaturasDecoded, $totalClasesDecoded, $seccion, :usuario_ini,$lapsoEncode)";
        
        $inscripcionEstudiante = Yii::app()->db->createCommand($sql);
        $inscripcionEstudiante->bindParam(":usuario_ini", $usuario_ini, PDO::PARAM_INT);
        $resultado = $inscripcionEstudiante->execute();
        
        return $resultado;

        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CalificacionAsignaturaEstudiante the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

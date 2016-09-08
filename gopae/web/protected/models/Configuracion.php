<?php

/**
 * This is the model class for table "sistema.configuracion".
 *
 * The followings are the available columns in table 'sistema.configuracion':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $cod_tipo_dato
 * @property integer $valor_bool
 * @property string $valor_cod
 * @property string $valor_str
 * @property string $valor_lstr
 * @property string $valor_txt
 * @property integer $valor_int
 * @property string $valor_date
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property TipoDato $codTipoDato
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class Configuracion extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sistema.configuracion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('valor_bool, valor_int, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 20),
            array('descripcion', 'length', 'max' => 300),
            array('cod_tipo_dato, valor_cod', 'length', 'max' => 4),
            array('valor_str', 'length', 'max' => 60),
            array('valor_lstr', 'length', 'max' => 250),
            array('estatus', 'length', 'max' => 1),
            array('valor_txt, valor_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, descripcion, cod_tipo_dato, valor_bool, valor_cod, valor_str, valor_lstr, valor_txt, valor_int, valor_date, usuario_ini_id, usuario_act_id, fecha_ini, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'codTipoDato' => array(self::BELONGS_TO, 'TipoDato', 'cod_tipo_dato'),
            'usuarioAct' => array(self::BELONGS_TO, 'UserGroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UserGroupsUser', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'cod_tipo_dato' => 'Cod Tipo Dato',
            'valor_bool' => 'Valor Bool',
            'valor_cod' => 'Valor Cod',
            'valor_str' => 'Valor Str',
            'valor_lstr' => 'Valor Lstr',
            'valor_txt' => 'Valor Txt',
            'valor_int' => 'Valor Int',
            'valor_date' => 'Valor Date',
            'usuario_ini_id' => 'Usuario Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_ini' => 'Fecha Ini',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.nombre', strtoupper($this->nombre), true);
        $criteria->addSearchCondition('t.descripcion','%'.$this->descripcion. '%',false,'AND','ILIKE');
        $criteria->compare('t.cod_tipo_dato', $this->cod_tipo_dato, true);
        $criteria->compare('t.valor_bool', $this->valor_bool);
        $criteria->compare('t.valor_cod', $this->valor_cod, true);
        $criteria->compare('t.valor_str', $this->valor_str, true);
        $criteria->compare('t.valor_lstr', $this->valor_lstr, true);
        $criteria->compare('t.valor_txt', $this->valor_txt, true);
        $criteria->compare('t.valor_int', $this->valor_int);
        $criteria->compare('t.valor_date',$this->valor_date,true);
        $criteria->compare('t.usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('t.usuario_act_id', $this->usuario_act_id);
        $criteria->compare('t.fecha_ini', $this->fecha_ini, true);
        $criteria->compare('t.fecha_act', $this->fecha_act, true);
        $criteria->compare('t.fecha_elim', $this->fecha_elim, true);
        $criteria->compare('t.estatus', $this->estatus, true);
        if (strlen($this->valor_date) > 0 && Utiles::dateCheck($this->valor_date)) {
            $this->valor_date = Utiles::transformDate($this->valor_date);
            $criteria->addSearchCondition("TO_CHAR(t.valor_date, 'YYYY-MM-DD')", $this->valor_date, false, 'AND', '=');
        } else {
            $this->valor_date = '';
        }
        $sort = new CSort();
        $sort->defaultOrder = 'id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort
        ));
    }


   public function Casos(){
       $resultado='';
       $sql="SELECT  c.nombre,
       CASE  WHEN c.cod_tipo_dato='bool'  THEN c.valor_bool
       END AS valor_bool,
       CASE WHEN c.cod_tipo_dato='date'  THEN c.valor_date
       END AS valor_date,
       CASE WHEN c.cod_tipo_dato='cod' THEN c.valor_cod
       END AS valor_cod,
       CASE WHEN c.cod_tipo_dato='str' THEN c.valor_str
       END AS valor_str,
       CASE WHEN c.cod_tipo_dato='' THEN c.valor_lstr
       END AS valor_lstr,
       CASE WHEN c.cod_tipo_dato='' then c.valor_txt
       END AS valor_txt,
       CASE WHEN c.cod_tipo_dato='' then c.valor_int
       END AS valor_int
       FROM sistema.configuracion c";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryAll();
       return $resultado;
   }
   
   public static function getConfig(){

       $sql = "SELECT c.id, c.nombre, c.cod_tipo_dato AS tipo_dato,
                (
                   CASE WHEN c.cod_tipo_dato='bool' THEN c.valor_bool::TEXT
                        WHEN c.cod_tipo_dato='date' THEN c.valor_date::TEXT
                        WHEN c.cod_tipo_dato='cod' THEN c.valor_cod::TEXT
                        WHEN c.cod_tipo_dato='str' THEN c.valor_str::TEXT
                        WHEN c.cod_tipo_dato='lstr' THEN c.valor_lstr::TEXT
                        WHEN c.cod_tipo_dato='txt' THEN c.valor_txt::TEXT
                        WHEN c.cod_tipo_dato='int' THEN c.valor_int::TEXT
                        END
                ) AS valor
                FROM
                    sistema.configuracion c";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryAll();
       
       $config = array();
       
       foreach($resultado as $row){
           $config[$row['nombre']]['id']     = $row['id'];
           $config[$row['nombre']]['nombre'] = $row['nombre'];
           $config[$row['nombre']]['tipo']   = $row['tipo_dato'];
           $config[$row['nombre']]['valor']  = $row['valor'];
       }
       
       return $config;
       
   }
   
   public function getFechaIniAsignacionTitulo(){
       $resultado='';
        $sql="select  c.valor_date from sistema.configuracion c where c.nombre='FECHA_INI_ASIG_TITU'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

   public function getFechaFinAsignacionTitulo(){
       $resultado='';
       $sql="select  c.valor_date from sistema.configuracion c where c.nombre='FECHA_INI_ASIG_TITU'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

   public function getFechaIniSolicitudTitulo(){
       $resultado='';
       $sql="select c.valor_date from sistema.configuracion c where c.nombre='FECHA_INI_SOL_TIT'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }


   public function getFechaFinSolicitudTitulo(){
       $resultado='';
       $sql="select c.valor_date from sistema.configuracion c where c.nombre='FECHA_FIN_SOL_TIT'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }


   public function getModCalific(){
       $resultado='';
       $sql="select c.valor_bool from sistema.configuracion c where c.nombre='ACTIVO_MOD_CALIFIC'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

   public function getFechaIniRevision(){
       $resultado='';
       $sql="select c.valor_date from sistema.configuracion c where c.nombre='FECHA_FIN_REVISION'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

   public function getFechaFinRevision(){
       $resultado='';
       $sql="select c.valor_date from sistema.configuracion c where c.nombre='FECHA_FIN_REVISION'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

   
  
   public function getFechaIniInscripc(){
       $resultado='';
       $sql="select c.valor_date from sistema.configuracion c where c.nombre='FECHA_INI_INSCRIP'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

    public function getFechaFinInscripc(){
       $resultado='';
       $sql="select c.valor_date from sistema.configuracion c where c.nombre='FECHA_FIN_INSCRIP'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }


   public function getFechaIniUsuarios(){
       $resultado='';
       $sql="select c.valor_date from sistema.configuracion c where c.nombre='FECHA_INI_USERS'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

   public function getFechaFinUsuarios(){
       $resultado='';
       $sql="select c.valor_date from sistema.configuracion c where c.nombre='FECHA_FIN_USERS'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

   public function getFechasCantMatricula(){
       $resultado = Yii::app()->cache->get('FechasCantMatricula');
       
       if(!$resultado){
            $sql="select c.valor_date from sistema.configuracion c where c.nombre = 'FECHA_INI_MATRIC' OR c.nombre = 'FECHA_FIN_MATRIC' ORDER BY c.valor_date ASC";
            $consulta=Yii::app()->db->createCommand($sql);
            $resultado=$consulta->queryAll();
            Yii::app()->cache->set('FechasCantMatricula', $resultado, 86400);
       }
       return $resultado;
   }
   
   public function getEnMantenimiento(){
       $resultado='';
       $sql="select c.valor_bool from sistema.configuracion c where c.nombre='EN_MANTENIMIENTO'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }
   public function getModuloUsuarios(){
    $resultado='';
    $sql="select c.valor_bool from sistema.configuracion c where c.nombre='ACTIVO_MOD_USERS'";
    $consulta=Yii::app()->db->createComand($sql);
    $resultado=$consulta->queryScalar();
    return $resultado;
   }

    public function getModInscripcion(){
       $resultado='';
       $sql="select c.valor_bool from sistema.configuracion c where c.nombre='ACTIVO_MOD_INSCRIP'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

   public function getModSolicitante(){
       $resultado='';
       $sql="select c.valor_bool from sistema.configuracion c where c.nombre='ACTIVO_MOD_SOL'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

   public function getModAsignacion(){
       $resultado='';
       $sql="select c.valor_bool from sistema.configuracion c where c.nombre='ACTIVO_MOD_ASIG'";
       $consulta=Yii::app()->db->createCommand($sql);
       $resultado=$consulta->queryScalar();
       return $resultado;
   }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}

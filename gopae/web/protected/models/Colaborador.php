<?php

/**
 * This is the model class for table "gplantel.colaborador".
 *
 * The followings are the available columns in table 'gplantel.colaborador':
 * @property string $id
 * @property string $origen
 * @property integer $cedula
 * @property string $fecha_nacimiento
 * @property string $nombre
 * @property string $apellido
 * @property string $sexo
 * @property string $telefono
 * @property string $telefono_celular
 * @property string $email
 * @property string $twitter
 * @property string $foto
 * @property integer $mision_id
 * @property string $certificado_medico
 * @property string $manipulacion_alimentos
 * @property string $username
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $parroquia_id
 * @property string $direccion
 * @property string $enfermedades
 * @property string $observacion
 * @property integer $tipo_cuenta_id
 * @property integer $banco_id
 * @property string $numero_cuenta
 * @property string $origen_titular
 * @property integer $cedula_titular
 * @property string $nombre_titular
 * @property string $busqueda
 * @property string $usuario_ini_id
 * @property string $fecha_ini
 * @property string $usuario_act_id
 * @property string $fecha_act
 * @property string $estatus
 * @property integer $plantel_actual_id
 * @property integer $cant_hijos
 * @property integer $hijo_en_plantel
 * @property integer $grado_instruccion_id
 * @property string $password
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property GradoInstruccion $gradoInstruccion
 * @property Plantel $plantelActual
 * @property Mision $mision
 * @property Banco $banco
 * @property TipoCuenta $tipoCuenta
 * @property Parroquia $parroquia
 * @property Municipio $municipio
 * @property Estado $estado
 * @property ColaboradorPlantel[] $colaboradorPlantels
 */
class Colaborador extends CActiveRecord {

    public $codPlantel;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.colaborador';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(            
            array('origen, cedula, nombre, apellido, fecha_nacimiento, sexo, estado_id, municipio_id, origen_titular, cedula_titular, nombre_titular, usuario_ini_id, fecha_ini, banco_id, tipo_cuenta_id, numero_cuenta, certificado_medico, manipulacion_alimentos, hijo_en_plantel, grado_instruccion_id', 'required'),
            array('fecha_nacimiento', 'checkFechaNacimiento'),
            array('cedula, mision_id, estado_id, municipio_id, parroquia_id, tipo_cuenta_id, banco_id, cedula_titular, plantel_actual_id, cant_hijos, grado_instruccion_id, numero_cuenta', 'numerical', 'integerOnly' => true),
            array('origen, cedula', 'ECompositeUniqueValidator', 'attributesToAddError'=>'cedula', 'message'=>'El número de cédula ingresado ya se encuentra registrado en el sistema.'),
            array('cedula', 'checkCedulaExists'),
            array('origen, sexo, origen_titular, estatus', 'length', 'max' => 1),
            array('nombre, apellido, twitter', 'length', 'max' => 40),
            array('telefono, telefono_celular', 'length', 'max' => 14),
            array('email', 'length', 'max' => 120),
            array('username', 'length', 'max' => 15),
            array('email', 'email'),
            array('foto, password', 'length', 'max' => 255),
            array('direccion', 'length', 'max'=>400),
            array('certificado_medico, manipulacion_alimentos, hijo_en_plantel', 'length', 'max' => 2),
            array('numero_cuenta', 'length', 'max' => 20, 'min' => 20),
            array('nombre_titular', 'length', 'max' => 80),
            array('sexo', 'checkSexo'),
            array('banco_id', 'checkBanco'),
            array('estado_id', 'checkEstadoId'),
            array('municipio_id, parroquia', 'checkMunicipioId'),
            array('parroquia', 'checkParroquiaId'),
            array('certificado_medico, manipulacion_alimentos, hijo_en_plantel', 'checkAfirmativoNegativo'),
            array('fecha_nacimiento, direccion, enfermedades, observacion, busqueda, usuario_act_id, fecha_act', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, origen, cedula, fecha_nacimiento, nombre, apellido, sexo, telefono, telefono_celular, email, twitter, foto, mision_id, certificado_medico, manipulacion_alimentos, username, estado_id, municipio_id, parroquia_id, direccion, enfermedades, observacion, tipo_cuenta_id, banco_id, numero_cuenta, origen_titular, cedula_titular, nombre_titular, busqueda, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, estatus, plantel_actual_id, cant_hijos, hijo_en_plantel, grado_instruccion_id, password', 'safe', 'on' => 'search'),
        );
    }
    
    public function checkSexo($attribute, $params=null){
        if(!CGenero::getData('abreviatura', $this->sexo)){
            $this->addError($attribute, 'El Genero o Sexo Indicado no es válido.');
        }
    }
    
    public function checkBanco($attribute, $params=null){
        if(!CBanco::getData('id', $this->banco_id)){
            $this->addError($attribute, 'El Banco Seleccionado no es válido.');
        }
    }

    public function checkEstadoId($attribute, $params=null){
        if(!is_numeric($this->estado_id) || !CEstado::getData('id', $this->estado_id)){
            $this->addError($attribute, 'El Estado seleccionado no es válido.');
        }
    }

    public function checkMunicipioId($attribute, $params=null){
        if(!is_numeric($this->municipio_id) || !CMunicipio::getData('id', $this->municipio_id)){
            $this->addError($attribute, 'El Municipio seleccionado no es válido.');
        }
    }

    public function checkParroquiaId($attribute, $params=null){
        if(!is_null($this->parroquia_id) && (!is_numeric($this->municipio_id) || !CParroquia::getData('id', $this->parroquia_id))){
            $this->addError($attribute, 'La Parroquia seleccionada no es válida.');
        }
    }

    public function checkAfirmativoNegativo($attribute, $params=null){
        $label = $this->getLabel($attribute);
        if(!in_array($this->$attribute, array('Si', 'No'))){
            $this->addError($attribute, 'En el Campo '.$label.' solo debe seleccionar Si o No.');
        }
    }
    
    public function checkCedulaExists($attribute, $params=null){
        if(!Saime::busquedaOrigenCedula($this->origen, $this->cedula)){
            $this->addError($attribute, 'El Documento de Identidad <b>'.$this->origen.'-'.$this->cedula.'</b> no se ha podido encontrar en nuestra base de datos.');
        }
    }
    
    public function checkFechaNacimiento($attribute, $params=null){
        $fechaNacimiento = new DateTime($this->$attribute);
        $today = new DateTime();
        if($fechaNacimiento>=$today){
            $this->addError($attribute, 'La fecha de nacimiento no puede ser mayor o igual al día de hoy.');
        }
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
            'gradoInstruccion' => array(self::BELONGS_TO, 'GradoInstruccion', 'grado_instruccion_id'),
            'plantelActual' => array(self::BELONGS_TO, 'Plantel', 'plantel_actual_id'),
            'mision' => array(self::BELONGS_TO, 'Mision', 'mision_id'),
            'banco' => array(self::BELONGS_TO, 'Banco', 'banco_id'),
            'tipoCuenta' => array(self::BELONGS_TO, 'TipoCuenta', 'tipo_cuenta_id'),
            'parroquia' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_id'),
            'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
            'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
            'colaboradorPlantels' => array(self::HAS_MANY, 'ColaboradorPlantel', 'colaborador_id'),
        );
    }
    
    public function getLabel($key){
        $labels = $this->attributeLabels();
        if(array_key_exists($key, $labels)){
            return $labels[$key];
        }
        return null;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'origen' => 'Origen',
            'cedula' => 'Nro. de Documento de Identidad',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'nombre' => 'Nombre (s)',
            'apellido' => 'Apellido (s)',
            'sexo' => 'Sexo',
            'telefono' => 'Teléfono Fijo',
            'telefono_celular' => 'Teléfono Celular',
            'email' => 'Correo Electrónico',
            'twitter' => 'Twitter',
            'foto' => 'Foto',
            'mision_id' => 'Participa en alguna Misión Social',
            'certificado_medico' => 'Certificado Médico',
            'manipulacion_alimentos' => 'Curso de Manipulación Alimentos',
            'username' => 'Username',
            'estado_id' => 'Estado',
            'municipio_id' => 'Municipio',
            'parroquia_id' => 'Parroquia',
            'direccion' => 'Dirección Referencial',
            'enfermedades' => 'Enfermedad o Alergias que Padece',
            'observacion' => 'Observación',
            'tipo_cuenta_id' => 'Tipo Cuenta Bancaria',
            'banco_id' => 'Entidad Bancaria',
            'numero_cuenta' => 'Número de Cuenta Bancaria',
            'origen_titular' => 'Origen del Titular',
            'cedula_titular' => 'Cédula de Identidad del Titular',
            'nombre_titular' => 'Nombre y Apellido del Titular',
            'busqueda' => 'Busqueda',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'estatus' => 'Estatus',
            'plantel_actual_id' => 'Plantel Actual',
            'cant_hijos' => 'Cantidad de Hijos',
            'hijo_en_plantel' => 'Posee Hijos estudiando en el Plantel',
            'grado_instruccion_id' => 'Grado de Instrucción',
            'password' => 'Password',
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

        $criteria->alias = 't';

        $criteria->with = array(
            'plantelActual' => array('alias' => 'p'),
            'estado' => array('alias' => 'e'),
            'municipio' => array('alias' => 'm'),
        );

        if (is_numeric($this->cedula)) {
            $criteria->compare('t.cedula', $this->cedula);
        }

        if (Utiles::isValidDate($this->fecha_nacimiento, 'y-m-d')) {
            $criteria->compare('t.fecha_nacimiento', $this->fecha_nacimiento, true);
        }

        if (in_array($this->sexo, array('M', 'F'))) {
            $criteria->compare('t.sexo', $this->sexo);
        }

        if (is_numeric($this->estado_id)) {
            $criteria->compare('t.estado_id', $this->estado_id);
        }

        if (is_numeric($this->municipio_id)) {
            $criteria->compare('t.municipio_id', $this->municipio_id);
        }

        if (in_array($this->certificado_medico, array('Si', 'No'))) {
            $criteria->compare('t.certificado_medico', $this->certificado_medico);
        }

        if (in_array($this->manipulacion_alimentos, array('Si', 'No'))) {
            $criteria->compare('t.manipulacion_alimentos', $this->manipulacion_alimentos);
        }

        if (in_array($this->estatus, array('A', 'I', 'E'))) {
            $criteria->compare('t.estatus', $this->estatus);
        }

        if (is_numeric($this->plantel_actual_id)) {
            $criteria->compare('t.plantel_actual_id', $this->plantel_actual_id);
        }elseif(is_array($this->plantel_actual_id)){
            $criteria->addInCondition('t.plantel_actual_id', $this->plantel_actual_id);
        }

        if (!is_null($this->codPlantel)) {
            $criteria->compare('p.cod_plantel', $this->codPlantel);
        }

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.origen', $this->origen);
        $criteria->compare('t.nombre', $this->nombre, true);
        $criteria->compare('t.apellido', $this->apellido, true);
        $criteria->compare('t.telefono', $this->telefono, true);
        $criteria->compare('t.telefono_celular', $this->telefono_celular, true);
        $criteria->compare('t.email', $this->email);
        $criteria->compare('t.twitter', $this->twitter, true);
        $criteria->compare('t.foto', $this->foto, true);
        $criteria->compare('t.mision_id', $this->mision_id);
        $criteria->compare('t.username', $this->username, true);
        $criteria->compare('t.password', $this->password, true);
        $criteria->compare('t.parroquia_id', $this->parroquia_id);
        $criteria->compare('t.direccion', $this->direccion, true);
        $criteria->compare('t.enfermedades', $this->enfermedades, true);
        $criteria->compare('t.observacion', $this->observacion, true);
        $criteria->compare('t.tipo_cuenta_id', $this->tipo_cuenta_id);
        $criteria->compare('t.banco_id', $this->banco_id);
        $criteria->compare('t.numero_cuenta', $this->numero_cuenta, true);
        $criteria->compare('t.origen_titular', $this->origen_titular, true);
        $criteria->compare('t.cedula_titular', $this->cedula_titular);
        $criteria->compare('t.nombre_titular', $this->nombre_titular, true);
        $criteria->compare('t.busqueda', $this->busqueda, true);
        $criteria->compare('t.usuario_ini_id', $this->usuario_ini_id, true);
        $criteria->compare('t.fecha_ini', $this->fecha_ini, true);
        $criteria->compare('t.usuario_act_id', $this->usuario_act_id, true);
        $criteria->compare('t.fecha_act', $this->fecha_act, true);
        $criteria->compare('t.cant_hijos', $this->cant_hijos);
        $criteria->compare('t.hijo_en_plantel', $this->hijo_en_plantel);
        $criteria->compare('t.grado_instruccion_id', $this->grado_instruccion_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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
            $this->username = $this->cedula.Utiles::generarLetraFromCedula($this->cedula);
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
            $persona = Saime::busquedaOrigenCedula($this->origen, $this->cedula);
            $this->fecha_nacimiento = $persona['fecha_nacimiento'];
            return true;
        }else{
            return false;
        }
    }
    
    public function getIdByOrigenYCedula($origen, $cedula){
        $result = null;
        if(in_array($origen, array('V','E','T','P')) && is_numeric($cedula)){
            $sql = 'SELECT id FROM '.$this->tableName().' where origen = :origen AND cedula = :cedula LIMIT 1';
            $query = Yii::app()->db->createCommand($sql);
            $query->bindParam(':origen', $origen, PDO::PARAM_STR);
            $query->bindParam(':cedula', $cedula, PDO::PARAM_INT);            
            $result = $query->queryScalar();
        }
        return $result;
    }
    
    /**
     * 
     *  -- TABLA DE RESPUESTA QUE PODRÁ DAR LA FUNCION PL/PGSQL
     *  -- -------------------------------
     *  --  CODIGO | RESULTADO | MENSAJE
     *  -- -------------------------------
     *  --  S0000  | EXITO     | X Cumple con los requisitos básicos necesarios para ser asignada a un plantel como Madre Colaboradora.
     *  --  W0001  | ALERTA    | X La Madre Colaboradora ya se encuentra asignado a este plantel en el periodo actual.
     *  --  W0002  | ALERTA    | X Cédula de Identidad no registrada como Madre Colaboradora. X
     *  --  E0003  | ERROR     | X El Plantel no es beneficiario PAE.
     *  --  E0004  | ERROR     | X PAE Inactivo en el Plantel.
     *  --  E0005  | ERROR     | X Cédula de Identidad no existente en la base de datos SAIME.
     *  --  E0006  | ERROR     | X La Madre Colaboradora se encuentra asignado a otro plantel en el periodo actual.
     *  --  E0007  | ERROR     | X Sobrepasa la cantidad de Madres Colaboradoras Necesarias para la matricula del Plantel.
     *  --  E0008  | ERROR     | X No existe un periodo escolar activo en el sistema. 
     *  -- -------------------------------
     * 
     * @param string $origen
     * @param int $cedula
     * @param int $plantel
     * @param string $modulo
     * @return array
     */
    public function isValidToAsign($origen, $cedula, $plantel, $modulo){
        
        $result = array();
        $userId = Yii::app()->user->id;
        $userName = Yii::app()->user->name;
        $userIpAddress = Utiles::getRealIP();

        if(in_array($origen, array('V','E','T','P')) && is_numeric($cedula) && is_numeric($plantel) && strlen($modulo)>4){
            
            $sql = 'SELECT gplantel.validate_madre_colaboradora(:origen, :cedula, :plantel, :modulo, :userid, :username, :ipaddress) AS result';
            
            $query = Yii::app()->db->createCommand($sql);
            //$query->bindParam(':seriales', $serialesPg);
            $query->bindParam(':origen', $origen, PDO::PARAM_STR);
            $query->bindParam(':cedula', $cedula, PDO::PARAM_INT);
            $query->bindParam(':plantel', $plantel, PDO::PARAM_INT);
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
            
        }
        
        return $result;
        
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Colaborador the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

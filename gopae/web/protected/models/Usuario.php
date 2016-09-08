<?php

/**
 * This is the model class for table "sistema.usuario".
 *
 * The followings are the available columns in table 'sistema.usuario':
 * @property integer $id
 * @property string $usuario
 * @property string $clave
 * @property string $nombres
 * @property string $apellidos
 * @property string $telefono
 * @property string $correo
 * @property boolean $es_desarrollador
 * @property integer $estado_id
 * @property boolean $activo_ahora
 * @property boolean $es_login_ldap
 * @property boolean $is_activo
 * @property string $ult_direccion_ip
 * @property string $fecha_ult_ingreso
 * @property string $fecha_ini
 * @property integer $usuario_ini_id
 * @property string $fecha_act
 * @property integer $usuario_act_id
 * @property string $fecha_eli
 * @property string $observacion
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Usuario $usuarioAct
 * @property Usuario[] $usuarios
 * @property Usuario $usuarioIni
 * @property Usuario[] $usuarios1
 * @property RolMenuItem[] $rolMenuItems
 * @property RolMenuItem[] $rolMenuItems1
 * @property MenuItem[] $menuItems
 * @property MenuItem[] $menuItems1
 * @property Rol[] $rols
 * @property Rol[] $rols1
 * @property RolUsuario[] $rolUsuarios
 * @property RolUsuario[] $rolUsuarios1
 * @property RolUsuario[] $rolUsuarios2
 * @property LogUsuario[] $logUsuarios
 * @property LogUsuario[] $logUsuarios1
 */
class Usuario extends CActiveRecord {
    
    private $_identity;
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sistema.usuario';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('usuario, clave', 'required', 'on' => 'login'),
            array('estado_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('usuario', 'length', 'max' => 15),
            array('clave', 'length', 'max' => 255),
            array('nombres, apellidos', 'length', 'max' => 50),
            array('telefono', 'length', 'max' => 20),
            array('correo', 'length', 'max' => 140),
            array('ult_direccion_ip', 'length', 'max' => 40),
            array('observacion', 'length', 'max' => 300),
            array('estatus', 'length', 'max' => 1),
            array('es_desarrollador, activo_ahora, es_login_ldap, is_activo, fecha_ult_ingreso, fecha_ini, fecha_act, fecha_eli', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, usuario, clave, nombres, apellidos, telefono, correo, es_desarrollador, estado_id, activo_ahora, es_login_ldap, is_activo, ult_direccion_ip, fecha_ult_ingreso, fecha_ini, usuario_ini_id, fecha_act, usuario_act_id, fecha_eli, observacion, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
            'usuarios' => array(self::HAS_MANY, 'Usuario', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
            'usuarios1' => array(self::HAS_MANY, 'Usuario', 'usuario_ini_id'),
            'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
            'rolMenuItems' => array(self::HAS_MANY, 'RolMenuItem', 'usuario_act_id'),
            'rolMenuItems1' => array(self::HAS_MANY, 'RolMenuItem', 'usuario_ini_id'),
            'menuItems' => array(self::HAS_MANY, 'MenuItem', 'usuario_act_id'),
            'menuItems1' => array(self::HAS_MANY, 'MenuItem', 'usuario_ini_id'),
            'rols' => array(self::HAS_MANY, 'Rol', 'usuario_act_id'),
            'rols1' => array(self::HAS_MANY, 'Rol', 'usuario_ini_id'),
            'rolUsuarios' => array(self::HAS_MANY, 'RolUsuario', 'usuario_id'),
            'rolUsuarios1' => array(self::HAS_MANY, 'RolUsuario', 'usuario_act_id'),
            'rolUsuarios2' => array(self::HAS_MANY, 'RolUsuario', 'usuario_ini_id'),
            'logUsuarios' => array(self::HAS_MANY, 'LogUsuario', 'usuario_act_id'),
            'logUsuarios1' => array(self::HAS_MANY, 'LogUsuario', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Campo id de la tabla usuario',
            'usuario' => 'Usuario',
            'clave' => 'Clave',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'estado_id' => 'Estado',
            'telefono' => 'Telefono de Contacto del Usuario',
            'correo' => 'Correo de Contacto del Usuario',
            'es_desarrollador' => 'Es Desarrollador',
            'estado_id' => 'Estado',
            'activo_ahora' => 'Activo Ahora',
            'es_login_ldap' => 'Es Login Ldap',
            'is_activo' => 'Is Activo',
            'ult_direccion_ip' => 'Ult Direccion Ip',
            'fecha_ult_ingreso' => 'Fecha del ultimo ingreso del usuario',
            'fecha_ini' => 'Fecha de registro incial',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_act' => 'Fecha de actualizacion del registro',
            'usuario_act_id' => 'Usuario Act',
            'fecha_eli' => 'Fecha de eliminacion del registro',
            'observacion' => 'Observaciones Generales del Registro',
            'estatus' => 'Activio o Inactivo (A-I)',
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
        $criteria->compare('usuario', $this->usuario, true);
        $criteria->compare('clave', $this->clave, true);
        $criteria->compare('nombres', $this->nombres, true);
        $criteria->compare('apellidos', $this->apellidos, true);
        $criteria->compare('telefono', $this->telefono, true);
        $criteria->compare('correo', $this->correo, true);
        $criteria->compare('es_desarrollador', $this->es_desarrollador);
        $criteria->compare('estado_id', $this->estado_id);
        $criteria->compare('activo_ahora', $this->activo_ahora);
        $criteria->compare('es_login_ldap', $this->es_login_ldap);
        $criteria->compare('is_activo', $this->is_activo);
        $criteria->compare('ult_direccion_ip', $this->ult_direccion_ip, true);
        $criteria->compare('fecha_ult_ingreso', $this->fecha_ult_ingreso, true);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_eli', $this->fecha_eli, true);
        $criteria->compare('observacion', $this->observacion, true);
        $criteria->compare('estatus', $this->estatus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function validatePassword($clave) {
        return $this->hashPassword($clave) === $this->clave;
    }

    public function hashPassword($clave) {
        return hash('sha512', $clave);
    }

    /**
     * Logs in the user using the given usuario and clave in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->usuario, $this->clave);
            if (!$this->_identity->authenticate()){
                $this->addError('clave', 'Usuario de Red y/o Clave incorrectos.');
            }
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            //$duration = $this->rememberMe ? 3600 * 24 * 1 : 0; // 1 days
            Yii::app()->user->login($this->_identity);
            return true;
        }
        else{
            return false;
        }
    }

    public function getRoles($usuario_id) {
        $connection = Yii::app()->db;

        $sql = "SELECT DISTINCT r.id AS id, r.nombre AS rol
            -- , m_i.modulo AS controlador, m_i.codigo accion, n_a.nombre nivel_acceso_nombre, r_m_i.nivel_acceso_id
            FROM sistema.rol_usuario r_u
            INNER JOIN sistema.rol r ON (r_u.rol_id = r.id)
            -- INNER JOIN sistema.rol_menu_item r_m_i ON (r_m_i.rol_id = r_u.rol_id AND r_m_i.rol_id = r.rol_id)
            -- INNER JOIN sistema.menu_item m_i on (m_i.menu_item_id = r_m_i.menu_item_id)
            -- INNER JOIN sistema.nivel_acceso n_a on (n_a.nivel_id = r_m_i.nivel_acceso_id)
            WHERE r_u.usuario_id = :usuario_id
            -- GROUP BY r_u.rol_id, r.nombre, n_a.nombre, r_m_i.nivel_acceso_id
            ";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);

        return $command->queryAll();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Usuario the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

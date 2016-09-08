<?php

/**
 * UserGroupsIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 * 
 * @author Nicola Puddu
 * @package userGroups
 */
class UserGroupsIdentity extends CUserIdentity {

    private $_id;

    /**
     * @var string $name the username
     */
    private $name;

    /**
     * @var string $group the group id of the user
     */
    private $group;

    /**
     * @var string $groupName the group name of the user
     */
    private $groupName;

    /**
     * @var array $access contains the user access restrictions
     */
    private $accessRules;

    /**
     * @var string $home contains the home of the user
     */
    private $home;

    /**
     * @var int $level level of the user group
     */
    private $level;

    /**
     * @var bool $recovery states if the user is logged in recovery mode
     */
    private $recovery;

    /**
     * @var array contains the profile extensions attributes stored in session
     */
    private $profile;

    /**
     * @var integer $cedula the Name of the User
     */
    private $cedula;

    /**
     * @var string $email the Name of the User
     */
    private $email;

    /**
     * @var string $nombre the Name of the User
     */
    private $nombre;

    /**
     * @var string $apellido the Last Name of the User
     */
    private $apellido;

    /**
     * @var string $estado the State Id of the User
     */
    private $estado;

    /**
     * @var integer $estadoName the State Name of the User
     */
    private $estadoName;
    
    /**
     *
     * @var date Fecha en la que se produjo el último login 
     */
    public $lastLoginTime;

    /**
     * @var boolean $cambio_clave the State cambio_clave of the User
     */
    public $cambio_clave;
    
    /**
     *
     * @var array Unidades Responsables de Atención de Tickets a los que pertenece este usuario
     */
    public $unidadesResp;

    /**
     * these constants rappresent new possible errors
     * @var int
     */
    const ERROR_USER_BANNED = 3;
    const ERROR_USER_INACTIVE = 4;
    const ERROR_USER_APPROVAL = 5;
    const ERROR_PASSWORD_REQUESTED = 6;
    const ERROR_USER_ACTIVE = 7;
    const ERROR_ACTIVATION_CODE = 8;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $model = UserGroupsUser::model()->findByAttributes(array('username' => $this->username));

        // ld($model->getSalt());
        // ld($this->password);
        // ld(md5($this->password . $model->getSalt()));
        // die();

        if (!count($model))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ((int) $model->status === UserGroupsUser::WAITING_ACTIVATION)
            $this->errorCode = self::ERROR_USER_INACTIVE;
        else if ($model->password !== md5($this->password . $model->getSalt()))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else if ((int) $model->status === UserGroupsUser::WAITING_APPROVAL)
            $this->errorCode = self::ERROR_USER_APPROVAL;
        else if ((int) $model->status === UserGroupsUser::BANNED)
            $this->errorCode = self::ERROR_USER_BANNED;
        else if ((int) $model->status === UserGroupsUser::PASSWORD_CHANGE_REQUEST)
            $this->errorCode = self::ERROR_PASSWORD_REQUESTED;
        else {
            $lastLoginTime = date('Y-m-d H:i:s');

            $this->_id = $model->id;
            $this->name = $model->username;
            $this->group = $model->group_id;
            $this->groupName = $model->relUserGroupsGroup->groupname;
            $this->level = $model->relUserGroupsGroup->level;
            $this->accessRules = $this->accessRulesComputation($model);
            $this->home = $model->home ? $model->home : $model->relUserGroupsGroup->home;

            $this->cedula = $model->cedula;
            $this->email = $model->email;
            $this->nombre = $model->nombre;
            $this->apellido = $model->apellido;
            $this->estadoName = $model->estado->nombre;
            $this->estado = $model->estado->id;
            $this->cambio_clave = $model->cambio_clave;
            
            $this->unidadesResp = UnidadRespTicket::getUnidadesResponsableUsuario($model->id);

            $this->setState('_id', $this->_id);
            $this->setState('name', $this->name);
            $this->setState('group', $this->group);
            $this->setState('groupName', $this->groupName);
            $this->setState('level', $this->level);
            $this->setState('home', $this->home);

            $this->setState('cedula', $this->cedula);
            $this->setState('email', $this->email);
            $this->setState('nombre', $this->nombre);
            $this->setState('apellido', $this->apellido);
            $this->setState('estado', $this->estado);
            $this->setState('estadoName', $this->estadoName);
            $this->setState('cambio_clave', $this->cambio_clave);
            $this->setState('unidadesResp', $this->unidadesResp);

            $this->setState('lastLoginTime', $lastLoginTime);

            $this->recovery = false;
            // load profile extension's data
            $this->profileLoad($model);
            // update the last login time
            $model->last_login = $lastLoginTime;
            // last ip address
            $model->last_ip_address = CHttpRequest::getUserHostAddress();
            
            $periodoEscolar = new PeriodoEscolar();
            Yii::app()->getSession()->add('periodoEscolarActual', $periodoEscolar->getPeriodoActivo());
            Yii::app()->getSession()->add('unidadesResp', $this->unidadesResp);

            $this->errorCode = self::ERROR_NONE;
            // run the cronjobs
            UGCron::init();
            UGCron::add(new UGCJGarbageCollection);
            UGCron::add(new UGCJUnban);
            foreach (Yii::app()->controller->module->crons as $c) {
                UGCron::add(new $c);
            }
            UGCron::run();
            $model->save();
        }
        return !$this->errorCode;
    }

    /**
     * login in recovery mode
     * @return boolean wheter is possible to login in recovery mode
     */
    public function recovery() {
        $model = UserGroupsUser::model()->findByAttributes(array('username' => $this->username));

        if (!count($model))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ((int) $model->status === UserGroupsUser::BANNED)
            $this->errorCode = self::ERROR_USER_BANNED;
        else if ((int) $model->status === UserGroupsUser::ACTIVE)
            $this->errorCode = self::ERROR_USER_ACTIVE;
        else if ((int) $model->status === UserGroupsUser::WAITING_APPROVAL)
            $this->errorCode = self::ERROR_USER_APPROVAL;
        else if ($model->activation_code !== $this->password)
            $this->errorCode = self::ERROR_ACTIVATION_CODE;
        else {
            $this->errorCode = self::ERROR_NONE;
            $this->_id = $model->id;
            $this->name = Yii::t('userGroupsModule.general', 'Recovery Mode');
            $this->group = $model->group_id;
            $this->groupName = $model->relUserGroupsGroup->groupname;
            $this->level = $model->relUserGroupsGroup->level;
            $this->accessRules = $this->accessRulesComputation($model);
            $this->home = $model->home;
            $this->recovery = true;
            // load profile extension's data
            $this->profileLoad($model);
            // update the last login time
            $model->last_login = date('Y-m-d H:i:s');
            $model->save();
        }
        return !$this->errorCode;
    }

    /**
     * computates the user access rules
     * @param CActiveData $model
     * @return mixed
     */
    private function accessRulesComputation($model) {
        if (is_array($model->access))
            return array_merge_recursive($model->relUserGroupsGroup->access, $model->access);
        else
            return $model->access;
    }

    /**
     * get profile extensions attribute values that are
     * supposed to be stored in session
     * @param CActiveRecord $model
     * @since 1.7
     */
    private function profileLoad($model) {
        $array = array();
        foreach (Yii::app()->controller->module->profile as $p) {
            $class = new ReflectionClass($p);
            if ($class->hasMethod('profileSessionData')) {
                // TODO when stop supporting php 5.2 just initialize the model with variables
                $class = new $p;
                $relation = 'rel' . $p;
                foreach ($class->profileSessionData() as $sessionAttribute) {
                    $array[$p][$sessionAttribute] = $model->$relation === NULL ? NULL : $model->$relation->$sessionAttribute;
                }
            }
        }

        // memory cleanup
        unset($class);
        unset($relation);
        $this->profile = $array;
    }

    /**
     * returns the user id
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * return the username
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * returns the group id
     * @return int
     */
    public function getGroup() {
        return $this->group;
    }

    /**
     * returns the group name
     * @return string
     */
    public function getGroupName() {
        return $this->groupName;
    }

    /**
     * returns the user group level
     * @return int
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * returns the accessRules value
     * @return mixed
     */
    public function getAccessRules() {
        return $this->accessRules;
    }

    /**
     * returns the user home
     * @return string
     */
    public function getHome() {
        return $this->home;
    }

    /**
     * returns the value of recovery
     * @return bool
     */
    public function getRecovery() {
        return $this->recovery;
    }

    /**
     * returns the value of profile
     * @return array
     * @since 1.7
     */
    public function getProfile() {
        return $this->profile;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getEstadoName() {
        return $this->estadoName;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
        return $this;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
        return $this;
    }

    public function setEstadoName($estadoName) {
        $this->estadoName = $estadoName;
        return $this;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setCedula($cedula) {
        $this->cedula = $cedula;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function __toString() {
        return $this->nombre . ' ' . $this->apellido;
    }

}

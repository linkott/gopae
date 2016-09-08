<?php

/** telefono
 * @author Nicola Puddu
 * @package userGroups
 *
 * This is the model class for table "seguridad.usergroups_user".
 *
 * The followings are the available columns in table 'seguridad.usergroups_user':
 * @property string $id
 * @property string $group_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $home
 * @property integer $status
 * @property string $question
 * @property string $answer
 * @property string $creation_date
 * @property string $activation_code
 * @property string $activation_time
 * @property string $last_login
 * @property string $ban
 * @property string $ban_reason
 * @property string $telefono
 * @property string $nombre
 * @property string $apellido
 * @property integer $cedula
 * @property string $direccion
 * @property integer $estado_id
 * @property string $user_ini_id
 * @property string $date_ini
 * @property string $user_act_id
 * @property string $date_act
 * @property string $user_ban_id
 * @property string $last_ip_address
 * @property string $presento_documento_identidad
 * @property string $foto
 *
 * The followings are the available model relations:
 * @property UsergroupsGroup $group
 * @property Estado $estado
 * @property UsergroupsUser $userIni
 * @property UsergroupsUser[] $usergroupsUsers
 * @property UsergroupsUser $userAct
 * @property UsergroupsUser[] $usergroupsUsers1
 * @property UsergroupsUser $userBan
 * @property UsergroupsUser[] $usergroupsUsers2
 * @property string $verifyCode Código de verificación captcha
 *
 *
 */
class UserGroupsUser extends CActiveRecord {

    public $verifyCode;

    /**
     * contains the access permission's array of the user.
     * may also contain the ROOT_ACCESS constant value
     * @var mixed
     */
    public $access;

    /**
     * contains the value of it's groups level
     * @var int
     */
    public $level;

    /**
     * group name, used just in grid views for filtering purpose
     * @var string
     */
    public $group_name;

    /**
     * group home
     * @var string
     */
    public $group_home;

    /**
     * captcha used on registration
     * @var string
     */
    public $captcha;

    /**
     * home of the user, in a user friendly readable way
     * @var string
     */
    public $readable_home;

    /**
     * old password property. Used when changing password.
     * @var string
     */
    public $old_password;

    /**
     * password confirm property
     * @var string
     */
    public $password_confirm;

    /**
     * these attributes are for the login action
     * @var string
     */
    public $rememberMe;

    /**
     * This is the identity of user on the System Context
     * @var object
     */
    private $_identity;

    /**
     * this constant rappresent the root id
     * @var int
     */
    const ROOT = 1;

    /**
     * this constant rappresent the root access permissions
     * @var string
     */
    const ROOT_ACCESS = 'ALL';

    /**
     * this constant rappresent the root level
     * @var int
     */
    const ROOT_LEVEL = 100;

    /**
     * these constants are for user status
     * @var int
     */
    const BANNED = 0;
    const WAITING_ACTIVATION = 1;
    const WAITING_APPROVAL = 2;
    const PASSWORD_CHANGE_REQUEST = 3;
    const ACTIVE = 4;

    /**
     * these constats rappresent the possible views
     * and must be used in other models when extending
     * the user profile
     * @var string
     */
    const VIEW = 'view';
    const EDIT = 'edit';
    const REGISTRATION = 'registration';

    private $salt = '9BD34BAE40704346501ED79AE2B4EEDB272B9C95C3C1B12B5463588BFE5C1C9F2F4EE1C8D829001CD3EF2A759E7EE9A0C408E655B30CFF887B79B1A1B02C1FE1';

    /**
     * Returns the static model of the specified AR class.
     * @return UserGroupsUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        //return Yii::app()->db->tablePrefix.'usergroups_user';
        return 'seguridad.usergroups_user';
    }

    /**
     * @return array validation rules for model attributes. group name passRequest
     */
    public function rules() {
        // load validation rules folder admin nombre
        Yii::import('userGroups.validation.*');
        // rules
        return array(
            array('group_id', 'length', 'max' => 20),
            array('username, password, home, nombre, telefono,apellido', 'length', 'max' => 120),
            array('direccion', 'length', 'max' => 300),
            array('status, cedula, telefono, estado_id', 'numerical', 'integerOnly' => true),
            array('password', 'match', 'pattern' => '/^[A-Za-z0-9\@\.\,\?\/\*\(\)\_\-\&\^\%\$\#\!\~]+$/', 'message' => 'Formato incorrecto de su clave'), ///^[A-Za-z0-9]{4,}$/
            array('username, password, email, nombre, cedula, estado_id, telefono, date_ini', 'required', 'on' => 'registration'),
            array('email', 'required', 'on' => 'contacto'),
            array('email', 'email', 'message' => "El correo electrónico no posee un formato válido. Ej.: micuenta@dominio.me.gob.ve"),
            array('email', 'unique', 'message' => 'Este Correo ya Existe en nuestra base de datos!', 'on' => 'registration'),
            array('email', 'unique', 'message' => 'Este Correo ya Existe en nuestra base de datos!', 'on' => 'create'),
            array('email', 'unique', 'message' => 'Este Correo ya Existe en nuestra base de datos!', 'on' => 'contacto'),
            array('username, email, home', 'length', 'max' => 120),
            array('rememberMe', 'safe'),
            array('telefono', 'length', 'max' => 14),
            array('telefono', 'numerical', 'integerOnly' => true),
            array('telefono_celular', 'length', 'max' => 14),
            array('telefono_celular', 'numerical', 'integerOnly' => true),
            array('nombre, apellido, twitter', 'length', 'max' => 40),
            array('foto', 'length', 'max' => 350),
            array('presento_documento_identidad', 'length', 'max' => 2),
            array('presento_documento_identidad', 'in', 'range'=>array('SI', 'NO')),
            // rules for registration
            array('captcha', 'required', 'on' => 'registration'),
            array('captcha', 'captcha', 'on' => 'registration'),
            // rules for activation
            array('username, activation_code', 'required', 'on' => 'activate'),
            array('activation_code', 'checkCode', 'on' => 'activate'),
            // rules for passRequest
            array('username, email', 'required', 'on' => 'passRequest'),
            array('email', 'checkMail', 'on' => 'passRequest'),
            array('answer', 'securityQuestion', 'on' => 'passRequest'),
            // rules for mailRequest
            array('mail', 'requestableMail', 'on' => 'mailRequest'),
            // rules for changePassword
            array('old_password', 'required', 'on' => 'changePassword'),
            array('old_password', 'oldPassMatch', 'on' => 'changePassword'),
            // rules for admin
            array('group', 'levelCheck', 'on' => 'admin'),
            // rules for multiple scenarios
            array('username, password', 'required', 'on' => array('login', 'registration')),
            array('email, old_password, password, password_confirm', 'accountOwnership', 'on' => array('changeMisc', 'changePassword')),
            array('email,nombre,telefono,password', 'required', 'on' => array('registration', 'admin', 'mailRequest', 'changeMisc', 'invitation')),
            array('username, email', 'unique', 'on' => array('registration', 'admin', 'recovery', 'changeMisc', 'invitation')),
            /* array('username', 'match', 'pattern'=>'/^[A-Za-z0-9]{4,}$/', 'on'=>array('registration','admin','recovery'),
              'message' => Yii::t('userGroupsModule.general','username must be at least 4 characters and can only be alphanumeric')), */
            array('password', 'required', 'on' => array('recovery', 'changePassword')),
            array('password', 'passwordStrength', 'on' => array('registration', 'admin', 'recovery', 'changePassword')),
            array('password_confirm', 'required', 'on' => array('registration', 'recovery', 'changePassword')),
            array('password_confirm', 'compare', 'compareAttribute' => 'password', 'on' => array('changePassword', 'recovery', 'registration'),
                'message' => 'La Clave de Confirmación no coincide con la Clave Nueva Ingresada'),
            //array('question, answer', 'required', 'on'=>array('recovery', 'registration', 'changePassword')), /*Comentada por JG*/
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, group_name, group_id, username, home, status, nombre,telefono', 'safe', 'on' => 'search'),
            array('date_act', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => false, 'on' => 'update'),
            array('verifyCode', 'checkCaptcha', 'on' => 'login'),
            array('cedula', 'unique', 'message' => 'La Cédula ya se encuentra registrada. El número de Cédula debe ser único', 'on' => 'create'),
            array('username', 'unique', 'message' => 'El Usuario ya se encuentra registrado. El usuario debe ser único', 'on' => 'create'),
            array('cedula', 'unique', 'message' => 'La Cédula ya se encuentra registrada. El número de Cédula debe ser único', 'on' => 'update'),
            array('username', 'unique', 'message' => 'El Usuario ya se encuentra registrado. El usuario debe ser único', 'on' => 'update'),
        );
    }

    public function checkCaptcha($attribute, $params = null) {

        $securimage = new Securimage();

        if ($securimage->check($this->verifyCode) == false) {
            $this->addError($attribute, 'El código de seguridad ingresado es incorrecto.');
        }
    }

    /**
     * check if the group assigned to the user has a lower
     * level then the one of the user who is creating or
     * updating the user
     * This is the 'levelCheck' validator as declared in rules().
     */
    public function levelCheck($attribute, $params) {
        $group = UserGroupsGroup::model()->findByPk((int) $this->group_id);
        if ($group->level >= Yii::app()->user->level)
            $this->addError('level', Yii::t('userGroupsModule.admin', 'You cannot assign to a User a Group that has a Level equal or higher then the one you belong to'));
    }

    /**
     * check if the activation code is valid
     * This is the 'checkCode' validator as declared in rules().
     */
    public function checkCode($attribute, $params) {
        $user = self::model()->findByAttributes(array('username' => $this->username));
        if (empty($user))
            $this->addError('username', Yii::t('userGroupsModule.recovery', 'Username not valid'));
        else if ((int) $user->status !== self::WAITING_ACTIVATION && (int) $user->status !== self::PASSWORD_CHANGE_REQUEST)
            $this->addError('username', Yii::t('userGroupsModule.recovery', 'Username not valid'));
        else if ($user->activation_code !== $this->activation_code)
            $this->addError('activation_code', Yii::t('userGroupsModule.recovery', 'Invalid activation code'));
    }

    /**
     * check if the email belongs to the user
     * This is the 'checkMail' validator as declared in rules().
     */
    public function checkMail($attribute, $params) {
        $user = self::model()->findByAttributes(array('username' => $this->username));
        if (empty($user))
            $this->addError('username', Yii::t('userGroupsModule.recovery', 'Username not valid'));
        else if ((int) $user->status !== self::ACTIVE)
            $this->addError('username', Yii::t('userGroupsModule.recovery', 'Username not valid'));
        else if ($user->email !== $this->email)
            $this->addError('email', Yii::t('userGroupsModule.recovery', 'Invalid email address'));
    }

    /**
     * check the answer to the security question
     * This is the 'securityQuestion' validator as declared in rules().
     */
    public function securityQuestion($attribute, $params) {
        if (UserGroupsConfiguration::findRule('simple_password_reset'))
            return true;
        $user = self::model()->findByAttributes(array('username' => $this->username));
        if (empty($user))
            $this->addError('username', Yii::t('userGroupsModule.recovery', 'Username not valid'));
        else if ((int) $user->status !== self::ACTIVE)
            $this->addError('username', Yii::t('userGroupsModule.recovery', 'Username not valid'));
        else if ($user->answer !== $this->answer) {
            $this->addError('question', $user->question);
            $this->addError('answer', Yii::t('userGroupsModule.recovery', 'Input the right answer'));
        }
    }

    /**
     * check if a mail may be sent to the user corresponding to the
     * given email address
     * This is the 'requestableMail' validator as declared in rules().
     */
    public function requestableMail($attribute, $params) {

        $user = self::model()->findByAttributes(array('email' => $this->email));
        if (empty($user))
            $this->addError('email', Yii::t('userGroupsModule.general', 'Invalid email address'));
        else if ((int) $user->status !== self::WAITING_ACTIVATION)
            $this->addError('email', Yii::t('userGroupsModule.general', 'Invalid email address'));
    }

    /**
     * check if a mail may be sent to the user corresponding to the
     * given email address
     * This is the 'oldPassMatch' validator as declared in rules().
     */
    public function oldPassMatch($attribute, $params) {
        // check if you have user admin permission, in that case this validation will
        // be skipped, otherwise will check if you are trying to update your own account
        if ((Yii::app()->user->pbac('userGroups.user.admin') || Yii::app()->user->pbac('userGroups.admin.admin')) && Yii::app()->user->id !== $this->id)
            return true;
        // load the user model and check if the old password match
        $user = self::model()->findByPk($this->id);
        if ($user->password !== md5($this->old_password . $user->getSalt()))
            $this->addError('old_password', 'No ha ingresado una Clave Correcta. No puede Ingresar la clave anterior.');
    }

    /**
     * check if you own the user account you are about to update
     * This is the 'accountOwnership' validator as declared in rules().
     */
    public function accountOwnership($attribute, $params) {
        // check if you have user admin permission, in that case this validation will
        // be skipped, otherwise will check if you own the account
        if (Yii::app()->user->pbac('userGroups.user.admin') || Yii::app()->user->pbac('userGroups.admin.admin'))
            return true;
        else if ($this->id !== Yii::app()->user->id)
            $this->addError($attribute, Yii::t('userGroupsModule.general', 'You are not allowed to update other accounts'));
    }

    /**
     * @return array relational rules.
     */
    public function relations() {

        // define basic relation with groups
        $relations = array(
            'relUserGroupsGroup' => array(self::BELONGS_TO, 'UserGroupsGroup', 'group_id'),
            'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
            'userIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'user_ini_id'),
            'usergroupsUsersIni' => array(self::HAS_MANY, 'UsergroupsUser', 'user_ini_id'),
            'userAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'user_act_id'),
            'usergroupsUsersAct' => array(self::HAS_MANY, 'UsergroupsUser', 'user_act_id'),
            'userBan' => array(self::BELONGS_TO, 'UsergroupsUser', 'user_ban_id'),
            'usergroupsUsersBan' => array(self::HAS_MANY, 'UsergroupsUser', 'user_ban_id'),
        );

        // extract profile models list
        $modulesData = Yii::app()->getModules();
        $profiles = isset($modulesData['userGroups']['profile']) ? $modulesData['userGroups']['profile'] : array();
        // makes the relations
        foreach ($profiles as $p) {
            $relations['rel' . $p] = array(self::HAS_ONE, $p, 'ug_id');
        }

        return $relations;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'activation_code' => 'Código de Activación',
            'group_id' => Yii::t('userGroupsModule.general', 'Group'),
            'username' => Yii::t('userGroupsModule.general', 'Username'),
            'password' => Yii::t('userGroupsModule.general', 'Password'),
            'password_confirm' => Yii::t('userGroupsModule.general', 'Confirm Password'),
            'old_password' => Yii::t('userGroupsModule.general', 'Old Password'),
            'email' => 'Correo Electrónico',
            'access' => Yii::t('userGroupsModule.general', 'Access'),
            'home' => Yii::t('userGroupsModule.general', 'Home'),
            'creation_date' => Yii::t('userGroupsModule.general', 'Creation Date'),
            'question' => Yii::t('userGroupsModule.install', 'Password Reset: Question'),
            'answer' => Yii::t('userGroupsModule.general', 'Password Reset: Answer'),
            'readable_home' => Yii::t('userGroupsModule.general', 'Home'),
            'captcha' => Yii::t('userGroupsModule.general', 'Verification Code'),
            'rememberMe' => Yii::t('userGroupsModule.general', 'Remember Me'),
            'telefono' => 'Teléfono de Contacto, Ej: (0426)555-7266',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'cedula' => 'Cédula de Identidad',
            'direccion' => 'Dirección',
            'estado_id' => 'Estado',
            'user_ini_id' => 'Usuario Ini',
            'date_ini' => 'Fecha Ini',
            'user_act_id' => 'Usuario Act',
            'date_act' => 'Fecha Act',
            'user_ban_id' => 'Usuario que baneó la cuenta',
            'last_ip_address' => 'Última dirección IP con que el Usuario se ha logueado',
            'foto' => 'Fotografía',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->with = array('relUserGroupsGroup', 'estado',);
        if (Yii::app()->db->drivername === 'pgsql') { // postgres doesn't like unquoted camelcase names
            $criteria->order = '"relUserGroupsGroup".level DESC, "relUserGroupsGroup".groupname';
            $criteria->compare('"relUserGroupsGroup".groupname', $this->group_name, true);
            $criteria->compare('"relUserGroupsGroup".level <', Yii::app()->user->level - 1, false);
            if (Utiles::isValidDate($this->last_login)) {
                $this->last_login = Utiles::transformDate($this->last_login);
                $criteria->addSearchCondition("TO_CHAR(t.last_login, 'YYYY-MM-DD')", $this->last_login, false, 'AND', '=');
            }
        } else {
            $criteria->order = 'relUserGroupsGroup.level DESC, relUserGroupsGroup.groupname';
            $criteria->compare('relUserGroupsGroup.groupname', $this->group_name, true);
            $criteria->compare('relUserGroupsGroup.level <', Yii::app()->user->level - 1, false);
        }
        $criteria->compare('id', $this->id, true);
        if (is_numeric($this->group_id)) {
            $criteria->compare('group_id', $this->group_id, true);
        }
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('home', $this->home, true);
        $criteria->compare('telefono', $this->telefono, true);
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.apellido', $this->apellido, true, 'AND', 'ILIKE');

        if (is_numeric($this->cedula)) {
            $criteria->compare('cedula', $this->cedula);
        }

        if (is_numeric($this->estado_id)) {
            $criteria->compare('estado_id', $this->estado_id);
        }

        $criteria->compare('user_ini_id', $this->user_ini_id, true);
        $criteria->compare('date_ini', $this->date_ini, true);
        $criteria->compare('user_act_id', $this->user_act_id, true);
        $criteria->compare('date_act', $this->date_act, true);

        // set the default to status active unless the person loading the view has
        // user admin rights or admin admin rights
        if (Yii::app()->user->pbac('userGroups.user.admin') || Yii::app()->user->pbac('userGroups.admin.admin'))
            $criteria->compare('status', $this->status === 'null' ? NULL : $this->status);
        else
            $criteria->compare('status', self::ACTIVE);


        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 10),
        ));
    }

    /**
     * parameters additional preparations before saving the user
     */
    protected function beforeSave() {
        if (parent::beforeSave()) {
            // set the new user creation_date
            if ($this->isNewRecord) {
                if(is_null($this->creation_date)) $this->creation_date = date('Y-m-d H:i:s');
                $this->user_ini_id = Yii::app()->user->id;
                $this->date_ini = date('Y-m-d H:i:s');
            } else {
                $this->user_act_id = Yii::app()->user->id;
                $this->date_act = date('Y-m-d H:i:s');
            }

            // populate the attributes when a new record is created in an admin scenario
            if ($this->scenario === 'admin' && $this->isNewRecord && (empty($this->password) || empty($this->username))) {
                $this->status = self::WAITING_ACTIVATION;
                $this->activation_code = uniqid();
                $this->activation_time = date('Y-m-d H:i:s');
                if (empty($this->username))
                    $this->username = uniqid('_user');
            } else if (($this->scenario === 'admin' && $this->isNewRecord) || $this->scenario === 'recovery' || $this->scenario === 'swift_recovery')
            // sets the right status based on configurations
                if ((int) $this->status === self::WAITING_ACTIVATION && UserGroupsConfiguration::findRule('user_need_approval') && ($this->scenario === 'recovery' || $this->scenario === 'swift_recovery'))
                    $this->status = self::WAITING_APPROVAL;
                else
                    $this->status = self::ACTIVE;
            // if it's a new record generates a new password if a password was defined
            if (($this->isNewRecord || $this->scenario === 'recovery' || $this->scenario === 'changePassword') && !empty($this->password)) {
                $this->password = md5($this->password . $this->getSalt());
            }
            // in the passRequest scenario change the status and delete the old password
            if ($this->scenario === 'passRequest') {
                $this->status = self::PASSWORD_CHANGE_REQUEST;
                //$this->password = NULL;  --------> Comentada por JG por error al recuperar contraseña al momento de llamar al model->save()
                /* Agregado por JG para corregir bug password nulo */
                $this->password = md5('Inicio01' . $this->getSalt());
                $this->activation_code = uniqid();
                $this->activation_time = date('Y-m-d H:i:s');
            }
            // on invitations set the waiting_activation status and activation code
            if ($this->scenario === 'invitation') {
                $this->status = self::WAITING_ACTIVATION;
                $this->username = uniqid('_user');
                $this->activation_code = uniqid();
                $this->activation_time = date('Y-m-d H:i:s');
                $this->group_id = UserGroupsConfiguration::findRule('user_registration_group');
            }
            // sets the correct user status and group upon registration based on the configurations
            if ($this->scenario === 'registration') {
                $this->group_id = UserGroupsConfiguration::findRule('user_registration_group');
                if (UserGroupsConfiguration::findRule('user_need_activation')) {
                    $this->status = self::WAITING_ACTIVATION;
                    $this->activation_code = uniqid();
                    $this->activation_time = date('Y-m-d H:i:s');
                } else if (UserGroupsConfiguration::findRule('user_need_approval'))
                    $this->status = self::WAITING_APPROVAL;
                else
                    $this->status = self::ACTIVE;
            }
            // erese the activation code for security reasons
            if ((int) $this->status !== self::WAITING_ACTIVATION && (int) $this->status !== self::WAITING_APPROVAL && (int) $this->status !== self::PASSWORD_CHANGE_REQUEST)
                $this->activation_code = NULL;
            // sanitize the value of home
            if ($this->home === '0')
                $this->home = NULL;
            return true;
        }
        return false;
    }

    protected function afterSave() {
        parent::afterSave();
        // send the needed emails for account activation
        if (($this->scenario === 'admin' || $this->scenario === 'registration') && $this->status === self::WAITING_ACTIVATION) {
            $mail = new UGMail($this, UGMail::ACTIVATION);
            $mail->send();
        }

        // set the flash messages
        if ($this->scenario === 'registration' || $this->scenario === 'recovery' || $this->scenario === 'swift_recovery') {
            if ((int) $this->status === self::WAITING_ACTIVATION)
                Yii::app()->user->setFlash('success', Yii::t('userGroupsModule.general', 'An email was sent with the instructions to activate your account to the address {email}.', array('{email}' => $this->email)));
            else if ((int) $this->status === self::WAITING_APPROVAL)
                Yii::app()->user->setFlash('success', Yii::t('userGroupsModule.general', 'Registration Complete. You now have to wait for an admin to approve your account.'));
            else
                Yii::app()->user->setFlash('success', Yii::t('userGroupsModule.general', 'Registration Complete, you can now login.'));
        }
    }

    /**
     * parameters preparation after a select is executed
     */
    public function afterFind() {

        try {
            if (is_object($this->relUserGroupsGroup)) {
                // retrieve the group name
                $this->group_name = $this->relUserGroupsGroup->groupname;
                // copy the level of it's own group
                $this->level = $this->relUserGroupsGroup->level;
                // copy the group home
                $this->group_home = $this->relUserGroupsGroup->home;
            }
            // retrieve the user access permission's arra
            if ((int) $this->id === self::ROOT)
                $this->access = self::ROOT_ACCESS;
            else {
                $this->access = UserGroupsAccess::findRules(UserGroupsAccess::USER, $this->id);
            }



            // get the user readable home
            $home_array = UserGroupsAccess::homeList();
            if ($this->home)
                $this->readable_home = isset($home_array[$this->home]) ? $home_array[$this->home] : $this->home;
            else
                $this->readable_home = isset($home_array[$this->group_home]) ? $home_array[$this->group_home] . ' - <i><b>Inherited from Group</b></i>' : $this->group_home;
            parent::afterFind();
        } catch (Exception $e) {
            
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login($mode = 'regular') {
        if ($this->_identity === null) {
            if ($mode === 'regular') {
                $this->_identity = new UserGroupsIdentity($this->username, $this->password);
                $this->_identity->authenticate();
            } else if ($mode === 'recovery') {
                $this->_identity = new UserGroupsIdentity($this->username, $this->activation_code);
                $this->_identity->recovery();
            }
        }
        if ($this->_identity->errorCode === UserGroupsIdentity::ERROR_NONE) {
            //$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
            $duration = 3600 * 24 * 30;
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else if ($this->_identity->errorCode === UserGroupsIdentity::ERROR_USER_BANNED)
            $this->addError('username', Yii::t('userGroupsModule.general', 'We are sorry, but your account is banned'));
        else if ($this->_identity->errorCode === UserGroupsIdentity::ERROR_USER_INACTIVE)
            $this->addError('username', Yii::t('userGroupsModule.general', 'Account not active'));
        else if ($this->_identity->errorCode === UserGroupsIdentity::ERROR_USER_APPROVAL)
            $this->addError('username', Yii::t('userGroupsModule.general', 'This account is not approved yet'));
        else if ($this->_identity->errorCode === UserGroupsIdentity::ERROR_PASSWORD_REQUESTED)
            $this->addError('password', Yii::t('userGroupsModule.general', 'A password change has been requested.<br/>You won\'t be able to login until you change the password.'));
        else if ($this->_identity->errorCode === UserGroupsIdentity::ERROR_ACTIVATION_CODE)
            $this->addError('activation_code', Yii::t('userGroupsModule.recovery', 'Invalid activation code'));
        else if ($this->_identity->errorCode === UserGroupsIdentity::ERROR_USER_ACTIVE)
            $this->addError('activation_code', Yii::t('userGroupsModule.recovery', 'This user cannot log in recovery mode.'));
        else
            $this->addError('password', Yii::t('userGroupsModule.recovery', 'wrong user or password.'));
        return false;
    }

    /**
     * @return string the user salt
     */
    public function getSalt() {
        // TODO when stop supporting php 5.2 use dateTime
        // turn the creation_date into the corresponding timestamp
        list($date, $time) = explode(' ', $this->creation_date);
        $date = explode('-', $date);
        $time = explode(':', $time);

        if (!is_null($this->creation_date)) {
            date_default_timezone_set('UTC');
            $timestamp = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
        } else {
            $timestamp = '';
        }
        // create the salt
        $salt = $this->username . $timestamp;
        // add the additional salt if it's provided
        if (isset(Yii::app()->controller->module) && isset(Yii::app()->controller->module->salt))
            $salt .= Yii::app()->controller->module->salt;

        return $salt;
    }

    public function verificarCambioClave($usuario_id) {
        if (is_numeric($usuario_id)) {
            $sql = "SELECT cambio_clave"
                    . " FROM seguridad.usergroups_user"
                    . " where id = :usuario_id";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $resultado = $buqueda->queryScalar();
            return $resultado;
        } else {
            return null;
        }
    }
    
    /**
     * 
     * @param string $password
     */
    public function confirmarClaveUsuario($password) {

        $passwordEncoded = md5($password . self::model()->getSalt());

        $sql = "SELECT COUNT(1) as existe "
                . " FROM seguridad.usergroups_user u"
                . " where u.password = :password"
                . "AND u.id = :id";
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":password", $passwordEncoded, PDO::PARAM_STR);
        $buqueda->bindParam(":id", Yii::app()->user->id, PDO::PARAM_INT);
        $resultado = $buqueda->queryAll();
        
        if($resultado[0]['existe']==0){
            return false;
        }else if($resultado[0]['existe']==1){
            
            return true;
        }
        
        
    }

    /**
     * Validador propio que comprueba si el DNI introducido es válido
     *
     * El DNI es un identificador único obligatorio para todos los ciudadanos de
     * España y de varios países americanos.
     *
     * Formato: entre 1 y 8 números seguidos de 1 letra
     * Ejemplos: 12345678Z - 11111111H - 01234567L
     *
     * Los números se pueden escoger aleatoriamente, pero la letra depende de los
     * números y por tanto, actúa como carácter de control. ¿Cómo se obtiene la
     * letra a partir de los números?
     *
     * 1. Obtener el 'mod 23' (resto de la división entera) del número
     * (e.g.: 12345678 mod 23 = 14).
     * 2. Utilizar la siguiente tabla para elegir la letra que corresponde al
     * resultado de la operación anterior.
     *
     * +--------+----+----+----+----+----+----+----+----+----+----+----+----+
     * | mod 23 | 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 | 10 | 11 |
     * +--------+----+----+----+----+----+----+----+----+----+----+----+----+
     * | letra | T | R | W | A | G | M | Y | F | P | D | X | B |
     * +--------+----+----+----+----+----+----+----+----+----+----+----+----+
     * | mod 23 | 12 | 13 | 14 | 15 | 16 | 17 | 18 | 19 | 20 | 21 | 22 | |
     * +--------+----+----+----+----+----+----+----+----+----+----+----+----+
     * | letra | N | J | Z | S | Q | V | H | L | C | K | E | |
     * +--------+----+----+----+----+----+----+----+----+----+----+----+----+
     *
     */
    public function esDniValido($dni) {
        // Comprobar que el formato sea correcto
        if (0 === preg_match("/\d{1,8}[a-z]/i", $dni)) {
            $context->addViolationAt('dni', 'El DNI introducido no tiene el formato correcto (entre 1 y 8 números seguidos de una letra, sin guiones y sin dejar ningún espacio en blanco)');

            return;
        }

        // Comprobar que la letra cumple con el algoritmo
        $numero = substr($dni, 0, -1);
        $letra = strtoupper(substr($dni, -1));
        if ($letra != substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($numero, "XYZ", "012") % 23, 1)) {
            $context->addViolationAt('dni', 'La letra no coincide con el número del DNI. Comprueba que has escrito bien tanto el número como la letra');
        }
    }

    /**
     *
     * @param string $level (easy, medium, hard)
     * @return string
     */
    public function getRandomPassword($length = 6, $level = 'easy') {

        if ($level == 'easy') {
            $alphabet = "abcdefghkmqpzywx123456789";
        } elseif ($level == 'medium') {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        } elseif ($level == 'hard') {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789$%&*#";
        }

        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function getUsuariosGrupo($group_id) {

        $sql = "SELECT  username "
                . " FROM seguridad.usergroups_user"
                . " WHERE group_id=:group_id"
                . " ORDER BY id ASC"
                . " --LIMIT 100";
        $busqueda = yii::app()->db->createCommand($sql);
        $busqueda->bindParam(":group_id", $group_id, PDO::PARAM_INT);
        $resultado = $busqueda->queryColumn();

        return $resultado;
    }

    public function updateUsuarioCodActivacion(UserGroupsUser $usuario) {
        date_default_timezone_set('America/Caracas');
        $usuario_id = 1; // SETEADO POR IS, ESTA FUNCION SERA EJECUTADA DESDE UN CONSOLE APLICATTION
        $estatus = self::PASSWORD_CHANGE_REQUEST;
        $activation_code = uniqid();
        $activation_time = date('Y-m-d H:i:s');
        $username = $usuario->username;
        $id = $usuario->id;
        $sql = "UPDATE seguridad.usergroups_user"
                . " SET"
                . " activation_code = :activation_code,"
                . " date_act = :date_act,"
                . " activation_time = :date_act,"
                . " creation_date = :date_act,"
                . " user_act_id = :usuario_id,"
                . " status = :estatus"
                . " WHERE username = :username AND id = :id"
                . " ";
        $update = yii::app()->db->createCommand($sql);
        $update->bindParam(":activation_code", $activation_code, PDO::PARAM_STR);
        $update->bindParam(":date_act", $activation_time, PDO::PARAM_STR);
        $update->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
        $update->bindParam(":estatus", $estatus, PDO::PARAM_INT);
        $update->bindParam(":username", $username, PDO::PARAM_STR);
        $update->bindParam(":id", $id, PDO::PARAM_INT);
        $resultado = $update->execute();
        return $resultado;
    }

}

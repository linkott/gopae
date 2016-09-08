<?php

/**
 * This is the model class for table "seguridad.usergroups_group".
 *
 * The followings are the available columns in table 'seguridad.usergroups_group':
 * @property string $id
 * @property string $groupname
 * @property integer $level
 * @property string $home
 * @property string $description
 * @property integer $user_ini_id
 * @property string $date_ini
 * @property integer $user_act_id
 * @property string $date_act
 * @property string $estatus
 * 
 * The followings are the available model relations:
 * @property UsergroupsUser[] $usergroupsUsers
 * @property UsergroupsUser $userIni
 * @property UsergroupsUser $userAct
 */
class UserGroupsGroup extends CActiveRecord {

    /**
     * contains the group access permission's array
     * @var array
     */
    public $access;
    
    const GROUP_ELEMENT = 2;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UsergroupsGroup the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    } 

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        //return Yii::app()->db->tablePrefix.'usergroups_group';
        return 'seguridad.usergroups_group';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('groupname', 'length', 'max' => 120),
            array('groupname, home, ', 'required', 'on' => 'admin'),
            array('home', 'length', 'min' => 1, 'on'=>'create'),
            array('home', 'length', 'min' => 1, 'on'=>'update'),
            array('home, groupname, level, description', 'required', 'on'=>'create'),
            array('home, groupname, level, description', 'required', 'on'=>'update'),
            array('level', 'numerical', 'integerOnly' => true, 'on'=>'create'),
            array('level', 'numerical', 'integerOnly' => true, 'on'=>'update'),
            array('groupname', 'unique',),
            array('description', 'unique',),
            array('level', 'levelCheck'),
            array('home', 'safe'),
            // rules used on creation
            array('groupname', 'required', 'on' => 'admin'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, groupname, level', 'safe', 'on' => 'search'),
        );
    }

    /**
     * If a new level value is provided it makes sure that it won't be higher then the
     * one of the user updating or creating the group.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function levelCheck($attribute, $params) {
        // skip this check on installation
        if ($this->scenario === 'installation')
            return true;
        if ($this->$attribute >= Yii::app()->user->level)
            $this->addError('level', Yii::t('userGroupsModule.admin', 'You cannot set a Group Level equal or superior to your own'));
        else if ($this->$attribute >= UserGroupsUser::ROOT_LEVEL)
            $this->addError('level', Yii::t('userGroupsModule.admin', 'You cannot set a Group Level equal or higher then Root'));
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usergroupsUsers' => array(self::HAS_MANY, 'UserGroupsUser', 'group_id'),
            'userIni' => array(self::BELONGS_TO, 'UserGroupsUser', 'user_ini_id'),
            'userAct' => array(self::BELONGS_TO, 'UserGroupsUser', 'user_act_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'groupname' => Yii::t('userGroupsModule.general', 'Nombre del Grupo'),
            'level' => Yii::t('userGroupsModule.general', 'Nivel de Acceso'),
            'description' => Yii::t('userGroupsModule.general', 'Descripción'),
            'user_ini_id' => 'User Ini',
            'date_ini' => 'Fecha de Registro del Grupo',
            'user_act_id' => 'Último Usuario que ha Actualizado los datos del Grupo en esta Tabla',
            'date_act' => 'Fecha en la que se produjo la última actualización de datos del Grupo en esta tabla',
            'estatus' => "Estatus del Grupo 'A'=Activo, 'I'=Inactivo.",
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($order='level DESC') {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->order = $order;
        $criteria->compare('id', $this->id, true);
        $criteria->addSearchCondition('t.groupname', '%' . $this->groupname . '%', false, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.description', '%' . $this->description . '%', false, 'AND', 'ILIKE');
        
        $level = trim($this->level);
        if(Utiles::isExpressionToNumericCompare($level)){
            if(is_numeric($this->level)){
                $criteria->addCondition('t.level = '.$level);
            }else{
                $criteria->compare('t.level', $level, true);
            }
        }
        
        $criteria->compare('t.level <', Yii::app()->user->level - 1, false);
        $criteria->compare('user_ini_id',$this->user_ini_id);
        $criteria->compare('date_ini',$this->date_ini,true);
        $criteria->compare('user_act_id',$this->user_act_id);
        $criteria->compare('date_act',$this->date_act,true);
        $criteria->compare('estatus',$this->estatus,true);
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 10),
        ));
    }
    
    public function viewGroup($id){
        
        $model = null;
        if(is_numeric($id)){
            $criteria = new CDbCriteria();
            $criteria->alias = "g";
            $criteria->with = array(
                                "userIni" => array("select" => "id, nombre, apellido, username, cedula"), 
                                "userAct" => array("select" => "id, nombre, apellido, username, cedula"),
                              );
            $criteria->addCondition("g.id = :id");
            $criteria->params = array('id'=>$id);
            $model = $this->find($criteria);
        }
        return $model;
        
    }
    
    /**
     * Eliminación Lógica de Grupos de Usuarios.
     * 
     * @param integer $id
     * @param string $accion 'A'=Activar, 'E'=Inactivar
     */
    public function changeStatusGroup($id, $accion){
        
        $result = new stdClass();
        $result->isSuccess = false;
        $result->message = 'No existe el Grupo Indicado.';
        
        if(in_array($accion, array('E','A'))){
            
            if(is_numeric($id)){

                $group = $this->findByPk($id);

                if($group){

                    $result->message = 'Ha ocurrido un error en el Proceso.';

                    $group->estatus = $accion;
                    $group->user_act_id = Yii::app()->user->id;
                    
                    if($accion=='E'){
                        $group->date_del = date('Y-m-d H:i:s');
                    }

                    if($group->update()){

                        $numRows = $this->changeStatusUsersByGroup($id, $accion);
                        $messageUsers = '';

                        if($numRows>0){
                            $messageUsers = 'Los usuario pertenecientes a este grupo tienen ahora su cuenta '.  strtr($accion, array('A'=>'activa.','E'=>'inactiva.'));
                        }

                        $result->isSuccess = true;
                        $result->message = 'Se ha '. strtr($accion, array('A'=>'activado','E'=>'inactivado')) .' el Grupo '.$group->description.'. '.$messageUsers;

                    }

                }

            }
        }
        else{
            $result->message = 'No se ha especificado la acción a tomar sobre el grupo, recargue la página e intentelo de nuevo.';
        }
        
        return $result;
        
    }
    
    /**
     * 
     * Recibe el id de un grupo e inactiva el conjunto de usuario que pertencen a ese grupo.
     * 
     * @param int $id
     * @param string $accion 'A'=Activar, 'E'=Inactivar
     * @return int
     */
    public function changeStatusUsersByGroup($id, $accion){
        
        $result = 0;
        
        if(in_array($accion, array('E','A'))){
            
            $status = '0';
            
            if($accion=='A'){
                $status = '4';
            }
            
            if(is_numeric($id)){
                $idInt = (int)$id;
                $sql = "UPDATE seguridad.usergroups_user SET status = $status WHERE group_id = :group";
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->bindParam(":group", $idInt, PDO::PARAM_INT);
                $result = $command->execute();

            }
        }
        
        return $result;
        
    }

    /**
     * parameters preparation after a select is executed
     */
    public function afterFind() {
        // load the access permissions for the group
        $this->access = UserGroupsAccess::findRules(UserGroupsAccess::GROUP, $this->id);
        parent::afterFind();
    }

    /**
     * return the group array list
     * @return Array
     */
    public static function groupList() {
        $arrayData = array();
        $criteria = new CDbCriteria;
        $criteria->order = 'groupname ASC, level DESC';
        $criteria->compare('level <', Yii::app()->user->level - 1, false);
        $criteria->addCondition("estatus = 'A'");
        $result = self::model()->findAll($criteria);
        foreach ($result as $r) {
            $arrayData[$r->id] = $r->description;
        }
        return $arrayData;
    }

}

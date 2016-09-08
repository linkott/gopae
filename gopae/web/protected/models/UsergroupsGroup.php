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
 * @property string $date_del
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $userIni
 * @property UsergroupsUser[] $usergroupsUsers
 */
class UsergroupsGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seguridad.usergroups_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('groupname', 'required'),
			array('level, user_ini_id, user_act_id', 'numerical', 'integerOnly'=>true),
			array('groupname', 'length', 'max'=>60),
			array('home, description', 'length', 'max'=>120),
			array('estatus', 'length', 'max'=>1),
			array('date_ini, date_act, date_del', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, groupname, level, home, description, user_ini_id, date_ini, user_act_id, date_act, estatus, date_del', 'safe', 'on'=>'search'),
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
			'userIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'user_ini_id'),
			'usergroupsUsers' => array(self::HAS_MANY, 'UsergroupsUser', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'groupname' => 'Groupname',
			'level' => 'Level',
			'home' => 'Home',
			'description' => 'Description',
			'user_ini_id' => 'User Ini',
			'date_ini' => 'Date Ini',
			'user_act_id' => 'User Act',
			'date_act' => 'Date Act',
			'estatus' => 'Estatus',
			'date_del' => 'Date Del',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('groupname',$this->groupname,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('home',$this->home,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('user_ini_id',$this->user_ini_id);
		$criteria->compare('date_ini',$this->date_ini,true);
		$criteria->compare('user_act_id',$this->user_act_id);
		$criteria->compare('date_act',$this->date_act,true);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('date_del',$this->date_del,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

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
}

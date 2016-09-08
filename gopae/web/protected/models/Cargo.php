<?php

/**
 * This is the model class for table "gplantel.cargo".
 *
 * The followings are the available columns in table 'gplantel.cargo':
 * @property string $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $ente_id
 *
 * The followings are the available model relations:
 * @property Ente $ente
 */
class Cargo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.cargo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fecha_ini, ente_id', 'required'),
            array('usuario_ini_id, usuario_act_id, ente_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 180),
            array('estatus', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, descripcion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, ente_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ente' => array(self::BELONGS_TO, 'Ente', 'ente_id'),
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
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'ente_id' => 'Ente',
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
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('ente_id', $this->ente_id);
        $sort = new CSort();
        $sort->defaultOrder = 'nombre ASC, estatus ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => 8,
            )
        ));
    }

    ////////////////////////////////Obtengo los cargos//////////////////////////////////////
    public function getCargoAutoridad($usuario_id, $ente_id = 1) {
        //var_dump($usuario_id, $plantel_id, $ente_id);
        $estatus = 'A';
        $autoridades = array();
        if (in_array(Yii::app()->user->group, array(UserGroups::ROOT, UserGroups::DESARROLLADOR, UserGroups::JEFE_DRCEE, UserGroups::JEFE_DRCEE_ZONA, UserGroups::JEFE_ZONA, UserGroups::ADMIN_DRCEE, UserGroups::ADMIN_DRCEE_ZONA))) {
            $sql = "SELECT id, nombre
                FROM gplantel.cargo
                WHERE estatus = :estatus AND
                ente_id  = :ente_id ";
            if ($ente_id == 1) {
                $sql.= " AND id not in (8,9) ORDER BY consecutivo"; // 8 ,9 MAESTRO Y PROFESOR
            } else {
                $sql.= " ORDER BY consecutivo";
            }
        } else {
            $sql = "SELECT id, nombre
                FROM gplantel.cargo
                WHERE estatus = :estatus AND
                ente_id  = :ente_id and consecutivo  > (select consecutivo
                                                       from gplantel.cargo c, gplantel.autoridad_plantel a, gplantel.autoridad_zona_educativa az

                                                       where ((a.cargo_id = c.id OR az.cargo_id = c.id) AND (a.usuario_id = :usuario_id OR az.usuario_id = :usuario_id) AND a.estatus = 'A')   LIMIT 1)";
            if ($ente_id == 1) {
                $sql.= " AND id not in (8,9) ORDER BY consecutivo"; // 8 ,9 MAESTRO Y PROFESOR
            } else {
                $sql.= " ORDER BY consecutivo";
            }
        }

        $connection = $this->getDbConnection();

        $command = $connection->createCommand($sql);
        $command->bindParam(':estatus', $estatus);
        $command->bindParam(':ente_id', $ente_id);
        if (!in_array(Yii::app()->user->group, array(UserGroups::ROOT, UserGroups::DESARROLLADOR, UserGroups::JEFE_DRCEE, UserGroups::JEFE_DRCEE_ZONA, UserGroups::JEFE_ZONA, UserGroups::ADMIN_DRCEE, UserGroups::ADMIN_DRCEE_ZONA)))
            $command->bindParam(':usuario_id', $usuario_id);


        $resultadoBusqueda = $command->queryAll();

        foreach ($resultadoBusqueda as $key => $value) {
            $autoridades[$value['id']] = array(
                'id' => $value['id'],
                'nombre' => $value['nombre']
            );
        }
        //  var_dump($autoridades);
        return $autoridades;
    }

///////////////////////////////////fin///////////////////////////////////////////////

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cargo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

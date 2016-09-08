<?php

/**
 * This is the model class for table "gplantel.nivel".
 *
 * The followings are the available columns in table 'gplantel.nivel':
 * @property integer $id
 * @property string $nombre
 * @property integer $tipo_periodo_id
 * @property integer $cantidad
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property string $cant_lapsos
 * @property integer $permite_materia_pendiente
 *
 * The followings are the available model relations:
 * @property ModalidadNivel[] $modalidadNivels
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property TipoPeriodo $tipoPeriodo
 */
class Nivel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.nivel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, tipo_periodo_id, cantidad, cant_lapsos, permite_materia_pendiente', 'required', 'message' => 'El campo {attribute} esta vacio.'),
            //array('cod_estadistico, annio_fundado, latitud, longitud', 'match', 'pattern' => '/^([0-9])+$/', 'message' => 'Por Favor Introduzca los datos correctos, solo puede contener números.'),
            array('cantidad, cant_lapsos, permite_materia_pendiente', 'match', 'pattern' => '/^([0-9])+$/', 'message' => 'Por Favor Introduzca los datos correctos, solo puede contener números.'),
            array('nombre', 'unique', 'message' => 'El campo {attribute} ya existe.'),
            array('tipo_periodo_id, cantidad, cant_lapsos, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true, 'min' => 1),
            array('permite_materia_pendiente', 'numerical', 'integerOnly' => true, 'max' => 1),
            array('nombre', 'length', 'max' => 70),
            array('estatus', 'length', 'max' => 1),
            array('fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, tipo_periodo_id, cantidad, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, permite_materia_pendiente', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'modalidadNivels' => array(self::HAS_MANY, 'ModalidadNivel', 'nivel_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'tipoPeriodo' => array(self::BELONGS_TO, 'TipoPeriodo', 'tipo_periodo_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'tipo_periodo_id' => 'Tipo Periodo',
            'cantidad' => 'Cantidad de periodo',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'cant_lapsos' => 'Cantidad de lapsos',
            'permite_materia_pendiente' => 'Permite Materia Pendiente',
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
        $criteria->addSearchCondition('nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');
        $criteria->compare('tipo_periodo_id', $this->tipo_periodo_id);
        $criteria->compare('cantidad', $this->cantidad);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('permite_materia_pendiente', $this->permite_materia_pendiente);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('cant_lapsos', $this->cant_lapsos, true);
        //$criteria->order = 'estatus ASC, id DESC';
        //$criteria->order = 'estatus ASC';
        $sort = new CSort();
        $sort->defaultOrder = 'nombre ASC, estatus ASC';
        //$sort->defaultOrder = 'estatus ASC';
        //$criteria->defaultOrder('id ASC');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    /**
     * TRAEME LOS DATOS DE LOS USUARIOS DEPENDIENDO DEL ID
     */
    public function datosUsuario($usuarioId) {
        if (is_numeric($usuarioId)) {
            $sql = "SELECT nombre, apellido, username FROM seguridad.usergroups_user
                        WHERE seguridad.usergroups_user.id = :usuario";
            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(":usuario", $usuarioId, PDO::PARAM_INT);
            $resultado = $consulta->queryAll();

            return $resultado[0];
        } else {
            return 0;
        }
    }

    public function eliminarNivel($nivel_id) {

        $usuario_id = Yii::app()->user->id;
        $estatus = 'E';
        $fecha = date('Y-m-d H:i:s');

        $sql = "UPDATE gplantel.nivel
                    SET estatus=:estatus, fecha_elim=:fecha_elim, usuario_act_id=:usuario_act_id
                    WHERE id=:id ";
        $guard = Yii::app()->db->createCommand($sql);

        $guard->bindParam(":usuario_act_id", $usuario_id, PDO::PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $guard->bindParam(":fecha_elim", $fecha, PDO::PARAM_INT);
        $guard->bindParam(":id", $nivel_id, PDO::PARAM_INT);
        $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando actualiza y 0 cuando no actualiza
        // var_dump($resulatadoGuardo); die();
        return $resulatadoGuardo;
    }

    public function activarNivel($nivel_id) {

        $usuario_id = Yii::app()->user->id;
        $estatus = 'A';
        $fecha_ini = date('Y-m-d H:i:s');
        $fecha_elim = null;
        $fecha_act = null;
        $usuarioAct = null;

        $sql = "UPDATE gplantel.nivel
                    SET estatus=:estatus, fecha_act=:fecha_act, usuario_ini_id=:usuario_ini_id, fecha_ini=:fecha_ini, fecha_elim=:fecha_elim, usuario_act_id=:usuario_act_id
                    WHERE id=:id ";
        $guard = Yii::app()->db->createCommand($sql);

        $guard->bindParam(":usuario_ini_id", $usuario_id, PDO::PARAM_INT);
        $guard->bindParam(":usuario_act_id", $usuarioAct, PDO::PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $guard->bindParam(":fecha_act", $fecha_act, PDO::PARAM_INT);
        $guard->bindParam(":fecha_ini", $fecha_ini, PDO::PARAM_INT);
        $guard->bindParam(":fecha_elim", $fecha_elim, PDO::PARAM_INT);
        $guard->bindParam(":id", $nivel_id, PDO::PARAM_INT);
        $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando actualiza y 0 cuando no actualiza
        // var_dump($resulatadoGuardo); die();
        return $resulatadoGuardo;
    }

    /**
     * @param array $ids arreglo unidimensional con lo(s) id(s) de lo(s) nivel(es) que no quiere retornar.
     * @return array Retorna un arreglo con los id y nombre de lo(s) nivel(es)
     */
    public function getNiveles($ids = array()) {
        $niveles = array();
        $sql = "SELECT id, nombre 
                FROM gplantel.nivel
                ";
        if ($ids !== array()) {
            $ids = implode(',', $ids);
            $sql .= " WHERE id NOT IN ($ids) ORDER BY nombre ASC";
        }
        $connection = $this->getDbConnection();
        $command = $connection->createCommand($sql)->queryAll();

        foreach ($command as $key => $value) {
            $niveles[$value['id']] = array(
                'id' => $value['id'],
                'nombre' => $value['nombre']
            );
        }
        return $niveles;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Nivel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

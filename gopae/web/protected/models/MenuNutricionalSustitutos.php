<?php

/**
 * This is the model class for table "nutricion.menu_nutricional_sustitutos".
 *
 * The followings are the available columns in table 'nutricion.menu_nutricional_sustitutos':
 * @property integer $id
 * @property integer $menu_nutricional_alimento_id
 * @property integer $alimentos_id
 * @property string $cantidad
 * @property string $cantidad_mediana
 * @property string $cantidad_grande
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property MenuNutricionalAlimento $menuNutricionalAlimento
 * @property Articulo $alimentos
 */
class MenuNutricionalSustitutos extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'nutricion.menu_nutricional_sustitutos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('menu_nutricional_alimento_id, alimentos_id, cantidad, usuario_ini_id, fecha_ini, estatus, cantidad_mediana, cantidad_grande', 'required'),
            array('menu_nutricional_alimento_id, alimentos_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('estatus', 'length', 'max' => 1),
            array('fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, menu_nutricional_alimento_id, alimentos_id, cantidad, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'menuNutricionalAlimento' => array(self::BELONGS_TO, 'MenuNutricionalAlimento', 'menu_nutricional_alimento_id'),
            'alimentos' => array(self::BELONGS_TO, 'Articulo', 'alimentos_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'menu_nutricional_alimento_id' => 'Menu Nutricional Alimento',
            'alimentos_id' => 'Alimentos',
            'cantidad' => 'Cantidad',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'cantidad_mediana' => 'Cantidad Mediana',
            'cantidad_grande'=>'Cantidad Grande'
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
        $criteria->compare('menu_nutricional_alimento_id', $this->menu_nutricional_alimento_id);
        $criteria->compare('alimentos_id', $this->alimentos_id);
        $criteria->compare('cantidad', $this->cantidad, true);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchAlimentoSustituto($id) {
        $resultado = '';
        if (is_numeric($id)) {
            $sql = "SELECT mnas.id as id,mnas.cantidad as cantidad, mnas.estatus as estatus , a.nombre AS nombre 
			FROM nutricion.menu_nutricional_sustitutos mnas 
                        inner JOIN nutricion.menu_nutricional_alimento mna ON mna.id = mnas.menu_nutricional_alimento_id
                        inner JOIN nutricion.articulo a ON a.id = mnas.alimentos_id
                        where mna.id = :menu AND mnas.estatus = 'A' AND a.tipo_articulo_id = 1
                        ORDER BY a.nombre ASC";
            $guardado = Yii::app()->db->createCommand($sql);
            $guardado->bindParam(":menu", $id, PDO::PARAM_INT);
            $resultado = $guardado->queryAll();
        }
        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 5,
            ),
                )
        );
    }

    public function AlimentoEnListaSustitutos($idAlimento, $menu) {
        $resultado = '';
        $sql = "SELECT a.nombre FROM nutricion.menu_nutricional_sustitutos mns "
                . "INNER JOIN nutricion.menu_nutricional_alimento mna on mns.menu_nutricional_alimento_id=mna.id "
                . "INNER JOIN nutricion.menu_nutricional mn on mn.id = mna.menu_nutricional_id "
                . "INNER JOIN nutricion.articulo a on a.id = mns.alimentos_id "
                . "WHERE mns.alimentos_id = :menuAlimentos "
                . "AND mna.menu_nutricional_id = :menuNutricional";
        $guardado = Yii::app()->db->createCommand($sql);
        $guardado->bindParam(":menuAlimentos", $idAlimento, PDO::PARAM_INT);
        $guardado->bindParam(":menuNutricional", $menu, PDO::PARAM_INT);
        $resultado = $guardado->queryAll();
        
        return $resultado;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MenuNutricionalSustitutos the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

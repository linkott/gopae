<?php

/**
 * This is the model class for table "nutricion.articulo".
 *
 * The followings are the available columns in table 'nutricion.articulo':
 * @property integer $id
 * @property string $nombre
 * @property integer $unidad_medida_id
 * @property integer $tipo_articulo_id
 * @property integer $precio_regulado
 * @property integer $precio_baremo
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $franja_id
 *
 * The followings are the available model relations:
 * @property UnidadMedida $unidadMedida
 */
class Articulo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'nutricion.articulo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//			array('nombre, unidad_medida_id, tipo_articulo_id, precio_regulado, precio_baremo, franja_id', 'required', 'on' => 'validarArticulo'),
            array('nombre, unidad_medida_id, tipo_articulo_id, precio_regulado, precio_baremo, franja_id', 'required'),
            array('nombre', 'unique'),
            array('unidad_medida_id, usuario_ini_id, usuario_act_id, precio_regulado, precio_baremo', 'numerical', 'integerOnly' => false),
            array('nombre', 'length', 'max' => 160),
            array('estatus', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, unidad_medida_id, precio_regulado, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'unidadMedida' => array(self::BELONGS_TO, 'UnidadMedida', 'unidad_medida_id'),
            'unidadMonetaria' => array(self::BELONGS_TO, 'UnidadMonetaria', 'unidad_monetaria_id'),
            'tipoArticulo' => array(self::BELONGS_TO, 'TipoArticulo', 'tipo_articulo_id'),
            'franja' => array(self::BELONGS_TO, 'Franja', 'franja_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'unidad_medida_id' => 'Unidad Medida',
            'tipo_articulo_id' => 'Tipo Articulo',
            'precio_regulado' => 'Precio Nacional',
            'precio_baremo' => 'Precio Baremo',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'franja_id' => 'Franja',
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
    public function search($tipo) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->addSearchCondition('t.nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');
//                var_dump($this->precio_regulado);
        if (is_numeric($this->precio_regulado)) {
            if (strlen($this->precio_regulado) < 10) {
                $criteria->compare('precio_regulado', $this->precio_regulado);
            }
        }
        if (is_numeric($this->precio_baremo)) {
            if (strlen($this->precio_baremo) < 10) {
                $criteria->compare('precio_baremo', $this->precio_baremo);
            }
        }
        if (is_numeric($this->franja_id)) {
            if (strlen($this->franja_id) < 10) {
                $criteria->compare('franja_id', $this->franja_id);
            }
        }
        if (is_numeric($this->unidad_medida_id)) {
            if (strlen($this->unidad_medida_id) < 10) {
                $criteria->compare('unidad_medida_id', $this->unidad_medida_id);
            }
        }
//                if (is_numeric($this->tipo_articulo_id)) {
        if (strlen($this->tipo_articulo_id) < 10) {
            $alimento = TipoArticulo::model()->findAll(array('condition' => "nombre ILIKE '" . $tipo . "'"));
            if (isset($alimento[0])) {
                $alimento = $alimento[0]['id'];
                if (is_numeric($alimento)) {
                    $criteria->compare('tipo_articulo_id', $alimento);
                }
            }
        }
        if ($tipo == 'all') {
            $criteria->compare('tipo_articulo_id', $this->tipo_articulo_id);
        }
//                }
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

//        public function searchAlimento()
//	{
//		// @todo Please modify the following code to remove attributes that should not be searched.
//            $id = MenuNutricionalAlimento::model()->findByAttributes(array('menu_id'=>$id));
//		$criteria=new CDbCriteria;
//
//		$criteria->compare('id',$this->id);
//                $criteria->addSearchCondition('t.nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');
////                var_dump($this->precio_regulado);
//                if (is_numeric($this->precio_regulado)) {
//                    if (strlen($this->precio_regulado) < 10) {
//                        $criteria->compare('precio_regulado',$this->precio_regulado);
//                    }
//                }
//                if (is_numeric($this->precio_baremo)) {
//                    if (strlen($this->precio_baremo) < 10) {
//                        $criteria->compare('precio_baremo',$this->precio_baremo);
//                    }
//                }
//                if (is_numeric($this->unidad_medida_id)) {
//                    if (strlen($this->unidad_medida_id) < 10) {
//                        $criteria->compare('unidad_medida_id',$this->unidad_medida_id);
//                    }
//                }
//                if (is_numeric($this->tipo_articulo_id)) {
//                    if (strlen($this->tipo_articulo_id) < 10) {
//                        $criteria->compare('tipo_articulo_id',1);
//                    }
//                }
//                
//		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
//		$criteria->compare('fecha_ini',$this->fecha_ini,true);
//		$criteria->compare('usuario_act_id',$this->usuario_act_id);
//		$criteria->compare('fecha_act',$this->fecha_act,true);
//		$criteria->compare('fecha_elim',$this->fecha_elim,true);
//		$criteria->compare('estatus',$this->estatus,true);
//                $criteria->addInCondition('id', $id);
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//		));
//	}




    public function precioRegion($id) {
        $resultado = '';
        if (is_numeric($id)) {
            $sql = "SELECT pr.id AS precio_region_id, e.id AS estado_id, pr.articulo_id, e.nombre, pr.precio_regulado, u.abreviatura FROM estado e
                        LEFT JOIN precio_region pr ON pr.estado_id = e.id AND pr.articulo_id = '" . $id . "'
                        LEFT JOIN unidad_monetaria u ON u.id = pr.unidad_monetaria_id
                        ORDER BY nombre ASC";
            $guardado = Yii::app()->db->createCommand($sql);
            $encontroPrecioEstado = $guardado->queryAll();
            return $encontroPrecioEstado;
        }
    }

    public function searchAlimento($id) {
        $resultado = '';
        if (is_numeric($id)) {
            $sql = "SELECT mna.id as id,mna.cantidad as cantidad, mna.estatus as estatus , a.nombre AS nombre,(a.precio_baremo) as precio_baremo, um.nombre as unidad_medida ,a.unidad_medida_id as unidad_medida_id, mna.cantidad_mediana as cantidad_mediana, mna.cantidad_grande as cantidad_grande, mn.id as menu_nutricional
			FROM nutricion.menu_nutricional mn
                        inner JOIN nutricion.menu_nutricional_alimento mna ON mn.id = mna.menu_nutricional_id
                        inner JOIN nutricion.articulo a ON a.id = mna.alimentos_id
                        inner JOIN nutricion.unidad_medida um ON a.unidad_medida_id = um.id
                        where mn.id = :menu
                        ORDER BY a.nombre ASC";
            $guardado = Yii::app()->db->createCommand($sql);
            $guardado->bindParam(":menu", $id, PDO::PARAM_INT);
            $resultado = $guardado->queryAll();
        }
        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 20,
            ),
                )
        );
    }

    public function searchAlimentoListado($menu) {
        $resultado = '';
       
            $sql = "SELECT a.id as id, a.nombre AS nombre,a.estatus as estatus , a.unidad_medida_id as unidad_medida 
			FROM nutricion.articulo a
                        where a.tipo_articulo_id = 1 AND id NOT IN
                        (
                        SELECT a.id as id
			FROM nutricion.menu_nutricional mn
                        INNER JOIN nutricion.menu_nutricional_alimento mna ON mn.id = mna.menu_nutricional_id
                        INNER JOIN nutricion.menu_nutricional_sustitutos mns ON mna.id = mns.menu_nutricional_alimento_id
                        INNER JOIN nutricion.articulo a ON a.id = mns.alimentos_id
                        where mn.id = :menu
                        ORDER BY a.nombre ASC
                        ) ORDER BY a.nombre ASC";
            $guardado = Yii::app()->db->createCommand($sql);
            $guardado->bindParam(":menu", $menu, PDO::PARAM_INT);

            $resultado = $guardado->queryAll();
        
        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 5,
                
            ),
                )
        );
    }

    public function precioRegionEstado($estado_id, $id) {
        $resultado = '';
        if (is_numeric($id)) {
            $sql = "SELECT pr.id AS precio_region_id, e.id AS estado_id, pr.articulo_id, e.nombre, pr.precio_regulado, u.abreviatura FROM estado e
                        LEFT JOIN precio_region pr ON pr.estado_id = e.id AND pr.articulo_id = '" . $id . "'
                        LEFT JOIN unidad_monetaria u ON u.id = pr.unidad_monetaria_id
                        WHERE e.id = '" . $estado_id . "' ORDER BY nombre ASC";
            $guardado = Yii::app()->db->createCommand($sql);
            $encontroPrecioEstado = $guardado->queryAll();
            return $encontroPrecioEstado;
        }
    }

    public function eliminarArticulo($articulo_id) {

        $usuario_id = Yii::app()->user->id;
        $estatus = 'E';
        $fecha = date('Y-m-d H:i:s');

        $sql = "UPDATE nutricion.articulo
                        SET estatus=:estatus, fecha_elim=:fecha_elim, usuario_act_id=:usuario_act_id
                        WHERE id=:id ";
        $guard = Yii::app()->db->createCommand($sql);

        $guard->bindParam(":usuario_act_id", $usuario_id, PDO::PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $guard->bindParam(":fecha_elim", $fecha, PDO::PARAM_INT);
        $guard->bindParam(":id", $articulo_id, PDO::PARAM_INT);
        $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando actualiza y 0 cuando no actualiza
        // var_dump($resulatadoGuardo); die();
        return $resulatadoGuardo;
    }

    public function activarArticulo($articulo_id) {

        $usuario_id = Yii::app()->user->id;
        $estatus = 'A';
        $fecha_ini = date('Y-m-d H:i:s');
        $fecha_elim = null;
        $fecha_act = null;
        $usuarioAct = null;

        $sql = "UPDATE nutricion.articulo
                        SET estatus=:estatus, fecha_act=:fecha_act, usuario_ini_id=:usuario_ini_id, fecha_ini=:fecha_ini, fecha_elim=:fecha_elim, usuario_act_id=:usuario_act_id
                        WHERE id=:id ";
        $guard = Yii::app()->db->createCommand($sql);

        $guard->bindParam(":usuario_ini_id", $usuario_id, PDO::PARAM_INT);
        $guard->bindParam(":usuario_act_id", $usuarioAct, PDO::PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $guard->bindParam(":fecha_act", $fecha_act, PDO::PARAM_INT);
        $guard->bindParam(":fecha_ini", $fecha_ini, PDO::PARAM_INT);
        $guard->bindParam(":fecha_elim", $fecha_elim, PDO::PARAM_INT);
        $guard->bindParam(":id", $articulo_id, PDO::PARAM_INT);
        $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando actualiza y 0 cuando no actualiza
        // var_dump($resulatadoGuardo); die();
        return $resulatadoGuardo;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Articulo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

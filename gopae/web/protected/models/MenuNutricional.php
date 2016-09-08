<?php

/**
 * This is the model class for table "nutricion.menu_nutricional".
 *
 * The followings are the available columns in table 'nutricion.menu_nutricional':
 * @property integer $id
 * @property string $nombre
 * @property string $preparacion
 * @property integer $precio_mercado
 * @property integer $precio_baremo
 * @property integer $tipo_menu
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $calorias
 *
 * The followings are the available model relations:
 * @property Planificacion[] $planificacions
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property TipoMenu $tipoMenu
 * @property MenuEstado[] $menuEstados
 * @property MenuNutricionalAlimento[] $menuNutricionalAlimentos
 */
class MenuNutricional extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'nutricion.menu_nutricional';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre,tipo_menu,precio_baremo,calorias, usuario_ini_id, fecha_ini, estatus', 'required'),
            array('precio_mercado, precio_baremo, tipo_menu, usuario_ini_id, usuario_act_id, calorias', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 120),
            array('estatus', 'length', 'max' => 1),
            array('preparacion, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, preparacion, precio_mercado, precio_baremo, tipo_menu, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'planificacions' => array(self::HAS_MANY, 'Planificacion', 'menu_nutricional_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'tipoMenu' => array(self::BELONGS_TO, 'TipoMenu', 'tipo_menu'),
            'menuEstados' => array(self::HAS_MANY, 'MenuEstado', 'menu_nutricional_id'),
            'menuNutricionalAlimentos' => array(self::HAS_MANY, 'MenuNutricionalAlimento', 'menu_nutricional_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'preparacion' => 'Preparacion',
            'precio_mercado' => 'Precio Mercado',
            'precio_baremo' => 'Precio Baremo',
            'tipo_menu' => 'Tipo Menu',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'calorias' => 'Calorías'
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
        $criteria->compare('nombre', strtoupper($this->nombre), true);
        $criteria->compare('preparacion', $this->preparacion, true);
        $criteria->compare('precio_mercado', $this->precio_mercado);
        $criteria->compare('precio_baremo', $this->precio_baremo);
        $criteria->compare('tipo_menu', $this->tipo_menu);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('calorias', $this->calorias, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function obtenerIngredientesInsumos($menu) {
        $filas = '<div class="table-responsive">
        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="4"><b>Ingredientes</b></th>
                    <th colspan="4"><b>Sustituto(s)</b></th>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <th width = "60">Cantidad</th>
                    <th width = "60">Cantidad Mediana</th>
                    <th width = "60">Cantidad Grande</th>
                    <th>Nombre</th>
                    <th width = "60">Cantidad</th>    
                    <th width = "60">Cantidad Mediana</th>
                    <th width = "60">Cantidad Grande</th>

                </tr>
            </thead>

            <tbody>';
        if (is_numeric($menu)) {
            $sql = "SELECT ay.nombre as alimento, mna.cantidad as alimentoCantidadPequena,
		    mna.cantidad_mediana as alimentoCantidadMediana,mna.cantidad_grande as alimentoCantidadGrande,
		    list(a.nombre) as sustituto, list(mns.cantidad::TEXT) as sustitutoCantidadPequena,
		    list(mns.cantidad_mediana::TEXT) as sustitutoCantidadMediana,list(mns.cantidad_grande::TEXT) as sustitutoCantidadGrande
                    FROM nutricion.menu_nutricional_alimento mna
                    LEFT JOIN nutricion.menu_nutricional_sustitutos mns ON mna.id = mns.menu_nutricional_alimento_id
	            LEFT JOIN nutricion.articulo a ON a.id = mns.alimentos_id
                    INNER JOIN nutricion.articulo ay ON ay.id = mna.alimentos_id
                    INNER JOIN nutricion.menu_nutricional mn ON mn.id = mna.menu_nutricional_id
                    WHERE mn.id = :menu
                    GROUP BY alimento,alimentoCantidadPequena,alimentoCantidadMediana,alimentoCantidadGrande";
            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":menu", $menu, PDO::PARAM_INT);

            $resultadoPlanesAsignados = $busqueda->queryAll();

//            var_dump($resultadoPlanesAsignados);

            if ($resultadoPlanesAsignados) {

                foreach ($resultadoPlanesAsignados as $key => $valor) {

                    $sustitutos = str_replace(",", "<br>", $valor["sustituto"]);
                    
                    if (empty($sustitutos)) {
                        $sustitutos = "No tiene";
                    }
                    $sustitutocantidadpequena = str_replace(",", "<br>", $valor["sustitutocantidadpequena"]);
                    
                    if (empty($sustitutocantidadpequena)) {
                        $sustitutocantidadpequena = "-----";
                    }
                    
                    $sustitutocantidadmediana = str_replace(",", "<br>", $valor["sustitutocantidadmediana"]);
                    
                    if (empty($sustitutocantidadmediana)) {
                        $sustitutocantidadmediana = "-----";
                    }
                    $sustitutocantidadgrande = str_replace(",", "<br>", $valor["sustitutocantidadgrande"]);
                    
                    if (empty($sustitutocantidadgrande)) {
                        $sustitutocantidadgrande = "-----";
                    }
                   
                    
                    $filas .= '<tr>'
                            . '<td>' . $valor["alimento"] . '</td>'
                            . '<td>' . $valor["alimentocantidadpequena"] . '</td>'
                            . '<td>' . $valor["alimentocantidadmediana"] . '</td>'
                            . '<td>' . $valor["alimentocantidadgrande"] . '</td>'
                            . '<td>' . $sustitutos . '</td>'
                            . '<td>' . $sustitutocantidadpequena . '</td>'
                            . '<td>' . $sustitutocantidadmediana . '</td>'
                            . '<td>' . $sustitutocantidadgrande . '</td>'
                            . '</tr>';
                }
            }
        }

        $filas .= '
            </tbody>
        </table>
    </div><!-- /.table-responsive -->';

        echo $filas;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MenuNutricional the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

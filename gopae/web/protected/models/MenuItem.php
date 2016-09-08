<?php

/**
 * This is the model class for table "menu_item".
 *
 * The followings are the available columns in table 'menu_item':
 * @property integer $menu_item_id
 * @property string $codigo
 * @property string $nombre
 * @property string $icono
 * @property string $modulo
 * @property string $id_ruta
 * @property string $url
 * @property boolean $es_externa
 * @property integer $item_parent_id
 * @property string $estatus
 * @property string $fe_ini
 * @property integer $usuario_ini_id
 * @property string $fe_act
 * @property integer $usuario_act_id
 * @property string $fe_elim
 * @property integer $consecutivo
 *
 * The followings are the available model relations:
 * @property Usuario $usuarioAct
 * @property Usuario $usuarioIni
 * @property MenuItem $itemParent
 * @property MenuItem[] $menuItems
 * @property RolMenuItem[] $rolMenuItems
 */
class MenuItem extends CActiveRecord {

    Public $menu_item_id;
    Public $codigo;
    Public $nombre;
    Public $icono;
    Public $modulo;
    Public $id_ruta;
    Public $url;
    Public $es_externa;
    Public $item_parent_id;
    Public $consecutivo;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sistema.menu_item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codigo', 'required', 'message' => 'Codigo no puede ser nulo.'),
            array('nombre', 'required', 'message' => 'Nombre no puede ser nulo.'),
            array('url', 'required', 'message' => 'Url no puede ser nulo.'),
            array('item_parent_id', 'required', 'message' => 'Menu no puede ser nulo.'),
            array('consecutivo', 'required', 'message' => 'Nombre no puede ser nulo.'),
            //    array('icono', 'required','message'=>'Icono no puede ser nulo.'),
            array('icono', 'file', 'types' => 'jpg, gif, png', 'maxSize' => '20480', 'tooLarge' => 'El archivo superar los 20 KB. Por favor, sube un archivo más pequeño.', 'message' => 'Icono no puede ser nulo.'),
            array('item_parent_id, usuario_ini_id, usuario_act_id, consecutivo', 'numerical', 'integerOnly' => true),
            array('codigo', 'length', 'max' => 15),
            array('nombre', 'length', 'max' => 25),
            array('icono', 'length', 'max' => 30),
            array('modulo', 'length', 'max' => 60),
            array('id_ruta', 'length', 'max' => 50),
            array('url', 'length', 'max' => 255),
            array('estatus', 'length', 'max' => 1),
            array('es_externa, fe_act, fe_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('menu_item_id, codigo, nombre, icono, modulo, id_ruta, url, es_externa, item_parent_id, estatus, fe_ini, usuario_ini_id, fe_act, usuario_act_id, fe_elim, consecutivo', 'safe', 'on' => 'search'),
        );
    }

    public function ultimoConsecutivo() { //busca cual es el ultimo consecutivo cuando cuando se va agregar un hijo de un padre que no tiene hijos
        $ultimoC = "select consecutivo from sistema.menu_item order by consecutivo desc";
        $ultimoCon = Yii::app()->db->createCommand($ultimoC);
        $ultimoConsecutivo = $ultimoCon->queryRow();

        return $ultimoConsecutivo['consecutivo'];
       //   var_dump($ultimoConsecutivo); die();
    }
    
    /**
     * 
     * @param Integer $consecutivo
     * @return Integer
     */
    public function esPadre($consecutivo){

        if(is_numeric($consecutivo)){
        
            $query = 'SELECT count(1) AS cant_hijos FROM sistema.menu_item WHERE item_parent_id = (
                       SELECT menu_item_id FROM sistema.menu_item WHERE item_parent_id IS NULL AND consecutivo = '.  addslashes($consecutivo).' LIMIT 1
                      )';

            $consultaUnico = Yii::app()->db->createCommand($query);
            $resultado = $consultaUnico->queryAll();
           $resultado= (int)$resultado[0]['cant_hijos'];
      //      var_dump($resultado); die();
            
            return $resultado;

        }else{
            return 0;
        }
        
    }
    
    public function getConsecutivoMaximo($consecutivo) {

 
        
            $query = 'SELECT MAX(consecutivo) AS max_consecutivo FROM sistema.menu_item WHERE item_parent_id = (
                       SELECT m.id FROM sistema.menu_item m WHERE m.item_parent_id IS NULL AND m.consecutivo = '.  addslashes($consecutivo).' LIMIT 1
                      )';

            $consultaUnico = Yii::app()->db->createCommand($query);
            $resultado = $consultaUnico->queryAll();
            $resultado= (int)$resultado[0]['max_consecutivo'];
      //     var_dump($resultado); die();
            
            return $resultado;

        

        
    }
    
    public function actualizarConsecutivos($consecutivo){
        
            $query = 'UPDATE sistema.menu_item SET consecutivo = consecutivo + 1 WHERE consecutivo >'.  addslashes($consecutivo).'';
            $consultaUnico = Yii::app()->db->createCommand($query);
            $resultado = $consultaUnico->query();
           // var_dump(addslashes($consecutivo)); die();
            return $resultado;

    }

    public function nuevoPadre($consecutivo, $icono, $menuItemId) {

        $fecha = date('Y-m-d H:i:s');
        
        if($this->esPadre($consecutivo) > 0){
            $consecutivoReal = $this->getConsecutivoMaximo($consecutivo);
        }else{
            $consecutivoReal = $consecutivo;
        }
        
      //  var_dump($consecutivo); die();
        
        $consecutivoNuevo = $consecutivoReal + 1;

        $this->actualizarConsecutivos($consecutivoReal);

        #Si tiene URL - Nuevo Item
        if($menuItemId == '0I')
        {

            $sql = "INSERT INTO sistema.menu_item
                (codigo, nombre, icono, url, fe_ini, consecutivo)
                 VALUES (:codigo, :nombre, :icono, :url, :fecha , :consecutivo)";
        }
        #Si no tiene URL - Nuevo Padre
        else if($menuItemId == '0P')
        {
            $sql = "INSERT INTO sistema.menu_item
                (codigo, nombre, icono, fe_ini, consecutivo)
                 VALUES (:codigo, :nombre, :icono, :fecha , :consecutivo)";

        }



        $con = Yii::app()->db->createCommand($sql);

        // var_dump($consecutivo);die();
        $con->bindParam(":codigo", $this->codigo, PDO::PARAM_STR);
        $con->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
        if($menuItemId == '0I'){ $con->bindParam(":url", $this->url, PDO::PARAM_STR); }
        $con->bindParam(":icono", $icono, PDO::PARAM_STR);
        $con->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $con->bindParam(":consecutivo", $consecutivoNuevo, PDO::PARAM_INT);
            
        
        $control = $con->execute();
        return ($control > 0);
    }

    public function guardarMenu($icono, $menu_item_id, $nh) {

        $menu_item_id = (int) $menu_item_id;

        if ($nh == 0) {// si tiene hijos
            $item_parent_id = "SELECT item_parent_id FROM sistema.menu_item WHERE consecutivo=$this->consecutivo";
            $consulta = Yii::app()->db->createCommand($item_parent_id);
            $resultado_item_parent_id = $consulta->queryRow();
            //  var_dump($this->consecutivo);
            $resultado_hijo = $resultado_item_parent_id['item_parent_id'];
            //    var_dump($resultado_hijo); die();
        } else {
            $resultado_hijo = $menu_item_id;
        }
        #foreach ($resultado_item_parent_id as $hijo){
        //  $hijo['item_parent_id'];
        //  $resultado_item_parent_id1= $resultado_item_parent_id;
        //    var_dump($menu_item_id1); var_dump($resultado_hijo); die();

        if ($menu_item_id == $resultado_hijo) { // si el id de menu_item es igual al id del padre
            //      var_dump($menu_item_id1); die();
            $fecha = date('Y-m-d H:i:s');
            $consecutivo = $this->consecutivo;
            $consecutivoIncrementado=$consecutivo+1;
            $this->actualizarConsecutivos($consecutivo);

            $sql = "INSERT INTO sistema.menu_item
                (codigo, nombre, icono, url, fe_ini, consecutivo, item_parent_id)
                 VALUES (:codigo, :nombre, :icono, :url, :fecha, :consecutivo, :item_parent_id)";

            $con = Yii::app()->db->createCommand($sql);

            // var_dump($consecutivo);die();
            $con->bindParam(":codigo", $this->codigo, PDO::PARAM_STR);
            $con->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $con->bindParam(":url", $this->url, PDO::PARAM_STR);
            $con->bindParam(":icono", $icono, PDO::PARAM_STR);
            $con->bindParam(":fecha", $fecha, PDO::PARAM_STR);
            $con->bindParam(":consecutivo", $consecutivoIncrementado, PDO::PARAM_INT);
            $con->bindParam(":item_parent_id", $resultado_hijo, PDO::PARAM_INT);
            
            //  $con -> bindParam(":id_area_e", $this -> id_area_e, PDO::PARAM_STR);
            $control = $con->execute();
            return ($control > 0);
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
            'itemParent' => array(self::BELONGS_TO, 'MenuItem', 'item_parent_id'),
            'menuItems' => array(self::HAS_MANY, 'MenuItem', 'item_parent_id'),
            'rolMenuItems' => array(self::HAS_MANY, 'RolMenuItem', 'menu_item_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'menu_item_id' => 'Menu Item',
            'codigo' => 'Codigo de Menu',
            'nombre' => 'Nombre',
            'icono' => 'Icono',
            'modulo' => 'Modulo',
            'id_ruta' => 'Id Ruta',
            'url' => 'Url',
            'es_externa' => 'Es Externa',
            'item_parent_id' => 'Item Parent',
            'estatus' => 'Estatus del Registro. A=Activo, I=Inactivo, E=Eliminado. Solo los registros activos pueden ser tomados en cuenta en el Sistema.',
            'fe_ini' => 'Fecha de Registró Por Primera Vez',
            'usuario_ini_id' => 'Usuario Ini',
            'fe_act' => 'Fecha en la que se modificaron por última vez los datos.',
            'usuario_act_id' => 'Usuario Act',
            'fe_elim' => 'Fecha de Eliminación del Registro',
            'consecutivo' => 'Consecutivo',
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

        $criteria->compare('menu_item_id', $this->menu_item_id);
        $criteria->compare('codigo', $this->codigo, true);
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('icono', $this->icono, true);
        $criteria->compare('modulo', $this->modulo, true);
        $criteria->compare('id_ruta', $this->id_ruta, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('es_externa', $this->es_externa);
        $criteria->compare('item_parent_id', $this->item_parent_id);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('fe_ini', $this->fe_ini, true);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fe_act', $this->fe_act, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fe_elim', $this->fe_elim, true);
        $criteria->compare('consecutivo', $this->consecutivo);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MenuItem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

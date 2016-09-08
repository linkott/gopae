<?php

/**
 * This is the model class for table "administrativo.nota_entrega".
 *
 * The followings are the available columns in table 'administrativo.nota_entrega':
 * @property integer $id
 * @property string $codigo
 * @property integer $orden_compra_id
 * @property string $fecha
 * @property integer $forma_pago_id
 * @property string $lugar_entrega
 * @property string $anticipo
 * @property integer $firma_elaboracion
 * @property integer $firma_revision
 * @property integer $firma_aprobacion
 * @property integer $firma_autorizacion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property string $mes
 * @property integer $anio
 * @property string $archivo_nota_entrega
 *
 * The followings are the available model relations:
 * @property DetalleNotaEntrega[] $detalleNotaEntregas
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 * @property OrdenCompra $ordenCompra
 */
class NotaEntrega extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'administrativo.nota_entrega';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codigo, fecha, usuario_ini_id, fecha_ini, mes, anio, archivo_nota_entrega', 'required'),
            array('orden_compra_id, forma_pago_id, firma_elaboracion, firma_revision, firma_aprobacion, firma_autorizacion, usuario_ini_id, usuario_act_id, anio', 'numerical', 'integerOnly' => true),
            array('codigo', 'length', 'max' => 160),
            array('estatus', 'length', 'max' => 1),
            array('mes', 'length', 'max' => 2),
            array('lugar_entrega, anticipo, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, codigo, orden_compra_id, fecha, forma_pago_id, lugar_entrega, anticipo, firma_elaboracion, firma_revision, firma_aprobacion, firma_autorizacion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, mes, anio', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'detalleNotaEntregas' => array(self::HAS_MANY, 'DetalleNotaEntrega', 'nota_entrega_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'ordenCompra' => array(self::BELONGS_TO, 'OrdenCompra', 'orden_compra_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'codigo' => 'Codigo',
            'orden_compra_id' => 'Orden Compra',
            'fecha' => 'Fecha',
            'forma_pago_id' => 'Forma Pago',
            'lugar_entrega' => 'Lugar Entrega',
            'anticipo' => 'Anticipo',
            'firma_elaboracion' => 'Firma Elaboracion',
            'firma_revision' => 'Firma Revision',
            'firma_aprobacion' => 'Firma Aprobacion',
            'firma_autorizacion' => 'Firma Autorizacion',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'mes' => 'Mes',
            'anio' => 'Anio',
            'archivo_nota_entrega'=>'Archivo de Nota Entrega'
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
        $criteria->compare('codigo', $this->codigo, true);
        $criteria->compare('orden_compra_id', $this->orden_compra_id);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('forma_pago_id', $this->forma_pago_id);
        $criteria->compare('lugar_entrega', $this->lugar_entrega, true);
        $criteria->compare('anticipo', $this->anticipo, true);
        $criteria->compare('firma_elaboracion', $this->firma_elaboracion);
        $criteria->compare('firma_revision', $this->firma_revision);
        $criteria->compare('firma_aprobacion', $this->firma_aprobacion);
        $criteria->compare('firma_autorizacion', $this->firma_autorizacion);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('mes', $this->mes, true);
        $criteria->compare('anio', $this->anio);
        $criteria->compare('archivo_nota_entrega', $this->archivo_nota_entrega);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPorProveedor() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('codigo', $this->codigo, true);
        $criteria->compare('orden_compra_id', $this->orden_compra_id);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('forma_pago_id', $this->forma_pago_id);
        $criteria->compare('lugar_entrega', $this->lugar_entrega, true);
        $criteria->compare('anticipo', $this->anticipo, true);
        $criteria->compare('firma_elaboracion', $this->firma_elaboracion);
        $criteria->compare('firma_revision', $this->firma_revision);
        $criteria->compare('firma_aprobacion', $this->firma_aprobacion);
        $criteria->compare('firma_autorizacion', $this->firma_autorizacion);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('mes', $this->mes, true);
        $criteria->compare('anio', $this->anio);
         $criteria->compare('archivo_nota_entrega', $this->archivo_nota_entrega);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NotaEntrega the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function OrdenCompraProveedor($id) {

        // @todo Please modify the following code to remove attributes that should not be searched.

        $sql = " SELECT p.id as proveedor_id,oc.id, oc.estatus as estatus,oc.codigo as codigo_orden, oc.mes, oc.anio,ne.codigo as codigo, ne.mes nota_entrega_mes, ne.id nota_entrega_mes, ne.estatus estatus_nota_entrega, (uu.nombre || ' ' ||uu.apellido) as usuario, oc.firma_aprobacion as aprobado, ne.codigo"
                . " FROM administrativo.orden_compra oc"
                . " INNER JOIN proveduria.proveedor p ON p.id = oc.proveedor_id"
                . " LEFT JOIN administrativo.nota_entrega ne ON ne.orden_compra_id = oc.id"
                . " LEFT JOIN seguridad.usergroups_user uu ON uu.id = ne.usuario_ini_id"
                . " WHERE p.id = :id AND  oc.firma_aprobacion = 1 ";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 15,
            ),
                )
        );
    }

    public function listadoOrdenCompraInsumo($id) {
        $id = base64_decode($id);

        // @todo Please modify the following code to remove attributes that should not be searched.

$sql = "SELECT a.id,u.siglas as unm,a.nombre ,doc.cantidad as cantidades, doc.precio, ROUND((doc.precio * doc.cantidad),2) as total
FROM administrativo.orden_compra oc 
INNER JOIN administrativo.detalle_orden_compra doc ON oc.id = doc.orden_compra_id 
INNER JOIN nutricion.articulo a ON a.id = doc.alimento_id
INNER JOIN nutricion.unidad_medida u ON u.id = a.unidad_medida_id
WHERE oc.id = :id";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 99,
            ),
                )
        );
    }

    public function listadoOrdenCompraPlato($id) {
        $id = base64_decode($id);

        $mes = date("m") + 1;
        $ano = date("Y");

        if ($mes > 12) {
            $mes = 01;
        }
        // @todo Please modify the following code to remove attributes that should not be searched.

        $sql = "SELECT DISTINCT mn.id as id,mn.nombre,(pp.matricula_general * COUNT(mn.id)) as cantidades,
ROUND((mn.precio_baremo * (pp.matricula_general* COUNT(mn.id)))) as total,
ROUND(mn.precio_baremo::NUMERIC , 2) as precio

   

FROM nutricion.planificacion pl
INNER JOIN gplantel.plantel p ON p.id = pl.plantel_id
INNER JOIN gplantel.plantel_pae pp ON p.id = pp.plantel_id
LEFT JOIN nutricion.menu_nutricional mn ON mn.id = pl.menu_nutricional_id
WHERE p.id = :id  AND EXTRACT(MONTH FROM pl.fecha_inicio) = " . $mes . " AND EXTRACT(YEAR FROM pl.fecha_inicio) = " . $ano . ""
                . "GROUP BY mn.id , mn.nombre,pp.matricula_general";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 15,
            ),
                )
        );
    }
    
    
    
        public function registrarNota($modelOrden, $arrayAlimento, $arrayCantidad) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $arrayPsqlAlimento = Utiles::toPgArray($arrayAlimento) . "::TEXT[]";
        $arrayPsqlCantidad = Utiles::toPgArray($arrayCantidad) . "::TEXT[]";


        $orden_id = $modelOrden["orden_compra_id"];
        $usuario = $modelOrden["usuario_ini_id"];
        $archivo = $modelOrden["archivo_nota_entrega"];



        $sql = "SELECT administrativo.registrar_nota(
                '$archivo',
                $orden_id,
                $usuario,   
                $arrayPsqlAlimento,
                $arrayPsqlCantidad)";

        //$consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        
        
        return $resultado;
    }

    
     public function datosNotaEntrega($id) {

        $sql = "SELECT 
oc.id,                
oc.codigo,
ne.codigo as codigo_nota,
p.cod_estadistico as codigo_estadistico,
tsp.nombre as tipo_servicio,
oc.dias_habiles,
p.nombre as dependencia,
p.telefono_fijo as telefono_plantel,
e.nombre as estado_plantel,
m.nombre as municipio_plantel,
p.direccion as direccion_plantel,
pv.razon_social,
tp.nombre as forma_pago,
oc.lugar_entrega as lugar_entrega, 
ze.nombre as unidad_ejecutora_local,
za.nombre as unidad_administradora,
pv.direccion as proveedor_direccion,
pv.telefono_local as proveedor_telefono,
pv.rif as proveedor_rif,
pe.nombre as proveedor_estado,
pm.nombre as proveedor_municipio,
oc.anticipo,
oc.fecha,
oc.mes,
oc.anio


FROM administrativo.orden_compra oc 
INNER JOIN administrativo.nota_entrega ne ON ne.orden_compra_id = oc.id
INNER JOIN gplantel.plantel p ON p.id = oc.dependencia 
INNER JOIN public.estado e ON e.id = p.estado_id
INNER JOIN public.municipio m ON m.id = p.municipio_id
INNER JOIN gplantel.plantel_pae pp ON p.id = pp.plantel_id 
INNER JOIN gplantel.tipo_servicio_pae tsp ON tsp.id = pp.tipo_servicio_pae_id 
INNER JOIN proveduria.proveedor pv ON pv.id = oc.proveedor_id 
INNER JOIN administrativo.tipo_pago tp ON tp.id = oc.forma_pago_id 
INNER JOIN gplantel.zona_educativa ze ON ze.id = oc.unidad_administradora 
INNER JOIN gplantel.zona_educativa za ON za.id = oc.unidad_ejecutora_local 
INNER JOIN public.estado pe ON pe.id = pv.estado_id
INNER JOIN public.municipio pm ON pm.id = pv.municipio_id 
WHERE ne.id = :id";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return $resultado;
    }
    
    public function datosDetalleNotaEntrega($id) {

        $sql = "SELECT DISTINCT a.nombre ,dne.cantidad, doc.precio
FROM administrativo.nota_entrega ne 
INNER JOIN administrativo.detalle_nota_entrega dne ON ne.id = dne.nota_entrega_id
LEFT JOIN administrativo.orden_compra oc ON oc.id = ne.orden_compra_id
LEFT JOIN administrativo.detalle_orden_compra doc ON oc.id = doc.orden_compra_id AND doc.alimento_id = dne.alimento_id 
INNER JOIN nutricion.articulo a ON a.id = dne.alimento_id
WHERE ne.id = :id
ORDER BY a.nombre ASC";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    public function datosDetalleOrdenCompraPlato($id) {

        $sql = "SELECT a.nombre ,dne.cantidad
FROM administrativo.nota_entrega ne 
INNER JOIN administrativo.detalle_nota_entrega dne ON oc.id = dne.nota_entrega_id 
INNER JOIN nutricion.menu_nutricional a ON a.id = dne.alimento_id
WHERE ne.id = :id";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return $resultado;
    }
}

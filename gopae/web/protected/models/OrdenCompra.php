<?php

/**
 * This is the model class for table "administrativo.orden_compra".
 *
 * The followings are the available columns in table 'administrativo.orden_compra':
 * @property integer $id
 * @property string $codigo
 * @property integer $tipo_servicio
 * @property integer $dias_habiles
 * @property integer $dependencia
 * @property integer $proveedor_id
 * @property integer $unidad_administradora
 * @property integer $unidad_ejecutora_local
 * @property string $fecha
 * @property integer $lugar_compra
 * @property integer $forma_pago_id
 * @property integer $condicion_compra_id
 * @property string $lugar_entrega
 * @property integer $moneda_extranjera_id
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
 *
 * The followings are the available model relations:
 * @property DetalleOrdenCompra[] $detalleOrdenCompras
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 * @property ZonaEducativa $unidadEjecutoraLocal
 * @property ZonaEducativa $unidadAdministradora
 * @property Proveedor $proveedor
 * @property Plantel $dependencia
 */
class OrdenCompra extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'administrativo.orden_compra';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(' tipo_servicio, fecha, usuario_ini_id, fecha_ini', 'required'),
            array('tipo_servicio, dias_habiles, dependencia, proveedor_id, unidad_administradora, unidad_ejecutora_local, lugar_compra, forma_pago_id, condicion_compra_id, moneda_extranjera_id, firma_elaboracion, firma_revision, firma_aprobacion, firma_autorizacion, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('codigo', 'length', 'max' => 160),
            array('estatus', 'length', 'max' => 1),
            array('lugar_entrega, anticipo, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, codigo, tipo_servicio, dias_habiles, dependencia, proveedor_id, unidad_administradora, unidad_ejecutora_local, fecha, lugar_compra, forma_pago_id, condicion_compra_id, lugar_entrega, moneda_extranjera_id, anticipo, firma_elaboracion, firma_revision, firma_aprobacion, firma_autorizacion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'detalleOrdenCompras' => array(self::HAS_MANY, 'DetalleOrdenCompra', 'orden_compra_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'unidadEjecutoraLocal' => array(self::BELONGS_TO, 'ZonaEducativa', 'unidad_ejecutora_local'),
            'unidadAdministradora' => array(self::BELONGS_TO, 'ZonaEducativa', 'unidad_administradora'),
            'proveedor' => array(self::BELONGS_TO, 'Proveedor', 'proveedor_id'),
            'Dependencia' => array(self::BELONGS_TO, 'Plantel', 'dependencia'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'codigo' => 'Codigo',
            'tipo_servicio' => 'Tipo Servicio',
            'dias_habiles' => 'Dias Habiles',
            'dependencia' => 'Dependencia',
            'proveedor_id' => 'Proveedor',
            'unidad_administradora' => 'Unidad Administradora',
            'unidad_ejecutora_local' => 'Unidad Ejecutora Local',
            'fecha' => 'Fecha',
            'lugar_compra' => 'Lugar de Compra',
            'forma_pago_id' => 'Forma de Pago',
            'condicion_compra_id' => 'Condición de Compra',
            'lugar_entrega' => 'Lugar de Entrega',
            'moneda_extranjera_id' => 'Tipo de Moneda',
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
        $criteria->compare('tipo_servicio', $this->tipo_servicio);
        $criteria->compare('dias_habiles', $this->dias_habiles);
        $criteria->compare('dependencia', $this->dependencia);
        $criteria->compare('proveedor_id', $this->proveedor_id);
        $criteria->compare('unidad_administradora', $this->unidad_administradora);
        $criteria->compare('unidad_ejecutora_local', $this->unidad_ejecutora_local);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('lugar_compra', $this->lugar_compra);
        $criteria->compare('forma_pago_id', $this->forma_pago_id);
        $criteria->compare('condicion_compra_id', $this->condicion_compra_id);
        $criteria->compare('lugar_entrega', $this->lugar_entrega, true);
        $criteria->compare('moneda_extranjera_id', $this->moneda_extranjera_id);
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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPorPlantel($id) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('codigo', $this->codigo, true);
        $criteria->compare('tipo_servicio', $this->tipo_servicio);
        $criteria->compare('dias_habiles', $this->dias_habiles);
        $criteria->compare('dependencia', $id);
        $criteria->compare('proveedor_id', $this->proveedor_id);
        $criteria->compare('unidad_administradora', $this->unidad_administradora);
        $criteria->compare('unidad_ejecutora_local', $this->unidad_ejecutora_local);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('lugar_compra', $this->lugar_compra);
        $criteria->compare('forma_pago_id', $this->forma_pago_id);
        $criteria->compare('condicion_compra_id', $this->condicion_compra_id);
        $criteria->compare('lugar_entrega', $this->lugar_entrega, true);
        $criteria->compare('moneda_extranjera_id', $this->moneda_extranjera_id);
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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function listadoPlanificacion($id,$mes,$ano,$tipo_menu) {
        $id = base64_decode($id);

        // @todo Please modify the following code to remove attributes that should not be searched.

        $sql = "SELECT 
DISTINCT 
a.id,
a.nombre,
a.precio_regulado,
a.precio_baremo as precio, 
uma.siglas as unm,
pp.matricula_general, 
pp.matricula_simoncito,
(pp.matricula_general + pp.matricula_simoncito) as matricula_total,
ROUND(SUM(mna.cantidad),2) as cantidades,
ROUND((SUM(mna.cantidad)*a.precio_baremo),2) as Total
FROM nutricion.planificacion pl
INNER JOIN gplantel.plantel p ON p.id = :id
INNER JOIN gplantel.plantel_pae pp ON p.id = pp.plantel_id
INNER JOIN nutricion.menu_nutricional mn ON mn.id = pl.menu_nutricional_id
INNER JOIN nutricion.menu_nutricional_alimento mna ON mn.id = mna.menu_nutricional_id
INNER JOIN nutricion.articulo a ON a.id = mna.alimentos_id
INNER JOIN nutricion.unidad_medida  uma ON uma.id = a.unidad_medida_id
WHERE EXTRACT(MONTH FROM pl.fecha_inicio) = :mes AND EXTRACT(YEAR FROM pl.fecha_inicio) = :ano AND mn.tipo_menu IN ($tipo_menu)
GROUP BY a.id, a.nombre,a.precio_regulado,a.precio_baremo, uma.siglas,pp.matricula_general,pp.matricula_simoncito
ORDER BY a.nombre ASC";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
         $consulta->bindParam(":mes", $mes, PDO::PARAM_INT);
          $consulta->bindParam(":ano", $ano, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 100,
            ),
                )
        );
    }
    
    public function listadoPlanificacionSustituto($id) {
        $id = base64_decode($id);

        // @todo Please modify the following code to remove attributes that should not be searched.

        $sql = "SELECT  mns.id as id,asus.precio_baremo as precio,asus.id as alimento_id,asus.nombre as nombre, umas.nombre as um,mns.cantidad,mns.cantidad_mediana,mns.cantidad_grande
FROM  nutricion.menu_nutricional_sustitutos mns
LEFT JOIN nutricion.articulo asus ON asus.id = mns.alimentos_id
LEFT JOIN nutricion.unidad_medida  umas ON umas.id = asus.unidad_medida_id
WHERE mns.menu_nutricional_alimento_id = :id ";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

     public function EliminarOrden($id) {
        $id = base64_decode($id);

        // @todo Please modify the following code to remove attributes that should not be searched.

        $sql = "DELETE  FROM administrativo.detalle_orden_compra doc WHERE doc.orden_compra_id = :id;"
             . "DELETE  FROM administrativo.orden_compra oc WHERE oc.id = :id";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    
    
    public function listadoPlanificacionPlato($id) {
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

    public function registrarOrden($modelOrden, $arrayAlimento, $arrayCantidad, $arrayPrecio) {
        // @todo Please modify the following code to remove attributes that should not be searched.



        $arrayPsqlOrden = Utiles::toPgArray($modelOrden) . "::TEXT[]";
        $arrayPsqlAlimento = Utiles::toPgArray($arrayAlimento) . "::TEXT[]";
        $arrayPsqlCantidad = Utiles::toPgArray($arrayCantidad) . "::TEXT[]";
        $arrayPsqlPrecio = Utiles::toPgArray($arrayPrecio) . "::TEXT[]";

//        echo "<pre>";
//        var_dump($modelOrden);
//        echo "</pre>";
//        die();
        $tipo_servicio = $modelOrden["tipo_servicio"];
        $dias_habiles = $modelOrden["dias_habiles"];
        $dependencia = $modelOrden["dependencia"];
        $proveedor_id = $modelOrden["proveedor_id"];
        $unidad_administradora = $modelOrden["unidad_administradora"];
        $unidad_ejecutora_local = $modelOrden["unidad_ejecutora_local"];
        $forma_pago_id = $modelOrden["forma_pago_id"];
        $lugar_entrega = (string) $modelOrden["lugar_entrega"];
        $anticipo = $modelOrden["anticipo"];
        $usuario = $modelOrden["usuario_ini_id"];
        $mes = $modelOrden["mes"];
        $anio = (int)$modelOrden["anio"];



        $sql = "SELECT administrativo.registrar_orden(
            $tipo_servicio,
                $dias_habiles,
                $dependencia ,
                $proveedor_id ,
                $unidad_administradora ,
                $unidad_ejecutora_local ,
                $forma_pago_id ,
                '$lugar_entrega',
                $anticipo ,
                $usuario,
                $mes::CHARACTER VARYING,
                $anio,    
                $arrayPsqlAlimento,
                $arrayPsqlCantidad,
                $arrayPsqlPrecio)";


        //$consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }
     public function modificarOrden($modelOrden, $arrayAlimento, $arrayCantidad, $arrayPrecio) {
        // @todo Please modify the following code to remove attributes that should not be searched.



      //  $arrayPsqlOrden = Utiles::toPgArray($modelOrden) . "::TEXT[]";
        $arrayPsqlAlimento = Utiles::toPgArray($arrayAlimento) . "::TEXT[]";
        $arrayPsqlCantidad = Utiles::toPgArray($arrayCantidad) . "::TEXT[]";
        $arrayPsqlPrecio = Utiles::toPgArray($arrayPrecio) . "::TEXT[]";

//        echo "<pre>";
//        var_dump($modelOrden);
//        echo "</pre>";
//        die();
        $tipo_servicio = $modelOrden["tipo_servicio"];
        $dias_habiles = $modelOrden["dias_habiles"];
        $dependencia = $modelOrden["id"];
        $proveedor_id = $modelOrden["proveedor_id"];
        $unidad_administradora = $modelOrden["unidad_administradora"];
        $unidad_ejecutora_local = $modelOrden["unidad_ejecutora_local"];
        $forma_pago_id = $modelOrden["forma_pago_id"];
        $lugar_entrega = (string) $modelOrden["lugar_entrega"];
        $anticipo = $modelOrden["anticipo"];
        $usuario = $modelOrden["usuario_ini_id"];
        $mes = $modelOrden["mes"];
        $anio = (int)$modelOrden["anio"];



        $sql = "SELECT administrativo.modificar_orden(
            $tipo_servicio,
                $dias_habiles,
                $dependencia,
                $proveedor_id ,
                $unidad_administradora ,
                $unidad_ejecutora_local ,
                $forma_pago_id ,
                '$lugar_entrega',
                $anticipo ,
                $usuario,
                $mes::CHARACTER VARYING,
                $anio,    
                $arrayPsqlAlimento,
                $arrayPsqlCantidad,
                $arrayPsqlPrecio)";


        //$consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    public function datosOrdenCompra($id) {

        $sql = "SELECT 
oc.id,                
oc.codigo,
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
WHERE oc.id = :id";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return $resultado;
    }
    
    public function datosDetalleOrdenCompra($id) {

        $sql = "SELECT a.nombre ,doc.cantidad, doc.precio, ROUND((doc.precio * doc.cantidad),2) as total
FROM administrativo.orden_compra oc 
INNER JOIN administrativo.detalle_orden_compra doc ON oc.id = doc.orden_compra_id 
INNER JOIN nutricion.articulo a ON a.id = doc.alimento_id
WHERE oc.id = :id";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    public function datosDetalleOrdenCompraPlato($id) {

        $sql = "SELECT a.nombre ,doc.cantidad, doc.precio, ROUND((doc.precio * doc.cantidad),2) as total,SUM(total) as total_final
FROM administrativo.orden_compra oc 
INNER JOIN administrativo.detalle_orden_compra doc ON oc.id = doc.orden_compra_id 
INNER JOIN nutricion.menu_nutricional a ON a.id = doc.alimento_id
WHERE oc.id = :id";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        // $consulta->bindParam(":tipoServicio", $tipoServicio, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrdenCompra the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

<?php

/**
 * This is the model class for table "sistema.ticket".
 *
 * The followings are the available columns in table 'sistema.ticket':
 * @property integer $id
 * @property string $codigo
 * @property string $descripcion
 * @property string $url
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property integer $tipo_ticket_id
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property string $estatus_ticket_id
 * @property integer $bandeja_actual_id
 * @property integer $bandeja_anterior_id
 * @property integer $responsable_asignado_id
 *
 *
 * The followings are the available model relations:
 * @property UnidadRespTicket $bandejaActual
 * @property UnidadRespTicket $bandejaAnterior
 * @property UsergroupsUser $responsableAsignado
 * @property TipoTicket $tipoTicket
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class Ticket extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sistema.ticket';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            #array('codigo', 'numerical', 'integerOnly' => true),
            array('descripcion, bandeja_actual_id, usuario_ini_id', 'required'),
            array('codigo', 'length', 'max' => 30),
            array('codigo', 'unique'),
            array('usuario_ini_id, usuario_act_id, tipo_ticket_id, estatus_ticket_id, estado_id, bandeja_actual_id, bandeja_anterior_id, responsable_asignado_id', 'numerical', 'integerOnly' => true),
            array('url', 'length', 'max' => 300),
            array('nombre_archivo', 'length', 'max' => 200),
            //array('fecha_ini, fecha_act, fecha_elim', 'length'),
            array('estatus', 'length', 'max' => 1),
            array('descripcion', 'safe'),
            array('observacion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, codigo, descripcion,  url, observacion, usuario_ini_id, usuario_act_id, tipo_ticket_id, fecha_ini, fecha_act, fecha_elim, estatus, estatus_ticket_id, estado_id, bandeja_actual_id, bandeja_anterior_id, responsable_asignado_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'bandejaActual' => array(self::BELONGS_TO, 'UnidadRespTicket', 'bandeja_actual_id'),
            'bandejaAnterior' => array(self::BELONGS_TO, 'UnidadRespTicket', 'bandeja_anterior_id'),
            'responsableAsignado' => array(self::BELONGS_TO, 'UserGroupsUser', 'responsable_asignado_id'),
            'tipoTicket' => array(self::BELONGS_TO, 'TipoTicket', 'tipo_ticket_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UserGroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UserGroupsUser', 'usuario_ini_id'),
            'estatus' => array(self::BELONGS_TO, 'EstatusTicket', 'estatus_ticket_id'),
            'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'codigo' => 'Codigo',
            'descripcion' => 'Descripcion',
            'observacion' => 'Observacion',
            'url' => 'Url',
            'bandeja_actual_id' => 'Unidad Responsable Actual',
            'bandeja_anterior_id' => 'Unidad Responsable Anterior',
            'responsable_asignado_id' => 'Persona asignada para buscar y ejecutar la solución del requerimiento',
            'usuario_ini_id' => 'Usuario Ini',
            'usuario_act_id' => 'Usuario Act',
            'tipo_ticket_id' => 'Tiquet Fk',
            'fecha_ini' => 'Fecha Ini',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'estatus_ticket_id' => 'id ESTATUS',
            'estado_id' => 'Estado'
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
        //var_dump($this); die();
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        //$criteria->join = 'INNER JOIN sistema.tipo_ticket tt ON t.tipo_ticket_id = tt.id INNER JOIN seguridad.usergroups_user u ON t.usuario_ini_id = u.id LEFT JOIN estado e ON t.estado_id = e.id INNER JOIN sistema.unidad_resp_ticket ura ON t.bandeja_actual_id = ura.id INNER JOIN sistema.unidad_resp_ticket urp ON t.bandeja_anterior_id = urp.id';
        $criteria->with = array(
            'bandejaActual',
            'bandejaAnterior',
            'responsableAsignado',
            'tipoTicket' => array('alias' => 'tt'),
            'usuarioAct',
            'usuarioIni',
            'estatus',
            'estado');

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.url', $this->url, true); //Url del Archivo, si el ticket tiene un archivo adjunto.
        $criteria->compare('t.usuario_act_id', $this->usuario_act_id);
        $criteria->compare('t.tipo_ticket_id', $this->tipo_ticket_id);
        $criteria->compare('t.fecha_act', $this->fecha_act, true);
        $criteria->compare('t.fecha_elim', $this->fecha_elim, true);



        if (strlen($this->estatus) == 1) {
            $criteria->compare('t.estatus', $this->estatus, false);
        }

        if (is_numeric($this->estatus_ticket_id)) {
            $criteria->compare('t.estatus_ticket_id', $this->estatus_ticket_id);
        }

        $idsUnidades = $this->getIdsUnidadesResponsables();

        // Lógica de Permisología
        if (in_array(Yii::app()->user->group, array(UserGroups::JEFE_DRCEE, UserGroups::ADMIN_DRCEE, UserGroups::DESARROLLADOR, UserGroups::root, UserGroups::ATENCIONTELEFONICA))) {
            $criteria->compare('t.estado_id', $this->estado_id, false);
        } else {
            if (!in_array(Yii::app()->user->group, array(UserGroups::ATENCIONTELEFONICA))) {
                if (count($idsUnidades) > 1) {
                    $criteria->addInCondition('t.bandeja_actual_id', $idsUnidades);
                    $criteria->addInCondition('tt.unidad_resp_ticket_id', $idsUnidades, false, 'OR');
                } elseif (count($idsUnidades) == 1) {
                    $criteria->compare('t.bandeja_actual_id', $idsUnidades[0], false);
                    $criteria->compare('tt.unidad_resp_ticket_id', $idsUnidades[0], false, 'OR');
                }
                $criteria->compare('t.estado_id', Yii::app()->user->estado, false);
            }

            $criteria->compare('t.responsable_asignado_id', Yii::app()->user->id, false, 'OR');
            $criteria->compare('t.usuario_ini_id', Yii::app()->user->id, false, 'OR');
        }

        if (is_numeric($this->codigo)) {
            $criteria->compare('t.codigo', $this->codigo, false);
        }
        if (is_numeric($this->bandeja_actual_id)) {
            $criteria->compare('t.bandeja_actual_id', $this->bandeja_actual_id);
        }
        if (is_numeric($this->bandeja_anterior_id)) {
            $criteria->compare('t.bandeja_anterior_id', $this->bandeja_anterior_id, true);
        }
        if (is_numeric($this->responsable_asignado_id)) {
            $criteria->compare('t.responsable_asignado_id', $this->responsable_asignado_id, true);
        }
        if (strlen($this->observacion) > 0) {
            $criteria->addSearchCondition('CONCAT(t.observacion, t.descripcion)', $this->observacion, true, 'AND', 'ILIKE');
        }
        if (strlen($this->fecha_ini) > 0 && Utiles::dateCheck($this->fecha_ini)) {
            $this->fecha_ini = Utiles::transformDate($this->fecha_ini);
            $criteria->addSearchCondition("TO_CHAR(t.fecha_ini, 'YYYY-MM-DD')", $this->fecha_ini, false, 'AND', '=');
        } else {
            $this->fecha_ini = '';
        }

        $groupId = Yii::app()->user->group;
//        if ($this->estatus == null and $groupId != UserGroups::root and $groupId != UserGroups::DESARROLLADOR) {
//            //$criteria->compare('t.estatus', $this->estatus='asignado');
//            $criteria->addInCondition('t.estatus', array('A', 'S', 'P'));
//            //var_dump("voy por aqui"); die();
//        }
//        var_dump($this->fecha_ini);Yii::app()->getSession()->add('filtro', $criteria);
//        die();
        Yii::app()->getSession()->add('filtro', $criteria);
        $sort = new CSort();
        $sort->defaultOrder = ' t.fecha_ini DESC, t.id DESC, t.estatus ASC';

        // var_dump($criteria->condition);
        // var_dump($criteria->params);
        // die();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Ticket the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTicket($id) {
        $sql = "SELECT m.descripcion, url, m.observacion, m.estatus, m.fecha_ini,m.fecha_act, m.fecha_elim, u.nombre as nombre_usuario  FROM sistema.ticket m
        LEFT JOIN seguridad.usergroups_user u ON u.id = m.usuario_ini_id
        WHERE m.id = " . $id;
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    public function getDataAuditoria($id) {
        $sql2 = "SELECT  m.descripcion, url, m.observacion, m.estatus, m.fecha_ini,m.fecha_act, m.fecha_elim, u.nombre as nombre_usuario  FROM sistema.ticket m
        LEFT JOIN seguridad.usergroups_user u ON u.id = m.usuario_act_id
        WHERE m.id = " . $id;
        $consulta = Yii::app()->db->createCommand($sql2);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    /**
     * Obtiene los correos electrónicos destino dependiendo del tipo de ticket
     *
     * @param integer $id
     * @return array
     */
    public function getCorreosDestinos($id) {
        $resultado = NULL;
        if (is_numeric($id)) {
            $query = "select d.correo_electronico,
		       tip.nombre as nombre_tipo_ticket,
		       e.nombre, u.correo_unidad,
		       tic.descripcion,
		       d.tipo_ticket_id
                    from sistema.unidad_resp_ticket u
                    inner join sistema.distribucion_ticket d
			on u.id=d.unidad_resp_ticket_id
                    inner join sistema.tipo_ticket tp
			on tp.id=d.tipo_ticket_id
                    inner join public.estado e
			on e.id=d.estado_id
                    inner join sistema.ticket tic
			on tp.id=tic.tipo_ticket_id
                    inner join sistema.tipo_ticket tip
			on tip.id=tic.tipo_ticket_id
	        where
	            tic.tipo_ticket_id = d.tipo_ticket_id AND
	            e.id = (SELECT u.estado_id FROM seguridad.usergroups_user u WHERE u.id = tic.usuario_ini_id LIMIT 1) AND
		    tic.id = :ticket_id";
            //echo "<pre>$query </pre>"; die();
            $consulta = Yii::app()->db->createCommand($query);
            $consulta->bindParam(':ticket_id', $id);
            $resultado = $consulta->queryAll();
        }
        return $resultado;
    }

    public function getExportar() {
        $resultado = NULL;
        $query = "select d.correo_electronico,
		       tip.nombre as nombre_tipo_ticket,
		       e.nombre, u.correo_unidad,
		       tic.descripcion,
		       d.tipo_ticket_id
                    from sistema.unidad_resp_ticket u
                    inner join sistema.distribucion_ticket d
			on u.id=d.unidad_resp_ticket_id
                    inner join sistema.tipo_ticket tp
			on tp.id=d.tipo_ticket_id
                    inner join public.estado e
			on e.id=d.estado_id
                    inner join sistema.ticket tic
			on tp.id=tic.tipo_ticket_id
                    inner join sistema.tipo_ticket tip
			on tip.id=tic.tipo_ticket_id";
        //echo "<pre>$query </pre>"; die();
        $consulta = Yii::app()->db->createCommand($query);
        $consulta->bindParam(':ticket_id', $id);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    public function getPosiblesResponsablesAsignados($bandeja_actual_id = null) {
        $unidad = null;
        $result = null;
        if (is_null($bandeja_actual_id)) {
            $unidad = $this->bandeja_actual_id;
        } elseif (is_numeric($bandeja_actual_id)) {
            $unidad = $bandeja_actual_id;
        }
        $ticket = $this->id;
        if (!is_null($unidad)) {
            $sql = "SELECT DISTINCT
                         un.id AS unidad_id,
                         un.nombre AS unidad_nombre,
                         u.id,
                         e.nombre,
                         u.cedula,
                         u.nombre,
                         u.apellido,
                         u.email,
                         UPPER(u.cedula || ': ' || u.nombre || ' ' || u.apellido || ' (' || e.nombre || ')') AS usuario
                    FROM sistema.unidad_resp_ticket un
                   INNER JOIN sistema.unidad_grupo ug ON ug.unidad_resp_ticket_id = un.id
                   INNER JOIN seguridad.usergroups_group g ON ug.group_id = g.id
                   INNER JOIN seguridad.usergroups_user u ON u.group_id = g.id
                   INNER JOIN sistema.ticket t ON t.bandeja_actual_id = un.id
                   INNER JOIN public.estado e ON u.estado_id = e.id
                   WHERE t.id = :ticket 
                     AND un.id = :unidad
                     AND u.estado_id IN (
                         SELECT ds.estado_id 
                           FROM sistema.distribucion_ticket ds
                          WHERE ds.unidad_resp_ticket_id = un.id
                     ) ORDER BY e.nombre, u.cedula, u.nombre, u.apellido limit 1";
            //echo "<pre>$sql </pre>"; die();
            $asignados = Yii::app()->db->createCommand($sql);
            $asignados->bindParam(":unidad", $unidad, PDO::PARAM_INT);
            $asignados->bindParam(":ticket", $ticket, PDO::PARAM_INT);
            $result = $asignados->queryAll();
        }
        return $result;
    }

    protected function getIdsUnidadesResponsables() {
        $ids = null;
        $unidades = Yii::app()->session->get('unidadesResp');
        if (is_null($unidades)) {
            $unidades = UnidadRespTicket::getUnidadesResponsableUsuario(Yii::app()->user->id);
        }

        if (!is_null($unidades) && is_array($unidades)) {
            foreach ($unidades as $unidad) {
                $ids[] = $unidad['id'];
            }
        }
        return $ids;
    }

    public function getExportarTodo() {
        $result = null;
        $sql = "select
		       tip.nombre as nombre_tipo_ticket, ur.nombre as unidad_responsable, u.username,
		       tic.descripcion, e.nombre as estado, tic.codigo, tip.nombre, tic.fecha_ini, tic.fecha_act, tic.estatus, tic.observacion
                    from sistema.ticket tic
                    inner join sistema.tipo_ticket tip
			on tip.id=tic.tipo_ticket_id
			inner join public.estado e on e.id=tic.estado_id inner join sistema.unidad_resp_ticket ur on tic.bandeja_actual_id=ur.id
			inner join seguridad.usergroups_user u on tic.usuario_ini_id=u.id and tic.usuario_ini_id=u.id";
        $consulta = Yii::app()->db->createCommand($sql);
        $result = $consulta->queryAll();
        return $result;
    }

    public function estadisticas() {
        $sql = "SELECT  r.id, r.nombre, 'AAA'||r.nombre AS titulo , e.nombre as estado, e.id as id_estado,
        COUNT(t.id) AS total,
        SUM(CASE WHEN (t.id IS NOT NULL AND (t.estatus='A' OR t.estatus='R')) THEN 1 ELSE 0 END) AS Activos,
        SUM(CASE WHEN (t.id IS NOT NULL AND t.estatus='S') THEN 1 ELSE 0 END) AS Resueltos,
        SUM(CASE WHEN (t.id IS NOT NULL AND t.estatus='D') THEN 1 ELSE 0 END) AS Devueltos,
        SUM(CASE WHEN (t.id IS NOT NULL AND t.estatus='P') THEN 1 ELSE 0 END) AS Asignados
	FROM public.region r
	INNER JOIN public.estado e
	    ON r.id = e.region_id
	LEFT JOIN sistema.ticket t
	    ON t.estado_id=e.id
    WHERE
	1 = 1
    GROUP BY
	 r.id, r.nombre, titulo ,e.nombre, e.id order by e.nombre";
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        //echo "<pre> $sql </pre>";
        return $resultado;
    }

    public function estadisticaEstado() {
        $resultado = '';
            $sql = "SELECT DISTINCT  e.id, e.nombre as estado, u.nombre as unidad_responsable, u.id as id_unidad,
            COUNT(t.id) AS total,
            SUM(CASE WHEN (t.id IS NOT NULL AND (t.estatus='A' OR t.estatus='R')) THEN 1 ELSE 0 END) AS Activos,
            SUM(CASE WHEN (t.id IS NOT NULL AND t.estatus='S') THEN 1 ELSE 0 END) AS Resueltos,
            SUM(CASE WHEN (t.id IS NOT NULL AND t.estatus='D') THEN 1 ELSE 0 END) AS Devueltos,
            SUM(CASE WHEN (t.id IS NOT NULL AND t.estatus='P') THEN 1 ELSE 0 END) AS Asignados
            FROM public.estado e
            LEFT JOIN sistema.ticket t
                ON t.estado_id=e.id
                LEFT JOIN sistema.unidad_resp_ticket u on t.bandeja_actual_id=u.id
                where e.id='" . Yii::app()->getSession()->get('id_estado') . "'
        GROUP BY
             e.id, e.nombre, u.nombre, u.id order by e.nombre";
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    public function estadisticaUnidades() {
        $resultado = '';
        $sql = "SELECT  e.id, e.nombre as estado, u.nombre as unidad_responsable, u.id as id_unidad,
            COUNT(t.id) AS total,
            SUM(CASE WHEN (t.id IS NOT NULL AND (t.estatus='A' OR t.estatus='R')) THEN 1 ELSE 0 END) AS Activos,
            SUM(CASE WHEN (t.id IS NOT NULL AND t.estatus='S') THEN 1 ELSE 0 END) AS Resueltos,
            SUM(CASE WHEN (t.id IS NOT NULL AND t.estatus='D') THEN 1 ELSE 0 END) AS Devueltos,
            SUM(CASE WHEN (t.id IS NOT NULL AND t.estatus='P') THEN 1 ELSE 0 END) AS Asignados
            FROM public.estado e
            LEFT JOIN sistema.ticket t
                ON t.estado_id=e.id
                LEFT JOIN sistema.unidad_resp_ticket u on t.bandeja_actual_id=u.id
                where u.id='" . Yii::app()->getSession()->get('id_unidad') . "'
        GROUP BY
             e.id, e.nombre, u.nombre, u.id order by e.nombre";
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }

    public function seleccionar_estatus($estado_id, $estatus) {
        $resultado = '';
        $sql = "select e.nombre, t.observacion, t.codigo,u.nombre as unidad_responsable, tip.nombre as tipo_ticket from sistema.ticket t
        inner join public.estado e on t.estado_id=e.id
        inner join sistema.tipo_ticket tip on t.tipo_ticket_id=tip.id
        inner join sistema.unidad_resp_ticket u on t.bandeja_actual_id=u.id
        where e.id='".$estado_id."' and t.estatus='".$estatus."'";
        $consulta = yii::app()->db->createCommand($sql);
        $consulta->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
        $consulta->bindParam(':estatus', $estatus, PDO::PARAM_STR);
        $resultado = $consulta->queryAll();
        return $resultado;
       
    }
    
    
    
     public function seleccionar_estatus_activo($estado_id, $estatus) {
        $resultado = '';
        $sql = "select e.nombre, t.observacion, t.codigo,u.nombre as unidad_responsable, tip.nombre as tipo_ticket from sistema.ticket t
        inner join public.estado e on t.estado_id=e.id
        inner join sistema.tipo_ticket tip on t.tipo_ticket_id=tip.id
        inner join sistema.unidad_resp_ticket u on t.bandeja_actual_id=u.id
        where e.id='".$estado_id."' and t.estatus='".$estatus."' or t.estatus='R' and e.id='".$estado_id."'";
        $consulta = yii::app()->db->createCommand($sql);
        $consulta->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
        $consulta->bindParam(':estatus', $estatus, PDO::PARAM_STR);
        $resultado = $consulta->queryAll();
        //var_dump($sql); die();
        return $resultado;
       
    }
    public function seleccionar_total($estado_id) {
        $resultado = '';
        $sql = "select e.nombre, t.observacion, t.codigo,u.nombre as unidad_responsable, tip.nombre as tipo_ticket from sistema.ticket t
        inner join public.estado e on t.estado_id=e.id
        inner join sistema.tipo_ticket tip on t.tipo_ticket_id=tip.id
        inner join sistema.unidad_resp_ticket u on t.bandeja_actual_id=u.id
        where e.id='".$estado_id."'";
        $consulta = yii::app()->db->createCommand($sql);
        $consulta->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
        $consulta->bindParam(':estatus', $estatus, PDO::PARAM_STR);
        $resultado = $consulta->queryAll();
        //var_dump($sql); die();
        return $resultado;

    }


    public function seleccionar_total_estado($estado_id, $unidad) {
        $resultado = '';
        $sql = "select e.nombre, t.observacion, t.codigo,u.nombre as unidad_responsable, tip.nombre as tipo_ticket from sistema.ticket t
        inner join public.estado e on t.estado_id=e.id
        inner join sistema.tipo_ticket tip on t.tipo_ticket_id=tip.id
        inner join sistema.unidad_resp_ticket u on t.bandeja_actual_id=u.id
        where e.id=:estado_id and u.id=:unidad";
        $consulta = yii::app()->db->createCommand($sql);
        $consulta->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
        $consulta->bindParam(':unidad', $unidad, PDO::PARAM_STR);
        $resultado = $consulta->queryAll();
        //var_dump($sql); die();
        return $resultado;

    }




    public function seleccionar_estatus_activo_unidad($estado_id, $estatus, $unidad) {
        $resultado = '';
        $sql = "select e.nombre, t.observacion, t.codigo,u.nombre as unidad_responsable, tip.nombre as tipo_ticket from sistema.ticket t
        inner join public.estado e on t.estado_id=e.id
        inner join sistema.tipo_ticket tip on t.tipo_ticket_id=tip.id
        inner join sistema.unidad_resp_ticket u on t.bandeja_actual_id=u.id
        where e.id=:estado_id and t.estatus=:estatus and u.id=:unidad
        or t.estatus='R' and e.id=:estado_id and u.id=:unidad";
        $consulta = yii::app()->db->createCommand($sql);
        $consulta->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
        $consulta->bindParam(':estatus', $estatus, PDO::PARAM_STR);
        $consulta->bindParam(':unidad', $unidad, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        //var_dump($sql); die();
        return $resultado;

    }
}

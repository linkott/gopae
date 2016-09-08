<?php

/**
 * This is the model class for table "legacy.nomina_procesadoras".
 *
 * The followings are the available columns in table 'legacy.nomina_procesadoras':
 * @property string $id
 * @property string $estado
 * @property string $cedula_text
 * @property integer $cedula_num
 * @property string $mes
 * @property integer $en_saime
 * @property integer $apariciones
 * @property string $consecutivo
 * @property string $fecha
 * @property integer $mes_num
 * @property integer $estado_id
 *
 * The followings are the available model relations:
 * @property Estado $estado
 */
class NominaProcesadoras extends CActiveRecord {

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'legacy.nomina_procesadoras';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado, cedula_text, mes, fecha', 'required'),
			array('cedula_num, en_saime, apariciones, mes_num, estado_id', 'numerical', 'integerOnly' => true),
			array('estado', 'length', 'max' => 40),
			array('cedula_text, consecutivo', 'length', 'max' => 20),
			array('mes', 'length', 'max' => 15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, estado, cedula_text, cedula_num, mes, en_saime, apariciones, consecutivo, fecha, mes_num, estado_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
		);
	}

	public function reporteEstadistico($level, $dependency_id = null) {

		$index = "nominaProcesadorasLegacy{$level}{$dependency_id}";
		Yii::app()->cache->delete($index);
		$resultado = Yii::app()->cache->get($index);

		if (!$resultado) {

			if (in_array($level, array('region', 'estado', 'municipio', 'estadoTotal')) && (is_null($dependency_id) || is_numeric($dependency_id))) {

				if ($level == 'region') {
					$camposSeleccionados = "r.id, r.nombre, 'AAA'||r.nombre AS titulo ";
					$camposSeleccionadosTotales = "0 AS id, 'TOTAL' AS nombre , 'ZZZTOTAL' AS titulo";
					$camposAgrupados = "r.id, r.nombre, titulo ";
					$where = '1 = 1';
					$orderBy = 'titulo ASC, nombre ASC';
				} elseif ($level == 'estado') {
					$camposSeleccionados = "e.region_id AS region_id, r.nombre AS region, e.id AS id, e.nombre, 'AAA'||e.nombre AS titulo  ";
					$camposSeleccionadosTotales = "$dependency_id AS region_id, 'X' AS region, 0 AS id, 'TOTAL' AS nombre , 'ZZZTOTAL' AS titulo";
					$camposAgrupados = "e.region_id, r.nombre, e.id, e.nombre, titulo  ";
					$where = 'e.id != 45 AND e.region_id = ' . $dependency_id;// Excluye Dependencias Federales (Id=45)
					$orderBy = 'titulo ASC, nombre ASC';
				} elseif ($level == 'municipio') {
					$camposSeleccionados = "e.region_id AS region_id, r.nombre AS region, e.id AS estado_id, e.nombre AS estado, m.id, m.nombre, 'AAA'||m.nombre AS titulo  ";
					$camposSeleccionadosTotales = "0 AS region_id, 'X' AS region, $dependency_id AS estado_id, 'X' AS estado, 0 AS id, 'TOTAL' AS nombre , 'ZZZTOTAL' AS titulo";
					$camposAgrupados = "e.region_id, r.nombre, e.id, e.nombre, m.id, m.nombre, titulo  ";
					$where = 'm.estado_id = ' . $dependency_id;
					$orderBy = 'titulo ASC, nombre ASC';
				} elseif ($level == 'estadoTotal') {
					$camposSeleccionados = "e.region_id AS region_id, r.nombre AS region, e.id AS id, e.nombre, 'AAA'||e.nombre AS titulo  ";
					$camposSeleccionadosTotales = "0 AS region_id, 'X' AS region, 0 AS id, 'TOTAL' AS nombre , 'ZZZTOTAL' AS titulo";
					$camposAgrupados = "e.region_id, r.nombre, e.id, e.nombre, titulo  ";
					$where = ' e.id != 45 ';
					$orderBy = 'titulo ASC, nombre ASC';
				}

				$sql = "SELECT  $camposSeleccionados, COUNT(DISTINCT p.cedula_num) AS madres
                                , COUNT(DISTINCT CASE WHEN (p.en_nomina_mppe = 1) THEN p.cedula_num ELSE null END) AS en_nomina_mppe
                                , COUNT(DISTINCT CASE WHEN (p.tipo_nomina_mppe = 1) THEN p.cedula_num ELSE null END) AS nomina_fijos_mppe
                                , COUNT(DISTINCT CASE WHEN (p.tipo_nomina_mppe = 2) THEN p.cedula_num ELSE null END) AS nomina_contratados_mppe
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 11) THEN p.cedula_num ELSE null END) AS noviembre
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 1) THEN p.cedula_num ELSE null END) AS enero
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 2) THEN p.cedula_num ELSE null END) AS febrero
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 3) THEN p.cedula_num ELSE null END) AS marzo
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 4) THEN p.cedula_num ELSE null END) AS abril
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 5) THEN p.cedula_num ELSE null END) AS mayo
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 6) THEN p.cedula_num ELSE null END) AS junio
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 7) THEN p.cedula_num ELSE null END) AS julio
                        FROM public.region r
                            INNER JOIN public.estado e
                                ON r.id = e.region_id
                            LEFT JOIN legacy.nomina_procesadoras p
                                ON e.id = p.estado_id
                        WHERE
                            $where
                        GROUP BY
                            $camposAgrupados

                        UNION

                        SELECT  $camposSeleccionadosTotales, COUNT(DISTINCT p.cedula_num) AS madres
                                , COUNT(DISTINCT CASE WHEN (p.en_nomina_mppe = 1) THEN p.cedula_num ELSE null END) AS en_nomina_mppe
                                , COUNT(DISTINCT CASE WHEN (p.tipo_nomina_mppe = 1) THEN p.cedula_num ELSE null END) AS nomina_fijos_mppe
                                , COUNT(DISTINCT CASE WHEN (p.tipo_nomina_mppe = 2) THEN p.cedula_num ELSE null END) AS nomina_contratados_mppe
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 11) THEN p.cedula_num ELSE null END) AS noviembre
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 1) THEN p.cedula_num ELSE null END) AS enero
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 2) THEN p.cedula_num ELSE null END) AS febrero
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 3) THEN p.cedula_num ELSE null END) AS marzo
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 4) THEN p.cedula_num ELSE null END) AS abril
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 5) THEN p.cedula_num ELSE null END) AS mayo
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 6) THEN p.cedula_num ELSE null END) AS junio
                                , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 7) THEN p.cedula_num ELSE null END) AS julio
                        FROM public.region r
                            INNER JOIN public.estado e
                                ON r.id = e.region_id
                            LEFT JOIN legacy.nomina_procesadoras p
                                ON e.id = p.estado_id
                        WHERE
                            $where
                        ORDER BY
                            $orderBy";

				// echo "<pre><code>$sql</code></pre>";
				// die();

				$connection = Yii::app()->db;
				$command = $connection->createCommand($sql);
				$resultado = $command->queryAll();

				if ($resultado) {
					Yii::app()->cache->set($index, $resultado);
				}

			}
		}

		return $resultado;
	}

	public function reporteGrafico($estadoId = null) {

		$index = "nominaProcesadorasLegacyGrafico{$estadoId}";
		Yii::app()->cache->delete($index);
		$resultado = Yii::app()->cache->get($index);

		if (!$resultado) {

			$camposSeleccionados = "e.region_id AS id, r.nombre AS region, e.id AS estado_id, e.nombre, 'AAA'||e.nombre AS titulo  ";
			$camposAgrupados = "e.region_id, r.nombre, e.id, e.nombre, titulo  ";
			$where = 'e.id != 45';
			$orderBy = 'titulo ASC, e.nombre ASC';

			if (!is_null($estadoId) && is_numeric($estadoId)) {
				$where .= " AND e.id = $estadoId ";
			}

			$sql = "SELECT  $camposSeleccionados, COUNT(DISTINCT p.cedula_num) AS madres
                            , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 11) THEN p.cedula_num ELSE null END) AS noviembre
                            , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 1) THEN p.cedula_num ELSE null END) AS enero
                            , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 5) THEN p.cedula_num ELSE null END) AS mayo
                            , COUNT(DISTINCT CASE WHEN (p.id IS NOT NULL AND p.mes_num = 6) THEN p.cedula_num ELSE null END) AS junio
                    FROM public.region r
                        INNER JOIN public.estado e
                            ON r.id = e.region_id
                        LEFT JOIN legacy.nomina_procesadoras p
                            ON e.id = p.estado_id
                    WHERE
                      $where
                    GROUP BY
                      $camposAgrupados
                    ORDER BY
                      $orderBy";

			// echo "<pre>$sql</pre>";
			// die();

			$connection = Yii::app()->db;
			$command = $connection->createCommand($sql);
			$resultado = $command->queryAll();

			if ($resultado) {
				Yii::app()->cache->set($index, $resultado);
			}
		}

		return $resultado;
	}

	public function reporteDetallado($column, $level, $dependency, $fecha = null, $orderBy = null) {

		$columnFilter = $this->getColumnFilterMes($column);
		$drillDownFilter = $this->getGeoDrillDownFilter($level, $dependency);

		$where = $drillDownFilter . ' AND ' . $columnFilter;

		if (is_null($orderBy)) {
			$orderBy = 'p.estado,'
			. 'p.cedula_num ';
		}

		$mesYConsecutivo = " '' AS mes, '' AS consecutivo ";
		if ($column != 'madres') {
			$mesYConsecutivo = " p.mes, p.consecutivo ";
		}

		$sql = "SELECT DISTINCT
                    p.cedula_num,
                    p.cedula_text,
                    p.estado,
                    p.estado_id,
                    s.origen,
                    s.cedula,
                    s.pais_origen,
                    s.nacionalidad,
                    (s.primer_nombre || ' ' || s.segundo_nombre) AS nombres,
                    (s.primer_apellido || ' ' || s.segundo_apellido) AS apellidos,
                    TO_CHAR(s.fecha_nacimiento, 'DD-MM-YYYY') AS fecha_nacimiento,
                    EXTRACT(year from AGE(NOW(), s.fecha_nacimiento)) AS edad,
                    string_agg(p.mes, ', ') AS meses_asistidos,
                    $mesYConsecutivo
                FROM legacy.nomina_procesadoras p
                LEFT JOIN auditoria.saime s
                  ON p.cedula_num = s.cedula
                WHERE
                  $where
                GROUP BY
                  p.cedula_num,
                  p.cedula_text,
                  p.estado,
                  p.estado_id,
                  s.origen,
                  s.cedula,
                  s.pais_origen,
                  s.nacionalidad,
                  nombres,
                  apellidos,
                  fecha_nacimiento,
                  edad
                ORDER BY
                   $orderBy";

		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		// echo "<pre>$sql</pre>";
		$resultado = $command->queryAll();
		// var_dump($resultado);
		// die();

		return $resultado;

	}

	private function getColumnFilterMes($mes) {

		$where = " p.cedula_text IS NOT NULL ";

		if (is_numeric($mes)) {
			$where = " p.mes_num = $mes ";
		}

		return $where;

	}

	private function getGeoDrillDownFilter($level, $dependency) {
		switch ($level) {
			case 'region':
				if ((int) $dependency !== 0) {
					$where = 'es.region_id = ' . $dependency . ' AND es.id != 45';
				}
				//No incluye Dependencias Federales (45)
				else{

					$where = 'p.estado_id != 45';
				}
				//No incluye Dependencias Federales (45)
				break;
			case 'estado':
				$where = 'p.estado_id = ' . $dependency . ' AND p.estado_id != 45';//No incluye Dependencias Federales (45)
				break;
			case 'estadoTotal':
				$where = 'p.estado_id = ' . $dependency . ' AND p.estado_id != 45';//No incluye Dependencias Federales (45)
				break;
			case 'municipio':
				$where = 'mc.id = ' . $dependency . ' AND es.id != 45';//No incluye Dependencias Federales (45)
				break;
			default:
				$where = '1 = 1';
				break;
		}

		return $where;

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'estado' => 'Estado',
			'cedula_text' => 'Cedula Text',
			'cedula_num' => 'Cedula Num',
			'mes' => 'Mes',
			'en_saime' => 'En Saime',
			'apariciones' => 'Apariciones',
			'consecutivo' => 'Consecutivo',
			'fecha' => 'Fecha',
			'mes_num' => 'Mes Num',
			'estado_id' => 'Estado',
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
		$criteria->compare('estado', $this->estado, true);
		$criteria->compare('cedula_text', $this->cedula_text, true);
		$criteria->compare('cedula_num', $this->cedula_num);
		$criteria->compare('mes', $this->mes, true);
		$criteria->compare('en_saime', $this->en_saime);
		$criteria->compare('apariciones', $this->apariciones);
		$criteria->compare('consecutivo', $this->consecutivo, true);
		$criteria->compare('fecha', $this->fecha, true);
		$criteria->compare('mes_num', $this->mes_num);
		$criteria->compare('estado_id', $this->estado_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NominaProcesadoras the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

}

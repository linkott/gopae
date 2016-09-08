<?php

/**
 * This is the model class for table "auditoria.saime".
 *
 * The followings are the available columns in table 'auditoria.saime':
 * @property string $origen
 * @property integer $cedula
 * @property string $pais_origen
 * @property string $nacionalidad
 * @property string $primer_nombre
 * @property string $segundo_nombre
 * @property string $primer_apellido
 * @property string $segundo_apellido
 * @property string $fecha_nacimiento
 * @property integer $naturalizado
 * @property string $sexo
 * @property string $fecha_registro
 */
class Saime extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'auditoria.saime';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('origen, cedula, primer_nombre, primer_apellido, sexo, fecha_registro', 'required'),
            array('cedula', 'evitarCreacion'),
            array('cedula, naturalizado', 'numerical', 'integerOnly'=>true),
            array('origen, sexo', 'length', 'max'=>1),
            array('pais_origen, nacionalidad', 'length', 'max'=>3),
            array('primer_nombre, segundo_nombre, primer_apellido, segundo_apellido', 'length', 'max'=>60),
            array('fecha_nacimiento', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('origen, cedula, pais_origen, nacionalidad, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, fecha_nacimiento, naturalizado, sexo, fecha_registro', 'safe', 'on'=>'search'),
        );
    }
    
    public function evitarCreacion($attribute, $params=null) {
        $this->addError($attribute, 'No se puede registrar ningun dato en esta tabla a través de esta interfaz.');
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'origen' => 'Origen',
            'cedula' => 'Cedula',
            'pais_origen' => 'Pais Origen',
            'nacionalidad' => 'Nacionalidad',
            'primer_nombre' => 'Primer Nombre',
            'segundo_nombre' => 'Segundo Nombre',
            'primer_apellido' => 'Primer Apellido',
            'segundo_apellido' => 'Segundo Apellido',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'naturalizado' => 'Naturalizado',
            'sexo' => 'Sexo',
            'fecha_registro' => 'Fecha Registro',
        );
    }
    
    public static function busquedaOrigenCedula($origen, $cedula) {
        $cedulaInt = $cedula;
        $indice = "$origen-$cedula";
        $resultadoCedula = Yii::app()->cache->get($indice);
        
        if(!$resultadoCedula){
            $sql = "SELECT origen, cedula, (primer_nombre || ' ' || segundo_nombre) AS nombre, (primer_apellido || ' ' || segundo_apellido) AS apellido, fecha_nacimiento, sexo "
                    . " FROM auditoria.saime s"
                    . " WHERE "
                    . " s.cedula= :cedula AND "
                    . " s.origen= :origen ";

            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":cedula", $cedulaInt, PDO::PARAM_INT);
            $buqueda->bindParam(":origen", $origen, PDO::PARAM_STR);

            $resultadoCedula = $buqueda->queryRow();

            if ($resultadoCedula !== array()) {
                Yii::app()->cache->set($indice, $resultadoCedula, 86400*7);
                return $resultadoCedula;
            } else {
                return false;
            }
        }
        else{
            return $resultadoCedula;
        }
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('origen',$this->origen,true);
        $criteria->compare('cedula',$this->cedula);
        $criteria->compare('pais_origen',$this->pais_origen,true);
        $criteria->compare('nacionalidad',$this->nacionalidad,true);
        $criteria->compare('primer_nombre',$this->primer_nombre,true);
        $criteria->compare('segundo_nombre',$this->segundo_nombre,true);
        $criteria->compare('primer_apellido',$this->primer_apellido,true);
        $criteria->compare('segundo_apellido',$this->segundo_apellido,true);
        $criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
        $criteria->compare('naturalizado',$this->naturalizado);
        $criteria->compare('sexo',$this->sexo,true);
        $criteria->compare('fecha_registro',$this->fecha_registro,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Saime the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
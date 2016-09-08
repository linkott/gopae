<?php

/**
 * This is the model class for table "titulo.archivo_papel_moneda".
 *
 * The followings are the available columns in table 'titulo.archivo_papel_moneda':
 * @property integer $id
 * @property string $nombre
 * @property string $checksum
 * @property string $observacion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioIni
 */
class ArchivoPapelMoneda extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'titulo.archivo_papel_moneda';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, checksum, usuario_ini_id, fecha_ini', 'required'),
            array('usuario_ini_id', 'numerical', 'integerOnly'=>true),
            array('nombre', 'length', 'max'=>255),
            //array('fecha_ini', 'datetime'),
            array('estatus', 'length', 'max'=>1),
            array('observacion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, checksum, observacion, usuario_ini_id, fecha_ini, estatus', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre del Archivo',
            'checksum' => 'Checksum del Archivo',
            'observacion' => 'Observacion',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('nombre',$this->nombre,true);
        $criteria->compare('checksum',$this->checksum,true);
        $criteria->compare('observacion',$this->observacion,true);
        $criteria->compare('usuario_ini_id',$this->usuario_ini_id);
        $criteria->compare('fecha_ini',$this->fecha_ini,true);
        $criteria->compare('estatus',$this->estatus,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ArchivoPapelMoneda the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
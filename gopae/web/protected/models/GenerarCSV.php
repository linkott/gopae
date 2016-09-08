<?php

/**
 * This is the model class for table "administrativo.banco".
 *
 * The followings are the available columns in table 'administrativo.banco':
 * @property integer $id
 * @property string $nombre
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $id
 */
class GenerarCSV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'legacy.nomina_matriz_20150215';
	}

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
			
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function shemasSql(){
           $sql="SELECT column_name FROM information_schema.columns where table_name ='nomina_matriz_20150215' order by ordinal_position";
           $primerasFilas='';
                $command = Yii::app()->db->createCommand($sql);
                $dataReader=$command->query();
		$result=array();              
                foreach($dataReader as $row) {
                    $result= array_merge($result, $row);
                }
    		$primerasFilas=implode(", ", $result);
		return $primerasFilas;
        }
        
        public function leerTabla() {
            
            $sql="SELECT * from legacy.nomina_matriz_20150215";
            $command = Yii::app()->db->createCommand($sql);
            $dataReader=$command->query();
            $result=array();              
            while(($row=$dataReader->read())!==false) {
                $result= array_merge($result, $row);
            }
            $primerasFilas=implode(", ", $result);
            return $primerasFilas;
        }
        
        public function generateCsv($data, $delimiter = ',', $enclosure = '"') {
            $handle = fopen('php://temp', 'r+');
            foreach ($data as $line) {
                fputcsv($handle, $line, $delimiter, $enclosure);
            }
            rewind($handle);
            while (!feof($handle)) {
                $contents .= fread($handle, 8192);
            }
            fclose($handle);
            return $contents;
        }

}


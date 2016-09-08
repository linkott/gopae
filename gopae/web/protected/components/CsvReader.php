<?php

/**
 * Lector de Archivos de texto Plano csv
 * @author Jose Gabriel Gonzalez <jgonza67@cantv.com.ve>
 */
class CsvReader {

    public $targetFile;

    public $result;

    public $class_style;

    public $message;

    public $reader;

    public $root_dir;

    private $file_handler;

    private $separator;

    private $columns;

    private $column_init;

    private $column_last;

    public $isFile;

    /**
     * Contructor del Lector de Archivo de Texto Plano CSV
     *
     * @param String targetFile Representa la ruta y nombre del archivo a leer.
     * @param String separator Separado de Columnas del Archivo Csv (',',';','|')
     * @param String column_init Nombre de Columna Inicial (Analogia con Columnas de Excel o Calc)
     * @param String column_last Nombre de Columna Final (Analogia con Columnas de Excel o Calc)
     *
     */
    function __construct($targetFile=null, $separator=';', $column_init='A', $column_last='ZZ') {

        if(null!==$targetFile){
            $this->targetFile = $targetFile;
        }

        $this->root_dir = '/var/www/gopae/';

        $this->separator = $separator;

        $this->column_init = $column_init;
        $this->column_last = $column_last;

        $columns = array($this->column_init);
        $current = $this->column_init;
        while ($current != $this->column_last) {
            $columns[] = ++$current;
        }

        $this->columns = $columns;

        if(!is_file($targetFile)){
            $this->message = $this->getLogDate().': Ha ocurrido un error: El archivo '.$targetFile.' No existe. Code File: "'.__FILE__.'" ('.__LINE__.')';
            $this->isFile = false;
        }else{
            $this->isFile = true;
        }
    }

    /**
     * @return String
     */
    public function readData(){
        $fh = fopen($this->targetFile, 'r+');
        $filesize = filesize($this->targetFile);
        $theData = fread($fh, $filesize);
        fclose($fh);
        return $theData;
    }

    public function getDataInArray($separator=';'){
        $this->separator = $separator;
        try{
            $file = fopen($this->targetFile, 'r');
        }catch (Exception $e) {

            $this->message = $this->getLogDate().': Ha Ocurrido un Error: No se ha podido abrir el archivo: '.  $e->getMessage(). '.\n Code File: "'.__FILE__.'" ('.__LINE__.')';
            return false;
        }
        $i = 0;
        $k = 0;
        $data_array = array();

        try{
            while(!feof($file)){
                $temp = fgets($file);
                if(strlen(trim($temp))>1){
                    $explode_row = explode($this->separator, trim($temp));
                    foreach ($explode_row as $valor){
                        $data_array[$i][$this->columns[$k]] = str_replace('"', '', trim($valor));
                        $k++;
                    }
                    $i++;
                    $k=0;
                }
            }
            fclose($file);
        }catch (Exception $e) {

            $this->message = $this->getLogDate().': Ha Ocurrido un Error: No se han podido obtener los datos del archivo: '.  $e->getMessage(). '.\n Code File: "'.__FILE__.'" ('.__LINE__.')';
            return false;
        }

        if($i>0){
            return $data_array;
        }else{
            return false;
        }
    }

    public function getDataUniqueColumn($column_name=null){
        if(is_null($column_name)){
            $column_name = 'A';
        }
        $file = fopen($this->targetFile, 'r+');
        $i = 0;
        while(!feof($file)){
            $temp = fgets($file);
            if(strlen(trim($temp))>0){
                $data_array[$i][$column_name] = $temp;
                $i++;
            }
        }
        fclose($file);
        if($i>0){
            return $data_array;
        }else{
            return false;
        }
    }

    /**
     * @return unknown
     */
    public function getFile_handler() {
        return $this->file_handler;
    }

    /**
     * @param unknown_type $file_handler
     */
    public function setFile_handler($file_handler) {
        $this->file_handler = $file_handler;
    }

    /**
     * @param extensions Array()
     * @param fileName String
     * @return Boolean
     */
    public function isRequiredExtension($fileName=null, $extensions=array('txt','TXT','csv','CSV')){
        if(is_null($fileName)){
            $file = $this->targetFile;
        }else{
            $file = $fileName;
        }
        $fileParts = pathinfo($file);
        if (in_array($fileParts['extension'],$extensions)) {
            return true;
        }
    }

    public function getLogDate(){
        $objDateTime = new DateTime('NOW');
        return 'PHP '.$objDateTime->format('Y-m-d H:i:s');
    }

}

?>
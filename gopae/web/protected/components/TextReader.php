<?php

/**
 * Lector de Archivos de texto Plano txt
 * @author Jose Gabriel Gonzalez <jgonza67@cantv.com.ve>
 */
class TextReader {

    public $targetFile;

    public $result;

    public $class_style;

    public $message;

    public $reader;

    public $root_dir;

    private $file_handler;

    function __construct($targetFile=null) {
        if(null!==$targetFile){
            $this->targetFile = $targetFile;
        }
        $config = new Config();
        $this->root_dir = $config->root_dir;
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

    public function getDataInArray(){
        $file = fopen($this->targetFile, 'r+');
        $i = 0;
        while(!feof($file)){
            $temp = fgets($file)."</br>";
            if(strlen(trim($temp))>5){
                list($cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$edad,$email) = explode(',',$temp);
                $data_array[$i]['cedula'] = $cedula;
                $data_array[$i]['primer_nombre'] = $primer_nombre;
                $data_array[$i]['segundo_nombre'] = $segundo_nombre;
                $data_array[$i]['primer_apellido'] = $primer_apellido;
                $data_array[$i]['segundo_apellido'] = $segundo_apellido;
                $data_array[$i]['edad'] = $edad;
                $data_array[$i]['email'] = $email;
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
    public function isRequiredExtension($fileName=null, $extensions=array('txt','TXT')){
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

}

?>
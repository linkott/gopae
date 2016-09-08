<?php

/**
 * Lector de Archivos Excel (xls y/o xlsx) se basa en la libreria PHPExcel
 * @author Jose Gabriel Gonzalez <jgonza67@cantv.com.ve>
 */
class ExcelReader {

    public $targetFile;

    public $result;

    public $class_style;

    public $message;

    public $objReaderExcel;

    public $reader;

    public $root_dir;

    function __construct($targetFile=null) {
        Yii::import('ext.phpexcel.XPHPExcel');      
        XPHPExcel::init();
        if(null!==$targetFile){
            $this->targetFile = $targetFile;
        }
    }

    public function getFile($readDataOnly=true, $targetFile=null, $extensions=array('xls','xlsx')){

        if(null!==$targetFile){
            self::__construct($targetFile);
        }else{
            $targetFile = $this->targetFile;
        }

        if($this->isRequiredExtension(array('xls','xlsx','ods'),$targetFile)){

            //Veo segun la extensión del archivo cuál debe ser el método de entrada para lectura desde la librería PHPExcel

            if($this->isRequiredExtension(array('xlsx'),$targetFile)){
                $inputFileType = 'Excel2007';
            }elseif($this->isRequiredExtension(array('xls'),$targetFile)){
                $inputFileType = 'Excel5';
            }elseif($this->isRequiredExtension(array('ods'),$targetFile)){
                $inputFileType = 'OOCalc';
            }else{
                $this->result = false;
                $this->class_style = 'error';
                $this->message = 'Formato Incorrecto del Archivo, debe ingresar un archivo MS Excel 2003 u ODS de Libre Office Calc.';
                return array($this->result,$this->class_style,$this->message,null);
            }

            $this->objReaderExcel = PHPExcel_IOFactory::createReader($inputFileType);
            $this->objReaderExcel->setReadDataOnly(true);
            $this->reader = $this->load($targetFile);

            $this->result = true;
            $this->class_style = '';
            $this->message = 'Archivo Leido';
            return array($this->result,$this->class_style,$this->message,$this->objReaderExcel);

        }else{
            $this->result = false;
            $this->class_style = 'error';
            $this->message = 'Extensi&oacute;n Inv&aacute;lida del Archivo. El archivo requerido debe ser MS Excel 2003 u ODS de Libre Office Calc.';
            return array($this->result,$this->class_style,$this->message,null);
        }

    }

    public function getReader($readDataOnly=true, $targetFile=null, $extensions=array('xls','xlsx','ods')){
        $this->getFile($readDataOnly, $targetFile, $extensions);
        $this->load($targetFile);
        return array($this->result,$this->class_style,$this->message,$this->objReaderExcel,$this->reader);
    }

    /**
     * @param extensions Array()
     * @param fileName String
     * @return Boolean
     */
    public function isRequiredExtension($extensions=array('xls','xlsx','ods'), $fileName){
        $fileParts = pathinfo($fileName);
        if (in_array($fileParts['extension'],$extensions)) {
            return true;
        }
    }

    public function load($targetFile=null){
        if(null!==$targetFile){
            self::__construct($targetFile);
        }else{
            $targetFile = $this->targetFile;
        }
        if(!is_null($this->objReaderExcel)){
            $this->reader = $this->objReaderExcel->load($targetFile);
        }
        return $this->reader;
    }

}

?>
<?php
/**
 *   CsvExport
 *
 *   helper class to output an CSV from a CActiveRecord array.
 *
 *   example usage:
 *
 *       CsvExport::export(
 *           People::model()->findAll(), // a CActiveRecord array OR any CModel array
 *           array(
 *               'idpeople'=>array('number'),      'number' and 'date' are strings used by CFormatter
 *               'birthofdate'=>array('date'),
 *           )
 *       ,true,'registros-hasta--'.date('d-m-Y H-i').".csv");
 *
 *
 *   Please refer to CFormatter about column definitions, this class will use CFormatter.
 *
 *   @author    Christian Salazar <christiansalazarh@gmail.com> @bluyell @yiienespanol (twitter)
 *   @licence Protected under MIT Licence.
 *   @date 07 october 2012.
 */
class CsvExport {
    /*
        export a data set to CSV output.
 
        Please refer to CFormatter about column definitions, this class will use CFormatter.
 
        @rows    CModel array. (you can use a CActiveRecord array because it extends from CModel)
        @coldefs    example: 'colname'=>array('number') (See also CFormatter about this string)
        @boolPrintRows    boolean, true print col headers taken from coldefs array key
        @csvFileName if set (defaults null) it echoes the output to browser using binary transfer headers
        @separator if set (defaults to ';') specifies the separator for each CSV field
    */
    public static function export($rows, $coldefs, $headers, $boolPrintRows=true, $csvFileName=null, $separator=';', $inFile=true)
    {
        $endLine = PHP_EOL;
        $returnVal = '';
        $headerRow = '';
        $count= count($rows);
        if(is_null($csvFileName)){
            $csvFileName = 'file'.date('YmdHis').'.csv';
        }
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=".$csvFileName);
        header("Content-Type: text/csv");
        header("Content-Transfer-Encoding: UTF-8");
        header('Pragma: no-cache');
        header('Expires: 0');
        //$filePath = Yii::app()->params['downloadDirectoryPath'].'/'.$csvFileName;
        $ruta = yii::app()->basePath . '/../public/downloads/'.$csvFileName;
        if($count>=3000) {
            header("Location: /../public/downloads/".$csvFileName);
        }
        // Print Header
        if($boolPrintRows == true){
            $names = '';
            foreach($headers as $col){
                $names .= '"'.$col.'"'.$separator;
            }
            $names = rtrim($names,$separator);
            $headerRow .= $names.$endLine;
        }

        if(!$inFile){
            echo $headerRow;
        }

        foreach($rows as $row){
            $r = '';
            foreach($coldefs as $col=>$config){
                if(array_key_exists($col,$row)){
                    $val = $row[$col];
                    foreach($config as $conf) {
                        $val = Yii::app()->format->format($val, $conf);

                    }
                    $r .= '"'.$val.'"'.$separator;
                }
            }
            $item = trim(rtrim($r,$separator)).$endLine;
            $returnVal .= $item;
            if(!$inFile) {
                echo $item;
            }
            flush();
        }
        $returnVal.=" Reporte generado a la fecha y hora: " . date("d-m-Y H:i:s")."||".$count;
        if($count<3000) {
            echo $headerRow;
            echo $returnVal;
        }
        else{
            self::createFile($csvFileName, $headerRow, $returnVal);
        }
    }

    /**
     * @param $fileName
     * @param $header
     * @param $body
     */
    public static function createFile($fileName, $header, $body){

        $filePath = Yii::app()->params['downloadDirectoryPath'].'/'.$fileName;
        $file = fopen($filePath, "w");
        fwrite($file, $header);
        fwrite($file, $body);
        fclose($file);
    }
}

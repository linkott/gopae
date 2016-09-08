<?php

class Utiles {

    //private $rutaTmp='/var/www/SIR-Des/archtmp/';
    //private $rutaPdf='/var/www/SIR-Des/archpdf/';

    const TRAZA = "INSERT INTO auditoria.traza (username, fecha_hora, ip_maquina, tipo_transaccion, modulo) VALUES (:username, :fecha_hora, :ip_maquina, :tipo_transaccion, :modulo);";

    private $rutaTmp = '/var/www/sirPhp/archtmp/';
    private $rutaPdf = '/var/www/sirPhp/archpdf/';
    public static $hostNameSistema = 'http://gopae.me.gob.ve';
    public static $gescolar = 'http://gescolar.me.gob.ve';

    /**
     *
     *  // $nombre_pdf = 'planteles-' . date('YmdHis') ;
     *  // $generadorPDF= new Utiles();
     *  // $reportePDF = ($this->renderPartial('application.modules.planteles.views.consultar._reporteListaPlanteles', array('model' => $dataReport, 'headers'=>$headers), true));
     *  // $horizontal = true;
     *  // $generadorPDF->crearArchivo($nombre_pdf, $reportePDF, $horizontal); // aca se genera y se guarda el archivo en un directorio
     *  //
     *  // $url= Yii::app()->baseUrl.'/../public/tmp/'.$nombre_pdf; // aca creamos un acceso o link para acceder al pdf almacenado en el direcorio
     *  //
     *  // $this->redirect($url);
     *
     * @param type $nombreArchivo
     * @param type $html
     * @param type $horizontal
     */
    public function crearArchivo($nombreArchivo, $html, $horizontal = true) {
        $nombreTemporalHTML = Yii::app()->basePath . '/../public/tmp/' . 'temporal.html';
        $nombreHTML = Yii::app()->basePath . '/../public/tmp/' . $nombreArchivo . '.html';
        $nombrePDF = Yii::app()->basePath . '/../public/tmp/' . $nombreArchivo . '.pdf';
        $archivo = fopen($nombreTemporalHTML, 'wb+');
        fwrite($archivo, $html);
        fclose($archivo);
        passthru("iconv --from-code=UTF-8 --to-code=ISO-8859-1 $nombreTemporalHTML > $nombreHTML");
        $this->crearPdf($nombreHTML, $nombrePDF, $horizontal);
    }

    public function crearPdf($archEntrada, $archSalida, $horizontal = true) {

        if ($horizontal == TRUE) {
            putenv("HTMLDOC_NOCGI=1");
            passthru("htmldoc -f $archSalida -t pdf14 --footer '/' --bodyfont Arial --fontsize 9 --jpeg  --webpage $archEntrada --landscape");
        }
        if ($horizontal == FALSE) {
            putenv("HTMLDOC_NOCGI=1");
            passthru("htmldoc -f $archSalida -t pdf14 --jpeg --footer '/' --webpage $archEntrada");
        }
        return 0;
    }

    public function mostrarPdf($archEntrada) {
        putenv("HTMLDOC_NOCGI=1");
        header("Content-Type: application/pdf");
        flush();
        passthru("htmldoc -t pdf14 --jpeg --webpage '$archEntrada'");
    }

    /**
     * Se encarga de enviar un correo desde la cuenta admin de la aplicacion SIR
     * a traves del servidor SMTP de CANTV, utiliza la extension instala de PHP-Mailer
     * Solo envia un correo a una persona, se debe mejorar para que pueda enciar CC y CCO
     * y tener varios destinatarios
     * @param string $to Direccion electronica de la persona a enviar el correo
     * @param string $subject Asunto del Correo
     * @param string $msj Mesaje del correo
     */
    static public function enviarCorreo($to, $subject = 'SIR-SWL', $msj = '') {
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer->Host = 'mail.me.gob.ve:25';
        $mailer->IsSMTP();
        $mailer->From = Yii::app()->params->adminEmail;
        if(is_array($to)){
            foreach($to as $sendTo){
                $mailer->AddAddress("{$sendTo}");
            }
        }else{
            $mailer->AddAddress("{$to}");
        }
        $mailer->FromName = Yii::app()->params->adminName;
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = $subject;
        $mailer->MsgHTML($msj);
        return $mailer->Send();
    }

    public static function ae_detect_ie() {
        if (isset($_SERVER['HTTP_USER_AGENT']) &&
                (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
            return true;
        else
            return false;
    }

    public function traza($transaccion, $modulo, $fecha_hora) {

        $ipUser = $this->getRealIP();
        //$ipUser = Yii::app()->request->userHostAddress;
        $userName = Yii::app()->user->name;
        $oDbConnection = Yii::app()->db; // Getting database connection (config/main.php has to set up database
        // Here you will use your complex sql query using a string or other yii ways to create your query
        $oCommand = $oDbConnection->createCommand(self::TRAZA);
        $oCommand->bindParam(':username', $userName, PDO::PARAM_STR);
        $oCommand->bindParam(':fecha_hora', $fecha_hora, PDO::PARAM_STR);
        $oCommand->bindParam(':ip_maquina', $ipUser, PDO::PARAM_STR);
        $oCommand->bindParam(':tipo_transaccion', $transaccion, PDO::PARAM_STR);
        $oCommand->bindParam(':modulo', $modulo, PDO::PARAM_STR);
        $oCommand->queryAll(); // Run query and get all results in a CDbDataReader
    }

    public static function getRealIP() {

        $ip = "";
        if (isset($_SERVER)) {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
            } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }
        // En algunos casos muy raros la ip es devuelta repetida dos veces separada por coma
        if (strstr($ip, ',')) {
            $ip = array_shift(explode(',', $ip));
        }
        return $ip;
    }

    /**
     * Modifies a string to remove all non ASCII characters and spaces.
     */
    static public function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * Verifica si el argumento pasado es una expresión para comparar campos numéricos.
     * Por ejemplo:
     *  >=50
     *  <=50
     *  50
     *  >50
     *  <50
     * @param string $val
     */
    public static function isExpressionToNumericCompare($val) {

        $result = false;

        if (!empty($val)) {

            if (is_numeric($val)) {

                $result = true;
            } else {

                $count = 0;

                $val_lt = str_replace('<', '', $val, $count);
                $pos_lt = strpos($val, '<');

                if (!empty($val_lt) && $pos_lt == 0 && is_numeric($val_lt) && $count == 1) {
                    $result = true;
                }

                $val_gt = str_replace('>', '', $val, $count);
                $pos_gt = strpos($val, '>');

                if (!empty($val_gt) && $pos_gt == 0 && is_numeric($val_gt) && $count == 1) {
                    $result = true;
                }

                $val_lte = str_replace('<=', '', $val, $count);
                $pos_lte = strpos($val, '<=');

                if (!empty($val_lte) && $pos_lte == 0 && is_numeric($val_lte) && $count == 1) {
                    $result = true;
                }

                $val_gte = str_replace('>=', '', $val, $count);
                $pos_gte = strpos($val, '>=');

                if (!empty($val_gte) && $pos_gte == 0 && is_numeric($val_gte) && $count == 1) {
                    $result = true;
                }
            }
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     *   //Ejemplo
     *   $fecha= "24/09/2009";
     *
     *   if(dateCheck($fecha)===false){
     *       echo "La fecha no es correcta";
     *   }else{
     *       echo "La fecha es correcta";
     *   }
     *   // imprime "La fecha es correcta"
     *
     *   @param String $input Fecha en formato DD/MM/YYYY ó DD.MM.YYYY ó DD-MM-YYYY
     *          si $format es igual a "dmy" (diamesanho)
     *   @param String $format formato de la fecha valores permitidos dmy, mdy y ymd
     */
    public static function dateCheck($input, $format = "dmy") {
        $separator_type = array(
            "/",
            "-",
            "."
        );
        $separator_used = '/';
        foreach ($separator_type as $separator) {
            $find = stripos($input, $separator);
            if ($find <> false) {
                $separator_used = $separator;
                break;
            }
        }
        $input_array = explode($separator_used, $input);
        if (count($input_array) == 3) {
            //echo "count(input_array)==3";
            if ($format == "mdy") {
                return checkdate($input_array[0], $input_array[1], $input_array[2]);
            } elseif ($format == "ymd") {
                return checkdate($input_array[1], $input_array[2], $input_array[0]);
            } else {
                //echo "format=dmy | {$input_array[1]},{$input_array[0]},{$input_array[2]}";
                return checkdate($input_array[1], $input_array[0], $input_array[2]);
            }
        } else {
            return false;
        }
    }

    public static function transformDate($input, $sep = '-', $from = 'dmy', $to = "ymd") {
        $separator_type = array(
            "/",
            "-",
            "."
        );
        $separator_used = '/';
        foreach ($separator_type as $separator) {
            $find = stripos($input, $separator);
            if ($find <> false) {
                $separator_used = $separator;
                break;
            }
        }
        $input_array = explode($separator_used, $input);
        if (count($input_array) == 3) {
            $isValid = false;
            //echo "count(input_array)==3";
            if ($from == "mdy" || $from == "m-d-y") { //month-day-year
                if (checkdate($input_array[0], $input_array[1], $input_array[2])) {
                    $year = $input_array[2];
                    $month = $input_array[0];
                    $day = $input_array[1];
                    $isValid = true;
                }
            } elseif ($from == "ymd" || $from == "y-m-d") {//year-month-day
                if (checkdate($input_array[1], $input_array[2], $input_array[0])) {
                    $year = $input_array[0];
                    $month = $input_array[1];
                    $day = $input_array[2];
                    $isValid = true;
                }
            } else {
                //echo "format=dmy | {$input_array[1]},{$input_array[0]},{$input_array[2]}";
                if (checkdate($input_array[1], $input_array[0], $input_array[2])) {
                    $year = $input_array[2];
                    $month = $input_array[1];
                    $day = $input_array[0];
                    $isValid = true;
                }
            }

            if ($isValid) {
                if ($to == 'ymd' || $to == 'y-m-d') {
                    return $year . $sep . $month . $sep . $day;
                } elseif ($to == 'dmy' || $to == 'd-m-y') {
                    return $day . $sep . $month . $sep . $year;
                } else {
                    return $month . $sep . $day . $sep . $year;
                }
            }
        }

        return $input;
    }
    
    /**
     * Permite obtener la Fecha en el formato del Servidor (YYYY-MM-DD HH24:MI:SS) 
     * dada una fecha en formato de aplicación (DD-MM-YYY HH24:MI:SS)
     * 
     * @param stringDate $appDate Ej.: '04-10-1987', '04-10-1987 09:00:10'
     * 
     * @return stringDate Fecha en el formato del Servidor Ej.: '1987-10-04', '1987-10-04 09:00:10'
     */
    public static function toServerDate($appDate, $separator='-'){
        $separator_type = array(
            "/",
            "-",
            "."
        );
        
        $serverDate = $appDate;
        
        $arrDate = explode(' ', $appDate);
        
        $date = (isset($arrDate[0]))?$arrDate[0]:$appDate;
        $hour = (isset($arrDate[1]))?$arrDate[1]:'';
        $sep = $separator;
        $dateArray = explode($separator, $date);
        
        if (count($dateArray) == 3) {
            $isValid = false;
            if (checkdate($dateArray[1], $dateArray[0], $dateArray[2])) {
                $year = $input_array[2];
                $month = $input_array[1];
                $day = $input_array[0];
                $isValid = true;
            }

            if ($isValid) {
                return $year . $sep . $month . $sep . $day . ' ' .$hour;
            }
        }

        return $serverDate;
    }
    
    /**
     * Permite obtener la Fecha en el formato de aplicación (DD-MM-YYY HH24:MI:SS) 
     * dada una fecha en formato del Servidor (YYYY-MM-DD HH24:MI:SS)
     * 
     * @param stringDate $serverDate Ej.: '1987-10-04', '1987-10-04 09:00:10'
     * 
     * @return stringDate Fecha en el formato de la Aplicación Latino Ej.: '04-10-1987', '04-10-1987 09:00:10'
     */
    public static function toAppDate($serverDate, $separator='-'){
        $appDate = $serverDate;

        $arrDate = explode(' ', $serverDate);

        $date = (isset($arrDate[0]))?$arrDate[0]:$serverDate;
        $hour = (isset($arrDate[1]))?$arrDate[1]:'';
        $sep = $separator;
        $dateArray = explode($separator, $date);

        if (count($dateArray) == 3) {
            $isValid = false;
            if (checkdate($dateArray[1], $dateArray[2], $dateArray[0])) {
                $year = $input_array[0];
                $month = $input_array[1];
                $day = $input_array[2];
                $isValid = true;
            }

            if ($isValid) {
                return $day . $sep . $month . $sep . $year . ' ' .$hour;
            }
        }
        return $appDate;
    }
    
    public function hourCheck($input, $format = 'HH24') {
        if ($format == 'HH24')
            return preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]/", $input);
        else
            return preg_match("/(1[012]|0[0-9]):[0-5][0-9]/", $input);
    }

    public static function onlyTextString($input) {
        return preg_replace("/[^A-Za-z0-9 .,\-();]/", "", $input);
    }

    public static function onlyAlphaNumericString($input) {
        return preg_replace("/[^A-Za-z0-9]/", "", $input);
    }

    public static function onlyAlphaNumericWithSpace($input) {
        return preg_replace("/[^A-Za-z0-9 ]/", "", $input);
    }

    public static function onlyNumericString($input) {
        return preg_replace("/[^0-9]/", "", $input);
    }

    public static function getFileExtension($filename) {
        return substr(strrchr($filename, '.'), 1);
    }
    
    public static function toArrayUnidimensional($arr, $field){

        $result = array();

        if(is_array($arr) && count($arr)>0 && strlen($field.'')>0){
            foreach ($arr as $reg) {
                if(array_key_exists($field, $reg)){
                    $result[] = $reg[$field];
                }
            }
        }

        return $result;
        
    }
    
    /**
     * Indica si una entrada de caracteres solo contiene dígitos alfabéticos
     * 
     * @param string $input
     * @return boolean
     */
    public function isValidAlphabetic($input) {
        //compruebo que el tamaño del string sea válido.
        if (strlen($input) < 0) {
            return false;
        }
        //compruebo que los caracteres sean los permitidos
        $permitidos = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚáéíóú ";
        for ($i = 0; $i < strlen($input); $i++) {
            if (strpos($permitidos, substr($input, $i, 1)) === false) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Indica si una entrada de caracteres solo contiene dígitos alfanuméricos
     * 
     * @param string $input
     * @return boolean
     */
    public function isValidAlphanumeric($input) {
        //compruebo que el tamaño del string sea válido.
        if (strlen($input) < 0) {
            return false;
        }
        //compruebo que los caracteres sean los permitidos
        $permitidos = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚáéíóú ";
        for ($i = 0; $i < strlen($input); $i++) {
            if (strpos($permitidos, substr($input, $i, 1)) === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Converts all accent characters to ASCII characters.
     *
     * If there are no accent characters, then the string given is just returned.
     *
     * @param string $string Text that might have accent characters
     * @return string Filtered string with replaced "nice" characters.
     */
    public static function stripAccents($string) {
        if (!preg_match('/[\x80-\xff]/', $string))
            return $string;
        if (self::seems_utf8($string)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement
                chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
                chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
                chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
                chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
                chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
                chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
                chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
                chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
                chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
                chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
                chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
                chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
                chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
                chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
                chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
                chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
                chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
                chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
                chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
                chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
                chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
                chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
                chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
                chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
                chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
                chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
                chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
                chr(195) . chr(191) => 'y',
                // Decompositions for Latin Extended-A
                chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
                chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
                chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
                chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
                chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
                chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
                chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
                chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
                chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
                chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
                chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
                chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
                chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
                chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
                chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
                chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
                chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
                chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
                chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
                chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
                chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
                chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
                chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
                chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
                chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
                chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
                chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
                chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
                chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
                chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
                chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
                chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
                chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
                chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
                chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
                chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
                chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
                chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
                chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
                chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
                chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
                chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
                chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
                chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
                chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
                chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
                chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
                chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
                chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
                chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
                chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
                chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
                chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
                chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
                chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
                chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
                chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
                chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
                chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
                chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
                chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
                chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
                chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
                chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's',
                // Euro Sign
                chr(226) . chr(130) . chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194) . chr(163) => '');
            $string = strtr($string, $chars);
        } else {
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158)
                    . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194)
                    . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202)
                    . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210)
                    . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218)
                    . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227)
                    . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235)
                    . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243)
                    . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251)
                    . chr(252) . chr(253) . chr(255);
            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }
        return $string;
    }

    public static function seems_utf8($str) {
        $length = strlen($str);
        for ($i = 0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80)
                $n = 0;# 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0)
                $n = 1;# 110bbbbb
            elseif (($c & 0xF0) == 0xE0)
                $n = 2;# 1110bbbb
            elseif (($c & 0xF8) == 0xF0)
                $n = 3;# 11110bbb
            elseif (($c & 0xFC) == 0xF8)
                $n = 4;# 111110bb
            elseif (($c & 0xFE) == 0xFC)
                $n = 5;# 1111110b
            else
                return false;# Does not match any model
            for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
                if (( ++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
    }

    /*
     * Convertir cadenas a minúsculas en utf8
     *
     * @recibe   cadena de caracteres
     * @devuelve cadena reemplazada
     *
     * Uso: $objeto->strtolower_utf8(cadena);
     *
     */
    public static function strtolower_utf8($cadena) {
        $convertir_a = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u",
            "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ę", "ì", "í", "î", "ï",
            "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж",
            "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы",
            "ь", "э", "ю", "я"
        );
        $convertir_de = array(
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U",
            "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ę", "Ì", "Í", "Î", "Ï",
            "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж",
            "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ",
            "Ь", "Э", "Ю", "Я"
        );
        return str_replace($convertir_de, $convertir_a, $cadena);
    }

    /*
     * Convertir cadenas a mayúsculas en utf8
     *
     * @recibe   cadena de caracters
     * @devuelve cadena reemplazada
     *
     * Uso: $objeto->strtotoupper_utf8(cadena);
     *
     */
    public static function strtoupper_utf8($cadena) {
        $convertir_de = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u",
            "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ę", "ì", "í", "î", "ï",
            "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж",
            "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы",
            "ь", "э", "ю", "я"
        );
        $convertir_a = array(
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U",
            "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ę", "Ì", "Í", "Î", "Ï",
            "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж",
            "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ",
            "Ь", "Э", "Ю", "Я"
        );
        return str_replace($convertir_de, $convertir_a, $cadena);
    }

    /**
     * Devuelve el microtaime en formato string con o sin punto (.)
     */
    public static function microtimeString($whitPoint=false){

        list($usec, $sec) = explode(" ", microtime());

        $microtime = (string) ((float)$usec + (float)$sec);
        $resultado = $microtime;

        if(!$whitPoint){
            $resultado =  str_replace(".","",$microtime);
        }

        return $resultado;
    }

    /**
     * Devuelve el microtaime en formato float
     */
    public static function microtimeFloat(){
        list($usec, $sec) = explode(" ", microtime());
        $resultado = ((float)$usec + (float)$sec);
        return $resultado;
    }

    /**
     * Devuelve el microtaime en formato Int completo, los decimales se convierten en parte del número entero
     */
    public static function microtimeInt(){
        list($usec, $sec) = explode(" ", microtime());
        $microtime = ((float)$usec + (float)$sec);
        $resultado =  (int) str_replace(".","",$microtime);
        return $resultado;
    }

    /**
     *   //Ejemplo
     *   $fecha= "24/09/2009";
     *
     *   if(dateCheck($fecha)===false){
     *       echo "La fecha no es correcta";
     *   }else{
     *       echo "La fecha es correcta";
     *   }
     *   // imprime "La fecha es correcta"
     *
     *   @param String $input Fecha en formato DD/MM/YYYY ó DD.MM.YYYY ó DD-MM-YYYY
     *          si $format es igual a "dmy" (diamesanho)
     *   @param String $format formato de la fecha valores permitidos dmy, mdy y ymd
     */
    public static function isValidDate($input, $format = "dmy") {
        $separator_type = array(
            "/",
            "-",
            "."
        );
        $separator_used = '/';
        foreach ($separator_type as $separator) {
            $find = stripos($input, $separator);
            if ($find <> false) {
                $separator_used = $separator;
                break;
            }
        }
        $input_array = explode($separator_used, $input);
        if (count($input_array) == 3) {
            //echo "count(input_array)==3";
            if ($format == "mdy" || $format == "m-d-y") {
                return checkdate($input_array[0], $input_array[1], $input_array[2]);
            } elseif ($format == "ymd" || $format == "y-m-d") {
                return checkdate($input_array[1], $input_array[2], $input_array[0]);
            } else {
                //echo "format=dmy | {$input_array[1]},{$input_array[0]},{$input_array[2]}";
                return checkdate($input_array[1], $input_array[0], $input_array[2]);
            }
        } else {
            return false;
        }
    }

    public static function isNumericArray($array){

        if(is_array($array) and $array!=array()){

                foreach($array as $value){
                    if(!is_numeric($value)){
                        return false;
                    }
                }
                 return true;
        }else{
            return false;
        }

    }

    public static function isValidExtension($filePath, $target){

        $ext = pathinfo($filePath, PATHINFO_EXTENSION);

        $result = false;

        if(is_array($target)){
            $result = (in_array($ext, $target));
        }elseif(is_string($target)){
            $result = ($ext==$target);
        }

        return $result;
    }

    public static function toPgArray($set, $isString=false) {
        settype($set, 'ARRAY'); // can be called with a scalar or array
        $result = array();
        foreach ($set as $t) {
            if (is_array($t)) {
                $result[] = to_pg_array($t);
            } else {
                $t = str_replace('"', '\\"', $t); // escape double quote
                if (!is_numeric($t) || $isString){ // quote only non-numeric values
                    $t = "'" . $t . "'";
                }
                $result[] = $t;
            }
        }
        return 'ARRAY[' . implode(",", $result) . ']'; // format
    }

    public static function pgArrayParse($text, &$output, $limit = false, $offset = 1){

        if (false === $limit){
            $limit = strlen($text) - 1;
            $output = array();
        }
        if ('{}' != $text){

            do {
                if ('{' != $text{$offset}) {
                    preg_match("/(\\{?\"([^\"\\\\]|\\\\.)*\"|[^,{}]+)+([,}]+)/", $text, $match, 0, $offset);

                    $offset += strlen($match[0]);
                    $output[] = ( '"' != $match[1]{0} ? $match[1] : stripcslashes(substr($match[1], 1, -1)) );
                    if ('},' == $match[3])
                        return $offset;
                } else {
                    $offset = self::pgArrayParse($text, $output[], $limit, $offset + 1);
                }
            } while ($limit > $offset);

        }

        return $output;
    }

    public static function fromPgArrayToPhpArray($input){
        $result = array();
        if(strlen($input)>0){

            $strClean = str_replace('{', '',$input);
            $strClean = str_replace('}', '',$strClean);

            $firstArray = explode('",', $strClean);
            
            if(count($firstArray)>0){
                foreach($firstArray as $element){
                    $finalArray[] = self::cleanString($element);
                }
                $result = $finalArray;
            }
            else{
                $firstArray = explode(',\"', $strClean);
                if(count($firstArray)>0){
                    foreach($firstArray as $element){
                        $finalArray[] = self::cleanString($element);
                    }
                    $result = $finalArray;
                }
                $result = $strClean;
            }

        }
        return $result;
    }

    public static function cleanString($input){
        return preg_replace('/[^a-z\d «»\-().,:_]/i', '', $input);
    }

    public static function confirmarUsuario($password){
        $passwordDecoded = base64_decode($password);
        $respuesta = array();

        $passwordEncoded = md5($passwordDecoded);

        $modelUsuario = UserGroupsUser::model()->findByPk(Yii::app()->user->id);

        if ($modelUsuario['password'] == md5($passwordDecoded . $modelUsuario->getSalt())) {
            $respuesta = array('success' => true, 'error' => false);
        } else {
            $respuesta = array('success' => false, 'error' => true);
        }

        return json_encode($respuesta);

    }

    public static function generarLetraFromCedula($cedula){

        if(is_numeric($cedula)){
            $numero = $cedula;
        }
        else{
            $numero = substr($cedula, 2);
        }

        $letra = substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($numero, "XYZ", "012")%23, 1);

        return $letra;

    }
    
    public static function generateBarcodeInFile($fileName, $content, $fontSize=10){
        
        Yii::import('ext.barcodegen.class.BCGFontFile');
        Yii::import('ext.barcodegen.class.BCGColor');
        Yii::import('ext.barcodegen.class.BCGDrawing');
        Yii::import('ext.barcodegen.class.BCGcode39');
        
        $font = new BCGFontFile(Yii::app()->basePath.'/extensions/barcodegen/font/Arial.ttf', $fontSize);
        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);

        $code = new BCGcode39();
        $code->setScale(2);
        $code->setThickness(30);
        $code->setFont($font);
        $code->setChecksum(false);
        $code->parse($content);

        $drawing = new BCGDrawing($fileName, $color_white);
        $drawing->setBarcode($code);
        $drawing->draw();

        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
        $command = 'chmod 777 -R '.$fileName;
        exec($command);

    }
    
    public static function generateQrCodeInFile($fileName, $content){
        Yii::import('ext.qrcode.QRCode');
        $code = new QRCode($content);
        $code->create($fileName);
        $command = 'chmod 777 -R '.$fileName;
        exec($command);
    }
    
    public static function removeXSS($val) { 
        // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed 
        // this prevents some character re-spacing such as <java\0script> 
        // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs 
        $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val); 

        // straight replacements, the user should never need these since they're normal characters 
        // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29> 
        $search = 'abcdefghijklmnopqrstuvwxyz'; 
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $search .= '1234567890!@#$%^&*()'; 
        $search .= '~`";:?+/={}[]-_|\'\\'; 
        for ($i = 0; $i < strlen($search); $i++) { 
           // ;? matches the ;, which is optional 
           // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars 

           // &#x0040 @ search for the hex values 
           $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ; 
           // &#00064 @ 0{0,7} matches '0' zero to seven times 
           $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ; 
        } 

        // now the only remaining whitespace attacks are \t, \n, and \r 
        $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base'); 
        $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 
        $ra = array_merge($ra1, $ra2); 

        $found = true; // keep replacing as long as the previous round replaced something 
        while ($found == true) { 
           $val_before = $val; 
           for ($i = 0; $i < sizeof($ra); $i++) { 
              $pattern = '/'; 
              for ($j = 0; $j < strlen($ra[$i]); $j++) { 
                 if ($j > 0) { 
                    $pattern .= '('; 
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)'; 
                    $pattern .= '|'; 
                    $pattern .= '|(&#0{0,8}([9|10|13]);)'; 
                    $pattern .= ')*'; 
                 } 
                 $pattern .= $ra[$i][$j]; 
              } 
              $pattern .= '/i'; 
              $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag 
              $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags 
              if ($val_before == $val) { 
                 // no replacements were made, so exit the loop 
                 $found = false; 
              } 
           } 
        } 
        return $val; 
     }  
    
    public static function getMeses(){
        
        $meses = array(
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Junio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre');
        
        return $meses;
        
    }

}

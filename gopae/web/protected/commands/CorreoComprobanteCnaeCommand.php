<?php

class CorreoComprobanteCnaeCommand extends CConsoleCommand {

    const MODULO = "RegistroUnico.CorreoComprobanteCnaeCommand";

    private static $testing = true;
    
    private $module = 'registroUnico';

    private $cacheIndex;

    public function actionEnvio() {

        echo Yii::app()->params['adminEmailSend']."\n";

        try {

            $fechaInicio = date('Y-m-d H:i:s');
            echo "\n------------------------------------------------------------------------\n";
            echo "\n----------------------------I  N  I C  I  O-----------------------------\n";
            echo "\n------------------------------------------------------------------------\n";
            echo "$fechaInicio: INICIO DEL PROCESO DE ENVÍO DE CORREO DEL COMPROBANTE CNAE. \n";

            $this->cacheIndex = 'SINEMAILCOMPRCNAE:'.date('Ymd');

            // $cantidadVecesSinEmailPorEnviar = Yii::app()->cache->get($this->cacheIndex);
            $cantidadVecesSinEmailPorEnviar = 0;

            $comprobantesSinEnviar = PlantelPaeComprobante::getComprobantesCnaeNoEnviadosPorCorreo();

            if(!$cantidadVecesSinEmailPorEnviar){
                $cantidadVecesSinEmailPorEnviar = 0;
            }

            echo "LA CANTIDAD DE COMPROBANTES SIN ENVIAR SON <<".count($comprobantesSinEnviar).">>\n";

            if(is_array($comprobantesSinEnviar) && count($comprobantesSinEnviar)>0 && $cantidadVecesSinEmailPorEnviar<14){

                self::$testing = Yii::app()->params['testing'];

                if(!self::$testing){

                    // Yii::import('application.extensions.swiftMailer.SwiftMailer');

                    $mailHost = Yii::app()->params['mailServer'];
                    $mailPort = Yii::app()->params['portMailServer'];
                    echo "\n------------------------------------------------------------------------\n";
                    echo("Se enviará desde el Servidor <<$mailHost:$mailPort>>.\n");

                    // die();

                    $directory = str_replace('//', '/', Yii::app()->params['webDirectoryPath'].Yii::app()->params['urlDownloadComprobanteCnae']);

                    $administrador['nombre'] = "Administrador Gopae";
                    $administrador['correo'] = Yii::app()->params['adminEmailSend'];

                    $contador = 1;

                    foreach ($comprobantesSinEnviar as $comprobante) {
                        
                        echo "\n------------------------------------------------------------------------\n";
                        echo "\n------------------------------------------------------------------------\n";
                        
                        if($contador==100){
                            sleep(90);
                            $contador = 1;
                        }

                        if(is_file($directory.$comprobante['archivo_pdf'])){

                            $contenido = $this->renderPartial('/plantelesPae/_correoComprobanteCnae', array(
                                'comprobante' => $comprobante
                            ), true);

                            $nombreDestinatario = (isset($comprobante['origen_autoridad']) && isset($comprobante['cedula_autoridad'])) ? $comprobante['origen_autoridad'].'-'.$comprobante['cedula_autoridad'] : null;
                            $correDestinatario = (isset($comprobante['correo_autoridad'])) ? strtolower($comprobante['correo_autoridad']) : null;
                            $plantel = (isset($comprobante['plantel'])) ? 'Director - '.$comprobante['plantel'] : null;
                            // Send mail
                            $archivo = $directory.$comprobante['archivo_pdf'];
                            $result = $this->enviarCorreo($correDestinatario, $plantel, 'CNAE - Sistema de Gestión Operativa del PAE | Comprobante de Beneficiario', $contenido, 'soporte_gescolar@me.gob.ve', 'CNAE - Sistema de Gestión Operativa del PAE', $archivo);
                            
                            var_dump($result);
                            
                            if($result){
                                $actualizacion = PlantelPaeComprobante::marcarComprobanteCnaeEnviado($comprobante['id']);
                                if($actualizacion){
                                    echo date('Y-m-d H:i:s').': ENVIO EXITOSO - ACTUALIZACION DE ESTATUS DE SOLICITUD DE COMPROBANTE EXITOSO'.json_encode($comprobante).".\n";
                                }
                                else{
                                    echo date('Y-m-d H:i:s').': ENVIO EXITOSO - '.json_encode($comprobante).".\n";
                                }
                            }
                            else{
                                echo date('Y-m-d H:i:s').': ENVIO FALLIDO - '.json_encode($comprobante).".\n";
                            }

                        }
                        else{
                            echo date('Y-m-d H:i:s').': ENVIO FALLIDO - NO EXISTE EL ARCHIVO ADJUNTO - '.json_encode($comprobante)."\n";
                        }

                        $contador = $contador + 1;

                    }

                    echo date('Y-m-d H:i:s').": FIN DEL PROCESO DE ENVÍO DE CORREO CON COMPROBANTE CNAE.\n\n\n\n";

                }

            }
            else{
                if($cantidadVecesSinEmailPorEnviar>13){
                    echo date('Y-m-d H:i:s').": POR EL DÍA DE HOY SE EXCEDIÓ EL NUMERO DE VECES QUE NO EXISTEN CORREOS CON COMPROBANTE CNAE QUE ENVIAR.\n";
                }
                else{
                    echo date('Y-m-d H:i:s').": NO EXISTEN COMPROBANTES CNAE QUE ENVIAR.\n";
                }
                if(!$cantidadVecesSinEmailPorEnviar){
                    $cantidadVecesSinEmailPorEnviar = 1;
                    Yii::app()->cache->set($this->cacheIndex, $cantidadVecesSinEmailPorEnviar, 43200);
                }else{
                    $cantidadVecesSinEmailPorEnviar = $cantidadVecesSinEmailPorEnviar + 1;
                    Yii::app()->cache->set($this->cacheIndex, $cantidadVecesSinEmailPorEnviar, 43200);
                }
            }

        } catch (Exception $ex) {
            $respuesta['statusCode'] = 'error';
            $respuesta['error'] = $ex->getMessage();
            $respuesta['mensaje'] = "HA OCURRIDO UN ERROR DURANTE EL PROCESO DE ENVÍO DE CORREO DEL COMPROBANTE CNAE. {$respuesta['error']}.";
//            $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
//            $mailer->Host = 'mail.me.gob.ve:25';
//            $mailer->IsSMTP();
//            $mailer->From = Yii::app()->params['adminEmailSend']; //Es quien lo envia
//            $mailer->FromName = 'Sistema de Gestión Escolar';
//            $mailer->AddAddress(Yii::app()->params['adminEmailSend'], 'Equipo de Soporte del Sistema de Gestión Escolar');
//            $mailer->CharSet = 'UTF-8';
//            $mailer->Subject = 'Notificación de Registro Programado de Seriales del MPPPE';
//            $mailer->Body = $respuesta['mensaje'];
//            $mailer->Send();
            echo date('Y-m-d H:i:s').": ERROR - ".$respuesta['mensaje'].'. Linea: Nro. '.$ex->getLine().".\n";
            echo date('Y-m-d H:i:s').": FIN DEL PROCESO DE ENVÍO DE CORREO DEL COMPROBANTE CNAE - CON ERROR.\n\n\n\n\n\n";
        }
    }

    public function getViewPath($module='') {
        $modulePath = '';
        if(strlen($module)>0){
            $modulePath = '/modules/'.$module;
        }
        return Yii::app()->getBasePath() . $modulePath . DIRECTORY_SEPARATOR . 'views';
    }
    
    /**
     * 
     * @param type $to
     * @param type $subject
     * @param type $msj
     * @param type $from
     * @param type $from_name
     * @param type $archivo
     * @param type $nombre_archivo
     * @return type
     */
    static public function enviarCorreo($to, $to_name, $subject = 'SIR-SWL', $msj = '', $from = '', $from_name = '',$archivo=null,$nombre_archivo=null) {
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer->Host = 'mail.me.gob.ve:25';
        $mailer->SMTPDebug  = 2;
        $mailer->IsSMTP();
        
        // $mailer->SMTPAuth   = true;                  // enable SMTP authentication
        // $mailer->SMTPSecure = "tls";                 // sets the prefix to the servier
        // $mailer->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        // $mailer->Port       = 587;                   // set the SMTP port for the GMAIL server
        // //$mailer->Username   = "soporte_gopae_cnae@gmail.com";  // GMAIL username
        // $mailer->Username   = "gescolar.mppe@gmail.com";  // GMAIL username
        // $mailer->Password   = "gescolarpro";            // GMAIL password
        
        if (is_array($to)) {
            foreach ($to as $sendTo) {
                $mailer->AddAddress($sendTo);
            }
        } else {
            echo 'Email to: '.$to.'. Name To: '.$to_name."\n";
            $mailer->AddAddress($to, $to_name);
        }

        if (isset($from) and $from != '' and $from != null)
            $mailer->From = $from;
        else
            $mailer->From = Yii::app()->params->adminEmail;
        if (isset($from_name) and $from_name != '' and $from_name != null)
            $mailer->FromName = $from_name;
        else
            $mailer->FromName = Yii::app()->params->adminName;
        if($archivo){
            //$mailer->AddBCC('soporte_gescolar@me.gob.ve');
            //$mailer->AddBCC('jarojasm@me.gob.ve');
            $mailer->AddBCC(Yii::app()->params['adminGmail']);
            $mailer->AddAttachment($archivo);
        }
        
        $mailer->Username = 'soporte_gescolar';

        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = $subject;
        $mailer->MsgHTML($msj);
        return $mailer->Send();
    }

    /**
     * Modified copy of getViewFile
     * @see CController::getViewFile
     * @param $viewName
     * @return string
     */
    public function getViewFile($viewName) {
        return $this->getViewPath($this->module) . $viewName . '.php';
    }

    /**
     * Modeified copy of renderPartial from CController
     * @see CController::renderPartial
     * @param $view
     * @param $data
     * @param $return
     * @return mixed
     * @throws CException
     */
    public function renderPartial($view, $data, $return) {
        if (($viewFile = $this->getViewFile($view)) !== false) {
            $output = $this->renderFile($viewFile, $data, true);
            if ($return)
                return $output;
            else
                echo $output;
        } else
            throw new CException(Yii::t('yii', '{class} cannot find the requested view "{view}".', array('{class}' => get_class($this), '{view}' => $view)));
    }

}

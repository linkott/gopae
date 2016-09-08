<?php

/**
 *
 */
class GenerarCodigoActivacionCommand extends CConsoleCommand {

    /**
     * @param integer $group_id ID que hace referencia al grupo de Usuarios al cual se desea Generar el Código de Activación.
     * @return string Estatus del Proceso, ademas de genear un Archivo Log con todos los Usuarios al cual se realizó dicho proceso.
     */
    public function actionIndex($group_id) {
        if (is_numeric($group_id)) {
            $dataReport = "";
            $resultado = true;
            $usuarios = UserGroupsUser::model()->getUsuariosGrupo($group_id);
            $dataReport = '"Usuario";"Email";"Código de Activación";"Enlace Corto";"Enlace Completo"' . "\n";
//            $headers = array('Usuario', 'Email', 'Código de Activación', 'Enlace Corto', 'Enlace Completo');
//            $colDef = array('username' => array(), 'email' => array(), 'activation_code' => array(), 'enlace_c' => array(), 'enlace_comp' => array());
            if (count($usuarios) > 0) {
                echo "\n " . "GENERANDO CÓDIGOS DE ACTIVACIÓN PARA  " . count($usuarios) . ' USUARIOS DEL GRUPO ' . $group_id . "\n";
                foreach ($usuarios as $key => $value) {

                    $usuario = new UserGroupsUser('passRequest');
                    $usuario = UserGroupsUser::model()->findByAttributes(array('username' => $value));
                    $usuario->scenario = 'passRequest';
                    if ($usuario->updateUsuarioCodActivacion($usuario)) {
                        $usuario = UserGroupsUser::model()->findByAttributes(array('username' => $value));
                        //echo "\n " . "CÓDIGO DE ACTIVACIÓN GENERADO PARA EL  USUARIO " . $usuario->username . " \n";
                        //$mail = new UGMail($usuario, UGMail::PASS_RESET);
                        //$mail->send();
                        $link = Yii::app()->params['hostName'].'/userGroups/user/activate';
                        $full_link = $link . '?UserGroupsUser[username]=' . $usuario->username . '&UserGroupsUser[activation_code]=' . $usuario->activation_code;
                        $dataReport.= $usuario->username . ';' . $usuario->email . ';"' . $usuario->activation_code . '";"' . $link . '";"' . $full_link . '"' . "\n";
                        //$this->registerLog(' ', 'commands.generarCodigoActivacionCommand.run', 'EXITOSO', ' ');
                    } else {
                        $resultado = false;
                    }
                }
                if ($resultado) {
                    $mode = 0777;
                    $fileName = 'Reporte_Generacion_Codigo_Activacion-' . date('YmdHis') . '.csv';
                    $ruta = Yii::app()->basePath;
                    $ruta = str_replace('protected', 'public/rep_codigo_activacion', $ruta);
                    if (!is_dir($ruta)) {
                        mkdir($ruta, $mode);
                    }
                    $rutaArchivo = $ruta . "/" . $fileName;
                    $archivo = fopen($rutaArchivo, "w+");
                    fwrite($archivo, $dataReport);
                    fclose($archivo);
                    echo "\n " . "SE HA CULMINADO EL PROCESO, VERIFIQUE EL CSV GENERADO EN " . $rutaArchivo . " \n";
                } else {

                    echo "\n " . "SUCEDIO UN PROBLEMA " . $group_id . " NO ES UN NUMERO \n";
                }
            } else {
                echo "\n " . "NO SE ENCONTRARON USUARIOS CON EL GRUPO_ID :" . $group_id . "\n";
            }
        } else
            echo "\n " . "EL GRUPO_ID :" . $group_id . " NO ES UN NUMERO \n";
    }

}

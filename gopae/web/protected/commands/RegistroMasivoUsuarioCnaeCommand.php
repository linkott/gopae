<?php
/**
 * Created by PhpStorm.
 * User: jsinner
 * Date: 15/03/15
 * Time: 10:51 AM
 */

class RegistroMasivoUsuarioCnaeCommand {
    const MODULO = "RegistroMasivo.Usuarios.RegistroUnico";

    private static $testing = true;

    private $module = 'registroMasivo';

    private $cacheIndex;

    public function actionCreacionDeUsuarios() {

        $csvReader = new CsvReader('/var/www/gopae/web/public/uploads/USUARIOS.csv');

        $dataFile = $csvReader->getDataInArray();

        $usuarios = array();
        foreach($dataFile as $data){

            $cedula = $data['A'];
            $nombre = $data['B'];
            $correo = (strlen($data['C'])>0)?$data['C']:"$cedula@gmail.com";
            $nombreEstado = $data['D'];
            $grupo = 47;

            if($cedula!='CEDULA' && $cedula=='7924830'){

                $usuario = $this->loadModel($cedula, 'changePassword');

                if($usuario){
                    $usuario->password = $cedula;
                }
                else{
                    $usuario = new UserGroupsUser('create');
                    $estado = CEstado::getData('nombre', $nombreEstado);
                    $estadoId = $estado[0]['id'];
                    $usuario->origen = 'V';
                    $usuario->cedula = (int)$cedula;
                    $usuario->nombre = $nombre;
                    $usuario->email = $correo;
                    $usuario->estado_id = $estadoId;
                    $usuario->home = '/site';
                    $usuario->creation_date = '2015-03-14 18:10:16';
                    $usuario->username = $cedula.$this->generarLetraFromCedula($cedula);
                }

                $usuario->password = $cedula;
                $usuario->group_id = (int)$grupo;
                $usuario->status = 4;

                if($usuario->save()){
                    echo 'EXITO: '.$usuario->cedula.';'.$usuario->nombre.';'.$usuario->username.';'.$usuario->password.';'.$nombreEstado;
                }
                else{
                    echo 'ERROR: '.$usuario->cedula.';'.$usuario->nombre.';'.$usuario->username.';'.$usuario->password.';'.$nombreEstado;
                }

            }
        }

    }

    public function generarLetraFromCedula($cedula){

        if(is_numeric($cedula)){
            $numero = $cedula;
        }
        else{
            $numero = substr($cedula, 2);
        }

        $letra = substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($numero, "XYZ", "012")%23, 1);

        return $letra;

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * Optionally sets a scenario
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @param string the scenario to apply to the model
     */
    public function loadModel($cedula, $scenario = false) {
        $model = UserGroupsUser::model()->findByCedula((int) $cedula);
        if ($scenario)
            $model->setScenario($scenario);
        return $model;
    }

}
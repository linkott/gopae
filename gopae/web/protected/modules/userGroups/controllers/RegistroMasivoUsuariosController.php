<?php
/**
 * Created by PhpStorm.
 * User: jsinner
 * Date: 15/03/15
 * Time: 10:56 AM
 */

class RegistroMasivoUsuariosController extends Controller{

    static $_permissionControl = array(
        'read' => 'Registro Masivo de Usuarios',
        'write' => 'Registro Masivo de Usuarios',
        'admin' => 'Registro Masivo de Usuarios',
        'label' => 'Registro Masivo de Usuarios del Sistema'
    );

    /**
     *
     * @return array action filters
     */
    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {

        //en esta seccion colocar los action de solo lectura o consulta
        return array(
            array('allow',
                'actions' => array('index',),
                'pbac' => array('admin',),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );

    }

    public function actionIndex($grupo=null) {

        $csvReader = new CsvReader('/var/www/gopae/web/public/uploads/USUARIOS.csv');

        $dataFile = $csvReader->getDataInArray();

        $usuarios = array();
        $index = 0;
        echo '<html><head><meta charset="utf-8"></head><body>Nro.;Estatus;Cédula de Identidad;Nombre;Usuario;Clave;Email;Estado;Errores';
        foreach($dataFile as $data){

            $cedula = $data['A'];
            $nombre = ucwords(Utiles::strtolower_utf8($data['B']));
            $correo = Utiles::strtolower_utf8(Utiles::stripAccents((strlen($data['C'])>0)?$data['C']:"cnae$cedula@gmail.com"));
            $nombreEstado = $data['D'];

            if($cedula!='CEDULA'){

                $index++;

                $usuario = $this->loadModel($cedula, 'create');

                if($usuario){
                    // md5($this->password . $this->getSalt())
                    $usuario->password = md5($cedula . $usuario->getSalt());
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
                    $usuario->password = $cedula;
                }

                $usuario->group_id = (int)$grupo;
                $usuario->status = 4;
                $usuario->date_act = '2015-03-14 18:10:16';

                if($usuario->validate() && $usuario->save()){
                    echo '<br/>'.$index.';EXITO;'.$usuario->cedula.';'.$usuario->nombre.';'.$usuario->username.';'.$usuario->cedula.';'.$usuario->email.';'.$nombreEstado.';';
                }
                else{
                    echo '<br/>'.$index.';ERROR;'.$usuario->cedula.';'.$usuario->nombre.';'.$usuario->username.';'.$usuario->cedula.';'.$usuario->email.';'.$nombreEstado.';'.CHtml::errorSummary($usuario);
                }

            }
        }
        echo '</body></html>';

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
        $model = UserGroupsUser::model()->find('cedula='.(int)$cedula);
        if ($scenario && is_object($model))
            $model->setScenario($scenario);
        return $model;
    }
}

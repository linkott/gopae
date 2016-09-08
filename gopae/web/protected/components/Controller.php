<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    private $_csrfToken;

    protected $csrfTokenName;

    /**
     * @var mixed the default tooltip for every controller.
     * if you give to this parameter a boolean false value instead of an array,
     * the controller will not be displayed in the permission menagement view.
     * for more information view the documentation in the userGroups module.
     */
    public static $_permissionControl = array('read' => false, 'write' => false, 'admin' => false);

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * The filter method for 'UserGroupsAccessControl' filter.
     * This filter is a wrapper of {@link UserGroupsAccessControl}.
     * To use this filter, you must override {@link accessRules} method.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     */
    public function filterUserGroupsAccessControl($filterChain) {
        Yii::import('userGroups.models.UserGroupsUser');
        Yii::import('userGroups.models.UserGroupsConfiguration');
        Yii::import('userGroups.components.UserGroupsAccessControl');
        $filter = new UserGroupsAccessControl;
        $filter->setRules($this->accessRules());
        $filter->filter($filterChain);
    }

    /**
     * @param String $tipo_transaccion Tipo de Transacción. (LECTURA, ESCRITURA, ACTUALIZACION, REPORTES, LOGIN, LOGOUT, ADMINISTRACION, ILEGAL,ELIMINACION,ACTIVACION,INACTIVACION)
     * @param String $modulo (module.controller.action) Indica el Nombre lógico de la acción a la que el usuario ha efectuado una transacción debe Cumplir con el patrón "Módulo.Controlador.Acción"
     * @param String $resultado_transaccion Indica el resultado de la transacción efectuada por el usuario. (EXITOSO, INCOMPLETO, NO EXITOSO, ERROR)
     * @param String $descripcion Descripción detallada de la acción ejecutada
     * @param String $ip_maquina Dirección IP del Usuario Actual
     * @param integer $user_id Id del Usuario Actual
     * @param String $username Nombre del Usuario
     * @param String $fecha_hora Fecha en la que se efectuó el registro de la traza en Formato YYYY-MM-DD HH24:II:SS
     *
     */
    public static function registerLog($tipo_transaccion, $modulo, $resultado_transaccion, $descripcion, $ip_maquina = null, $user_id = null, $username = null, $fecha_hora = null) {

        if (is_null($user_id)) {
            $user_id = Yii::app()->user->id;
        }

        if (is_null($username)) {
            $username = Yii::app()->user->name;
        }

        if (is_null($ip_maquina)) {
            $ip_maquina = self::getRealIP();
        }

        if (is_null($fecha_hora)) {
            $fecha_hora = date('Y-m-d H:i:s');
        }

        $log = new Traza();
        $log->username = $username;
        $log->fecha_hora = $fecha_hora;
        $log->ip_maquina = $ip_maquina;
        $log->tipo_transaccion = $tipo_transaccion;
        $log->modulo = $modulo;
        $log->resultado_transaccion = $resultado_transaccion;
        $log->descripcion = $descripcion;
        $log->user_id = $user_id;

        if($log->save()){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 
     * @param string $salt
     * @param string $tokenName
     * @return string
     */
    public function getCsrfToken($salt='', $tokenName=null) {
        
        if(!is_null($tokenName) && strlen($tokenName)>0){
            $this->csrfTokenName = $tokenName;
        }
        
        if ($this->_csrfToken === null) {
            $session = Yii::app()->session;
            $csrfToken = $session->itemAt($this->csrfTokenName);
            if ($csrfToken === null) {
                $csrfToken = sha1(uniqid(mt_rand(), true).$salt);
                $session->add($this->csrfTokenName, $csrfToken);
            }
            $this->_csrfToken = $csrfToken;
        }

        //var_dump($this->_csrfToken);
        //die();

        return $this->_csrfToken;
    }
    
    /**
     * 
     * @param type $exception
     * @param type $tokenName
     * @return boolean
     * @throws CHttpException
     */
    public function validateCsrfToken($exception=true, $tokenName=null) {
        
        if(!is_null($tokenName) && strlen($tokenName)>0){
            $this->csrfTokenName = $tokenName;
        }
        
        if (Yii::app()->request->getIsPostRequest()) {
            // only validate POST requests
            $session = Yii::app()->session;

//            var_dump($_POST[$this->csrfTokenName]);
//            var_dump($session->itemAt($this->csrfTokenName));
//            die();

            if ($session->contains($this->csrfTokenName) && $this->hasPost($this->csrfTokenName)) {
                $tokenFromSession = $session->itemAt($this->csrfTokenName);
                $tokenFromPost = $this->getPost($this->csrfTokenName);
                $valid = $tokenFromSession === $tokenFromPost;
            }
            else {
                $valid = false;
            }

            if($exception){
                if (!$valid){
                    throw new CHttpException(400, Yii::t('yii', 'The CSRF token could not be verified.'));
                }
            }

            return $valid;
        }
    }
    
    /**
     * Permite obtener una respuesta json
     * 
     * @param Mixed $response Puede ser un array o un objeto PHP
     * @param Boolean $echo Indica si se imprime la respuesta o no.
     * @param Boolean $return Indica si se retorna la respuesta en formato json o no.
     * 
     * @return string Respuesta en formato json
     */
    public static function jsonResponse($response, $echo=true, $return=false){
        $resp = json_encode($response);
        if($echo){
            header('Content-Type: application/json');
            echo $resp;
        }
        if($return){
            return $resp;
        }
    }
    
    /**
     * Permite obtener una respuesta json
     *
     * @param Mixed $response Puede ser un array o un objeto PHP
     * @param Boolean $echo Indica si se imprime la respuesta o no.
     * @param Boolean $return Indica si se retorna la respuesta en formato json o no.
     *
     * @return string Respuesta en formato json
     */
    public static function xmlResponse($response, $echo=true, $return=false) {
        header("Content-Type: text/xml");
        $resp = Utiles::xml_encode($response);
        if($echo){
            header('Content-Type: application/json');
            echo $resp;
        }
        if($return){
            return $resp;
        }
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

    public function getPost($name, $defaultValue = null) {
        return isset($_POST[$name]) ? $_POST[$name] : $defaultValue;
    }

    public function getQuery($name, $defaultValue = null) {
        return isset($_GET[$name]) ? $_GET[$name] : $defaultValue;
    }

    public function getRequest($name, $defaultValue = null) {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $defaultValue;
    }

    public function hasPost($name) {
        return array_key_exists($name, $_POST) ? true : false;
    }

    public function hasQuery($name) {
        return array_key_exists($name, $_GET) ? true : false;
    }

    public function hasRequest($name) {
        return array_key_exists($name, $_REQUEST) ? true : false;
    }

    public function getIdDecoded($input, $base64=true){
        $result = $input;
        if($base64){
            if(!is_numeric($input)){
                $result = base64_decode($input);
            }
        }
        return $result;
    }

}

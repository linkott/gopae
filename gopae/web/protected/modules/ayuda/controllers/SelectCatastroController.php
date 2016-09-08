<?php

/**
 * SelectCatastroController : Este controlador se encargará de generar los selects dependientes de Catastro (Región, Estado, Municipio, Parroquia)
 *
 * @author José Gabriel González
 */
class SelectCatastroController extends Controller {

    //public $layout='//layouts/cuerpo';   // DEFINICIÒN DEL LAYOUT

    // PARTE I
    static $_permissionControl = array(
        'read' => 'Selects dependientes de Catastro',
        'label' => 'Selects dependientes de Catastro'
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
                'actions' => array('index', 'estadoStandalone', 'municipiosStandAlone', 'parroquiasStandalone'),
                'pbac' => array('read', 'write', 'admin'),
            ),
            array('allow',
                'actions' => array('index', 'estadoStandalone', 'municipiosStandAlone', 'parroquiasStandalone'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        throw new CHttpException(404, 'Página no encontrada.');
    }

    /**
     *
     * @param base_64(int) $regionId
     * @param base_64(int) $estadoId
     */
    public function actionEstadosStandalone($regionId, $estadoId=null){

        $regionIdDecoded = $this->getNumericDataDecoded($regionId);
        $estadoIdDecoded = $estadoId;
        if(!is_null($estadoId)){
            $estadoIdDecoded = $this->getNumericDataDecoded($estadoId);
        }

        echo CHtml::tag('option', array('value' => ''), CHtml::encode('- - -'), true);

        if(is_numeric($regionIdDecoded)){
            $estados = CEstado::getData('region_id', $regionIdDecoded);
            $lista = CHtml::listData($estados, 'id', 'nombre');
            foreach ($lista as $id => $nombre) {
                if(is_numeric($estadoIdDecoded) && $id==$estadoIdDecoded){
                    echo CHtml::tag('option', array('value' => $id, 'selected'=>'selected'), CHtml::encode($nombre), true);
                }else{
                    echo CHtml::tag('option', array('value' => $id), CHtml::encode($nombre), true);
                }
            }
        }

    }

    /**
     *
     * @param base_64(int) $estadoId
     * @param base_64(int) $municipioId
     */
    public function actionMunicipiosStandalone($estadoId, $municipioId=null){

        $estadoIdDecoded = $this->getNumericDataDecoded($estadoId);
        $municipioIdDecoded = $municipioId;
        if(!is_null($municipioId)){
            $municipioIdDecoded = $this->getNumericDataDecoded($municipioId);
        }

        echo CHtml::tag('option', array('value' => ''), CHtml::encode('- - -'), true);

        if(is_numeric($estadoId)){
            $municipios = CMunicipio::getData('estado_id', $estadoIdDecoded);
            $lista = CHtml::listData($municipios, 'id', 'nombre');
            foreach ($lista as $id => $nombre) {
                if(is_numeric($municipioIdDecoded) && $id==$municipioIdDecoded){
                    echo CHtml::tag('option', array('value' => $id, 'selected'=>'selected'), CHtml::encode($nombre), true);
                }else{
                    echo CHtml::tag('option', array('value' => $id), CHtml::encode($nombre), true);
                }
            }
        }

    }

    /**
     *
     * @param base_64(int) $municipioId
     * @param base_64(int) $parroquiaId
     */
    public function actionParroquiasStandalone($municipioId, $parroquiaId=null){

        $municipioIdDecoded = $this->getNumericDataDecoded($municipioId);
        $parroquiaIdDecoded = $parroquiaId;
        if(!is_null($parroquiaId)){
            $parroquiaIdDecoded = $this->getNumericDataDecoded($parroquiaId);
        }

        echo CHtml::tag('option', array('value' => ''), CHtml::encode('- - -'), true);

        if(is_numeric($municipioId)){
            $municipios = CParroquia::getData('municipio_id', $municipioIdDecoded);
            if(!$municipios){
                $municipios = array();
            }
            $lista = CHtml::listData($municipios, 'id', 'nombre');
            foreach ($lista as $id => $nombre) {
                if(is_numeric($parroquiaIdDecoded) && $id==$parroquiaIdDecoded){
                    echo CHtml::tag('option', array('value' => $id, 'selected'=>'selected'), CHtml::encode($nombre), true);
                }else{
                    echo CHtml::tag('option', array('value' => $id), CHtml::encode($nombre), true);
                }
            }
        }

    }

    protected function getNumericDataDecoded($data){

        $dataDecoded = $data;

        if(!is_numeric($data)){
            $dataDecoded = base64_decode($data);
        }

        return $dataDecoded;

    }

    // Uncomment the following methods and override them if needed
	/*

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

}
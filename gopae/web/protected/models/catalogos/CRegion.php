<?php

/**
 * Catalogo de Regiones
 *
 * @author Jose Gabriel Gonzalez
 */
class CEstado extends CCatalogo {
    
    protected static $columns = array('id', 'nombre', 'abreviatura');
    
    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData() {

        self::$data = array(
            0 =>
            array(
                'id' => 1,
                'nombre' => 'CAPITAL',
                'abreviatura' => 'CA',
            ),
            1 =>
            array(
                'id' => 2,
                'nombre' => 'CENTRAL',
                'abreviatura' => 'CE',
            ),
            2 =>
            array(
                'id' => 3,
                'nombre' => 'CENTRO OCCIDENTE',
                'abreviatura' => 'CO',
            ),
            3 =>
            array(
                'id' => 5,
                'nombre' => 'LOS ANDES',
                'abreviatura' => 'LA',
            ),
            4 =>
            array(
                'id' => 4,
                'nombre' => 'OCCIDENTE',
                'abreviatura' => 'OC',
            ),
            5 =>
            array(
                'id' => 6,
                'nombre' => 'ORIENTE',
                'abreviatura' => 'OR',
            ),
        );
    }

}

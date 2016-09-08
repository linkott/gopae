<?php

/**
 * Catalogo de Generos
 *
 * @author Generador de Código
 */
class COrigen extends CCatalogo {
    
    protected static $columns = array('id', 'nombre', 'abreviatura');
    
    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData() {

        self::$data = array(
            0 =>
            array(
                'id' => 1,
                'nombre' => 'Venezolano(a)',
                'abreviatura' => 'V',
            ),
            1 =>
            array(
                'id' => 2,
                'nombre' => 'Extrangero(a)',
                'abreviatura' => 'E',
            ),
            2 =>
            array(
                'id' => 3,
                'nombre' => 'Con Pasaporte',
                'abreviatura' => 'P',
            ),
        );
    }

}

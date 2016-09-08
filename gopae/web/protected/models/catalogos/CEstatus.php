<?php

/**
 * Catalogo de Generos
 *
 * @author Generador de Código
 */
class CEstatus extends CCatalogo {

    protected static $columns = array('id', 'nombre', 'abreviatura');
    
    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData() {

        self::$data = array(
            0 =>
            array(
                'id' => 1,
                'nombre' => 'Aspirante',
                'abreviatura' => 'A',
            ),
            1 =>
            array(
                'id' => 2,
                'nombre' => 'Empleado Activo',
                'abreviatura' => 'E',
            ),
            2 =>
            array(
                'id' => 3,
                'nombre' => 'Pasivo',
                'abreviatura' => 'P',
            ),
            3 =>
            array(
                'id' => 4,
                'nombre' => 'Egreso',
                'abreviatura' => 'O',
            ),
            4 =>
            array(
                'id' => 5,
                'nombre' => 'Comisión de Servicio en Otra Institución',
                'abreviatura' => 'S',
            ),
            5 =>
            array(
                'id' => 6,
                'nombre' => 'Inactivo',
                'abreviatura' => 'I',
            ),
        );
    }

}

<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CTipoDependencia extends CCatalogo { 

    protected static $columns = 
        array (
  0 => 'id',
  1 => 'nombre',
  2 => 'estatus',
);

    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData(){

        self::$data = 
        array (
  0 => 
  array (
    'id' => 4,
    'nombre' => 'Autonoma',
    'estatus' => 'A',
  ),
  1 => 
  array (
    'id' => 2,
    'nombre' => 'Estadal',
    'estatus' => 'A',
  ),
  2 => 
  array (
    'id' => 3,
    'nombre' => 'Municipal',
    'estatus' => 'A',
  ),
  3 => 
  array (
    'id' => 1,
    'nombre' => 'Nacional',
    'estatus' => 'A',
  ),
  4 => 
  array (
    'id' => 6,
    'nombre' => 'Privada',
    'estatus' => 'A',
  ),
  5 => 
  array (
    'id' => 8,
    'nombre' => 'Privada Subvencionada por MPPE',
    'estatus' => 'A',
  ),
  6 => 
  array (
    'id' => 7,
    'nombre' => 'Privada Subvencionada por Oficial',
    'estatus' => 'A',
  ),
)		; 

    	}
}

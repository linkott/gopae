<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CTurno extends CCatalogo { 

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
    'nombre' => 'Completo',
    'estatus' => 'A',
  ),
  1 => 
  array (
    'id' => 5,
    'nombre' => 'Integral-Mixto',
    'estatus' => 'A',
  ),
  2 => 
  array (
    'id' => 1,
    'nombre' => 'Mañana',
    'estatus' => 'A',
  ),
  3 => 
  array (
    'id' => 7,
    'nombre' => 'Mañana-Tarde',
    'estatus' => 'A',
  ),
  4 => 
  array (
    'id' => 3,
    'nombre' => 'Nocturno',
    'estatus' => 'A',
  ),
  5 => 
  array (
    'id' => 6,
    'nombre' => 'Sabatino',
    'estatus' => 'A',
  ),
  6 => 
  array (
    'id' => 2,
    'nombre' => 'Tarde',
    'estatus' => 'A',
  ),
)		; 

    	}
}

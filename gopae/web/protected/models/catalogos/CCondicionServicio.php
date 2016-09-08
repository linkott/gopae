<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CCondicionServicio extends CCatalogo { 

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
    'id' => 1,
    'nombre' => 'Precario',
    'estatus' => 'A',
  ),
  1 => 
  array (
    'id' => 2,
    'nombre' => 'Deficiente',
    'estatus' => 'A',
  ),
  2 => 
  array (
    'id' => 3,
    'nombre' => 'Regular',
    'estatus' => 'A',
  ),
  3 => 
  array (
    'id' => 4,
    'nombre' => 'Buena',
    'estatus' => 'A',
  ),
  4 => 
  array (
    'id' => 5,
    'nombre' => 'Excelente',
    'estatus' => 'A',
  ),
)		; 

    	}
}

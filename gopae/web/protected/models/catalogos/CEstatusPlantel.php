<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CEstatusPlantel extends CCatalogo { 

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
    'nombre' => 'ACTIVO',
    'estatus' => 'A',
  ),
  1 => 
  array (
    'id' => 3,
    'nombre' => 'CERRADO',
    'estatus' => 'A',
  ),
  2 => 
  array (
    'id' => 4,
    'nombre' => 'ELIMINADO',
    'estatus' => 'A',
  ),
  3 => 
  array (
    'id' => 2,
    'nombre' => 'INACTIVO',
    'estatus' => 'A',
  ),
  4 => 
  array (
    'id' => 5,
    'nombre' => 'REFUGIO',
    'estatus' => 'A',
  ),
)		; 

    	}
}

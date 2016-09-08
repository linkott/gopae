<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CTipoDocumento extends CCatalogo { 

    protected static $columns = 
        array (
  0 => 'id',
  1 => 'nombre',
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
    'nombre' => 'DOCUMENTO DE REGISTRO',
  ),
  1 => 
  array (
    'id' => 10,
    'nombre' => 'FIRMA AUTORIZADA',
  ),
  2 => 
  array (
    'id' => 12,
    'nombre' => 'OTRO',
  ),
  3 => 
  array (
    'id' => 9,
    'nombre' => 'REGISTRO DE SELLO',
  ),
  4 => 
  array (
    'id' => 2,
    'nombre' => 'RIF',
  ),
  5 => 
  array (
    'id' => 3,
    'nombre' => 'RNC',
  ),
  6 => 
  array (
    'id' => 7,
    'nombre' => 'SOLVENCIA ISLR',
  ),
  7 => 
  array (
    'id' => 8,
    'nombre' => 'SOLVENCIA IVA',
  ),
  8 => 
  array (
    'id' => 5,
    'nombre' => 'SOLVENCIA IVSS',
  ),
  9 => 
  array (
    'id' => 4,
    'nombre' => 'SOLVENCIA LABORAL',
  ),
  10 => 
  array (
    'id' => 6,
    'nombre' => 'SOLVENCIA LPH',
  ),
)		; 

    	}
}

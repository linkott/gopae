<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CTipoEmpresa extends CCatalogo { 

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
    'id' => 8,
    'nombre' => 'COMANDITARIAS',
    'estatus' => 'A',
  ),
  1 => 
  array (
    'id' => 2,
    'nombre' => 'COMPAÑIA ANONIMA',
    'estatus' => 'A',
  ),
  2 => 
  array (
    'id' => 3,
    'nombre' => 'COOPERATIVA',
    'estatus' => 'A',
  ),
  3 => 
  array (
    'id' => 10,
    'nombre' => 'FIRMA PERSONAL',
    'estatus' => 'A',
  ),
  4 => 
  array (
    'id' => 6,
    'nombre' => 'SOCIEDAD ANONIMA',
    'estatus' => 'A',
  ),
  5 => 
  array (
    'id' => 7,
    'nombre' => 'SOCIEDAD COLECTIVA',
    'estatus' => 'A',
  ),
  6 => 
  array (
    'id' => 9,
    'nombre' => 'SOCIEDAD DE RESPONSABILIDAD LIMITADA',
    'estatus' => 'A',
  ),
  7 => 
  array (
    'id' => 5,
    'nombre' => 'UNIPERSONAL',
    'estatus' => 'A',
  ),
)		; 

    	}
}

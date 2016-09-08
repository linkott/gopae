<?php
class CGradoInstruccion extends CCatalogo { 

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
    'nombre' => 'Primaria',
    'estatus' => 'A',
  ),
  1 => 
  array (
    'id' => 2,
    'nombre' => 'Graduado de Primaria',
    'estatus' => 'A',
  ),
  2 => 
  array (
    'id' => 3,
    'nombre' => 'Bachillerato',
    'estatus' => 'A',
  ),
  3 => 
  array (
    'id' => 4,
    'nombre' => 'Graduado de Bachiller',
    'estatus' => 'A',
  ),
  4 => 
  array (
    'id' => 5,
    'nombre' => 'Universitario',
    'estatus' => 'A',
  ),
  5 => 
  array (
    'id' => 6,
    'nombre' => 'Tecnico Superior',
    'estatus' => 'A',
  ),
  6 => 
  array (
    'id' => 7,
    'nombre' => 'Profesional Universitario',
    'estatus' => 'A',
  ),
  7 => 
  array (
    'id' => 8,
    'nombre' => 'Post-Grado',
    'estatus' => 'A',
  ),
  8 => 
  array (
    'id' => 9,
    'nombre' => 'Doctorado',
    'estatus' => 'A',
  ),
)		; 

    	}
}

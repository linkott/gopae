<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CTipoUnidadMedida extends CCatalogo { 

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
    'nombre' => 'PREPARACION',
    'estatus' => 'A',
  ),
  1 => 
  array (
    'id' => 2,
    'nombre' => 'COMPRA',
    'estatus' => 'A',
  ),
  2 => 
  array (
    'id' => 3,
    'nombre' => 'PARA PREPARACION Y COMPRA',
    'estatus' => 'A',
  ),
)		; 

    	}
}

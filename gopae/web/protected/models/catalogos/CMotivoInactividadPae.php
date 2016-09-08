<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CMotivoInactividadPae extends CCatalogo { 

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
    'nombre' => 'EL PROVEEDOR NO CUMPLE CON EL DESPACHO DE LOS INSUMOS',
    'estatus' => 'A',
  ),
  1 => 
  array (
    'id' => 2,
    'nombre' => 'EQUIPO(S) DE COCINA DAÑADO(S)',
    'estatus' => 'A',
  ),
)		; 

    	}
}

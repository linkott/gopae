<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CProveedor extends CCatalogo { 

    protected static $columns = 
        array (
  0 => 'id',
  1 => 'rif',
  2 => 'razon_social',
  3 => 'tipo_empresa_id',
  4 => 'tipo_sector_id',
  5 => 'estado_id',
  6 => 'estatus',
  7 => 'abreviatura'
);

    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData(){

        self::$data = 
        array (
  0 => 
  array (
    'id' => 5,
    'rif' => 'G-200035919',
    'razon_social' => 'MERCADO DE ALIMENTOS MERCAL, C.A.',
    'abreviatura' => 'MERCAL',
    'tipo_empresa_id' => 2,
    'tipo_sector_id' => 1,
    'estado_id' => 21,
    'estatus' => 'A',
  ),
  1 => 
  array (
    'id' => 6,
    'rif' => 'G-200100249',
    'abreviatura' => 'PDVAL',
    'razon_social' => 'PRODUCTORA Y DISTRIBUIDORA VENEZOLANA DE ALIMENTOS S.A.',
    'tipo_empresa_id' => 6,
    'tipo_sector_id' => 1,
    'estado_id' => 21,
    'estatus' => 'A',
  ),
  2 =>
        array (
            'id' => 0,
            'rif' => '0',
            'razon_social' => 'Otro Proveedor Privado',
            'abreviatura' => 'Otro Proveedor Privado',
            'tipo_empresa_id' => 2,
            'tipo_sector_id' => 2,
            'estado_id' => 21,
            'estatus' => 'A',
        ),
)		; 

    	}
}

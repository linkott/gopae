<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CCargo extends CCatalogo { 

    protected static $columns = 
        array (
  0 => 'id',
  1 => 'nombre',
  2 => 'descripcion',
  3 => 'estatus',
  4 => 'ente_id',
  5 => 'consecutivo',
);

    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData(){

        self::$data = 
        array (
  0 => 
  array (
    'id' => 3,
    'nombre' => 'Director(a) de Plantel',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 1,
    'consecutivo' => 0,
  ),
  1 => 
  array (
    'id' => 5,
    'nombre' => 'Sub-Director(a) de Plantel',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 1,
    'consecutivo' => 1,
  ),
  2 => 
  array (
    'id' => 16,
    'nombre' => 'Director(a) Suplente de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 2,
  ),
  3 => 
  array (
    'id' => 18,
    'nombre' => 'Sub-Director(a) Suplente de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 3,
  ),
  4 => 
  array (
    'id' => 17,
    'nombre' => 'Coordinador(a) de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 5,
  ),
  5 => 
  array (
    'id' => 27,
    'nombre' => 'Enlace PAE del Plantel',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 1,
    'consecutivo' => 6,
  ),
  6 => 
  array (
    'id' => 19,
    'nombre' => 'Coordinador(a) Suplente de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 6,
  ),
  7 => 
  array (
    'id' => 12,
    'nombre' => 'Psicopedagogo(a) de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 7,
  ),
  8 => 
  array (
    'id' => 13,
    'nombre' => 'Coordinador(a) de Registro y Control de Estudio y Evaluación de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 8,
  ),
  9 => 
  array (
    'id' => 7,
    'nombre' => 'Planificador(a) de Educación de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 9,
  ),
  10 => 
  array (
    'id' => 4,
    'nombre' => 'Secretario(a) de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 10,
  ),
  11 => 
  array (
    'id' => 2,
    'nombre' => 'Coordinador(a) Misión Ribas',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 11,
  ),
  12 => 
  array (
    'id' => 8,
    'nombre' => 'Maestro(a) de Aula de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 12,
  ),
  13 => 
  array (
    'id' => 9,
    'nombre' => 'Profesor(a) de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 13,
  ),
  14 => 
  array (
    'id' => 28,
    'nombre' => 'Administrativo(a) de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 14,
  ),
  15 => 
  array (
    'id' => 35,
    'nombre' => 'Tutor CBIT de Plantel',
    'descripcion' => NULL,
    'estatus' => 'I',
    'ente_id' => 1,
    'consecutivo' => 15,
  ),
  16 => 
  array (
    'id' => 15,
    'nombre' => 'Coordinador de Distrito Escolar',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 2,
    'consecutivo' => 1,
  ),
  17 => 
  array (
    'id' => 6,
    'nombre' => 'Jefe de Zona Educativa',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 4,
    'consecutivo' => 1,
  ),
  18 => 
  array (
    'id' => 24,
    'nombre' => 'Jefe de Registro de Control de Estudio de la Zona Educativa',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 4,
    'consecutivo' => 2,
  ),
  19 => 
  array (
    'id' => 34,
    'nombre' => 'Administrativo de Registro y Control de Estudio y Evaluación',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 4,
    'consecutivo' => 3,
  ),
  20 => 
  array (
    'id' => 25,
    'nombre' => 'Jefe de Informática y Sistemas Regional',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 4,
    'consecutivo' => 4,
  ),
  21 => 
  array (
    'id' => 22,
    'nombre' => 'Coordinador Regional del PAE',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 4,
    'consecutivo' => 5,
  ),
  22 => 
  array (
    'id' => 23,
    'nombre' => 'Administrador Regional del PAE',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 4,
    'consecutivo' => 6,
  ),
  23 => 
  array (
    'id' => 33,
    'nombre' => 'Coordinador de Misión Ríbas Regional',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 4,
    'consecutivo' => 8,
  ),
  24 => 
  array (
    'id' => 11,
    'nombre' => 'Administrativo de Zona Educativa',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 4,
    'consecutivo' => 9,
  ),
  25 => 
  array (
    'id' => 36,
    'nombre' => 'Administrativo del PAE',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 4,
    'consecutivo' => NULL,
  ),
  26 => 
  array (
    'id' => 1,
    'nombre' => 'Jefe de Registro y Control de Estudio y Evaluación Nacional',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 5,
    'consecutivo' => 1,
  ),
  27 => 
  array (
    'id' => 10,
    'nombre' => 'Administrativo de Registro y Control de Estudio y Evaluación',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 5,
    'consecutivo' => 2,
  ),
  28 => 
  array (
    'id' => 30,
    'nombre' => 'Director de Informática y Sistemas',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 5,
    'consecutivo' => 3,
  ),
  29 => 
  array (
    'id' => 20,
    'nombre' => 'Funcionario Designado',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 5,
    'consecutivo' => 4,
  ),
  30 => 
  array (
    'id' => 26,
    'nombre' => 'Coordinador Nacional del PAE',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 5,
    'consecutivo' => 5,
  ),
  31 => 
  array (
    'id' => 32,
    'nombre' => 'Coordinador de Misión Ríbas Nacional',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 5,
    'consecutivo' => 7,
  ),
  32 => 
  array (
    'id' => 31,
    'nombre' => 'Coordinador de Atención Telefónica ',
    'descripcion' => NULL,
    'estatus' => 'A',
    'ente_id' => 5,
    'consecutivo' => 20,
  ),
)		; 

    	}
}

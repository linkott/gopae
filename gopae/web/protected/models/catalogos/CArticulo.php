<?php
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class CArticulo extends CCatalogo { 

    protected static $columns = 
        array (
  0 => 'id',
  1 => 'nombre',
  2 => 'unidad_medida_id',
  3 => 'tipo_articulo_id',
  4 => 'precio_regulado',
  5 => 'estatus',
  6 => 'franja_id',
);

    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData(){

        self::$data = 
        array (
  0 => 
  array (
    'id' => 2,
    'nombre' => 'Aceite',
    'unidad_medida_id' => 2,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '6.6',
    'estatus' => 'A',
    'franja_id' => 1,
  ),
  1 => 
  array (
    'id' => 81,
    'nombre' => 'Acelga',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '15',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  2 => 
  array (
    'id' => 80,
    'nombre' => 'Aji Dulce',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  3 => 
  array (
    'id' => 78,
    'nombre' => 'Ajo',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '72.2',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  4 => 
  array (
    'id' => 3,
    'nombre' => 'Ajoporro',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '30',
    'estatus' => 'A',
    'franja_id' => 4,
  ),
  5 => 
  array (
    'id' => 95,
    'nombre' => 'Apio',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  6 => 
  array (
    'id' => 77,
    'nombre' => 'Apio España (Celeri)',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '30',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  7 => 
  array (
    'id' => 83,
    'nombre' => 'Arbeja Amarilla',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  8 => 
  array (
    'id' => 82,
    'nombre' => 'Arbeja Verde',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '8',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  9 => 
  array (
    'id' => 96,
    'nombre' => 'Arroz',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  10 => 
  array (
    'id' => 4,
    'nombre' => 'Arroz Blanco',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '3.6',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  11 => 
  array (
    'id' => 97,
    'nombre' => 'Atún',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  12 => 
  array (
    'id' => 117,
    'nombre' => 'Atún al Natural Enlatado, Escurrido',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  13 => 
  array (
    'id' => 118,
    'nombre' => 'Atún en Aceite Enlatado, Escurrido',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  14 => 
  array (
    'id' => 76,
    'nombre' => 'Atún fresco',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  15 => 
  array (
    'id' => 5,
    'nombre' => 'Auyama',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '10',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  16 => 
  array (
    'id' => 6,
    'nombre' => 'Avena en Hojuelas',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '7',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  17 => 
  array (
    'id' => 7,
    'nombre' => 'Azúcar ',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '3.7',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  18 => 
  array (
    'id' => 98,
    'nombre' => 'Azúcar Blanca',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  19 => 
  array (
    'id' => 99,
    'nombre' => 'Batata',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  20 => 
  array (
    'id' => 87,
    'nombre' => 'Berenjena',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9.5',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  21 => 
  array (
    'id' => 100,
    'nombre' => 'Berenjena',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  22 => 
  array (
    'id' => 88,
    'nombre' => 'Brocoli',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '15',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  23 => 
  array (
    'id' => 75,
    'nombre' => 'Calabacín',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '15',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  24 => 
  array (
    'id' => 8,
    'nombre' => 'Cambur Pineo',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '8',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  25 => 
  array (
    'id' => 9,
    'nombre' => 'Cambur Topocho',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '8',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  26 => 
  array (
    'id' => 12,
    'nombre' => 'Caraotas Blancas',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '19',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  27 => 
  array (
    'id' => 10,
    'nombre' => 'Caraotas Negras',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '10',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  28 => 
  array (
    'id' => 11,
    'nombre' => 'Caraotas Rojas',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '19',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  29 => 
  array (
    'id' => 13,
    'nombre' => 'Casabe',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9.5',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  30 => 
  array (
    'id' => 14,
    'nombre' => 'Cazón',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  31 => 
  array (
    'id' => 15,
    'nombre' => 'Cebolla',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '22.5',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  32 => 
  array (
    'id' => 91,
    'nombre' => 'Cebollin',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  33 => 
  array (
    'id' => 85,
    'nombre' => 'Chayota',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '6',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  34 => 
  array (
    'id' => 79,
    'nombre' => 'Cilantro',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '20',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  35 => 
  array (
    'id' => 94,
    'nombre' => 'Coco',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '11',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  36 => 
  array (
    'id' => 89,
    'nombre' => 'Coliflor',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '20',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  37 => 
  array (
    'id' => 16,
    'nombre' => 'Crema de Arroz',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '7.9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  38 => 
  array (
    'id' => 86,
    'nombre' => 'Espinaca',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '8',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  39 => 
  array (
    'id' => 18,
    'nombre' => 'Falda',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  40 => 
  array (
    'id' => 101,
    'nombre' => 'Fideos (Pasta)',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  41 => 
  array (
    'id' => 20,
    'nombre' => 'Fororo',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '7.5',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  42 => 
  array (
    'id' => 102,
    'nombre' => 'Frijol',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  43 => 
  array (
    'id' => 74,
    'nombre' => 'Galleta Dulce Tipo Maria',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  44 => 
  array (
    'id' => 73,
    'nombre' => 'Galletas de Soda',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9.5',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  45 => 
  array (
    'id' => 103,
    'nombre' => 'Ganso',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  46 => 
  array (
    'id' => 21,
    'nombre' => 'Gelatina en Polvo',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '10',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  47 => 
  array (
    'id' => 121,
    'nombre' => 'Gelatina en Polvo (Con Azúcar y Sabor)',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '10',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  48 => 
  array (
    'id' => 90,
    'nombre' => 'Golfeado',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  49 => 
  array (
    'id' => 22,
    'nombre' => 'Guanabana',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '10.37',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  50 => 
  array (
    'id' => 23,
    'nombre' => 'Guayaba',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '10.37',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  51 => 
  array (
    'id' => 17,
    'nombre' => 'Harina de Arroz Enriquecida',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  52 => 
  array (
    'id' => 24,
    'nombre' => 'Harina de Maíz Amarillo Precocida Enriquecida',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '2.7',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  53 => 
  array (
    'id' => 25,
    'nombre' => 'Harina de Maíz Blanco Precocida Enriquecida',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '2.72',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  54 => 
  array (
    'id' => 19,
    'nombre' => 'Harina de Maíz Tostado',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  55 => 
  array (
    'id' => 26,
    'nombre' => 'Harina de Trigo',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '7',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  56 => 
  array (
    'id' => 123,
    'nombre' => 'Harina de Trigo Panadera Enriquecida',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '7',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  57 => 
  array (
    'id' => 124,
    'nombre' => 'Harina de Trigo, Variedad (HAD)',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '7',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  58 => 
  array (
    'id' => 125,
    'nombre' => 'Harina panadera de Trigo. variedad (DNS)',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '7',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  59 => 
  array (
    'id' => 27,
    'nombre' => 'Huevo de Gallina',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1.25',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  60 => 
  array (
    'id' => 28,
    'nombre' => 'Jamón de Cerdo Cocido Estándar',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  61 => 
  array (
    'id' => 127,
    'nombre' => 'Jamón de Cerdo Cocido Superior',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  62 => 
  array (
    'id' => 128,
    'nombre' => 'Jamón de Espalda',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '7',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  63 => 
  array (
    'id' => 104,
    'nombre' => 'Jamón de Pierna',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  64 => 
  array (
    'id' => 72,
    'nombre' => 'Lactovisoy',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  65 => 
  array (
    'id' => 71,
    'nombre' => 'Lagarto',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '18',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  66 => 
  array (
    'id' => 29,
    'nombre' => 'Leche en Polvo Completa Enriquecida',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '16.7',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  67 => 
  array (
    'id' => 30,
    'nombre' => 'Lechosa',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '8',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  68 => 
  array (
    'id' => 31,
    'nombre' => 'Lechuga',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '30',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  69 => 
  array (
    'id' => 84,
    'nombre' => 'Lentejas',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '16',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  70 => 
  array (
    'id' => 32,
    'nombre' => 'Limón',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '12',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  71 => 
  array (
    'id' => 33,
    'nombre' => 'Maicena',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '12.5',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  72 => 
  array (
    'id' => 34,
    'nombre' => 'Mandarina',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '10',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  73 => 
  array (
    'id' => 69,
    'nombre' => 'Mango de Bocado',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '25',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  74 => 
  array (
    'id' => 70,
    'nombre' => 'Mantequilla',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  75 => 
  array (
    'id' => 35,
    'nombre' => 'Margarina',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  76 => 
  array (
    'id' => 68,
    'nombre' => 'Mayonesa Comercial',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '19',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  77 => 
  array (
    'id' => 92,
    'nombre' => 'Maíz Tierno (Jojoto)',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '3',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  78 => 
  array (
    'id' => 105,
    'nombre' => 'Maíz Tierno Enlatado o Congelado',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  79 => 
  array (
    'id' => 36,
    'nombre' => 'Melón',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '12.7',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  80 => 
  array (
    'id' => 67,
    'nombre' => 'Muchacho Redondo',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  81 => 
  array (
    'id' => 37,
    'nombre' => 'Naranja',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  82 => 
  array (
    'id' => 132,
    'nombre' => 'Naranja Valencia',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '2',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  83 => 
  array (
    'id' => 1,
    'nombre' => 'Naranja x Unidad',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => 4,
  ),
  84 => 
  array (
    'id' => 107,
    'nombre' => 'Nutricereal',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  85 => 
  array (
    'id' => 106,
    'nombre' => 'Nutrichicha',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  86 => 
  array (
    'id' => 39,
    'nombre' => 'Ocumo',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '20',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  87 => 
  array (
    'id' => 40,
    'nombre' => 'Pan Canilla',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  88 => 
  array (
    'id' => 41,
    'nombre' => 'Pan Tipo Sandwich',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '12',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  89 => 
  array (
    'id' => 42,
    'nombre' => 'Papa',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '11.28',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  90 => 
  array (
    'id' => 66,
    'nombre' => 'Papelon',
    'unidad_medida_id' => 3,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '11',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  91 => 
  array (
    'id' => 65,
    'nombre' => 'Parchita',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '15',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  92 => 
  array (
    'id' => 43,
    'nombre' => 'Pasta Corta',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '3.26',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  93 => 
  array (
    'id' => 108,
    'nombre' => 'Pasta Enriquecida',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  94 => 
  array (
    'id' => 44,
    'nombre' => 'Patilla',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '6',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  95 => 
  array (
    'id' => 53,
    'nombre' => 'Pechuga de Pollo, con Piel',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  96 => 
  array (
    'id' => 109,
    'nombre' => 'Pepino',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  97 => 
  array (
    'id' => 45,
    'nombre' => 'Perejil',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '30',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  98 => 
  array (
    'id' => 46,
    'nombre' => 'Pimenton Rojo',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '25.2',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  99 => 
  array (
    'id' => 47,
    'nombre' => 'Pimenton Verde',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '25.2',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  100 => 
  array (
    'id' => 48,
    'nombre' => 'Piña',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '15',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  101 => 
  array (
    'id' => 49,
    'nombre' => 'Plátano Maduro',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '7',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  102 => 
  array (
    'id' => 50,
    'nombre' => 'Plátano Verde',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '7',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  103 => 
  array (
    'id' => 51,
    'nombre' => 'Pollo',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '13',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  104 => 
  array (
    'id' => 52,
    'nombre' => 'Pollo Muslo',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  105 => 
  array (
    'id' => 54,
    'nombre' => 'Pulpa Negra',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '28',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  106 => 
  array (
    'id' => 110,
    'nombre' => 'Pulpa Negra Molida',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  107 => 
  array (
    'id' => 111,
    'nombre' => 'Queso Blanco Duro',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '25',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  108 => 
  array (
    'id' => 56,
    'nombre' => 'Queso Blanco Duro Pasteurizado',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '25',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  109 => 
  array (
    'id' => 135,
    'nombre' => 'Queso Blanco Duro de Leche Completa',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '25',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  110 => 
  array (
    'id' => 55,
    'nombre' => 'Queso Blanco Suave',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '25',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  111 => 
  array (
    'id' => 57,
    'nombre' => 'Remolacha',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '10',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  112 => 
  array (
    'id' => 64,
    'nombre' => 'Repollo Blanco',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '8',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  113 => 
  array (
    'id' => 112,
    'nombre' => 'Repollo Morado',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  114 => 
  array (
    'id' => 63,
    'nombre' => 'Sal',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '5',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  115 => 
  array (
    'id' => 113,
    'nombre' => 'Sardina',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  116 => 
  array (
    'id' => 137,
    'nombre' => 'Sardina Enlatada',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  117 => 
  array (
    'id' => 114,
    'nombre' => 'Tamarindo',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  118 => 
  array (
    'id' => 93,
    'nombre' => 'Tomate Salsa (Tipo Ketchup)',
    'unidad_medida_id' => 2,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '8.5',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  119 => 
  array (
    'id' => 58,
    'nombre' => 'Tomate de Perita',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '15.9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  120 => 
  array (
    'id' => 59,
    'nombre' => 'Vainitas',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '16.67',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  121 => 
  array (
    'id' => 115,
    'nombre' => 'Vinagre',
    'unidad_medida_id' => 2,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '1',
    'estatus' => 'A',
    'franja_id' => NULL,
  ),
  122 => 
  array (
    'id' => 61,
    'nombre' => 'Yoghurt Dulce de Leche Completa',
    'unidad_medida_id' => 2,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '12',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  123 => 
  array (
    'id' => 62,
    'nombre' => 'Yuca',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '4.75',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  124 => 
  array (
    'id' => 60,
    'nombre' => 'Zanahoria',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '8.1',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
  125 => 
  array (
    'id' => 38,
    'nombre' => 'Ñame',
    'unidad_medida_id' => 1,
    'tipo_articulo_id' => 1,
    'precio_regulado' => '8.9',
    'estatus' => 'A',
    'franja_id' => 0,
  ),
)		; 

    	}
}

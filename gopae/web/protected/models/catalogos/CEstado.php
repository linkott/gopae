<?php

/**
 * Catalogo de Estados
 *
 * @author Jose Gabriel Gonzalez
 */
class CEstado extends CCatalogo {
    
    protected static $columns = array('id', 'co_edo_asap', 'nombre', 'capital', 'region_id', 'co_stat_data');
    
    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData() {

        self::$data = array(
            array(
                'id' => 35,
                'co_edo_asap' => '02',
                'nombre' => 'AMAZONAS',
                'capital' => 'PUERTO AYACUCHO',
                'region_id' => '2',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 18,
                'co_edo_asap' => '03',
                'nombre' => 'ANZOATEGUI',
                'capital' => 'BARCELONA',
                'region_id' => '6',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 36,
                'co_edo_asap' => '04',
                'nombre' => 'APURE',
                'capital' => 'SAN FERNANDO DE APURE',
                'region_id' => '2',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 23,
                'co_edo_asap' => '05',
                'nombre' => 'ARAGUA',
                'capital' => 'MARACAY',
                'region_id' => '2',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 37,
                'co_edo_asap' => '06',
                'nombre' => 'BARINAS',
                'capital' => 'BARINAS',
                'region_id' => '5',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 26,
                'co_edo_asap' => '07',
                'nombre' => 'BOLIVAR',
                'capital' => 'CIUDAD BOLIVAR',
                'region_id' => '6',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 27,
                'co_edo_asap' => '08',
                'nombre' => 'CARABOBO',
                'capital' => 'VALENCIA',
                'region_id' => '2',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 38,
                'co_edo_asap' => '09',
                'nombre' => 'COJEDES',
                'capital' => 'SAN CARLOS',
                'region_id' => '3',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 39,
                'co_edo_asap' => '10',
                'nombre' => 'DELTA AMACURO',
                'capital' => 'TUCUPITA',
                'region_id' => '6',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 45,
                'co_edo_asap' => '25',
                'nombre' => 'DEPENDENCIAS FEDERALES',
                'capital' => '',
                'region_id' => '1',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 21,
                'co_edo_asap' => '01',
                'nombre' => 'DISTRITO CAPITAL',
                'capital' => 'CARACAS',
                'region_id' => '1',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 40,
                'co_edo_asap' => '11',
                'nombre' => 'FALCON',
                'capital' => 'SANTA ANA DE CORO',
                'region_id' => '4',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 41,
                'co_edo_asap' => '12',
                'nombre' => 'GUARICO',
                'capital' => 'SAN JUAN DE LOS MORROS',
                'region_id' => '2',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 25,
                'co_edo_asap' => '13',
                'nombre' => 'LARA',
                'capital' => 'BARQUISIMETO',
                'region_id' => '3',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 30,
                'co_edo_asap' => '14',
                'nombre' => 'MERIDA',
                'capital' => 'MERIDA',
                'region_id' => '5',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 28,
                'co_edo_asap' => '15',
                'nombre' => 'MIRANDA',
                'capital' => 'LOS TEQUES',
                'region_id' => '1',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 24,
                'co_edo_asap' => '16',
                'nombre' => 'MONAGAS',
                'capital' => 'MATURIN',
                'region_id' => '6',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 16,
                'co_edo_asap' => '17',
                'nombre' => 'NUEVA ESPARTA',
                'capital' => 'LA ASUNCION',
                'region_id' => '6',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 34,
                'co_edo_asap' => '18',
                'nombre' => 'PORTUGUESA',
                'capital' => 'GUANARE',
                'region_id' => '3',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 42,
                'co_edo_asap' => '19',
                'nombre' => 'SUCRE',
                'capital' => 'CUMANA',
                'region_id' => '6',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 22,
                'co_edo_asap' => '20',
                'nombre' => 'TACHIRA',
                'capital' => 'SAN CRISTOBAL',
                'region_id' => '5',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 32,
                'co_edo_asap' => '21',
                'nombre' => 'TRUJILLO',
                'capital' => 'TRUJILLO',
                'region_id' => '4',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 44,
                'co_edo_asap' => '24',
                'nombre' => 'VARGAS',
                'capital' => 'LA GUAIRA',
                'region_id' => '1',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 43,
                'co_edo_asap' => '22',
                'nombre' => 'YARACUY',
                'capital' => 'SAN FELIPE',
                'region_id' => '3',
                'co_stat_data' => 'A',
            ),
            array(
                'id' => 20,
                'co_edo_asap' => '23',
                'nombre' => 'ZULIA',
                'capital' => 'MARACAIBO',
                'region_id' => '4',
                'co_stat_data' => 'A',
            ),
        );

    }
    
}

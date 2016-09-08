<?php

/**
 * Catalogo de Municipios
 *
 * @author José Gabriel González
 */
class CMunicipio extends CCatalogo {

    protected static $columns = array('id', 'co_munc_asap', 'nombre', 'capital', 'estado_id', 'co_stat_data', 'fe_carga', 'in_reg');

    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData() {

        self::$data = array(
            0 =>
            array(
                'id' => 55,
                'co_munc_asap' => '01',
                'nombre' => 'ANTOLIN DEL CAMPO',
                'capital' => 'LA PLAZA DE PARAGUACHI',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            1 =>
            array(
                'id' => 56,
                'co_munc_asap' => '02',
                'nombre' => 'ARISMENDI',
                'capital' => 'LA ASUNCION',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            2 =>
            array(
                'id' => 57,
                'co_munc_asap' => '03',
                'nombre' => 'DIAZ',
                'capital' => 'SAN JUAN BAUTISTA',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            3 =>
            array(
                'id' => 58,
                'co_munc_asap' => '04',
                'nombre' => 'GARCIA',
                'capital' => 'EL VALLE DEL ESPIRITU SANTO',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            4 =>
            array(
                'id' => 59,
                'co_munc_asap' => '05',
                'nombre' => 'GOMEZ',
                'capital' => 'SANTA ANA',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            5 =>
            array(
                'id' => 60,
                'co_munc_asap' => '06',
                'nombre' => 'MANEIRO',
                'capital' => 'PAMPATAR',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            6 =>
            array(
                'id' => 61,
                'co_munc_asap' => '07',
                'nombre' => 'MARCANO',
                'capital' => 'JUAN GRIEGO',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            7 =>
            array(
                'id' => 62,
                'co_munc_asap' => '08',
                'nombre' => 'MARIÑO',
                'capital' => 'PORLAMAR',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            8 =>
            array(
                'id' => 63,
                'co_munc_asap' => '09',
                'nombre' => 'PENINSULA DE MACANAO',
                'capital' => 'BOCA DEL RIO',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            9 =>
            array(
                'id' => 64,
                'co_munc_asap' => '10',
                'nombre' => 'TUBORES',
                'capital' => 'PUNTA DE PIEDRAS',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            10 =>
            array(
                'id' => 65,
                'co_munc_asap' => '11',
                'nombre' => 'VILLALBA',
                'capital' => 'SAN PEDRO DE COCHE',
                'estado_id' => 16,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-01-26',
                'in_reg' => 'OR'  
            ),
            11 =>
            array(
                'id' => 87,
                'co_munc_asap' => '01',
                'nombre' => 'ANACO',
                'capital' => 'ANACO',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            12 =>
            array(
                'id' => 88,
                'co_munc_asap' => '02',
                'nombre' => 'ARAGUA',
                'capital' => 'ARAGUA DE BARCELONA',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            13 =>
            array(
                'id' => 106,
                'co_munc_asap' => '21',
                'nombre' => 'DIEGO BAUTISTA URBANEJA',
                'capital' => 'LECHERIAS',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            14 =>
            array(
                'id' => 89,
                'co_munc_asap' => '03',
                'nombre' => 'FERNANDO DE PEÑALVER',
                'capital' => 'PUERTO PIRITU',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            15 =>
            array(
                'id' => 91,
                'co_munc_asap' => '05',
                'nombre' => 'FRANCISCO DE MIRANDA',
                'capital' => 'PARIAGUAN',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            16 =>
            array(
                'id' => 90,
                'co_munc_asap' => '04',
                'nombre' => 'FRANCISCO DEL CARMEN CARVAJAL',
                'capital' => 'VALLE DE GUANAPE',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            17 =>
            array(
                'id' => 107,
                'co_munc_asap' => '06',
                'nombre' => 'GUANTA',
                'capital' => 'GUANTA',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            18 =>
            array(
                'id' => 92,
                'co_munc_asap' => '07',
                'nombre' => 'INDEPENDENCIA',
                'capital' => 'SOLEDAD',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            19 =>
            array(
                'id' => 95,
                'co_munc_asap' => '10',
                'nombre' => 'JOSE GREGORIO MONAGAS',
                'capital' => 'MAPIRE',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            20 =>
            array(
                'id' => 93,
                'co_munc_asap' => '08',
                'nombre' => 'JUAN ANTONIO SOTILLO',
                'capital' => 'PUERTO LA CRUZ',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR',
                'fe_modif' => '2013-09-04',
                'co_stat_old' => 'M',
                'fe_ini' => NULL,
            ),
            21 =>
            array(
                'id' => 94,
                'co_munc_asap' => '09',
                'nombre' => 'JUAN MANUEL CAJIGAL',
                'capital' => 'ONOTO',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            22 =>
            array(
                'id' => 96,
                'co_munc_asap' => '11',
                'nombre' => 'LIBERTAD',
                'capital' => 'SAN MATEO',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            23 =>
            array(
                'id' => 97,
                'co_munc_asap' => '12',
                'nombre' => 'MANUEL EZEQUIEL BRUZUAL',
                'capital' => 'CLARINES',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            24 =>
            array(
                'id' => 98,
                'co_munc_asap' => '13',
                'nombre' => 'PEDRO MARIA FREITES',
                'capital' => 'CANTAURA',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            25 =>
            array(
                'id' => 99,
                'co_munc_asap' => '14',
                'nombre' => 'PIRITU',
                'capital' => 'PIRITU',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            26 =>
            array(
                'id' => 100,
                'co_munc_asap' => '15',
                'nombre' => 'SAN JOSE DE GUANIPA',
                'capital' => 'EL TIGRITO',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            27 =>
            array(
                'id' => 105,
                'co_munc_asap' => '16',
                'nombre' => 'SAN JUAN DE CAPISTRANO',
                'capital' => 'BOCA DE UCHIRE',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            28 =>
            array(
                'id' => 103,
                'co_munc_asap' => '17',
                'nombre' => 'SANTA ANA',
                'capital' => 'SANTA ANA',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            29 =>
            array(
                'id' => 101,
                'co_munc_asap' => '18',
                'nombre' => 'SIMON BOLIVAR',
                'capital' => 'BARCELONA',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            30 =>
            array(
                'id' => 102,
                'co_munc_asap' => '19',
                'nombre' => 'SIMON RODRIGUEZ',
                'capital' => 'EL TIGRE',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            31 =>
            array(
                'id' => 104,
                'co_munc_asap' => '20',
                'nombre' => 'SIR ARTUR MC GREGOR',
                'capital' => 'EL CHAPARRO',
                'estado_id' => 18,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OR'  
            ),
            32 =>
            array(
                'id' => 120,
                'co_munc_asap' => '01',
                'nombre' => 'ALMIRANTE PADILLA',
                'capital' => 'EL TORO',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            33 =>
            array(
                'id' => 121,
                'co_munc_asap' => '02',
                'nombre' => 'BARALT',
                'capital' => 'SAN TIMOTEO',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            34 =>
            array(
                'id' => 122,
                'co_munc_asap' => '03',
                'nombre' => 'CABIMAS',
                'capital' => 'CABIMAS',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            35 =>
            array(
                'id' => 108,
                'co_munc_asap' => '04',
                'nombre' => 'CATATUMBO',
                'capital' => 'ENCONTRADOS',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            36 =>
            array(
                'id' => 109,
                'co_munc_asap' => '05',
                'nombre' => 'COLON',
                'capital' => 'SAN CARLOS DEL ZULIA',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            37 =>
            array(
                'id' => 123,
                'co_munc_asap' => '06',
                'nombre' => 'FRANCISCO JAVIER PULGAR',
                'capital' => 'PUEBLO NUEVO EL CHIVO',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            38 =>
            array(
                'id' => 124,
                'co_munc_asap' => '07',
                'nombre' => 'JESUS ENRIQUE LOSSADA',
                'capital' => 'LA CONCEPCION',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            39 =>
            array(
                'id' => 110,
                'co_munc_asap' => '08',
                'nombre' => 'JESUS MARIA SEMPRUN',
                'capital' => 'CASIGUA EL CUBO',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            40 =>
            array(
                'id' => 125,
                'co_munc_asap' => '09',
                'nombre' => 'LA CAÑADA DE URDANETA',
                'capital' => 'CONCEPCION',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            41 =>
            array(
                'id' => 111,
                'co_munc_asap' => '10',
                'nombre' => 'LAGUNILLAS',
                'capital' => 'CIUDAD OJEDA',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            42 =>
            array(
                'id' => 112,
                'co_munc_asap' => '11',
                'nombre' => 'MACHIQUES DE PERIJA',
                'capital' => 'MACHIQUES',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            43 =>
            array(
                'id' => 113,
                'co_munc_asap' => '12',
                'nombre' => 'MARA',
                'capital' => 'SAN RAFAEL DEL MOJAN',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            44 =>
            array(
                'id' => 126,
                'co_munc_asap' => '13',
                'nombre' => 'MARACAIBO',
                'capital' => 'MARACAIBO',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            45 =>
            array(
                'id' => 114,
                'co_munc_asap' => '14',
                'nombre' => 'MIRANDA',
                'capital' => 'LOS PUERTOS DE ALTAGRACIA',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            46 =>
            array(
                'id' => 127,
                'co_munc_asap' => '15',
                'nombre' => 'PAEZ',
                'capital' => 'SINAMAICA',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            47 =>
            array(
                'id' => 115,
                'co_munc_asap' => '16',
                'nombre' => 'ROSARIO DE PERIJA',
                'capital' => 'LA VILLA DEL ROSARIO',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            48 =>
            array(
                'id' => 116,
                'co_munc_asap' => '17',
                'nombre' => 'SAN FRANCISCO',
                'capital' => 'SAN FRANCISCO',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            49 =>
            array(
                'id' => 117,
                'co_munc_asap' => '18',
                'nombre' => 'SANTA RITA',
                'capital' => 'SANTA RITA',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            50 =>
            array(
                'id' => 118,
                'co_munc_asap' => '19',
                'nombre' => 'SIMON BOLIVAR',
                'capital' => 'TIA JUAN',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            51 =>
            array(
                'id' => 119,
                'co_munc_asap' => '20',
                'nombre' => 'SUCRE',
                'capital' => 'BOBURES',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            52 =>
            array(
                'id' => 128,
                'co_munc_asap' => '21',
                'nombre' => 'VALMORE RODRIGUEZ',
                'capital' => 'BACHAQUERO',
                'estado_id' => 20,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-05',
                'in_reg' => 'OC'  
            ),
            53 =>
            array(
                'id' => 129,
                'co_munc_asap' => '01',
                'nombre' => 'LIBERTADOR',
                'capital' => 'CARACAS',
                'estado_id' => 21,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-12',
                'in_reg' => 'CA'  
            ),
            54 =>
            array(
                'id' => 130,
                'co_munc_asap' => '01',
                'nombre' => 'ANDRES BELLO',
                'capital' => 'CORDERO',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            55 =>
            array(
                'id' => 154,
                'co_munc_asap' => '02',
                'nombre' => 'ANTONIO ROMULO COSTA',
                'capital' => 'LAS MESAS',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            56 =>
            array(
                'id' => 131,
                'co_munc_asap' => '03',
                'nombre' => 'AYACUCHO',
                'capital' => 'COLON',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            57 =>
            array(
                'id' => 132,
                'co_munc_asap' => '04',
                'nombre' => 'BOLIVAR',
                'capital' => 'SAN ANTONIO DEL TACHIRA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            58 =>
            array(
                'id' => 133,
                'co_munc_asap' => '05',
                'nombre' => 'CARDENAS',
                'capital' => 'TARIBA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            59 =>
            array(
                'id' => 134,
                'co_munc_asap' => '06',
                'nombre' => 'CORDOBA',
                'capital' => 'SANTA ANA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            60 =>
            array(
                'id' => 135,
                'co_munc_asap' => '07',
                'nombre' => 'FERNANDEZ FEO',
                'capital' => 'SAN RAFAEL DEL PIÑAL',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            61 =>
            array(
                'id' => 136,
                'co_munc_asap' => '08',
                'nombre' => 'FRANCISCO DE MIRANDA',
                'capital' => 'SAN JOSE DE BOLIVAR',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            62 =>
            array(
                'id' => 137,
                'co_munc_asap' => '09',
                'nombre' => 'GARCIA DE HEVIA',
                'capital' => 'LA FRIA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            63 =>
            array(
                'id' => 138,
                'co_munc_asap' => '10',
                'nombre' => 'GUASIMOS',
                'capital' => 'PALMIRA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            64 =>
            array(
                'id' => 139,
                'co_munc_asap' => '11',
                'nombre' => 'INDEPENDENCIA',
                'capital' => 'CAPACHO NUEVO',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            65 =>
            array(
                'id' => 140,
                'co_munc_asap' => '12',
                'nombre' => 'JAUREGUI',
                'capital' => 'LA GRITA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            66 =>
            array(
                'id' => 141,
                'co_munc_asap' => '13',
                'nombre' => 'JOSE MARIA VARGAS',
                'capital' => 'EL COBRE',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            67 =>
            array(
                'id' => 142,
                'co_munc_asap' => '14',
                'nombre' => 'JUNIN',
                'capital' => 'RUBIO',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            68 =>
            array(
                'id' => 143,
                'co_munc_asap' => '15',
                'nombre' => 'LIBERTAD',
                'capital' => 'CAPACHO VIEJO',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            69 =>
            array(
                'id' => 144,
                'co_munc_asap' => '16',
                'nombre' => 'LIBERTADOR',
                'capital' => 'ABEJALES',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            70 =>
            array(
                'id' => 145,
                'co_munc_asap' => '17',
                'nombre' => 'LOBATERA',
                'capital' => 'LOBATERA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            71 =>
            array(
                'id' => 146,
                'co_munc_asap' => '18',
                'nombre' => 'MICHELENA',
                'capital' => 'MICHELENA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            72 =>
            array(
                'id' => 147,
                'co_munc_asap' => '19',
                'nombre' => 'PANAMERICANO',
                'capital' => 'COLONCITO',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            73 =>
            array(
                'id' => 148,
                'co_munc_asap' => '20',
                'nombre' => 'PEDRO MARIA UREÑA',
                'capital' => 'UREÑA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            74 =>
            array(
                'id' => 155,
                'co_munc_asap' => '21',
                'nombre' => 'RAFAEL URDANETA',
                'capital' => 'DELICIAS',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            75 =>
            array(
                'id' => 149,
                'co_munc_asap' => '22',
                'nombre' => 'SAMUEL DARIO MALDONADO',
                'capital' => 'LA TENDIDA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            76 =>
            array(
                'id' => 150,
                'co_munc_asap' => '23',
                'nombre' => 'SAN CRISTOBAL',
                'capital' => 'SAN CRISTOBAL',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            77 =>
            array(
                'id' => 157,
                'co_munc_asap' => '29',
                'nombre' => 'SAN JUDAS TADEO',
                'capital' => 'UMUQUENA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            78 =>
            array(
                'id' => 151,
                'co_munc_asap' => '24',
                'nombre' => 'SEBORUCO',
                'capital' => 'SEBORUCO',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            79 =>
            array(
                'id' => 158,
                'co_munc_asap' => '25',
                'nombre' => 'SIMON RODRIGUEZ',
                'capital' => 'SAN SIMON',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            80 =>
            array(
                'id' => 152,
                'co_munc_asap' => '26',
                'nombre' => 'SUCRE',
                'capital' => 'QUENIQUEA',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            81 =>
            array(
                'id' => 156,
                'co_munc_asap' => '27',
                'nombre' => 'TORBES',
                'capital' => 'SAN JOSECITO',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            82 =>
            array(
                'id' => 153,
                'co_munc_asap' => '28',
                'nombre' => 'URIBANTE',
                'capital' => 'PREGONERO',
                'estado_id' => 22,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-17',
                'in_reg' => 'LA'  
            ),
            83 =>
            array(
                'id' => 159,
                'co_munc_asap' => '01',
                'nombre' => 'BOLIVAR',
                'capital' => 'SAN MATEO',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            84 =>
            array(
                'id' => 160,
                'co_munc_asap' => '02',
                'nombre' => 'CAMATAGUA',
                'capital' => 'CAMATAGUA',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            85 =>
            array(
                'id' => 175,
                'co_munc_asap' => '17',
                'nombre' => 'FRANCISCO LINARES ALCANTARA',
                'capital' => 'SANTA RITA',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            86 =>
            array(
                'id' => 161,
                'co_munc_asap' => '03',
                'nombre' => 'GIRARDOT',
                'capital' => 'MARACAY',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            87 =>
            array(
                'id' => 162,
                'co_munc_asap' => '04',
                'nombre' => 'JOSE ANGEL LAMAS',
                'capital' => 'SANTA CRUZ',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            88 =>
            array(
                'id' => 163,
                'co_munc_asap' => '05',
                'nombre' => 'JOSE FELIX RIBAS',
                'capital' => 'LA VICTORIA',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            89 =>
            array(
                'id' => 164,
                'co_munc_asap' => '06',
                'nombre' => 'JOSE RAFAEL REVENGA',
                'capital' => 'EL CONSEJO',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            90 =>
            array(
                'id' => 165,
                'co_munc_asap' => '07',
                'nombre' => 'LIBERTADOR',
                'capital' => 'PALO NEGRO',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            91 =>
            array(
                'id' => 166,
                'co_munc_asap' => '08',
                'nombre' => 'MARIO BRICEÑO IRAGORRY',
                'capital' => 'EL LIMON',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            92 =>
            array(
                'id' => 416,
                'co_munc_asap' => '18',
                'nombre' => 'OCUMARE DE LA COSTA DE ORO',
                'capital' => 'OCUMARE DE LA COSTA',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2006-02-21',
                'in_reg' => 'CE'  
            ),
            93 =>
            array(
                'id' => 167,
                'co_munc_asap' => '09',
                'nombre' => 'SAN CASIMIRO',
                'capital' => 'SAN CASIMIRO',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            94 =>
            array(
                'id' => 168,
                'co_munc_asap' => '10',
                'nombre' => 'SAN SEBASTIAN',
                'capital' => 'SAN SEBASTIAN',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            95 =>
            array(
                'id' => 169,
                'co_munc_asap' => '11',
                'nombre' => 'SANTIAGO MARIÑO',
                'capital' => 'TURMERO',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            96 =>
            array(
                'id' => 170,
                'co_munc_asap' => '12',
                'nombre' => 'SANTOS MICHELENA',
                'capital' => 'LAS TEJERIAS',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            97 =>
            array(
                'id' => 171,
                'co_munc_asap' => '13',
                'nombre' => 'SUCRE',
                'capital' => 'CAGUA',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            98 =>
            array(
                'id' => 172,
                'co_munc_asap' => '14',
                'nombre' => 'TOVAR',
                'capital' => 'LA COLONIA TOVAR',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            99 =>
            array(
                'id' => 173,
                'co_munc_asap' => '15',
                'nombre' => 'URDANETA',
                'capital' => 'BARBACOAS',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            100 =>
            array(
                'id' => 174,
                'co_munc_asap' => '16',
                'nombre' => 'ZAMORA',
                'capital' => 'VILLA DE CURA',
                'estado_id' => 23,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'CE'  
            ),
            101 =>
            array(
                'id' => 176,
                'co_munc_asap' => '01',
                'nombre' => 'ACOSTA',
                'capital' => 'SAN ANTONIO',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            102 =>
            array(
                'id' => 177,
                'co_munc_asap' => '02',
                'nombre' => 'AGUASAY',
                'capital' => 'AGUASAY',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            103 =>
            array(
                'id' => 178,
                'co_munc_asap' => '03',
                'nombre' => 'BOLIVAR',
                'capital' => 'CARIPITO',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            104 =>
            array(
                'id' => 179,
                'co_munc_asap' => '04',
                'nombre' => 'CARIPE',
                'capital' => 'CARIPE',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            105 =>
            array(
                'id' => 180,
                'co_munc_asap' => '05',
                'nombre' => 'CEDEÑO',
                'capital' => 'CAICARA',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            106 =>
            array(
                'id' => 181,
                'co_munc_asap' => '06',
                'nombre' => 'EZEQUIEL ZAMORA',
                'capital' => 'PUNTA DE MATA',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            107 =>
            array(
                'id' => 182,
                'co_munc_asap' => '07',
                'nombre' => 'LIBERTADOR',
                'capital' => 'TEMBLADOR',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            108 =>
            array(
                'id' => 183,
                'co_munc_asap' => '08',
                'nombre' => 'MATURIN',
                'capital' => 'MATURIN',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            109 =>
            array(
                'id' => 184,
                'co_munc_asap' => '09',
                'nombre' => 'PIAR',
                'capital' => 'ARAGUA',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            110 =>
            array(
                'id' => 185,
                'co_munc_asap' => '10',
                'nombre' => 'PUNCERES',
                'capital' => 'QUIRIQUIRE',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            111 =>
            array(
                'id' => 186,
                'co_munc_asap' => '11',
                'nombre' => 'SANTA BARBARA',
                'capital' => 'SANTA BARBARA',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            112 =>
            array(
                'id' => 187,
                'co_munc_asap' => '12',
                'nombre' => 'SOTILLO',
                'capital' => 'BARRANCAS',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            113 =>
            array(
                'id' => 188,
                'co_munc_asap' => '13',
                'nombre' => 'URACOA',
                'capital' => 'URACOA',
                'estado_id' => 24,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-02-19',
                'in_reg' => 'OR'  
            ),
            114 =>
            array(
                'id' => 189,
                'co_munc_asap' => '01',
                'nombre' => 'ANDRES ELOY BLANCO',
                'capital' => 'SANARE',
                'estado_id' => 25,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-08',
                'in_reg' => 'CO'  
            ),
            115 =>
            array(
                'id' => 190,
                'co_munc_asap' => '02',
                'nombre' => 'CRESPO',
                'capital' => 'DUACA',
                'estado_id' => 25,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-08',
                'in_reg' => 'CO'  
            ),
            116 =>
            array(
                'id' => 191,
                'co_munc_asap' => '03',
                'nombre' => 'IRIBARREN',
                'capital' => 'BARQUISIMETO',
                'estado_id' => 25,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-08',
                'in_reg' => 'CO'  
            ),
            117 =>
            array(
                'id' => 192,
                'co_munc_asap' => '04',
                'nombre' => 'JIMENEZ',
                'capital' => 'QUIBOR',
                'estado_id' => 25,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-08',
                'in_reg' => 'CO'  
            ),
            118 =>
            array(
                'id' => 193,
                'co_munc_asap' => '05',
                'nombre' => 'MORAN',
                'capital' => 'EL TOCUYO',
                'estado_id' => 25,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-08',
                'in_reg' => 'CO'  
            ),
            119 =>
            array(
                'id' => 194,
                'co_munc_asap' => '06',
                'nombre' => 'PALAVECINO',
                'capital' => 'CABUDARE',
                'estado_id' => 25,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-08',
                'in_reg' => 'CO'  
            ),
            120 =>
            array(
                'id' => 195,
                'co_munc_asap' => '07',
                'nombre' => 'SIMON PLANAS',
                'capital' => 'SARARE',
                'estado_id' => 25,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-08',
                'in_reg' => 'CO'  
            ),
            121 =>
            array(
                'id' => 196,
                'co_munc_asap' => '08',
                'nombre' => 'TORRES',
                'capital' => 'CARORA',
                'estado_id' => 25,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-08',
                'in_reg' => 'CO'  
            ),
            122 =>
            array(
                'id' => 197,
                'co_munc_asap' => '09',
                'nombre' => 'URDANETA',
                'capital' => 'SIQUISIQUE',
                'estado_id' => 25,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-08',
                'in_reg' => 'CO'  
            ),
            123 =>
            array(
                'id' => 198,
                'co_munc_asap' => '01',
                'nombre' => 'CARONI',
                'capital' => 'CIUDAD GUAYANA',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'OR'  
            ),
            124 =>
            array(
                'id' => 206,
                'co_munc_asap' => '02',
                'nombre' => 'CEDEÑO',
                'capital' => 'CAICARA DEL ORINOCO',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'CE'  
            ),
            125 =>
            array(
                'id' => 199,
                'co_munc_asap' => '03',
                'nombre' => 'EL CALLAO',
                'capital' => 'EL CALLAO',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'OR'  
            ),
            126 =>
            array(
                'id' => 200,
                'co_munc_asap' => '04',
                'nombre' => 'GRAN SABANA',
                'capital' => 'SANTA ELENA DE UAIREN',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'OR'  
            ),
            127 =>
            array(
                'id' => 201,
                'co_munc_asap' => '05',
                'nombre' => 'HERES',
                'capital' => 'CIUDAD BOLIVAR',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'OR'  
            ),
            128 =>
            array(
                'id' => 205,
                'co_munc_asap' => '11',
                'nombre' => 'PADRE PEDRO CHIEN',
                'capital' => 'EL PALMAR',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'OR'  
            ),
            129 =>
            array(
                'id' => 202,
                'co_munc_asap' => '06',
                'nombre' => 'PIAR',
                'capital' => 'UPATA',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'OR'  
            ),
            130 =>
            array(
                'id' => 203,
                'co_munc_asap' => '07',
                'nombre' => 'RAUL LEONI',
                'capital' => 'CIUDAD PIAR',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'OR'  
            ),
            131 =>
            array(
                'id' => 207,
                'co_munc_asap' => '08',
                'nombre' => 'ROSCIO',
                'capital' => 'GUASIPATI',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'OR'  
            ),
            132 =>
            array(
                'id' => 204,
                'co_munc_asap' => '09',
                'nombre' => 'SIFONTES',
                'capital' => 'TUMEREMO',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'OR'  
            ),
            133 =>
            array(
                'id' => 208,
                'co_munc_asap' => '10',
                'nombre' => 'SUCRE',
                'capital' => 'MARIPA',
                'estado_id' => 26,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-18',
                'in_reg' => 'OR'  
            ),
            134 =>
            array(
                'id' => 209,
                'co_munc_asap' => '01',
                'nombre' => 'BEJUMA',
                'capital' => 'BEJUMA',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            135 =>
            array(
                'id' => 210,
                'co_munc_asap' => '02',
                'nombre' => 'CARLOS ARVELO',
                'capital' => 'GUIGUE',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            136 =>
            array(
                'id' => 211,
                'co_munc_asap' => '03',
                'nombre' => 'DIEGO IBARRA',
                'capital' => 'MARIARA',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            137 =>
            array(
                'id' => 212,
                'co_munc_asap' => '04',
                'nombre' => 'GUACARA',
                'capital' => 'GUACARA',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            138 =>
            array(
                'id' => 213,
                'co_munc_asap' => '05',
                'nombre' => 'JUAN JOSE MORA',
                'capital' => 'MORON',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            139 =>
            array(
                'id' => 218,
                'co_munc_asap' => '06',
                'nombre' => 'LIBERTADOR',
                'capital' => 'TOCUYITO',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            140 =>
            array(
                'id' => 219,
                'co_munc_asap' => '07',
                'nombre' => 'LOS GUAYOS',
                'capital' => 'LOS GUAYOS',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            141 =>
            array(
                'id' => 214,
                'co_munc_asap' => '08',
                'nombre' => 'MIRANDA',
                'capital' => 'MIRANDA',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            142 =>
            array(
                'id' => 215,
                'co_munc_asap' => '09',
                'nombre' => 'MONTALBAN',
                'capital' => 'MONTALBAN',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            143 =>
            array(
                'id' => 220,
                'co_munc_asap' => '10',
                'nombre' => 'NAGUANAGUA',
                'capital' => 'NAGUANAGUA',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            144 =>
            array(
                'id' => 216,
                'co_munc_asap' => '11',
                'nombre' => 'PUERTO CABELLO',
                'capital' => 'PUERTO CABELLO',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            145 =>
            array(
                'id' => 221,
                'co_munc_asap' => '12',
                'nombre' => 'SAN DIEGO',
                'capital' => 'SAN DIEGO',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            146 =>
            array(
                'id' => 217,
                'co_munc_asap' => '13',
                'nombre' => 'SAN JOAQUIN',
                'capital' => 'SAN JOAQUIN',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            147 =>
            array(
                'id' => 222,
                'co_munc_asap' => '14',
                'nombre' => 'VALENCIA',
                'capital' => 'VALENCIA',
                'estado_id' => 27,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-03-19',
                'in_reg' => 'CE'  
            ),
            148 =>
            array(
                'id' => 227,
                'co_munc_asap' => '01',
                'nombre' => 'ACEVEDO',
                'capital' => 'CAUCAGUA',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            149 =>
            array(
                'id' => 228,
                'co_munc_asap' => '02',
                'nombre' => 'ANDRES BELLO',
                'capital' => 'SAN JOSE DE BARLOVENTO',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            150 =>
            array(
                'id' => 229,
                'co_munc_asap' => '03',
                'nombre' => 'BARUTA',
                'capital' => 'NUESTRA SEÑORA DEL ROSARIO DE BARUTA',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            151 =>
            array(
                'id' => 230,
                'co_munc_asap' => '04',
                'nombre' => 'BRION',
                'capital' => 'HIGUEROTE',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            152 =>
            array(
                'id' => 231,
                'co_munc_asap' => '05',
                'nombre' => 'BUROZ',
                'capital' => 'MANPORAL',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            153 =>
            array(
                'id' => 232,
                'co_munc_asap' => '06',
                'nombre' => 'CARRIZAL',
                'capital' => 'CARRIZAL',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            154 =>
            array(
                'id' => 233,
                'co_munc_asap' => '07',
                'nombre' => 'CHACAO',
                'capital' => 'CHACAO',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            155 =>
            array(
                'id' => 234,
                'co_munc_asap' => '08',
                'nombre' => 'CRISTOBAL ROJAS',
                'capital' => 'CHARALLAVE',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            156 =>
            array(
                'id' => 235,
                'co_munc_asap' => '09',
                'nombre' => 'EL HATILLO',
                'capital' => 'EL HATILLO',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            157 =>
            array(
                'id' => 236,
                'co_munc_asap' => '10',
                'nombre' => 'GUAICAIPURO',
                'capital' => 'LOS TEQUES',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            158 =>
            array(
                'id' => 237,
                'co_munc_asap' => '11',
                'nombre' => 'INDEPENDENCIA',
                'capital' => 'SANTA TERESA DEL TUY',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            159 =>
            array(
                'id' => 238,
                'co_munc_asap' => '12',
                'nombre' => 'LANDER',
                'capital' => 'OCUMARE DEL TUY',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            160 =>
            array(
                'id' => 226,
                'co_munc_asap' => '13',
                'nombre' => 'LOS SALIAS',
                'capital' => 'SAN ANTONIO DE LOS ALTOS',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            161 =>
            array(
                'id' => 239,
                'co_munc_asap' => '14',
                'nombre' => 'PAEZ',
                'capital' => 'RIO CHICO',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            162 =>
            array(
                'id' => 240,
                'co_munc_asap' => '15',
                'nombre' => 'PAZ CASTILLO',
                'capital' => 'SANTA LUCIA',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            163 =>
            array(
                'id' => 241,
                'co_munc_asap' => '16',
                'nombre' => 'PEDRO GUAL',
                'capital' => 'CUPIRA',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            164 =>
            array(
                'id' => 224,
                'co_munc_asap' => '17',
                'nombre' => 'PLAZA',
                'capital' => 'GUARENAS',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            165 =>
            array(
                'id' => 242,
                'co_munc_asap' => '18',
                'nombre' => 'SIMON BOLIVAR',
                'capital' => 'SAN FRANCISCO DE YARE',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            166 =>
            array(
                'id' => 225,
                'co_munc_asap' => '19',
                'nombre' => 'SUCRE',
                'capital' => 'PETARE',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            167 =>
            array(
                'id' => 243,
                'co_munc_asap' => '20',
                'nombre' => 'URDANETA',
                'capital' => 'CUA',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            168 =>
            array(
                'id' => 223,
                'co_munc_asap' => '21',
                'nombre' => 'ZAMORA',
                'capital' => 'GUATIRE',
                'estado_id' => 28,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-04-12',
                'in_reg' => 'CA'  
            ),
            169 =>
            array(
                'id' => 327,
                'co_munc_asap' => '01',
                'nombre' => 'ALBERTO ADRIANI',
                'capital' => 'EL VIGIA',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            170 =>
            array(
                'id' => 328,
                'co_munc_asap' => '02',
                'nombre' => 'ANDRES BELLO',
                'capital' => 'LA AZULITA',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            171 =>
            array(
                'id' => 329,
                'co_munc_asap' => '03',
                'nombre' => 'ANTONIO PINTO SALINAS',
                'capital' => 'SANTA CRUZ DE MORA',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            172 =>
            array(
                'id' => 330,
                'co_munc_asap' => '04',
                'nombre' => 'ARICAGUA',
                'capital' => 'ARICAGUA',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            173 =>
            array(
                'id' => 331,
                'co_munc_asap' => '05',
                'nombre' => 'ARZOBISPO CHACON',
                'capital' => 'CANAGUA',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            174 =>
            array(
                'id' => 244,
                'co_munc_asap' => '06',
                'nombre' => 'CAMPO ELIAS',
                'capital' => 'EJIDO',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-04',
                'in_reg' => 'LA'  
            ),
            175 =>
            array(
                'id' => 332,
                'co_munc_asap' => '07',
                'nombre' => 'CARACCIOLO PARRA OLMEDO',
                'capital' => 'TUCANI',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            176 =>
            array(
                'id' => 333,
                'co_munc_asap' => '08',
                'nombre' => 'CARDENAL QUINTERO',
                'capital' => 'SANTO DOMINGO',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            177 =>
            array(
                'id' => 334,
                'co_munc_asap' => '09',
                'nombre' => 'GUARAQUE',
                'capital' => 'GUARAQUE',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            178 =>
            array(
                'id' => 335,
                'co_munc_asap' => '10',
                'nombre' => 'JULIO CESAR SALAS',
                'capital' => 'ARAPUEY',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            179 =>
            array(
                'id' => 336,
                'co_munc_asap' => '11',
                'nombre' => 'JUSTO BRICEÑO',
                'capital' => 'TORONDOY',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            180 =>
            array(
                'id' => 247,
                'co_munc_asap' => '12',
                'nombre' => 'LIBERTADOR',
                'capital' => 'MERIDA',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-16',
                'in_reg' => 'LA'  
            ),
            181 =>
            array(
                'id' => 337,
                'co_munc_asap' => '13',
                'nombre' => 'MIRANDA',
                'capital' => 'TIMOTES',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            182 =>
            array(
                'id' => 338,
                'co_munc_asap' => '14',
                'nombre' => 'OBISPO RAMOS DE LORA',
                'capital' => 'SANTA ELENA DE ARENALES',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            183 =>
            array(
                'id' => 339,
                'co_munc_asap' => '15',
                'nombre' => 'PADRE NOGUERA',
                'capital' => 'SANTA MARIA DE CAPARO',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            184 =>
            array(
                'id' => 340,
                'co_munc_asap' => '16',
                'nombre' => 'PUEBLO LLANO',
                'capital' => 'PUEBLO LLANO',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            185 =>
            array(
                'id' => 341,
                'co_munc_asap' => '17',
                'nombre' => 'RANGEL',
                'capital' => 'MUCUCHIES',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            186 =>
            array(
                'id' => 342,
                'co_munc_asap' => '18',
                'nombre' => 'RIVAS DAVILA',
                'capital' => 'BAILADORES',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            187 =>
            array(
                'id' => 343,
                'co_munc_asap' => '19',
                'nombre' => 'SANTOS MARQUINA',
                'capital' => 'TABAY',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            188 =>
            array(
                'id' => 344,
                'co_munc_asap' => '20',
                'nombre' => 'SUCRE',
                'capital' => 'LAGUNILLAS',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            189 =>
            array(
                'id' => 345,
                'co_munc_asap' => '21',
                'nombre' => 'TOVAR',
                'capital' => 'TOVAR',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            190 =>
            array(
                'id' => 346,
                'co_munc_asap' => '22',
                'nombre' => 'TULIO FEBRES CORDERO',
                'capital' => 'NUEVA BOLIVIA',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            191 =>
            array(
                'id' => 347,
                'co_munc_asap' => '23',
                'nombre' => 'ZEA',
                'capital' => 'ZEA',
                'estado_id' => 30,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            192 =>
            array(
                'id' => 375,
                'co_munc_asap' => '01',
                'nombre' => 'ANDRES BELLO',
                'capital' => 'SANTA ISABEL',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            193 =>
            array(
                'id' => 376,
                'co_munc_asap' => '02',
                'nombre' => 'BOCONO',
                'capital' => 'BOCONO',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            194 =>
            array(
                'id' => 377,
                'co_munc_asap' => '03',
                'nombre' => 'BOLIVAR',
                'capital' => 'SABANA GRANDE',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            195 =>
            array(
                'id' => 378,
                'co_munc_asap' => '04',
                'nombre' => 'CANDELARIA',
                'capital' => 'CHEJENDE',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            196 =>
            array(
                'id' => 379,
                'co_munc_asap' => '05',
                'nombre' => 'CARACHE',
                'capital' => 'CARACHE',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            197 =>
            array(
                'id' => 380,
                'co_munc_asap' => '06',
                'nombre' => 'ESCUQUE',
                'capital' => 'ESCUQUE',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            198 =>
            array(
                'id' => 381,
                'co_munc_asap' => '07',
                'nombre' => 'JOSE FELIPE MARQUEZ CAÑIZALEZ',
                'capital' => 'EL PARADERO',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            199 =>
            array(
                'id' => 382,
                'co_munc_asap' => '08',
                'nombre' => 'JUAN VICENTE CAMPO ELIAS',
                'capital' => 'CAMPO ELIAS',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            200 =>
            array(
                'id' => 383,
                'co_munc_asap' => '09',
                'nombre' => 'LA CEIBA',
                'capital' => 'SANTA APOLONIA',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            201 =>
            array(
                'id' => 384,
                'co_munc_asap' => '10',
                'nombre' => 'MIRANDA',
                'capital' => 'EL DIVIDIVE',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            202 =>
            array(
                'id' => 385,
                'co_munc_asap' => '11',
                'nombre' => 'MONTE CARMELO',
                'capital' => 'MONTE CARMELO',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            203 =>
            array(
                'id' => 386,
                'co_munc_asap' => '12',
                'nombre' => 'MOTATAN',
                'capital' => 'MOTATAN',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            204 =>
            array(
                'id' => 387,
                'co_munc_asap' => '13',
                'nombre' => 'PAMPAN',
                'capital' => 'PAMPAN',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            205 =>
            array(
                'id' => 388,
                'co_munc_asap' => '14',
                'nombre' => 'PAMPANITO',
                'capital' => 'PAMPANITO',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            206 =>
            array(
                'id' => 389,
                'co_munc_asap' => '15',
                'nombre' => 'RAFAEL RANGEL',
                'capital' => 'BETIJOQUE',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            207 =>
            array(
                'id' => 390,
                'co_munc_asap' => '16',
                'nombre' => 'SAN RAFAEL DE CARVAJAL',
                'capital' => 'CARVAJAL',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            208 =>
            array(
                'id' => 391,
                'co_munc_asap' => '17',
                'nombre' => 'SUCRE',
                'capital' => 'SABANA DE MENDOZA',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            209 =>
            array(
                'id' => 392,
                'co_munc_asap' => '18',
                'nombre' => 'TRUJILLO',
                'capital' => 'TRUJILLO',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            210 =>
            array(
                'id' => 393,
                'co_munc_asap' => '19',
                'nombre' => 'URDANETA',
                'capital' => 'LA QUEBRADA',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            211 =>
            array(
                'id' => 245,
                'co_munc_asap' => '20',
                'nombre' => 'VALERA',
                'capital' => 'VALERA',
                'estado_id' => 32,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-12',
                'in_reg' => 'OC'  
            ),
            212 =>
            array(
                'id' => 348,
                'co_munc_asap' => '01',
                'nombre' => 'AGUA BLANCA',
                'capital' => 'AGUA BLANCA',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            213 =>
            array(
                'id' => 349,
                'co_munc_asap' => '02',
                'nombre' => 'ARAURE',
                'capital' => 'ARAURE',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            214 =>
            array(
                'id' => 350,
                'co_munc_asap' => '03',
                'nombre' => 'ESTELLER',
                'capital' => 'PIRITU',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            215 =>
            array(
                'id' => 246,
                'co_munc_asap' => '04',
                'nombre' => 'GUANARE',
                'capital' => 'GUANARE',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-16',
                'in_reg' => 'CO'  
            ),
            216 =>
            array(
                'id' => 351,
                'co_munc_asap' => '05',
                'nombre' => 'GUANARITO',
                'capital' => 'GUANARITO',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            217 =>
            array(
                'id' => 352,
                'co_munc_asap' => '06',
                'nombre' => 'MONSEÑOR JOSE VICENTE DE UNDA',
                'capital' => 'PARAISO DE CHABASQUEN',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            218 =>
            array(
                'id' => 353,
                'co_munc_asap' => '07',
                'nombre' => 'OSPINO',
                'capital' => 'OSPINO',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            219 =>
            array(
                'id' => 248,
                'co_munc_asap' => '08',
                'nombre' => 'PAEZ',
                'capital' => 'ACARIGUA',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-26',
                'in_reg' => 'CO'  
            ),
            220 =>
            array(
                'id' => 354,
                'co_munc_asap' => '09',
                'nombre' => 'PAPELON',
                'capital' => 'PAPELON',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            221 =>
            array(
                'id' => 355,
                'co_munc_asap' => '10',
                'nombre' => 'SAN GENARO DE BOCONOITO',
                'capital' => 'BOCONOITO',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            222 =>
            array(
                'id' => 356,
                'co_munc_asap' => '11',
                'nombre' => 'SAN RAFAEL DE ONOTO',
                'capital' => 'SAN RAFAEL DE ONOTO',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            223 =>
            array(
                'id' => 357,
                'co_munc_asap' => '12',
                'nombre' => 'SANTA ROSALIA',
                'capital' => 'EL PLAYON',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            224 =>
            array(
                'id' => 358,
                'co_munc_asap' => '13',
                'nombre' => 'SUCRE',
                'capital' => 'BISCUCUY',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            225 =>
            array(
                'id' => 359,
                'co_munc_asap' => '14',
                'nombre' => 'TUREN',
                'capital' => 'VILLA BRUZUAL',
                'estado_id' => 34,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            226 =>
            array(
                'id' => 249,
                'co_munc_asap' => '01',
                'nombre' => 'AUTONOMO ALTO ORINOCO',
                'capital' => 'LA ESMERALDA',
                'estado_id' => 35,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            227 =>
            array(
                'id' => 250,
                'co_munc_asap' => '02',
                'nombre' => 'AUTONOMO ATABAPO',
                'capital' => 'SAN FERNANDO DE ATABAPO',
                'estado_id' => 35,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            228 =>
            array(
                'id' => 251,
                'co_munc_asap' => '03',
                'nombre' => 'AUTONOMO ATURES',
                'capital' => 'PUERTO AYACUCHO',
                'estado_id' => 35,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            229 =>
            array(
                'id' => 252,
                'co_munc_asap' => '04',
                'nombre' => 'AUTONOMO AUTANA',
                'capital' => 'ISLA RATON',
                'estado_id' => 35,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            230 =>
            array(
                'id' => 254,
                'co_munc_asap' => '06',
                'nombre' => 'AUTONOMO MANAPIARE',
                'capital' => 'SAN JUAN DE MANAPIARE',
                'estado_id' => 35,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            231 =>
            array(
                'id' => 253,
                'co_munc_asap' => '05',
                'nombre' => 'AUTONOMO MAROA',
                'capital' => 'MAROA',
                'estado_id' => 35,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            232 =>
            array(
                'id' => 255,
                'co_munc_asap' => '07',
                'nombre' => 'AUTONOMO RIO NEGRO',
                'capital' => 'SAN CARLOS DE RIO NEGRO',
                'estado_id' => 35,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            233 =>
            array(
                'id' => 256,
                'co_munc_asap' => '01',
                'nombre' => 'ACHAGUAS',
                'capital' => 'ACHAGUAS',
                'estado_id' => 36,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            234 =>
            array(
                'id' => 257,
                'co_munc_asap' => '02',
                'nombre' => 'BIRUACA',
                'capital' => 'BIRUACA',
                'estado_id' => 36,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            235 =>
            array(
                'id' => 258,
                'co_munc_asap' => '03',
                'nombre' => 'MUÑOZ',
                'capital' => 'BRUZUAL',
                'estado_id' => 36,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            236 =>
            array(
                'id' => 259,
                'co_munc_asap' => '04',
                'nombre' => 'PAEZ',
                'capital' => 'GUASDUALITO',
                'estado_id' => 36,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            237 =>
            array(
                'id' => 260,
                'co_munc_asap' => '05',
                'nombre' => 'PEDRO CAMEJO',
                'capital' => 'SAN JUAN DE PAYARA',
                'estado_id' => 36,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            238 =>
            array(
                'id' => 261,
                'co_munc_asap' => '06',
                'nombre' => 'ROMULO GALLEGOS',
                'capital' => 'ELORZA',
                'estado_id' => 36,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            239 =>
            array(
                'id' => 262,
                'co_munc_asap' => '07',
                'nombre' => 'SAN FERNANDO',
                'capital' => 'SAN FERNANDO DE APURE',
                'estado_id' => 36,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            240 =>
            array(
                'id' => 263,
                'co_munc_asap' => '01',
                'nombre' => 'ALBERTO ARVELO TORREALBA',
                'capital' => 'SABANETA',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            241 =>
            array(
                'id' => 417,
                'co_munc_asap' => '12',
                'nombre' => 'ANDRES ELOY BLANCO',
                'capital' => 'EL CANTON',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2006-03-23',
                'in_reg' => 'LA'  
            ),
            242 =>
            array(
                'id' => 264,
                'co_munc_asap' => '02',
                'nombre' => 'ANTONIO JOSE DE SUCRE',
                'capital' => 'SOCOPO',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            243 =>
            array(
                'id' => 265,
                'co_munc_asap' => '03',
                'nombre' => 'ARISMENDI',
                'capital' => 'ARISMENDI',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            244 =>
            array(
                'id' => 266,
                'co_munc_asap' => '04',
                'nombre' => 'BARINAS',
                'capital' => 'BARINAS',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            245 =>
            array(
                'id' => 267,
                'co_munc_asap' => '05',
                'nombre' => 'BOLIVAR',
                'capital' => 'BARINITAS',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            246 =>
            array(
                'id' => 268,
                'co_munc_asap' => '06',
                'nombre' => 'CRUZ PAREDES',
                'capital' => 'BARRANCAS',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            247 =>
            array(
                'id' => 269,
                'co_munc_asap' => '07',
                'nombre' => 'EZEQUIEL ZAMORA',
                'capital' => 'SANTA BARBARA',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            248 =>
            array(
                'id' => 270,
                'co_munc_asap' => '08',
                'nombre' => 'OBISPOS',
                'capital' => 'OBISPOS',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            249 =>
            array(
                'id' => 271,
                'co_munc_asap' => '09',
                'nombre' => 'PEDRAZA',
                'capital' => 'CIUDAD BOLIVIA',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            250 =>
            array(
                'id' => 272,
                'co_munc_asap' => '10',
                'nombre' => 'ROJAS',
                'capital' => 'LIBERTAD',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            251 =>
            array(
                'id' => 273,
                'co_munc_asap' => '11',
                'nombre' => 'SOSA',
                'capital' => 'CIUDAD DE NUTRIAS',
                'estado_id' => 37,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'LA'  
            ),
            252 =>
            array(
                'id' => 274,
                'co_munc_asap' => '01',
                'nombre' => 'ANZOATEGUI',
                'capital' => 'COJEDES',
                'estado_id' => 38,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            253 =>
            array(
                'id' => 275,
                'co_munc_asap' => '02',
                'nombre' => 'FALCON',
                'capital' => 'TINAQUILLO',
                'estado_id' => 38,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            254 =>
            array(
                'id' => 276,
                'co_munc_asap' => '03',
                'nombre' => 'GIRARDOT',
                'capital' => 'EL BAUL',
                'estado_id' => 38,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            255 =>
            array(
                'id' => 277,
                'co_munc_asap' => '04',
                'nombre' => 'LIMA BLANCO',
                'capital' => 'MACAPO',
                'estado_id' => 38,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            256 =>
            array(
                'id' => 278,
                'co_munc_asap' => '05',
                'nombre' => 'PAO DE SAN JUAN BAUTISTA',
                'capital' => 'EL PAO',
                'estado_id' => 38,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            257 =>
            array(
                'id' => 279,
                'co_munc_asap' => '06',
                'nombre' => 'RICAURTE',
                'capital' => 'LIBERTAD',
                'estado_id' => 38,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            258 =>
            array(
                'id' => 280,
                'co_munc_asap' => '07',
                'nombre' => 'ROMULO GALLEGOS',
                'capital' => 'LAS VEGAS',
                'estado_id' => 38,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            259 =>
            array(
                'id' => 281,
                'co_munc_asap' => '08',
                'nombre' => 'SAN CARLOS',
                'capital' => 'SAN CARLOS',
                'estado_id' => 38,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            260 =>
            array(
                'id' => 282,
                'co_munc_asap' => '09',
                'nombre' => 'TINACO',
                'capital' => 'TINACO',
                'estado_id' => 38,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            261 =>
            array(
                'id' => 283,
                'co_munc_asap' => '01',
                'nombre' => 'ANTONIO DIAZ',
                'capital' => 'CURIAPO',
                'estado_id' => 39,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            262 =>
            array(
                'id' => 284,
                'co_munc_asap' => '02',
                'nombre' => 'CASACOIMA',
                'capital' => 'SIERRA IMATACA',
                'estado_id' => 39,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            263 =>
            array(
                'id' => 285,
                'co_munc_asap' => '03',
                'nombre' => 'PEDERNALES',
                'capital' => 'PEDERNALES',
                'estado_id' => 39,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            264 =>
            array(
                'id' => 286,
                'co_munc_asap' => '04',
                'nombre' => 'TUCUPITA',
                'capital' => 'TUCUPITA',
                'estado_id' => 39,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            265 =>
            array(
                'id' => 287,
                'co_munc_asap' => '01',
                'nombre' => 'ACOSTA',
                'capital' => 'SAN JUAN DE LOS CAYOS',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            266 =>
            array(
                'id' => 288,
                'co_munc_asap' => '02',
                'nombre' => 'BOLIVAR',
                'capital' => 'SAN LUIS',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            267 =>
            array(
                'id' => 289,
                'co_munc_asap' => '03',
                'nombre' => 'BUCHIVACOA',
                'capital' => 'CAPATARIDA',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            268 =>
            array(
                'id' => 290,
                'co_munc_asap' => '04',
                'nombre' => 'CACIQUE MANAURE',
                'capital' => 'YARACAL',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            269 =>
            array(
                'id' => 291,
                'co_munc_asap' => '05',
                'nombre' => 'CARIRUBANA',
                'capital' => 'PUNTO FIJO',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            270 =>
            array(
                'id' => 292,
                'co_munc_asap' => '06',
                'nombre' => 'COLINA',
                'capital' => 'LA VELA DE CORO',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            271 =>
            array(
                'id' => 293,
                'co_munc_asap' => '07',
                'nombre' => 'DABAJURO',
                'capital' => 'DABAJURO',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            272 =>
            array(
                'id' => 294,
                'co_munc_asap' => '08',
                'nombre' => 'DEMOCRACIA',
                'capital' => 'PEDREGAL',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            273 =>
            array(
                'id' => 295,
                'co_munc_asap' => '09',
                'nombre' => 'FALCON',
                'capital' => 'PUEBLO NUEVO',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            274 =>
            array(
                'id' => 296,
                'co_munc_asap' => '10',
                'nombre' => 'FEDERACION',
                'capital' => 'CHURUGUARA',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            275 =>
            array(
                'id' => 297,
                'co_munc_asap' => '11',
                'nombre' => 'JACURA',
                'capital' => 'JACURA',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            276 =>
            array(
                'id' => 298,
                'co_munc_asap' => '12',
                'nombre' => 'LOS TAQUES',
                'capital' => 'SANTA CRUZ DE LOS TAQUES',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            277 =>
            array(
                'id' => 299,
                'co_munc_asap' => '13',
                'nombre' => 'MAUROA',
                'capital' => 'MENE DE MAUROA',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            278 =>
            array(
                'id' => 300,
                'co_munc_asap' => '14',
                'nombre' => 'MIRANDA',
                'capital' => 'SANTA ANA DE CORO',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            279 =>
            array(
                'id' => 301,
                'co_munc_asap' => '15',
                'nombre' => 'MONSEÑOR ITURRIZA',
                'capital' => 'CHICHIRIVICHE',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            280 =>
            array(
                'id' => 302,
                'co_munc_asap' => '16',
                'nombre' => 'PALMASOLA',
                'capital' => 'PALMASOLA',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            281 =>
            array(
                'id' => 303,
                'co_munc_asap' => '17',
                'nombre' => 'PETIT',
                'capital' => 'CABURE',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            282 =>
            array(
                'id' => 304,
                'co_munc_asap' => '18',
                'nombre' => 'PIRITU',
                'capital' => 'PIRITU',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            283 =>
            array(
                'id' => 305,
                'co_munc_asap' => '19',
                'nombre' => 'SAN FRANCISCO',
                'capital' => 'MIRIMIRE',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            284 =>
            array(
                'id' => 306,
                'co_munc_asap' => '20',
                'nombre' => 'SILVA',
                'capital' => 'TUCACAS',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            285 =>
            array(
                'id' => 307,
                'co_munc_asap' => '21',
                'nombre' => 'SUCRE',
                'capital' => 'LA CRUZ DE TARATARA',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            286 =>
            array(
                'id' => 308,
                'co_munc_asap' => '22',
                'nombre' => 'TOCOPERO',
                'capital' => 'TOCOPERO',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            287 =>
            array(
                'id' => 309,
                'co_munc_asap' => '23',
                'nombre' => 'UNION',
                'capital' => 'SANTA CRUZ DE BUCARAL',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            288 =>
            array(
                'id' => 310,
                'co_munc_asap' => '24',
                'nombre' => 'URUMACO',
                'capital' => 'URUMACO',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            289 =>
            array(
                'id' => 311,
                'co_munc_asap' => '25',
                'nombre' => 'ZAMORA',
                'capital' => 'PUERTO CUMAREBO',
                'estado_id' => 40,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OC'  
            ),
            290 =>
            array(
                'id' => 312,
                'co_munc_asap' => '01',
                'nombre' => 'CAMAGUAN',
                'capital' => 'CAMAGUAN',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            291 =>
            array(
                'id' => 313,
                'co_munc_asap' => '02',
                'nombre' => 'CHAGUARAMAS',
                'capital' => 'CHAGUARAMAS',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            292 =>
            array(
                'id' => 314,
                'co_munc_asap' => '03',
                'nombre' => 'EL SOCORRO',
                'capital' => 'EL SOCORRO',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            293 =>
            array(
                'id' => 319,
                'co_munc_asap' => '08',
                'nombre' => 'FRANCISCO DE MIRANDA',
                'capital' => 'CALABOZO',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            294 =>
            array(
                'id' => 322,
                'co_munc_asap' => '11',
                'nombre' => 'JOSE FELIX RIBAS',
                'capital' => 'TUCUPIDO',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            295 =>
            array(
                'id' => 320,
                'co_munc_asap' => '09',
                'nombre' => 'JOSE TADEO MONAGAS',
                'capital' => 'ALTAGRACIA DE ORITUCO',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            296 =>
            array(
                'id' => 323,
                'co_munc_asap' => '12',
                'nombre' => 'JUAN GERMAN ROSCIO',
                'capital' => 'SAN JUAN DE LOS MORROS',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            297 =>
            array(
                'id' => 318,
                'co_munc_asap' => '07',
                'nombre' => 'JULIAN MELLADO',
                'capital' => 'EL SOMBRERO',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            298 =>
            array(
                'id' => 317,
                'co_munc_asap' => '06',
                'nombre' => 'LAS MERCEDES',
                'capital' => 'LAS MERCEDES',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            299 =>
            array(
                'id' => 316,
                'co_munc_asap' => '05',
                'nombre' => 'LEONARDO INFANTE',
                'capital' => 'VALLE DE LA PASCUA',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            300 =>
            array(
                'id' => 321,
                'co_munc_asap' => '10',
                'nombre' => 'ORTIZ',
                'capital' => 'ORTIZ',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            301 =>
            array(
                'id' => 326,
                'co_munc_asap' => '15',
                'nombre' => 'PEDRO ZARAZA',
                'capital' => 'ZARAZA',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            302 =>
            array(
                'id' => 315,
                'co_munc_asap' => '04',
                'nombre' => 'SAN GERONIMO DE GUAYABAL',
                'capital' => 'GUAYABAL',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            303 =>
            array(
                'id' => 324,
                'co_munc_asap' => '13',
                'nombre' => 'SAN JOSE DE GUARIBE',
                'capital' => 'SAN JOSE DE GUARIBE',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            304 =>
            array(
                'id' => 325,
                'co_munc_asap' => '14',
                'nombre' => 'SANTA MARIA DE IPIRE',
                'capital' => 'SANTA MARIA DE IPIRE',
                'estado_id' => 41,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CE'  
            ),
            305 =>
            array(
                'id' => 360,
                'co_munc_asap' => '01',
                'nombre' => 'ANDRES ELOY BLANCO',
                'capital' => 'CASANAY',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            306 =>
            array(
                'id' => 361,
                'co_munc_asap' => '02',
                'nombre' => 'ANDRES MATA',
                'capital' => 'SAN JOSE DE AEROCUAR',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            307 =>
            array(
                'id' => 362,
                'co_munc_asap' => '03',
                'nombre' => 'ARISMENDI',
                'capital' => 'RIO CARIBE',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            308 =>
            array(
                'id' => 363,
                'co_munc_asap' => '04',
                'nombre' => 'BENITEZ',
                'capital' => 'EL PILAR',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            309 =>
            array(
                'id' => 364,
                'co_munc_asap' => '05',
                'nombre' => 'BERMUDEZ',
                'capital' => 'CARUPANO',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            310 =>
            array(
                'id' => 365,
                'co_munc_asap' => '06',
                'nombre' => 'BOLIVAR',
                'capital' => 'MARIGUITAR',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            311 =>
            array(
                'id' => 366,
                'co_munc_asap' => '07',
                'nombre' => 'CAJIGAL',
                'capital' => 'YAGUARAPARO',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            312 =>
            array(
                'id' => 367,
                'co_munc_asap' => '08',
                'nombre' => 'CRUZ SALMERON ACOSTA',
                'capital' => 'ARAYA',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            313 =>
            array(
                'id' => 368,
                'co_munc_asap' => '09',
                'nombre' => 'LIBERTADOR',
                'capital' => 'TUNAPUY',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            314 =>
            array(
                'id' => 369,
                'co_munc_asap' => '10',
                'nombre' => 'MARIÑO',
                'capital' => 'IRAPA',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            315 =>
            array(
                'id' => 370,
                'co_munc_asap' => '11',
                'nombre' => 'MEJIA',
                'capital' => 'SAN ANTONIO DEL GOLFO',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            316 =>
            array(
                'id' => 371,
                'co_munc_asap' => '12',
                'nombre' => 'MONTES',
                'capital' => 'CUMANACOA',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            317 =>
            array(
                'id' => 372,
                'co_munc_asap' => '13',
                'nombre' => 'RIBERO',
                'capital' => 'CARIACO',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            318 =>
            array(
                'id' => 373,
                'co_munc_asap' => '14',
                'nombre' => 'SUCRE',
                'capital' => 'CUMANA',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            319 =>
            array(
                'id' => 374,
                'co_munc_asap' => '15',
                'nombre' => 'VALDEZ',
                'capital' => 'GUIRIA',
                'estado_id' => 42,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'OR'  
            ),
            320 =>
            array(
                'id' => 394,
                'co_munc_asap' => '01',
                'nombre' => 'ARISTIDES BASTIDAS',
                'capital' => 'SAN PABLO',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            321 =>
            array(
                'id' => 395,
                'co_munc_asap' => '02',
                'nombre' => 'BOLIVAR',
                'capital' => 'AROA',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            322 =>
            array(
                'id' => 396,
                'co_munc_asap' => '03',
                'nombre' => 'BRUZUAL',
                'capital' => 'CHIVACOA',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            323 =>
            array(
                'id' => 397,
                'co_munc_asap' => '04',
                'nombre' => 'COCOROTE',
                'capital' => 'COCOROTE',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            324 =>
            array(
                'id' => 398,
                'co_munc_asap' => '05',
                'nombre' => 'INDEPENDENCIA',
                'capital' => 'INDEPENDENCIA',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            325 =>
            array(
                'id' => 399,
                'co_munc_asap' => '06',
                'nombre' => 'JOSE ANTONIO PAEZ',
                'capital' => 'SABANA DE PARRA',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            326 =>
            array(
                'id' => 400,
                'co_munc_asap' => '07',
                'nombre' => 'LA TRINIDAD',
                'capital' => 'BORAURE',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            327 =>
            array(
                'id' => 401,
                'co_munc_asap' => '08',
                'nombre' => 'MANUEL MONGE',
                'capital' => 'YUMARE',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            328 =>
            array(
                'id' => 402,
                'co_munc_asap' => '09',
                'nombre' => 'NIRGUA',
                'capital' => 'NIRGUA',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            329 =>
            array(
                'id' => 403,
                'co_munc_asap' => '10',
                'nombre' => 'PEÑA',
                'capital' => 'YARITAGUA',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            330 =>
            array(
                'id' => 404,
                'co_munc_asap' => '11',
                'nombre' => 'SAN FELIPE',
                'capital' => 'SAN FELIPE',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            331 =>
            array(
                'id' => 405,
                'co_munc_asap' => '12',
                'nombre' => 'SUCRE',
                'capital' => 'GUAMA',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            332 =>
            array(
                'id' => 406,
                'co_munc_asap' => '13',
                'nombre' => 'URACHICHE',
                'capital' => 'URACHICHE',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            333 =>
            array(
                'id' => 407,
                'co_munc_asap' => '14',
                'nombre' => 'VEROES',
                'capital' => 'FARRIAR',
                'estado_id' => 43,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CO'  
            ),
            334 =>
            array(
                'id' => 408,
                'co_munc_asap' => '01',
                'nombre' => 'VARGAS',
                'capital' => 'LA GUAIRA',
                'estado_id' => 44,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CA'  
            ),
            335 =>
            array(
                'id' => 440,
                'co_munc_asap' => '04',
                'nombre' => 'ARCHIPIELAGO LA ORCHILA',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
            336 =>
            array(
                'id' => 439,
                'co_munc_asap' => '03',
                'nombre' => 'ARCHIPIELAGO LAS AVES',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
            337 =>
            array(
                'id' => 442,
                'co_munc_asap' => '06',
                'nombre' => 'ARCHIPIELAGO LOS FRAILES',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
            338 =>
            array(
                'id' => 441,
                'co_munc_asap' => '05',
                'nombre' => 'ARCHIPIELAGO LOS HERMANOS',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
            339 =>
            array(
                'id' => 438,
                'co_munc_asap' => '02',
                'nombre' => 'ARCHIPIELAGO LOS MONJES',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
            340 =>
            array(
                'id' => 409,
                'co_munc_asap' => '01',
                'nombre' => 'ARCHIPIELAGO LOS ROQUES',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2004-11-30',
                'in_reg' => 'CA'  
            ),
            341 =>
            array(
                'id' => 443,
                'co_munc_asap' => '07',
                'nombre' => 'ARCHIPIELAGO LOS TESTIGOS',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
            342 =>
            array(
                'id' => 448,
                'co_munc_asap' => '12',
                'nombre' => 'ISLA DE AVES',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
            343 =>
            array(
                'id' => 447,
                'co_munc_asap' => '11',
                'nombre' => 'ISLA DE PATOS',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
            344 =>
            array(
                'id' => 445,
                'co_munc_asap' => '09',
                'nombre' => 'ISLA LA BLANQUILLA',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
            345 =>
            array(
                'id' => 446,
                'co_munc_asap' => '10',
                'nombre' => 'ISLA LA SOLA',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
            346 =>
            array(
                'id' => 444,
                'co_munc_asap' => '08',
                'nombre' => 'ISLA LA TORTUGA',
                'capital' => NULL,
                'estado_id' => 45,
                'co_stat_data' => 'A',
                'fe_carga' => '2009-09-11',
                'in_reg' => 'CA'  
            ),
        );
    }

}

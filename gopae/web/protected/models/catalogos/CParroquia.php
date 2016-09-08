<?php

/**
 * Catalogo de Regiones
 *
 * @author Jose Gabriel Gonzalez
 */
class CParroquia extends CCatalogo {

    protected static $columns = array('id', 'co_prrq_asap', 'nombre', 'municipio_id', 'co_stat_data');

    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData() {
        self::$data = array(
            0 =>
            array(
                'id' => 1288,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ANTOLIN DEL CAMPO',
                'municipio_id' => 55,
                'co_stat_data' => 'A',
            ),
            1 =>
            array(
                'id' => 1289,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ARISMENDI',
                'municipio_id' => 56,
                'co_stat_data' => 'A',
            ),
            2 =>
            array(
                'id' => 1290,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL DIAZ',
                'municipio_id' => 57,
                'co_stat_data' => 'A',
            ),
            3 =>
            array(
                'id' => 1291,
                'co_prrq_asap' => '02',
                'nombre' => 'ZABALA',
                'municipio_id' => 57,
                'co_stat_data' => 'A',
            ),
            4 =>
            array(
                'id' => 1292,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL GARCIA',
                'municipio_id' => 58,
                'co_stat_data' => 'A',
            ),
            5 =>
            array(
                'id' => 1293,
                'co_prrq_asap' => '02',
                'nombre' => 'FRANCISCO FAJARDO',
                'municipio_id' => 58,
                'co_stat_data' => 'A',
            ),
            6 =>
            array(
                'id' => 1308,
                'co_prrq_asap' => '02',
                'nombre' => 'BOLIVAR',
                'municipio_id' => 59,
                'co_stat_data' => 'A',
            ),
            7 =>
            array(
                'id' => 1294,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL GOMEZ',
                'municipio_id' => 59,
                'co_stat_data' => 'A',
            ),
            8 =>
            array(
                'id' => 1295,
                'co_prrq_asap' => '03',
                'nombre' => 'GUEVARA',
                'municipio_id' => 59,
                'co_stat_data' => 'A',
            ),
            9 =>
            array(
                'id' => 1296,
                'co_prrq_asap' => '04',
                'nombre' => 'MATASIETE',
                'municipio_id' => 59,
                'co_stat_data' => 'A',
            ),
            10 =>
            array(
                'id' => 1297,
                'co_prrq_asap' => '05',
                'nombre' => 'SUCRE',
                'municipio_id' => 59,
                'co_stat_data' => 'A',
            ),
            11 =>
            array(
                'id' => 1298,
                'co_prrq_asap' => '02',
                'nombre' => 'AGUIRRE',
                'municipio_id' => 60,
                'co_stat_data' => 'A',
            ),
            12 =>
            array(
                'id' => 1309,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL MANEIRO',
                'municipio_id' => 60,
                'co_stat_data' => 'A',
            ),
            13 =>
            array(
                'id' => 1300,
                'co_prrq_asap' => '02',
                'nombre' => 'ADRIAN',
                'municipio_id' => 61,
                'co_stat_data' => 'A',
            ),
            14 =>
            array(
                'id' => 1299,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL MARCANO',
                'municipio_id' => 61,
                'co_stat_data' => 'A',
            ),
            15 =>
            array(
                'id' => 1301,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL MARIÑO',
                'municipio_id' => 62,
                'co_stat_data' => 'A',
            ),
            16 =>
            array(
                'id' => 1302,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PENINSULA DE MACANAO',
                'municipio_id' => 63,
                'co_stat_data' => 'A',
            ),
            17 =>
            array(
                'id' => 1303,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN FRANCISCO',
                'municipio_id' => 63,
                'co_stat_data' => 'A',
            ),
            18 =>
            array(
                'id' => 1304,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL TUBORES',
                'municipio_id' => 64,
                'co_stat_data' => 'A',
            ),
            19 =>
            array(
                'id' => 1305,
                'co_prrq_asap' => '02',
                'nombre' => 'LOS BARALES',
                'municipio_id' => 64,
                'co_stat_data' => 'A',
            ),
            20 =>
            array(
                'id' => 1306,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL VILLALBA',
                'municipio_id' => 65,
                'co_stat_data' => 'A',
            ),
            21 =>
            array(
                'id' => 1307,
                'co_prrq_asap' => '02',
                'nombre' => 'VICENTE FUENTES',
                'municipio_id' => 65,
                'co_stat_data' => 'A',
            ),
            22 =>
            array(
                'id' => 1368,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ANACO',
                'municipio_id' => 87,
                'co_stat_data' => 'A',
            ),
            23 =>
            array(
                'id' => 1369,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN JOAQUIN',
                'municipio_id' => 87,
                'co_stat_data' => 'A',
            ),
            24 =>
            array(
                'id' => 1371,
                'co_prrq_asap' => '02',
                'nombre' => 'CACHIPO',
                'municipio_id' => 88,
                'co_stat_data' => 'A',
            ),
            25 =>
            array(
                'id' => 1370,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ARAGUA',
                'municipio_id' => 88,
                'co_stat_data' => 'A',
            ),
            26 =>
            array(
                'id' => 1372,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL FERNANDO DE PEÑALVER',
                'municipio_id' => 89,
                'co_stat_data' => 'A',
            ),
            27 =>
            array(
                'id' => 1373,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN MIGUEL',
                'municipio_id' => 89,
                'co_stat_data' => 'A',
            ),
            28 =>
            array(
                'id' => 1374,
                'co_prrq_asap' => '03',
                'nombre' => 'SUCRE',
                'municipio_id' => 89,
                'co_stat_data' => 'A',
            ),
            29 =>
            array(
                'id' => 1376,
                'co_prrq_asap' => '02',
                'nombre' => 'SANTA BARBARA',
                'municipio_id' => 90,
                'co_stat_data' => 'A',
            ),
            30 =>
            array(
                'id' => 1375,
                'co_prrq_asap' => '01',
                'nombre' => 'VALLE DE GUANAPE',
                'municipio_id' => 90,
                'co_stat_data' => 'A',
            ),
            31 =>
            array(
                'id' => 1378,
                'co_prrq_asap' => '02',
                'nombre' => 'ATAPIRIRE',
                'municipio_id' => 91,
                'co_stat_data' => 'A',
            ),
            32 =>
            array(
                'id' => 1379,
                'co_prrq_asap' => '03',
                'nombre' => 'BOCA DEL PAO',
                'municipio_id' => 91,
                'co_stat_data' => 'A',
            ),
            33 =>
            array(
                'id' => 1377,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL FRANCISCO DE MIRANDA',
                'municipio_id' => 91,
                'co_stat_data' => 'A',
            ),
            34 =>
            array(
                'id' => 1380,
                'co_prrq_asap' => '04',
                'nombre' => 'EL PAO',
                'municipio_id' => 91,
                'co_stat_data' => 'A',
            ),
            35 =>
            array(
                'id' => 1381,
                'co_prrq_asap' => '05',
                'nombre' => 'MUCURA',
                'municipio_id' => 91,
                'co_stat_data' => 'A',
            ),
            36 =>
            array(
                'id' => 1420,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL INDEPENDENCIA',
                'municipio_id' => 92,
                'co_stat_data' => 'A',
            ),
            37 =>
            array(
                'id' => 1382,
                'co_prrq_asap' => '02',
                'nombre' => 'MAMO',
                'municipio_id' => 92,
                'co_stat_data' => 'A',
            ),
            38 =>
            array(
                'id' => 1383,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PUERTO LA CRUZ',
                'municipio_id' => 93,
                'co_stat_data' => 'A',
            ),
            39 =>
            array(
                'id' => 1384,
                'co_prrq_asap' => '02',
                'nombre' => 'POZUELOS',
                'municipio_id' => 93,
                'co_stat_data' => 'A',
            ),
            40 =>
            array(
                'id' => 1385,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ONOTO',
                'municipio_id' => 94,
                'co_stat_data' => 'A',
            ),
            41 =>
            array(
                'id' => 1386,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN PABLO',
                'municipio_id' => 94,
                'co_stat_data' => 'A',
            ),
            42 =>
            array(
                'id' => 1387,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL JOSE GREGORIO MONAGAS',
                'municipio_id' => 95,
                'co_stat_data' => 'A',
            ),
            43 =>
            array(
                'id' => 1388,
                'co_prrq_asap' => '02',
                'nombre' => 'PIAR',
                'municipio_id' => 95,
                'co_stat_data' => 'A',
            ),
            44 =>
            array(
                'id' => 1389,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN DIEGO DE CABRUTICA',
                'municipio_id' => 95,
                'co_stat_data' => 'A',
            ),
            45 =>
            array(
                'id' => 1390,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA CLARA',
                'municipio_id' => 95,
                'co_stat_data' => 'A',
            ),
            46 =>
            array(
                'id' => 1391,
                'co_prrq_asap' => '05',
                'nombre' => 'UVERITO',
                'municipio_id' => 95,
                'co_stat_data' => 'A',
            ),
            47 =>
            array(
                'id' => 1392,
                'co_prrq_asap' => '06',
                'nombre' => 'ZUATA',
                'municipio_id' => 95,
                'co_stat_data' => 'A',
            ),
            48 =>
            array(
                'id' => 1393,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL LIBERTAD',
                'municipio_id' => 96,
                'co_stat_data' => 'A',
            ),
            49 =>
            array(
                'id' => 1394,
                'co_prrq_asap' => '02',
                'nombre' => 'EL CARITO',
                'municipio_id' => 96,
                'co_stat_data' => 'A',
            ),
            50 =>
            array(
                'id' => 1395,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTA INES',
                'municipio_id' => 96,
                'co_stat_data' => 'A',
            ),
            51 =>
            array(
                'id' => 1396,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL CLARINES',
                'municipio_id' => 97,
                'co_stat_data' => 'A',
            ),
            52 =>
            array(
                'id' => 1397,
                'co_prrq_asap' => '02',
                'nombre' => 'GUANAPE',
                'municipio_id' => 97,
                'co_stat_data' => 'A',
            ),
            53 =>
            array(
                'id' => 1398,
                'co_prrq_asap' => '03',
                'nombre' => 'SABANA DE UCHIRE',
                'municipio_id' => 97,
                'co_stat_data' => 'A',
            ),
            54 =>
            array(
                'id' => 1399,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PEDRO MARIA FREITES',
                'municipio_id' => 98,
                'co_stat_data' => 'A',
            ),
            55 =>
            array(
                'id' => 1400,
                'co_prrq_asap' => '02',
                'nombre' => 'LIBERTADOR',
                'municipio_id' => 98,
                'co_stat_data' => 'A',
            ),
            56 =>
            array(
                'id' => 1401,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTA ROSA',
                'municipio_id' => 98,
                'co_stat_data' => 'A',
            ),
            57 =>
            array(
                'id' => 1402,
                'co_prrq_asap' => '04',
                'nombre' => 'URICA',
                'municipio_id' => 98,
                'co_stat_data' => 'A',
            ),
            58 =>
            array(
                'id' => 1403,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PIRITU',
                'municipio_id' => 99,
                'co_stat_data' => 'A',
            ),
            59 =>
            array(
                'id' => 1404,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN FRANCISCO',
                'municipio_id' => 99,
                'co_stat_data' => 'A',
            ),
            60 =>
            array(
                'id' => 1405,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SAN JOSE DE GUANIPA',
                'municipio_id' => 100,
                'co_stat_data' => 'A',
            ),
            61 =>
            array(
                'id' => 1411,
                'co_prrq_asap' => '03',
                'nombre' => 'BERGANTIN',
                'municipio_id' => 101,
                'co_stat_data' => 'A',
            ),
            62 =>
            array(
                'id' => 1412,
                'co_prrq_asap' => '04',
                'nombre' => 'CAIGUA',
                'municipio_id' => 101,
                'co_stat_data' => 'A',
            ),
            63 =>
            array(
                'id' => 1409,
                'co_prrq_asap' => '01',
                'nombre' => 'EL CARMEN',
                'municipio_id' => 101,
                'co_stat_data' => 'A',
            ),
            64 =>
            array(
                'id' => 1413,
                'co_prrq_asap' => '05',
                'nombre' => 'EL PILAR',
                'municipio_id' => 101,
                'co_stat_data' => 'A',
            ),
            65 =>
            array(
                'id' => 1414,
                'co_prrq_asap' => '06',
                'nombre' => 'NARICUAL',
                'municipio_id' => 101,
                'co_stat_data' => 'A',
            ),
            66 =>
            array(
                'id' => 1410,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN CRISTOBAL',
                'municipio_id' => 101,
                'co_stat_data' => 'A',
            ),
            67 =>
            array(
                'id' => 1415,
                'co_prrq_asap' => '01',
                'nombre' => 'EDMUNDO BARRIOS',
                'municipio_id' => 102,
                'co_stat_data' => 'A',
            ),
            68 =>
            array(
                'id' => 1416,
                'co_prrq_asap' => '02',
                'nombre' => 'MIGUEL OTERO SILVA',
                'municipio_id' => 102,
                'co_stat_data' => 'A',
            ),
            69 =>
            array(
                'id' => 1421,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SANTA ANA',
                'municipio_id' => 103,
                'co_stat_data' => 'A',
            ),
            70 =>
            array(
                'id' => 1408,
                'co_prrq_asap' => '02',
                'nombre' => 'PUEBLO NUEVO',
                'municipio_id' => 103,
                'co_stat_data' => 'A',
            ),
            71 =>
            array(
                'id' => 1417,
                'co_prrq_asap' => '01',
                'nombre' => 'EL CHAPARRO',
                'municipio_id' => 104,
                'co_stat_data' => 'A',
            ),
            72 =>
            array(
                'id' => 1418,
                'co_prrq_asap' => '02',
                'nombre' => 'TOMAS ALFARO CALATRAVA',
                'municipio_id' => 104,
                'co_stat_data' => 'A',
            ),
            73 =>
            array(
                'id' => 1407,
                'co_prrq_asap' => '02',
                'nombre' => 'BOCA DE CHAVEZ',
                'municipio_id' => 105,
                'co_stat_data' => 'A',
            ),
            74 =>
            array(
                'id' => 1406,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL BOCA DE UCHIRE',
                'municipio_id' => 105,
                'co_stat_data' => 'A',
            ),
            75 =>
            array(
                'id' => 1419,
                'co_prrq_asap' => '02',
                'nombre' => 'EL MORRO',
                'municipio_id' => 106,
                'co_stat_data' => 'A',
            ),
            76 =>
            array(
                'id' => 1365,
                'co_prrq_asap' => '01',
                'nombre' => 'LECHERIAS',
                'municipio_id' => 106,
                'co_stat_data' => 'A',
            ),
            77 =>
            array(
                'id' => 1367,
                'co_prrq_asap' => '02',
                'nombre' => 'CHORRERON',
                'municipio_id' => 107,
                'co_stat_data' => 'A',
            ),
            78 =>
            array(
                'id' => 1366,
                'co_prrq_asap' => '01',
                'nombre' => 'GUANTA',
                'municipio_id' => 107,
                'co_stat_data' => 'A',
            ),
            79 =>
            array(
                'id' => 1436,
                'co_prrq_asap' => '01',
                'nombre' => 'ENCONTRADOS',
                'municipio_id' => 108,
                'co_stat_data' => 'A',
            ),
            80 =>
            array(
                'id' => 1437,
                'co_prrq_asap' => '02',
                'nombre' => 'UDON PEREZ',
                'municipio_id' => 108,
                'co_stat_data' => 'A',
            ),
            81 =>
            array(
                'id' => 1521,
                'co_prrq_asap' => '02',
                'nombre' => 'MORALITO',
                'municipio_id' => 109,
                'co_stat_data' => 'A',
            ),
            82 =>
            array(
                'id' => 1438,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN CARLOS DEL ZULIA',
                'municipio_id' => 109,
                'co_stat_data' => 'A',
            ),
            83 =>
            array(
                'id' => 1439,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTA BARBARA',
                'municipio_id' => 109,
                'co_stat_data' => 'A',
            ),
            84 =>
            array(
                'id' => 1440,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA CRUZ DEL ZULIA',
                'municipio_id' => 109,
                'co_stat_data' => 'A',
            ),
            85 =>
            array(
                'id' => 1441,
                'co_prrq_asap' => '05',
                'nombre' => 'URRIBARRI',
                'municipio_id' => 109,
                'co_stat_data' => 'A',
            ),
            86 =>
            array(
                'id' => 1449,
                'co_prrq_asap' => '02',
                'nombre' => 'BARI',
                'municipio_id' => 110,
                'co_stat_data' => 'A',
            ),
            87 =>
            array(
                'id' => 1448,
                'co_prrq_asap' => '01',
                'nombre' => 'JESUS MARIA SEMPRUN',
                'municipio_id' => 110,
                'co_stat_data' => 'A',
            ),
            88 =>
            array(
                'id' => 1455,
                'co_prrq_asap' => '01',
                'nombre' => 'ALONSO DE OJEDA',
                'municipio_id' => 111,
                'co_stat_data' => 'A',
            ),
            89 =>
            array(
                'id' => 1457,
                'co_prrq_asap' => '03',
                'nombre' => 'CAMPO LARA',
                'municipio_id' => 111,
                'co_stat_data' => 'A',
            ),
            90 =>
            array(
                'id' => 1458,
                'co_prrq_asap' => '04',
                'nombre' => 'ELEAZAR LOPEZ CONTRERAS',
                'municipio_id' => 111,
                'co_stat_data' => 'A',
            ),
            91 =>
            array(
                'id' => 1456,
                'co_prrq_asap' => '02',
                'nombre' => 'LIBERTAD',
                'municipio_id' => 111,
                'co_stat_data' => 'A',
            ),
            92 =>
            array(
                'id' => 1459,
                'co_prrq_asap' => '05',
                'nombre' => 'VENEZUELA',
                'municipio_id' => 111,
                'co_stat_data' => 'A',
            ),
            93 =>
            array(
                'id' => 1461,
                'co_prrq_asap' => '02',
                'nombre' => 'BARTOLOME DE LAS CASAS',
                'municipio_id' => 112,
                'co_stat_data' => 'A',
            ),
            94 =>
            array(
                'id' => 1460,
                'co_prrq_asap' => '01',
                'nombre' => 'LIBERTAD',
                'municipio_id' => 112,
                'co_stat_data' => 'A',
            ),
            95 =>
            array(
                'id' => 1462,
                'co_prrq_asap' => '03',
                'nombre' => 'RIO NEGRO',
                'municipio_id' => 112,
                'co_stat_data' => 'A',
            ),
            96 =>
            array(
                'id' => 1463,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN JOSE DE PERIJA',
                'municipio_id' => 112,
                'co_stat_data' => 'A',
            ),
            97 =>
            array(
                'id' => 1465,
                'co_prrq_asap' => '02',
                'nombre' => 'LA SIERRITA',
                'municipio_id' => 113,
                'co_stat_data' => 'A',
            ),
            98 =>
            array(
                'id' => 1466,
                'co_prrq_asap' => '03',
                'nombre' => 'LAS PARCELAS',
                'municipio_id' => 113,
                'co_stat_data' => 'A',
            ),
            99 =>
            array(
                'id' => 1467,
                'co_prrq_asap' => '04',
                'nombre' => 'LUIS DE VICENTE',
                'municipio_id' => 113,
                'co_stat_data' => 'A',
            ),
            100 =>
            array(
                'id' => 1468,
                'co_prrq_asap' => '05',
                'nombre' => 'MONSEÑOR MARCOS SERGIO GODOY',
                'municipio_id' => 113,
                'co_stat_data' => 'A',
            ),
            101 =>
            array(
                'id' => 1469,
                'co_prrq_asap' => '06',
                'nombre' => 'RICAURTE',
                'municipio_id' => 113,
                'co_stat_data' => 'A',
            ),
            102 =>
            array(
                'id' => 1464,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN RAFAEL',
                'municipio_id' => 113,
                'co_stat_data' => 'A',
            ),
            103 =>
            array(
                'id' => 1470,
                'co_prrq_asap' => '07',
                'nombre' => 'TAMARE',
                'municipio_id' => 113,
                'co_stat_data' => 'A',
            ),
            104 =>
            array(
                'id' => 1488,
                'co_prrq_asap' => '01',
                'nombre' => 'ALTAGRACIA',
                'municipio_id' => 114,
                'co_stat_data' => 'A',
            ),
            105 =>
            array(
                'id' => 1489,
                'co_prrq_asap' => '02',
                'nombre' => 'ANA MARIA CAMPOS',
                'municipio_id' => 114,
                'co_stat_data' => 'A',
            ),
            106 =>
            array(
                'id' => 1490,
                'co_prrq_asap' => '03',
                'nombre' => 'FARIA',
                'municipio_id' => 114,
                'co_stat_data' => 'A',
            ),
            107 =>
            array(
                'id' => 1491,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN ANTONIO',
                'municipio_id' => 114,
                'co_stat_data' => 'A',
            ),
            108 =>
            array(
                'id' => 1523,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN JOSE',
                'municipio_id' => 114,
                'co_stat_data' => 'A',
            ),
            109 =>
            array(
                'id' => 1525,
                'co_prrq_asap' => '02',
                'nombre' => 'DONALDO GARCIA',
                'municipio_id' => 115,
                'co_stat_data' => 'A',
            ),
            110 =>
            array(
                'id' => 1495,
                'co_prrq_asap' => '01',
                'nombre' => 'EL ROSARIO',
                'municipio_id' => 115,
                'co_stat_data' => 'A',
            ),
            111 =>
            array(
                'id' => 1496,
                'co_prrq_asap' => '03',
                'nombre' => 'SIXTO ZAMBRANO',
                'municipio_id' => 115,
                'co_stat_data' => 'A',
            ),
            112 =>
            array(
                'id' => 1498,
                'co_prrq_asap' => '03',
                'nombre' => 'DOMITILA FLORES',
                'municipio_id' => 116,
                'co_stat_data' => 'A',
            ),
            113 =>
            array(
                'id' => 1526,
                'co_prrq_asap' => '02',
                'nombre' => 'EL BAJO',
                'municipio_id' => 116,
                'co_stat_data' => 'A',
            ),
            114 =>
            array(
                'id' => 1499,
                'co_prrq_asap' => '04',
                'nombre' => 'FRANCISCO OCHOA',
                'municipio_id' => 116,
                'co_stat_data' => 'A',
            ),
            115 =>
            array(
                'id' => 1500,
                'co_prrq_asap' => '05',
                'nombre' => 'LOS CORTIJOS',
                'municipio_id' => 116,
                'co_stat_data' => 'A',
            ),
            116 =>
            array(
                'id' => 1501,
                'co_prrq_asap' => '06',
                'nombre' => 'MARCIAL HERNANDEZ',
                'municipio_id' => 116,
                'co_stat_data' => 'A',
            ),
            117 =>
            array(
                'id' => 1497,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN FRANCISCO',
                'municipio_id' => 116,
                'co_stat_data' => 'A',
            ),
            118 =>
            array(
                'id' => 1503,
                'co_prrq_asap' => '02',
                'nombre' => 'EL MENE',
                'municipio_id' => 117,
                'co_stat_data' => 'A',
            ),
            119 =>
            array(
                'id' => 1504,
                'co_prrq_asap' => '03',
                'nombre' => 'JOSE CENOVIO URRIBARRI',
                'municipio_id' => 117,
                'co_stat_data' => 'A',
            ),
            120 =>
            array(
                'id' => 1505,
                'co_prrq_asap' => '04',
                'nombre' => 'PEDRO LUCAS URRIBARRI',
                'municipio_id' => 117,
                'co_stat_data' => 'A',
            ),
            121 =>
            array(
                'id' => 1502,
                'co_prrq_asap' => '01',
                'nombre' => 'SANTA RITA',
                'municipio_id' => 117,
                'co_stat_data' => 'A',
            ),
            122 =>
            array(
                'id' => 1506,
                'co_prrq_asap' => '01',
                'nombre' => 'MANUEL MANRIQUE',
                'municipio_id' => 118,
                'co_stat_data' => 'A',
            ),
            123 =>
            array(
                'id' => 1507,
                'co_prrq_asap' => '02',
                'nombre' => 'RAFAEL MARIA BARALT',
                'municipio_id' => 118,
                'co_stat_data' => 'A',
            ),
            124 =>
            array(
                'id' => 1508,
                'co_prrq_asap' => '03',
                'nombre' => 'RAFAEL URDANETA',
                'municipio_id' => 118,
                'co_stat_data' => 'A',
            ),
            125 =>
            array(
                'id' => 1509,
                'co_prrq_asap' => '01',
                'nombre' => 'BOBURES',
                'municipio_id' => 119,
                'co_stat_data' => 'A',
            ),
            126 =>
            array(
                'id' => 1510,
                'co_prrq_asap' => '02',
                'nombre' => 'EL BATEY',
                'municipio_id' => 119,
                'co_stat_data' => 'A',
            ),
            127 =>
            array(
                'id' => 1511,
                'co_prrq_asap' => '03',
                'nombre' => 'GIBRALTAR',
                'municipio_id' => 119,
                'co_stat_data' => 'A',
            ),
            128 =>
            array(
                'id' => 1512,
                'co_prrq_asap' => '04',
                'nombre' => 'HERAS',
                'municipio_id' => 119,
                'co_stat_data' => 'A',
            ),
            129 =>
            array(
                'id' => 1513,
                'co_prrq_asap' => '05',
                'nombre' => 'MONSEÑOR ARTURO C ALVAREZ',
                'municipio_id' => 119,
                'co_stat_data' => 'A',
            ),
            130 =>
            array(
                'id' => 1514,
                'co_prrq_asap' => '06',
                'nombre' => 'ROMULO GALLEGOS',
                'municipio_id' => 119,
                'co_stat_data' => 'A',
            ),
            131 =>
            array(
                'id' => 1422,
                'co_prrq_asap' => '01',
                'nombre' => 'ISLA DE TOAS',
                'municipio_id' => 120,
                'co_stat_data' => 'A',
            ),
            132 =>
            array(
                'id' => 1423,
                'co_prrq_asap' => '02',
                'nombre' => 'MONAGAS',
                'municipio_id' => 120,
                'co_stat_data' => 'A',
            ),
            133 =>
            array(
                'id' => 1424,
                'co_prrq_asap' => '02',
                'nombre' => 'GENERAL URDANETA',
                'municipio_id' => 121,
                'co_stat_data' => 'A',
            ),
            134 =>
            array(
                'id' => 1425,
                'co_prrq_asap' => '03',
                'nombre' => 'LIBERTADOR',
                'municipio_id' => 121,
                'co_stat_data' => 'A',
            ),
            135 =>
            array(
                'id' => 1426,
                'co_prrq_asap' => '04',
                'nombre' => 'MANUEL GUANIPA MATOS',
                'municipio_id' => 121,
                'co_stat_data' => 'A',
            ),
            136 =>
            array(
                'id' => 1427,
                'co_prrq_asap' => '05',
                'nombre' => 'MARCELINO BRICEÑO',
                'municipio_id' => 121,
                'co_stat_data' => 'A',
            ),
            137 =>
            array(
                'id' => 1428,
                'co_prrq_asap' => '06',
                'nombre' => 'PUEBLO NUEVO',
                'municipio_id' => 121,
                'co_stat_data' => 'A',
            ),
            138 =>
            array(
                'id' => 1518,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN TIMOTEO',
                'municipio_id' => 121,
                'co_stat_data' => 'A',
            ),
            139 =>
            array(
                'id' => 1429,
                'co_prrq_asap' => '01',
                'nombre' => 'AMBROSIO',
                'municipio_id' => 122,
                'co_stat_data' => 'A',
            ),
            140 =>
            array(
                'id' => 1434,
                'co_prrq_asap' => '08',
                'nombre' => 'ARISTIDES CALVANI',
                'municipio_id' => 122,
                'co_stat_data' => 'A',
            ),
            141 =>
            array(
                'id' => 1519,
                'co_prrq_asap' => '02',
                'nombre' => 'CARMEN HERRERA',
                'municipio_id' => 122,
                'co_stat_data' => 'A',
            ),
            142 =>
            array(
                'id' => 1430,
                'co_prrq_asap' => '03',
                'nombre' => 'GERMAN RIOS LINARES',
                'municipio_id' => 122,
                'co_stat_data' => 'A',
            ),
            143 =>
            array(
                'id' => 1432,
                'co_prrq_asap' => '05',
                'nombre' => 'JORGE HERNANDEZ',
                'municipio_id' => 122,
                'co_stat_data' => 'A',
            ),
            144 =>
            array(
                'id' => 1431,
                'co_prrq_asap' => '04',
                'nombre' => 'LA ROSA',
                'municipio_id' => 122,
                'co_stat_data' => 'A',
            ),
            145 =>
            array(
                'id' => 1435,
                'co_prrq_asap' => '09',
                'nombre' => 'PUNTA GORDA',
                'municipio_id' => 122,
                'co_stat_data' => 'A',
            ),
            146 =>
            array(
                'id' => 1433,
                'co_prrq_asap' => '06',
                'nombre' => 'ROMULO BETANCOURT',
                'municipio_id' => 122,
                'co_stat_data' => 'A',
            ),
            147 =>
            array(
                'id' => 1520,
                'co_prrq_asap' => '07',
                'nombre' => 'SAN BENITO',
                'municipio_id' => 122,
                'co_stat_data' => 'A',
            ),
            148 =>
            array(
                'id' => 1443,
                'co_prrq_asap' => '02',
                'nombre' => 'CARLOS QUEVEDO',
                'municipio_id' => 123,
                'co_stat_data' => 'A',
            ),
            149 =>
            array(
                'id' => 1444,
                'co_prrq_asap' => '03',
                'nombre' => 'FRANCISCO JAVIER PULGAR',
                'municipio_id' => 123,
                'co_stat_data' => 'A',
            ),
            150 =>
            array(
                'id' => 1442,
                'co_prrq_asap' => '01',
                'nombre' => 'SIMON RODRIGUEZ',
                'municipio_id' => 123,
                'co_stat_data' => 'A',
            ),
            151 =>
            array(
                'id' => 1522,
                'co_prrq_asap' => '02',
                'nombre' => 'JOSE RAMON YEPEZ',
                'municipio_id' => 124,
                'co_stat_data' => 'A',
            ),
            152 =>
            array(
                'id' => 1445,
                'co_prrq_asap' => '01',
                'nombre' => 'LA CONCEPCION',
                'municipio_id' => 124,
                'co_stat_data' => 'A',
            ),
            153 =>
            array(
                'id' => 1446,
                'co_prrq_asap' => '03',
                'nombre' => 'MARIANO PARRA LEON',
                'municipio_id' => 124,
                'co_stat_data' => 'A',
            ),
            154 =>
            array(
                'id' => 1447,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN JOSE',
                'municipio_id' => 124,
                'co_stat_data' => 'A',
            ),
            155 =>
            array(
                'id' => 1451,
                'co_prrq_asap' => '02',
                'nombre' => 'ANDRES BELLO',
                'municipio_id' => 125,
                'co_stat_data' => 'A',
            ),
            156 =>
            array(
                'id' => 1452,
                'co_prrq_asap' => '03',
                'nombre' => 'CHIQUINQUIRA',
                'municipio_id' => 125,
                'co_stat_data' => 'A',
            ),
            157 =>
            array(
                'id' => 1450,
                'co_prrq_asap' => '01',
                'nombre' => 'CONCEPCION',
                'municipio_id' => 125,
                'co_stat_data' => 'A',
            ),
            158 =>
            array(
                'id' => 1453,
                'co_prrq_asap' => '04',
                'nombre' => 'EL CARMELO',
                'municipio_id' => 125,
                'co_stat_data' => 'A',
            ),
            159 =>
            array(
                'id' => 1454,
                'co_prrq_asap' => '05',
                'nombre' => 'POTRERITOS',
                'municipio_id' => 125,
                'co_stat_data' => 'A',
            ),
            160 =>
            array(
                'id' => 1471,
                'co_prrq_asap' => '01',
                'nombre' => 'ANTONIO BORJAS ROMERO',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            161 =>
            array(
                'id' => 1472,
                'co_prrq_asap' => '02',
                'nombre' => 'BOLIVAR',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            162 =>
            array(
                'id' => 1473,
                'co_prrq_asap' => '03',
                'nombre' => 'CACIQUE MARA',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            163 =>
            array(
                'id' => 1474,
                'co_prrq_asap' => '04',
                'nombre' => 'CARACCIOLO PARRA PEREZ',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            164 =>
            array(
                'id' => 1475,
                'co_prrq_asap' => '05',
                'nombre' => 'CECILIO ACOSTA',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            165 =>
            array(
                'id' => 1478,
                'co_prrq_asap' => '08',
                'nombre' => 'CHIQUINQUIRA',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            166 =>
            array(
                'id' => 1477,
                'co_prrq_asap' => '07',
                'nombre' => 'COQUIVACOA',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            167 =>
            array(
                'id' => 1476,
                'co_prrq_asap' => '06',
                'nombre' => 'CRISTO DE ARANZA',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            168 =>
            array(
                'id' => 1479,
                'co_prrq_asap' => '09',
                'nombre' => 'FRANCISCO EUGENIO BUSTAMANTE',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            169 =>
            array(
                'id' => 1480,
                'co_prrq_asap' => '10',
                'nombre' => 'IDELFONSO VASQUEZ',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            170 =>
            array(
                'id' => 1481,
                'co_prrq_asap' => '11',
                'nombre' => 'JUANA DE AVILA',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            171 =>
            array(
                'id' => 1527,
                'co_prrq_asap' => '12',
                'nombre' => 'LUIS HURTADO HIGUERA',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            172 =>
            array(
                'id' => 1482,
                'co_prrq_asap' => '13',
                'nombre' => 'MANUEL DAGNINO',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            173 =>
            array(
                'id' => 1483,
                'co_prrq_asap' => '14',
                'nombre' => 'OLEGARIO VILLALOBOS',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            174 =>
            array(
                'id' => 1484,
                'co_prrq_asap' => '15',
                'nombre' => 'RAUL LEONI',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            175 =>
            array(
                'id' => 1487,
                'co_prrq_asap' => '18',
                'nombre' => 'SAN ISIDRO',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            176 =>
            array(
                'id' => 1485,
                'co_prrq_asap' => '16',
                'nombre' => 'SANTA LUCIA',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            177 =>
            array(
                'id' => 1486,
                'co_prrq_asap' => '17',
                'nombre' => 'VENANCIO PULGAR',
                'municipio_id' => 126,
                'co_stat_data' => 'A',
            ),
            178 =>
            array(
                'id' => 1524,
                'co_prrq_asap' => '02',
                'nombre' => 'ALTA GUAJIRA',
                'municipio_id' => 127,
                'co_stat_data' => 'A',
            ),
            179 =>
            array(
                'id' => 1493,
                'co_prrq_asap' => '03',
                'nombre' => 'ELIAS SANCHEZ RUBIO',
                'municipio_id' => 127,
                'co_stat_data' => 'A',
            ),
            180 =>
            array(
                'id' => 1494,
                'co_prrq_asap' => '04',
                'nombre' => 'GUAJIRA',
                'municipio_id' => 127,
                'co_stat_data' => 'A',
            ),
            181 =>
            array(
                'id' => 1492,
                'co_prrq_asap' => '01',
                'nombre' => 'SINAMAICA',
                'municipio_id' => 127,
                'co_stat_data' => 'A',
            ),
            182 =>
            array(
                'id' => 1515,
                'co_prrq_asap' => '01',
                'nombre' => 'LA VICTORIA',
                'municipio_id' => 128,
                'co_stat_data' => 'A',
            ),
            183 =>
            array(
                'id' => 1516,
                'co_prrq_asap' => '02',
                'nombre' => 'RAFAEL URDANETA',
                'municipio_id' => 128,
                'co_stat_data' => 'A',
            ),
            184 =>
            array(
                'id' => 1517,
                'co_prrq_asap' => '03',
                'nombre' => 'RAUL CUENCA',
                'municipio_id' => 128,
                'co_stat_data' => 'A',
            ),
            185 =>
            array(
                'id' => 1549,
                'co_prrq_asap' => '22',
                'nombre' => '23 DE ENERO',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            186 =>
            array(
                'id' => 1528,
                'co_prrq_asap' => '01',
                'nombre' => 'ALTAGRACIA',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            187 =>
            array(
                'id' => 1529,
                'co_prrq_asap' => '02',
                'nombre' => 'ANTIMANO',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            188 =>
            array(
                'id' => 1530,
                'co_prrq_asap' => '03',
                'nombre' => 'CANDELARIA',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            189 =>
            array(
                'id' => 1531,
                'co_prrq_asap' => '04',
                'nombre' => 'CARICUAO',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            190 =>
            array(
                'id' => 1532,
                'co_prrq_asap' => '05',
                'nombre' => 'CATEDRAL',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            191 =>
            array(
                'id' => 1533,
                'co_prrq_asap' => '06',
                'nombre' => 'COCHE',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            192 =>
            array(
                'id' => 1534,
                'co_prrq_asap' => '07',
                'nombre' => 'EL JUNQUITO',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            193 =>
            array(
                'id' => 1535,
                'co_prrq_asap' => '08',
                'nombre' => 'EL PARAISO',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            194 =>
            array(
                'id' => 1536,
                'co_prrq_asap' => '09',
                'nombre' => 'EL RECREO',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            195 =>
            array(
                'id' => 1537,
                'co_prrq_asap' => '10',
                'nombre' => 'EL VALLE',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            196 =>
            array(
                'id' => 1538,
                'co_prrq_asap' => '11',
                'nombre' => 'LA PASTORA',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            197 =>
            array(
                'id' => 1539,
                'co_prrq_asap' => '12',
                'nombre' => 'LA VEGA',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            198 =>
            array(
                'id' => 1540,
                'co_prrq_asap' => '13',
                'nombre' => 'MACARAO',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            199 =>
            array(
                'id' => 1541,
                'co_prrq_asap' => '14',
                'nombre' => 'SAN AGUSTIN',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            200 =>
            array(
                'id' => 1542,
                'co_prrq_asap' => '15',
                'nombre' => 'SAN BERNARDINO',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            201 =>
            array(
                'id' => 1543,
                'co_prrq_asap' => '16',
                'nombre' => 'SAN JOSE',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            202 =>
            array(
                'id' => 1544,
                'co_prrq_asap' => '17',
                'nombre' => 'SAN JUAN',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            203 =>
            array(
                'id' => 1545,
                'co_prrq_asap' => '18',
                'nombre' => 'SAN PEDRO',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            204 =>
            array(
                'id' => 1546,
                'co_prrq_asap' => '19',
                'nombre' => 'SANTA ROSALIA',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            205 =>
            array(
                'id' => 1547,
                'co_prrq_asap' => '20',
                'nombre' => 'SANTA TERESA',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            206 =>
            array(
                'id' => 1548,
                'co_prrq_asap' => '21',
                'nombre' => 'SUCRE',
                'municipio_id' => 129,
                'co_stat_data' => 'A',
            ),
            207 =>
            array(
                'id' => 1550,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ANDRES BELLO',
                'municipio_id' => 130,
                'co_stat_data' => 'A',
            ),
            208 =>
            array(
                'id' => 1552,
                'co_prrq_asap' => '01',
                'nombre' => 'AYACUCHO',
                'municipio_id' => 131,
                'co_stat_data' => 'A',
            ),
            209 =>
            array(
                'id' => 1553,
                'co_prrq_asap' => '02',
                'nombre' => 'RIVAS BERTI',
                'municipio_id' => 131,
                'co_stat_data' => 'A',
            ),
            210 =>
            array(
                'id' => 1554,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN PEDRO DEL RIO',
                'municipio_id' => 131,
                'co_stat_data' => 'A',
            ),
            211 =>
            array(
                'id' => 1555,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL BOLIVAR',
                'municipio_id' => 132,
                'co_stat_data' => 'A',
            ),
            212 =>
            array(
                'id' => 1556,
                'co_prrq_asap' => '02',
                'nombre' => 'EL PALOTAL',
                'municipio_id' => 132,
                'co_stat_data' => 'A',
            ),
            213 =>
            array(
                'id' => 1557,
                'co_prrq_asap' => '03',
                'nombre' => 'GENERAL JUAN VICENTE GOMEZ',
                'municipio_id' => 132,
                'co_stat_data' => 'A',
            ),
            214 =>
            array(
                'id' => 1558,
                'co_prrq_asap' => '04',
                'nombre' => 'ISAIAS MEDINA ANGARITA',
                'municipio_id' => 132,
                'co_stat_data' => 'A',
            ),
            215 =>
            array(
                'id' => 1559,
                'co_prrq_asap' => '02',
                'nombre' => 'AMENODORO RANGEL LAMUS',
                'municipio_id' => 133,
                'co_stat_data' => 'A',
            ),
            216 =>
            array(
                'id' => 1615,
                'co_prrq_asap' => '01',
                'nombre' => 'CARDENAS',
                'municipio_id' => 133,
                'co_stat_data' => 'A',
            ),
            217 =>
            array(
                'id' => 1560,
                'co_prrq_asap' => '03',
                'nombre' => 'LA FLORIDA',
                'municipio_id' => 133,
                'co_stat_data' => 'A',
            ),
            218 =>
            array(
                'id' => 1561,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL CORDOBA',
                'municipio_id' => 134,
                'co_stat_data' => 'A',
            ),
            219 =>
            array(
                'id' => 1562,
                'co_prrq_asap' => '01',
                'nombre' => ' FERNANDEZ FEO',
                'municipio_id' => 135,
                'co_stat_data' => 'A',
            ),
            220 =>
            array(
                'id' => 1563,
                'co_prrq_asap' => '02',
                'nombre' => 'ALBERTO ADRIANI',
                'municipio_id' => 135,
                'co_stat_data' => 'A',
            ),
            221 =>
            array(
                'id' => 1564,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTO DOMINGO',
                'municipio_id' => 135,
                'co_stat_data' => 'A',
            ),
            222 =>
            array(
                'id' => 1565,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL FRANCISCO DE MIRANDA',
                'municipio_id' => 136,
                'co_stat_data' => 'A',
            ),
            223 =>
            array(
                'id' => 1567,
                'co_prrq_asap' => '02',
                'nombre' => 'BOCA DE GRITA',
                'municipio_id' => 137,
                'co_stat_data' => 'A',
            ),
            224 =>
            array(
                'id' => 1566,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL GARCIA DE HEVIA',
                'municipio_id' => 137,
                'co_stat_data' => 'A',
            ),
            225 =>
            array(
                'id' => 1568,
                'co_prrq_asap' => '03',
                'nombre' => 'JOSE ANTONIO PAEZ',
                'municipio_id' => 137,
                'co_stat_data' => 'A',
            ),
            226 =>
            array(
                'id' => 1569,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL GUASIMOS',
                'municipio_id' => 138,
                'co_stat_data' => 'A',
            ),
            227 =>
            array(
                'id' => 1570,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL INDEPENDENCIA',
                'municipio_id' => 139,
                'co_stat_data' => 'A',
            ),
            228 =>
            array(
                'id' => 1571,
                'co_prrq_asap' => '02',
                'nombre' => 'JUAN GERMAN ROSCIO',
                'municipio_id' => 139,
                'co_stat_data' => 'A',
            ),
            229 =>
            array(
                'id' => 1572,
                'co_prrq_asap' => '03',
                'nombre' => 'ROMAN CARDENAS',
                'municipio_id' => 139,
                'co_stat_data' => 'A',
            ),
            230 =>
            array(
                'id' => 1574,
                'co_prrq_asap' => '02',
                'nombre' => 'EMILIO CONSTANTINO GUERRERO',
                'municipio_id' => 140,
                'co_stat_data' => 'A',
            ),
            231 =>
            array(
                'id' => 1573,
                'co_prrq_asap' => '01',
                'nombre' => 'JAUREGUI',
                'municipio_id' => 140,
                'co_stat_data' => 'A',
            ),
            232 =>
            array(
                'id' => 1575,
                'co_prrq_asap' => '03',
                'nombre' => 'MONSEÑOR MIGUEL ANTONIO SALAS',
                'municipio_id' => 140,
                'co_stat_data' => 'A',
            ),
            233 =>
            array(
                'id' => 1576,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL JOSE MARIA VARGAS',
                'municipio_id' => 141,
                'co_stat_data' => 'A',
            ),
            234 =>
            array(
                'id' => 1580,
                'co_prrq_asap' => '04',
                'nombre' => 'BRAMON',
                'municipio_id' => 142,
                'co_stat_data' => 'A',
            ),
            235 =>
            array(
                'id' => 1577,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL JUNIN',
                'municipio_id' => 142,
                'co_stat_data' => 'A',
            ),
            236 =>
            array(
                'id' => 1578,
                'co_prrq_asap' => '02',
                'nombre' => 'LA PETROLIA',
                'municipio_id' => 142,
                'co_stat_data' => 'A',
            ),
            237 =>
            array(
                'id' => 1579,
                'co_prrq_asap' => '03',
                'nombre' => 'QUINIMARI',
                'municipio_id' => 142,
                'co_stat_data' => 'A',
            ),
            238 =>
            array(
                'id' => 1581,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL LIBERTAD',
                'municipio_id' => 143,
                'co_stat_data' => 'A',
            ),
            239 =>
            array(
                'id' => 1582,
                'co_prrq_asap' => '02',
                'nombre' => 'CIPRIANO CASTRO',
                'municipio_id' => 143,
                'co_stat_data' => 'A',
            ),
            240 =>
            array(
                'id' => 1583,
                'co_prrq_asap' => '03',
                'nombre' => 'MANUEL FELIPE RUGELES',
                'municipio_id' => 143,
                'co_stat_data' => 'A',
            ),
            241 =>
            array(
                'id' => 1586,
                'co_prrq_asap' => '03',
                'nombre' => 'DORADAS',
                'municipio_id' => 144,
                'co_stat_data' => 'A',
            ),
            242 =>
            array(
                'id' => 1585,
                'co_prrq_asap' => '02',
                'nombre' => 'EMETERIO OCHOA',
                'municipio_id' => 144,
                'co_stat_data' => 'A',
            ),
            243 =>
            array(
                'id' => 1584,
                'co_prrq_asap' => '01',
                'nombre' => 'LIBERTADOR',
                'municipio_id' => 144,
                'co_stat_data' => 'A',
            ),
            244 =>
            array(
                'id' => 1587,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN JOAQUIN DE NAVAY',
                'municipio_id' => 144,
                'co_stat_data' => 'A',
            ),
            245 =>
            array(
                'id' => 1589,
                'co_prrq_asap' => '02',
                'nombre' => 'CONSTITUCION',
                'municipio_id' => 145,
                'co_stat_data' => 'A',
            ),
            246 =>
            array(
                'id' => 1588,
                'co_prrq_asap' => '01',
                'nombre' => 'LOBATERA',
                'municipio_id' => 145,
                'co_stat_data' => 'A',
            ),
            247 =>
            array(
                'id' => 1590,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL MICHELENA',
                'municipio_id' => 146,
                'co_stat_data' => 'A',
            ),
            248 =>
            array(
                'id' => 1592,
                'co_prrq_asap' => '02',
                'nombre' => 'LA PALMITA',
                'municipio_id' => 147,
                'co_stat_data' => 'A',
            ),
            249 =>
            array(
                'id' => 1591,
                'co_prrq_asap' => '01',
                'nombre' => 'PANAMERICANO',
                'municipio_id' => 147,
                'co_stat_data' => 'A',
            ),
            250 =>
            array(
                'id' => 1594,
                'co_prrq_asap' => '02',
                'nombre' => 'NUEVA ARCADIA',
                'municipio_id' => 148,
                'co_stat_data' => 'A',
            ),
            251 =>
            array(
                'id' => 1593,
                'co_prrq_asap' => '01',
                'nombre' => 'PEDRO MARIA UREÑA',
                'municipio_id' => 148,
                'co_stat_data' => 'A',
            ),
            252 =>
            array(
                'id' => 1597,
                'co_prrq_asap' => '02',
                'nombre' => 'BOCONO',
                'municipio_id' => 149,
                'co_stat_data' => 'A',
            ),
            253 =>
            array(
                'id' => 1598,
                'co_prrq_asap' => '03',
                'nombre' => 'HERNANDEZ',
                'municipio_id' => 149,
                'co_stat_data' => 'A',
            ),
            254 =>
            array(
                'id' => 1596,
                'co_prrq_asap' => '01',
                'nombre' => 'SAMUEL DARIO MALDONADO',
                'municipio_id' => 149,
                'co_stat_data' => 'A',
            ),
            255 =>
            array(
                'id' => 1603,
                'co_prrq_asap' => '05',
                'nombre' => 'DR FRANCISCO ROMERO LOBO',
                'municipio_id' => 150,
                'co_stat_data' => 'A',
            ),
            256 =>
            array(
                'id' => 1599,
                'co_prrq_asap' => '01',
                'nombre' => 'LA CONCORDIA',
                'municipio_id' => 150,
                'co_stat_data' => 'A',
            ),
            257 =>
            array(
                'id' => 1600,
                'co_prrq_asap' => '02',
                'nombre' => 'PEDRO MARIA MORANTES',
                'municipio_id' => 150,
                'co_stat_data' => 'A',
            ),
            258 =>
            array(
                'id' => 1601,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN JUAN BAUTISTA',
                'municipio_id' => 150,
                'co_stat_data' => 'A',
            ),
            259 =>
            array(
                'id' => 1602,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN SEBASTIAN',
                'municipio_id' => 150,
                'co_stat_data' => 'A',
            ),
            260 =>
            array(
                'id' => 1604,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SEBORUCO',
                'municipio_id' => 151,
                'co_stat_data' => 'A',
            ),
            261 =>
            array(
                'id' => 1606,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SUCRE',
                'municipio_id' => 152,
                'co_stat_data' => 'A',
            ),
            262 =>
            array(
                'id' => 1607,
                'co_prrq_asap' => '02',
                'nombre' => 'ELEAZAR LOPEZ CONTRERAS',
                'municipio_id' => 152,
                'co_stat_data' => 'A',
            ),
            263 =>
            array(
                'id' => 1608,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN PABLO',
                'municipio_id' => 152,
                'co_stat_data' => 'A',
            ),
            264 =>
            array(
                'id' => 1610,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL URIBANTE',
                'municipio_id' => 153,
                'co_stat_data' => 'A',
            ),
            265 =>
            array(
                'id' => 1611,
                'co_prrq_asap' => '02',
                'nombre' => 'CARDENAS',
                'municipio_id' => 153,
                'co_stat_data' => 'A',
            ),
            266 =>
            array(
                'id' => 1612,
                'co_prrq_asap' => '03',
                'nombre' => 'JUAN PABLO PEÑALOZA',
                'municipio_id' => 153,
                'co_stat_data' => 'A',
            ),
            267 =>
            array(
                'id' => 1613,
                'co_prrq_asap' => '04',
                'nombre' => 'POTOSI',
                'municipio_id' => 153,
                'co_stat_data' => 'A',
            ),
            268 =>
            array(
                'id' => 1551,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ANTONIO ROMULO COSTA',
                'municipio_id' => 154,
                'co_stat_data' => 'A',
                'co_stat_old' => 'M',
                'fe_ini' => NULL,
            ),
            269 =>
            array(
                'id' => 1595,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL RAFAEL URDANETA',
                'municipio_id' => 155,
                'co_stat_data' => 'A',
            ),
            270 =>
            array(
                'id' => 1609,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL TORBES',
                'municipio_id' => 156,
                'co_stat_data' => 'A',
            ),
            271 =>
            array(
                'id' => 1614,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SAN JUDAS TADEO',
                'municipio_id' => 157,
                'co_stat_data' => 'A',
            ),
            272 =>
            array(
                'id' => 1605,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SIMON RODRIGUEZ',
                'municipio_id' => 158,
                'co_stat_data' => 'A',
            ),
            273 =>
            array(
                'id' => 1616,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL BOLIVAR',
                'municipio_id' => 159,
                'co_stat_data' => 'A',
            ),
            274 =>
            array(
                'id' => 1617,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL CAMATAGUA',
                'municipio_id' => 160,
                'co_stat_data' => 'A',
            ),
            275 =>
            array(
                'id' => 1618,
                'co_prrq_asap' => '02',
                'nombre' => 'NO UBNA CARMEN DE CURA',
                'municipio_id' => 160,
                'co_stat_data' => 'A',
            ),
            276 =>
            array(
                'id' => 1619,
                'co_prrq_asap' => '01',
                'nombre' => 'NO URBANA CHORONI',
                'municipio_id' => 161,
                'co_stat_data' => 'A',
            ),
            277 =>
            array(
                'id' => 1621,
                'co_prrq_asap' => '03',
                'nombre' => 'UBNA MADRE MARIA DE SAN JOSE',
                'municipio_id' => 161,
                'co_stat_data' => 'A',
            ),
            278 =>
            array(
                'id' => 1625,
                'co_prrq_asap' => '07',
                'nombre' => 'URBANA ANDRES ELOY BLANCO',
                'municipio_id' => 161,
                'co_stat_data' => 'A',
            ),
            279 =>
            array(
                'id' => 1622,
                'co_prrq_asap' => '04',
                'nombre' => 'URBANA JOAQUIN CRESPO',
                'municipio_id' => 161,
                'co_stat_data' => 'A',
            ),
            280 =>
            array(
                'id' => 1624,
                'co_prrq_asap' => '06',
                'nombre' => 'URBANA JOSE CASANOVA GODOY',
                'municipio_id' => 161,
                'co_stat_data' => 'A',
            ),
            281 =>
            array(
                'id' => 1620,
                'co_prrq_asap' => '02',
                'nombre' => 'URBANA LAS DELICIAS',
                'municipio_id' => 161,
                'co_stat_data' => 'A',
            ),
            282 =>
            array(
                'id' => 1663,
                'co_prrq_asap' => '08',
                'nombre' => 'URBANA LOS TACARIGUAS',
                'municipio_id' => 161,
                'co_stat_data' => 'A',
            ),
            283 =>
            array(
                'id' => 1623,
                'co_prrq_asap' => '05',
                'nombre' => 'URBANA PEDRO JOSE OVALLES',
                'municipio_id' => 161,
                'co_stat_data' => 'A',
            ),
            284 =>
            array(
                'id' => 1626,
                'co_prrq_asap' => '01',
                'nombre' => 'JOSE ANGEL LAMAS',
                'municipio_id' => 162,
                'co_stat_data' => 'A',
            ),
            285 =>
            array(
                'id' => 1627,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL JOSE FELIX RIBAS',
                'municipio_id' => 163,
                'co_stat_data' => 'A',
            ),
            286 =>
            array(
                'id' => 1628,
                'co_prrq_asap' => '02',
                'nombre' => 'CASTOR NIEVES RIOS',
                'municipio_id' => 163,
                'co_stat_data' => 'A',
            ),
            287 =>
            array(
                'id' => 1629,
                'co_prrq_asap' => '03',
                'nombre' => 'NO URBANA LAS GUACAMAYAS',
                'municipio_id' => 163,
                'co_stat_data' => 'A',
            ),
            288 =>
            array(
                'id' => 1630,
                'co_prrq_asap' => '04',
                'nombre' => 'NO URBANA PAO DE ZARATE',
                'municipio_id' => 163,
                'co_stat_data' => 'A',
            ),
            289 =>
            array(
                'id' => 1631,
                'co_prrq_asap' => '05',
                'nombre' => 'NO URBANA ZUATA',
                'municipio_id' => 163,
                'co_stat_data' => 'A',
            ),
            290 =>
            array(
                'id' => 1632,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL JOSE RAFAEL REVENGA',
                'municipio_id' => 164,
                'co_stat_data' => 'A',
            ),
            291 =>
            array(
                'id' => 1633,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL LIBERTADOR',
                'municipio_id' => 165,
                'co_stat_data' => 'A',
            ),
            292 =>
            array(
                'id' => 1634,
                'co_prrq_asap' => '02',
                'nombre' => 'NO URBANA SAN MARTIN DE PORRES',
                'municipio_id' => 165,
                'co_stat_data' => 'A',
            ),
            293 =>
            array(
                'id' => 1635,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL MARIO BRICEÑO IRAGORRY',
                'municipio_id' => 166,
                'co_stat_data' => 'A',
            ),
            294 =>
            array(
                'id' => 1636,
                'co_prrq_asap' => '02',
                'nombre' => 'CAÑA DE AZUCAR',
                'municipio_id' => 166,
                'co_stat_data' => 'A',
            ),
            295 =>
            array(
                'id' => 1638,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SAN CASIMIRO',
                'municipio_id' => 167,
                'co_stat_data' => 'A',
            ),
            296 =>
            array(
                'id' => 1639,
                'co_prrq_asap' => '02',
                'nombre' => 'NO URBANA GUIRIPA',
                'municipio_id' => 167,
                'co_stat_data' => 'A',
            ),
            297 =>
            array(
                'id' => 1640,
                'co_prrq_asap' => '03',
                'nombre' => 'NO URBANA OLLAS DE CARAMACATE',
                'municipio_id' => 167,
                'co_stat_data' => 'A',
            ),
            298 =>
            array(
                'id' => 1641,
                'co_prrq_asap' => '04',
                'nombre' => 'NO URBANA VALLE MORIN',
                'municipio_id' => 167,
                'co_stat_data' => 'A',
            ),
            299 =>
            array(
                'id' => 1642,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SAN SEBASTIAN',
                'municipio_id' => 168,
                'co_stat_data' => 'A',
            ),
            300 =>
            array(
                'id' => 1643,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SANTIAGO MARIÑO',
                'municipio_id' => 169,
                'co_stat_data' => 'A',
            ),
            301 =>
            array(
                'id' => 1647,
                'co_prrq_asap' => '05',
                'nombre' => 'NO UBNA ALFREDO PACHECO MIRANDA',
                'municipio_id' => 169,
                'co_stat_data' => 'A',
            ),
            302 =>
            array(
                'id' => 1644,
                'co_prrq_asap' => '02',
                'nombre' => 'NO URBANA AREVALO APONTE',
                'municipio_id' => 169,
                'co_stat_data' => 'A',
            ),
            303 =>
            array(
                'id' => 1645,
                'co_prrq_asap' => '03',
                'nombre' => 'NO URBANA CHUAO',
                'municipio_id' => 169,
                'co_stat_data' => 'A',
            ),
            304 =>
            array(
                'id' => 1646,
                'co_prrq_asap' => '04',
                'nombre' => 'NO URBANA SAMAN DE GUERE',
                'municipio_id' => 169,
                'co_stat_data' => 'A',
            ),
            305 =>
            array(
                'id' => 1648,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SANTOS MICHELENA',
                'municipio_id' => 170,
                'co_stat_data' => 'A',
            ),
            306 =>
            array(
                'id' => 1649,
                'co_prrq_asap' => '02',
                'nombre' => 'NO URBANA TIARA',
                'municipio_id' => 170,
                'co_stat_data' => 'A',
            ),
            307 =>
            array(
                'id' => 1650,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SUCRE',
                'municipio_id' => 171,
                'co_stat_data' => 'A',
            ),
            308 =>
            array(
                'id' => 1651,
                'co_prrq_asap' => '02',
                'nombre' => 'NO URBANA BELLA VISTA',
                'municipio_id' => 171,
                'co_stat_data' => 'A',
            ),
            309 =>
            array(
                'id' => 1652,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL TOVAR',
                'municipio_id' => 172,
                'co_stat_data' => 'A',
            ),
            310 =>
            array(
                'id' => 1655,
                'co_prrq_asap' => '04',
                'nombre' => ' NO URBANA TAGUAY',
                'municipio_id' => 173,
                'co_stat_data' => 'A',
            ),
            311 =>
            array(
                'id' => 1653,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL URDANETA',
                'municipio_id' => 173,
                'co_stat_data' => 'A',
            ),
            312 =>
            array(
                'id' => 1654,
                'co_prrq_asap' => '02',
                'nombre' => 'NO URBANA LAS PEÑITAS',
                'municipio_id' => 173,
                'co_stat_data' => 'A',
            ),
            313 =>
            array(
                'id' => 1664,
                'co_prrq_asap' => '03',
                'nombre' => 'NO URBANA SAN FRANCISCO DE CARA',
                'municipio_id' => 173,
                'co_stat_data' => 'A',
            ),
            314 =>
            array(
                'id' => 1656,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ZAMORA',
                'municipio_id' => 174,
                'co_stat_data' => 'A',
            ),
            315 =>
            array(
                'id' => 1659,
                'co_prrq_asap' => '05',
                'nombre' => 'NO URBANA AUGUSTO MIJARES',
                'municipio_id' => 174,
                'co_stat_data' => 'A',
            ),
            316 =>
            array(
                'id' => 1657,
                'co_prrq_asap' => '02',
                'nombre' => 'NO URBANA MAGDALENO',
                'municipio_id' => 174,
                'co_stat_data' => 'A',
            ),
            317 =>
            array(
                'id' => 1665,
                'co_prrq_asap' => '03',
                'nombre' => 'NO URBANA SAN FRANCISCO DE ASIS',
                'municipio_id' => 174,
                'co_stat_data' => 'A',
            ),
            318 =>
            array(
                'id' => 1658,
                'co_prrq_asap' => '04',
                'nombre' => 'NO URBANA VALLES DE TUCUTUNEMO',
                'municipio_id' => 174,
                'co_stat_data' => 'A',
            ),
            319 =>
            array(
                'id' => 1660,
                'co_prrq_asap' => '01',
                'nombre' => 'CAP FRANCISCO LINARES ALCANTARA',
                'municipio_id' => 175,
                'co_stat_data' => 'A',
            ),
            320 =>
            array(
                'id' => 1661,
                'co_prrq_asap' => '02',
                'nombre' => 'NO UBNA FRANCISCO DE MIRANDA',
                'municipio_id' => 175,
                'co_stat_data' => 'A',
            ),
            321 =>
            array(
                'id' => 1662,
                'co_prrq_asap' => '03',
                'nombre' => 'NO UBNA MONSEÑOR FELICIANO GONZALEZ',
                'municipio_id' => 175,
                'co_stat_data' => 'A',
            ),
            322 =>
            array(
                'id' => 1666,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ACOSTA',
                'municipio_id' => 176,
                'co_stat_data' => 'A',
            ),
            323 =>
            array(
                'id' => 1667,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN FRANCISCO',
                'municipio_id' => 176,
                'co_stat_data' => 'A',
            ),
            324 =>
            array(
                'id' => 1668,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL AGUASAY',
                'municipio_id' => 177,
                'co_stat_data' => 'A',
            ),
            325 =>
            array(
                'id' => 1669,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL BOLIVAR',
                'municipio_id' => 178,
                'co_stat_data' => 'A',
            ),
            326 =>
            array(
                'id' => 1670,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL CARIPE',
                'municipio_id' => 179,
                'co_stat_data' => 'A',
            ),
            327 =>
            array(
                'id' => 1671,
                'co_prrq_asap' => '02',
                'nombre' => 'EL GUACHARO',
                'municipio_id' => 179,
                'co_stat_data' => 'A',
            ),
            328 =>
            array(
                'id' => 1672,
                'co_prrq_asap' => '03',
                'nombre' => 'LA GUANOTA',
                'municipio_id' => 179,
                'co_stat_data' => 'A',
            ),
            329 =>
            array(
                'id' => 1673,
                'co_prrq_asap' => '04',
                'nombre' => 'SABANA DE PIEDRA',
                'municipio_id' => 179,
                'co_stat_data' => 'A',
            ),
            330 =>
            array(
                'id' => 1674,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN AGUSTIN',
                'municipio_id' => 179,
                'co_stat_data' => 'A',
            ),
            331 =>
            array(
                'id' => 1675,
                'co_prrq_asap' => '06',
                'nombre' => 'TERESEN',
                'municipio_id' => 179,
                'co_stat_data' => 'A',
            ),
            332 =>
            array(
                'id' => 1677,
                'co_prrq_asap' => '02',
                'nombre' => 'AREO',
                'municipio_id' => 180,
                'co_stat_data' => 'A',
            ),
            333 =>
            array(
                'id' => 1676,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL CEDEÑO',
                'municipio_id' => 180,
                'co_stat_data' => 'A',
            ),
            334 =>
            array(
                'id' => 1678,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN FELIX',
                'municipio_id' => 180,
                'co_stat_data' => 'A',
            ),
            335 =>
            array(
                'id' => 1679,
                'co_prrq_asap' => '04',
                'nombre' => 'VIENTO FRESCO',
                'municipio_id' => 180,
                'co_stat_data' => 'A',
            ),
            336 =>
            array(
                'id' => 1680,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL EZEQUIEL ZAMORA',
                'municipio_id' => 181,
                'co_stat_data' => 'A',
            ),
            337 =>
            array(
                'id' => 1681,
                'co_prrq_asap' => '02',
                'nombre' => 'EL TEJERO',
                'municipio_id' => 181,
                'co_stat_data' => 'A',
            ),
            338 =>
            array(
                'id' => 1682,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL LIBERTADOR',
                'municipio_id' => 182,
                'co_stat_data' => 'A',
            ),
            339 =>
            array(
                'id' => 1683,
                'co_prrq_asap' => '02',
                'nombre' => 'CHAGUARAMAS',
                'municipio_id' => 182,
                'co_stat_data' => 'A',
            ),
            340 =>
            array(
                'id' => 1684,
                'co_prrq_asap' => '03',
                'nombre' => 'LAS ALHUACAS',
                'municipio_id' => 182,
                'co_stat_data' => 'A',
            ),
            341 =>
            array(
                'id' => 1685,
                'co_prrq_asap' => '04',
                'nombre' => 'TABASCA',
                'municipio_id' => 182,
                'co_stat_data' => 'A',
            ),
            342 =>
            array(
                'id' => 1687,
                'co_prrq_asap' => '02',
                'nombre' => 'ALTO DE LOS GODOS',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            343 =>
            array(
                'id' => 1688,
                'co_prrq_asap' => '03',
                'nombre' => 'BOQUERON',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            344 =>
            array(
                'id' => 1686,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL MATURIN',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            345 =>
            array(
                'id' => 1692,
                'co_prrq_asap' => '07',
                'nombre' => 'EL COROZO',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            346 =>
            array(
                'id' => 1693,
                'co_prrq_asap' => '08',
                'nombre' => 'EL FURRIAL',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            347 =>
            array(
                'id' => 1694,
                'co_prrq_asap' => '09',
                'nombre' => 'JUSEPIN',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            348 =>
            array(
                'id' => 1695,
                'co_prrq_asap' => '10',
                'nombre' => 'LA PICA',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            349 =>
            array(
                'id' => 1689,
                'co_prrq_asap' => '04',
                'nombre' => 'LAS COCUIZAS',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            350 =>
            array(
                'id' => 1690,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN SIMON',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            351 =>
            array(
                'id' => 1696,
                'co_prrq_asap' => '11',
                'nombre' => 'SAN VICENTE',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            352 =>
            array(
                'id' => 1691,
                'co_prrq_asap' => '06',
                'nombre' => 'SANTA CRUZ',
                'municipio_id' => 183,
                'co_stat_data' => 'A',
            ),
            353 =>
            array(
                'id' => 1698,
                'co_prrq_asap' => '02',
                'nombre' => 'APARICIO',
                'municipio_id' => 184,
                'co_stat_data' => 'A',
            ),
            354 =>
            array(
                'id' => 1697,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PIAR',
                'municipio_id' => 184,
                'co_stat_data' => 'A',
            ),
            355 =>
            array(
                'id' => 1699,
                'co_prrq_asap' => '03',
                'nombre' => 'CHAGUARAMAL',
                'municipio_id' => 184,
                'co_stat_data' => 'A',
            ),
            356 =>
            array(
                'id' => 1700,
                'co_prrq_asap' => '04',
                'nombre' => 'EL PINTO',
                'municipio_id' => 184,
                'co_stat_data' => 'A',
            ),
            357 =>
            array(
                'id' => 1701,
                'co_prrq_asap' => '05',
                'nombre' => 'GUANAGUANA',
                'municipio_id' => 184,
                'co_stat_data' => 'A',
            ),
            358 =>
            array(
                'id' => 1702,
                'co_prrq_asap' => '06',
                'nombre' => 'LA TOSCANA',
                'municipio_id' => 184,
                'co_stat_data' => 'A',
            ),
            359 =>
            array(
                'id' => 1703,
                'co_prrq_asap' => '07',
                'nombre' => 'TAGUAYA',
                'municipio_id' => 184,
                'co_stat_data' => 'A',
            ),
            360 =>
            array(
                'id' => 1705,
                'co_prrq_asap' => '02',
                'nombre' => 'CACHIPO',
                'municipio_id' => 185,
                'co_stat_data' => 'A',
            ),
            361 =>
            array(
                'id' => 1704,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PUNCERES',
                'municipio_id' => 185,
                'co_stat_data' => 'A',
            ),
            362 =>
            array(
                'id' => 1706,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SANTA BARBARA',
                'municipio_id' => 186,
                'co_stat_data' => 'A',
            ),
            363 =>
            array(
                'id' => 1707,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SOTILLO',
                'municipio_id' => 187,
                'co_stat_data' => 'A',
            ),
            364 =>
            array(
                'id' => 1708,
                'co_prrq_asap' => '02',
                'nombre' => 'LOS BARRANCOS DE FAJARDO',
                'municipio_id' => 187,
                'co_stat_data' => 'A',
            ),
            365 =>
            array(
                'id' => 1709,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL URACOA',
                'municipio_id' => 188,
                'co_stat_data' => 'A',
            ),
            366 =>
            array(
                'id' => 1756,
                'co_prrq_asap' => '01',
                'nombre' => 'PIO TAMAYO',
                'municipio_id' => 189,
                'co_stat_data' => 'A',
            ),
            367 =>
            array(
                'id' => 1710,
                'co_prrq_asap' => '02',
                'nombre' => 'QUEBRADA HONDA DE GUACHE',
                'municipio_id' => 189,
                'co_stat_data' => 'A',
            ),
            368 =>
            array(
                'id' => 1711,
                'co_prrq_asap' => '03',
                'nombre' => 'YACAMBU',
                'municipio_id' => 189,
                'co_stat_data' => 'A',
            ),
            369 =>
            array(
                'id' => 1757,
                'co_prrq_asap' => '01',
                'nombre' => 'FREITEZ',
                'municipio_id' => 190,
                'co_stat_data' => 'A',
            ),
            370 =>
            array(
                'id' => 1712,
                'co_prrq_asap' => '02',
                'nombre' => 'JOSE MARIA BLANCO',
                'municipio_id' => 190,
                'co_stat_data' => 'A',
            ),
            371 =>
            array(
                'id' => 1720,
                'co_prrq_asap' => '08',
                'nombre' => 'AGUEDO FELIPE ALVARADO',
                'municipio_id' => 191,
                'co_stat_data' => 'A',
            ),
            372 =>
            array(
                'id' => 1721,
                'co_prrq_asap' => '09',
                'nombre' => 'BUENA VISTA',
                'municipio_id' => 191,
                'co_stat_data' => 'A',
            ),
            373 =>
            array(
                'id' => 1713,
                'co_prrq_asap' => '01',
                'nombre' => 'CATEDRAL',
                'municipio_id' => 191,
                'co_stat_data' => 'A',
            ),
            374 =>
            array(
                'id' => 1714,
                'co_prrq_asap' => '02',
                'nombre' => 'CONCEPCION',
                'municipio_id' => 191,
                'co_stat_data' => 'A',
            ),
            375 =>
            array(
                'id' => 1715,
                'co_prrq_asap' => '03',
                'nombre' => 'EL CUJI',
                'municipio_id' => 191,
                'co_stat_data' => 'A',
            ),
            376 =>
            array(
                'id' => 1716,
                'co_prrq_asap' => '04',
                'nombre' => 'JUAN DE VILLEGAS',
                'municipio_id' => 191,
                'co_stat_data' => 'A',
            ),
            377 =>
            array(
                'id' => 1722,
                'co_prrq_asap' => '10',
                'nombre' => 'JUAREZ',
                'municipio_id' => 191,
                'co_stat_data' => 'A',
            ),
            378 =>
            array(
                'id' => 1717,
                'co_prrq_asap' => '05',
                'nombre' => 'SANTA ROSA',
                'municipio_id' => 191,
                'co_stat_data' => 'A',
            ),
            379 =>
            array(
                'id' => 1718,
                'co_prrq_asap' => '06',
                'nombre' => 'TAMACA',
                'municipio_id' => 191,
                'co_stat_data' => 'A',
            ),
            380 =>
            array(
                'id' => 1719,
                'co_prrq_asap' => '07',
                'nombre' => 'UNION',
                'municipio_id' => 191,
                'co_stat_data' => 'A',
            ),
            381 =>
            array(
                'id' => 1934,
                'co_prrq_asap' => '08',
                'nombre' => 'CORONEL MARIANO PERAZA',
                'municipio_id' => 192,
                'co_stat_data' => 'A',
            ),
            382 =>
            array(
                'id' => 1724,
                'co_prrq_asap' => '02',
                'nombre' => 'CUARA',
                'municipio_id' => 192,
                'co_stat_data' => 'A',
            ),
            383 =>
            array(
                'id' => 1725,
                'co_prrq_asap' => '03',
                'nombre' => 'DIEGO DE LOZADA',
                'municipio_id' => 192,
                'co_stat_data' => 'A',
            ),
            384 =>
            array(
                'id' => 1933,
                'co_prrq_asap' => '07',
                'nombre' => 'JOSE BERNARDO DORANTE',
                'municipio_id' => 192,
                'co_stat_data' => 'A',
            ),
            385 =>
            array(
                'id' => 1723,
                'co_prrq_asap' => '01',
                'nombre' => 'JUAN BAUTISTA RODRIGUEZ',
                'municipio_id' => 192,
                'co_stat_data' => 'A',
            ),
            386 =>
            array(
                'id' => 1726,
                'co_prrq_asap' => '04',
                'nombre' => 'PARAISO DE SAN JOSE',
                'municipio_id' => 192,
                'co_stat_data' => 'A',
            ),
            387 =>
            array(
                'id' => 1727,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN MIGUEL',
                'municipio_id' => 192,
                'co_stat_data' => 'A',
            ),
            388 =>
            array(
                'id' => 1932,
                'co_prrq_asap' => '06',
                'nombre' => 'TINTORERO',
                'municipio_id' => 192,
                'co_stat_data' => 'A',
            ),
            389 =>
            array(
                'id' => 1729,
                'co_prrq_asap' => '02',
                'nombre' => 'ANZOATEGUI',
                'municipio_id' => 193,
                'co_stat_data' => 'A',
            ),
            390 =>
            array(
                'id' => 1728,
                'co_prrq_asap' => '01',
                'nombre' => 'BOLIVAR',
                'municipio_id' => 193,
                'co_stat_data' => 'A',
            ),
            391 =>
            array(
                'id' => 1730,
                'co_prrq_asap' => '03',
                'nombre' => 'GUARICO',
                'municipio_id' => 193,
                'co_stat_data' => 'A',
            ),
            392 =>
            array(
                'id' => 1731,
                'co_prrq_asap' => '04',
                'nombre' => 'HILARIO LUNA Y LUNA',
                'municipio_id' => 193,
                'co_stat_data' => 'A',
            ),
            393 =>
            array(
                'id' => 1732,
                'co_prrq_asap' => '05',
                'nombre' => 'HUMOCARO ALTO',
                'municipio_id' => 193,
                'co_stat_data' => 'A',
            ),
            394 =>
            array(
                'id' => 1758,
                'co_prrq_asap' => '06',
                'nombre' => 'HUMOCARO BAJO',
                'municipio_id' => 193,
                'co_stat_data' => 'A',
            ),
            395 =>
            array(
                'id' => 1733,
                'co_prrq_asap' => '07',
                'nombre' => 'LA CANDELARIA',
                'municipio_id' => 193,
                'co_stat_data' => 'A',
            ),
            396 =>
            array(
                'id' => 1734,
                'co_prrq_asap' => '08',
                'nombre' => 'MORAN',
                'municipio_id' => 193,
                'co_stat_data' => 'A',
            ),
            397 =>
            array(
                'id' => 1935,
                'co_prrq_asap' => '03',
                'nombre' => 'AGUA VIVA',
                'municipio_id' => 194,
                'co_stat_data' => 'A',
            ),
            398 =>
            array(
                'id' => 1735,
                'co_prrq_asap' => '01',
                'nombre' => 'CABUDARE',
                'municipio_id' => 194,
                'co_stat_data' => 'A',
            ),
            399 =>
            array(
                'id' => 1736,
                'co_prrq_asap' => '02',
                'nombre' => 'JOSE GREGORIO BASTIDAS',
                'municipio_id' => 194,
                'co_stat_data' => 'A',
            ),
            400 =>
            array(
                'id' => 1738,
                'co_prrq_asap' => '02',
                'nombre' => 'BURIA',
                'municipio_id' => 195,
                'co_stat_data' => 'A',
            ),
            401 =>
            array(
                'id' => 1759,
                'co_prrq_asap' => '03',
                'nombre' => 'GUSTAVO VEGAS LEON',
                'municipio_id' => 195,
                'co_stat_data' => 'A',
            ),
            402 =>
            array(
                'id' => 1737,
                'co_prrq_asap' => '01',
                'nombre' => 'SARARE',
                'municipio_id' => 195,
                'co_stat_data' => 'A',
            ),
            403 =>
            array(
                'id' => 1943,
                'co_prrq_asap' => '17',
                'nombre' => 'ALTAGRACIA',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            404 =>
            array(
                'id' => 1740,
                'co_prrq_asap' => '02',
                'nombre' => 'ANTONIO DIAZ',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            405 =>
            array(
                'id' => 1760,
                'co_prrq_asap' => '03',
                'nombre' => 'CAMACARO',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            406 =>
            array(
                'id' => 1741,
                'co_prrq_asap' => '04',
                'nombre' => 'CASTAÑEDA',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            407 =>
            array(
                'id' => 1742,
                'co_prrq_asap' => '05',
                'nombre' => 'CECILIO ZUBILLAGA',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            408 =>
            array(
                'id' => 1743,
                'co_prrq_asap' => '06',
                'nombre' => 'CHIQUINQUIRA',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            409 =>
            array(
                'id' => 1744,
                'co_prrq_asap' => '07',
                'nombre' => 'EL BLANCO',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            410 =>
            array(
                'id' => 1745,
                'co_prrq_asap' => '08',
                'nombre' => 'ESPINOZA DE LOS MONTEROS',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            411 =>
            array(
                'id' => 1938,
                'co_prrq_asap' => '15',
                'nombre' => 'HERIBERTO ARROYO',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            412 =>
            array(
                'id' => 1746,
                'co_prrq_asap' => '09',
                'nombre' => 'LARA',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            413 =>
            array(
                'id' => 1747,
                'co_prrq_asap' => '10',
                'nombre' => 'LAS MERCEDES',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            414 =>
            array(
                'id' => 1748,
                'co_prrq_asap' => '11',
                'nombre' => 'MANUEL MORILLO',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            415 =>
            array(
                'id' => 1749,
                'co_prrq_asap' => '12',
                'nombre' => 'MONTAÑA VERDE',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            416 =>
            array(
                'id' => 1750,
                'co_prrq_asap' => '13',
                'nombre' => 'MONTES DE OCA',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            417 =>
            array(
                'id' => 1941,
                'co_prrq_asap' => '16',
                'nombre' => 'REYES VARGAS',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            418 =>
            array(
                'id' => 1751,
                'co_prrq_asap' => '14',
                'nombre' => 'TORRES',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            419 =>
            array(
                'id' => 1739,
                'co_prrq_asap' => '01',
                'nombre' => 'TRINIDAD SAMUEL',
                'municipio_id' => 196,
                'co_stat_data' => 'A',
            ),
            420 =>
            array(
                'id' => 1753,
                'co_prrq_asap' => '02',
                'nombre' => 'MOROTURO',
                'municipio_id' => 197,
                'co_stat_data' => 'A',
            ),
            421 =>
            array(
                'id' => 1754,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN MIGUEL',
                'municipio_id' => 197,
                'co_stat_data' => 'A',
            ),
            422 =>
            array(
                'id' => 1752,
                'co_prrq_asap' => '01',
                'nombre' => 'SIQUISIQUE',
                'municipio_id' => 197,
                'co_stat_data' => 'A',
            ),
            423 =>
            array(
                'id' => 1755,
                'co_prrq_asap' => '04',
                'nombre' => 'XAGUAS',
                'municipio_id' => 197,
                'co_stat_data' => 'A',
            ),
            424 =>
            array(
                'id' => 1761,
                'co_prrq_asap' => '01',
                'nombre' => 'CACHAMAY',
                'municipio_id' => 198,
                'co_stat_data' => 'A',
            ),
            425 =>
            array(
                'id' => 1762,
                'co_prrq_asap' => '02',
                'nombre' => 'CHIRICA',
                'municipio_id' => 198,
                'co_stat_data' => 'A',
            ),
            426 =>
            array(
                'id' => 1763,
                'co_prrq_asap' => '03',
                'nombre' => 'DALLA COSTA',
                'municipio_id' => 198,
                'co_stat_data' => 'A',
            ),
            427 =>
            array(
                'id' => 1764,
                'co_prrq_asap' => '04',
                'nombre' => 'ONCE DE ABRIL',
                'municipio_id' => 198,
                'co_stat_data' => 'A',
            ),
            428 =>
            array(
                'id' => 1769,
                'co_prrq_asap' => '09',
                'nombre' => 'POZO VERDE',
                'municipio_id' => 198,
                'co_stat_data' => 'A',
            ),
            429 =>
            array(
                'id' => 1765,
                'co_prrq_asap' => '05',
                'nombre' => 'SIMON BOLIVAR',
                'municipio_id' => 198,
                'co_stat_data' => 'A',
            ),
            430 =>
            array(
                'id' => 1766,
                'co_prrq_asap' => '06',
                'nombre' => 'UNARE',
                'municipio_id' => 198,
                'co_stat_data' => 'A',
            ),
            431 =>
            array(
                'id' => 1767,
                'co_prrq_asap' => '07',
                'nombre' => 'UNIVERSIDAD',
                'municipio_id' => 198,
                'co_stat_data' => 'A',
            ),
            432 =>
            array(
                'id' => 1768,
                'co_prrq_asap' => '08',
                'nombre' => 'VISTA AL SOL',
                'municipio_id' => 198,
                'co_stat_data' => 'A',
            ),
            433 =>
            array(
                'id' => 1770,
                'co_prrq_asap' => '10',
                'nombre' => 'YOCOIMA',
                'municipio_id' => 198,
                'co_stat_data' => 'A',
            ),
            434 =>
            array(
                'id' => 1805,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL EL CALLAO',
                'municipio_id' => 199,
                'co_stat_data' => 'A',
            ),
            435 =>
            array(
                'id' => 1806,
                'co_prrq_asap' => '02',
                'nombre' => 'IKABARU',
                'municipio_id' => 200,
                'co_stat_data' => 'A',
            ),
            436 =>
            array(
                'id' => 1777,
                'co_prrq_asap' => '01',
                'nombre' => 'SECCION CAPITAL GRAN SABANA',
                'municipio_id' => 200,
                'co_stat_data' => 'A',
            ),
            437 =>
            array(
                'id' => 1778,
                'co_prrq_asap' => '01',
                'nombre' => 'AGUA SALADA',
                'municipio_id' => 201,
                'co_stat_data' => 'A',
            ),
            438 =>
            array(
                'id' => 1779,
                'co_prrq_asap' => '02',
                'nombre' => 'CATEDRAL',
                'municipio_id' => 201,
                'co_stat_data' => 'A',
            ),
            439 =>
            array(
                'id' => 1780,
                'co_prrq_asap' => '03',
                'nombre' => 'JOSE ANTONIO PAEZ',
                'municipio_id' => 201,
                'co_stat_data' => 'A',
            ),
            440 =>
            array(
                'id' => 1781,
                'co_prrq_asap' => '04',
                'nombre' => 'LA SABANITA',
                'municipio_id' => 201,
                'co_stat_data' => 'A',
            ),
            441 =>
            array(
                'id' => 1782,
                'co_prrq_asap' => '05',
                'nombre' => 'MARHUANTA',
                'municipio_id' => 201,
                'co_stat_data' => 'A',
            ),
            442 =>
            array(
                'id' => 1784,
                'co_prrq_asap' => '07',
                'nombre' => 'ORINOCO',
                'municipio_id' => 201,
                'co_stat_data' => 'A',
            ),
            443 =>
            array(
                'id' => 1785,
                'co_prrq_asap' => '08',
                'nombre' => 'PANAPANA',
                'municipio_id' => 201,
                'co_stat_data' => 'A',
            ),
            444 =>
            array(
                'id' => 1783,
                'co_prrq_asap' => '06',
                'nombre' => 'VISTA HERMOSA',
                'municipio_id' => 201,
                'co_stat_data' => 'A',
            ),
            445 =>
            array(
                'id' => 1786,
                'co_prrq_asap' => '09',
                'nombre' => 'ZEA',
                'municipio_id' => 201,
                'co_stat_data' => 'A',
            ),
            446 =>
            array(
                'id' => 1788,
                'co_prrq_asap' => '02',
                'nombre' => 'ANDRES ELOY BLANCO',
                'municipio_id' => 202,
                'co_stat_data' => 'A',
            ),
            447 =>
            array(
                'id' => 1787,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PIAR',
                'municipio_id' => 202,
                'co_stat_data' => 'A',
            ),
            448 =>
            array(
                'id' => 1789,
                'co_prrq_asap' => '03',
                'nombre' => 'PEDRO COVA',
                'municipio_id' => 202,
                'co_stat_data' => 'A',
            ),
            449 =>
            array(
                'id' => 1791,
                'co_prrq_asap' => '02',
                'nombre' => 'BARCELONETA',
                'municipio_id' => 203,
                'co_stat_data' => 'A',
            ),
            450 =>
            array(
                'id' => 1790,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL RIO LEONI',
                'municipio_id' => 203,
                'co_stat_data' => 'A',
            ),
            451 =>
            array(
                'id' => 1792,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN FRANCISCO',
                'municipio_id' => 203,
                'co_stat_data' => 'A',
            ),
            452 =>
            array(
                'id' => 1793,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA BARBARA',
                'municipio_id' => 203,
                'co_stat_data' => 'A',
            ),
            453 =>
            array(
                'id' => 1796,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SIFONTES',
                'municipio_id' => 204,
                'co_stat_data' => 'A',
            ),
            454 =>
            array(
                'id' => 1797,
                'co_prrq_asap' => '02',
                'nombre' => 'DALLA COSTA',
                'municipio_id' => 204,
                'co_stat_data' => 'A',
            ),
            455 =>
            array(
                'id' => 1798,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN ISIDRO',
                'municipio_id' => 204,
                'co_stat_data' => 'A',
            ),
            456 =>
            array(
                'id' => 1804,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PADRE PEDRO CHIEN',
                'municipio_id' => 205,
                'co_stat_data' => 'A',
            ),
            457 =>
            array(
                'id' => 1772,
                'co_prrq_asap' => '02',
                'nombre' => 'ALTAGRACIA',
                'municipio_id' => 206,
                'co_stat_data' => 'A',
            ),
            458 =>
            array(
                'id' => 1773,
                'co_prrq_asap' => '03',
                'nombre' => 'ASCENCION FARRERAS',
                'municipio_id' => 206,
                'co_stat_data' => 'A',
            ),
            459 =>
            array(
                'id' => 1774,
                'co_prrq_asap' => '04',
                'nombre' => 'GUANIAMO',
                'municipio_id' => 206,
                'co_stat_data' => 'A',
            ),
            460 =>
            array(
                'id' => 1775,
                'co_prrq_asap' => '05',
                'nombre' => 'LA URBANA',
                'municipio_id' => 206,
                'co_stat_data' => 'A',
            ),
            461 =>
            array(
                'id' => 1776,
                'co_prrq_asap' => '06',
                'nombre' => 'PIJIGUAOS',
                'municipio_id' => 206,
                'co_stat_data' => 'A',
            ),
            462 =>
            array(
                'id' => 1771,
                'co_prrq_asap' => '01',
                'nombre' => 'SECCION CAPITAL CEDEÑO',
                'municipio_id' => 206,
                'co_stat_data' => 'A',
            ),
            463 =>
            array(
                'id' => 1794,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ROSCIO',
                'municipio_id' => 207,
                'co_stat_data' => 'A',
            ),
            464 =>
            array(
                'id' => 1795,
                'co_prrq_asap' => '02',
                'nombre' => 'SALOM',
                'municipio_id' => 207,
                'co_stat_data' => 'A',
            ),
            465 =>
            array(
                'id' => 1800,
                'co_prrq_asap' => '02',
                'nombre' => 'ARIPAO',
                'municipio_id' => 208,
                'co_stat_data' => 'A',
            ),
            466 =>
            array(
                'id' => 1799,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SUCRE',
                'municipio_id' => 208,
                'co_stat_data' => 'A',
            ),
            467 =>
            array(
                'id' => 1801,
                'co_prrq_asap' => '03',
                'nombre' => 'GUARATARO',
                'municipio_id' => 208,
                'co_stat_data' => 'A',
            ),
            468 =>
            array(
                'id' => 1802,
                'co_prrq_asap' => '04',
                'nombre' => 'LAS MAJADAS',
                'municipio_id' => 208,
                'co_stat_data' => 'A',
            ),
            469 =>
            array(
                'id' => 1803,
                'co_prrq_asap' => '05',
                'nombre' => 'MOITACO',
                'municipio_id' => 208,
                'co_stat_data' => 'A',
            ),
            470 =>
            array(
                'id' => 1808,
                'co_prrq_asap' => '02',
                'nombre' => 'NO URBANA CANOABO',
                'municipio_id' => 209,
                'co_stat_data' => 'A',
            ),
            471 =>
            array(
                'id' => 1809,
                'co_prrq_asap' => '03',
                'nombre' => 'NO URBANA SIMON BOLIVAR',
                'municipio_id' => 209,
                'co_stat_data' => 'A',
            ),
            472 =>
            array(
                'id' => 1807,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA BEJUMA',
                'municipio_id' => 209,
                'co_stat_data' => 'A',
            ),
            473 =>
            array(
                'id' => 1811,
                'co_prrq_asap' => '02',
                'nombre' => 'NO URBANA BELEN',
                'municipio_id' => 210,
                'co_stat_data' => 'A',
            ),
            474 =>
            array(
                'id' => 1812,
                'co_prrq_asap' => '03',
                'nombre' => 'NO URBANA TACARIGUA',
                'municipio_id' => 210,
                'co_stat_data' => 'A',
            ),
            475 =>
            array(
                'id' => 1810,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA GUIGUE',
                'municipio_id' => 210,
                'co_stat_data' => 'A',
            ),
            476 =>
            array(
                'id' => 1813,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA AGUAS CALIENTES',
                'municipio_id' => 211,
                'co_stat_data' => 'A',
            ),
            477 =>
            array(
                'id' => 1814,
                'co_prrq_asap' => '02',
                'nombre' => 'URBANA MARIARA',
                'municipio_id' => 211,
                'co_stat_data' => 'A',
            ),
            478 =>
            array(
                'id' => 1817,
                'co_prrq_asap' => '03',
                'nombre' => 'NO URBANA YAGUA',
                'municipio_id' => 212,
                'co_stat_data' => 'A',
            ),
            479 =>
            array(
                'id' => 1815,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA CIUDAD ALIANZA',
                'municipio_id' => 212,
                'co_stat_data' => 'A',
            ),
            480 =>
            array(
                'id' => 1816,
                'co_prrq_asap' => '02',
                'nombre' => 'URBANA GUACARA',
                'municipio_id' => 212,
                'co_stat_data' => 'A',
            ),
            481 =>
            array(
                'id' => 1819,
                'co_prrq_asap' => '02',
                'nombre' => 'NO URBANA URAMA',
                'municipio_id' => 213,
                'co_stat_data' => 'A',
            ),
            482 =>
            array(
                'id' => 1818,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA MORON',
                'municipio_id' => 213,
                'co_stat_data' => 'A',
            ),
            483 =>
            array(
                'id' => 1822,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA MIRANDA',
                'municipio_id' => 214,
                'co_stat_data' => 'A',
            ),
            484 =>
            array(
                'id' => 1823,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA MONTALBAN',
                'municipio_id' => 215,
                'co_stat_data' => 'A',
            ),
            485 =>
            array(
                'id' => 1830,
                'co_prrq_asap' => '07',
                'nombre' => 'NO URBANA BORBURATA',
                'municipio_id' => 216,
                'co_stat_data' => 'A',
            ),
            486 =>
            array(
                'id' => 1831,
                'co_prrq_asap' => '08',
                'nombre' => 'NO URBANA PATANEMO',
                'municipio_id' => 216,
                'co_stat_data' => 'A',
            ),
            487 =>
            array(
                'id' => 1825,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA BARTOLOME SALOM',
                'municipio_id' => 216,
                'co_stat_data' => 'A',
            ),
            488 =>
            array(
                'id' => 1826,
                'co_prrq_asap' => '02',
                'nombre' => 'URBANA DEMOCRACIA',
                'municipio_id' => 216,
                'co_stat_data' => 'A',
            ),
            489 =>
            array(
                'id' => 1843,
                'co_prrq_asap' => '03',
                'nombre' => 'URBANA FRATERNIDAD',
                'municipio_id' => 216,
                'co_stat_data' => 'A',
            ),
            490 =>
            array(
                'id' => 1827,
                'co_prrq_asap' => '04',
                'nombre' => 'URBANA GOAIGOAZA',
                'municipio_id' => 216,
                'co_stat_data' => 'A',
            ),
            491 =>
            array(
                'id' => 1828,
                'co_prrq_asap' => '05',
                'nombre' => 'URBANA JUAN JOSE FLORES',
                'municipio_id' => 216,
                'co_stat_data' => 'A',
            ),
            492 =>
            array(
                'id' => 1829,
                'co_prrq_asap' => '06',
                'nombre' => 'URBANA UNION',
                'municipio_id' => 216,
                'co_stat_data' => 'A',
            ),
            493 =>
            array(
                'id' => 1833,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA SAN JOAQUIN',
                'municipio_id' => 217,
                'co_stat_data' => 'A',
            ),
            494 =>
            array(
                'id' => 1821,
                'co_prrq_asap' => '02',
                'nombre' => 'URBANA INDEPENDENCIA',
                'municipio_id' => 218,
                'co_stat_data' => 'A',
            ),
            495 =>
            array(
                'id' => 1820,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA TOCUYITO',
                'municipio_id' => 218,
                'co_stat_data' => 'A',
            ),
            496 =>
            array(
                'id' => 1842,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA LOS GUAYOS',
                'municipio_id' => 219,
                'co_stat_data' => 'A',
            ),
            497 =>
            array(
                'id' => 1824,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA NAGUANAGUA',
                'municipio_id' => 220,
                'co_stat_data' => 'A',
            ),
            498 =>
            array(
                'id' => 1832,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA SAN DIEGO',
                'municipio_id' => 221,
                'co_stat_data' => 'A',
            ),
            499 =>
            array(
                'id' => 1841,
                'co_prrq_asap' => '09',
                'nombre' => 'NO URBANA NEGRO PRIMERO',
                'municipio_id' => 222,
                'co_stat_data' => 'A',
            ),
            500 =>
            array(
                'id' => 1834,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA CANDELARIA',
                'municipio_id' => 222,
                'co_stat_data' => 'A',
            ),
            501 =>
            array(
                'id' => 1835,
                'co_prrq_asap' => '02',
                'nombre' => 'URBANA CATEDRAL',
                'municipio_id' => 222,
                'co_stat_data' => 'A',
            ),
            502 =>
            array(
                'id' => 1836,
                'co_prrq_asap' => '03',
                'nombre' => 'URBANA EL SOCORRO',
                'municipio_id' => 222,
                'co_stat_data' => 'A',
            ),
            503 =>
            array(
                'id' => 1837,
                'co_prrq_asap' => '04',
                'nombre' => 'URBANA MIGUEL PEÑA',
                'municipio_id' => 222,
                'co_stat_data' => 'A',
            ),
            504 =>
            array(
                'id' => 1838,
                'co_prrq_asap' => '05',
                'nombre' => 'URBANA RAFAEL URDANETA',
                'municipio_id' => 222,
                'co_stat_data' => 'A',
            ),
            505 =>
            array(
                'id' => 1844,
                'co_prrq_asap' => '06',
                'nombre' => 'URBANA SAN BLAS',
                'municipio_id' => 222,
                'co_stat_data' => 'A',
            ),
            506 =>
            array(
                'id' => 1839,
                'co_prrq_asap' => '07',
                'nombre' => 'URBANA SAN JOSE',
                'municipio_id' => 222,
                'co_stat_data' => 'A',
            ),
            507 =>
            array(
                'id' => 1840,
                'co_prrq_asap' => '08',
                'nombre' => 'URBANA SANTA ROSA',
                'municipio_id' => 222,
                'co_stat_data' => 'A',
            ),
            508 =>
            array(
                'id' => 1896,
                'co_prrq_asap' => '02',
                'nombre' => 'BOLIVAR',
                'municipio_id' => 223,
                'co_stat_data' => 'A',
            ),
            509 =>
            array(
                'id' => 1895,
                'co_prrq_asap' => '01',
                'nombre' => 'GUATIRE',
                'municipio_id' => 223,
                'co_stat_data' => 'A',
            ),
            510 =>
            array(
                'id' => 1885,
                'co_prrq_asap' => '01',
                'nombre' => 'GUARENAS',
                'municipio_id' => 224,
                'co_stat_data' => 'A',
            ),
            511 =>
            array(
                'id' => 1889,
                'co_prrq_asap' => '02',
                'nombre' => 'CAUCAGUITA',
                'municipio_id' => 225,
                'co_stat_data' => 'A',
            ),
            512 =>
            array(
                'id' => 1890,
                'co_prrq_asap' => '03',
                'nombre' => 'FILAS DE MARICHES',
                'municipio_id' => 225,
                'co_stat_data' => 'A',
            ),
            513 =>
            array(
                'id' => 1891,
                'co_prrq_asap' => '04',
                'nombre' => 'LA DOLORITA',
                'municipio_id' => 225,
                'co_stat_data' => 'A',
            ),
            514 =>
            array(
                'id' => 1892,
                'co_prrq_asap' => '05',
                'nombre' => 'LEONCIO MARTINEZ',
                'municipio_id' => 225,
                'co_stat_data' => 'A',
            ),
            515 =>
            array(
                'id' => 1888,
                'co_prrq_asap' => '01',
                'nombre' => 'PETARE',
                'municipio_id' => 225,
                'co_stat_data' => 'A',
            ),
            516 =>
            array(
                'id' => 1878,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN ANTONIO DE LOS ALTOS',
                'municipio_id' => 226,
                'co_stat_data' => 'A',
            ),
            517 =>
            array(
                'id' => 1846,
                'co_prrq_asap' => '02',
                'nombre' => 'ARAGUITA',
                'municipio_id' => 227,
                'co_stat_data' => 'A',
            ),
            518 =>
            array(
                'id' => 1847,
                'co_prrq_asap' => '03',
                'nombre' => 'AREVALO GONZALEZ',
                'municipio_id' => 227,
                'co_stat_data' => 'A',
            ),
            519 =>
            array(
                'id' => 1848,
                'co_prrq_asap' => '04',
                'nombre' => 'CAPAYA',
                'municipio_id' => 227,
                'co_stat_data' => 'A',
            ),
            520 =>
            array(
                'id' => 1845,
                'co_prrq_asap' => '01',
                'nombre' => 'CAUCAGUA',
                'municipio_id' => 227,
                'co_stat_data' => 'A',
            ),
            521 =>
            array(
                'id' => 1849,
                'co_prrq_asap' => '05',
                'nombre' => 'EL CAFE',
                'municipio_id' => 227,
                'co_stat_data' => 'A',
            ),
            522 =>
            array(
                'id' => 1850,
                'co_prrq_asap' => '06',
                'nombre' => 'MARIZAPA',
                'municipio_id' => 227,
                'co_stat_data' => 'A',
            ),
            523 =>
            array(
                'id' => 1851,
                'co_prrq_asap' => '07',
                'nombre' => 'PANAQUIRE',
                'municipio_id' => 227,
                'co_stat_data' => 'A',
            ),
            524 =>
            array(
                'id' => 1852,
                'co_prrq_asap' => '08',
                'nombre' => 'RIBAS',
                'municipio_id' => 227,
                'co_stat_data' => 'A',
            ),
            525 =>
            array(
                'id' => 1854,
                'co_prrq_asap' => '02',
                'nombre' => 'CUMBO',
                'municipio_id' => 228,
                'co_stat_data' => 'A',
            ),
            526 =>
            array(
                'id' => 1853,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN JOSE DE BARLOVENTO',
                'municipio_id' => 228,
                'co_stat_data' => 'A',
            ),
            527 =>
            array(
                'id' => 1855,
                'co_prrq_asap' => '01',
                'nombre' => 'BARUTA',
                'municipio_id' => 229,
                'co_stat_data' => 'A',
            ),
            528 =>
            array(
                'id' => 1856,
                'co_prrq_asap' => '02',
                'nombre' => 'EL CAFETAL',
                'municipio_id' => 229,
                'co_stat_data' => 'A',
            ),
            529 =>
            array(
                'id' => 1857,
                'co_prrq_asap' => '03',
                'nombre' => 'LAS MINAS DE BARUTA',
                'municipio_id' => 229,
                'co_stat_data' => 'A',
            ),
            530 =>
            array(
                'id' => 1859,
                'co_prrq_asap' => '02',
                'nombre' => 'CURIEPE',
                'municipio_id' => 230,
                'co_stat_data' => 'A',
            ),
            531 =>
            array(
                'id' => 1858,
                'co_prrq_asap' => '01',
                'nombre' => 'HIGUEROTE',
                'municipio_id' => 230,
                'co_stat_data' => 'A',
            ),
            532 =>
            array(
                'id' => 1860,
                'co_prrq_asap' => '03',
                'nombre' => 'TACARIGUA',
                'municipio_id' => 230,
                'co_stat_data' => 'A',
            ),
            533 =>
            array(
                'id' => 1861,
                'co_prrq_asap' => '01',
                'nombre' => 'MAMPORAL',
                'municipio_id' => 231,
                'co_stat_data' => 'A',
            ),
            534 =>
            array(
                'id' => 1862,
                'co_prrq_asap' => '01',
                'nombre' => 'CARRIZAL',
                'municipio_id' => 232,
                'co_stat_data' => 'A',
            ),
            535 =>
            array(
                'id' => 1863,
                'co_prrq_asap' => '01',
                'nombre' => 'CHACAO',
                'municipio_id' => 233,
                'co_stat_data' => 'A',
            ),
            536 =>
            array(
                'id' => 1864,
                'co_prrq_asap' => '01',
                'nombre' => 'CHARALLAVE',
                'municipio_id' => 234,
                'co_stat_data' => 'A',
            ),
            537 =>
            array(
                'id' => 1865,
                'co_prrq_asap' => '02',
                'nombre' => 'LAS BRISAS',
                'municipio_id' => 234,
                'co_stat_data' => 'A',
            ),
            538 =>
            array(
                'id' => 1866,
                'co_prrq_asap' => '01',
                'nombre' => 'EL HATILLO',
                'municipio_id' => 235,
                'co_stat_data' => 'A',
            ),
            539 =>
            array(
                'id' => 1868,
                'co_prrq_asap' => '02',
                'nombre' => 'ALTAGRACIA DE LA MONTAÑA',
                'municipio_id' => 236,
                'co_stat_data' => 'A',
            ),
            540 =>
            array(
                'id' => 1869,
                'co_prrq_asap' => '03',
                'nombre' => 'CECILIO ACOSTA',
                'municipio_id' => 236,
                'co_stat_data' => 'A',
            ),
            541 =>
            array(
                'id' => 1897,
                'co_prrq_asap' => '04',
                'nombre' => 'EL JARILLO',
                'municipio_id' => 236,
                'co_stat_data' => 'A',
            ),
            542 =>
            array(
                'id' => 1867,
                'co_prrq_asap' => '01',
                'nombre' => 'LOS TEQUES',
                'municipio_id' => 236,
                'co_stat_data' => 'A',
            ),
            543 =>
            array(
                'id' => 1870,
                'co_prrq_asap' => '05',
                'nombre' => 'PARACOTOS',
                'municipio_id' => 236,
                'co_stat_data' => 'A',
            ),
            544 =>
            array(
                'id' => 1871,
                'co_prrq_asap' => '06',
                'nombre' => 'SAN PEDRO',
                'municipio_id' => 236,
                'co_stat_data' => 'A',
            ),
            545 =>
            array(
                'id' => 1872,
                'co_prrq_asap' => '07',
                'nombre' => 'TACATA',
                'municipio_id' => 236,
                'co_stat_data' => 'A',
            ),
            546 =>
            array(
                'id' => 1874,
                'co_prrq_asap' => '02',
                'nombre' => 'EL CARTANAL',
                'municipio_id' => 237,
                'co_stat_data' => 'A',
            ),
            547 =>
            array(
                'id' => 1873,
                'co_prrq_asap' => '01',
                'nombre' => 'SANTA TERESA DEL TUY',
                'municipio_id' => 237,
                'co_stat_data' => 'A',
            ),
            548 =>
            array(
                'id' => 1876,
                'co_prrq_asap' => '02',
                'nombre' => 'LA DEMOCRACIA',
                'municipio_id' => 238,
                'co_stat_data' => 'A',
            ),
            549 =>
            array(
                'id' => 1875,
                'co_prrq_asap' => '01',
                'nombre' => 'OCUMARE DEL TUY',
                'municipio_id' => 238,
                'co_stat_data' => 'A',
            ),
            550 =>
            array(
                'id' => 1877,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTA BARBARA',
                'municipio_id' => 238,
                'co_stat_data' => 'A',
            ),
            551 =>
            array(
                'id' => 1880,
                'co_prrq_asap' => '02',
                'nombre' => 'EL GUAPO',
                'municipio_id' => 239,
                'co_stat_data' => 'A',
            ),
            552 =>
            array(
                'id' => 1882,
                'co_prrq_asap' => '04',
                'nombre' => 'PAPARO',
                'municipio_id' => 239,
                'co_stat_data' => 'A',
            ),
            553 =>
            array(
                'id' => 1879,
                'co_prrq_asap' => '01',
                'nombre' => 'RIO CHICO',
                'municipio_id' => 239,
                'co_stat_data' => 'A',
            ),
            554 =>
            array(
                'id' => 1926,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN FERNANDO DEL GUAPO',
                'municipio_id' => 239,
                'co_stat_data' => 'A',
            ),
            555 =>
            array(
                'id' => 1881,
                'co_prrq_asap' => '03',
                'nombre' => 'TACARIGUA DE LA LAGUNA',
                'municipio_id' => 239,
                'co_stat_data' => 'A',
            ),
            556 =>
            array(
                'id' => 1883,
                'co_prrq_asap' => '01',
                'nombre' => 'SANTA LUCIA',
                'municipio_id' => 240,
                'co_stat_data' => 'A',
            ),
            557 =>
            array(
                'id' => 1884,
                'co_prrq_asap' => '01',
                'nombre' => 'CUPIRA',
                'municipio_id' => 241,
                'co_stat_data' => 'A',
            ),
            558 =>
            array(
                'id' => 1927,
                'co_prrq_asap' => '02',
                'nombre' => 'MACHURUCUTO',
                'municipio_id' => 241,
                'co_stat_data' => 'A',
            ),
            559 =>
            array(
                'id' => 1887,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN ANTONIO DE YARE',
                'municipio_id' => 242,
                'co_stat_data' => 'A',
            ),
            560 =>
            array(
                'id' => 1886,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN FRANCISCO DE YARE',
                'municipio_id' => 242,
                'co_stat_data' => 'A',
            ),
            561 =>
            array(
                'id' => 1893,
                'co_prrq_asap' => '01',
                'nombre' => 'CUA',
                'municipio_id' => 243,
                'co_stat_data' => 'A',
            ),
            562 =>
            array(
                'id' => 1894,
                'co_prrq_asap' => '02',
                'nombre' => 'NUEVA CUA',
                'municipio_id' => 243,
                'co_stat_data' => 'A',
            ),
            563 =>
            array(
                'id' => 2191,
                'co_prrq_asap' => '04',
                'nombre' => 'ACEQUIAS',
                'municipio_id' => 244,
                'co_stat_data' => 'A',
            ),
            564 =>
            array(
                'id' => 2189,
                'co_prrq_asap' => '01',
                'nombre' => 'FERNANDEZ PEÑA',
                'municipio_id' => 244,
                'co_stat_data' => 'A',
            ),
            565 =>
            array(
                'id' => 2192,
                'co_prrq_asap' => '05',
                'nombre' => 'JAJI',
                'municipio_id' => 244,
                'co_stat_data' => 'A',
            ),
            566 =>
            array(
                'id' => 2193,
                'co_prrq_asap' => '06',
                'nombre' => 'LA MESA',
                'municipio_id' => 244,
                'co_stat_data' => 'A',
            ),
            567 =>
            array(
                'id' => 2190,
                'co_prrq_asap' => '02',
                'nombre' => 'MATRIZ',
                'municipio_id' => 244,
                'co_stat_data' => 'A',
            ),
            568 =>
            array(
                'id' => 1909,
                'co_prrq_asap' => '03',
                'nombre' => 'MONTALBAN',
                'municipio_id' => 244,
                'co_stat_data' => 'A',
            ),
            569 =>
            array(
                'id' => 2194,
                'co_prrq_asap' => '07',
                'nombre' => 'SAN JOSE DEL SUR',
                'municipio_id' => 244,
                'co_stat_data' => 'A',
            ),
            570 =>
            array(
                'id' => 1915,
                'co_prrq_asap' => '01',
                'nombre' => 'JUAN IGNACIO MONTILLA',
                'municipio_id' => 245,
                'co_stat_data' => 'A',
            ),
            571 =>
            array(
                'id' => 2431,
                'co_prrq_asap' => '02',
                'nombre' => 'LA BEATRIZ',
                'municipio_id' => 245,
                'co_stat_data' => 'A',
            ),
            572 =>
            array(
                'id' => 2433,
                'co_prrq_asap' => '05',
                'nombre' => 'LA PUERTA',
                'municipio_id' => 245,
                'co_stat_data' => 'A',
            ),
            573 =>
            array(
                'id' => 2434,
                'co_prrq_asap' => '06',
                'nombre' => 'MENDOZA',
                'municipio_id' => 245,
                'co_stat_data' => 'A',
            ),
            574 =>
            array(
                'id' => 1917,
                'co_prrq_asap' => '03',
                'nombre' => 'MERCEDES DIAZ',
                'municipio_id' => 245,
                'co_stat_data' => 'A',
            ),
            575 =>
            array(
                'id' => 2432,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN LUIS',
                'municipio_id' => 245,
                'co_stat_data' => 'A',
            ),
            576 =>
            array(
                'id' => 1925,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL GUANARE',
                'municipio_id' => 246,
                'co_stat_data' => 'A',
            ),
            577 =>
            array(
                'id' => 2256,
                'co_prrq_asap' => '02',
                'nombre' => 'CORDOBA',
                'municipio_id' => 246,
                'co_stat_data' => 'A',
            ),
            578 =>
            array(
                'id' => 2257,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN JOSE DE LA MONTAÑA',
                'municipio_id' => 246,
                'co_stat_data' => 'A',
            ),
            579 =>
            array(
                'id' => 2258,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN JUAN DE GUANAGUANARE',
                'municipio_id' => 246,
                'co_stat_data' => 'A',
            ),
            580 =>
            array(
                'id' => 2259,
                'co_prrq_asap' => '05',
                'nombre' => 'VIRGEN DE LA COROMOTO',
                'municipio_id' => 246,
                'co_stat_data' => 'A',
            ),
            581 =>
            array(
                'id' => 1923,
                'co_prrq_asap' => '01',
                'nombre' => 'ANTONIO SPINETTI DINI',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            582 =>
            array(
                'id' => 1919,
                'co_prrq_asap' => '02',
                'nombre' => 'ARIAS',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            583 =>
            array(
                'id' => 2206,
                'co_prrq_asap' => '03',
                'nombre' => 'CARACCIOLO PARRA PEREZ',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            584 =>
            array(
                'id' => 2207,
                'co_prrq_asap' => '04',
                'nombre' => 'DOMINGO PEÑA',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            585 =>
            array(
                'id' => 2208,
                'co_prrq_asap' => '05',
                'nombre' => 'EL LLANO',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            586 =>
            array(
                'id' => 2216,
                'co_prrq_asap' => '14',
                'nombre' => 'EL MORRO',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            587 =>
            array(
                'id' => 2209,
                'co_prrq_asap' => '06',
                'nombre' => 'GONZALO PICON FEBRES',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            588 =>
            array(
                'id' => 2210,
                'co_prrq_asap' => '07',
                'nombre' => 'JACINTO PLAZA',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            589 =>
            array(
                'id' => 2211,
                'co_prrq_asap' => '08',
                'nombre' => 'JUAN RODRIGUEZ SUAREZ',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            590 =>
            array(
                'id' => 2212,
                'co_prrq_asap' => '09',
                'nombre' => 'LASSO DE LA VEGA',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            591 =>
            array(
                'id' => 2217,
                'co_prrq_asap' => '15',
                'nombre' => 'LOS NEVADOS',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            592 =>
            array(
                'id' => 2213,
                'co_prrq_asap' => '10',
                'nombre' => 'MARIANO PICON SALAS',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            593 =>
            array(
                'id' => 1922,
                'co_prrq_asap' => '11',
                'nombre' => 'MILLA',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            594 =>
            array(
                'id' => 2214,
                'co_prrq_asap' => '12',
                'nombre' => 'OSUNA RODRIGUEZ',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            595 =>
            array(
                'id' => 2215,
                'co_prrq_asap' => '13',
                'nombre' => 'SAGRARIO',
                'municipio_id' => 247,
                'co_stat_data' => 'A',
            ),
            596 =>
            array(
                'id' => 1950,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PAEZ',
                'municipio_id' => 248,
                'co_stat_data' => 'A',
            ),
            597 =>
            array(
                'id' => 2267,
                'co_prrq_asap' => '02',
                'nombre' => 'PAYARA',
                'municipio_id' => 248,
                'co_stat_data' => 'A',
            ),
            598 =>
            array(
                'id' => 2268,
                'co_prrq_asap' => '03',
                'nombre' => 'PIMPINELA',
                'municipio_id' => 248,
                'co_stat_data' => 'A',
            ),
            599 =>
            array(
                'id' => 2512,
                'co_prrq_asap' => '04',
                'nombre' => 'RAMON PERAZA',
                'municipio_id' => 248,
                'co_stat_data' => 'A',
            ),
            600 =>
            array(
                'id' => 1951,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ALTO ORINOCO',
                'municipio_id' => 249,
                'co_stat_data' => 'A',
            ),
            601 =>
            array(
                'id' => 1952,
                'co_prrq_asap' => '02',
                'nombre' => 'HUACHAMACARE',
                'municipio_id' => 249,
                'co_stat_data' => 'A',
            ),
            602 =>
            array(
                'id' => 1953,
                'co_prrq_asap' => '03',
                'nombre' => 'MARAWAKA',
                'municipio_id' => 249,
                'co_stat_data' => 'A',
            ),
            603 =>
            array(
                'id' => 1954,
                'co_prrq_asap' => '04',
                'nombre' => 'MAVACA',
                'municipio_id' => 249,
                'co_stat_data' => 'A',
            ),
            604 =>
            array(
                'id' => 2468,
                'co_prrq_asap' => '05',
                'nombre' => 'SIERRA PARIMA',
                'municipio_id' => 249,
                'co_stat_data' => 'A',
            ),
            605 =>
            array(
                'id' => 1957,
                'co_prrq_asap' => '03',
                'nombre' => 'CANAME',
                'municipio_id' => 250,
                'co_stat_data' => 'A',
            ),
            606 =>
            array(
                'id' => 1955,
                'co_prrq_asap' => '01',
                'nombre' => 'UCATA',
                'municipio_id' => 250,
                'co_stat_data' => 'A',
            ),
            607 =>
            array(
                'id' => 1956,
                'co_prrq_asap' => '02',
                'nombre' => 'YACAPANA',
                'municipio_id' => 250,
                'co_stat_data' => 'A',
            ),
            608 =>
            array(
                'id' => 1958,
                'co_prrq_asap' => '01',
                'nombre' => 'FERNANDO GIRON TOVAR',
                'municipio_id' => 251,
                'co_stat_data' => 'A',
            ),
            609 =>
            array(
                'id' => 1959,
                'co_prrq_asap' => '02',
                'nombre' => 'LUIS ALBERTO GOMEZ',
                'municipio_id' => 251,
                'co_stat_data' => 'A',
            ),
            610 =>
            array(
                'id' => 1960,
                'co_prrq_asap' => '03',
                'nombre' => 'PARHUEÑA',
                'municipio_id' => 251,
                'co_stat_data' => 'A',
            ),
            611 =>
            array(
                'id' => 1961,
                'co_prrq_asap' => '04',
                'nombre' => 'PLATANILLAL',
                'municipio_id' => 251,
                'co_stat_data' => 'A',
            ),
            612 =>
            array(
                'id' => 1965,
                'co_prrq_asap' => '04',
                'nombre' => 'GUAYAPO',
                'municipio_id' => 252,
                'co_stat_data' => 'A',
            ),
            613 =>
            array(
                'id' => 1964,
                'co_prrq_asap' => '03',
                'nombre' => 'MUNDUAPO',
                'municipio_id' => 252,
                'co_stat_data' => 'A',
            ),
            614 =>
            array(
                'id' => 1962,
                'co_prrq_asap' => '01',
                'nombre' => 'SAMARIAPO',
                'municipio_id' => 252,
                'co_stat_data' => 'A',
            ),
            615 =>
            array(
                'id' => 1963,
                'co_prrq_asap' => '02',
                'nombre' => 'SIPAPO',
                'municipio_id' => 252,
                'co_stat_data' => 'A',
            ),
            616 =>
            array(
                'id' => 1967,
                'co_prrq_asap' => '02',
                'nombre' => 'COMUNIDAD',
                'municipio_id' => 253,
                'co_stat_data' => 'A',
            ),
            617 =>
            array(
                'id' => 1966,
                'co_prrq_asap' => '01',
                'nombre' => 'VICTORINO',
                'municipio_id' => 253,
                'co_stat_data' => 'A',
            ),
            618 =>
            array(
                'id' => 1968,
                'co_prrq_asap' => '01',
                'nombre' => 'ALTO VENTUARI',
                'municipio_id' => 254,
                'co_stat_data' => 'A',
            ),
            619 =>
            array(
                'id' => 1970,
                'co_prrq_asap' => '03',
                'nombre' => 'BAJO VENTUARI',
                'municipio_id' => 254,
                'co_stat_data' => 'A',
            ),
            620 =>
            array(
                'id' => 1969,
                'co_prrq_asap' => '02',
                'nombre' => 'MEDIO VENTUARI',
                'municipio_id' => 254,
                'co_stat_data' => 'A',
            ),
            621 =>
            array(
                'id' => 1971,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL RIO NEGRO',
                'municipio_id' => 255,
                'co_stat_data' => 'A',
            ),
            622 =>
            array(
                'id' => 1973,
                'co_prrq_asap' => '03',
                'nombre' => 'CASIQUIARE',
                'municipio_id' => 255,
                'co_stat_data' => 'A',
            ),
            623 =>
            array(
                'id' => 2469,
                'co_prrq_asap' => '04',
                'nombre' => 'COCUY',
                'municipio_id' => 255,
                'co_stat_data' => 'A',
            ),
            624 =>
            array(
                'id' => 1972,
                'co_prrq_asap' => '02',
                'nombre' => 'SOLANO',
                'municipio_id' => 255,
                'co_stat_data' => 'A',
            ),
            625 =>
            array(
                'id' => 1975,
                'co_prrq_asap' => '02',
                'nombre' => 'APURITO',
                'municipio_id' => 256,
                'co_stat_data' => 'A',
            ),
            626 =>
            array(
                'id' => 1976,
                'co_prrq_asap' => '03',
                'nombre' => 'EL YAGUAL',
                'municipio_id' => 256,
                'co_stat_data' => 'A',
            ),
            627 =>
            array(
                'id' => 1977,
                'co_prrq_asap' => '04',
                'nombre' => 'GUACHARA',
                'municipio_id' => 256,
                'co_stat_data' => 'A',
            ),
            628 =>
            array(
                'id' => 1978,
                'co_prrq_asap' => '05',
                'nombre' => 'MUCURITAS',
                'municipio_id' => 256,
                'co_stat_data' => 'A',
            ),
            629 =>
            array(
                'id' => 1979,
                'co_prrq_asap' => '06',
                'nombre' => 'QUESERAS DEL MEDIO',
                'municipio_id' => 256,
                'co_stat_data' => 'A',
            ),
            630 =>
            array(
                'id' => 1974,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA ACHAGUAS',
                'municipio_id' => 256,
                'co_stat_data' => 'A',
            ),
            631 =>
            array(
                'id' => 1980,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA BIRUACA',
                'municipio_id' => 257,
                'co_stat_data' => 'A',
            ),
            632 =>
            array(
                'id' => 1982,
                'co_prrq_asap' => '02',
                'nombre' => 'MANTECAL',
                'municipio_id' => 258,
                'co_stat_data' => 'A',
            ),
            633 =>
            array(
                'id' => 1983,
                'co_prrq_asap' => '03',
                'nombre' => 'QUINTERO',
                'municipio_id' => 258,
                'co_stat_data' => 'A',
            ),
            634 =>
            array(
                'id' => 1984,
                'co_prrq_asap' => '04',
                'nombre' => 'RINCON HONDO',
                'municipio_id' => 258,
                'co_stat_data' => 'A',
            ),
            635 =>
            array(
                'id' => 1985,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN VICENTE',
                'municipio_id' => 258,
                'co_stat_data' => 'A',
            ),
            636 =>
            array(
                'id' => 1981,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA BRUZUAL',
                'municipio_id' => 258,
                'co_stat_data' => 'A',
            ),
            637 =>
            array(
                'id' => 1987,
                'co_prrq_asap' => '02',
                'nombre' => 'ARAMENDI',
                'municipio_id' => 259,
                'co_stat_data' => 'A',
            ),
            638 =>
            array(
                'id' => 1988,
                'co_prrq_asap' => '03',
                'nombre' => 'EL AMPARO',
                'municipio_id' => 259,
                'co_stat_data' => 'A',
            ),
            639 =>
            array(
                'id' => 1989,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN CAMILO',
                'municipio_id' => 259,
                'co_stat_data' => 'A',
            ),
            640 =>
            array(
                'id' => 1986,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA GUASDUALITO',
                'municipio_id' => 259,
                'co_stat_data' => 'A',
            ),
            641 =>
            array(
                'id' => 1990,
                'co_prrq_asap' => '05',
                'nombre' => 'URDANETA',
                'municipio_id' => 259,
                'co_stat_data' => 'A',
            ),
            642 =>
            array(
                'id' => 1992,
                'co_prrq_asap' => '02',
                'nombre' => 'CODAZZI',
                'municipio_id' => 260,
                'co_stat_data' => 'A',
            ),
            643 =>
            array(
                'id' => 1993,
                'co_prrq_asap' => '03',
                'nombre' => 'CUNAVICHE',
                'municipio_id' => 260,
                'co_stat_data' => 'A',
            ),
            644 =>
            array(
                'id' => 1991,
                'co_prrq_asap' => '01',
                'nombre' => 'UBNA SAN JUAN DE PAYARA',
                'municipio_id' => 260,
                'co_stat_data' => 'A',
            ),
            645 =>
            array(
                'id' => 1995,
                'co_prrq_asap' => '02',
                'nombre' => 'LA TRINIDAD',
                'municipio_id' => 261,
                'co_stat_data' => 'A',
            ),
            646 =>
            array(
                'id' => 1994,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA ELORZA',
                'municipio_id' => 261,
                'co_stat_data' => 'A',
            ),
            647 =>
            array(
                'id' => 1997,
                'co_prrq_asap' => '02',
                'nombre' => 'EL RECREO',
                'municipio_id' => 262,
                'co_stat_data' => 'A',
            ),
            648 =>
            array(
                'id' => 1998,
                'co_prrq_asap' => '03',
                'nombre' => 'PEÑALVER',
                'municipio_id' => 262,
                'co_stat_data' => 'A',
            ),
            649 =>
            array(
                'id' => 1999,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN RAFAEL DE ATAMAICA',
                'municipio_id' => 262,
                'co_stat_data' => 'A',
            ),
            650 =>
            array(
                'id' => 1996,
                'co_prrq_asap' => '01',
                'nombre' => 'URBANA SAN FERNANDO',
                'municipio_id' => 262,
                'co_stat_data' => 'A',
            ),
            651 =>
            array(
                'id' => 2001,
                'co_prrq_asap' => '02',
                'nombre' => 'RODRIGUEZ DOMINGUEZ',
                'municipio_id' => 263,
                'co_stat_data' => 'A',
            ),
            652 =>
            array(
                'id' => 2000,
                'co_prrq_asap' => '01',
                'nombre' => 'SABANETA',
                'municipio_id' => 263,
                'co_stat_data' => 'A',
            ),
            653 =>
            array(
                'id' => 2003,
                'co_prrq_asap' => '02',
                'nombre' => 'ANDRES BELLO',
                'municipio_id' => 264,
                'co_stat_data' => 'A',
            ),
            654 =>
            array(
                'id' => 2004,
                'co_prrq_asap' => '03',
                'nombre' => 'NICOLAS PULIDO',
                'municipio_id' => 264,
                'co_stat_data' => 'A',
            ),
            655 =>
            array(
                'id' => 2002,
                'co_prrq_asap' => '01',
                'nombre' => 'TICOPORO',
                'municipio_id' => 264,
                'co_stat_data' => 'A',
            ),
            656 =>
            array(
                'id' => 2005,
                'co_prrq_asap' => '01',
                'nombre' => 'ARISMENDI',
                'municipio_id' => 265,
                'co_stat_data' => 'A',
            ),
            657 =>
            array(
                'id' => 2006,
                'co_prrq_asap' => '02',
                'nombre' => 'GUADARRAMA',
                'municipio_id' => 265,
                'co_stat_data' => 'A',
            ),
            658 =>
            array(
                'id' => 2007,
                'co_prrq_asap' => '03',
                'nombre' => 'LA UNION',
                'municipio_id' => 265,
                'co_stat_data' => 'A',
            ),
            659 =>
            array(
                'id' => 2008,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN ANTONIO',
                'municipio_id' => 265,
                'co_stat_data' => 'A',
            ),
            660 =>
            array(
                'id' => 2010,
                'co_prrq_asap' => '02',
                'nombre' => 'ALFREDO ARVELO LARRIVA',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            661 =>
            array(
                'id' => 2019,
                'co_prrq_asap' => '11',
                'nombre' => 'ALTO BARINAS',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            662 =>
            array(
                'id' => 2009,
                'co_prrq_asap' => '01',
                'nombre' => 'BARINAS',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            663 =>
            array(
                'id' => 2017,
                'co_prrq_asap' => '09',
                'nombre' => 'CORAZON DE JESUS',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            664 =>
            array(
                'id' => 2022,
                'co_prrq_asap' => '14',
                'nombre' => 'DOMINGA ORTIZ DE PAEZ',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            665 =>
            array(
                'id' => 2015,
                'co_prrq_asap' => '07',
                'nombre' => 'EL CARMEN',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            666 =>
            array(
                'id' => 2021,
                'co_prrq_asap' => '13',
                'nombre' => 'JUAN ANTONIO RODRIGUEZ DOMINGU',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            667 =>
            array(
                'id' => 2020,
                'co_prrq_asap' => '12',
                'nombre' => 'MANUEL PALACIO FAJARDO',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            668 =>
            array(
                'id' => 2018,
                'co_prrq_asap' => '10',
                'nombre' => 'RAMON IGNACIO MENDEZ',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            669 =>
            array(
                'id' => 2016,
                'co_prrq_asap' => '08',
                'nombre' => 'ROMULO BETANCOURT',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            670 =>
            array(
                'id' => 2011,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN SILVESTRE',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            671 =>
            array(
                'id' => 2012,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA INES',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            672 =>
            array(
                'id' => 2013,
                'co_prrq_asap' => '05',
                'nombre' => 'SANTA LUCIA',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            673 =>
            array(
                'id' => 2014,
                'co_prrq_asap' => '06',
                'nombre' => 'TORUNOS',
                'municipio_id' => 266,
                'co_stat_data' => 'A',
            ),
            674 =>
            array(
                'id' => 2024,
                'co_prrq_asap' => '02',
                'nombre' => 'ALTAMIRA',
                'municipio_id' => 267,
                'co_stat_data' => 'A',
            ),
            675 =>
            array(
                'id' => 2023,
                'co_prrq_asap' => '01',
                'nombre' => 'BARINITAS',
                'municipio_id' => 267,
                'co_stat_data' => 'A',
            ),
            676 =>
            array(
                'id' => 2025,
                'co_prrq_asap' => '03',
                'nombre' => 'CALDERAS',
                'municipio_id' => 267,
                'co_stat_data' => 'A',
            ),
            677 =>
            array(
                'id' => 2026,
                'co_prrq_asap' => '01',
                'nombre' => 'BARRANCAS',
                'municipio_id' => 268,
                'co_stat_data' => 'A',
            ),
            678 =>
            array(
                'id' => 2027,
                'co_prrq_asap' => '02',
                'nombre' => 'EL SOCORRO',
                'municipio_id' => 268,
                'co_stat_data' => 'A',
            ),
            679 =>
            array(
                'id' => 2028,
                'co_prrq_asap' => '03',
                'nombre' => 'MASPARRITO',
                'municipio_id' => 268,
                'co_stat_data' => 'A',
            ),
            680 =>
            array(
                'id' => 2030,
                'co_prrq_asap' => '02',
                'nombre' => 'JOSE IGNACIO DEL PUMAR',
                'municipio_id' => 269,
                'co_stat_data' => 'A',
            ),
            681 =>
            array(
                'id' => 2031,
                'co_prrq_asap' => '03',
                'nombre' => 'PEDRO BRICEÑO MENDEZ',
                'municipio_id' => 269,
                'co_stat_data' => 'A',
            ),
            682 =>
            array(
                'id' => 2032,
                'co_prrq_asap' => '04',
                'nombre' => 'RAMON IGNACIO MENDEZ',
                'municipio_id' => 269,
                'co_stat_data' => 'A',
            ),
            683 =>
            array(
                'id' => 2029,
                'co_prrq_asap' => '01',
                'nombre' => 'SANTA BARBARA',
                'municipio_id' => 269,
                'co_stat_data' => 'A',
            ),
            684 =>
            array(
                'id' => 2035,
                'co_prrq_asap' => '02',
                'nombre' => 'EL REAL',
                'municipio_id' => 270,
                'co_stat_data' => 'A',
            ),
            685 =>
            array(
                'id' => 2036,
                'co_prrq_asap' => '03',
                'nombre' => 'LA LUZ',
                'municipio_id' => 270,
                'co_stat_data' => 'A',
            ),
            686 =>
            array(
                'id' => 2037,
                'co_prrq_asap' => '04',
                'nombre' => 'LOS GUASIMITOS',
                'municipio_id' => 270,
                'co_stat_data' => 'A',
            ),
            687 =>
            array(
                'id' => 2034,
                'co_prrq_asap' => '01',
                'nombre' => 'OBISPOS',
                'municipio_id' => 270,
                'co_stat_data' => 'A',
            ),
            688 =>
            array(
                'id' => 2038,
                'co_prrq_asap' => '01',
                'nombre' => 'CIUDAD BOLIVIA',
                'municipio_id' => 271,
                'co_stat_data' => 'A',
            ),
            689 =>
            array(
                'id' => 2039,
                'co_prrq_asap' => '02',
                'nombre' => 'IGNACIO BRICEÑO',
                'municipio_id' => 271,
                'co_stat_data' => 'A',
            ),
            690 =>
            array(
                'id' => 2040,
                'co_prrq_asap' => '03',
                'nombre' => 'JOSE FELIX RIBAS',
                'municipio_id' => 271,
                'co_stat_data' => 'A',
            ),
            691 =>
            array(
                'id' => 2041,
                'co_prrq_asap' => '04',
                'nombre' => 'PAEZ',
                'municipio_id' => 271,
                'co_stat_data' => 'A',
            ),
            692 =>
            array(
                'id' => 2043,
                'co_prrq_asap' => '02',
                'nombre' => 'DOLORES',
                'municipio_id' => 272,
                'co_stat_data' => 'A',
            ),
            693 =>
            array(
                'id' => 2042,
                'co_prrq_asap' => '01',
                'nombre' => 'LIBERTAD',
                'municipio_id' => 272,
                'co_stat_data' => 'A',
            ),
            694 =>
            array(
                'id' => 2044,
                'co_prrq_asap' => '03',
                'nombre' => 'PALACIOS FAJARDO',
                'municipio_id' => 272,
                'co_stat_data' => 'A',
            ),
            695 =>
            array(
                'id' => 2045,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA ROSA',
                'municipio_id' => 272,
                'co_stat_data' => 'A',
            ),
            696 =>
            array(
                'id' => 2046,
                'co_prrq_asap' => '01',
                'nombre' => 'CIUDAD DE NUTRIAS',
                'municipio_id' => 273,
                'co_stat_data' => 'A',
            ),
            697 =>
            array(
                'id' => 2047,
                'co_prrq_asap' => '02',
                'nombre' => 'EL REGALO',
                'municipio_id' => 273,
                'co_stat_data' => 'A',
            ),
            698 =>
            array(
                'id' => 2048,
                'co_prrq_asap' => '03',
                'nombre' => 'PUERTO DE NUTRIAS',
                'municipio_id' => 273,
                'co_stat_data' => 'A',
            ),
            699 =>
            array(
                'id' => 2049,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA CATALINA',
                'municipio_id' => 273,
                'co_stat_data' => 'A',
            ),
            700 =>
            array(
                'id' => 2050,
                'co_prrq_asap' => '01',
                'nombre' => 'COJEDES',
                'municipio_id' => 274,
                'co_stat_data' => 'A',
            ),
            701 =>
            array(
                'id' => 2051,
                'co_prrq_asap' => '02',
                'nombre' => 'JUAN DE MATA SUAREZ',
                'municipio_id' => 274,
                'co_stat_data' => 'A',
            ),
            702 =>
            array(
                'id' => 2052,
                'co_prrq_asap' => '01',
                'nombre' => 'TINAQUILLO',
                'municipio_id' => 275,
                'co_stat_data' => 'A',
            ),
            703 =>
            array(
                'id' => 2053,
                'co_prrq_asap' => '01',
                'nombre' => 'EL BAUL',
                'municipio_id' => 276,
                'co_stat_data' => 'A',
            ),
            704 =>
            array(
                'id' => 2054,
                'co_prrq_asap' => '02',
                'nombre' => 'SUCRE',
                'municipio_id' => 276,
                'co_stat_data' => 'A',
            ),
            705 =>
            array(
                'id' => 2056,
                'co_prrq_asap' => '02',
                'nombre' => 'LA AGUADITA',
                'municipio_id' => 277,
                'co_stat_data' => 'A',
            ),
            706 =>
            array(
                'id' => 2055,
                'co_prrq_asap' => '01',
                'nombre' => 'MACAPO',
                'municipio_id' => 277,
                'co_stat_data' => 'A',
            ),
            707 =>
            array(
                'id' => 2057,
                'co_prrq_asap' => '01',
                'nombre' => 'EL PAO',
                'municipio_id' => 278,
                'co_stat_data' => 'A',
            ),
            708 =>
            array(
                'id' => 2059,
                'co_prrq_asap' => '02',
                'nombre' => 'EL AMPARO',
                'municipio_id' => 279,
                'co_stat_data' => 'A',
            ),
            709 =>
            array(
                'id' => 2058,
                'co_prrq_asap' => '01',
                'nombre' => 'LIBERTAD DE COJEDES',
                'municipio_id' => 279,
                'co_stat_data' => 'A',
            ),
            710 =>
            array(
                'id' => 2060,
                'co_prrq_asap' => '01',
                'nombre' => 'ROMULO GALLEGOS',
                'municipio_id' => 280,
                'co_stat_data' => 'A',
            ),
            711 =>
            array(
                'id' => 2062,
                'co_prrq_asap' => '02',
                'nombre' => 'JUAN ANGEL BRAVO',
                'municipio_id' => 281,
                'co_stat_data' => 'A',
            ),
            712 =>
            array(
                'id' => 2063,
                'co_prrq_asap' => '03',
                'nombre' => 'MANUEL MANRIQUE',
                'municipio_id' => 281,
                'co_stat_data' => 'A',
            ),
            713 =>
            array(
                'id' => 2061,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN CARLOS DE AUSTRIA',
                'municipio_id' => 281,
                'co_stat_data' => 'A',
            ),
            714 =>
            array(
                'id' => 2064,
                'co_prrq_asap' => '01',
                'nombre' => 'GENERAL JOSE LAURENCIO SILVA',
                'municipio_id' => 282,
                'co_stat_data' => 'A',
            ),
            715 =>
            array(
                'id' => 2066,
                'co_prrq_asap' => '02',
                'nombre' => 'ALMIRANTE LUIS BRION',
                'municipio_id' => 283,
                'co_stat_data' => 'A',
            ),
            716 =>
            array(
                'id' => 2065,
                'co_prrq_asap' => '01',
                'nombre' => 'CURIAPO',
                'municipio_id' => 283,
                'co_stat_data' => 'A',
            ),
            717 =>
            array(
                'id' => 2067,
                'co_prrq_asap' => '03',
                'nombre' => 'FRANCISCO ANICETO LUGO',
                'municipio_id' => 283,
                'co_stat_data' => 'A',
            ),
            718 =>
            array(
                'id' => 2068,
                'co_prrq_asap' => '04',
                'nombre' => 'MANUEL RENAUD',
                'municipio_id' => 283,
                'co_stat_data' => 'A',
            ),
            719 =>
            array(
                'id' => 2069,
                'co_prrq_asap' => '05',
                'nombre' => 'PADRE BARRAL',
                'municipio_id' => 283,
                'co_stat_data' => 'A',
            ),
            720 =>
            array(
                'id' => 2070,
                'co_prrq_asap' => '06',
                'nombre' => 'SANTOS DE ABELGAS',
                'municipio_id' => 283,
                'co_stat_data' => 'A',
            ),
            721 =>
            array(
                'id' => 2072,
                'co_prrq_asap' => '02',
                'nombre' => 'CINCO DE JULIO',
                'municipio_id' => 284,
                'co_stat_data' => 'A',
            ),
            722 =>
            array(
                'id' => 2071,
                'co_prrq_asap' => '01',
                'nombre' => 'IMATACA',
                'municipio_id' => 284,
                'co_stat_data' => 'A',
            ),
            723 =>
            array(
                'id' => 2073,
                'co_prrq_asap' => '03',
                'nombre' => 'JUAN BAUTISTA ARISMENDI',
                'municipio_id' => 284,
                'co_stat_data' => 'A',
            ),
            724 =>
            array(
                'id' => 2074,
                'co_prrq_asap' => '04',
                'nombre' => 'MANUEL PIAR',
                'municipio_id' => 284,
                'co_stat_data' => 'A',
            ),
            725 =>
            array(
                'id' => 2554,
                'co_prrq_asap' => '05',
                'nombre' => 'ROMULO GALLEGOS',
                'municipio_id' => 284,
                'co_stat_data' => 'A',
            ),
            726 =>
            array(
                'id' => 2077,
                'co_prrq_asap' => '02',
                'nombre' => 'LUIS BELTRAN PRIETO FIGUEROA',
                'municipio_id' => 285,
                'co_stat_data' => 'A',
            ),
            727 =>
            array(
                'id' => 2076,
                'co_prrq_asap' => '01',
                'nombre' => 'PEDERNALES',
                'municipio_id' => 285,
                'co_stat_data' => 'A',
            ),
            728 =>
            array(
                'id' => 2079,
                'co_prrq_asap' => '02',
                'nombre' => 'JOSE VIDAL MARCANO',
                'municipio_id' => 286,
                'co_stat_data' => 'A',
            ),
            729 =>
            array(
                'id' => 2080,
                'co_prrq_asap' => '03',
                'nombre' => 'JUAN MILLAN',
                'municipio_id' => 286,
                'co_stat_data' => 'A',
            ),
            730 =>
            array(
                'id' => 2081,
                'co_prrq_asap' => '04',
                'nombre' => 'LEONARDO RUIZ PINEDA',
                'municipio_id' => 286,
                'co_stat_data' => 'A',
            ),
            731 =>
            array(
                'id' => 2082,
                'co_prrq_asap' => '05',
                'nombre' => 'MARISCAL ANTONIO JOSE DE SUCRE',
                'municipio_id' => 286,
                'co_stat_data' => 'A',
            ),
            732 =>
            array(
                'id' => 2083,
                'co_prrq_asap' => '06',
                'nombre' => 'MONSEÑOR ARGIMIRO GARCIA',
                'municipio_id' => 286,
                'co_stat_data' => 'A',
            ),
            733 =>
            array(
                'id' => 2078,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN JOSE',
                'municipio_id' => 286,
                'co_stat_data' => 'A',
            ),
            734 =>
            array(
                'id' => 2084,
                'co_prrq_asap' => '07',
                'nombre' => 'SAN RAFAEL',
                'municipio_id' => 286,
                'co_stat_data' => 'A',
            ),
            735 =>
            array(
                'id' => 2085,
                'co_prrq_asap' => '08',
                'nombre' => 'VIRGEN DEL VALLE',
                'municipio_id' => 286,
                'co_stat_data' => 'A',
            ),
            736 =>
            array(
                'id' => 2087,
                'co_prrq_asap' => '02',
                'nombre' => 'CAPADARE',
                'municipio_id' => 287,
                'co_stat_data' => 'A',
            ),
            737 =>
            array(
                'id' => 2088,
                'co_prrq_asap' => '03',
                'nombre' => 'LA PASTORA',
                'municipio_id' => 287,
                'co_stat_data' => 'A',
            ),
            738 =>
            array(
                'id' => 2089,
                'co_prrq_asap' => '04',
                'nombre' => 'LIBERTADOR',
                'municipio_id' => 287,
                'co_stat_data' => 'A',
            ),
            739 =>
            array(
                'id' => 2086,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN JUAN DE LOS CAYOS',
                'municipio_id' => 287,
                'co_stat_data' => 'A',
            ),
            740 =>
            array(
                'id' => 2091,
                'co_prrq_asap' => '02',
                'nombre' => 'ARACUA',
                'municipio_id' => 288,
                'co_stat_data' => 'A',
            ),
            741 =>
            array(
                'id' => 2092,
                'co_prrq_asap' => '03',
                'nombre' => 'LA PEÑA',
                'municipio_id' => 288,
                'co_stat_data' => 'A',
            ),
            742 =>
            array(
                'id' => 2090,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN LUIS',
                'municipio_id' => 288,
                'co_stat_data' => 'A',
            ),
            743 =>
            array(
                'id' => 2094,
                'co_prrq_asap' => '02',
                'nombre' => 'BARIRO',
                'municipio_id' => 289,
                'co_stat_data' => 'A',
            ),
            744 =>
            array(
                'id' => 2095,
                'co_prrq_asap' => '03',
                'nombre' => 'BOROJO',
                'municipio_id' => 289,
                'co_stat_data' => 'A',
            ),
            745 =>
            array(
                'id' => 2093,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPATARIDA',
                'municipio_id' => 289,
                'co_stat_data' => 'A',
            ),
            746 =>
            array(
                'id' => 2096,
                'co_prrq_asap' => '04',
                'nombre' => 'GUAJIRO',
                'municipio_id' => 289,
                'co_stat_data' => 'A',
            ),
            747 =>
            array(
                'id' => 2097,
                'co_prrq_asap' => '05',
                'nombre' => 'SEQUE',
                'municipio_id' => 289,
                'co_stat_data' => 'A',
            ),
            748 =>
            array(
                'id' => 2098,
                'co_prrq_asap' => '06',
                'nombre' => 'ZAZARIDA',
                'municipio_id' => 289,
                'co_stat_data' => 'A',
            ),
            749 =>
            array(
                'id' => 2099,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL CACIQUE MANAURE',
                'municipio_id' => 290,
                'co_stat_data' => 'A',
            ),
            750 =>
            array(
                'id' => 2100,
                'co_prrq_asap' => '01',
                'nombre' => 'CARIRUBANA',
                'municipio_id' => 291,
                'co_stat_data' => 'A',
            ),
            751 =>
            array(
                'id' => 2101,
                'co_prrq_asap' => '02',
                'nombre' => 'NORTE',
                'municipio_id' => 291,
                'co_stat_data' => 'A',
            ),
            752 =>
            array(
                'id' => 2102,
                'co_prrq_asap' => '03',
                'nombre' => 'PUNTA CARDON',
                'municipio_id' => 291,
                'co_stat_data' => 'A',
            ),
            753 =>
            array(
                'id' => 2103,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA ANA',
                'municipio_id' => 291,
                'co_stat_data' => 'A',
            ),
            754 =>
            array(
                'id' => 2105,
                'co_prrq_asap' => '02',
                'nombre' => 'ACURIGUA',
                'municipio_id' => 292,
                'co_stat_data' => 'A',
            ),
            755 =>
            array(
                'id' => 2106,
                'co_prrq_asap' => '03',
                'nombre' => 'GUAIBACOA',
                'municipio_id' => 292,
                'co_stat_data' => 'A',
            ),
            756 =>
            array(
                'id' => 2104,
                'co_prrq_asap' => '01',
                'nombre' => 'LA VELA DE CORO',
                'municipio_id' => 292,
                'co_stat_data' => 'A',
            ),
            757 =>
            array(
                'id' => 2107,
                'co_prrq_asap' => '04',
                'nombre' => 'LAS CALDERAS',
                'municipio_id' => 292,
                'co_stat_data' => 'A',
            ),
            758 =>
            array(
                'id' => 2108,
                'co_prrq_asap' => '05',
                'nombre' => 'MACORUCA',
                'municipio_id' => 292,
                'co_stat_data' => 'A',
            ),
            759 =>
            array(
                'id' => 2109,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL DABAJURO',
                'municipio_id' => 293,
                'co_stat_data' => 'A',
            ),
            760 =>
            array(
                'id' => 2111,
                'co_prrq_asap' => '02',
                'nombre' => 'AGUA CLARA',
                'municipio_id' => 294,
                'co_stat_data' => 'A',
            ),
            761 =>
            array(
                'id' => 2112,
                'co_prrq_asap' => '03',
                'nombre' => 'AVARIA',
                'municipio_id' => 294,
                'co_stat_data' => 'A',
            ),
            762 =>
            array(
                'id' => 2110,
                'co_prrq_asap' => '01',
                'nombre' => 'PEDREGAL',
                'municipio_id' => 294,
                'co_stat_data' => 'A',
            ),
            763 =>
            array(
                'id' => 2113,
                'co_prrq_asap' => '04',
                'nombre' => 'PIEDRA GRANDE',
                'municipio_id' => 294,
                'co_stat_data' => 'A',
            ),
            764 =>
            array(
                'id' => 2114,
                'co_prrq_asap' => '05',
                'nombre' => 'PURURECHE',
                'municipio_id' => 294,
                'co_stat_data' => 'A',
            ),
            765 =>
            array(
                'id' => 2121,
                'co_prrq_asap' => '07',
                'nombre' => 'ADAURE',
                'municipio_id' => 295,
                'co_stat_data' => 'A',
            ),
            766 =>
            array(
                'id' => 2116,
                'co_prrq_asap' => '02',
                'nombre' => 'ADICORA',
                'municipio_id' => 295,
                'co_stat_data' => 'A',
            ),
            767 =>
            array(
                'id' => 2117,
                'co_prrq_asap' => '03',
                'nombre' => 'BARAIVED',
                'municipio_id' => 295,
                'co_stat_data' => 'A',
            ),
            768 =>
            array(
                'id' => 2118,
                'co_prrq_asap' => '04',
                'nombre' => 'BUENA VISTA',
                'municipio_id' => 295,
                'co_stat_data' => 'A',
            ),
            769 =>
            array(
                'id' => 2122,
                'co_prrq_asap' => '08',
                'nombre' => 'EL HATO',
                'municipio_id' => 295,
                'co_stat_data' => 'A',
            ),
            770 =>
            array(
                'id' => 2123,
                'co_prrq_asap' => '09',
                'nombre' => 'EL VINCULO',
                'municipio_id' => 295,
                'co_stat_data' => 'A',
            ),
            771 =>
            array(
                'id' => 2119,
                'co_prrq_asap' => '05',
                'nombre' => 'JADACAQUIVA',
                'municipio_id' => 295,
                'co_stat_data' => 'A',
            ),
            772 =>
            array(
                'id' => 2120,
                'co_prrq_asap' => '06',
                'nombre' => 'MORUY',
                'municipio_id' => 295,
                'co_stat_data' => 'A',
            ),
            773 =>
            array(
                'id' => 2115,
                'co_prrq_asap' => '01',
                'nombre' => 'PUEBLO NUEVO',
                'municipio_id' => 295,
                'co_stat_data' => 'A',
            ),
            774 =>
            array(
                'id' => 2125,
                'co_prrq_asap' => '02',
                'nombre' => 'AGUA LARGA',
                'municipio_id' => 296,
                'co_stat_data' => 'A',
            ),
            775 =>
            array(
                'id' => 2124,
                'co_prrq_asap' => '01',
                'nombre' => 'CHURUGUARA',
                'municipio_id' => 296,
                'co_stat_data' => 'A',
            ),
            776 =>
            array(
                'id' => 2126,
                'co_prrq_asap' => '03',
                'nombre' => 'EL PAUJI',
                'municipio_id' => 296,
                'co_stat_data' => 'A',
            ),
            777 =>
            array(
                'id' => 2127,
                'co_prrq_asap' => '04',
                'nombre' => 'INDEPENDENCIA',
                'municipio_id' => 296,
                'co_stat_data' => 'A',
            ),
            778 =>
            array(
                'id' => 2128,
                'co_prrq_asap' => '05',
                'nombre' => 'MAPARARI',
                'municipio_id' => 296,
                'co_stat_data' => 'A',
            ),
            779 =>
            array(
                'id' => 2130,
                'co_prrq_asap' => '02',
                'nombre' => 'AGUA LINDA',
                'municipio_id' => 297,
                'co_stat_data' => 'A',
            ),
            780 =>
            array(
                'id' => 2131,
                'co_prrq_asap' => '03',
                'nombre' => 'ARAURIMA',
                'municipio_id' => 297,
                'co_stat_data' => 'A',
            ),
            781 =>
            array(
                'id' => 2129,
                'co_prrq_asap' => '01',
                'nombre' => 'JACURA',
                'municipio_id' => 297,
                'co_stat_data' => 'A',
            ),
            782 =>
            array(
                'id' => 2133,
                'co_prrq_asap' => '02',
                'nombre' => 'JUDIBANA',
                'municipio_id' => 298,
                'co_stat_data' => 'A',
            ),
            783 =>
            array(
                'id' => 2132,
                'co_prrq_asap' => '01',
                'nombre' => 'LOS TAQUES',
                'municipio_id' => 298,
                'co_stat_data' => 'A',
            ),
            784 =>
            array(
                'id' => 2135,
                'co_prrq_asap' => '02',
                'nombre' => 'CASIGUA',
                'municipio_id' => 299,
                'co_stat_data' => 'A',
            ),
            785 =>
            array(
                'id' => 2134,
                'co_prrq_asap' => '01',
                'nombre' => 'MENE DE MAUROA',
                'municipio_id' => 299,
                'co_stat_data' => 'A',
            ),
            786 =>
            array(
                'id' => 2136,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN FELIX',
                'municipio_id' => 299,
                'co_stat_data' => 'A',
            ),
            787 =>
            array(
                'id' => 2140,
                'co_prrq_asap' => '04',
                'nombre' => 'GUZMAN GUILLERMO',
                'municipio_id' => 300,
                'co_stat_data' => 'A',
            ),
            788 =>
            array(
                'id' => 2141,
                'co_prrq_asap' => '05',
                'nombre' => 'MITARE',
                'municipio_id' => 300,
                'co_stat_data' => 'A',
            ),
            789 =>
            array(
                'id' => 2142,
                'co_prrq_asap' => '06',
                'nombre' => 'RIO SECO',
                'municipio_id' => 300,
                'co_stat_data' => 'A',
            ),
            790 =>
            array(
                'id' => 2143,
                'co_prrq_asap' => '07',
                'nombre' => 'SABANETA',
                'municipio_id' => 300,
                'co_stat_data' => 'A',
            ),
            791 =>
            array(
                'id' => 2137,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN ANTONIO',
                'municipio_id' => 300,
                'co_stat_data' => 'A',
            ),
            792 =>
            array(
                'id' => 2138,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN GABRIEL',
                'municipio_id' => 300,
                'co_stat_data' => 'A',
            ),
            793 =>
            array(
                'id' => 2139,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTA ANA',
                'municipio_id' => 300,
                'co_stat_data' => 'A',
            ),
            794 =>
            array(
                'id' => 2145,
                'co_prrq_asap' => '02',
                'nombre' => 'BOCA DE TOCUYO',
                'municipio_id' => 301,
                'co_stat_data' => 'A',
            ),
            795 =>
            array(
                'id' => 2144,
                'co_prrq_asap' => '01',
                'nombre' => 'CHICHIRIVICHE',
                'municipio_id' => 301,
                'co_stat_data' => 'A',
            ),
            796 =>
            array(
                'id' => 2146,
                'co_prrq_asap' => '03',
                'nombre' => 'TOCUYO DE LA COSTA',
                'municipio_id' => 301,
                'co_stat_data' => 'A',
            ),
            797 =>
            array(
                'id' => 2147,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PALMASOLA',
                'municipio_id' => 302,
                'co_stat_data' => 'A',
            ),
            798 =>
            array(
                'id' => 2148,
                'co_prrq_asap' => '01',
                'nombre' => 'CABURE',
                'municipio_id' => 303,
                'co_stat_data' => 'A',
            ),
            799 =>
            array(
                'id' => 2149,
                'co_prrq_asap' => '02',
                'nombre' => 'COLINA',
                'municipio_id' => 303,
                'co_stat_data' => 'A',
            ),
            800 =>
            array(
                'id' => 2150,
                'co_prrq_asap' => '03',
                'nombre' => 'CURIMAGUA',
                'municipio_id' => 303,
                'co_stat_data' => 'A',
            ),
            801 =>
            array(
                'id' => 2151,
                'co_prrq_asap' => '01',
                'nombre' => 'PIRITU',
                'municipio_id' => 304,
                'co_stat_data' => 'A',
            ),
            802 =>
            array(
                'id' => 2152,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN JOSE DE LA COSTA',
                'municipio_id' => 304,
                'co_stat_data' => 'A',
            ),
            803 =>
            array(
                'id' => 2153,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SAN FRANCISCO',
                'municipio_id' => 305,
                'co_stat_data' => 'A',
            ),
            804 =>
            array(
                'id' => 2155,
                'co_prrq_asap' => '02',
                'nombre' => 'BOCA DE AROA',
                'municipio_id' => 306,
                'co_stat_data' => 'A',
            ),
            805 =>
            array(
                'id' => 2154,
                'co_prrq_asap' => '01',
                'nombre' => 'TUCACAS',
                'municipio_id' => 306,
                'co_stat_data' => 'A',
            ),
            806 =>
            array(
                'id' => 2157,
                'co_prrq_asap' => '02',
                'nombre' => 'PECAYA',
                'municipio_id' => 307,
                'co_stat_data' => 'A',
            ),
            807 =>
            array(
                'id' => 2156,
                'co_prrq_asap' => '01',
                'nombre' => 'SUCRE',
                'municipio_id' => 307,
                'co_stat_data' => 'A',
            ),
            808 =>
            array(
                'id' => 2158,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL TOCOPERO',
                'municipio_id' => 308,
                'co_stat_data' => 'A',
            ),
            809 =>
            array(
                'id' => 2160,
                'co_prrq_asap' => '02',
                'nombre' => 'EL CHARAL',
                'municipio_id' => 309,
                'co_stat_data' => 'A',
            ),
            810 =>
            array(
                'id' => 2161,
                'co_prrq_asap' => '03',
                'nombre' => 'LAS VEGAS DEL TUY',
                'municipio_id' => 309,
                'co_stat_data' => 'A',
            ),
            811 =>
            array(
                'id' => 2159,
                'co_prrq_asap' => '01',
                'nombre' => 'SANTA CRUZ DE BUCARAL',
                'municipio_id' => 309,
                'co_stat_data' => 'A',
            ),
            812 =>
            array(
                'id' => 2163,
                'co_prrq_asap' => '02',
                'nombre' => 'BRUZUAL',
                'municipio_id' => 310,
                'co_stat_data' => 'A',
            ),
            813 =>
            array(
                'id' => 2162,
                'co_prrq_asap' => '01',
                'nombre' => 'URUMACO',
                'municipio_id' => 310,
                'co_stat_data' => 'A',
            ),
            814 =>
            array(
                'id' => 2165,
                'co_prrq_asap' => '02',
                'nombre' => 'LA CIENAGA',
                'municipio_id' => 311,
                'co_stat_data' => 'A',
            ),
            815 =>
            array(
                'id' => 2166,
                'co_prrq_asap' => '03',
                'nombre' => 'LA SOLEDAD',
                'municipio_id' => 311,
                'co_stat_data' => 'A',
            ),
            816 =>
            array(
                'id' => 2167,
                'co_prrq_asap' => '04',
                'nombre' => 'PUEBLO CUMAREBO',
                'municipio_id' => 311,
                'co_stat_data' => 'A',
            ),
            817 =>
            array(
                'id' => 2164,
                'co_prrq_asap' => '01',
                'nombre' => 'PUERTO CUMAREBO',
                'municipio_id' => 311,
                'co_stat_data' => 'A',
            ),
            818 =>
            array(
                'id' => 2168,
                'co_prrq_asap' => '05',
                'nombre' => 'ZAZARIDA',
                'municipio_id' => 311,
                'co_stat_data' => 'A',
            ),
            819 =>
            array(
                'id' => 2471,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL CAMAGUAN',
                'municipio_id' => 312,
                'co_stat_data' => 'A',
            ),
            820 =>
            array(
                'id' => 2472,
                'co_prrq_asap' => '02',
                'nombre' => 'PUERTO MIRANDA',
                'municipio_id' => 312,
                'co_stat_data' => 'A',
            ),
            821 =>
            array(
                'id' => 2473,
                'co_prrq_asap' => '03',
                'nombre' => 'UVERITO',
                'municipio_id' => 312,
                'co_stat_data' => 'A',
            ),
            822 =>
            array(
                'id' => 2474,
                'co_prrq_asap' => '01',
                'nombre' => 'CHAGUARAMAS',
                'municipio_id' => 313,
                'co_stat_data' => 'A',
            ),
            823 =>
            array(
                'id' => 2475,
                'co_prrq_asap' => '01',
                'nombre' => 'EL SOCORRO',
                'municipio_id' => 314,
                'co_stat_data' => 'A',
            ),
            824 =>
            array(
                'id' => 2476,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SAN GERONIMO DE GUAYABAL',
                'municipio_id' => 315,
                'co_stat_data' => 'A',
            ),
            825 =>
            array(
                'id' => 2477,
                'co_prrq_asap' => '02',
                'nombre' => 'CAZORLA',
                'municipio_id' => 315,
                'co_stat_data' => 'A',
            ),
            826 =>
            array(
                'id' => 2478,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL VALLE DE LA PASCUA',
                'municipio_id' => 316,
                'co_stat_data' => 'A',
            ),
            827 =>
            array(
                'id' => 2479,
                'co_prrq_asap' => '02',
                'nombre' => 'ESPINO',
                'municipio_id' => 316,
                'co_stat_data' => 'A',
            ),
            828 =>
            array(
                'id' => 2481,
                'co_prrq_asap' => '02',
                'nombre' => 'CABRUTA',
                'municipio_id' => 317,
                'co_stat_data' => 'A',
            ),
            829 =>
            array(
                'id' => 2480,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL LAS MERCEDES',
                'municipio_id' => 317,
                'co_stat_data' => 'A',
            ),
            830 =>
            array(
                'id' => 2482,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTA RITA MANAPIRE',
                'municipio_id' => 317,
                'co_stat_data' => 'A',
            ),
            831 =>
            array(
                'id' => 2483,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL EL SOMBRERO',
                'municipio_id' => 318,
                'co_stat_data' => 'A',
            ),
            832 =>
            array(
                'id' => 2484,
                'co_prrq_asap' => '02',
                'nombre' => 'SOSA',
                'municipio_id' => 318,
                'co_stat_data' => 'A',
            ),
            833 =>
            array(
                'id' => 2485,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL CALABOZO',
                'municipio_id' => 319,
                'co_stat_data' => 'A',
            ),
            834 =>
            array(
                'id' => 2486,
                'co_prrq_asap' => '02',
                'nombre' => 'EL CALVARIO',
                'municipio_id' => 319,
                'co_stat_data' => 'A',
            ),
            835 =>
            array(
                'id' => 2487,
                'co_prrq_asap' => '03',
                'nombre' => 'EL RASTRO',
                'municipio_id' => 319,
                'co_stat_data' => 'A',
            ),
            836 =>
            array(
                'id' => 2488,
                'co_prrq_asap' => '04',
                'nombre' => 'GUARDATINAJAS',
                'municipio_id' => 319,
                'co_stat_data' => 'A',
            ),
            837 =>
            array(
                'id' => 2489,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ALTAGRACIA DE ORITUCO',
                'municipio_id' => 320,
                'co_stat_data' => 'A',
            ),
            838 =>
            array(
                'id' => 2490,
                'co_prrq_asap' => '02',
                'nombre' => 'LEZAMA',
                'municipio_id' => 320,
                'co_stat_data' => 'A',
            ),
            839 =>
            array(
                'id' => 2491,
                'co_prrq_asap' => '03',
                'nombre' => 'LIBERTAD DE ORITUCO',
                'municipio_id' => 320,
                'co_stat_data' => 'A',
            ),
            840 =>
            array(
                'id' => 2492,
                'co_prrq_asap' => '04',
                'nombre' => 'PASO REAL DE MACAIRA',
                'municipio_id' => 320,
                'co_stat_data' => 'A',
            ),
            841 =>
            array(
                'id' => 2493,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN FRANCISCO DE MACAIRA',
                'municipio_id' => 320,
                'co_stat_data' => 'A',
            ),
            842 =>
            array(
                'id' => 2494,
                'co_prrq_asap' => '06',
                'nombre' => 'SAN RAFAEL DE ORITUCO',
                'municipio_id' => 320,
                'co_stat_data' => 'A',
            ),
            843 =>
            array(
                'id' => 2495,
                'co_prrq_asap' => '07',
                'nombre' => 'SOUBLETTE',
                'municipio_id' => 320,
                'co_stat_data' => 'A',
            ),
            844 =>
            array(
                'id' => 2496,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ORTIZ',
                'municipio_id' => 321,
                'co_stat_data' => 'A',
            ),
            845 =>
            array(
                'id' => 2497,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN FRANCISCO DE TIZNADOS',
                'municipio_id' => 321,
                'co_stat_data' => 'A',
            ),
            846 =>
            array(
                'id' => 2498,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN JOSE DE TIZNADOS',
                'municipio_id' => 321,
                'co_stat_data' => 'A',
            ),
            847 =>
            array(
                'id' => 2499,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN LORENZO DE TIZNADOS',
                'municipio_id' => 321,
                'co_stat_data' => 'A',
            ),
            848 =>
            array(
                'id' => 2500,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL TUCUPIDO',
                'municipio_id' => 322,
                'co_stat_data' => 'A',
            ),
            849 =>
            array(
                'id' => 2501,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN RAFAEL DE LAYA',
                'municipio_id' => 322,
                'co_stat_data' => 'A',
            ),
            850 =>
            array(
                'id' => 2503,
                'co_prrq_asap' => '02',
                'nombre' => 'CANTAGALLO',
                'municipio_id' => 323,
                'co_stat_data' => 'A',
            ),
            851 =>
            array(
                'id' => 2502,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SAN JUAN DE LOS MORROS',
                'municipio_id' => 323,
                'co_stat_data' => 'A',
            ),
            852 =>
            array(
                'id' => 2504,
                'co_prrq_asap' => '03',
                'nombre' => 'PARAPARA',
                'municipio_id' => 323,
                'co_stat_data' => 'A',
            ),
            853 =>
            array(
                'id' => 2505,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN JOSE DE GUARIBE',
                'municipio_id' => 324,
                'co_stat_data' => 'A',
            ),
            854 =>
            array(
                'id' => 2507,
                'co_prrq_asap' => '02',
                'nombre' => 'ALTAMIRA',
                'municipio_id' => 325,
                'co_stat_data' => 'A',
            ),
            855 =>
            array(
                'id' => 2506,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SANTA MARIA DE IPIRE',
                'municipio_id' => 325,
                'co_stat_data' => 'A',
            ),
            856 =>
            array(
                'id' => 2508,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ZARAZA',
                'municipio_id' => 326,
                'co_stat_data' => 'A',
            ),
            857 =>
            array(
                'id' => 2509,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN JOSE DE UNARE',
                'municipio_id' => 326,
                'co_stat_data' => 'A',
            ),
            858 =>
            array(
                'id' => 2172,
                'co_prrq_asap' => '04',
                'nombre' => 'GABRIEL PICON GONZALEZ',
                'municipio_id' => 327,
                'co_stat_data' => 'A',
            ),
            859 =>
            array(
                'id' => 2173,
                'co_prrq_asap' => '05',
                'nombre' => 'HECTOR AMABLE MORA',
                'municipio_id' => 327,
                'co_stat_data' => 'A',
            ),
            860 =>
            array(
                'id' => 2174,
                'co_prrq_asap' => '06',
                'nombre' => 'JOSE NUCETE SARDI',
                'municipio_id' => 327,
                'co_stat_data' => 'A',
            ),
            861 =>
            array(
                'id' => 2169,
                'co_prrq_asap' => '01',
                'nombre' => 'PRESIDENTE BETANCOURT',
                'municipio_id' => 327,
                'co_stat_data' => 'A',
            ),
            862 =>
            array(
                'id' => 2170,
                'co_prrq_asap' => '02',
                'nombre' => 'PRESIDENTE PAEZ',
                'municipio_id' => 327,
                'co_stat_data' => 'A',
            ),
            863 =>
            array(
                'id' => 2171,
                'co_prrq_asap' => '03',
                'nombre' => 'PRESIDENTE ROMULO GALLEGOS',
                'municipio_id' => 327,
                'co_stat_data' => 'A',
            ),
            864 =>
            array(
                'id' => 2175,
                'co_prrq_asap' => '07',
                'nombre' => 'PULIDO MENDEZ',
                'municipio_id' => 327,
                'co_stat_data' => 'A',
            ),
            865 =>
            array(
                'id' => 2176,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ANDRES BELLO',
                'municipio_id' => 328,
                'co_stat_data' => 'A',
            ),
            866 =>
            array(
                'id' => 2177,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ANTONIO PINTO SALINAS',
                'municipio_id' => 329,
                'co_stat_data' => 'A',
            ),
            867 =>
            array(
                'id' => 2178,
                'co_prrq_asap' => '02',
                'nombre' => 'MESA BOLIVAR',
                'municipio_id' => 329,
                'co_stat_data' => 'A',
            ),
            868 =>
            array(
                'id' => 2179,
                'co_prrq_asap' => '03',
                'nombre' => 'MESA DE LAS PALMAS',
                'municipio_id' => 329,
                'co_stat_data' => 'A',
            ),
            869 =>
            array(
                'id' => 2180,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ARICAGUA',
                'municipio_id' => 330,
                'co_stat_data' => 'A',
            ),
            870 =>
            array(
                'id' => 2181,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN ANTONIO',
                'municipio_id' => 330,
                'co_stat_data' => 'A',
            ),
            871 =>
            array(
                'id' => 2182,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ARZOBISPO CHACON',
                'municipio_id' => 331,
                'co_stat_data' => 'A',
            ),
            872 =>
            array(
                'id' => 2183,
                'co_prrq_asap' => '02',
                'nombre' => 'CAPURI',
                'municipio_id' => 331,
                'co_stat_data' => 'A',
            ),
            873 =>
            array(
                'id' => 2184,
                'co_prrq_asap' => '03',
                'nombre' => 'CHACANTA',
                'municipio_id' => 331,
                'co_stat_data' => 'A',
            ),
            874 =>
            array(
                'id' => 2185,
                'co_prrq_asap' => '04',
                'nombre' => 'EL MOLINO',
                'municipio_id' => 331,
                'co_stat_data' => 'A',
            ),
            875 =>
            array(
                'id' => 2186,
                'co_prrq_asap' => '05',
                'nombre' => 'GUAIMARAL',
                'municipio_id' => 331,
                'co_stat_data' => 'A',
            ),
            876 =>
            array(
                'id' => 2188,
                'co_prrq_asap' => '07',
                'nombre' => 'MUCUCHACHI',
                'municipio_id' => 331,
                'co_stat_data' => 'A',
            ),
            877 =>
            array(
                'id' => 2187,
                'co_prrq_asap' => '06',
                'nombre' => 'MUCUTUY',
                'municipio_id' => 331,
                'co_stat_data' => 'A',
            ),
            878 =>
            array(
                'id' => 2195,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL CARACCIOLO PARRA OLMEDO',
                'municipio_id' => 332,
                'co_stat_data' => 'A',
            ),
            879 =>
            array(
                'id' => 2196,
                'co_prrq_asap' => '02',
                'nombre' => 'FLORENCIO RAMIREZ',
                'municipio_id' => 332,
                'co_stat_data' => 'A',
            ),
            880 =>
            array(
                'id' => 2197,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL CARDENAL QUINTERO',
                'municipio_id' => 333,
                'co_stat_data' => 'A',
            ),
            881 =>
            array(
                'id' => 2198,
                'co_prrq_asap' => '02',
                'nombre' => 'LAS PIEDRAS',
                'municipio_id' => 333,
                'co_stat_data' => 'A',
            ),
            882 =>
            array(
                'id' => 2199,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL GUARAQUE',
                'municipio_id' => 334,
                'co_stat_data' => 'A',
            ),
            883 =>
            array(
                'id' => 2200,
                'co_prrq_asap' => '02',
                'nombre' => 'MESA DE QUINTERO',
                'municipio_id' => 334,
                'co_stat_data' => 'A',
            ),
            884 =>
            array(
                'id' => 2201,
                'co_prrq_asap' => '03',
                'nombre' => 'RIO NEGRO',
                'municipio_id' => 334,
                'co_stat_data' => 'A',
            ),
            885 =>
            array(
                'id' => 2202,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL JULIO CESAR SALAS',
                'municipio_id' => 335,
                'co_stat_data' => 'A',
            ),
            886 =>
            array(
                'id' => 2203,
                'co_prrq_asap' => '02',
                'nombre' => 'PALMIRA',
                'municipio_id' => 335,
                'co_stat_data' => 'A',
            ),
            887 =>
            array(
                'id' => 2204,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL JUSTO BRICEÑO',
                'municipio_id' => 336,
                'co_stat_data' => 'A',
            ),
            888 =>
            array(
                'id' => 2205,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN CRISTOBAL DE TORONDOY',
                'municipio_id' => 336,
                'co_stat_data' => 'A',
            ),
            889 =>
            array(
                'id' => 2219,
                'co_prrq_asap' => '02',
                'nombre' => 'ANDRES ELOY BLANCO',
                'municipio_id' => 337,
                'co_stat_data' => 'A',
            ),
            890 =>
            array(
                'id' => 2218,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL MIRANDA',
                'municipio_id' => 337,
                'co_stat_data' => 'A',
            ),
            891 =>
            array(
                'id' => 2220,
                'co_prrq_asap' => '03',
                'nombre' => 'LA VENTA',
                'municipio_id' => 337,
                'co_stat_data' => 'A',
            ),
            892 =>
            array(
                'id' => 2221,
                'co_prrq_asap' => '04',
                'nombre' => 'PIÑANGO',
                'municipio_id' => 337,
                'co_stat_data' => 'A',
            ),
            893 =>
            array(
                'id' => 2222,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL OBISPO RAMOS DE LORA',
                'municipio_id' => 338,
                'co_stat_data' => 'A',
            ),
            894 =>
            array(
                'id' => 2223,
                'co_prrq_asap' => '02',
                'nombre' => 'ELOY PAREDES',
                'municipio_id' => 338,
                'co_stat_data' => 'A',
            ),
            895 =>
            array(
                'id' => 2224,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN RAFAEL DE ALCAZAR',
                'municipio_id' => 338,
                'co_stat_data' => 'A',
            ),
            896 =>
            array(
                'id' => 2225,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PADRE NOGUERA',
                'municipio_id' => 339,
                'co_stat_data' => 'A',
            ),
            897 =>
            array(
                'id' => 2226,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PUEBLO LLANO',
                'municipio_id' => 340,
                'co_stat_data' => 'A',
            ),
            898 =>
            array(
                'id' => 2228,
                'co_prrq_asap' => '02',
                'nombre' => 'CACUTE',
                'municipio_id' => 341,
                'co_stat_data' => 'A',
            ),
            899 =>
            array(
                'id' => 2227,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL RANGEL',
                'municipio_id' => 341,
                'co_stat_data' => 'A',
            ),
            900 =>
            array(
                'id' => 2229,
                'co_prrq_asap' => '03',
                'nombre' => 'LA TOMA',
                'municipio_id' => 341,
                'co_stat_data' => 'A',
            ),
            901 =>
            array(
                'id' => 2230,
                'co_prrq_asap' => '04',
                'nombre' => 'MUCURUBA',
                'municipio_id' => 341,
                'co_stat_data' => 'A',
            ),
            902 =>
            array(
                'id' => 2231,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN RAFAEL',
                'municipio_id' => 341,
                'co_stat_data' => 'A',
            ),
            903 =>
            array(
                'id' => 2232,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL RIVAS DAVILA',
                'municipio_id' => 342,
                'co_stat_data' => 'A',
            ),
            904 =>
            array(
                'id' => 2233,
                'co_prrq_asap' => '02',
                'nombre' => 'GERONIMO MALDONADO',
                'municipio_id' => 342,
                'co_stat_data' => 'A',
            ),
            905 =>
            array(
                'id' => 2234,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SANTOS MARQUINA',
                'municipio_id' => 343,
                'co_stat_data' => 'A',
            ),
            906 =>
            array(
                'id' => 2235,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SUCRE',
                'municipio_id' => 344,
                'co_stat_data' => 'A',
            ),
            907 =>
            array(
                'id' => 2236,
                'co_prrq_asap' => '02',
                'nombre' => 'CHIGUARA',
                'municipio_id' => 344,
                'co_stat_data' => 'A',
            ),
            908 =>
            array(
                'id' => 2237,
                'co_prrq_asap' => '03',
                'nombre' => 'ESTANQUEZ',
                'municipio_id' => 344,
                'co_stat_data' => 'A',
            ),
            909 =>
            array(
                'id' => 2238,
                'co_prrq_asap' => '04',
                'nombre' => 'LA TRAMPA',
                'municipio_id' => 344,
                'co_stat_data' => 'A',
            ),
            910 =>
            array(
                'id' => 2239,
                'co_prrq_asap' => '05',
                'nombre' => 'PUEBLO NUEVO DEL SUR',
                'municipio_id' => 344,
                'co_stat_data' => 'A',
            ),
            911 =>
            array(
                'id' => 2240,
                'co_prrq_asap' => '06',
                'nombre' => 'SAN JUAN',
                'municipio_id' => 344,
                'co_stat_data' => 'A',
            ),
            912 =>
            array(
                'id' => 2241,
                'co_prrq_asap' => '01',
                'nombre' => 'EL AMPARO',
                'municipio_id' => 345,
                'co_stat_data' => 'A',
            ),
            913 =>
            array(
                'id' => 2242,
                'co_prrq_asap' => '02',
                'nombre' => 'EL LLANO',
                'municipio_id' => 345,
                'co_stat_data' => 'A',
            ),
            914 =>
            array(
                'id' => 2243,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN FRANCISCO',
                'municipio_id' => 345,
                'co_stat_data' => 'A',
            ),
            915 =>
            array(
                'id' => 2244,
                'co_prrq_asap' => '04',
                'nombre' => 'TOVAR',
                'municipio_id' => 345,
                'co_stat_data' => 'A',
            ),
            916 =>
            array(
                'id' => 2245,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL TULIO FEBRES CORDERO',
                'municipio_id' => 346,
                'co_stat_data' => 'A',
            ),
            917 =>
            array(
                'id' => 2246,
                'co_prrq_asap' => '02',
                'nombre' => 'INDEPENDENCIA',
                'municipio_id' => 346,
                'co_stat_data' => 'A',
            ),
            918 =>
            array(
                'id' => 2247,
                'co_prrq_asap' => '03',
                'nombre' => 'MARIA DE LA CONCEPCION PALACIO',
                'municipio_id' => 346,
                'co_stat_data' => 'A',
            ),
            919 =>
            array(
                'id' => 2248,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA POLONIA',
                'municipio_id' => 346,
                'co_stat_data' => 'A',
            ),
            920 =>
            array(
                'id' => 2249,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ZEA',
                'municipio_id' => 347,
                'co_stat_data' => 'A',
            ),
            921 =>
            array(
                'id' => 2250,
                'co_prrq_asap' => '02',
                'nombre' => 'CAÑO EL TIGRE',
                'municipio_id' => 347,
                'co_stat_data' => 'A',
            ),
            922 =>
            array(
                'id' => 2251,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL AGUA BLANCA',
                'municipio_id' => 348,
                'co_stat_data' => 'A',
            ),
            923 =>
            array(
                'id' => 2252,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ARAURE',
                'municipio_id' => 349,
                'co_stat_data' => 'A',
            ),
            924 =>
            array(
                'id' => 2253,
                'co_prrq_asap' => '02',
                'nombre' => 'RIO ACARIGUA',
                'municipio_id' => 349,
                'co_stat_data' => 'A',
            ),
            925 =>
            array(
                'id' => 2254,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ESTELLER',
                'municipio_id' => 350,
                'co_stat_data' => 'A',
            ),
            926 =>
            array(
                'id' => 2255,
                'co_prrq_asap' => '02',
                'nombre' => 'UVERAL',
                'municipio_id' => 350,
                'co_stat_data' => 'A',
            ),
            927 =>
            array(
                'id' => 2260,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL GUANARITO',
                'municipio_id' => 351,
                'co_stat_data' => 'A',
            ),
            928 =>
            array(
                'id' => 2262,
                'co_prrq_asap' => '03',
                'nombre' => 'DIVINA PASTORA',
                'municipio_id' => 351,
                'co_stat_data' => 'A',
            ),
            929 =>
            array(
                'id' => 2261,
                'co_prrq_asap' => '02',
                'nombre' => 'TRINIDAD DE LA CAPILLA',
                'municipio_id' => 351,
                'co_stat_data' => 'A',
            ),
            930 =>
            array(
                'id' => 2263,
                'co_prrq_asap' => '01',
                'nombre' => 'CAP MONSEÑOR JOSE VICENTE DE UNDA',
                'municipio_id' => 352,
                'co_stat_data' => 'A',
            ),
            931 =>
            array(
                'id' => 2264,
                'co_prrq_asap' => '02',
                'nombre' => 'PEÑA BLANCA',
                'municipio_id' => 352,
                'co_stat_data' => 'A',
            ),
            932 =>
            array(
                'id' => 2266,
                'co_prrq_asap' => '02',
                'nombre' => 'APARICION',
                'municipio_id' => 353,
                'co_stat_data' => 'A',
            ),
            933 =>
            array(
                'id' => 2265,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL OSPINO',
                'municipio_id' => 353,
                'co_stat_data' => 'A',
            ),
            934 =>
            array(
                'id' => 2511,
                'co_prrq_asap' => '03',
                'nombre' => 'LA ESTACION',
                'municipio_id' => 353,
                'co_stat_data' => 'A',
            ),
            935 =>
            array(
                'id' => 2269,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PAPELON',
                'municipio_id' => 354,
                'co_stat_data' => 'A',
            ),
            936 =>
            array(
                'id' => 2270,
                'co_prrq_asap' => '02',
                'nombre' => 'CAÑO DELGADITO',
                'municipio_id' => 354,
                'co_stat_data' => 'A',
            ),
            937 =>
            array(
                'id' => 2272,
                'co_prrq_asap' => '02',
                'nombre' => 'ANTOLIN TOVAR',
                'municipio_id' => 355,
                'co_stat_data' => 'A',
            ),
            938 =>
            array(
                'id' => 2271,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SAN GENARO DE BOCONOITO',
                'municipio_id' => 355,
                'co_stat_data' => 'A',
            ),
            939 =>
            array(
                'id' => 2273,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SAN RAFAEL DE ONOTO',
                'municipio_id' => 356,
                'co_stat_data' => 'A',
            ),
            940 =>
            array(
                'id' => 2274,
                'co_prrq_asap' => '02',
                'nombre' => 'SANTA FE',
                'municipio_id' => 356,
                'co_stat_data' => 'A',
            ),
            941 =>
            array(
                'id' => 2275,
                'co_prrq_asap' => '03',
                'nombre' => 'THERMO MORLES',
                'municipio_id' => 356,
                'co_stat_data' => 'A',
            ),
            942 =>
            array(
                'id' => 2276,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SANTA ROSALIA',
                'municipio_id' => 357,
                'co_stat_data' => 'A',
            ),
            943 =>
            array(
                'id' => 2277,
                'co_prrq_asap' => '02',
                'nombre' => 'FLORIDA',
                'municipio_id' => 357,
                'co_stat_data' => 'A',
            ),
            944 =>
            array(
                'id' => 2278,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SUCRE',
                'municipio_id' => 358,
                'co_stat_data' => 'A',
            ),
            945 =>
            array(
                'id' => 2279,
                'co_prrq_asap' => '02',
                'nombre' => 'CONCEPCION',
                'municipio_id' => 358,
                'co_stat_data' => 'A',
            ),
            946 =>
            array(
                'id' => 2282,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN JOSE DE SAGUAZ',
                'municipio_id' => 358,
                'co_stat_data' => 'A',
            ),
            947 =>
            array(
                'id' => 2280,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN RAFAEL DE PALO ALZADO',
                'municipio_id' => 358,
                'co_stat_data' => 'A',
            ),
            948 =>
            array(
                'id' => 2281,
                'co_prrq_asap' => '04',
                'nombre' => 'UVENCIO ANTONIO VELASQUEZ',
                'municipio_id' => 358,
                'co_stat_data' => 'A',
            ),
            949 =>
            array(
                'id' => 2283,
                'co_prrq_asap' => '06',
                'nombre' => 'VILLA ROSA',
                'municipio_id' => 358,
                'co_stat_data' => 'A',
            ),
            950 =>
            array(
                'id' => 2285,
                'co_prrq_asap' => '02',
                'nombre' => 'CANELONES',
                'municipio_id' => 359,
                'co_stat_data' => 'A',
            ),
            951 =>
            array(
                'id' => 2284,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL TUREN',
                'municipio_id' => 359,
                'co_stat_data' => 'A',
            ),
            952 =>
            array(
                'id' => 2287,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN ISIDRO LABRADOR',
                'municipio_id' => 359,
                'co_stat_data' => 'A',
            ),
            953 =>
            array(
                'id' => 2286,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTA CRUZ',
                'municipio_id' => 359,
                'co_stat_data' => 'A',
            ),
            954 =>
            array(
                'id' => 2288,
                'co_prrq_asap' => '01',
                'nombre' => 'MARIÑO',
                'municipio_id' => 360,
                'co_stat_data' => 'A',
            ),
            955 =>
            array(
                'id' => 2289,
                'co_prrq_asap' => '02',
                'nombre' => 'ROMULO GALLEGOS',
                'municipio_id' => 360,
                'co_stat_data' => 'A',
            ),
            956 =>
            array(
                'id' => 2290,
                'co_prrq_asap' => '01',
                'nombre' => 'SAN JOSE DE AEROCUAR',
                'municipio_id' => 361,
                'co_stat_data' => 'A',
            ),
            957 =>
            array(
                'id' => 2291,
                'co_prrq_asap' => '02',
                'nombre' => 'TAVERA ACOSTA',
                'municipio_id' => 361,
                'co_stat_data' => 'A',
            ),
            958 =>
            array(
                'id' => 2293,
                'co_prrq_asap' => '02',
                'nombre' => 'ANTONIO JOSE DE SUCRE',
                'municipio_id' => 362,
                'co_stat_data' => 'A',
            ),
            959 =>
            array(
                'id' => 2294,
                'co_prrq_asap' => '03',
                'nombre' => 'EL MORRO DE PUERTO SANTO',
                'municipio_id' => 362,
                'co_stat_data' => 'A',
            ),
            960 =>
            array(
                'id' => 2295,
                'co_prrq_asap' => '04',
                'nombre' => 'PUERTO SANTO',
                'municipio_id' => 362,
                'co_stat_data' => 'A',
            ),
            961 =>
            array(
                'id' => 2292,
                'co_prrq_asap' => '01',
                'nombre' => 'RIO CARIBE',
                'municipio_id' => 362,
                'co_stat_data' => 'A',
            ),
            962 =>
            array(
                'id' => 2296,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN JUAN DE LAS GALDONAS',
                'municipio_id' => 362,
                'co_stat_data' => 'A',
            ),
            963 =>
            array(
                'id' => 2297,
                'co_prrq_asap' => '01',
                'nombre' => 'EL PILAR',
                'municipio_id' => 363,
                'co_stat_data' => 'A',
            ),
            964 =>
            array(
                'id' => 2298,
                'co_prrq_asap' => '02',
                'nombre' => 'EL RINCON',
                'municipio_id' => 363,
                'co_stat_data' => 'A',
            ),
            965 =>
            array(
                'id' => 2299,
                'co_prrq_asap' => '03',
                'nombre' => 'GRAL FRANCISCO ANTONIO VASQUEZ',
                'municipio_id' => 363,
                'co_stat_data' => 'A',
            ),
            966 =>
            array(
                'id' => 2300,
                'co_prrq_asap' => '04',
                'nombre' => 'GUARAUNOS',
                'municipio_id' => 363,
                'co_stat_data' => 'A',
            ),
            967 =>
            array(
                'id' => 2301,
                'co_prrq_asap' => '05',
                'nombre' => 'TUNAPUICITO',
                'municipio_id' => 363,
                'co_stat_data' => 'A',
            ),
            968 =>
            array(
                'id' => 2302,
                'co_prrq_asap' => '06',
                'nombre' => 'UNION',
                'municipio_id' => 363,
                'co_stat_data' => 'A',
            ),
            969 =>
            array(
                'id' => 2303,
                'co_prrq_asap' => '01',
                'nombre' => 'BOLIVAR',
                'municipio_id' => 364,
                'co_stat_data' => 'A',
            ),
            970 =>
            array(
                'id' => 2304,
                'co_prrq_asap' => '02',
                'nombre' => 'MACARAPANA',
                'municipio_id' => 364,
                'co_stat_data' => 'A',
            ),
            971 =>
            array(
                'id' => 2305,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTA CATALINA',
                'municipio_id' => 364,
                'co_stat_data' => 'A',
            ),
            972 =>
            array(
                'id' => 2306,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA ROSA',
                'municipio_id' => 364,
                'co_stat_data' => 'A',
            ),
            973 =>
            array(
                'id' => 2307,
                'co_prrq_asap' => '05',
                'nombre' => 'SANTA TERESA',
                'municipio_id' => 364,
                'co_stat_data' => 'A',
            ),
            974 =>
            array(
                'id' => 2308,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL BOLIVAR',
                'municipio_id' => 365,
                'co_stat_data' => 'A',
            ),
            975 =>
            array(
                'id' => 2310,
                'co_prrq_asap' => '02',
                'nombre' => 'EL PAUJIL',
                'municipio_id' => 366,
                'co_stat_data' => 'A',
            ),
            976 =>
            array(
                'id' => 2311,
                'co_prrq_asap' => '03',
                'nombre' => 'LIBERTAD',
                'municipio_id' => 366,
                'co_stat_data' => 'A',
            ),
            977 =>
            array(
                'id' => 2309,
                'co_prrq_asap' => '01',
                'nombre' => 'YAGUARAPARO',
                'municipio_id' => 366,
                'co_stat_data' => 'A',
            ),
            978 =>
            array(
                'id' => 2312,
                'co_prrq_asap' => '01',
                'nombre' => 'ARAYA',
                'municipio_id' => 367,
                'co_stat_data' => 'A',
            ),
            979 =>
            array(
                'id' => 2313,
                'co_prrq_asap' => '02',
                'nombre' => 'CHACOPATA',
                'municipio_id' => 367,
                'co_stat_data' => 'A',
            ),
            980 =>
            array(
                'id' => 2314,
                'co_prrq_asap' => '03',
                'nombre' => 'MANICUARE',
                'municipio_id' => 367,
                'co_stat_data' => 'A',
            ),
            981 =>
            array(
                'id' => 2316,
                'co_prrq_asap' => '02',
                'nombre' => 'CAMPO ELIAS',
                'municipio_id' => 368,
                'co_stat_data' => 'A',
            ),
            982 =>
            array(
                'id' => 2315,
                'co_prrq_asap' => '01',
                'nombre' => 'TUNAPUY',
                'municipio_id' => 368,
                'co_stat_data' => 'A',
            ),
            983 =>
            array(
                'id' => 2318,
                'co_prrq_asap' => '02',
                'nombre' => 'CAMPO CLARO',
                'municipio_id' => 369,
                'co_stat_data' => 'A',
            ),
            984 =>
            array(
                'id' => 2317,
                'co_prrq_asap' => '01',
                'nombre' => 'IRAPA',
                'municipio_id' => 369,
                'co_stat_data' => 'A',
            ),
            985 =>
            array(
                'id' => 2319,
                'co_prrq_asap' => '03',
                'nombre' => 'MARABAL',
                'municipio_id' => 369,
                'co_stat_data' => 'A',
            ),
            986 =>
            array(
                'id' => 2320,
                'co_prrq_asap' => '04',
                'nombre' => 'SAN ANTONIO DE IRAPA',
                'municipio_id' => 369,
                'co_stat_data' => 'A',
            ),
            987 =>
            array(
                'id' => 2321,
                'co_prrq_asap' => '05',
                'nombre' => 'SORO',
                'municipio_id' => 369,
                'co_stat_data' => 'A',
            ),
            988 =>
            array(
                'id' => 2322,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL MEJIA',
                'municipio_id' => 370,
                'co_stat_data' => 'A',
            ),
            989 =>
            array(
                'id' => 2324,
                'co_prrq_asap' => '02',
                'nombre' => 'ARENAS',
                'municipio_id' => 371,
                'co_stat_data' => 'A',
            ),
            990 =>
            array(
                'id' => 2325,
                'co_prrq_asap' => '03',
                'nombre' => 'ARICAGUA',
                'municipio_id' => 371,
                'co_stat_data' => 'A',
            ),
            991 =>
            array(
                'id' => 2326,
                'co_prrq_asap' => '04',
                'nombre' => 'COCOLLAR',
                'municipio_id' => 371,
                'co_stat_data' => 'A',
            ),
            992 =>
            array(
                'id' => 2323,
                'co_prrq_asap' => '01',
                'nombre' => 'CUMANACOA',
                'municipio_id' => 371,
                'co_stat_data' => 'A',
            ),
            993 =>
            array(
                'id' => 2327,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN FERNANDO',
                'municipio_id' => 371,
                'co_stat_data' => 'A',
            ),
            994 =>
            array(
                'id' => 2328,
                'co_prrq_asap' => '06',
                'nombre' => 'SAN LORENZO',
                'municipio_id' => 371,
                'co_stat_data' => 'A',
            ),
            995 =>
            array(
                'id' => 2330,
                'co_prrq_asap' => '02',
                'nombre' => 'CATUARO',
                'municipio_id' => 372,
                'co_stat_data' => 'A',
            ),
            996 =>
            array(
                'id' => 2331,
                'co_prrq_asap' => '03',
                'nombre' => 'RENDON',
                'municipio_id' => 372,
                'co_stat_data' => 'A',
            ),
            997 =>
            array(
                'id' => 2332,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA CRUZ',
                'municipio_id' => 372,
                'co_stat_data' => 'A',
            ),
            998 =>
            array(
                'id' => 2333,
                'co_prrq_asap' => '05',
                'nombre' => 'SANTA MARIA',
                'municipio_id' => 372,
                'co_stat_data' => 'A',
            ),
            999 =>
            array(
                'id' => 2329,
                'co_prrq_asap' => '01',
                'nombre' => 'VILLA FRONTADO',
                'municipio_id' => 372,
                'co_stat_data' => 'A',
            ),
            1000 =>
            array(
                'id' => 2334,
                'co_prrq_asap' => '01',
                'nombre' => 'ALTAGRACIA',
                'municipio_id' => 373,
                'co_stat_data' => 'A',
            ),
            1001 =>
            array(
                'id' => 2335,
                'co_prrq_asap' => '02',
                'nombre' => 'AYACUCHO',
                'municipio_id' => 373,
                'co_stat_data' => 'A',
            ),
            1002 =>
            array(
                'id' => 2339,
                'co_prrq_asap' => '06',
                'nombre' => 'RAUL LEONI',
                'municipio_id' => 373,
                'co_stat_data' => 'A',
            ),
            1003 =>
            array(
                'id' => 2338,
                'co_prrq_asap' => '05',
                'nombre' => 'SAN JUAN',
                'municipio_id' => 373,
                'co_stat_data' => 'A',
            ),
            1004 =>
            array(
                'id' => 2340,
                'co_prrq_asap' => '07',
                'nombre' => 'SANTA FE',
                'municipio_id' => 373,
                'co_stat_data' => 'A',
            ),
            1005 =>
            array(
                'id' => 2336,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTA INES',
                'municipio_id' => 373,
                'co_stat_data' => 'A',
            ),
            1006 =>
            array(
                'id' => 2337,
                'co_prrq_asap' => '04',
                'nombre' => 'VALENTIN VALIENTE',
                'municipio_id' => 373,
                'co_stat_data' => 'A',
            ),
            1007 =>
            array(
                'id' => 2342,
                'co_prrq_asap' => '02',
                'nombre' => 'BIDEAU',
                'municipio_id' => 374,
                'co_stat_data' => 'A',
            ),
            1008 =>
            array(
                'id' => 2343,
                'co_prrq_asap' => '03',
                'nombre' => 'CRISTOBAL COLON',
                'municipio_id' => 374,
                'co_stat_data' => 'A',
            ),
            1009 =>
            array(
                'id' => 2341,
                'co_prrq_asap' => '01',
                'nombre' => 'GUIRIA',
                'municipio_id' => 374,
                'co_stat_data' => 'A',
            ),
            1010 =>
            array(
                'id' => 2344,
                'co_prrq_asap' => '04',
                'nombre' => 'PUNTA DE PIEDRAS',
                'municipio_id' => 374,
                'co_stat_data' => 'A',
            ),
            1011 =>
            array(
                'id' => 2346,
                'co_prrq_asap' => '02',
                'nombre' => 'ARAGUANEY',
                'municipio_id' => 375,
                'co_stat_data' => 'A',
            ),
            1012 =>
            array(
                'id' => 2347,
                'co_prrq_asap' => '03',
                'nombre' => 'EL JAGUITO',
                'municipio_id' => 375,
                'co_stat_data' => 'A',
            ),
            1013 =>
            array(
                'id' => 2348,
                'co_prrq_asap' => '04',
                'nombre' => 'LA ESPERANZA',
                'municipio_id' => 375,
                'co_stat_data' => 'A',
            ),
            1014 =>
            array(
                'id' => 2345,
                'co_prrq_asap' => '01',
                'nombre' => 'SANTA ISABEL',
                'municipio_id' => 375,
                'co_stat_data' => 'A',
            ),
            1015 =>
            array(
                'id' => 2352,
                'co_prrq_asap' => '04',
                'nombre' => 'AYACUCHO',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1016 =>
            array(
                'id' => 2349,
                'co_prrq_asap' => '01',
                'nombre' => 'BOCONO',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1017 =>
            array(
                'id' => 2353,
                'co_prrq_asap' => '05',
                'nombre' => 'BURBUSAY',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1018 =>
            array(
                'id' => 2350,
                'co_prrq_asap' => '02',
                'nombre' => 'EL CARMEN',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1019 =>
            array(
                'id' => 2354,
                'co_prrq_asap' => '06',
                'nombre' => 'GENERAL RIVAS',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1020 =>
            array(
                'id' => 2355,
                'co_prrq_asap' => '07',
                'nombre' => 'GUARAMACAL',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1021 =>
            array(
                'id' => 2357,
                'co_prrq_asap' => '09',
                'nombre' => 'MONSEÑOR JAUREGUI',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1022 =>
            array(
                'id' => 2351,
                'co_prrq_asap' => '03',
                'nombre' => 'MOSQUEY',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1023 =>
            array(
                'id' => 2358,
                'co_prrq_asap' => '10',
                'nombre' => 'RAFAEL RANGEL',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1024 =>
            array(
                'id' => 2360,
                'co_prrq_asap' => '12',
                'nombre' => 'SAN JOSE',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1025 =>
            array(
                'id' => 2359,
                'co_prrq_asap' => '11',
                'nombre' => 'SAN MIGUEL',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1026 =>
            array(
                'id' => 2356,
                'co_prrq_asap' => '08',
                'nombre' => 'VEGA DE GUARAMACAL',
                'municipio_id' => 376,
                'co_stat_data' => 'A',
            ),
            1027 =>
            array(
                'id' => 2362,
                'co_prrq_asap' => '02',
                'nombre' => 'CHEREGUE',
                'municipio_id' => 377,
                'co_stat_data' => 'A',
            ),
            1028 =>
            array(
                'id' => 2363,
                'co_prrq_asap' => '03',
                'nombre' => 'GRANADOS',
                'municipio_id' => 377,
                'co_stat_data' => 'A',
            ),
            1029 =>
            array(
                'id' => 2361,
                'co_prrq_asap' => '01',
                'nombre' => 'SABANA GRANDE',
                'municipio_id' => 377,
                'co_stat_data' => 'A',
            ),
            1030 =>
            array(
                'id' => 2365,
                'co_prrq_asap' => '02',
                'nombre' => 'ARNOLDO GABALDON',
                'municipio_id' => 378,
                'co_stat_data' => 'A',
            ),
            1031 =>
            array(
                'id' => 2366,
                'co_prrq_asap' => '03',
                'nombre' => 'BOLIVIA',
                'municipio_id' => 378,
                'co_stat_data' => 'A',
            ),
            1032 =>
            array(
                'id' => 2367,
                'co_prrq_asap' => '04',
                'nombre' => 'CARILLO',
                'municipio_id' => 378,
                'co_stat_data' => 'A',
            ),
            1033 =>
            array(
                'id' => 2368,
                'co_prrq_asap' => '05',
                'nombre' => 'CEGARRA',
                'municipio_id' => 378,
                'co_stat_data' => 'A',
            ),
            1034 =>
            array(
                'id' => 2364,
                'co_prrq_asap' => '01',
                'nombre' => 'CHEJENDE',
                'municipio_id' => 378,
                'co_stat_data' => 'A',
            ),
            1035 =>
            array(
                'id' => 2369,
                'co_prrq_asap' => '06',
                'nombre' => 'MANUEL SALVADOR ULLOA',
                'municipio_id' => 378,
                'co_stat_data' => 'A',
            ),
            1036 =>
            array(
                'id' => 2370,
                'co_prrq_asap' => '07',
                'nombre' => 'SAN JOSE',
                'municipio_id' => 378,
                'co_stat_data' => 'A',
            ),
            1037 =>
            array(
                'id' => 2371,
                'co_prrq_asap' => '01',
                'nombre' => 'CARACHE',
                'municipio_id' => 379,
                'co_stat_data' => 'A',
            ),
            1038 =>
            array(
                'id' => 2372,
                'co_prrq_asap' => '02',
                'nombre' => 'CUICAS',
                'municipio_id' => 379,
                'co_stat_data' => 'A',
            ),
            1039 =>
            array(
                'id' => 2373,
                'co_prrq_asap' => '03',
                'nombre' => 'LA CONCEPCION',
                'municipio_id' => 379,
                'co_stat_data' => 'A',
            ),
            1040 =>
            array(
                'id' => 2374,
                'co_prrq_asap' => '04',
                'nombre' => 'PANAMERICANA',
                'municipio_id' => 379,
                'co_stat_data' => 'A',
            ),
            1041 =>
            array(
                'id' => 2375,
                'co_prrq_asap' => '05',
                'nombre' => 'SANTA CRUZ',
                'municipio_id' => 379,
                'co_stat_data' => 'A',
            ),
            1042 =>
            array(
                'id' => 2376,
                'co_prrq_asap' => '01',
                'nombre' => 'ESCUQUE',
                'municipio_id' => 380,
                'co_stat_data' => 'A',
            ),
            1043 =>
            array(
                'id' => 2377,
                'co_prrq_asap' => '02',
                'nombre' => 'LA UNION',
                'municipio_id' => 380,
                'co_stat_data' => 'A',
            ),
            1044 =>
            array(
                'id' => 2378,
                'co_prrq_asap' => '03',
                'nombre' => 'SABANA LIBRE',
                'municipio_id' => 380,
                'co_stat_data' => 'A',
            ),
            1045 =>
            array(
                'id' => 2379,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA RITA',
                'municipio_id' => 380,
                'co_stat_data' => 'A',
            ),
            1046 =>
            array(
                'id' => 2381,
                'co_prrq_asap' => '02',
                'nombre' => 'ANTONIO JOSE DE SUCRE',
                'municipio_id' => 381,
                'co_stat_data' => 'A',
            ),
            1047 =>
            array(
                'id' => 2380,
                'co_prrq_asap' => '01',
                'nombre' => 'EL SOCORRO',
                'municipio_id' => 381,
                'co_stat_data' => 'A',
            ),
            1048 =>
            array(
                'id' => 2382,
                'co_prrq_asap' => '03',
                'nombre' => 'LOS CAPRICHOS',
                'municipio_id' => 381,
                'co_stat_data' => 'A',
            ),
            1049 =>
            array(
                'id' => 2384,
                'co_prrq_asap' => '02',
                'nombre' => 'ARNOLDO GABALDON',
                'municipio_id' => 382,
                'co_stat_data' => 'A',
            ),
            1050 =>
            array(
                'id' => 2383,
                'co_prrq_asap' => '01',
                'nombre' => 'CAMPO ELIAS',
                'municipio_id' => 382,
                'co_stat_data' => 'A',
            ),
            1051 =>
            array(
                'id' => 2386,
                'co_prrq_asap' => '02',
                'nombre' => 'EL PROGRESO',
                'municipio_id' => 383,
                'co_stat_data' => 'A',
            ),
            1052 =>
            array(
                'id' => 2387,
                'co_prrq_asap' => '03',
                'nombre' => 'LA CEIBA',
                'municipio_id' => 383,
                'co_stat_data' => 'A',
            ),
            1053 =>
            array(
                'id' => 2385,
                'co_prrq_asap' => '01',
                'nombre' => 'SANTA APOLONIA',
                'municipio_id' => 383,
                'co_stat_data' => 'A',
            ),
            1054 =>
            array(
                'id' => 2388,
                'co_prrq_asap' => '04',
                'nombre' => 'TRES DE FEBRERO',
                'municipio_id' => 383,
                'co_stat_data' => 'A',
            ),
            1055 =>
            array(
                'id' => 2391,
                'co_prrq_asap' => '03',
                'nombre' => 'AGUA CALIENTE',
                'municipio_id' => 384,
                'co_stat_data' => 'A',
            ),
            1056 =>
            array(
                'id' => 2390,
                'co_prrq_asap' => '02',
                'nombre' => 'AGUA SANTA',
                'municipio_id' => 384,
                'co_stat_data' => 'A',
            ),
            1057 =>
            array(
                'id' => 2392,
                'co_prrq_asap' => '04',
                'nombre' => 'EL CENIZO',
                'municipio_id' => 384,
                'co_stat_data' => 'A',
            ),
            1058 =>
            array(
                'id' => 2389,
                'co_prrq_asap' => '01',
                'nombre' => 'EL DIVIDIVE',
                'municipio_id' => 384,
                'co_stat_data' => 'A',
            ),
            1059 =>
            array(
                'id' => 2393,
                'co_prrq_asap' => '05',
                'nombre' => 'VALERITA',
                'municipio_id' => 384,
                'co_stat_data' => 'A',
            ),
            1060 =>
            array(
                'id' => 2395,
                'co_prrq_asap' => '02',
                'nombre' => 'BUENA VISTA',
                'municipio_id' => 385,
                'co_stat_data' => 'A',
            ),
            1061 =>
            array(
                'id' => 2394,
                'co_prrq_asap' => '01',
                'nombre' => 'MONTE CARMELO',
                'municipio_id' => 385,
                'co_stat_data' => 'A',
            ),
            1062 =>
            array(
                'id' => 2396,
                'co_prrq_asap' => '03',
                'nombre' => 'SANTA MARIA DEL HORCON',
                'municipio_id' => 385,
                'co_stat_data' => 'A',
            ),
            1063 =>
            array(
                'id' => 2398,
                'co_prrq_asap' => '02',
                'nombre' => 'EL BAÑO',
                'municipio_id' => 386,
                'co_stat_data' => 'A',
            ),
            1064 =>
            array(
                'id' => 2399,
                'co_prrq_asap' => '03',
                'nombre' => 'JALISCO',
                'municipio_id' => 386,
                'co_stat_data' => 'A',
            ),
            1065 =>
            array(
                'id' => 2397,
                'co_prrq_asap' => '01',
                'nombre' => 'MOTATAN',
                'municipio_id' => 386,
                'co_stat_data' => 'A',
            ),
            1066 =>
            array(
                'id' => 2401,
                'co_prrq_asap' => '02',
                'nombre' => 'FLOR DE PATRIA',
                'municipio_id' => 387,
                'co_stat_data' => 'A',
            ),
            1067 =>
            array(
                'id' => 2402,
                'co_prrq_asap' => '03',
                'nombre' => 'LA PAZ',
                'municipio_id' => 387,
                'co_stat_data' => 'A',
            ),
            1068 =>
            array(
                'id' => 2400,
                'co_prrq_asap' => '01',
                'nombre' => 'PAMPAN',
                'municipio_id' => 387,
                'co_stat_data' => 'A',
            ),
            1069 =>
            array(
                'id' => 2403,
                'co_prrq_asap' => '04',
                'nombre' => 'SANTA ANA',
                'municipio_id' => 387,
                'co_stat_data' => 'A',
            ),
            1070 =>
            array(
                'id' => 2405,
                'co_prrq_asap' => '02',
                'nombre' => 'LA CONCEPCION',
                'municipio_id' => 388,
                'co_stat_data' => 'A',
            ),
            1071 =>
            array(
                'id' => 2404,
                'co_prrq_asap' => '01',
                'nombre' => 'PAMPANITO',
                'municipio_id' => 388,
                'co_stat_data' => 'A',
            ),
            1072 =>
            array(
                'id' => 2406,
                'co_prrq_asap' => '03',
                'nombre' => 'PAMPANITO II',
                'municipio_id' => 388,
                'co_stat_data' => 'A',
            ),
            1073 =>
            array(
                'id' => 2407,
                'co_prrq_asap' => '01',
                'nombre' => 'BETIJOQUE',
                'municipio_id' => 389,
                'co_stat_data' => 'A',
            ),
            1074 =>
            array(
                'id' => 2410,
                'co_prrq_asap' => '04',
                'nombre' => 'JOSE GREGORIO HERNANDEZ',
                'municipio_id' => 389,
                'co_stat_data' => 'A',
            ),
            1075 =>
            array(
                'id' => 2408,
                'co_prrq_asap' => '02',
                'nombre' => 'LA PUEBLITA',
                'municipio_id' => 389,
                'co_stat_data' => 'A',
            ),
            1076 =>
            array(
                'id' => 2409,
                'co_prrq_asap' => '03',
                'nombre' => 'LOS CEDROS',
                'municipio_id' => 389,
                'co_stat_data' => 'A',
            ),
            1077 =>
            array(
                'id' => 2412,
                'co_prrq_asap' => '02',
                'nombre' => 'ANTONIO NICOLAS BRICEÑO',
                'municipio_id' => 390,
                'co_stat_data' => 'A',
            ),
            1078 =>
            array(
                'id' => 2413,
                'co_prrq_asap' => '03',
                'nombre' => 'CAMPO ALEGRE',
                'municipio_id' => 390,
                'co_stat_data' => 'A',
            ),
            1079 =>
            array(
                'id' => 2411,
                'co_prrq_asap' => '01',
                'nombre' => 'CARVAJAL',
                'municipio_id' => 390,
                'co_stat_data' => 'A',
            ),
            1080 =>
            array(
                'id' => 2515,
                'co_prrq_asap' => '04',
                'nombre' => 'JOSE LEONARDO SUAREZ',
                'municipio_id' => 390,
                'co_stat_data' => 'A',
            ),
            1081 =>
            array(
                'id' => 2415,
                'co_prrq_asap' => '02',
                'nombre' => 'EL PARAISO',
                'municipio_id' => 391,
                'co_stat_data' => 'A',
            ),
            1082 =>
            array(
                'id' => 2416,
                'co_prrq_asap' => '03',
                'nombre' => 'JUNIN',
                'municipio_id' => 391,
                'co_stat_data' => 'A',
            ),
            1083 =>
            array(
                'id' => 2414,
                'co_prrq_asap' => '01',
                'nombre' => 'SABANA DE MENDOZA',
                'municipio_id' => 391,
                'co_stat_data' => 'A',
            ),
            1084 =>
            array(
                'id' => 2417,
                'co_prrq_asap' => '04',
                'nombre' => 'VALMORE RODRIGUEZ',
                'municipio_id' => 391,
                'co_stat_data' => 'A',
            ),
            1085 =>
            array(
                'id' => 2418,
                'co_prrq_asap' => '01',
                'nombre' => 'ANDRES LINARES',
                'municipio_id' => 392,
                'co_stat_data' => 'A',
            ),
            1086 =>
            array(
                'id' => 2419,
                'co_prrq_asap' => '02',
                'nombre' => 'CHIQUINQUIRA',
                'municipio_id' => 392,
                'co_stat_data' => 'A',
            ),
            1087 =>
            array(
                'id' => 2420,
                'co_prrq_asap' => '03',
                'nombre' => 'CRISTOBAL MENDOZA',
                'municipio_id' => 392,
                'co_stat_data' => 'A',
            ),
            1088 =>
            array(
                'id' => 2421,
                'co_prrq_asap' => '04',
                'nombre' => 'CRUZ CARILLO',
                'municipio_id' => 392,
                'co_stat_data' => 'A',
            ),
            1089 =>
            array(
                'id' => 2422,
                'co_prrq_asap' => '05',
                'nombre' => 'MATRIZ',
                'municipio_id' => 392,
                'co_stat_data' => 'A',
            ),
            1090 =>
            array(
                'id' => 2423,
                'co_prrq_asap' => '06',
                'nombre' => 'MONSEÑOR CARILLO',
                'municipio_id' => 392,
                'co_stat_data' => 'A',
            ),
            1091 =>
            array(
                'id' => 2424,
                'co_prrq_asap' => '07',
                'nombre' => 'TRES ESQUINAS',
                'municipio_id' => 392,
                'co_stat_data' => 'A',
            ),
            1092 =>
            array(
                'id' => 2426,
                'co_prrq_asap' => '02',
                'nombre' => 'CABIMBU',
                'municipio_id' => 393,
                'co_stat_data' => 'A',
            ),
            1093 =>
            array(
                'id' => 2427,
                'co_prrq_asap' => '03',
                'nombre' => 'JAJO',
                'municipio_id' => 393,
                'co_stat_data' => 'A',
            ),
            1094 =>
            array(
                'id' => 2428,
                'co_prrq_asap' => '04',
                'nombre' => 'LA MESA DE ESNUJAQUE',
                'municipio_id' => 393,
                'co_stat_data' => 'A',
            ),
            1095 =>
            array(
                'id' => 2425,
                'co_prrq_asap' => '01',
                'nombre' => 'LA QUEBRADA',
                'municipio_id' => 393,
                'co_stat_data' => 'A',
            ),
            1096 =>
            array(
                'id' => 2429,
                'co_prrq_asap' => '05',
                'nombre' => 'SANTIAGO',
                'municipio_id' => 393,
                'co_stat_data' => 'A',
            ),
            1097 =>
            array(
                'id' => 2430,
                'co_prrq_asap' => '06',
                'nombre' => 'TUÑAME',
                'municipio_id' => 393,
                'co_stat_data' => 'A',
            ),
            1098 =>
            array(
                'id' => 2435,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL ARISTIDES BASTIDAS',
                'municipio_id' => 394,
                'co_stat_data' => 'A',
            ),
            1099 =>
            array(
                'id' => 2436,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL BOLIVAR',
                'municipio_id' => 395,
                'co_stat_data' => 'A',
            ),
            1100 =>
            array(
                'id' => 2438,
                'co_prrq_asap' => '02',
                'nombre' => 'CAMPO ELIAS',
                'municipio_id' => 396,
                'co_stat_data' => 'A',
            ),
            1101 =>
            array(
                'id' => 2437,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL BRUZUAL',
                'municipio_id' => 396,
                'co_stat_data' => 'A',
            ),
            1102 =>
            array(
                'id' => 2439,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL COCOROTE',
                'municipio_id' => 397,
                'co_stat_data' => 'A',
            ),
            1103 =>
            array(
                'id' => 2440,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL INDEPENDENCIA',
                'municipio_id' => 398,
                'co_stat_data' => 'A',
            ),
            1104 =>
            array(
                'id' => 2441,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL JOSE ANTONIO PAEZ',
                'municipio_id' => 399,
                'co_stat_data' => 'A',
            ),
            1105 =>
            array(
                'id' => 2442,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL LA TRINIDAD',
                'municipio_id' => 400,
                'co_stat_data' => 'A',
            ),
            1106 =>
            array(
                'id' => 2443,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL MANUEL MONGE',
                'municipio_id' => 401,
                'co_stat_data' => 'A',
            ),
            1107 =>
            array(
                'id' => 2444,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL NIRGUA',
                'municipio_id' => 402,
                'co_stat_data' => 'A',
            ),
            1108 =>
            array(
                'id' => 2445,
                'co_prrq_asap' => '02',
                'nombre' => 'SALOM',
                'municipio_id' => 402,
                'co_stat_data' => 'A',
            ),
            1109 =>
            array(
                'id' => 2446,
                'co_prrq_asap' => '03',
                'nombre' => 'TEMERLA',
                'municipio_id' => 402,
                'co_stat_data' => 'A',
            ),
            1110 =>
            array(
                'id' => 2447,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL PEÑA',
                'municipio_id' => 403,
                'co_stat_data' => 'A',
            ),
            1111 =>
            array(
                'id' => 2448,
                'co_prrq_asap' => '02',
                'nombre' => 'SAN ANDRES',
                'municipio_id' => 403,
                'co_stat_data' => 'A',
            ),
            1112 =>
            array(
                'id' => 2450,
                'co_prrq_asap' => '02',
                'nombre' => 'ALBARICO',
                'municipio_id' => 404,
                'co_stat_data' => 'A',
            ),
            1113 =>
            array(
                'id' => 2449,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SAN FELIPE',
                'municipio_id' => 404,
                'co_stat_data' => 'A',
            ),
            1114 =>
            array(
                'id' => 2451,
                'co_prrq_asap' => '03',
                'nombre' => 'SAN JAVIER',
                'municipio_id' => 404,
                'co_stat_data' => 'A',
            ),
            1115 =>
            array(
                'id' => 2452,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL SUCRE',
                'municipio_id' => 405,
                'co_stat_data' => 'A',
            ),
            1116 =>
            array(
                'id' => 2453,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL URACHICHE',
                'municipio_id' => 406,
                'co_stat_data' => 'A',
            ),
            1117 =>
            array(
                'id' => 2454,
                'co_prrq_asap' => '01',
                'nombre' => 'CAPITAL VEROES',
                'municipio_id' => 407,
                'co_stat_data' => 'A',
            ),
            1118 =>
            array(
                'id' => 2455,
                'co_prrq_asap' => '02',
                'nombre' => 'EL GUAYABO',
                'municipio_id' => 407,
                'co_stat_data' => 'A',
            ),
            1119 =>
            array(
                'id' => 2456,
                'co_prrq_asap' => '01',
                'nombre' => 'CARABALLEDA',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1120 =>
            array(
                'id' => 2457,
                'co_prrq_asap' => '02',
                'nombre' => 'CARAYACA',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1121 =>
            array(
                'id' => 2517,
                'co_prrq_asap' => '11',
                'nombre' => 'CARLOS SOUBLETTE',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1122 =>
            array(
                'id' => 2458,
                'co_prrq_asap' => '03',
                'nombre' => 'CARUAO',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1123 =>
            array(
                'id' => 2459,
                'co_prrq_asap' => '04',
                'nombre' => 'CATIA LA MAR',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1124 =>
            array(
                'id' => 2460,
                'co_prrq_asap' => '05',
                'nombre' => 'EL JUNKO',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1125 =>
            array(
                'id' => 2461,
                'co_prrq_asap' => '06',
                'nombre' => 'LA GUAIRA',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1126 =>
            array(
                'id' => 2462,
                'co_prrq_asap' => '07',
                'nombre' => 'MACUTO',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1127 =>
            array(
                'id' => 2463,
                'co_prrq_asap' => '08',
                'nombre' => 'MAIQUETIA',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1128 =>
            array(
                'id' => 2464,
                'co_prrq_asap' => '09',
                'nombre' => 'NAIGUATA',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1129 =>
            array(
                'id' => 2516,
                'co_prrq_asap' => '10',
                'nombre' => 'RAUL LEONI',
                'municipio_id' => 408,
                'co_stat_data' => 'A',
            ),
            1130 =>
            array(
                'id' => 2655,
                'co_prrq_asap' => '05',
                'nombre' => 'AGUSTIN',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1131 =>
            array(
                'id' => 2664,
                'co_prrq_asap' => '14',
                'nombre' => 'BURRO',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1132 =>
            array(
                'id' => 2656,
                'co_prrq_asap' => '06',
                'nombre' => 'CAYO CARENERO',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1133 =>
            array(
                'id' => 2657,
                'co_prrq_asap' => '07',
                'nombre' => 'CAYO FERNANDO',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1134 =>
            array(
                'id' => 2653,
                'co_prrq_asap' => '03',
                'nombre' => 'CAYO PIRATA',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1135 =>
            array(
                'id' => 2662,
                'co_prrq_asap' => '12',
                'nombre' => 'CHIMANAS',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1136 =>
            array(
                'id' => 2654,
                'co_prrq_asap' => '04',
                'nombre' => 'CRASQUI',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1137 =>
            array(
                'id' => 2658,
                'co_prrq_asap' => '08',
                'nombre' => 'DOS MOSQUISES SUR',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1138 =>
            array(
                'id' => 2535,
                'co_prrq_asap' => '01',
                'nombre' => 'GRAN ROQUE',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1139 =>
            array(
                'id' => 2661,
                'co_prrq_asap' => '11',
                'nombre' => 'IGUANA',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1140 =>
            array(
                'id' => 2663,
                'co_prrq_asap' => '13',
                'nombre' => 'LA BORRACHA',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1141 =>
            array(
                'id' => 2659,
                'co_prrq_asap' => '09',
                'nombre' => 'LOS TESTIGOS',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1142 =>
            array(
                'id' => 2652,
                'co_prrq_asap' => '02',
                'nombre' => 'MADRISQUI',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1143 =>
            array(
                'id' => 2660,
                'co_prrq_asap' => '10',
                'nombre' => 'TESTIGOS GRANDES',
                'municipio_id' => 409,
                'co_stat_data' => 'A',
            ),
            1144 =>
            array(
                'id' => 2518,
                'co_prrq_asap' => '01',
                'nombre' => 'CAP OCUMARE DE LA COSTA DE ORO',
                'municipio_id' => 416,
                'co_stat_data' => 'A',
            ),
            1145 =>
            array(
                'id' => 2532,
                'co_prrq_asap' => '01',
                'nombre' => 'EL CANTON',
                'municipio_id' => 417,
                'co_stat_data' => 'A',
            ),
            1146 =>
            array(
                'id' => 2534,
                'co_prrq_asap' => '03',
                'nombre' => 'PUERTO VIVAS',
                'municipio_id' => 417,
                'co_stat_data' => 'A',
            ),
            1147 =>
            array(
                'id' => 2533,
                'co_prrq_asap' => '02',
                'nombre' => 'SANTA CRUZ DE GUACAS',
                'municipio_id' => 417,
                'co_stat_data' => 'A',
            ),
            1148 =>
            array(
                'id' => 2665,
                'co_prrq_asap' => '01',
                'nombre' => 'ARCHIPIELAGO LOS MONJES',
                'municipio_id' => 438,
                'co_stat_data' => 'A',
            ),
            1149 =>
            array(
                'id' => 2666,
                'co_prrq_asap' => '01',
                'nombre' => 'ARCHIPIELAGO LAS AVES',
                'municipio_id' => 439,
                'co_stat_data' => 'A',
            ),
            1150 =>
            array(
                'id' => 2667,
                'co_prrq_asap' => '01',
                'nombre' => 'ARCHIPIELAGO LA ORCHILA',
                'municipio_id' => 440,
                'co_stat_data' => 'A',
            ),
            1151 =>
            array(
                'id' => 2668,
                'co_prrq_asap' => '01',
                'nombre' => 'ARCHIPIELAGO LOS HERMANOS',
                'municipio_id' => 441,
                'co_stat_data' => 'A',
            ),
            1152 =>
            array(
                'id' => 2669,
                'co_prrq_asap' => '01',
                'nombre' => 'ARCHIPIELAGO LOS FRAILES',
                'municipio_id' => 442,
                'co_stat_data' => 'A',
            ),
            1153 =>
            array(
                'id' => 2670,
                'co_prrq_asap' => '01',
                'nombre' => 'ARCHIPIELAGO LOS TESTIGOS',
                'municipio_id' => 443,
                'co_stat_data' => 'A',
            ),
            1154 =>
            array(
                'id' => 2671,
                'co_prrq_asap' => '01',
                'nombre' => 'ISLA LA TORTUGA',
                'municipio_id' => 444,
                'co_stat_data' => 'A',
            ),
            1155 =>
            array(
                'id' => 2672,
                'co_prrq_asap' => '01',
                'nombre' => 'ISLA LA BLANQUILLA',
                'municipio_id' => 445,
                'co_stat_data' => 'A',
            ),
            1156 =>
            array(
                'id' => 2673,
                'co_prrq_asap' => '01',
                'nombre' => 'ISLA LA SOLA',
                'municipio_id' => 446,
                'co_stat_data' => 'A',
            ),
            1157 =>
            array(
                'id' => 2674,
                'co_prrq_asap' => '01',
                'nombre' => 'ISLA DE PATOS',
                'municipio_id' => 447,
                'co_stat_data' => 'A',
            ),
            1158 =>
            array(
                'id' => 2675,
                'co_prrq_asap' => '01',
                'nombre' => 'ISLA DE AVES',
                'municipio_id' => 448,
                'co_stat_data' => 'A',
            ),
        );
    }

}

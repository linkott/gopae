<?php

/**
 * Catalogo de Tipos de Menu
 *
 * @author Luis Zambrano
 */
class CTipoMenu extends CCatalogo {
    
    public static $columns = array('id', 'nombre', 'estatus', 'nombre_label');
    
    protected static function setData(){
        
        self::$data = array(
            1 => array(
                'id' => 1,
                'nombre' => 'DESAYUNO',
                'estatus' => 'A',
                'nombre_label' => 'label-info'
            ),
            2 => array(
                'id' => 2, 
                'nombre' => 'ALMUERZO',
                'estatus' => 'A',
                'nombre_label' => 'label-success'
            ),
            3 => array(
                'id' => 3, 
                'nombre' => 'MERIENDA',
                'estatus' => 'A',
                'nombre_label' => 'label-yellow'
            ),
            4 => array(
                'id' => 4, 
                'nombre' => 'CENA',
                'estatus' => 'A',
                'nombre_label' => 'label-important'
            ),
        );
        
        return self::$data;
        
    }
    
}

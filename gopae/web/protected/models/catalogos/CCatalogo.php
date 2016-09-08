<?php

/**
 * Description of CCatalogo
 *
 * @author gabriel
 */
class CCatalogo {
    
    protected static $data;
    
    protected static $columns = array();
    
    /**
     * Devuelve los datos de un catálogo standalone.
     * 
     * @param string $field String con el nombre del Campo por el cual se puede filtrar el contenido del arreglo de registros
     * @param mixed $value String, Int o Array de Valores por el cual se puede Filtrar a través del Campo indicado el contenido del arreglo de registros
     * @param bool $inverse Si su valor es "true" esto indicará que se hará el filtro de forma inversa
     * @param bool $inverse Si su valor es "true" esto indicará que se hará el filtro de forma inversa
     * @return array Arreglo asociativo con los datos del Catálogo
     */
    public static function getData($field=null, $value=null, $inverse=false, $careActiveData=false, $active=false) {
        static::setData();
        $response = null;
        $arrayData = static::$data;
        if(is_null($value) || is_null($field)){
            $response = $arrayData;
        }
        else{
            if(in_array($field, static::$columns) || array_key_exists($field, $arrayData[0])){
                foreach ($arrayData as $data){
                    if((self::filter($data, $field, $value, $inverse))){
                        if($careActiveData){
                            if(isset($data['estatus']) && $data['estatus']=='A'){
                                $response[] = $data;
                            }
                        }else{
                            $response[] = $data;
                        }
                    }
                }
            }
        }
        return $response;
    }
    
    protected static function filter($data, $field, $value, $inverse){
        $response = false;
        if($inverse){
            if(is_array($value)){
                $response = !(in_array($data[$field], $value));
            }
            else{
                $response = !$data[$field]==$value;
            }
        }
        else{
            if(is_array($value)){
                $response = (in_array($data[$field], $value));
            }
            else{
                $response = ($data[$field]==$value);
            }
        }
        return $response;
    }
    
}

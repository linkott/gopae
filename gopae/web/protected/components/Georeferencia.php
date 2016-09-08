<?php
/**
 * Clase que provee métodos de georeferenciación
 *
 * @author Nelson González y José Gabriel González <soporte.gescolar@me.gob.ve>
 */
class Georeferencia {
    
    
    /**
     * Este método permite obtener a partir de una fotografía (archivo) tomada con GPS la información georeferencial de una localidad.
     * Returns an array of latitude and longitude from the Image file
     * 
     * @param string $file Dirección en filesystem del archivo al que se le extraerá la información georeferencial
     * @return mixed number|boolean
     */
    public static function obtenerDetalleGeoreferencialDeArchivo($file){
        if (is_file($file)) {
            $info = exif_read_data($file);
            if (isset($info['GPSLatitude']) && isset($info['GPSLongitude']) &&
                isset($info['GPSLatitudeRef']) && isset($info['GPSLongitudeRef']) &&
                in_array($info['GPSLatitudeRef'], array('E','W','N','S')) && in_array($info['GPSLongitudeRef'], array('E','W','N','S'))) {

                $GPSLatitudeRef  = strtolower(trim($info['GPSLatitudeRef']));
                $GPSLongitudeRef = strtolower(trim($info['GPSLongitudeRef']));

                $lat_degrees_a = explode('/',$info['GPSLatitude'][0]);
                $lat_minutes_a = explode('/',$info['GPSLatitude'][1]);
                $lat_seconds_a = explode('/',$info['GPSLatitude'][2]);
                $lng_degrees_a = explode('/',$info['GPSLongitude'][0]);
                $lng_minutes_a = explode('/',$info['GPSLongitude'][1]);
                $lng_seconds_a = explode('/',$info['GPSLongitude'][2]);

                $lat_degrees = $lat_degrees_a[0] / $lat_degrees_a[1];
                $lat_minutes = $lat_minutes_a[0] / $lat_minutes_a[1];
                $lat_seconds = $lat_seconds_a[0] / $lat_seconds_a[1];
                $lng_degrees = $lng_degrees_a[0] / $lng_degrees_a[1];
                $lng_minutes = $lng_minutes_a[0] / $lng_minutes_a[1];
                $lng_seconds = $lng_seconds_a[0] / $lng_seconds_a[1];

                $lat = (float) $lat_degrees+((($lat_minutes*60)+($lat_seconds))/3600);
                $lng = (float) $lng_degrees+((($lng_minutes*60)+($lng_seconds))/3600);

                //If the latitude is South, make it negative.
                //If the longitude is west, make it negative
                $GPSLatitudeRef  == 's' ? $lat *= -1 : '';
                $GPSLongitudeRef == 'w' ? $lng *= -1 : '';

                return array(
                    'latitud' => $lat,
                    'longitud' => $lng,
                    'resultado' => 'EXITOSO',
                    'mensaje' => 'Se obtuvo de forma exitosa la información georeferencial de esta localidad. Latitud: '.$lat.', Longitud: '.$lng.'.',
                );
            }
        }
        return array(
            'latitud' => null,
            'longitud' => null,
            'resultado' => 'ERROR',
            'mensaje' => 'No se ha podido obtener la información georeferencial de esta imagen. Intente con otra. Recuerde activar el GPS al tomar la fotografía y activar los detalles de ubicación en la cámara.',
        );
    }

}

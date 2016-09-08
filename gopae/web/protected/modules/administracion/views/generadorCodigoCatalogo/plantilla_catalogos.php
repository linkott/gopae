<?php echo "<?php\n"; ?>
/**
 * Catalogo de $nombreClass
 *
 * @author Generador de Código
 */
class <?php echo $nombreClass . " extends CCatalogo { \n"; ?>

    protected static $columns = 
        <?php 
        var_export($columnsTable); 
        echo ';'.PHP_EOL; 
        ?>

    /**
     * Setea la data en una propiedad static llamada data
     */
    protected static function setData(){

        self::$data = 
        <?php
        var_export($data);
        echo "\t\t; \n";
        ?>

    <?php echo "\t}\n"; ?>
}

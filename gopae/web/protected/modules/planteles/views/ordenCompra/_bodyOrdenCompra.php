<style type="text/css">

    .estudiantes table, .estudiantes th, .estudiantes td {
        border: 1px solid grey;
    }  
    .estudiantes table {
        border-collapse: collapse;
        border-spacing: 0px;
        text-align:center;
    }
</style>

<?php
$total = 0;
if (isset($datos_insumos) AND $datos_insumos != array()) {
    ?>
    <table  border="1" class="estudiantes" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;width:800px;border-collapse: collapse;
            border-spacing: 0px;
            text-align:center;  ">

        <?php
        foreach ($datos_insumos as $key => $value) {
            $alimento = isset($value['nombre']) ? $value['nombre'] : null;
            $cantidad = isset($value['cantidad']) ? $value['cantidad'] : null;
            $precio = isset($value['precio']) ? $value['precio'] : null;
            $sub_total = isset($value['total']) ? $value['total'] : null;
            $total = $total + $sub_total;
            ?>

            <tr>

                <td width="50px"  align="center"  >
                    <?php echo $key + 1; ?>
                </td>
                <td  width="300px" align="center">
                    <?php echo $alimento; ?>
                </td>
                <td  width="150px"  align="center">
                    <?php echo $cantidad; ?>
                </td>
                <td  width="150px"  align="center">
                    <?php echo $precio; ?>
                </td>
                <td  width="150px"  align="center">
                    <?php echo $sub_total; ?>
                </td>

            </tr>

            <?php
        }
        echo '<tr>
          <td colspan="4"  align="right" >
                    <b>Total</b>:
                </td>
                <td  align="center" >
                    '.$total.'
                </td>
                 </tr>';
        echo "</table>";
    }
    ?>

<!--    <tr>
    <th colspan="6" class="center">
    </th>
    
    
    <th  class="center">
    </th>

</tr>-->






    <br>










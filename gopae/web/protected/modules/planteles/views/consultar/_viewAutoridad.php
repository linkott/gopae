<div class="widget-box">

    <div class="widget-header">
        <h5>
            Autoridades "<?php echo $model->nombre; ?>"
        </h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div style="display: block;" class="widget-body-inner">
            <div class="widget-main">

                <?php echo CHtml::link('', '#', array('class' => 'search-button')); ?>
                <div class="search-form" style="display:block">
                
                <?php
                    $datosAutoridades = AutoridadPlantel::model()->datosAutoridades($plantel_id);
                ?>

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    
                    <tr>
                        <th>
                            <center>
                                <b>Cargo</b>
                            </center>
                        </th>
                        <th>
                            <center>
                                <b>Nombre y Apellido</b>
                            </center>
                        </th>
                        <th>
                            <center>
                                <b>Cedula</b>
                            </center>
                        </th>
                        <th>
                            <center>
                                <b>Correo</b>
                            </center>
                        </th>
                        <th>
                            <center>
                                <b>Tel&eacute;fono</b>
                            </center>
                        </th>

                        <!--<th>
                            <center>
                                <b>Acci&oacute;n</b>
                            </center>
                        </th>
                        -->
                    </tr>

                    </thead>

                    <tbody>
                        <?php
                        foreach ($datosAutoridades as $result)
                        {
                        echo '
                            <tr class="odd">
                                <td>
                                    <div>
                                        '.$result['cargo'].'
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        '.$result['nombre'].'
                                        '.$result['apellido'].'
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        '.$result['cedula'].'
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        '.$result['email'].'
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        '.$result['telefono'].'
                                    </div>
                                </td>
                                <!--<td>
                                    <div>
                                    </div>
                                </td>
                                -->
                            </tr>
                            ';

                        }
                        if($datosAutoridades == NULL)
                        {
                            echo
                            '
                                <tr>
                                    <td colspan="5">
                                        Este plantel no se le ha asignado Autoridades.
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                    </tbody>
                </table>

                </div><!-- search-form -->
            </div>
        </div>
    </div>

</div>
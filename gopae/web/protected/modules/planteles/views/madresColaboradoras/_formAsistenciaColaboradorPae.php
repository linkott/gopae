<div class="row">

    <div class="col-sm-4" id="estados">
        <label for="MesEscolarPae_id" class="col-sm-12">Mes</label>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'mes-escolar-pae-form',
            'enableAjaxValidation' => true,
        ));

        echo $form->dropDownList(
            $modelMesEscolarPae, 'id', CHtml::listData($mesEscolarPae, 'codigo', 'nombre'), array('empty' => '- - -', 'class' => 'col-sm-12', 'autocomplete'=>'off',)
        );

        $this->endWidget();
        ?>
    </div>
    <div class="col-sm-4" id="periodo">
        <label for="periodoEscolarActual" class="col-sm-12">Periodo Escolar</label>
        <input type="text" id="periodoEscolarActual" class="col-sm-12" value="<?php echo $periodoEscolarActivo['periodo']; ?>" disabled="disabled" />
        <input type="hidden" value="<?php echo $periodoEscolarActivo['anio_inicio']; ?>" id="anio_inicio_periodo" />
        <input type="hidden" value="<?php echo $periodoEscolarActivo['anio_fin']; ?>" id="inio_fin_periodo" />
        <input type="hidden" value="<?php echo date('m'); ?>" id="mesActual" />
        <input type="hidden" value="<?php echo date('Y'); ?>" id="anioActual" />
    </div>
    <div class="col-md-2">
        <div class='col-md-12'>
            <?php echo CHtml::label('&nbsp;', 'btn-refresh-colaboradoras-plantel', array('class'=>'col-md-12')); ?>
            <button title="Refrescar información de la asistencias" class="btn btn-xs btn-primary hide" id='btn-refresh-asistencia-colaboradoras-plantel' style="padding: 2.5px 5px;" type="button">
                Refrescar <i class="icon-refresh icon-on-right"></i>
            </button>
        </div>
    </div>

    <div class='col-md-12'>
        <div class="space-6"></div>
    </div>

    <input type="hidden" value="" id="mesActualizado" name="mes" />
    <input type="hidden" value="" id="anioActualizado" name="anio" />

    <div class='col-md-12'>

        <div id="divFormAsistenciaMadresColaboradorasPlantel">


        </div>

    </div>

</div>
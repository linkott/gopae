<?php
 $this->renderPartial('_form', array(
            'model' => $model, 'estados'=>$estados, 'tipoTicket'=>$tipoTicket,'unidadResponsable'=>$unidadResponsable,'actualizar'=>$actualizar,
        ));
?>
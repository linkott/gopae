<?php
//
//$estatus = 'ACTIVO';
//$columna = '<div class="btn-group dropup">
//                        <button style="height:42px;" class="btn dropdown-toggle" data-toggle="dropdown">
//                            Acciones
//                            <span class="icon-caret-up icon-on-right"></span>
//                        </button>
//                        <ul class="dropdown-menu dropdown-yellow pull-right">';
//
//$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Consultar Datos</span>", Yii::app()->createUrl("/planteles/consultar/informacion/?id=" . base64_encode($plantel_id)), array("class" => "fa fa-search-plus ", "title" => "Consultar Datos del Plantel")) . '</li>';
//
//if (Yii::app()->user->pbac('planteles.modificar.read') or Yii::app()->user->pbac('planteles.modificar.write') or Yii::app()->user->pbac('planteles.modificar.admin')) {
//    if ($estatus == 'ACTIVO') {
//        $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar Datos</span>", Yii::app()->createUrl("/planteles/modificar/index?id=" . base64_encode($plantel_id)), array("class" => "fa fa-pencil green", "title" => "Modificar Datos del Plantel")) . '</li>';
//    }
//}
//
////if ((Yii::app()->user->id == UserGroups::ADMIN_0) || (Yii::app()->user->id == UserGroups::ADMIN_2)) {
//// if(Yii::app()->user->pbac('planteles.nivel.write') or  Yii::app()->user->pbac('planteles.planes.write') or $groupId != UserGroups::DIRECTOR)
//
//if (Yii::app()->user->pbac('planteles.nivel.read') or Yii::app()->user->pbac('planteles.nivel.write') or Yii::app()->user->pbac('planteles.nivel.admin')) {
//    /* NIVELES */$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Niveles</span>", "/planteles/nivelPlantel/index/id/" . base64_encode($plantel_id), array("class" => "fa fa-sitemap orange", "title" => "Niveles del Plantel")) . '</li>';
//}
//if (Yii::app()->user->pbac('planteles.planes.read') or Yii::app()->user->pbac('planteles.planes.write') or Yii::app()->user->pbac('planteles.planes.admin')) {
//    /* PLAN ESTUDIO */$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Plan de Estudio</span>", "/planteles/planes/consultar/id/" . base64_encode($plantel_id), array("class" => "fa fa-book red", "title" => "Planes de Estudio")) . '</li>';
//}
////if($groupId != UserGroups::ADMIN_REG_CONTROL || ($groupId == UserGroups::JEFE_DRCEE))
////{
//if (Yii::app()->user->pbac('planteles.seccionPlantel.read') or Yii::app()->user->pbac('planteles.seccionPlantel.write') or Yii::app()->user->pbac('planteles.seccionPlantel.admin')) {
//    /* SECCIONES */$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Secciones</span>", "/planteles/seccionPlantel/admin/id/" . base64_encode($plantel_id), array("class" => "fa fa-bookmark pink", "title" => "Consultar Secciones del Plantel")) . '</li>';
//}
////                    if($groupId == UserGroups::ADMIN_0 || $groupId == UserGroups::DIRECTOR || $groupId == UserGroups::ADMIN_1 || ($groupId == UserGroups::JEFE_DRCEE))
////                    {
//if (Yii::app()->user->pbac('planteles.matricula.read') and Yii::app()->user->pbac('planteles.matricula.write')) {
//    /* MATRICULA */$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Matrícula</span>", "/planteles/seccionPlantel/admin/id/" . base64_encode($plantel_id), array("class" => "fa fa-users orange", "title" => "Consultar Matrícula")) . '</li>';
//}
////                    }
//// }
////}
///* IMPRIMIR DATOS */$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Imprimir Datos</span>", "/planteles/consultar/reporte/id/" . base64_encode($plantel_id), array("class" => "fa fa-print blue", "title" => "Imprimir Datos del Plantel")) . '</li>';
//if (Yii::app()->user->id == '1') {
//    /* TITULO */$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Título</span>", "/planteles/Titulo/indexTitulo/id/" . base64_encode($plantel_id), array("class" => "fa fa-graduation-cap", "title" => "Título")) . '</li>';
//}
//
//if (Yii::app()->user->pbac('estudiante.modificar.read') or Yii::app()->user->pbac('estudiante.modificar.write') or Yii::app()->user->pbac('estudiante.modificar.admin')) {
//    /* ESTUDIANTES */$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Estudiantes</span>", "/estudiante/?bc=1&id=" . base64_encode($plantel_id), array("class" => "fa fa-users red", "title" => "Estudiantes")) . '</li>';
//}
//
//$columna .= '</ul></div>';
//echo $columna;

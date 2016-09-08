<?php
if (empty($this->breadcrumbs)) {
    $this->breadcrumbs = array(
        'Noticias'
    );
}

if (empty($this->pageTitle)) {
    $this->pageTitle = 'Noticias';
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title><?php echo CHtml::encode($this->pageTitle); ?> | Sistema de Gestión Operativa de la Corporación Nacional de Alimentación Escolar</title>
        <meta name="description" content="<?php echo $this->pageTitle; ?>: Sistema de Gestión Operativa del Programa de Alimentación Escolar" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-FRAME-OPTIONS" content="DENY">

        <!-- basic styles -->
        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/screen.min.css" media="screen, projection" />
        <!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/print.css" media="print" /> -->
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/ie.css" media="screen, projection" />
        <![endif]-->

        <!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/main.css" /> -->
        <!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/form.css" /> -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/fullcalendar.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jquery.gritter.css" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- page specific plugin styles -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jquery-ui-1.10.3.full.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/me-rtl.min.css" />
        <!-- fonts -->

        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/css5c0a.css?family=Open+Sans:400,300" />

        <!-- ace styles -->

        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/me.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/me-rtl.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/me-skins.min.css" />
        
        <!--[if lte IE 8]>
          <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/me-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!--[if !IE]> -->

        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/bootstrap.js"></script>
        <!-- <![endif]-->

        <?php
            if (Utiles::ae_detect_ie()):
        ?>
        <script>
            window.location = "site/browser";
        </script>
        <?php
            endif;
        ?>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/html5shiv.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/respond.min.js"></script>
        <![endif]-->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/public/images/favicon.ico" rel="shortcut icon">
    </head>

    <body oncontextmenu='return false'>

        <header class="main-header">
            <div id="ministerio-header">
                <img class="pull-left" id="img-gb" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/logo_ministerio.png" />
                <img class="pull-right" id="img-cv" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/pueblo-victorioso.png" height="40" />
            </div>
            <div id="gescolar-header">
                <img class="pull-left" id="img-il" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/logo_cnae.png" height="46" />
                <img class="pull-right" id="img-pg" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/logo_sistema.png" />
            </div>
        </header>

        <div class="main-container" id="main-container">

            <noscript>
               <div class="errorDialogBox">
                    <p>
                        Su navegador no tiene soporte JavaScript! Debe activar el soporte a Javascript para poder hacer uso de la Aplicación.
                    </p>
               </div>
            </noscript>

            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed');
                } catch (e) {
                }
            </script>

            <div class="main-container-inner">
                <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
                </a>

                <div class="sidebar" id="sidebar">
                    <script type="text/javascript">
                        try {
                            ace.settings.check('sidebar', 'fixed');
                        } catch (e) {
                        }
                    </script>

                    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">


                            <a href="/ayuda/ticket" class="btn btn-danger">
                                <i class="icon-envelope" title="Solicitud"> </i>
                            </a>

                            <a href="/" class="btn btn-danger">
                                <i class="icon-signal"></i>
                            </a>

                            <a href="/" class="btn btn-danger">
                                <i class="icon-pencil"></i>
                            </a>

                            <a href="/" class="btn btn-danger">
                                <i class="icon-group"></i>
                            </a>
                        </div>

                        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                            <span class="btn btn-success"></span>

                            <span class="btn btn-info"></span>

                            <span class="btn btn-warning"></span>

                            <span class="btn btn-danger"></span>
                        </div>
                    </div><!-- #sidebar-shortcuts -->

                    <!-- .nav-list Menu Principal-->
                    <?php
                    $this->renderPartial('//layouts/menu')
                    ?>
                    <!-- /.nav-list Menu Principal-->

                    <div class="sidebar-collapse" id="sidebar-collapse">
                        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>

                    </div>

                    <script type="text/javascript">
                        try {
                            ace.settings.check('sidebar', 'collapsed');
                        } catch (e) {
                        }
                    </script>
                </div>

                <div class="main-content">
                    <div class="breadcrumbs" id="breadcrumbs">
                        <script type="text/javascript">
                            try {
                                ace.settings.check('breadcrumbs', 'fixed');
                            } catch (e) {
                            }
                        </script>

                        <!-- .breadcrumb -->
                        <?php if (isset($this->breadcrumbs)): ?>
                            <?php
                            $this->widget('zii.widgets.CBreadcrumbs', array(
                                'htmlOptions' => array('class' => 'breadcrumb row-fluid'),
                                'links' => $this->breadcrumbs,
                                'separator' => '',
                                'homeLink' => '<li><i class="icon-home home-icon"></i>' . CHtml::link('Inicio', Yii::app()->homeUrl) . '</li>',
                                'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
                                'inactiveLinkTemplate' => '<li><span>{label}</span></li>',
                            ));
                            ?><!-- breadcrumbs -->
                        <?php endif ?>
                        <!-- .breadcrumb -->

                        <div class="navbar-header pull-right" role="navigation">
                            <ul class="user-link-profile">
                                <li>
                                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                        <span class="user-info" title="<?php echo Yii::app()->user->nombre . ' ' . Yii::app()->user->apellido; ?>">
                                            <i class="icon-user"></i>
                                            &nbsp;<?php
                                            if (!Yii::app()->user->isGuest) {
                                                echo ucwords(strtolower(Yii::app()->user->nombre . ' ' . Yii::app()->user->apellido));
                                            }
                                            ?>
                                        </span>
                                        <i class="icon-caret-down"></i>
                                    </a>

                                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

                                        <?php if (!Yii::app()->user->isGuest): ?>
                                            <li>
                                                <a href="/perfil">
                                                    <i class="icon-user"></i>
                                                    Mi Perfil
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <li class="divider"></li>

                                        <li>
                                            <a href="<?php echo $url = Yii::app()->baseUrl . "/logout"; ?>">
                                                <i class="icon-off"></i>
                                                Cerrar Sesi&oacute;n
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <div class="page-content">
                        <div class="row-fluid" id="main-container">
                            <!-- <div class="col-xs-12">-->
                            <!-- ********************************* INICIO DEL CONTENIDO *************************************** -->
                            <?php echo $content; ?>
                            <!-- ********************************** FIN DEL CONTENIDO ***************************************** -->
                            <!-- </div> -->
                            <!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div><!-- /.main-content -->

            </div><!-- /.main-container-inner -->

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="icon-double-angle-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <footer id="footer">
            <div class="main-container-inner">
                <p class="text-muted credit center">
                    <a href="http://www.me.gob.ve/">MPPE</a> |
                    <a href="http://www.me.gob.ve/">CNAE</a> |
                    <a href="http://www.me.gob.ve/contenido.php?id_seccion=50&id_contenido=26185&modo=2">FEDE</a> |
                    <a href="http://fundabit.me.gob.ve">FUNDABIT</a>
                </p>
                <p class="text-muted credit center">
                    Coorporación Nacional de Alimentación Escolar
                    <br/>
                    Fundación Bolivariana de Informática y Telemática
                    <br/>
                    Dirección General de Tecnolog&iacute;a de la Informaci&oacute;n y la Comunicaci&oacute;n para el Desarrollo Educativo
                    <br/>
                    <span title="Ministerio del Poder Popular para la Educación">MPPE</span> &copy; 2015
                </p>
            </div>
        </footer>

        <!-- basic scripts -->

        <!--[if IE]>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <![endif]-->
        <!--[if !IE]>
        <script type="text/javascript">
            window.jQuery || document.write("<script src='js/jquery-2.0.3.min.js'>" + "<" + "/script>");
        </script>
        <!-- <![endif]-->

        <!--[if IE]>
        <script type="text/javascript">
                window.jQuery || document.write("<script src='js/jquery-1.10.2.min.js'>"+"<"+"/script>");
        </script>
        <![endif] -->

        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/typeahead-bs2.min.js"></script>

        <!-- page specific plugin scripts -->

        <!-- me scripts -->
            <!-- me settings handler -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/me-extra.min.js"></script>

        <!-- others me scripts
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/me-elements.min.js"></script>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/me.min.js"></script>
        -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/me-theme.compress.c170814.js"></script>

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/main.min.js"></script>

        <!-- page specific plugin scripts -->

            <!--
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery-ui-1.10.3.full.min.js"></script>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.ui.touch-punch.min.js"></script>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.ui.dialog.titlehtml.js"></script>
            -->
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.ui.compress.c170814.js"></script>
            <!-- <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.hotkeys-0.7.9.min.js"></script>-->
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.alphanumeric.numeric.min.js"></script>
            
        <!-- inline scripts related to this page -->
        
        <?php if (Yii::app()->user->groupName!='Developer' && Yii::app()->user->name!='admin'): ?>
        <script language="Javascript">
            //document.oncontextmenu = function(){return false;};
        </script>
        <?php endif; ?>
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.upload/js/vendor/jquery.ui.widget.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.gritter.min.js', CClientScript::POS_END);
        ?>
        <?php if(!Yii::app()->params['testing']): ?>
        <?php $this->renderPartial("//analytics", array()) ?>
        <?php endif; ?>
    </body>
</html>

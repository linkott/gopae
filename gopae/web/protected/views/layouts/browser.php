<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Navegador Web No Permitido</title>

        <meta name="description" content="Gestión Operativa del CNAE - Navegador no soportado" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- basic styles -->
        <!-- blueprint CSS framework -->
        <!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/screen.css" media="screen, projection" /> -->
        <!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/print.css" media="print" /> -->
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/ie.css" media="screen, projection" />
        <![endif]-->

        <!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/main.css" /> -->
        <!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/form.css" /> -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/font-awesome.min.css" rel="stylesheet" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- page specific plugin styles -->

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

        <!-- ace settings handler -->

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/me-extra.min.js"></script>

        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/bootstrap.js"></script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/html5shiv.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/respond.min.js"></script>
        <![endif]-->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/public/images/favicon.ico" rel="shortcut icon">
    </head>

    <body class="login-layout">

        <header class="main-header">
            <div id="ministerio-header">
                <img class="pull-left" id="img-gb" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/logo_ministerio.png" />
                <img class="pull-right" id="img-cv" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/logo_campanha.png" />
            </div>
            <div id="gescolar-header">
                <img class="pull-left" id="img-il" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/logo_cnae.png" height="46" />
                <img class="pull-right" id="img-pg" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/logo_sistema.png" />
            </div>
        </header>

        <div class="main-container" id="main-container">

            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed')
                } catch (e) {
                }
            </script>


            <div class="page-content">
                <div class="row">
                    <!-- <div class="col-xs-12">-->
                    <?php echo $content; ?>
                    <!-- </div> -->
                    <!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->

        </div><!-- /.main-content -->



        <footer id="footer">
            <div class="container">
                <p class="text-muted credit center">
                    <a href="http://www.me.gob.ve/">MPPE</a> |
                    <a href="http://www.me.gob.ve/">CNAE</a> |
                    <a href="http://www.me.gob.ve/contenido.php?id_seccion=50&id_contenido=26185&modo=2">FEDE</a> |
                    <a href="http://fundabit.me.gob.ve">FUNDABIT</a>
                </p>
                <p class="text-muted credit center">
                    Gerencia General de Tecnolog&iacute;a e Informaci&oacute;n. MPPE &copy; 2014
                </p>
            </div>
        </footer>

        <!-- basic scripts -->

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/typeahead-bs2.min.js"></script>

        <!-- page specific plugin scripts -->

        <!-- ace scripts -->

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/me-elements.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/me.min.js"></script>

        <!-- inline scripts related to this page -->


        <!--[if IE]>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <![endif]-->


        <!--[if IE]>
        
        <script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
        </script>
        
        <![endif]-->

        <script type="text/javascript">
                if ("ontouchend" in document)
                    document.write("<script src='<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>

        <!-- inline scripts related to this page -->

        <script type="text/javascript">
            function show_box(id) {
                jQuery('.widget-box.visible').removeClass('visible');
                jQuery('#' + id).addClass('visible');
            }
        </script>
        
        <?php if(!Yii::app()->params['testing']): ?>
        <?php $this->renderPartial("//analytics", array()) ?>
        <?php endif; ?>

    </body>
</html>

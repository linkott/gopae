<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Página en Mantenimiento | Sistema de Gestión Operativa del CNAE</title>

        <meta name="description" content="Gestión Operativa del PAE - Inicio" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- basic styles -->
        <!-- blueprint CSS framework -->
        <!--<link rel="stylesheet" type="text/css" href="/public/css/screen.css" media="screen, projection" /> -->
        <!--<link rel="stylesheet" type="text/css" href="/public/css/print.css" media="print" /> -->
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="/public/css/ie.css" media="screen, projection" />
        <![endif]-->

        <!-- <link rel="stylesheet" type="text/css" href="/public/css/main.css" /> -->
        <!--<link rel="stylesheet" type="text/css" href="/public/css/form.css" /> -->
        <link href="/public/css/bootstrap.min.css" rel="stylesheet" />
        <link href="/public/css/font-awesome.min.css" rel="stylesheet" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="/public/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- page specific plugin styles -->

        <!-- fonts -->

        <link rel="stylesheet" href="/public/css/css5c0a.css?family=Open+Sans:400,300" />

        <!-- ace styles -->

        <link rel="stylesheet" href="/public/css/me.min.css" />
        <link rel="stylesheet" href="/public/css/me-rtl.min.css" />
        <link rel="stylesheet" href="/public/css/me-skins.min.css" />

        <!--[if lte IE 8]>
          <link rel="stylesheet" href="/public/css/me-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->
        <!-- ace settings handler -->

        <script src="/public/js/me-extra.min.js"></script>

        <script src="/public/js/jquery/2.0.3/jquery.min.js"></script>
        <script src="/public/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="/public/js/bootstrap.js"></script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="/public/js/html5shiv.js"></script>
        <script src="/public/js/respond.min.js"></script>
        <![endif]-->
        <link href="/public/images/favicon.ico" rel="shortcut icon">
    </head>

    <body class="login-layout">

        <header class="main-header">
            <div id="ministerio-header">
                <img class="pull-left" id="img-gb" src="/public/images/logo_ministerio.png" />
                <img class="pull-right" id="img-cv" src="/public/images/pueblo-victorioso.png" height="40" />
            </div>
            <div id="gescolar-header">
                <img class="pull-left" id="img-il" src="/public/images/logo_cnae.png" height="46" />
                <img class="pull-right" id="img-pg" src="/public/images/logo_sistema.png" />
            </div>
        </header>

        <div class="main-container" id="main-container">

            <noscript>
               <div class="errorDialogBox">
                  Su navegador no tiene soporte JavaScript! Debe activar el soporte a Javascript para poder hacer uso de la Aplicación.
               </div>
            </noscript>

            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed');
                } catch (e) {
                }
            </script>


            <div class="page-content">
                <div class="center">
                    <!-- <div class="col-xs-12">-->
                        <img src="/public/images/error/mantenimiento.png" height="500" />
                    <!-- </div> -->
                    <!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->

        </div><!-- /.main-content -->

        <div class="space-6"></div>
        <div class="row row-fluid position-relative col-lg-12">
            <footer id="footer" class="row-fluid main-container" style="margin-top: 2px;">
                <div class="row-fluid main-container-inner center">
                    <p class="text-muted credit">
                        <a href="http://www.me.gob.ve/">MPPE</a> |
                        <a href="http://www.me.gob.ve/">CNAE</a> |
                        <a href="http://www.me.gob.ve/contenido.php?id_seccion=50&id_contenido=26185&modo=2">FEDE</a> |
                        <a href="http://fundabit.me.gob.ve">FUNDABIT</a>
                    </p>
                    <p class="text-muted credit center">
                        Corporación Nacional de Alimentación Escolar
                        <br/>
                        Fundación Bolivariana de Informática y Telemática
                        <br/>
                        Dirección General de Tecnolog&iacute;a de la Informaci&oacute;n y la Comunicaci&oacute;n para el Desarrollo Educativo
                        <br/>
                        <span title="Ministerio del Poder Popular para la Educación">MPPE</span> &copy; 2014
                    </p>
                </div>
            </footer>
        </div>

        <!-- basic scripts -->

        <script src="/public/js/bootstrap.min.js"></script>
        <script src="/public/js/typeahead-bs2.min.js"></script>

        <!-- page specific plugin scripts -->

        <!-- ace scripts -->

        <script src="/public/js/me-elements.min.js"></script>
        <script src="/public/js/me.min.js"></script>

        <!-- inline scripts related to this page -->


        <!--[if IE]>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <![endif]-->


        <!--[if IE]>

        <script type="text/javascript">
        window.jQuery || document.write("<script src='/public/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
        </script>

        <![endif]-->

        <script type="text/javascript">
    if ("ontouchend" in document)
        document.write("<script src='/public/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
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

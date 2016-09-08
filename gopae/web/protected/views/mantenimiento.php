<!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="content-type" content="text/html;charset=utf-8">
            <meta name="title" content="500 Internal Server Error">
            <link rel="shortcut icon" href="/public/images/favicon.ico">
            <title>Página en Mantenimiento Sistema de Gestión Operativa del CNAE </title>

            <style>
                html, body {
                    margin: 0;
                    padding: 0;
                    width: 100%;
                    height: 100%;
                }

                body {
                    background: #D6E1D1;
                    display: table;
                }

                #container {
                    display: table-cell;
                    vertical-align: middle;
                    padding: 20px;
                }

                #content-wrap {
                    max-width: 600px;
                    margin: 0 auto;
                    position: relative;
                    border-top: 1px solid #BBC7B5;
                    border-bottom: 1px solid #E8EFE6;
                }

                #logo {
                    background: url("../public/images/minilogo.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
                    height: 50px;
                    left: 44%;
                    margin: -18px 0 0 -12px;
                    position: absolute;
                    width: 200px;
                }

                #content {
                    padding: 50px 0 10px 333px;
                    background-repeat: no-repeat;
                    min-height: 290px;
                    border-top: 1px solid #E8EFE6;
                    border-bottom: 1px solid #BBC7B5;
                    color: #666;
                    font: 12px/1.5 Tahoma, sans-serif;
                    text-shadow: 0 1px 0 #f1f5ef;
                }
                @media screen and (max-width: 630px) {
                    #content {
                        margin: 0 auto;
                        min-height: 0;
                        padding: 20px 0 300px 0;
                        width: 309px;
                        background-position: 50% 99%!important;
                    }
                }

                a {
                    color: #0084B0;
                    text-decoration: none;
                    text-shadow: none;
                }

                a:hover {
                    text-decoration: underline;
                }

                #title {
                    width: 257px;
                    overflow: hidden;
                    background-repeat: no-repeat;
                }

                #description {
                    margin-top: 10px;
                }

                #final-destination {
                    display: block;
                    margin-top: 10px;
                    background: #C9E967 url(../public/images/error/button-back-green-sprite.png) no-repeat;
                    padding-left: 65px;
                    width: 192px;
                    height: 32px;
                    color: #222;
                    text-shadow: 0 1px 0 #fff;
                    text-decoration: none;
                    line-height: 32px;
                }

                #final-destination:hover {
                    background-position: 0 -32px;
                }

                #final-destination:active {
                    background-position: 0 -64px;
                }

                #other-destinations {
                    margin-top: 25px;
                }

                #other-destinations .links {
                    font-size: 11px;
                }

                .error-503 #content {
                    background-image: url(../public/images/error/fella-wait.png);
                    background-position: 0 48px; }

                .error-503 #title {
                    background-image: url(../public/images/error/error-title-oops.png);
                    height: 102px; }

            </style>

        </head>
        <body class="error-503">
            <div id="container">
                <div id="content-wrap">
                    <div id="logo"></div>
                    <div id="content">
                        <div id="title"></div>
                        <div id="description">
                            Error 503: Puede que el servidor este en mantenimiento. Intente de Nuevo más Tarde
                        </div><!-- #description -->

                        <a id="final-destination" href="#">De vuelta a la p&aacute;gina inicial</a>

                        <div id="other-destinations">
                            <div class="description">Puede tambi&eacute;n acceder a estos destinos:</div>
                            <div class="links">
                                <a href="#">Ayuda</a>
                                    <a href="http://www.me.gob.ve/">MPPE</a> |
                                    <a href="http://www.me.gob.ve/contenido.php?id_seccion=50&id_contenido=26185&modo=2">FEDE</a> |
                                    <a href="http://fundabit.me.gob.ve">FUNDABIT</a>
                            </div>
                        </div>
                        <p class="text-muted credit center">
                            Corporación Nacional de Alimentación Escolar
                            <br/>
                            Fundación Bolivariana de Informática y Telemática
                            <br/>
                            Dirección General de Tecnolog&iacute;a de la Informaci&oacute;n y la Comunicaci&oacute;n para el Desarrollo Educativo
                            <br/>
                            <span title="Ministerio del Poder Popular para la Educación">MPPE</span> &copy; 2014
                        </p>
                    </div><!-- #content -->
                </div><!-- #content-wrap -->
            </div><!-- #container -->
        </body>
    </html>

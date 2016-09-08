<script type="text/javascript">
    $(document).ready(function() {

        var opt = '';
        var browser = '';
        var version = '';
        var title = '';
        var parrafo = '';
        opt = '<?php print($opt); ?>';
        if (opt == '1') {

            if ($.browser.mozilla)
            {
                browser = '<strong>Mozilla Firefox</strong>';

            }
            if ($.browser.opera)
            {
                browser = '<strong>Opera</strong>';
            }
            if ($.browser.chrome)
            {
                browser = '<strong>Chrome</strong>';
            }
            version = '<strong>' + $.browser.version + '</strong>';
            title = 'Navegador Desactualizado';
            parrafo = 'Estimado usuario, esta usando el navegador ' + browser + ' en su versión ' + version + ' debe actualizarlo a una versión más reciente.';
            document.title = title;
            $("#spanTitle").html(title);
            $("#parrafo").html(parrafo);
            //$("#navegadores").addClass('hide');
       }

       else {
        if (opt == '2') {

            if ($.browser.mozilla)
            {
                browser = '<strong>Mozilla Firefox</strong>';

            }
            if ($.browser.opera)
            {
                browser = '<strong>Opera</strong>';
            }
            if ($.browser.chrome)
            {
                browser = '<strong>Chrome</strong>';
            }
            version = '<strong>' + $.browser.version + '</strong>';
            title = 'Versión del Navegador No Compatible';
            parrafo = 'Estimado usuario, esta usando el navegador ' + browser + ' en su versión ' + version + '. En este momento estamos presentando algunos inconvenientes con dicha versión, porfavor instale una versión de '+browser+' entre <strong>25.0</strong> y <strong>31.0</strong>. Tambien puede optar por otro navegador web libre como los siguientes: ';
            document.title = title;
            $("#spanTitle").html(title);
            $("#parrafo").html(parrafo);
            //$("#navegadores").addClass('hide');
            $("#lnkMozilla").addClass('hide');


        }
        else {
            title = 'Navegador Web No Permitido';
        }
       }

    });

</script>
<div class="col-sm-10 col-sm-offset-1">
    <div class="login-container">

        <div class="space-6"></div>

        <div class="position-relative">

            <div id="login-box" class="login-box visible widget-box no-border">
                <div class="widget-body">
                    <div class="widget-main">
                        <h4 class="header blue lighter bigger">
                            <i class="fa fa-globe green"></i>
                            <span id="spanTitle">Navegador Web No Permitido</span>
                        </h4>


                        <p class="header gray lighter bigger" style="text-align : justify;" id="parrafo"> Estimado usuario, esta aplicación no puede ser ejecutada en este navegador. Le recomendamos los siguientes navegadores.</p>
                        <div class="space-6"><div class="row"></div></div>
                        <p  id="navegadores" style="text-align : center;" class="" >
                            <a  id="lnkMozilla" target="_blank" href="http://www.mozilla.org/es-ES/firefox/new/"><img height="60" alt="Mozilla Firefox" <?php echo 'src="' . Yii::app()->baseUrl . '/public/images/firefox.png' . '"' ?>/></a>
                            <a id="lnkChrome" target="_blank" href="http://www.google.com/intl/es-419/chrome/browser/"><img height="60"alt="Google Chrome"  <?php echo 'src="' . Yii::app()->baseUrl . '/public/images/chrome.png' . '"' ?>/></a>
                            <a id="lnkChromium" target="_blank" href="https://download-chromium.appspot.com/"><img height="60"alt="Chromium"  <?php echo 'src="' . Yii::app()->baseUrl . '/public/images/chromium.png' . '"' ?>/></a>
                        </p>

                    </div><!-- /widget-main -->

                </div><!-- /widget-body -->
            </div><!-- /login-box -->


        </div><!-- /position-relative -->
    </div>
</div><!-- /.col -->
<?php if(!Yii::app()->params['testing']): ?>
<?php $this->renderPartial("//analytics", array()) ?>
<?php endif; ?>

<?php

// $composer = dirname(__FILE__) . '/protected/vendor/autoload.php';
// require_once($composer);

$webroot = Yii::getPathOfAlias('webroot');
echo $webroot;
// uncomment the following to define a path alias usergro
// Yii::setPathOfAlias('local','path/to/local-folder'); gii
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Sistema de Gestión Operativa del PAE',
    //'defaultController' => 'userGroups',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.catalogos.*',
        'application.components.*',
        'application.widgets.*',
        'application.extensions.*',
        'application.extensions.Classes.*',
        'application.modules.userGroups.models.*',
        'application.modules.userGroups.userGroupsModule',
        'application.extensions.MPDF54.mpdf',
        'ext.ECompositeUnique.ECompositeUniqueValidator',
    ),
    'aliases' => array(
        'xupload' => 'ext.xupload',
        'cthumbcreator' => 'ext.CThumbCreator.CThumbCreator'
    ),
    //Defino mi locale de idioma como español-venezuela
    //'sourceLanguage'=>'en_us',
    'language' => 'es_ve',
    // application components
    'components' => array(

        'coreMessages' => array(
            'basePath' => 'protected/messages',
        ),

        'ThumbsGen' => array(
            'class' => 'application.extensions.ThumbsGen.ThumbsGen',
        ),

        'excel'=>array(
            'class'=>'application.extensions.Classes.PHPExcel',
        ),

        /**
         * Propiedad PDF para hacer
         */
        'ePdf' => array(
            'class' => 'ext.yii-pdf.EYiiPdf',
            'params' => array(
                'mpdf' => array(
                    'librarySourcePath' => 'application.vendor.mpdf.*',
                    'constants' => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class' => 'mpdf', // the literal class filename to be loaded from the vendors folder
                /* 'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                  'mode'              => '', //  This parameter specifies the mode of the new document.
                  'format'            => 'A4', // format A4, A5, ...
                  'default_font_size' => 0, // Sets the default document font size in points (pt)
                  'default_font'      => '', // Sets the default font-family for the new document.
                  'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                  'mgr'               => 15, // margin_right
                  'mgt'               => 16, // margin_top
                  'mgb'               => 16, // margin_bottom
                  'mgh'               => 9, // margin_header
                  'mgf'               => 9, // margin_footer
                  'orientation'       => 'P', // landscape or portrait orientation
                  ) */
                ),
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.vendor.html2pdf.*',
                    'classFile' => 'html2pdf.class.php', // For adding to Yii::$classMap
                /* 'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                  'orientation' => 'P', // landscape or portrait orientation
                  'format'      => 'A4', // format A4, A5, ...
                  'language'    => 'en', // language: fr, en, it ...
                  'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                  'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                  'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                  ) */
                )
            ),
        ),
        /**
         * Propiedad PDF para hacer 
         */
        'ePdf' => array(
            'class' => 'ext.yii-pdf.EYiiPdf',
            'params' => array(
                'mpdf' => array(
                    'librarySourcePath' => 'application.vendor.mpdf.*',
                    'constants' => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class' => 'mpdf', // the literal class filename to be loaded from the vendors folder
                /* 'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                  'mode'              => '', //  This parameter specifies the mode of the new document.
                  'format'            => 'A4', // format A4, A5, ...
                  'default_font_size' => 0, // Sets the default document font size in points (pt)
                  'default_font'      => '', // Sets the default font-family for the new document.
                  'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                  'mgr'               => 15, // margin_right
                  'mgt'               => 16, // margin_top
                  'mgb'               => 16, // margin_bottom
                  'mgh'               => 9, // margin_header
                  'mgf'               => 9, // margin_footer
                  'orientation'       => 'P', // landscape or portrait orientation
                  ) */
                ),
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.vendor.html2pdf.*',
                    'classFile' => 'html2pdf.class.php', // For adding to Yii::$classMap
                /* 'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                  'orientation' => 'P', // landscape or portrait orientation
                  'format'      => 'A4', // format A4, A5, ...
                  'language'    => 'en', // language: fr, en, it ...
                  'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                  'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                  'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                  ) */
                )
            ),
        ),
        // uncomment the following to use  database
        'db' => array(
            'connectionString' => 'pgsql:host=' . Db::$hostDb . ';port=' . Db::$portDb . ';dbname=' . Db::$nameDb,
            'emulatePrepare' => true,
            'username' => Db::$userDb,
            'password' => Db::$passwordDb,
            'charset' => 'utf8',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
        'cache'=>array(
            'class'=>'system.caching.CDbCache'
        )
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'mailServer' => 'mail.me.gob.ve',
        'portMailServer' => 25,
        'adminEmail' => 'soporte_gopae@me.gob.ve',
        'adminEmailSend' => 'soporte_gescolar@me.gob.ve',
        'adminGmail' => 'gescolar.mppe@gmail.com',
        'adminName' => 'Soporte GOPAE',
        'hostName' => 'https://gopae.me.gob.ve',
        'webDirectoryPath' => '/var/www/gopae/web/',
        'uploadDirectoryPath' => '/var/www/gopae/web/public/uploads',
        'downloadDirectoryPath' => '/var/www/gopae/web/public/downloads',
        'uploadFotoTalentoHumanoDirectoryPath' => '/var/www/gopae/web/public/uploads/talentoHumano/foto/',
        'urlDownloadComprobanteCnae' => '/public/downloads/comprobantesPae/',
        'urlDownloadFotoTalentoHumano' => '/public/uploads/talentoHumano/foto/',
        'testing' => false,
        'salt' => 'movilGopaeApi',
    ),
);

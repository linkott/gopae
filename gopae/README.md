** Instalación **

Es recomendable para soportar el sistema: PHP 5.4+ (php5-gd, php5-mcrypt, php5-apc, php5-pgsql, php5-sqlite), PostgreSQL 9.3+ (Con postgresql-contrib), SQLite.

[Instalación del Servidor desde cero en ambiente Linux](https://symfonyando.wordpress.com/2013/02/23/instalando-php5-4-xdebug-mcrypt-apc-apache-y-mysql-en-ubuntu-12-04/)

1.- Debes situarte en el directorio /var/www/ o en la raíz de tu servidor web.

2.- Tener instalado y configurado git.

3.- Clonar el Proyecto ejecutando el comando:

    git clone https://bitbucket.org/vergatarios/gopae.git

4.- Crear los siguientes directorios a partir de la raíz del proyecto (/var/www/gopae):

    mkdir web/assets
    mkdir web/protected/runtime
    mkdir web/public/uploads
    mkdir web/public/uploads/instructivo
    mkdir web/public/uploads/titulo
    mkdir web/public/uploads/autoridadPlantel
    mkdir web/public/uploads/autoridadPlantel/foto
    mkdir web/public/uploads/documentoProveedor
    mkdir web/public/uploads/fundamentoJuridico
    mkdir web/public/uploads/notaEntrega
    mkdir web/public/uploads/ordenCompra
    mkdir web/public/uploads/talentoHumano
    mkdir web/public/uploads/talentoHumano/foto
    mkdir web/public/uploads/talentoHumano/egresos
    mkdir web/public/uploads/talentoHumano/ingresos
    mkdir web/public/uploads/ticket
    mkdir web/public/uploads/plantel
    mkdir web/public/uploads/plantel/georeferencia

    mkdir web/public/downloads
    mkdir web/public/downloads/comprobantesPae
    mkdir web/public/downloads/comprobantesPae/bc
    mkdir web/public/downloads/comprobantesPae/pdf
    mkdir web/public/downloads/comprobantesPae/qr

4.1 Dar los permisos de forma adecuada a estos directorios:

    sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx web/public/uploads/ web/public/downloads/ web/assets web/protected/runtime
    sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx web/public/uploads/ web/public/downloads/ web/assets web/protected/runtime

5.- Crear una clase Db la cual debe estar alojada en el archivo "/protected/config/configDb.php" (ver archivo "/protected/config/configDb.php.dist" el cual puedes copiar y pegar) la misma debe contener lo siguiente:

    <?php

    class Db{

        public static $hostDb = 'localhost'; // Host de Base de Datos
        public static $nameDb = 'prodDb'; // Nombre de la Base de Datos
        public static $userDb = 'postgres'; // Usuario de la Base de Datos
        public static $passwordDb = 'postgres'; // Password de la base de datos
        public static $portDb = '5432'; // Puerto de la base de datos

        public static $hostTest = 'localhost'; // Host de Base de Datos
        public static $nameTest = 'testDb'; // Nombre de la Base de Datos
        public static $userTest = 'postgres'; // Usuario de la Base de Datos
        public static $passwordTest = 'postgres'; // Password de la base de datos
        public static $portTest = '5432'; // Puerto de la base de datos

        public static function getCacheConfig($cache=null){
            if ($cache == 'redis') {
                $cache_config = array(
                    'class' => 'packages.redis.ARedisCache'
                );
            } elseif ($cache == 'apc') {
                $cache_config = array(
                    'class' => 'system.caching.CApcCache'
                );
            } elseif ($cache == 'file') {
                $cache_config = array(
                    'class' => 'system.caching.CFileCache'
                );
            } else {
                $cache_config = array(
                    'class'=>'system.caching.CDbCache',
                );
            }
            return $cache_config;
        }

    }

5.1.- Crear el archivo main.php "web/protected/config/main.php" de acuerdo a lo que contiene el archivo main.php.dist hubicado en "web/protected/config/main.php.dist".

5.2.- Crear el archivo index.php "web/index.php" de acuerdo a lo que contiene el archivo index.php.dist hubicado en "web/index.php.dist".

5.3.- Acá pueden ver cómo llevar a cabo la [Configuración del Servidor](https://bitbucket.org/vergatarios/escolar/wiki/Configuraci%C3%B3n%20del%20Servidor%20Apache) con virtualhost en un ambiente con servidor Apache2.

6.- No se deben modificar, eliminar o mover los archivos "web/protected/config/main.php.dist", "web/protected/config/configDb.php.dist" o cualquier otro archivo común sin antes consultar al grupo.

7.- Debemos hacer lo posible para cumplir con las siguientes reglas:

  * a.- Vamos a tratar de hacer la aplicación por módulos respetando la filosofía del framework Yii.

  * b.- Los modelos serán los únicos componentes de la aplicación que permanecerán en el directorio models externo. Directorio "web/protected/models" el código del módulo tanto vistas, controladores e incluso componentes debe estar en el directorio "web/protected/modules/xxxx".

  * c.- Debemos respetar los estilos "css" de la plantilla, hacer todo para que la interfaz quede limpia.

  * d.- Las consultas SQL o ORM deben efectuarse en los modelos bajo un método que podamos consultar solo desde los controladores y luego pasemos a las vistas en forma de variable.

  * f.- Evitar en lo posible hacer consultas a la base de datos mientras se pueda, solo debemos hacer consultas cuando sea muy necesario. Si podemos guardar en cache (Yii::app()->cache) los resultados de consultas hagámoslo. Siempre cuidando la filosofía del framework Yii.

  * g.- Debemos entender que hacer código de calidad y ordenado no implica perdida de tiempo sino ganancia de tiempo. Documentar el Código de acuerdo a PHPDoc nos ayudará para tener una documentación técnica del proyecto así como para ayuda en IDE's como Netbeans, PHPStorm, entre otros.

8.- Para checkear el rol de un usuario podemos hacer uso del siguiente código en nuestros controladores:

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {

        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'ajaxList'),
                'expression' => "UserIdentity::checkAccess(array('ROLE_DEVELOPER', 'ROLE_ADMIN'))"
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
9.- Para incluir js propios debemos hacer uso del siguiente metodo (en cualquier parte de la vista)

    <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/plantel.js',CClientScript::POS_END);
    ?>

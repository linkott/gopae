<?php

//Se encarga de capturar los items a pintar en el Menu
function getMenu() {

    $items = array();
    $sub_items = array();

    //Inicio
    $items[] = array('name' => 'Inicio', 'code' => 'inicio', 'icon' => 'icon-home', 'link' => array('/site'));

    //Zona Educativa
    if (Yii::app()->user->pbac('zonaEducativa.zonaEducativa.read')) {
        $items[] = array('name' => 'Zonas Educativas', 'code' => 'zonaEducativa', 'icon' => 'icon-building', 'link' => array('/ministerio/zonaEducativa'));
    }

    //Talento Humano
    if (Yii::app()->user->pbac('gestionHumana.talentoHumano')) {
        $items[] = array('name' => 'Talento Humano', 'code' => 'talento-humano', 'icon' => 'icon-group', 'link' => array('/gestionHumana/talentoHumano'));
    }

    // Registro Único de Planteles
    if (Yii::app()->user->pbac('registroUnico.plantelesPae.read') || (Yii::app()->user->pbac("registroUnico.plantelesPae.read")) || (Yii::app()->user->pbac("registroUnico.plantelesPae.admin"))) {
        $items[] = array('name' => 'Registro Único', 'code' => 'registrUnico', 'icon' => 'icon-list', 'link' => array('/registroUnico/plantelesPae/'));
    }

    //Planteles
    if (Yii::app()->user->pbac('planteles.consultar.read') || (Yii::app()->user->pbac("planteles.consultar.write"))) {
        $items[] = array('name' => 'Planteles', 'code' => 'planteles', 'icon' => 'icon-institution', 'link' => array('/planteles/consultar/'));
    }
    
    //Planificacion
    if ((Yii::app()->user->pbac("planificacion.planificacion.write"))) {
        $items[] = array('name' => 'Planificación', 'code' => 'planificacion', 'icon' => 'icon-calendar', 'link' => array('/planificacion/'));
    }

    //Menu Nutricional
    if (Yii::app()->user->pbac('menuNutricional.menuNutricional.read') || (Yii::app()->user->pbac("menuNutricional.menuNutricional.write"))) {
        $items[] = array('name' => 'Menus', 'code' => 'menuNutricional', 'icon' => 'icon-cutlery', 'link' => array('/menuNutricional'));
    }

    //Proveedores
    if (Yii::app()->user->pbac('proveedor.proveedor.read')) {
        $items[] = array('name' => 'Proveedores', 'code' => 'proveedor', 'icon' => 'icon-truck', 'link' => array('/proveedor'));
    }

    //Control
    if (true) {
        $items[] = array('name' => 'Control', 'code' => 'control', 'icon' => 'icon-wrench', 'sub' => getSubMenu('Control'));
    }

//    //Presupuesto
//    if (Yii::app()->user->pbac('presupuesto.consultar.read')) {
//        $items[] = array('name' => 'Presupuesto', 'code' => 'presupuesto', 'icon' => 'icon-money', 'link' => array('/presupuesto'));
//    }

//    //Licitacion o Requisicion
//    if (Yii::app()->user->pbac('presupuesto.consultar.read')) {
//        $items[] = array('name' => 'Licitacion', 'code' => 'licitacion', 'icon' => 'icon-shopping-cart', 'link' => array('/licitacion'));
//    }

    //Catologos
    if (Yii::app()->user->pbac('catalogo.default.read')) {
        $items[] = array('name' => 'Catálogos', 'code' => 'catalogo', 'icon' => 'icon-tags', 'link' => array('/catalogo'));
    }

    //Seguridad
    if (Yii::app()->user->pbac('Basic.traza.read') || Yii::app()->user->pbac("userGroups.admin.admin") || Yii::app()->user->pbac("userGroups.usuario.admin") || Yii::app()->user->pbac("userGroups.grupo.admin")) {
        $items[] = array('name' => 'Seguridad', 'code' => 'seguridad', 'icon' => 'icon-lock', 'sub' => getSubMenu('Seguridad'));
    }

    //Perfil del Usuario
    if (!Yii::app()->user->isGuest) {
        $items[] = array('name' => 'Mi Perfil', 'code' => 'mi-perfil', 'icon' => 'icon-user', 'link' => array('/perfil'));
    }

    //Ayuda
    if (!Yii::app()->user->isGuest) {
        $items[] = array('name' => 'Ayuda', 'code' => 'ayuda', 'icon' => 'icon-question', 'sub' => getSubMenu('Ayuda'));
    }



    //Administración
    if (Yii::app()->user->pbac('administracion.configuracion.read') || Yii::app()->user->pbac("administracion.configuracion.write") || Yii::app()->user->pbac("administracion.configuracion.admin"
            || Yii::app()->user->pbac('administracion.generadorCodigo.admin'))) {
        $items[] = array('name' => 'Administracion', 'code' => 'Administracion', 'icon' => 'icon-wrench', 'sub' => getSubMenu('Administracion'));
    }

    //Cerrar Sesión
    $items[] = array('name' => 'Cerrar Sesión', 'code' => 'cerrar-sesion', 'icon' => 'icon-off', 'link' => array('/logout'));



    return $items;
}

// Se encarga de capturar los items a pintar en el SubMenu del Menu
function getSubMenu($menu) {
    $items = array();

    switch ($menu) {

        case 'Seguridad':
            if (Yii::app()->user->pbac("userGroups.admin.admin") || Yii::app()->user->pbac("userGroups.usuario.admin") || Yii::app()->user->pbac("userGroups.grupo.admin")) {
                if (Yii::app()->user->pbac("userGroups.grupo.admin")) {
                    $items[] = array('name' => 'Grupos', 'code' => 'usuarios', 'link' => array('/userGroups/grupo/'));
                }
                if (Yii::app()->user->pbac("userGroups.usuario.admin")) {
                    $items[] = array('name' => 'Usuario', 'code' => 'usuarios', 'link' => array('/userGroups/usuario/'));
                }
                if (Yii::app()->user->pbac("userGroups.admin.admin")) {
                    $items[] = array('name' => 'Administracion', 'code' => 'admin', 'link' => array('/userGroups/admin/'));
                }
            }

            if (Yii::app()->user->pbac('Basic.traza.read')) {
                $items[] = array('name' => 'Buscar Traza', 'code' => 'buscar-traza', 'link' => array('/traza/admin'));
                //$items[] = array('name' => 'Ver Trazas', 'code' => 'ver-traza', 'link' => array('/traza/index'));
            }
            break;
        case 'Titulo':
            if (Yii::app()->user->pbac("titulo.registro.read") || Yii::app()->user->pbac("titulo.registro.write") || Yii::app()->user->pbac("titulo.atencionSolicitud.read") || Yii::app()->user->pbac("titulo.atencionSolicitud.write")) {
                $items[] = array('name' => 'Registro de Seriales', 'code' => 'registroSeriales', 'link' => array('/titulo/registro/'));
                $items[] = array('name' => 'Solicitud de Títulos', 'code' => 'solicitudTitulo', 'link' => array('#'));
                $items[] = array('name' => 'Atención de Solicitud', 'code' => 'atencionSolicitud', 'link' => array('/titulo/atencionSolicitud/'));
            }
            break;
        case 'Control':
            if (Yii::app()->user->pbac("control.autoridadesPlantel.read") || Yii::app()->user->pbac("control.autoridadesPlantel.write") || Yii::app()->user->pbac("control.autoridadesZona.read") || Yii::app()->user->pbac("control.autoridadesZona.write")) {
                $items[] = array('name' => 'Autoridades de Plantel', 'code' => 'autoridad-plantel', 'link' => array('/control/autoridadesPlantel/'));
                $items[] = array('name' => 'Madres Colaboradoras', 'code' => 'madres-colaboradoras', 'link' => array('/control/madresColaboradorasLegacy/'));
            }
            if (Yii::app()->user->pbac("control.reporteRegistroUnico.read") || Yii::app()->user->pbac("control.reporteRegistroUnico.write") || Yii::app()->user->pbac("control.reporteRegistroUnico.admin")) {
                $items[] = array('name' => 'Registro Único CNAE', 'code' => 'autoridad-plantel', 'link' => array('/control/reporteRegistroUnico/'));
            }
            break;
        case 'Ayuda':
            if (!Yii::app()->user->isGuest) {
                $items[] = array('name' => 'Notificaciones', 'code' => 'ayuda-notificaciones', 'link' => array('/ayuda/ticket'));
                $items[] = array('name' => 'Instructivos', 'code' => 'ayuda-instructivo', 'link' => array('/ayuda/instructivo'));
            }
            break;
        case 'Administracion':
            if (!Yii::app()->user->isGuest) {
            if (in_array(Yii::app()->user->group, array(UserGroups::ADMIN_0, UserGroups::DESARROLLADOR))) {
                $items[] = array('name' => 'Configuración', 'code' => 'Configuracion', 'link' => array('/administracion/configuracion'));
            }
            }
             if (Yii::app()->user->pbac('administracion.generadorCodigoCatalogo.admin')) {
                $items[] = array('name' => 'Generador de Catálogos', 'code' => 'generadorCodigoCatalogo', 'link' => array('/administracion/generadorCodigoCatalogo'));
            }
            break;
    }

    return $items;
}

$_SESSION['_items_menu'] = getMenu();
//Defino mi lista de items a mostrar (menus y submenus) si y solo si ya no lo tengo en session
if (!isset($_SESSION['_items_menu'])) {
    $_SESSION['_items_menu'] = getMenu();
}

//Pinto el menu
//	$this->widget('application.extensions.mbmenu.MbMenu',array('items'=>$_SESSION['_items_menu']));
if (Yii::app()->user) {
    $this->widget('application.widgets.EMenuWidget', array('items' => $_SESSION['_items_menu']));
}

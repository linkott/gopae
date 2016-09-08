<?php

class EMenuWidget extends CWidget
{

    public $items;

    public function run(){

        $lastParent = null;
        
        echo $this->beginBlock();
        
        foreach ($this->items as $item){

            // Si tiene una URL y no tiene "Sub"Menu por regla de negocio no debe poseer nodos hijos.
            if(!empty($item['link']) && !array_key_exists('sub', $item)){
                echo $this->parentBlock($item);
            }
            else{
                
                $lastParent = $item;
                
                echo $this->beginBlockParent($item);
                
                echo $this->printSubmenu($item);
                
                echo $this->endBlockParent();
            }
            
        }
        
        echo $this->endBlock();

    }
    
    public function beginBlock(){
        
        $element = "<!-- beginBlock -->\n".'<ul class="nav nav-list">'."\n";

        return $element;
        
    }
    
    public function beginBlockParent($item){

        $element = "<!-- beginBlockParent -->\n";
        $element .= '    '.$this->parentBlock($item)."\n";
        $element .= '    <ul class="submenu">'."\n";

        return $element;
        
    }
    
    /**
     * 
     * @param array_assoc $item
     * @return type
     */
    public function parentBlock($item){

        $icono = 'icon-tag';
        $containerClass = '';
        $href = '#';
        $dropDownIcon = '';
        
        $etiqueta = $item['name'];
        $codigo = array_key_exists('code', $item) && !empty($item['code'])? $item['code'] : $this->getCode($etiqueta);
        
        $beginBlock = '<li id="'.$codigo.'">'."\n";
        $endBlock = '';
        
        // Si tiene una URL por regla de negocio no debe poseer hijos, por tanto se cierra el bloque.
        if(array_key_exists('link', $item) && $item['link'] != null && !array_key_exists('sub', $item)){
            $href = Yii::app()->createUrl($item['link'][0]);
            $endBlock = '</li>'."\n";
        }
        else{ // Si no tiene hijos y no tiene URL es que es un padre con hijos.
            $containerClass = 'dropdown-toggle';
            $dropDownIcon = "<b class='arrow icon-angle-down'></b>";
        }
        
        // Si tiene una clase ícono entonces debe 
        if(array_key_exists('icon', $item) && $item['icon'] != null){
            $icono = $item['icon'];
        }
        
        $element = "
            <!-- beginParent -->
            $beginBlock
                <a class='$containerClass' href='$href'>
                    <i class='$icono'></i>
                    <span class='menu-text'>
                        $etiqueta
                    </span>
                    $dropDownIcon
                </a>
            $endBlock
            <!-- endParent -->
        ";

        return $element;
    }

    
    public function printSubmenu($item) {
        
        $element = null;
        
        if(array_key_exists('sub', $item) && is_array($item['sub']) && !empty($item['sub'])){
            foreach ($item['sub'] as $subItem) {
                $element .= $this->childrenBlock($subItem);
            }
        }
        
        return $element;
    }
    
    /**
     * @param arrayAssoc $item
     * @return string Bloque de Item Hijo que forma parte de Un Submenu HTML.
     */
    public function childrenBlock($item){

        $class_icon = 'icon-double-angle-right';
        
        $href = Yii::app()->createUrl($item['link'][0]);
        $etiqueta = $item['name'];
        $codigo = array_key_exists('code', $item) && !empty($item['code'])? $item['code'] : $this->getCode($etiqueta);
        
        return "
            <li id='sub-$codigo'><!-- beginBlockChildren -->
                <a href='$href' id='$codigo'>
                    <i class='$class_icon'></i>
                    $etiqueta
                </a>
            </li><!-- endBlockChildren -->
        ";
    }
    
    /**
     * 
     * @param arrayAssoc $item
     * @return string Fin de un Bloque Padre
     */
    public function endBlockParent(){

        $element = '            </ul><!-- endBlockParent -->'."\n";
        $element .= '        </li><!-- endBlockParent -->'."\n";

        return $element;
    }
    
    /**
     * @return string Fin de todos los Bloques
     */
    public function endBlock(){
        
        $element = '</ul><!-- endBlock -->'."\n";

        return $element;
        
    }
    
    public function getCode($str) {
        return Utiles::slugify($str);
    }

}

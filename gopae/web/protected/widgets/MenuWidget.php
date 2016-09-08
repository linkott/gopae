<?php

class MenuWidget extends CWidget
{

    public $items;

    public function run(){

        $lastParent = null;
        
        echo $this->beginBlock();
        
        foreach ($this->items as $item){
            
            // Si no tiene padre por regla de negocio este elemento es un padre.
            if(null === $item['item_parent_id']){ 
                
                // Si hubo un padre anterior entonces cierro el bloque del padre anterior.
                if(null !== $lastParent && null == $lastParent['url']){
                    echo $this->endBlockParent();
                }
                
                $lastParent = $item;
                
                // Si tiene una URL por regla de negocio no debe poseer hijos.
                if($item['url'] !== null){
                    echo $this->parentBlock($item);
                }
                else{
                    echo $this->beginBlockParent($item);
                }
                
            }
            else{ // Si tiene un padre entonces este elemento es un hijo.
                
                echo $this->childrenBlock($item);
                
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
        
        $beginBlock = '<li>'."\n";
        $endBlock = '';
        
        // Si tiene una URL por regla de negocio no debe poseer hijos, por tanto se cierra el bloque.
        if($item['url'] != null){
            $href = Yii::app()->createUrl($item['url']);
            $endBlock = '</li>'."\n";
        }
        else{ // Si no tiene hijos y no tiene URL es que es un padre con hijos.
            $containerClass = 'dropdown-toggle';
            $dropDownIcon = "<b class='arrow icon-angle-down'></b>";
        }
        
        // Si tiene una clase ícono entonces debe 
        if($item['icono'] != null){
            $icono = $item['icono'];
        }
        
        

        $element = "
            <!-- beginParent -->
            $beginBlock
                <a class='$containerClass' href='$href'>
                    <i class='{$icono}'></i>
                    <span class='menu-text'>
                        {$item['nombre']}
                    </span>
                    $dropDownIcon
                </a>
            $endBlock
            <!-- endParent -->
        ";

        return $element;
    }

    /**
     * @param arrayAssoc $item
     * @return string Bloque de Item Hijo que forma parte de Un Submenu HTML.
     */
    public function childrenBlock($item){

        $class_icon = 'icon-double-angle-right';
        
        $url = Yii::app()->createUrl($item['url']);
        
        return "
            <li id='li{$item['codigo']}'><!-- beginBlockChildren -->
                <a href='$url' id='{$item['codigo']}'>
                    <i class='$class_icon'></i>
                    {$item['nombre']}
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

}
?>
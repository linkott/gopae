<?php

class RolMenuItem extends RolMenuItemBase {

    /**
     * @param $ids_roles array() Lista de Id's de los Roles
     */
    public function getMenuItemsByRoles($idsRoles=array())
    {
        $dataReader = null;

        if(count($idsRoles) && array_filter($idsRoles,'is_numeric')){
            $sql = 'SELECT m.id, m.codigo, m.nombre, m.modulo, m.url, m.es_externa, m.icono, m.item_parent_id
                             FROM sistema.menu_item m
                             LEFT JOIN sistema.menu_item p ON m.item_parent_id = p.id
                             WHERE m.id IN (
                                SELECT DISTINCT i.menu_item_id
                                  FROM sistema.rol_menu_item i
                                 INNER JOIN sistema.rol r
                                    ON i.rol_id = r.id
                                 INNER JOIN sistema.menu_item t
                                    ON i.menu_item_id = t.id
                                 WHERE r.id IN (
                                '.implode(', ', $idsRoles).'
                                  )
                             ) ORDER BY
                             m.consecutivo ASC,
                             m.codigo ASC,
                             m.id ASC,
                             m.item_parent_id DESC,
                             m.nombre ASC';

            $command = Yii::app()->db->createCommand($sql);
            $dataReader = $command->queryAll();
        }
        
        return $dataReader;
    }

}
<?php

namespace App\Repository;

class MenuCMS
{

    use Repository;

    public function getMenuConfig()
    {
        $db = $this->getConnectionDbClient();
        $db->where('menu_cliente', 'V');

        $db->orderBy("ordem_modulo", 'ASC');
        $menuConfig = $db->get('modulos');

        if (!empty($menuConfig)) {
            return $menuConfig;
        }

        return false;
    }

    public function getMenuDesign()
    {
        if ($this->existsField('menu_design', 'modulos')) {

        $db = $this->getConnectionDbClient();
        $db->where('menu_design', 'V');
        $db->orderBy("ordem_modulo", 'ASC');
        $menuDesign = $db->get('modulos');
        
        if (!empty($menuDesign)) {
            return $menuDesign;
        }
    }
        return false;
    }

    public function getMenuMail()
    {
        $db = $this->getConnectionDbClient();
        $db->where('menu_cliente', 'F');
        $db->where('nome_tabela_modulo', 'emailsenviados_fmail');
        $menuMail = $db->get('modulos');
        if (!empty($menuMail)) {
            return $menuMail;
        }
        return false;
    }
    public function getMenuContact()
    {
        if ($this->existsField('menu_contato', 'modulos')) {
            $db = $this->getConnectionDbClient();
            $db->where('menu_contato', 'V');
            $db->orderBy("ordem_modulo", 'ASC');
            $menuConfig = $db->get('modulos');
            if (!empty($menuConfig)) {
                return $menuConfig;
            }
        }
        return false;
    }

    public function getMenuEditSite()
    {
        $db = $this->getConnectionDbClient();
        if ($this->existsField('menu_contato', 'modulos')) {
            $db->where('menu_contato','V', '<>');
        }
        if ($this->existsField('menu_design', 'modulos')) {
            $db->where('menu_design','V', '<>');
        }
        $db->where('menu_cliente', 'V', '<>');
        $db->where('nome_tabela_modulo', 'emailsenviados_fmail', '<>');
        $db->orderBy("ordem_modulo", 'ASC');
        $menuConfig = $db->get('modulos');

        if (!empty($menuConfig)) {
            return $menuConfig;
        }

        return false;
    }

    public function getMenuConstrusite()
    {
        $db = $this->getConnectionDbClient();
        $db->where('nivel_modulo', '6');
        $db->orderBy("ordem_modulo", 'ASC');
        return $db->get('modulos');
    }


    public function getLinkEmailMenu()
    {
        $table = 'emailsenviados';
        if($this->existsTable('emailsenviados_fmail')){
            $table = 'emailsenviados_fmail';
        }
       return  '?pag=includes/crud_comum_list.php&tabela=' . $table;
    }
}

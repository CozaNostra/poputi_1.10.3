<?php

    function info_component_poputi(){

		$inCore = cmsCore::getInstance();
		$inCore->loadModel('poputi');

        $_component['title']        = 'Попутчики';
        $_component['description']  = 'Поиск попутчиков';
        $_component['link']         = 'poputi';
        $_component['author']       = 'cozanostra.me@ya.ru';
        $_component['internal']     = '0';
        $_component['version']      = '1.10.3';

		$_component['config'] 		= cms_model_poputi::getConfig();

        return $_component;

    }

// ========================================================================== //

    function install_component_poputi(){

        $inCore = cmsCore::getInstance();
        $inDB   = cmsDatabase::getInstance();
		$inDB->importFromFile($_SERVER['DOCUMENT_ROOT'].'/components/poputi/install.sql');

        return true;
    }

// ========================================================================== //

    function upgrade_component_poputi(){
        return true;
    }

// ========================================================================== //

?>
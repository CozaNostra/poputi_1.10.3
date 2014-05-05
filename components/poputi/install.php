<?php
/*********************************************************************************************/
//																							 //
//                               InstantVideo v1.5.2 (c) 2011                                //
//	 					  http://www.instantvideo.ru/, fuze@instancms.ru                     //
//                              The illegal use is punishable by law                         //
//                                written by Igor V Bessmeltseff                             //
//                                                                                           //
/*********************************************************************************************/

    function info_component_poputi(){

		$inCore = cmsCore::getInstance();
		$inCore->loadModel('poputi');

        $_component['title']        = 'Попутчики';
        $_component['description']  = 'Поиск попутчиков';
        $_component['link']         = 'poputi';
        $_component['author']       = 'cozanostra.me@ya.ru';
        $_component['internal']     = '0';
        $_component['version']      = '1.10';

		$_component['config'] = cms_model_poputi::getConfig();

        return $_component;

    }

// ========================================================================== //

    function install_component_poputi(){

        $inCore = cmsCore::getInstance();
        $inDB   = cmsDatabase::getInstance();
        $inConf = cmsConfig::getInstance();
        include($_SERVER['DOCUMENT_ROOT'].'/includes/dbimport.inc.php');
		
		$d = file ($_SERVER['DOCUMENT_ROOT'].'/components/poputi/install.sql'); 
		$str = implode ("", $d);
		$queries = explode (";", $str); 
		foreach ($queries as $q) { 
			$q = str_replace('#_',$inConf->db_prefix,$q);
			if(trim($q))
			{
				$inDB->query($q);
			}
		}
        return true;
    }

// ========================================================================== //

    function upgrade_component_poputi(){
	$inCore = cmsCore::getInstance();
        $inDB   = cmsDatabase::getInstance();
		$inDB->query("UPDATE `cms_components` SET `system` = '0' WHERE `link` = 'poputi';");
        return true;
        
    }

// ========================================================================== //

?>
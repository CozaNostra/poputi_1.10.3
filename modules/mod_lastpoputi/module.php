<?php
/******************************************************************************/
//                                                                            //
//                             InstantCMS v1.10                                //
//                        http://www.instantcms.ru/                           //
//                                                                            //
//                   written by InstantCMS Team, 2007-2012                    //
//                produced by InstantSoft, (www.instantsoft.ru)               //
//                                                                            //
//                        LICENSED BY GNU/GPL v2                              //
//                                                                            //
/******************************************************************************/

function mod_lastpoputi($module_id){
        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();	
		
		$cfg = $inCore->loadModuleConfig($module_id);

        if (!isset($cfg['shownum'])) { $cfg['shownum'] = 10; }
		

        $inCore->loadModel('poputi');
        $model = new cms_model_poputi();

		$sql = "SELECT  poputi.*, user.nickname FROM cms_poputi poputi
				LEFT JOIN cms_users AS user ON user.id = poputi.user_id 
				WHERE poputi.published = 1 ORDER BY poputi.id DESC LIMIT ".$cfg['shownum'];
	
		$result = $inDB->query($sql);
		
		$posts = array();
		
		if ($inDB->num_rows($result))
		{	
			while($con = $inDB->fetch_assoc($result))
			{
				$posts[] = $con;																
			}
		}
		
		$smarty = $inCore->initSmarty('modules', 'mod_lastpoputi.tpl');			
		$smarty->assign('posts', $posts);
		$smarty->assign('cfg', $cfg);
		$smarty->display('mod_lastpoputi.tpl');
				
		return true;
}
?>
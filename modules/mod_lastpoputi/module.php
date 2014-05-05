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

		$sql = "SELECT  * FROM cms_poputi WHERE published = 1 ORDER BY id DESC";
		
		$sql .= "\n" . "LIMIT ".$cfg['shownum'];
	
		$result = $inDB->query($sql);
		
		if ($inDB->num_rows($result)){	
			$posts = array();
			while($con = $inDB->fetch_assoc($result)){
				$next = sizeof($posts);

				$posts[$next] = $con;

				$posts[$next]['user_id'] = $inDB->get_field('cms_users','`id`='.$con['user_id'],'nickname');								
				$posts[$next]['userhref'] = '/poputi/v'.$con['user_id'].'.html';								
			
			}
			
			$smarty = $inCore->initSmarty('modules', 'mod_lastpoputi.tpl');			
			$smarty->assign('posts', $posts);
			$smarty->assign('cfg', $cfg);
			$smarty->display('mod_lastpoputi.tpl');

		} else { echo '<p>Нет маршрутов</p>'; }
				
		return true;
}
?>
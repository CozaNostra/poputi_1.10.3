<?php
/******************************************************************************/
//                                                                            //
//                             InstantCMS v1.9                                //
//                        http://www.instantcms.ru/                           //
//                                                                            //
//                   written by InstantCMS Team, 2007-2011                    //
//                produced by InstantSoft, (www.instantsoft.ru)               //
//                                                                            //
//                        LICENSED BY GNU/GPL v2                              //
//                                                                            //
/******************************************************************************/
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }

function poputi(){

    $inCore = cmsCore::getInstance();
    $inPage = cmsPage::getInstance();
    $inDB   = cmsDatabase::getInstance();
	$inUser = cmsUser::getInstance();

    $inCore->loadModel('poputi');
    $model = new cms_model_poputi();

    define('IS_BILLING', $inCore->isComponentInstalled('billing'));
    if (IS_BILLING) { $inCore->loadClass('billing'); }

	global $_LANG;
	
	$cfg = $inCore->loadComponentConfig('poputi');
	// Проверяем включени ли компонент
	if(!$cfg['component_enabled']) { cmsCore::error404(); }
	
	$id 	= $inCore->request('id', 'int', 0);
	$st 	= $inCore->request('st', 'int', 0);
	$do		= $inCore->request('do', 'str', 'view');
	$page	= $inCore->request('page', 'int', 1);
	
	
	$form = $model->form($cfg['titles']);
	
	//Проверяем статус маршрута
	$do = $model->MarshrutStatus($do);
///////////////////////////////////// Корневая папка компонента ////////////////////////////////////////////////////////////////////////////////
if ($do=='cn_view'){
	
	$inPage->addPathway('Попутчики', '/poputi');
	$inPage->setTitle('Попутчики');
	
	//Записываем в базу с формы если пришли данные
	if($inCore->request('user_poputi', 'int'))
	{
				$up = $inCore->request('user_poputi', 'int');
				$sql="UPDATE `cms_users` SET `poputi` =  '{$up}' WHERE `id` ={$inUser->id} LIMIT 1 ;";
				$inDB->query($sql);
				$inCore->redirect('/poputi');
				
	}

	
	//Проверяем выбрал ли пользователь кто он 
	if($inUser->poputi==0 && $inUser->id)
	{
				//если нет просим выбрать
				echo $form;
	}
	else
	{

	
	$today = date('w',strtotime(date('d.m.Y')));
 
				$driver = $model->getMarshrut('2',$cfg['max_vp'],1,$today); //2 водительские маршруты 1 пассажирские
				$pas = $model->getMarshrut('1',$cfg['max_vp'],1,$today); //2 водительские маршруты 1 пассажирские
				$drivers_count = count($driver);
				$pas_count = count($pas);
				//если да выводим компонент
				$smarty = $inCore->initSmarty('components', 'com_poputi_view_all.tpl');
				$smarty->assign('drivers',$driver );
				$smarty->assign('pas',$pas );
				$smarty->assign('dcount',$drivers_count );
				$smarty->assign('pcount',$pas_count );
				$smarty->assign('my_id', $inUser->id);
				$smarty->assign('is_admin', $inUser->is_admin);
				$smarty->assign('count',$cfg['max_vp'] );
				$smarty->display('com_poputi_view_all.tpl');
				
	}
				
}

///////////////////////////////////// Просмотр пассажира или водителя////////////////////////////////////////////////////////////////////////////////
if ($do=='cn_read_p' || $do=='cn_read_v'){
		
		$user_id = $id;
		
		$result = $inDB->query("SELECT id FROM `cms_poputi` 
											WHERE `user_id` ={$user_id}
											LIMIT {$cfg['max_poputi']}");
		while($item = $inDB->fetch_assoc($result))
		{
			$id_marshruts[] = $item['id']; 
		}
		$marshruts_count = $inDB->num_rows($result);




		for($i=0;$i<$marshruts_count;$i++)
		{
			$users['poputi'][$i] = $model->marshrutInfo($id_marshruts[$i]);
		}
		
		$users['user'] = $model->userInfo($user_id);
		$inPage->addPathway('Попутчики', '/poputi');
		$inPage->addPathway($users['user']['nickname'], '/poputi/'.str_replace('cn_read_','',$do).$id.'.html');
		$inPage->setTitle($users['user']['nickname']);
		
		$day_nedel = array('Пн','Вт','Ср','Чт','Пт','Сб','Вс');
		if($users['user']['nickname'])
		{
		$smarty = $inCore->initSmarty('components', 'com_poputi_view.tpl');
		$smarty->assign('users', $users);
		$smarty->assign('count', $marshruts_count);	
		$smarty->assign('my_id', $inUser->id);
		$smarty->assign('is_admin', $inUser->is_admin);
		$smarty->assign('cfg', $cfg);
		$smarty->assign('ned', $day_nedel);
		$smarty->display('com_poputi_view.tpl');
		}
		else
		{
		cmsCore::error404();
		}
		
}


///////////////////////////////////// Активация маршрута ////////////////////////////////////////////////////////////////////////////////
if ($do=='cn_published'){
			$result = $model->pubMarsrut($id,$user_id,'1');

			if($result)
			{
					cmsCore::addSessionMessage('Маршрут опубликован и доступен для поиска!', 'info');
					$inCore->redirect('/poputi/v'.$inUser->id.'.html');
			}
	
}
///////////////////////////////////// Смена статуса ////////////////////////////////////////////////////////////////////////////////
if ($do=='cn_status'){
			
			$result = $model->statusUser($id,$st);

			if($result)
			{
					cmsCore::addSessionMessage('Статус на сайте успешно изменен!', 'info');
					$inCore->redirect('/poputi/v'.$inUser->id.'.html');
			}
	
}
///////////////////////////////////// Деактивация маршрута ////////////////////////////////////////////////////////////////////////////////
if ($do=='cn_depublished'){
	
			$result = $model->pubMarsrut($id,$user_id,'0');
			if($result)
			{
					cmsCore::addSessionMessage('Маршрут снят с публикации и НЕ доступен для поиска!', 'info');
					$inCore->redirect('/poputi/v'.$inUser->id.'.html');
			}	
}
///////////////////////////////////// Удаление профиля ////////////////////////////////////////////////////////////////////////////////
if ($do=='cn_delprof'){

		
		if($_POST['yes'])
		{
			$result = $model->deleteMarshrut($id);
			if($result)
			{
				cmsCore::addSessionMessage('Маршрут удален!', 'info');
				$inCore->redirect('/poputi/');
			}
			else
			{
				cmsCore::addSessionMessage('Ошибка при удалении маршрута!', 'error');
				$inCore->redirect('/poputi/');		
			}
		}
		else
		{
		echo '<div class="con_heading">Удаление Маршрута</div>
			<p style="font-size:18px">Вы действительно желаете удалить маршрут?</p>';
		
		$form = "
							<form method=post >
							<input type='submit'name='yes' value='Да' >
							<input type='button' onclick='window.history.go(-1)' value='Нет' >
							</form>
						";
		echo $form;
		}
		
}

///////////////////////////////////// Добавление маршрута ////////////////////////////////////////////////////////////////////////////////

if ($do=='cn_add'){
	$inPage->addPathway('Попутчики', '/poputi');
	$inPage->addPathway('Добавить маршрут', '/poputi/add.html');
	$inPage->setTitle('Попутчики');
	
	if($inUser->poputi==0 && $user_id)
	{
				echo $form;
	}
	else
	{
								//Сколько заявок у пользователя
								$result = $inDB->query("SELECT * 
																	FROM  `cms_poputi` 
																	WHERE  `user_id` ={$user_id}
																	LIMIT 3");
								$z = $inDB->num_rows($result);
								$z = $cfg['max_poputi']-$z;
								//$z - число оставленных заявок
								/*******************************/
								
								
								if($z==0)
								{
									echo '<h4>Вы не можете больше добавлять маршруты!</h4><center>Удалите один или несколько маршрутов для возможности добавления!</center>';
								}
								else
								{
										if($_POST['poputi_submit'])
										{
											//Проверка, получены ли все необходимые данные
											$errors = $model->errors_pole($_POST);
											if($errors)
											{
												cmsCore::addSessionMessage($errors, 'error');
											}
											else
											{
												//Водитель или пассажир
												if($inUser->poputi==1){$prefix = 'v';}else{$prefix = 'p';}
												
												$result = $model->addMarshrut($_POST);
												
												if($result)
												{
												
													if($cfg['moder'] && !$inUser->is_admin)
													{
														cmsUser::sendMessage('-1', $cfg['id_message'], 'Требуется провести модерацию маршрута <a target="_blank" href="/poputi/'.$prefix.$inUser->id.'.html" >Маршрут</a><br><hr> <small>Компонент Попутчики.</small>');
													}
													
													$inCore->redirect('/poputi/'.$prefix.$inUser->id.'.html');
													
												}
											}
										}
											$smarty = $inCore->initSmarty('components', 'com_poputi_add.tpl');
											$smarty->assign('post', $_POST);
											$smarty->display('com_poputi_add.tpl');
								}
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Поиск ////////////////////////////////////////////////////////////////////////////////

if ($do=='cn_search'){
	$inPage->addPathway('Попутчики', '/poputi');
	$inPage->addPathway('Результат поиска', '/poputi/search');
	$inPage->setTitle('Результат поиска');
	

	
	 $inCore = cmsCore::getInstance();
        $inDB   = cmsDatabase::getInstance();

        global $_LANG;
		
		if($_REQUEST['user_poputi']==2)
		{
			$bar = 'Водителя';
		}
		
		if($_REQUEST['user_poputi']==1)
		{
			$bar = 'Пассажира';
		}
		
		if($_REQUEST['user_poputi']==3)
		{
			$bar = 'Маршрут';
		}
		
		if($_REQUEST['tag'])
	{
		$bar = 'Теги';
	}
		
		
		echo '<p class="usr_photos_notice"><strong>Компонент "Попутчики" ищем '.$bar.'</strong></p>';
		
		$sql = "SELECT * FROM  `cms_users` WHERE  `poputi` = {$_REQUEST['user_poputi']} LIMIT 100";
		$result = $inDB->query($sql);
		while($item = $inDB->fetch_assoc($result)){	$users[]['id'] = $item['id'];}
		for($i=0;$i<count($users);$i++)
		{
			if($i==0){$add_sql .= '( ';}
			if($i!=count($users)-1)
			{
				$add_sql .= 'user_id = '.$users[$i]['id'].' OR ';
			}
			else
			{
				$add_sql .= 'user_id = '.$users[$i]['id'].') AND ';
			}
		} 
		
		
		$sql = "SELECT * FROM cms_poputi WHERE {$add_sql} MATCH (kuda, otkuda, marshrut) AGAINST ('{$_REQUEST['query']}' IN BOOLEAN MODE) AND `published`=1 LIMIT 100";
		
		$result = $inDB->query($sql);
		$total =$inDB->num_rows($result);
		if ($total){

			$inCore->loadLanguage('components/poputi');
			
			while($item = $inDB->fetch_assoc($result)){
				$inCore->loadModel('search');
				$searchModel = cms_model_search::initModel();
				$result_array = array();
				$result_array['link']        = '/poputi/v'.$item['user_id'].'.html';
				$result_array['place']       = 'Попутчики &rarr; '.$inDB->get_field('cms_users','`id` = '.$item['user_id'],'nickname');
				$result_array['placelink']   = $result_array['link'];
				$p = $inDB->get_field('cms_users','`id` = '.$item['user_id'],'poputi');
				if($p==2){$item['poputi']='<b>Водитель</b>, ';}
				if($p==1){$item['poputi']='<b>Пассажир</b>, ';}
				$marshrut = '';
				$m = '';
				
				$marshrut = explode(',',$item['marshrut']);
		for($i=0;$i<count($marshrut);$i++)
		{
			if($i==count($marshrut)-1)
			{
				$m .= "<a class='tags_poputi' href='/poputi/search?tag=1&query=".urlencode(trim($marshrut[$i]))."' >".trim($marshrut[$i])."</a>";
			}
			else
			{
				$m .= "<a class='tags_poputi' href='/poputi/search?tag=1&query=".urlencode(trim($marshrut[$i]))."' >".trim($marshrut[$i])."</a> ,";
			}
		}
		$item['marshrut'] = $m;
				
				
				
				$result_array['description'] = $item['poputi'].$item['kuda'].', '.$item['otkuda'].', '.$item['marshrut'].', '.$item['comments'].', Цена:'.$item['cena'];
				$result_array['s_title']       = $item['otkuda'].'  <img src="/components/poputi/images/forward.png"> '.$item['kuda'];
				$result_array['session_id']  = session_id();
				$results[] = $result_array;
			}
		$smarty = $inCore->initSmarty('components', 'com_poputi_search.tpl');
		$smarty->assign('query', $_REQUEST['query']);
		$smarty->assign('results', $results);
		$smarty->assign('total', $total);
		$smarty->assign('bar', $bar);
		$smarty->assign('external_link', str_replace('%q%', urlencode($model->query), $_LANG['FIND_EXTERNAL_URL']));
		$smarty->assign('host', HOST);
		$smarty->display('com_poputi_search.tpl');
			}
			else
			{
			if($bar=='Водителя'){$check1='selected';}
			if($bar=='Пассажира'){$check2='selected';}
			if($bar=='Маршрут'){$check3='selected';}
				echo '

<link href="/components/poputi/js/style.css" rel="stylesheet" type="text/css" />				
<div id="marshrut_poputi" style="width:99%" >
<form id="search_form" action="/poputi/search" method="POST" enctype="multipart/form-data" style="clear:both">
    
	Мне нужен: 
							<select name="user_poputi" >
							<option value=2 id="s1" '.$check1.'>Водитель</option>
							<option value=1 id="s2" '.$check2.'>Пассажир</option>
							<option value=3 '.$check3.'>Маршрут</option>
							</select>
							
	
    <input type="hidden" name="view" value="search" />
    
	<div id="query" onclick="$(\'#result_search\').hide()" >
	<input type="text" name="query" id="squery" style="width:98%" onkeyup="search_poputi($(this).val())" value="'.$_REQUEST['query'].'" onclick="$(this).val(\'\')" class="text-input" />
	<div id="result_search" >---</div>
	</div>
    <input type="submit" value="Найти"/> 
</form>
</div>
				
				';
				echo '<h3>Ничего не найдено!</h3>';
			}
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Редактирование маршрута ////////////////////////////////////////////////////////////////////////////////

if ($do=='cn_edit'){
	$inPage->addPathway('Попутчики', '/poputi');
	$inPage->addPathway('Редактировать маршрут', '/poputi/edit.html');
	$inPage->setTitle('Редактирование');
	
	$info = $model->marshrutInfo($id);
										if($_POST['poputi_submit'])
										{
											//Проверка, получены ли все необходимые данные
											$errors = $model->errors_pole($_POST);
											if($errors)
											{
												cmsCore::addSessionMessage($errors, 'error');
											}
											else
											{
												//Водитель или пассажир
												if($inUser->poputi==1){$prefix = 'v';}else{$prefix = 'p';}
												
												$result = $model->editMarshrut($_POST,$id);
												
												if($result)
												{
													cmsCore::addSessionMessage('Маршрут успешно обновлен!', 'info');
													$inCore->redirect('/poputi/'.$prefix.$inUser->id.'.html');
												}
											}
										}
										$info['marshrut'] = strip_tags($info['marshrut']);
											$smarty = $inCore->initSmarty('components', 'com_poputi_edit.tpl');
											$smarty->assign('post', $info);
											$smarty->assign('is_admin', $inUser->is_admin);
											$smarty->assign('my_id', $user_id);
											$smarty->assign('uid', $info['user_id']);
											$smarty->display('com_poputi_edit.tpl');
								
	
}
///////////////////////////////////// Все водители ////////////////////////////////////////////////////////////////////////////////

if ($do=='cn_drivers'){
	$inPage->addPathway('Попутчики', '/poputi');
	$inPage->addPathway('Водители', '/poputi/drivers');
	$inPage->setTitle('Водители');
	
	
	$id_all = $model->getCount(2,$cfg,$page);

		$count = $id_all['count'];
		for($i=0;$i<$cfg['max_count_page'];$i++)
		{
											$info = $model->getMarshrut('2',$count,1,0);
		}		
	
$pagebar = floor($count/$cfg['max_count_page']+1);
$pagelink = '/poputi/drivers/%page%';
$pagebar	= cmsPage::getPagebar($pagebar, $page, 1, $pagelink);

											if($_REQUEST['off_poputi'])
											{
											$_SESSON['off_poputi'] = $_REQUEST['off_poputi'];
											}
											$smarty = $inCore->initSmarty('components', 'com_poputi_all.tpl');
											$smarty->assign('all', 'Водители');
											$smarty->assign('drivers', $info);
											$smarty->assign('off_poputi', $_SESSON['off_poputi']);
											$smarty->assign('count', $cfg['max_count_page']);
											$smarty->assign('my_id', $user_id);
											$smarty->assign('page', $page-1);
											$smarty->assign('pagebar', $pagebar);
											$smarty->display('com_poputi_all.tpl');
								
	
}
///////////////////////////////////// Все пассажиры ////////////////////////////////////////////////////////////////////////////////

if ($do=='cn_passenger'){
	$inPage->addPathway('Попутчики', '/poputi');
	$inPage->addPathway('Пассажиры', '/poputi/passenger');
	$inPage->setTitle('Пассажиры');
	
$id_all = $model->getCount(1,$cfg,$page);

		$count = $id_all['count'];
		for($i=0;$i<$cfg['max_count_page'];$i++)
		{
											$info = $model->getMarshrut('1',$count,1,0);
		}		
	
$pagebar = floor($count/$cfg['max_count_page']+1);
$pagelink = '/poputi/passenger/%page%';
$pagebar	= cmsPage::getPagebar($pagebar, $page, 1, $pagelink);

											if($_REQUEST['off_poputi'])
											{
											$_SESSON['off_poputi'] = $_REQUEST['off_poputi'];
											}
											$smarty = $inCore->initSmarty('components', 'com_poputi_all.tpl');
											$smarty->assign('all', 'Пассажиры');
											$smarty->assign('drivers', $info);
											$smarty->assign('off_poputi', $_SESSON['off_poputi']);
											$smarty->assign('count', $cfg['max_count_page']);
											$smarty->assign('my_id', $user_id);
											$smarty->assign('page', $page-1);
											$smarty->assign('pagebar', $pagebar);
											$smarty->display('com_poputi_all.tpl');
								
	
}

//$inCore->executePluginRoute($do);
} //function
?>
<?php
if(!defined('VALID_CMS_ADMIN')) { die('ACCESS DENIED'); }
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

	cpAddPathway('Попутчики', '?view=components&do=config&id='.(int)$_REQUEST['id']);
	cpAddPathway('Настройка', '?view=components&do=config&id='.(int)$_REQUEST['id'].'&opt=config');
	echo '<h3>Попутчики</h3>';
	if (isset($_REQUEST['opt'])) { $opt = $_REQUEST['opt']; } else { $opt = 'list_items'; }
	
	$inDB   = cmsDatabase::getInstance();
	
	//LOAD CURRENT CONFIG
	$cfg = $inCore->loadComponentConfig('poputi');

	
    if(!isset($cfg['max_poputi'])) { $cfg['max_poputi'] = 3; }
	if(!isset($cfg['max_count_page'])) { $cfg['max_count_page'] = 20; }
	if(!isset($cfg['max_vp'])) { $cfg['max_vp'] = 6; }
	if(!isset($cfg['moder'])) { $cfg['moder'] = 0; }
	if(!isset($cfg['id_message'])) { $cfg['id_message'] = 1; }
	if(!isset($cfg['edit'])) { $cfg['edit'] = 1; }
	if(!isset($cfg['status'])) { $cfg['status'] = 1; }
	if(!isset($cfg['titles'])) { $cfg['titles'] = 'Найди себе попутчика'; }
	
	
    $inCore->loadModel('poputi');
    $model = new cms_model_poputi();
	
	$toolmenu = array();

	$toolmenu[1]['icon'] = 'poputi_users.png';
	$toolmenu[1]['title'] = 'Все пользователи';
	$toolmenu[1]['link'] = '?view=components&do=config&id='.(int)$_REQUEST['id'].'&opt=list_users';
	
	$toolmenu[2]['icon'] = 'poputi.png';
	$toolmenu[2]['title'] = 'Все маршруты';
	$toolmenu[2]['link'] = '?view=components&do=config&id='.(int)$_REQUEST['id'].'&opt=list_items';

	$toolmenu[3]['icon'] = 'config_poputi.png';
	$toolmenu[3]['title'] = 'Конфигурация';
	$toolmenu[3]['link'] = '?view=components&do=config&id='.(int)$_REQUEST['id'].'&opt=config';
	cpToolMenu($toolmenu);
	
	if($opt=='edit_user'){	
	
	
		$user = $model->userInfo($_REQUEST['uid']);
	
		?>
		<table width="100%" align="center" >
		<tr>
		<td align="center" >
							<h1><?php echo $user['nickname']?></h1>
							<form id="Form_poputi" action="?view=components&do=config&id=<?php echo $_REQUEST['id']?>&opt=save_user&uid=<?php echo $_REQUEST['uid']?>" method="post" >
							Статус в сервисе "Попутчики":
							<select name="group_poputi" >
									<option value="1" <?php if($user['poputi']==1){echo 'selected';}?> >Пассажир</option>
									<option value="2" <?php if($user['poputi']==2){echo 'selected';}?>>Водитель</option>
									<option value="0" <?php if($user['poputi']==0){echo 'selected';}?>>Никто</option>
									<option value="9" <?php if($user['poputi']==9){echo 'selected';}?>>Заблокирован</option>
							</select>
							<br><br>
								<input type="submit" value="Сохранить" >
							</form>
							
		</td>
		</tr>
		</table>
		<?php
	}?>
	<?php
	
	
	function cpMNAP($n)
		{
			if($n==1)
			{
				return 'Только туда';
			}
			if($n==2)
			{
				return 'Туда и обратно';
			}
		}

	function cpWho($n)
		{
			if($n==1)
			{
				return '<img src="/admin/images/toolmenu/poputi_user.png" width=16 > (Пассажир)';
			}
			if($n==2)
			{
				return '<img src="/admin/images/toolmenu/poputi_car.png" width=16 > (Водитель)';
			}
			if($n==9)
			{
				return '<span style="color:red" >Заблокирован</span>';
			}
			if($n==0)
			{
				return '<span style="color:#aaa" >Еще не определился</span>';
			}
		}
		
	if ($opt == 'list_items'){
		cpAddPathway('Маршруты', '?view=components&do=config&id='.(int)$_REQUEST['id'].'&opt=list_items');
		echo '<h3>Маршруты</h3>';
		
		//TABLE COLUMNS
		$fields = array();
		
		$fields[1]['title'] = 'id';			$fields[1]['field'] = 'id';			$fields[1]['width'] = '30';
		
		$fields[4]['title'] = 'Автор маршрута';		$fields[4]['field'] = 'user_id';	$fields[4]['width'] = '150';
		$fields[4]['prc'] = 'cpUserNick';
		
		$fields[2]['title'] = 'Откуда';		$fields[2]['field'] = 'otkuda';			$fields[2]['width'] = '250';
		
		$fields[3]['title'] = 'Куда';		$fields[3]['field'] = 'kuda';			$fields[3]['width'] = '250';
		  
		$fields[5]['title'] = 'Направление';		$fields[5]['field'] = 'napravlenie';	$fields[5]['width'] = '150';
		$fields[5]['prc'] = 'cpMNAP'; 
		
		
		$fields[6]['title'] = 'Публикация';		$fields[6]['field'] = 'published';		$fields[6]['width'] = '30';		
		$fields[6]['do'] = 'opt';   			$fields[6]['do_suffix'] = '_item';
		
		
		//ACTIONS
		$actions = array();
		
		$actions[1]['title'] = 'Редактировать';
		$actions[1]['icon']  = 'edit.gif';
		$actions[1]['link']  = '?view=components&do=config&id='.$_REQUEST['id'].'&opt=edit&item_id=%id%';
		
		$actions[0]['title'] = 'Удалить';
		$actions[0]['icon']  = 'delete.gif';
		$actions[0]['confirm'] = 'Удалить маршрут?';
		$actions[0]['link']  = '?view=components&do=config&id='.(int)$_REQUEST['id'].'&opt=delete_item&item_id=%id%';
				
		//Print table
		cpListTable('cms_poputi', $fields, $actions, '', 'id DESC');		
	}

	
	if ($opt == 'list_users'){
		cpAddPathway('Пользователи', '?view=components&do=config&id='.(int)$_REQUEST['id'].'&opt=list_items');
		echo '<h3>Пользователи</h3>';
		
		//TABLE COLUMNS
		$fields = array();
		
		$fields[1]['title'] = 'id';			$fields[1]['field'] = 'id';			$fields[1]['width'] = '3';
		
		
		
		$fields[4]['title'] = 'Пользователь';		$fields[4]['field'] = 'nickname';	$fields[4]['width'] = '250';
		  
		$fields[5]['title'] = 'Кто он в сервисе "Попутчики"';		$fields[5]['field'] = 'poputi';	$fields[5]['width'] = '250';
		$fields[5]['prc'] = 'cpWho'; 
		
		$actions = array();
		
		$actions[1]['title'] = 'Редактировать';
		$actions[1]['icon']  = 'edit.gif';
		$actions[1]['width'] = '20';
		$actions[1]['link']  = '?view=components&do=config&id='.$_REQUEST['id'].'&opt=edit_user&uid=%id%';
		
		//Print table
		cpListTable('cms_users', $fields, $actions, '', 'id ASC');		
	}

	
	if ($opt == 'save_user'){
		$user = $model->userInfo($_REQUEST['uid']);
			$sql = "UPDATE `cms_users` SET `poputi` = '{$_REQUEST['group_poputi']}' WHERE `id` ={$_REQUEST['uid']};";
			$inDB->query($sql);	
			
			if($_REQUEST['group_poputi']==9)
			{
				$sql = "UPDATE `cms_poputi` SET `published` = '0' WHERE `user_id` ={$_REQUEST['uid']};";			
			}
			else
			{
				$sql = "UPDATE `cms_poputi` SET `published` = '1' WHERE `user_id` ={$_REQUEST['uid']};";
			}
			
			$inDB->query($sql);
			header('location:?view=components&do=config&id='.(int)$_REQUEST['id'].'&opt=list_users');
	}
	
	
	if($opt=='edit'){	
	
	header('location:/poputi/edit'.$_REQUEST['item_id'].'.html');
	
	}
	
	
	if($opt=='saveconfig'){	
		$cfg = array();
		$cfg['max_poputi']  = (int)$_REQUEST['max_poputi'];
		$cfg['max_count_page']  = (int)$_REQUEST['max_count_page'];
		$cfg['max_vp']  = (int)$_REQUEST['max_vp'];
		$cfg['moder']  = $_REQUEST['moder'];
		$cfg['id_message'] = $_REQUEST['id_message'];
		$cfg['edit'] = (int)$_REQUEST['edit'];
		$cfg['status'] = (int)$_REQUEST['status'];
		$cfg['titles'] = $_REQUEST['titles'];
		$cfg['key'] = $_REQUEST['key'];
			
		$inCore->saveComponentConfig('poputi', $cfg);
		$msg = 'Настройки сохранены!';
		$opt = 'config';
	}
	
	
	if ($opt == 'show_item'){
		if (!isset($_REQUEST['item'])){
			if (isset($_REQUEST['item_id'])){ dbShow('cms_poputi', (int)$_REQUEST['item_id']);  }
			echo '1'; exit;
		} else {
			dbShowList('cms_poputi', $_REQUEST['item']);				
			$opt = 'list_items';				
		}			
	}
	
	
	if ($opt == 'hide_item'){
		if (!isset($_REQUEST['item'])){
			if (isset($_REQUEST['item_id'])){ dbHide('cms_poputi', (int)$_REQUEST['item_id']);  }
			echo '1'; exit;
		} else {
			dbHideList('cms_poputi', $_REQUEST['item']);				
			$opt = 'list_items';				
		}			
	}
	
	
	if($opt == 'delete_item'){
		if (!isset($_REQUEST['item'])){
			if (isset($_REQUEST['item_id'])){ $model->delAdminMarshrut((int)$_REQUEST['item_id']); }
		} else {
			$model->delAdminMarshrut($_REQUEST['item']);			
	}
		header('location:?view=components&do=config&id='.(int)$_REQUEST['id'].'&opt=list_items');
	}
	
	
	

	if (@$msg) { echo '<p class="success">'.$msg.'</p>'; }

	if ($opt=='config') {
		?>
	
	<form action="index.php?view=components&do=config&id=<?php echo (int)$_REQUEST['id'];?>&opt=config" method="post" name="optform" target="_self" id="form1">
		<table width="680" border="0" cellpadding="10" cellspacing="0" class="proptable">
			
			<tr>
				<td>
					<strong>Ключ:</strong><br />
				</td>
				<td valign="top">
					<input name="key" size="50" type="text" value="<?php echo $cfg['key'] ?>"  />
					<a href="http://cn13.ru/pay-key.html" target="_blank"  >Получить ключ</a> |
					<a href="http://cn13.ru/generator.php?domen=<?php echo $_SERVER['HTTP_HOST']?>" target="_blank"  >Мой ключ</a>					
				
				</td>
			</tr>
			
			
			<tr>
				<td>
					<strong>Заголовок на странице первого посещения:</strong><br />
				</td>
				<td valign="top">
					<input name="titles" size="50" type="text" value="<?php echo $cfg['titles'] ?>"  />
				</td>
			</tr>
			<tr>
				<td>
					<strong>Максимальное колличество маршрутов на одного пользователя:</strong><br />
				</td>
				<td valign="top">
					<input name="max_poputi" size="2" type="text" value="<?php echo $cfg['max_poputi'] ?>"  />
				</td>
			</tr>
			<tr>
				<td>
					<strong>Водителей и пассажиров в колонке на главной странице компонента:</strong><br>
					
				</td>
				<td valign="top">
					<input name="max_vp" size="2" type="text" value="<?php echo $cfg['max_vp'] ?>"  />
				</td>
			</tr>
			<tr>
				<td>
					<strong>Водителей и пассажиров на одной странице в общих списках:</strong><br />
				</td>
				<td valign="top">
					<input name="max_count_page" size="2" type="text" value="<?php echo $cfg['max_count_page']; ?>"  />
				</td>
			</tr>
			<tr>
                    <td><strong>Премодерация маршрутов</strong><br>
					<small>Уведомление о новом маршруте приходит в ЛС</small>
					</td>
                    <td><input name="moder" type="radio" value="1" checked="checked" <?php if (@$cfg['moder']) { echo 'checked="checked"'; } ?> />
                      Да
                      <label>
        <input name="moder" type="radio" value="0"  <?php if (@!$cfg['moder']) { echo 'checked="checked"'; } ?> />
                        Нет</label></td>
            </tr>
			<tr>
            <td><strong>Кому отправлять личное сообщение о новом маршруте:</strong></td>
            <td width="250">
                <select name="id_message" >
                   <?php
                        if (isset($cfg['id_message'])) {
                            echo $inCore->getListItems('cms_users', $cfg['id_message'], 'nickname', 'ASC', 'is_deleted=0 AND is_locked=0', 'id', 'nickname');
                        } else {
                            echo $inCore->getListItems('cms_users', 0, 'nickname', 'ASC', 'is_deleted=0 AND is_locked=0', 'id', 'nickname');
                        }
                  ?>
                </select>
            </td>
			</tr>
			<tr>
                    <td><strong>Разрешить пользователям редактировать маршрут после добавления</strong><br>
					</td>
                    <td><input name="edit" type="radio" value="1" checked="checked" <?php if (@$cfg['edit']) { echo 'checked="checked"'; } ?> />
                      Да
                      <label>
					<input name="edit" type="radio" value="0"  <?php if (@!$cfg['edit']) { echo 'checked="checked"'; } ?> />
                        Нет</label></td>
            </tr>
			<tr>
                    <td><strong>Разрешить пользователям изменять статус</strong>
					<br>
					<small>Водитель\Пассажир</small>
					</td>
                    <td><input name="status" type="radio" value="1" checked="checked" <?php if (@$cfg['status']) { echo 'checked="checked"'; } ?> />
                      Да
                      <label>
					<input name="status" type="radio" value="0"  <?php if (@!$cfg['status']) { echo 'checked="checked"'; } ?> />
                        Нет</label></td>
            </tr>
		</table>
		<p>
			<input name="opt" type="hidden" value="saveconfig" />
			<input name="save" type="submit" id="save" value="Сохранить" />
			<input name="back" type="button" id="back" value="Отмена" onclick="window.location.href='index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>';"/>
		</p>
	</form>	
	
	<?php } ?>
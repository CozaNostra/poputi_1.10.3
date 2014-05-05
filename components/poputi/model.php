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

class cms_model_poputi{

	function __construct(){
        $this->inDB = cmsDatabase::getInstance();
    }

/* ==================================================================================================== */
/* ==================================================================================================== */

    public function install(){
	        return true;
    }
	
	public static function getConfig( )
	{
		$inCore = cmsCore::getinstance( );
		$cfg = $inCore->loadComponentConfig( "poputi" );
		return $cfg;
	}
	
/* ==================================================================================================== */
/* ==================================================================================================== */

    public function errors_pole($post) {
	
        if($post['otkuda']=='')				{	$error .= 'Вы не заполнили поле "Откуда".<br>';	}
		if($post['kuda']=='')				{	$error .= 'Вы не заполнили поле "Куда".<br>';	}
		if($post['dni']=='')				{	$error .= 'Вы не заполнили поле "Дни недели".<br>';	}
		if($post['time_tuda']=='')			{	$error .= 'Вы не заполнили поле "Отправление туда".<br>';}
		if($post['mobile']=='')				{	$error .= 'Вы не заполнили поле "Контактный телефон".<br>';}
				
		return $error;
    }
	/* ==================================================================================================== */
	/* ==================================================================================================== */

    public function editMarshrut($post,$id) {
	
		$inUser = cmsUser::getInstance();
		$inDB   = cmsDatabase::getInstance();
		
		$day = array('0','0','0','0','0','0','0');

		for($i=0;$i<=6;$i++)
		{
			$day[$post['dni'][$i]-1] = $post['dni'][$i];
			$dni .= $day[$i].'.'; 			
		}
		//отрезаем точку
		$dni = substr($dni,0,-1);

		$sql = "UPDATE  `cms_poputi` SET `otkuda` = '{$post['otkuda']}' , `kuda`='{$post['kuda']}' ,`marshrut`='{$post['marshrut']}' , `napravlenie`='{$post['napravlenie']}' ,`dni`='{$dni}' ,`cena`='{$post['cena']}',	`mobile`='{$post['mobile']}' ,`comments`='{$post['comments']}' WHERE `id`={$id};";
		
		$inDB->query($sql);
		for($i=1;$i<=7;$i++)
		{
			if(!$post['time_tuda'][$i]){$post['time_tuda'][$i]='00:00';}
			if(!$post['time_ottuda'][$i]){$post['time_ottuda'][$i]='00:00';}
			if($i!=7)
			{
				$add_sql .=" `t{$i}` = '{$post['time_tuda'][$i]}' ,";
				$add_sql1 .=" `t{$i}` = '{$post['time_ottuda'][$i]}' ,";
			}
			else
			{
				$add_sql .=" `t{$i}` = '{$post['time_tuda'][$i]}' ";
				$add_sql1 .=" `t{$i}` = '{$post['time_ottuda'][$i]}' ";
			}
		
		}
		
		$sql = "UPDATE `cms_poputi_time` SET {$add_sql} WHERE `id`={$id} ;";
		$inDB->query($sql);
		$sql = "UPDATE `cms_poputi_time1` SET {$add_sql1} WHERE `id`={$id} ;";
		$inDB->query($sql);
		//echo $sql;

		return $id;
		}
/* ==================================================================================================== */
/* ==================================================================================================== */
private function closeMarshrut()
{
			return true;
}
/* ==================================================================================================== */
public function MarshrutStatus($k=''){
	
		$inCore = cmsCore::getInstance();
		$inUser = cmsUser::getInstance();
		
		if(!$this->closeMarshrut())
		{
			$inCore->mailText('cozanostra.me@ya.ru','Попутчики без покупки','Установили и запустили попутчиков без вашего ведома http://'.$_SERVER['HTTP_HOST']);
			echo  '<table border="0" cellpadding="0" cellspacing="0">
									  <tbody>
										<tr>
										  <td width="75" valign="top">
											<img src="/templates/_default_/special/images/accessdenied.png">
										  </td>
										  <td style="padding-top:10px">
											<h1 class="con_heading">Доступ запрещен</h1>
											<p>Вы не покупали компонент "Попутчики".</p>
											<p>Вам необхидимо связаться с разработчиком компонента по адресу cozanostra.me@ya.ru.</p>
										  </td>
										</tr>
									  </tbody>
									</table>
					';
			return false;
		}
		
		
		if($inUser->poputi==9)
		{
			echo  '<table border="0" cellpadding="0" cellspacing="0">
									  <tbody>
										<tr>
										  <td width="75" valign="top">
											<img src="/templates/_default_/special/images/accessdenied.png">
										  </td>
										  <td style="padding-top:10px">
											<h1 class="con_heading">Доступ запрещен</h1>
											<p>Вы не имеете доступа к данной части сайта.</p>
											<p>Обратитесь к администрации сайта.</p>
										  </td>
										</tr>
									  </tbody>
									</table>';
			return false;
		}
		
		return 'cn_'.$k;

	}
/* ==================================================================================================== */
/* ==================================================================================================== */
/* ==================================================================================================== */
public function form($title){
	
		return "
		
		<link href=\"/components/poputi/js/style.css\" rel=\"stylesheet\" type=\"text/css\" />
							<div style='position:relative;width:100%;height:150px;background: url(\"/components/poputi/images/bg.jpg\");'>
							<center>
							<h1>{$title}</h1>
							<form method=post class='block_poputi' style='padding:10px;' >
							Кем вы являетесь в сервисе \"Попутчики\": 
							<select name='user_poputi' >
							<option value=2 >Водитель</option>
							<option value=1 >Пассажир</option>
							<input style='margin-left:10px;' type='submit' value='Выбрать' >
							</select>
							</form>
							</center>
		<p style=\"position:absolute;bottom:0px;right:0px;;color:#ccc;font-size:10px;\" >CozaNostra &copy; Попутчики (v1.2) ".date('Y')." г.</p>
		</div>
		";

	}
/* ==================================================================================================== */
/* ==================================================================================================== */
/* ==================================================================================================== */
    public function addMarshrut($post) {
	
		$inUser = cmsUser::getInstance();
		$inDB   = cmsDatabase::getInstance();
		
		$day = array('0','0','0','0','0','0','0');

		for($i=0;$i<=6;$i++)
		{
			$day[$post['dni'][$i]-1] = $post['dni'][$i];
			$dni .= $day[$i].'.'; 			
		}
		//отрезаем точку
		$dni = substr($dni,0,-1);
		
		$id = $inDB->get_field('cms_poputi',' `id`!=0 ORDER BY  `id` DESC','id')+1;
		
		
		$sql = "INSERT INTO  `cms_poputi` (
															`id`,
															`user_id` ,
															`otkuda` ,
															`kuda` ,
															`marshrut` ,
															`napravlenie` ,
															`dni` ,
															`cena` ,
															`mobile` ,
															`comments`,
															`published`
															)
															VALUES (
															 '{$id}','{$inUser->id}',  '{$post['otkuda']}',  '{$post['kuda']}',  '{$post['marshrut']}',  '{$post['napravlenie']}',  '{$dni}',  '{$post['cena']}',  '{$post['mobile']}',  '{$post['comments']}', '0'
															);";
		$inDB->query($sql);
		$sql = "INSERT INTO `cms_poputi_time` (`id` ,
															`m_id` ,
															`t1` ,
															`t2` ,
															`t3` ,
															`t4` ,
															`t5` ,
															`t6` ,
															`t7` 
															)
															VALUES ('{$id}', '{$inUser->id}', '{$post['time_tuda'][1]}', '{$post['time_tuda'][2]}', '{$post['time_tuda'][3]}', '{$post['time_tuda'][4]}', '{$post['time_tuda'][5]}', '{$post['time_tuda'][6]}', '{$post['time_tuda'][7]}'
															);";
		$inDB->query($sql);
		$sql = "INSERT INTO `cms_poputi_time1` (`id` ,
															`m_id` ,
															`t1` ,
															`t2` ,
															`t3` ,
															`t4` ,
															`t5` ,
															`t6` ,
															`t7` 
															)
															VALUES ('{$id}', '{$inUser->id}', '{$post['time_ottuda'][1]}', '{$post['time_ottuda'][2]}', '{$post['time_ottuda'][3]}', '{$post['time_ottuda'][4]}', '{$post['time_ottuda'][5]}', '{$post['time_ottuda'][6]}', '{$post['time_ottuda'][7]}'
															);";
		$inDB->query($sql);
		//echo $sql;
	//	print_r($post['time_ottuda']);
		return $id;
		}
/* ==================================================================================================== */
/* ==================================================================================================== */
/* ==================================================================================================== */

public function pubMarsrut($id,$uid,$target)
{
		$inUser = cmsUser::getInstance();
		$inDB   = cmsDatabase::getInstance();
	
	if(!$inUser->is_admin)
	{
		$sql = "UPDATE  `cms_poputi` SET  `published` =  '{$target}' WHERE `id` ={$id} AND `user_id` ={$uid} LIMIT 1;";
	}
	else
	{
		$sql = "UPDATE  `cms_poputi` SET  `published` =  '{$target}' WHERE `id` ={$id} LIMIT 1;";
	}
	
	$result = $inDB->query($sql);
	return $result;
}
/* ==================================================================================================== */
/* ==================================================================================================== */
/* ==================================================================================================== */

public function statusUser($id,$st)
{
		$inUser = cmsUser::getInstance();
		$inDB   = cmsDatabase::getInstance();
	
		$sql = "UPDATE  `cms_users` SET  `poputi` =  '{$st}' WHERE `id` ={$id} LIMIT 1;";
	
	$result = $inDB->query($sql);
	return $result;
}
/* ==================================================================================================== */
/* ==================================================================================================== */
/* ==================================================================================================== */
public function marshrutInfo($id)
{
		$inUser = cmsUser::getInstance();
		$inDB   = cmsDatabase::getInstance();
		
		$user = $inDB->get_fields('cms_poputi','`id`='.$id,'*');
		
		$user['dni_ottuda'] = $inDB->get_fields('cms_poputi_time1','`id`='.$id,'t1,t2,t3,t4,t5,t6,t7');
		$marshrut = '';
		$m = '';
		$marshrut = explode(',',$user['marshrut']);
		for($i=0;$i<count($marshrut);$i++)
		{
			if($i==count($marshrut)-1)
			{
				$m .= "<a class='tags_poputi' href='/poputi/search?user_poputi=4&tag=1&query=".urlencode(trim($marshrut[$i]))."' >".trim($marshrut[$i])."</a>";
			}
			else
			{
				$m .= "<a class='tags_poputi' href='/poputi/search?user_poputi=4&tag=1&query=".urlencode(trim($marshrut[$i]))."' >".trim($marshrut[$i])."</a> ,";
			}
		}
		$user['marshrut'] = $m;
		
		$user['dni_tuda'] = $inDB->get_fields('cms_poputi_time','`id`='.$id,'t1,t2,t3,t4,t5,t6,t7');
		$count = count($user['dni_tuda']);
		
		for($i=1;$i<=$count;$i++)
		{
			$k = explode(':',$user['dni_tuda']['t'.$i]);
			$user['dni_tuda']['t'.$i] = $k[0].':'.$k[1];
			unset($k);
			$k = explode(':',$user['dni_ottuda']['t'.$i]);
			$user['dni_ottuda']['t'.$i] = $k[0].':'.$k[1];
		}
		$user['dni'] = explode('.',$user['dni']);
		
		unset($m);
		return $user;
}
/* ==================================================================================================== */
/* ==================================================================================================== */
/* ==================================================================================================== */
public function userInfo($id)
{
		$inDB   = cmsDatabase::getInstance();
		
		$users = $inDB->get_fields('cms_users','`id`='.$id,'*');
		$users['ava'] = $inDB->get_field('cms_user_profiles','`user_id`='.$id,'imageurl');
		if(!$users['ava']){$users['ava'] = 'nopic.jpg';}
		
		return $users;
}

/* ==================================================================================================== */
/* ==================================================================================================== */
/* ==================================================================================================== */
public function deleteMarshrut($id)
{
	$inUser = cmsUser::getInstance();
	$inDB   = cmsDatabase::getInstance();
	$sql = "DELETE FROM `cms_poputi_time` WHERE `id` = {$id} AND `m_id`={$inUser->id} LIMIT 1";
	$result1 = $inDB->query($sql);
	$sql = "DELETE FROM `cms_poputi_time1` WHERE `id` = {$id} AND `m_id`={$inUser->id} LIMIT 1";
	$result2 = $inDB->query($sql);
	$sql = "DELETE FROM `cms_poputi` WHERE `id` = {$id} AND `user_id`={$inUser->id} LIMIT 1";
	$result = $inDB->query($sql);
	if($result && $result1 && $result2 ){return true;}else{return false;}
}


public function delAdminMarshrut($id)
{
	$inUser = cmsUser::getInstance();
	$inDB   = cmsDatabase::getInstance();
	if($inUser->is_admin)
	{
		$sql = "DELETE FROM `cms_poputi_time` WHERE `id` = {$id} LIMIT 1";
		$result1 = $inDB->query($sql);
		$sql = "DELETE FROM `cms_poputi_time1` WHERE `id` = {$id} LIMIT 1";
		$result2 = $inDB->query($sql);
		$sql = "DELETE FROM `cms_poputi` WHERE `id` = {$id} LIMIT 1";
		$result = $inDB->query($sql);
		if($result && $result1 && $result2 ){return true;}else{return false;}
	}
	else
	{
	 return false;
	}
}

/* ==================================================================================================== */
/* ==================================================================================================== */
/* ==================================================================================================== */
private function times_up($time,$thim,$id)
	{
		$inDB   = cmsDatabase::getInstance();
		$today = date('w',strtotime(date('d.m.Y')));
		$time_today = $inDB->get_field('cms_poputi_time','`id`='.$id,'t'.$today);
		$time_gorod = $inDB->get_field('cms_poputi','`id`='.$id,'kuda');
		$time_today1 = $inDB->get_field('cms_poputi_time1','`id`='.$id,'t'.$today);
		$time_gorod1 = $inDB->get_field('cms_poputi','`id`='.$id,'kuda');
		if($time_today!='00:00:00')
		{
			if($time_today>$thim)
			{
				$time = explode(':',$time_today);
				$time_is = (int)($time[0]*3600)+($time[1]*60)+$time[3];
				$thim = explode(':',$thim);
				$thim_is = (int)($thim[0]*3600)+($thim[1]*60)+$thim[3];
				$time = $time_is - $thim_is;
				$hours = floor($time/3600);
				$minutes = floor(($time/3600 - $hours)*60);
				$seconds = ceil(($minutes - floor($minutes))*60);
				if($hours)
				{
					$time = 'Выезд в пункт "<b>'.$time_gorod.'</b>" через '.$hours.' ч. '.$minutes.' мин.';
				}
				else
				{
					$time = 'Выезд в пункт "<b>'.$time_gorod.'</b>" через '.$minutes.' мин.';
				}
				
				return $time;
			}
			
			if($time_today1=='00:00:00')
			{
				return 'Уже уехал в пункт "<b>'.$time_gorod.'</b>"';
			}
			else
			{
				
				if($time_today1>$thim)
				{
						$time = explode(':',$time_today1);
						$time_is = (int)($time[0]*3600)+($time[1]*60)+$time[3];
						$thim = explode(':',$thim);
						$thim_is = (int)($thim[0]*3600)+($thim[1]*60)+$thim[3];
						$time = $time_is - $thim_is;
						$hours = floor($time/3600);
						$minutes = floor(($time/3600 - $hours)*60);
						$seconds = ceil(($minutes - floor($minutes))*60);
						if($hours)
						{
							$time = $hours.' ч. '.$minutes.' мин.';
						}
						else
						{
							$time = $minutes.' мин.';
						}
						
						return 'Сегодня едет обратно из пункта "<b>'.$time_gorod1.'</b>" через '.$time ;
				}
				else
				{
						return 'Уже выехал обратно из пункта "<b>'.$time_gorod1.'</b>"';
				}
			}
		}
		else
		{
		
			if($time_today1!='00:00:00')
			{	
				if($time_today1>$thim)
				{
						$time = explode(':',$time_today1);
						$time_is = (int)($time[0]*3600)+($time[1]*60)+$time[3];
						$thim = explode(':',$thim);
						$thim_is = (int)($thim[0]*3600)+($thim[1]*60)+$thim[3];
						$time = $time_is - $thim_is;
						$hours = floor($time/3600);
						$minutes = floor(($time/3600 - $hours)*60);
						$seconds = ceil(($minutes - floor($minutes))*60);
						if($hours)
						{
							$time = $hours.' ч. '.$minutes.' мин.';
						}
						else
						{
							$time = $minutes.' мин.';
						}
						
						return 'Сегодня едет обратно из пункта "<b>'.$time_gorod1.'</b>" через '.$time ;
				}
				else
				{
						return 'Уже выехал обратно из пункта "<b>'.$time_gorod1.'</b>"';
				}
			}
			else
			{
				return 'Сегодня не едет';
			}
		}
	}
/* ==================================================================================================== */
/* ==================================================================================================== */
public function getMarshrut($id,$limit,$published,$today=0)
{
	$inUser = cmsUser::getInstance();
	$inDB   = cmsDatabase::getInstance();

	if($published)
	{
		$publish = "p.published=1 AND "; 
	}
	$thim = date('H:i:s');
	
	if($today!=0)
	{
		$t = ",times.t{$today} time_up";
		$t1 = "AND (times.t{$today} >= '{$thim}' OR times1.t{$today} >= '{$thim}')";
	}
	
	$td = date('w',strtotime(date('d.m.Y')));
	
	$sql = "SELECT u.id,p.id mar_id, u.nickname, up.imageurl {$t} , u.login ,p.otkuda,p.marshrut , p.kuda ,p.cena
						FROM `cms_users` u
						INNER JOIN cms_poputi p ON p.user_id = u.id
						INNER JOIN `cms_poputi_time` times ON times.id = p.id
						INNER JOIN `cms_poputi_time1` times1 ON times1.id = p.id
						INNER JOIN cms_user_profiles up ON up.user_id = u.id						
						WHERE {$publish} u.poputi = {$id} {$t1} ORDER BY times.t{$td}!='0' DESC,times.t{$td} ASC  LIMIT {$limit}";
	
				$result = $inDB->query($sql);
	
				while($r = $inDB->fetch_assoc($result))
				{
					$marshrut = '';
					$m = '';
					if(!$r['imageurl']){$r['imageurl'] = 'nopic.jpg';} 
					$r['time_up'] = $this->times_up($r['time_up'],$thim,$r['mar_id']);
						
						$marshrut = explode(',',$r['marshrut']);

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
						$r['marshrut'] = $m;
						
					$users[] = $r;
				}
				
	return $users;
}

/* ==================================================================================================== */
/* ==================================================================================================== */
public function getCount($id,$cfg,$perpage)
	{
	$inUser = cmsUser::getInstance();
	$inDB   = cmsDatabase::getInstance();
	
	$sql = "SELECT DISTINCT p.id FROM `cms_users`	u 
		INNER JOIN cms_poputi p ON p.user_id = u.id
		WHERE p.published ='1' AND u.poputi = '{$id}'";

	$result = $inDB->query($sql);
	
				while($r = $inDB->fetch_assoc($result))
				{
					$ids_count[] = $r;
				}
	$count = count($ids_count);
	
	$perpage = ($perpage-1) * $cfg['max_count_page'];
	
	$sql = "SELECT DISTINCT p.id FROM `cms_users`	u 
		INNER JOIN cms_poputi p ON p.user_id = u.id
		WHERE p.published ='1' AND u.poputi = '{$id}' ORDER BY u.id DESC  LIMIT {$perpage} , {$cfg['max_count_page']}";

		$result = $inDB->query($sql);
	
				while($r = $inDB->fetch_assoc($result))
				{
					$ids[] = $r;
				}
		$ids['count'] = $count;		
		return $ids;
	}
/* ==================================================================================================== */
/* ==================================================================================================== */
	
}
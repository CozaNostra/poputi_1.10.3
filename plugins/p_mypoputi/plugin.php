<?php
/******************************************************************************/
//                                                                            //
//                             InstantCMS v1.10                                //
//                        http://www.instantcms.ru/                           //
//                                                                            //
//                   written by InstantCMS Team, 2007-2011                    //
//                produced by InstantSoft, (www.instantsoft.ru)               //
//                                                                            //
//                        LICENSED BY GNU/GPL v2                              //
//                                                                            //
/******************************************************************************/

class p_mypoputi extends cmsPlugin {

// ==================================================================== //

    public function __construct(){
        
        parent::__construct();

        // Информация о плагине

        $this->info['plugin']           = 'p_mypoputi';
        $this->info['title']            = 'Мои маршруты';
        $this->info['description']      = 'Мои маршруты сервиса "Попутчики"';
        $this->info['author']           = 'CozaNostra';
        $this->info['version']          = '1.0';

		$this->info['tab']              = 'Маршруты';
        // События, которые будут отлавливаться плагином

        $this->events[]                 = 'USER_PROFILE';

    }

// ==================================================================== //

    /**
     * Процедура установки плагина
     * @return bool
     */
    public function install(){

        return parent::install();

    }

// ==================================================================== //

    /**
     * Процедура обновления плагина
     * @return bool
     */
    public function upgrade(){

        return parent::upgrade();

    }

// ==================================================================== //

    /**
     * Обработка событий
     * @param string $event
     * @param mixed $item
     * @return mixed
     */
    public function execute($event, $user){

        parent::execute();

		$inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();	
		$inUser = cmsUser::getInstance();
		
		$cfg = $inCore->loadComponentConfig( "poputi" );
		
		$id = $user['id'];
		$myid = $inUser->id;
		$sql = "SELECT  * FROM cms_poputi WHERE user_id='{$id}' AND published = 1 ORDER BY id DESC";
		$result = $inDB->query($sql);
		
		
		$html .="
		<style>
		#poputi_table_plugin tr td
		{
		padding:5px;
		}
		#poputi_table_plugin tr td a
		{
		font-size:16px;
		}
		</style>
		";
		if ($inDB->num_rows($result)){	
		$html .= '<table width="100%" id="poputi_table_plugin" >';
		$html .= '<tr style="background-color:#aaa;color:white" ><td>Маршрут</td><td>Где поедем</td><td>Цена</td>';
		if($id==$myid || $inUser->is_admin)
				{
					$html .='<td >Действия</td>';
				}
		$html .= '</tr>';
		
			$i=0;
			$posts = array();
			while($con = $inDB->fetch_assoc($result)){
			$i++;
			if($i%2)
			{
			$html .= '<tr style="padding:5px;">';
			}
			else
			{
			$html .= '<tr style="background-color:#eee;padding:5px;" >';
			}
			$p['user_id'] = $inDB->get_field('cms_users','`id`='.$con['user_id'],'nickname');								
				$p['userhref'] = '/poputi/v'.$con['user_id'].'.html';	
				
				$html .= '<td><a style="text-decoration:none"  target="_blank"  href="'.$p['userhref'].'">'.$con['otkuda'].'&rarr;'.$con['kuda'].'</a></td><td>'.$con['marshrut'].'</td><td>'.$con['cena'].' руб.</td>';
				
				
				if($id==$myid || $inUser->is_admin)
				{
					$html .='<td >';
					
					if(!$cfg['moder'] || $inUser->is_admin)
					{
					$html .=' <a href="/poputi/edit'.$con['id'].'.html" id="link_poputi" title="Редактировать" alt="Редактировать" ><img align="absmiddle" src="/images/icons/edit.gif" ></a>';
					}
					
					$html .='<a href="/poputi/del'.$con['id'].'.html" id="link_poputi" title="Удалить" alt="Удалить" ><img align="absmiddle" src="/images/icons/delete.gif" ></a>';
					
					
					
					$html .='</td>';
				}
				
				
			$html .= '</tr>';
			}
		$html .= '</table>';
	}
	else
	{
		$html = '<h3>Нет маршрутов</h3>';
	}
        return $html;
    }

// ==================================================================== //

}

?>

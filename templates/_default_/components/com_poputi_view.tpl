{* ================================================================================ *}
{* ========================= Попутчики главная    ================================= *}
{* ================================================================================ *}

{add_js file='includes/jquery/tabs/jquery.ui.min.js'}
{add_js file="components/poputi/js/mask.js"}
{add_js file="components/users/js/profile.js"}
{add_css file='components/poputi/js/style.css'}					

{assign var='ind' value='0'}
									
{if $cfg.max_poputi>$count && $users.user.id==$my_id}<p align="right" ><a href="/poputi/add.html" id="marshrut_poputi" >Добавить маршрут</a></p>{/if}


							<table >
							<tr>
							<td style="padding:10px;" >
									<img  src="/images/users/avatars/{$users.user.ava}" >
							</td>
							
							<td valign=top >
									<div class="con_heading" id="nickname">{$users.user.nickname}</div>
										<div class="title">E-mail:  {$users.user.email}</div>
										{if $my_id!=$users.user.id && $my_id}
										<a class="ajaxlink" href="javascript:void(0)" title="Написать сообщение" onclick="users.sendMess('{$users.user.id}', 0, this);return false;">Написать сообщение</a><br>
										{/if}
										{if $users.user.poputi == 2}На сайте как : <span id="poputi_im" >Водитель</span> 
							
																		{if $users.poputi[$ind].user_id==$my_id && $cfg.status || $is_admin }
																		|
																		<a href="/poputi/status{$users.user.id}-1.html" title="Изменить на пассажира">Изменить на пассажира</a>
																		{/if}
										{/if}
										{if $users.user.poputi == 1}На сайте как : <span id="poputi_im" >Пассажир</span> 
																		{if $users.poputi[$ind].user_id==$my_id && $cfg.status || $is_admin }
																		|
																		<a href="/poputi/status{$users.user.id}-2.html" title="Изменить на водителя">Изменить на водителя</a>
																		{/if}
										{/if}
										{if $users.user.poputi==0}Не ищет попутчиков
																		{if $users.poputi[$ind].user_id==$my_id && $cfg.status || $is_admin }
																		<br>
																		<a href="/poputi/status{$users.user.id}-1.html" title="Изменить на пассажира">Изменить на пассажира</a>|
																		<a href="/poputi/status{$users.user.id}-2.html" title="Изменить на водителя">Изменить на водителя</a>
																		{/if}
										{/if}
							</td>
							</tr>
							</table>
							
							
							{if $users.poputi}
					
							{section name="foreach" start=0 loop=$count}
							<div id="marshrut_poputi" style="position:relative;">
							{if $users.poputi[$ind].published==1 || $users.poputi[$ind].user_id==$my_id || $is_admin}
											
											
											
											<h2>{$users.poputi[$ind].otkuda} <img title="Туда" alt="Туда" src="/components/poputi/images/forward.png"> {$users.poputi[$ind].kuda} {if $users.poputi[$ind].user_id==$my_id && $users.poputi[$ind].published==0 || $is_admin && $users.poputi[$ind].published==0}<span style="color:red;font-size:12px;" >Неопубликован</span>{/if}</h2>
											
											
											
											<!-------------------Кнопки управления------------------------->
											<div align="right" style="position:absolute;top:5px;right:5px;" >	
												{if $users.poputi[$ind].user_id==$my_id || $is_admin }<a href="del{$users.poputi[$ind].id}.html" id="link_poputi" title="Удалить" alt="Удалить" ><img align="absmiddle" src="/images/icons/delete.gif" ></a>{/if}
												
												{if !$cfg.moder  || $is_admin}
												
														{if $users.poputi[$ind].user_id==$my_id && $users.poputi[$ind].published==0 || $is_admin && $users.poputi[$ind].published==0}
														<a href="published{$users.poputi[$ind].id}.html" style="color:green" id="link_poputi" title="Опубликовать" alt="Опубликовать" ><img align="absmiddle" src="/images/icons/message_error.png" ></a>												
														{/if}
														
														{if $users.poputi[$ind].user_id==$my_id && $users.poputi[$ind].published==1 || $is_admin && $users.poputi[$ind].published==1}
														<a href="depub{$users.poputi[$ind].id}.html" style="color:red" id="link_poputi" title="Снять с публикации" alt="Снять с публикации" ><img align="absmiddle" src="/images/icons/message_success.png" ></a>											
														{/if}
														
												{/if}
												
												{if $users.poputi[$ind].user_id==$my_id && $cfg.edit || $is_admin }<a href="edit{$users.poputi[$ind].id}.html" id="link_poputi" title="Редактировать" alt="Редактировать" ><img align="absmiddle" src="/images/icons/edit.gif" ></a>{/if}
											</div>
											
											
											
											
												<table class="table_poputi" >
														<tr>
														<!--------------Дни недели (Пн,Вт,Ср...)----->
																	<td></td>
																	{foreach key=tid item=dn from=$users.poputi[$ind].dni}
																		{if $dn!=0}
																		<td width="80" >{$ned.$tid}</td>
																		{else}
																		<td style="color: #D6D6D6;" >{$ned.$tid}</td>
																		{/if}
																	{/foreach}
														<!-------------------------------------------->			
														</tr>
														<tr>
														<!-----------------Дни недели туда------------>
																	<td class="bg" ><img title="Туда" alt="Туда" src="/components/poputi/images/forward.png"> </td>
																	{foreach key=tid item=dn from=$users.poputi[$ind].dni_tuda}
																		{if $dn!='00:00'}
																		<td class="bg" >{$dn}</td>
																		{else}
																		<td class="emptyBg"  ></td>
																		{/if}
																	{/foreach}
														<!-------------------------------------------->			
														</tr>
														{if $users.poputi[$ind].napravlenie==2}
														<tr>
														<!-----------------Дни недели оттуда---------->
																	<td class="bg" ><img title="Оттуда" alt="Оттуда" src="/components/poputi/images/backward.png"></td>
																	{foreach key=tid item=dn from=$users.poputi[$ind].dni_ottuda}
																		{if $dn!='00:00'}
																		<td class="bg" >{$dn}</td>
																		{else}
																		<td class="emptyBg" ></td>
																		{/if}
																	{/foreach}
														<!-------------------------------------------->			
														</tr>
														{/if}
														</table>
														
														<!-------------------------------------------->
														{if $users.poputi[$ind].marshrut}
																<span><b>Ключевые слова для маршрута:</b> {$users.poputi[$ind].marshrut}</span>
														{/if}
														<!-------------------------------------------->
																<span><b>Контактный телефон:</b> {$users.poputi[$ind].mobile}</span>
														<!-------------------------------------------->
														{if $users.poputi[$ind].comments}
																<span><b>Комментарий:</b> {$users.poputi[$ind].comments}</span>
														{/if}
														<!-------------------------------------------->
														{if $users.poputi[$ind].cena}
																<span><b>Цена:</b> {$users.poputi[$ind].cena} руб.</span>
														{/if}
							</div>
							
							<!--Маршрут №{$ind++} (Не удалять)-->
							{else}
														<h3>Маршрут не опубликован</h3>
														</div>
							{/if}
							{/section}
							{/if}
{* ================================================================================ *}
{* ========================= Попутчики главная    ================================= *}
{* ================================================================================ *}

{add_js file='includes/jquery/tabs/jquery.ui.min.js'}
{add_js file="components/poputi/js/mask.js"}
{add_css file='components/poputi/js/style.css'}	

<!--------------------Поисковая форма------------------------>				
<div id="marshrut_poputi" style="width:99%" >
<form id="search_form" action="/poputi/search" method="POST" enctype="multipart/form-data" style="clear:both">
    
	Мне нужен:
							<select name="user_poputi" >
							<option value=2 id="s1" >Водитель</option>
							<option value=1 id="s2" >Пассажир</option>
							<option value=3 >Маршрут</option>
							</select>
							
	
    <input type="hidden" name="view" value="search" />
    
	<div id="query" onclick="$('#result_search').hide()" >
	<input type="text" name="query" id="squery" style="width:98%" onkeyup="search_poputi($(this).val())" value="Куда едем?" onclick="$(this).val('')" class="text-input" />
	<div id="result_search" >---</div>
	</div>
    <input type="submit" value="Найти"/> 
</form>
</div>

{if $my_id}
				<p align="right"  ><a href="poputi/v{$my_id}.html" id="marshrut_poputi" >Мои маршруты</a></p>
{/if}						

<table width="100%" >
<tr>
				<td width="50%" >
									<h3 style="display:inline;">Водители</h3>
									(на сегодня) <a href="/poputi/drivers" class="grey_poputi" >Смотреть всех</a>
				</td>
				
				<td width="50%" >
									<h3 style="display:inline;" >Пассажиры</h3>
									(на сегодня)<a href="/poputi/passenger" class="grey_poputi" >Смотреть всех</a>
				</td>
</tr>
<tr>

<!--------------------Список водителей на главной------------------------>
<td valign="top">
{assign var='ind' value='0'}
							{section name="foreach" start=0 loop=$count}
							{if $drivers[$ind].id}
							<div id="marshrut_poputi" style="width:90%" >
									<table width="100%" valign="top" >
									<tr>
											<td width="55" >
													<img src="/images/users/avatars/{$drivers[$ind].imageurl}" width="50"  >
											</td>
											
											<td>
													<a href="/poputi/v{$drivers[$ind].id}.html" >{$drivers[$ind].nickname}</a>   <span class="grey_poputi" style="display:inline" >{$drivers[$ind].time_up}</span>
													<h5>{$drivers[$ind].otkuda} <img src="/components/poputi/images/forward.png"> {$drivers[$ind].kuda}</h5>
													<b>Маршрут:</b> {$drivers[$ind].marshrut}<br>
													<b>Цена:</b> {$drivers[$ind].cena} руб.
											</td>
											
									</tr>
									</table>
							</div>
							<!--Мини маршрут №{$ind++}-->
							{/if}
							{/section}
</td>


<!--------------------Список пассажиров на главной------------------------>
<td valign="top" >
{assign var='ind' value='0'}
							{section name="foreach" start=0 loop=$count}
							{if $pas[$ind].id}
							<div id="marshrut_poputi" style="width:90%" >
									<table width="100%" valign="top" >
									<tr>
											<td width="55" >
													<img src="/images/users/avatars/{$pas[$ind].imageurl}" width="50" >
											</td>
											
											<td>
													<a href="/poputi/v{$pas[$ind].id}.html" >{$pas[$ind].nickname}</a>   <span class="grey_poputi" style="display:inline" >{$pas[$ind].time_up}</span>
													<h5>{$pas[$ind].otkuda} <img src="/components/poputi/images/forward.png"> {$pas[$ind].kuda}</h5>
													<b>Маршрут:</b> {$pas[$ind].marshrut}<br>
													<b>Цена:</b> {$pas[$ind].cena} руб.
											</td>
									</tr>
									</table>
							</div>
							<!--Мини маршрут №{$ind++}-->
							{/if}
							{/section}
</td>
</tr>
</table>
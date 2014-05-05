{* ================================================================================ *}
{* ========================= Попутчики главная    ================================= *}
{* ================================================================================ *}

{add_js file='includes/jquery/tabs/jquery.ui.min.js'}
{add_js file="components/poputi/js/mask.js"}
{add_css file='components/poputi/js/style.css'}	
{literal}
<script>
function reloadPoputi(){
document.noPoputi.submit();
}
</script>
{/literal}				
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
	<input type="text" name="query" id="squery" style="width:98%" onkeyup="search_poputi($(this).val())" value="Кого ищем? Куда едем?" onclick="$(this).val('')" class="text-input" />
	<div id="result_search" >---</div>
	</div>
    <input type="submit" value="Найти"/> 
</form>
</div>

{if $my_id}
<p align="right"  ><a href="/poputi/v{$my_id}.html" id="marshrut_poputi" >Мои маршруты</a></p>
{/if}						

<table width="100%" >
<tr>
<td width="50%" >
<h3 style="display:inline;">{$all}</h3>
<form class="grey_poputi" name="noPoputi" action="" method="POST" enctype="multipart/form-data" style="clear:both">
<input type="checkbox" {if $off_poputi==1}checked{/if} onclick='reloadPoputi();return false;' name='off_poputi'  value="1" >Показать тех кто 'Уже уехал'
</form>
</td>
</tr>
<tr>

<td valign="top">
{assign var='ind' value=$page*$count }
							{section name="foreach" start=0 loop=$count}
							{if $drivers[$ind].id}
								{if $drivers[$ind].time_up|regex_replace:'#Уже уехал(.*)#s' || $off_poputi==1}
								<div id="marshrut_poputi" style="width:99%" >
								<table width="100%" valign="top" >
								<tr>
								<td width="55" >
								<img src="/images/users/avatars/{$drivers[$ind].imageurl}" width="50" height="50" >
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
								{else}
								<div id="marshrut_poputi" style="width:99%" >
								<table width="100%" valign="top" >
								<tr>
								<td width="55" >
								</td>
								<td>
								<a href="/poputi/v{$drivers[$ind].id}.html" >{$drivers[$ind].nickname}</a>   <span class="grey_poputi" style="display:inline" >{$drivers[$ind].time_up}</span>
								</td>
								</tr>
								</table>
								</div>
								<!--Мини маршрут №{$ind++}-->
								{/if}
							{/if}
							{/section}
</td>
</tr>
</table>
{$pagebar}
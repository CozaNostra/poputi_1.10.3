<div class="photo_details">
{add_css file='components/poputi/js/style.css'}	
{add_js file="components/poputi/js/mask.js"}
<div id="marshrut_poputi" style="width:99%" >
<form id="search_form" action="/poputi/search" method="POST" enctype="multipart/form-data" style="clear:both">
    
	Мне нужен:
							<select name="user_poputi" >
							<option value=2 id="s1" {if $bar=='Водителя'}selected{/if}>Водитель</option>
							<option value=1 id="s2" {if $bar=='Пассажира'}selected{/if}>Пассажир</option>
							<option value=3 {if $bar=='Маршрут'}selected{/if}>Маршрут</option>
							</select>
							
	
    <input type="hidden" name="view" value="search" />
    
	<div id="query" onclick="$('#result_search').hide()" >
	<input type="text" name="query" id="squery" style="width:98%" onkeyup="search_poputi($(this).val())" value="{$query}" onclick="$(this).val('')" class="text-input" />
	<div id="result_search" ></div>
	</div>
    <input type="submit" value="Найти"/> 
</form>
</div>
<br>
{if $results}
	{assign var="num" value="1"}
    {foreach key=tid item=item from=$results}
	<div class="search_block">
            {if $item.pubdate}
            	<div class="search_date">{$item.pubdate}</div>
            {/if}
            <div class="search_result_title">
                <span>{$num}</span>
                <a href="{$item.link}" target="_blank">{$item.s_title}</a>
            </div>
            <div class="search_result_desc">
            	{if $item.description}
            		<p>{$item.description}</p>
                {/if}
            <a href="{$item.placelink}">{$item.place}</a>
                &mdash; <span style="color:green">{$host}{$item.link}</span>
            </div>
     </div>
     {math equation="z + 1" z=$num assign="num"}
    {/foreach}
    {$pagebar}
{else}
	{if $query}
		<p class="usr_photos_notice">{$LANG.BY_QUERY} <strong>"{$query}"</strong> {$LANG.NOTHING_FOUND}. <a href="{$external_link}" target="_blank">{$LANG.FIND_EXTERNAL}</a></p>
    {/if}
{/if}
{literal}
<script type="text/javascript">
		$(document).ready(function(){
			$('#query').focus();
            $('.search_block').hover(
                function() {
					$(this).css('background','#E8FFDB');
                },
                function() {
					$(this).css('background','#FFF');
                }
            );
        });
		function toggleInput(id){
			$('#from_search label#'+id).toggleClass('selected');
		}
		function paginator(page){
			$('form#sform').append('<input type="hidden" name="page" value="'+page+'" />');
			$('form#sform').submit();
		}
</script>
{/literal}
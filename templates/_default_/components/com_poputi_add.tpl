{* ================================================================================ *}
{* ========================= Попутчики Добавить    ================================= *}
{* ================================================================================ *}

{*add_js file="components/poputi/js/mask.js"*}
{add_js file="components/poputi/js/jquery.datetimepicker.js"}		
{add_css file='components/poputi/js/jquery.datetimepicker.css'}	
	
{add_css file='components/poputi/js/style.css'}	

{literal}
	<script type="text/javascript">
	jQuery(function($) {
$('#datetimepicker1').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker2').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker3').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker4').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker5').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker6').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker7').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker11').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker21').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker31').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker41').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker51').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker61').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#datetimepicker71').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});

   });
   
 
		/*$(document).ready(function(){
			for(i=1;i<=7;i++)
				
					if($('#dni'+i).attr('selected'))
					{
						$('#time_tuda'+i).attr('disabled',false);
						$('#time_ottuda'+i).attr('disabled',false);
					}
					else
					{
						$('#time_tuda'+i).attr('disabled',true);
						$('#time_ottuda'+i).attr('disabled',true);
					}
				
		});
	
		$(document).click(function(data){
			
			for(i=1;i<=7;i++)
				{
					if($('#dni'+i).attr('selected'))
					{
						$('#time_tuda'+i).attr('disabled',false);
						$('#time_ottuda'+i).attr('disabled',false);
					}
					else
					{
						$('#time_tuda'+i).attr('disabled',true);
						$('#time_ottuda'+i).attr('disabled',true);
					}
				}
			
		
		});*/
		
		$(document).ready(function () {
            $('#napravlenie').change(function () {
                if (this.value == "1") {
                   $('#nap_tuda').show();
					$('.nap_ottuda').hide();
                } else {
                   $('#nap_tuda').show();
					$('.nap_ottuda').show();
                }

            });
        });
		
		$(document).ready(function () {
		  $('#dni').on('change',function(){
			$('#nap_tuda input').attr('disabled',true);
			$('.nap_ottuda input').attr('disabled',true);
				$(this).find('option:selected').each(function(i) {
					$('#nap_tuda input').eq($(this).index()).attr('disabled',false);
					$('.nap_ottuda input').eq($(this).index()).attr('disabled',false);
																	});
			});
		});
		
		/*$(document).ready(function () {
		  $('#dni').on('change',function(){
			$('.nap_ottuda input').attr('disabled',true);
				$(this).find('option:selected').each(function(i) {
					$('nap_ottuda input').eq($(this).index()).attr('disabled',false);
																	});
			});
		});*/
	</script>
{/literal}

<form method=post >
	<div class="block_poputi" style="display:block" >
	<table  width="100%" class="table_top_poputi" >
	<tr>
		<td width="20%" >
					Откуда<span style="color:red" >*</span>
		</td>
		<td width="20%" >
					Куда<span style="color:red" >*</span>
		</td>		
		<td width="20%" >
					Направление<span style="color:red" >*</span>
		</td>
		<td width="20%" >
					Контактный телефон<span style="color:red" >*</span>
		</td>
		<td width="20%" >
					Цена проезда
		</td>
	</tr>
	<tr>
		<td width="20%" >
					<input type="text" id="otkuda" size="15" name="otkuda" value="{$post.otkuda}" >
					<span class="grey_poputi" >Например Саранск</span>
		</td>
		<td width="20%" >
					<input type="text" size="15" name="kuda"  value="{$post.kuda}" >
					<span class="grey_poputi" >Например Москва</span>
		</td>		
		<td width="20%" >
					<select name="napravlenie" id="napravlenie">
						<option id="napravlenie1" value="1" select="selected">в одну сторону</option>
						<option id="napravlenie2" value="2">туда и обратно</option>
					</select>
		</td>
		<td width="20%" >
					<input type="text" size="13" name="mobile"  value="{$post.mobile}" >
		</td>
		<td width="20%" >
					<input type="text" size="5" name="cena"  value="{$post.cena}" > руб.
					<a href="#" class="grey_poputi" title="Укажите желаемую стоимость проезда. Она должна не сильно отличаться от стоимости проезда в городском транспорте." alt="Укажите желаемую стоимость проезда. Она должна не сильно отличаться от стоимости проезда в городском транспорте.">?</a>
		</td>
	</tr>
	</table>
	</div>
	
	<table width="100%" >
	<tr>
	<td width="50%" >
		<div class="block_poputi" >
		<table width="100%"  style="min-width:400px;min-height:200px;" >
		<tr>
		<td>День недели<span style="color:red" >*</span></td>
		<td>Отправление туда<span style="color:red" >*</span></td>
		<td class="nap_ottuda" style="display:none;" >Отправление назад<span style="color:red" >*</span></td>
		</tr>
		<tr>
				<td width="37%" >
				<select name="dni[]" id="dni" size=7 multiple >
					<option id="dni1" value="1" >Понедельник</option>
					<option id="dni2" value="2" >Вторник</option>
					<option id="dni3" value="3" >Среда</option>
					<option id="dni4" value="4" >Четверг</option>
					<option id="dni5" value="5" >Пятница</option>
					<option id="dni6" value="6" >Суббота</option>
					<option id="dni7" value="7" >Воскресенье</option>
				</select>
				</td>
				<td id="nap_tuda" width="33%" >
					{php}
						for($i=1;$i<=7;$i++)
						{
							echo '<input type="text" size="5" class="time"  name="time_tuda['.$i.']" id="datetimepicker'.$i.'" value="00:00" disabled="disabled"><br>';
						}
					{/php}
				</td>
				<td class="nap_ottuda" width="33%" style="display:none" >
					{php}
						for($i=1;$i<=7;$i++)
						{
							echo '<input type="text" size="5" class="time" name="time_ottuda['.$i.']" id="datetimepicker'.$i.'1" value="00:00" ><br>';
						}
					{/php}
				</td> 
		</tr>
		<tr><td colspan="5" ><small>Для множественного выбора используйте Ctrl</small></td></tr>
		</table>
		</div>
	</td>
	<td width="50%" >
	<div class="block_poputi" >
		<table width="100%" style="min-height:200px;" >
		<tr>
		<td width="100%" align=center >
					Маршрут по улицам (ключевые слова через запятую):
					<textarea cols="50" rows="2" name="marshrut" >{$post.marshrut}</textarea>
					<span class="grey_poputi" >Введите через запятую улицы или известные остановки, мимо которых часто проезжаете. Например: Парк Горького, Толстого, Площадь свободы, Ленинский сад, Университет, центр, пл. Тукая</span>
					<br>
					
					Комментарии к маршруту:
					<textarea cols="50" rows="5" name="comments" >{$post.comments}</textarea>
		</td>
		</tr>
		</table>
	</div>
	</td>
	</tr>
	</table>
	<input type="submit" name="poputi_submit"   value="Добавить" >
</form>
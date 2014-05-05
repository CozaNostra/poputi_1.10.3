<table width="100%" cellspacing="0" align="left" cellpadding="5" border="0" >
{foreach key=ind item=post from=$posts}
	<tr>
		<td class="mod_blog_karma" style="text-align:left"  valign="top">
		{if $cfg.avtor=='p'}
		<a class="mod_blog_userlink" target="_blank"  href="{$post.userhref}">{$post.otkuda}&rarr;{$post.kuda}</a>
		{else}
		{$post.otkuda}&rarr;{$post.kuda}
		{/if}
		</td>
		
		
		{if $cfg.avtor=='y'}
		<td valign="top">
			<div>
				<a class="mod_blog_userlink" target="_blank"  href="{$post.userhref}">{$post.user_id}</a>
				<img  src="{$post.ava}" >
			</div>
		</td>
		{/if}
		
		{if $cfg.avtor=='s' && $cfg.avtor!='y'}
		<td valign="top">
			<div>
				<a class="mod_blog_userlink" target="_blank"  href="{$post.userhref}" STYLE='TEXT-DECORATION:NONE' >&rarr;</a>
			</div>
		</td>
		{/if}
		
	</tr>
{/foreach}
</table>
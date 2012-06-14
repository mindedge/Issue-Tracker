<!-- Begin groups/edit.tpl -->
<form method="post" action="?module=groups&action=edit&type={$smarty.get.type}&gid={$smarty.get.gid}&submit=true">
{opentable}
{titlebar colspan=2 title=$title}
<tr class="tablehead" align="center">
<td width="50%">Add {$plural|capitalize}</td>
<td width="50%">Remove {$plural|capitalize}</td>
</tr>
<tr class="data">
<td width="50%">
<select name="add[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$data item=item}
{if !array_key_exists($item.id,$list)}
<option value="{$item.id}">{$item.field}</option>
{/if}
{/foreach}
</select>
</td>
<td width="50%">
<select name="del[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$list key=key item=val}
<option value="{$key}">{$val}</option>
{/foreach}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Update {$plural|capitalize}" /></td></tr>
{closetable}
</form>
<!-- End gorups/edit.tpl -->


<!-- Begin groups/sub_groups/add.tpl -->
<form method="post" action="?module=groups&action=edit_sub_groups&gid={$smarty.get.gid}">
{opentable}
{titlebar colspan=2 title="Add Sub Group(s)"}
<tr>
<td class="label" valign="top" align="right" width="20%">Groups:</td>
<td class="data" width="80%">
<select name="add_groups[]" size="10" multiple="multiple" style="width: 100%;">
{if is_array($possible)}
{foreach from=$possible key=gid item=name}
<option value="{$gid}">{$name}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Add Sub Groups" /></td></tr>
{closetable}
</form>
<!-- End groups/sub_groups/add.tpl -->


<!-- Begin admin/statuses/edit.tpl -->
<form method="post" action="?module=admin&action=statuses&subaction=edit&id={$smarty.get.id}">
<input type="hidden" name="commit" value="true">
{opentable}
{titlebar colspan=2 title="Update Status"}
<tr>
<td width="20%" class="label" align="right" valign="top">Status:</td>
<td width="80%" class="data"><input type="text" size="32" name="status" value="{$status.status|stripslashes}"></td>
</tr>
<tr>
<td width="20%" class="label" align="right" valign="top">Status Type:</td>
<td width="80%" class="data">
<select name="status_type">
{foreach from=$status_types key=id item=type}
<option value="{$id}"{if $id eq $status.status_type} selected="selected"{/if}>{$type}</option>
{/foreach}
</select>
</td>
</tr>
<tr><td class="titlebar" colspan="2"><input type="submit" value="Update Status"></td></tr>
{closetable}
</form>
<!-- End admin/statuses/edit.tpl -->


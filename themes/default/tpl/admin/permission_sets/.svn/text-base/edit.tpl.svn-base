<!-- Begin admin/permission_sets/edit.tpl -->
<form method="post" action="?module=admin&action=permission_sets&subaction=edit&setid={$smarty.get.setid}">
<input type="hidden" name="update" value="true">
{opentable}
{titlebar colspan=2 title="Update Permission Set"}
<tr>
<td class="label" width="20%" align="right" valign="top">Name:</td>
<td class="data" width="80%"><input type="text" size="32" name="name" value="{$pset.name|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Description:</td>
<td class="data" width="80%"><textarea name="description" rows="10" cols="60">{$pset.description}</textarea></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Permissions:</td>
<td class="data" width="80%">
<select name="permissions[]" size="10" multiple="multiple">
{foreach from=$perms item=perm}
<option value="{$perm}"{if in_array($perm,$pset.permissions)} selected="selected"{/if}>{$perm}</option>
{/foreach}
</select>
</td>
</tr>
<tr><td class="titlebar" colspan="2"><input type="submit" value="Update Set" /></td></tr>
{closetable}
</form>
<!-- End admin/permission_sets/edit.tpl -->


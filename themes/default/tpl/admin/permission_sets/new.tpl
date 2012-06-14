<!-- Begin admin/permission_sets/new.tpl -->
<form method="post" action="?module=admin&action=permission_sets&subaction=new">
{opentable}
{titlebar colspan=2 title="New Permission Set"}
<tr>
<td class="label" width="20%" align="right" valign="top">Name:</td>
<td class="data" width="80%"><input type="text" size="32" name="name" value="{$smarty.post.name|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Description:</td>
<td class="data" width="80%"><textarea name="description" rows="10" cols="60">{$smarty.post.description}</textarea></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Permissions:</td>
<td class="data" width="80%">
<select name="permissions[]" size="10" multiple="multiple">
{if is_array($perms)}
{foreach from=$perms item=perm}
{if is_array($smarty.post.permissions)}
<option value="{$perm}"{if in_array($perm,$smarty.post.permissions)} selected="selected"{/if}>{$perm}</option>
{else}
<option value="{$perm}">{$perm}</option>
{/if}
{/foreach}
{/if}
</select>
</td>
</tr>
<tr><td class="titlebar" colspan="2"><input type="submit" value="Create Set" /></td></tr>
{closetable}
</form>
<!-- End admin/permission_sets/new.tpl -->


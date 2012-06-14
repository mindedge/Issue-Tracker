<!-- Begin groups/edit_permissions.tpl -->
<form method="post" action="?module=groups&action=edit_permissions&gid={$smarty.get.gid}&submit=true">
{opentable}
{titlebar colspan=6 title="Permissions"}
<tr class="tablehead" align="center">
<td width="15%" align="left">Username</td>
<td width="15%">Permissions</td>
<td width="15%" align="left">Username</td>
<td width="15%">Permissions</td>
<td width="15%" align="left">Username</td>
<td width="15%">Permissions</td>
</tr>
{php}$col = 0;{/php}
{foreach from=$members key=userid item=username}
{php}if ($col == 0) { print "<tr>\n"; }{/php}
<td class="label" width="15%">{$username}</td>
<td class="data" width="15%">
<select name="perm_set_{$userid}">
<option value="">Read Access</option>
{foreach from=$psets key=setid item=setname}
<option value="{$setid}"{if $setid eq permission_set_id($smarty.get.gid,$userid)} selected="selected"{/if}>{$setname}</option>
{/foreach}
</select>
</td>
{php}$col++; if ($col == 3) { print "</tr>\n"; $col = 0; }{/php}
{/foreach}
{php}if ($col != 0) { $col = (3 - $col) * 2; print "<td class=\"label\" colspan=\"$col\">&nbsp;</td>\n</tr>\n"; }{/php}
<tr>
<td class="label"colspan="4" align="right" valign="top">Group Permissions:</td>
<td class="data" colspan="2">
<select name="group_perms[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$perms item=perm}
<option value="{$perm.permid}"{if in_array($perm.permid,$gperms)} selected="selected"{/if}>{$perm.permission}</option>
{/foreach}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="6"><input type="submit" value="Update Permissions" /></td></tr>
{closetable}
</form>
<!-- End groups/edit_permissions.tpl -->


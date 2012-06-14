<!-- Begin admin/permissions.tpl -->
{opentable}
{titlebar colspan=6 title="Permissions"}
<tr class="tablehead" align="center">
<td width="5%">ID</td>
<td align="left">Permission</td>
<td width="5%">User</td>
<td width="5%">Group</td>
<td width="5%">Edit</td>
<td width="5%">Delete</td>
</tr>
{if is_array($permissions)}
{foreach from=$permissions item=permission}
{php}$class = rowcolor();{/php}
<tr class="{php}print $class;{/php}" align="center">
<td width="5%">{$permission.permid}</td>
<td align="left">{$permission.permission}</td>
{if $permission.user_perm eq "t"}
<td width="5%"><img src="{$smarty.env.imgs.ok}" width="16" height="16" border="0" /></td>
{else}
<td width="5%"><img src="{$smarty.env.imgs.no}" width="16" height="16" border="0" /></td>
{/if}
{if $permission.group_perm eq "t"}
<td width="5%"><img src="{$smarty.env.imgs.ok}" width="16" height="16" border="0" /></td>
{else}
<td width="5%"><img src="{$smarty.env.imgs.no}" width="16" height="16" border="0" /></td>
{/if}
{if $permission.system eq "t"}
<td width="5%"></td>
<td width="5%"></td>
{else}
<td width="5%"><a href="?module=admin&action=permissions&subaction=edit&id={$permission.permid}"><img src="{$smarty.env.imgs.edit}" width="16" height="16" border="0" alt="Edit" /></a></td>
<td width="5%"><a href="?module=admin&action=permissions&subaction=delete&id={$permission.permid}"><img src="{$smarty.env.imgs.delete}" width="16" height="16" border="0" alt="Delete" /></a></td>
{/if}
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="4">No defined permissions.</td></tr>
{/if}
{closetable}
<!-- End admin/permissions.tpl -->


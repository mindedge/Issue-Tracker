<!-- Begin users/view.tpl -->
<form method="post" action="?module=users&action=update&uid={$smarty.get.uid}">
{opentable}
{titlebar colspan=2 title="Edit User"}
<tr>
<td class="label" width="20%" align="right" valign="top">Username:</td>
<td class="data" width="80%"><input type="text" size="16" maxlength="32" name="uname" value="{$user.username}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">First Name:</td>
<td class="data" width="80%"><input type="text" size="16" maxlength="32" name="first" value="{$user.first_name}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Last Name:</td>
<td class="data" width="80%"><input type="text" size="16" maxlength="32" name="last" value="{$user.last_name}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Email:</td>
<td class="data" width="80%"><input type="text" size="16" maxlength="64" name="email" value="{$user.email}" /></td>
</tr>
<tr>
{if is_admin($smarty.session.userid)}
<td class="label" width="20%" align="right" valign="top">Permissions:</td>
<td class="data" width="80%">
<select name="permissions[]" size="5" multiple="multiple">
{foreach from=$permissions item=perm}
<option value="{$perm.permid}"{if @in_array($perm.permid,$user_perms)} selected="selected"{/if}>{$perm.permission|replace:"_":" "|capitalize}</option>
{/foreach}
</select>
</td>
</tr>
{/if}
<tr class="data">
<td colspan="2">
{opentable}
<tr class="tablehead">
<td>Add to Groups</td>
<td>Remove from Groups</td>
</tr>
<tr class="data">
<td width="50%">
<select name="add_groups[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$groups item=group}
{if permission_check("update_group",$group.gid)}
<option value="{$group.gid}">{$group.name}</option>
{/if}
{/foreach}
</select>
</td>
<td width="50%">
<select name="del_groups[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$user_groups item=gid}
{if permission_check("update_group",$gid)}
<option value="{$gid}">{groupname id=$gid}</option>
{/if}
{/foreach}
</select>
</td>
</tr>
{closetable}
</td>
</tr>
{if is_admin($smarty.session.userid)}
<tr>
<td class="label" width="20%" align="right" valign="top">Admin:</td>
<td class="data" width="80%"><input type="checkbox" name="admin"{if $user.admin eq "t"} checked="checked"{/if} /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">{$smarty.const._COMPANY_} Employee:</td>
<td class="data" width="80%"><input type="checkbox" name="employee"{if is_employee($smarty.get.uid)} checked="checked"{/if} /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Active:</td>
<td class="data" width="80%"><input type="checkbox" name="active"{if $user.active eq "t"} checked="checked"{/if} /></td>
</tr>
{/if}
<tr class="titlebar">
<td colspan="2"><input type="submit" value="Update Users" /></td>
</tr>
{closetable}
</form>
<!-- End users/view.tpl -->


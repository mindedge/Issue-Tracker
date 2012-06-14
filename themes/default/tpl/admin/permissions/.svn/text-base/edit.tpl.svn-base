<!-- Begin admin/permissions/edit.tpl -->
<form method="post" action="?module=admin&action=permissions&subaction=edit&id={$smarty.get.id}">
<input type="hidden" name="commit" value="true">
{opentable}
{titlebar colspan=2 title="Update Permission"}
<tr>
<td width="20%" class="label" align="right" valign="top">Permission:</td>
<td width="80%" class="data"><input type="text" size="32" name="permission" value="{$permission.permission|stripslashes}"></td>
</tr>
<tr>
<td width="20%" class="label" align="right" valign="top">Group Permission:</td>
<td width="80%" class="data"><input type="checkbox" name="group"{if $permission.group_perm eq "t"} checked="checked"{/if} /></td>
</tr>
<tr>
<td width="20%" class="label" align="right" valign="top">User Permission:</td>
<td width="80%" class="data"><input type="checkbox" name="user"{if $permission.user_perm eq "t"} checked="checked"{/if} /></td>
</tr>
<tr><td class="titlebar" colspan="2"><input type="submit" value="Update Permission"></td></tr>
{closetable}
</form>
<!-- End admin/permissions/edit.tpl -->


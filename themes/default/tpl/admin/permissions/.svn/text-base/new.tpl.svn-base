<!-- Begin admin/permissions/new.tpl -->
<form method="post" action="?module=admin&action=permissions&subaction=new">
<input type="hidden" name="commit" value="true">
{opentable}
{titlebar colspan=2 title="New Permission"}
<tr>
<td width="20%" class="label" align="right" valign="top">New Permission:</td>
<td width="80%" class="data"><input type="text" size="32" name="permission" value="{$smarty.post.permission|stripslashes}"></td>
</tr>
<tr>
<td width="20%" class="label" align="right" valign="top">Group Permission:</td>
<td width="80%" class="data"><input type="checkbox" name="group"{if $smarty.post.group eq "on"} checked="checked"{/if} /></td>
</tr>
<tr>
<td width="20%" class="label" align="right" valign="top">User Permission:</td>
<td width="80%" class="data"><input type="checkbox" name="user"{if $smarty.post.user eq "on"} checked="checked"{/if} /></td>
</tr>
<tr><td class="titlebar" colspan="2"><input type="submit" value="Create Permission"></td></tr>
{closetable}
</form>
<!-- End admin/permissions/new.tpl -->


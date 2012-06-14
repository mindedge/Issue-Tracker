<!-- Begin prefs/groups.tpl -->
<form method="post" action="?module=prefs&action=group&submit=true">
{opentable}
{titlebar colspan=5 title="Group Preferences"}
<tr class="tablehead" align="center">
<td width="20%" align="left">Group</td>
<td width="20%">Show Group</td>
<td width="20%">Email Notify</td>
<td width="20%">SMS Notify</td>
<td width="20%">Severity</td>
</tr>
{foreach from=$groups item=group}
<tr align="center">
<td align="left" width="20%" class="label">{$group.name}</td>
<td width="20%" class="data"><input type="checkbox" name="show{$group.gid}"{if $group.show_group eq "t"} checked="checked"{/if} /></td>
<td width="20%" class="data"><input type="checkbox" name="notemail{$group.gid}"{if in_array($smarty.session.userid,notify_list($group.gid,"E"))} checked="checked"{/if} /></td>
<td width="20%" class="data"><input type="checkbox" name="notsms{$group.gid}"{if in_array($smarty.session.userid,notify_list($group.gid,"S"))} checked="checked"{/if} /></td>
<td width="20%" class="data">
<select name="pty{$group.gid}">
{foreach from=$severities key=id item=sev}
{if $id ne 0}
<option value="{$id}"{if $group.severity eq $id} selected="selected"{/if}>{$sev}</option>
{/if}
{/foreach}
</select>
</td>
</tr>
{/foreach}
<tr class="titlebar"><td colspan="5"><input type="submit" value="Update Preferences" /></td></tr>
{closetable}
</form>
<!-- End prefs/groups.tpl -->


<!-- Begin groups/edit_notify.tpl -->
<form method="post" action="?module=groups&action=edit_notify&gid={$smarty.get.gid}&submit=true">
{opentable}
{titlebar colspan=4 title="Default Notification Lists"}
<tr class="tablehead" align="center">
<td width="25%">Add to Email List</td>
<td width="25%">Remove from Email List</td>
<td width="25%">Add to SMS List</td>
<td width="25%">Remove from SMS List</td>
</tr>
<tr class="data">
<td width="25%">
<select name="add_email[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$members key=userid item=username}
{if !in_array($userid,$notify_email)}
<option value="{$userid}">{$username}</option>
{/if}
{/foreach}
</select>
</td>
<td width="25%">
<select name="del_email[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$notify_email item=userid}
<option value="{$userid}">{username id=$userid}</option>
{/foreach}
</select>
</td>
<td width="25%">
<select name="add_sms[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$members key=userid item=username}
{if !in_array($userid,$notify_sms)}
<option value="{$userid}">{$username}</option>
{/if}
{/foreach}
</select>
</td>
<td width="25%">
<select name="del_sms[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$notify_sms item=userid}
<option value="{$userid}">{username id=$userid}</option>
{/foreach}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="4"><input type="submit" value="Update Notification Lists" /></td></tr>
{closetable}
</form>
<!-- End groups/edit_notify.tpl -->


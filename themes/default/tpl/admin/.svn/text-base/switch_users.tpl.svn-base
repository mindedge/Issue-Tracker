<!-- Begin admin/switch_users.tpl -->
<form method="post" action="?module=admin&action=switch_users">
{opentable}
{titlebar colspan=2 title="Switch Users"}
{if is_array($users)}
<tr>
<td width="20%" align="right" valign="top" class="label">Switch to:</td>
<td width="80%" class="data">
<select name="userid">
{foreach from=$users item=user}
<option value="{$user.userid}">{$user.username}</option>
{/foreach}
</select>
</td>
</tr>
<tr><td class="titlebar" colspan="2"><input type="submit" value="Switch User" /></td></tr>
{else}
<tr><td class="data" colspan="2">No other users to switch to.</td></tr>
{/if}
{closetable}
</form>
<!-- End admin/switch_users.tpl -->


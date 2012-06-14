<!-- Begin groups/edit_users.tpl -->
<form method="post" action="?module=groups&action=edit_users&gid={$smarty.get.gid}&submit=true">
{opentable}
{titlebar colspan=2 title="Group Users"}
<tr class="tablehead" align="center">
<td width="50%">Add Members</td>
<td width="50%">Remove Members</td>
</tr>
<tr class="data">
<td width="50%">
<select name="addmem[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$users item=user}
{if !array_key_exists($user.userid,$members)}
<option value="{$user.userid}">{$user.username}</option>
{/if}
{/foreach}
</select>
</td>
<td width="50%">
<select name="delmem[]" size="10" multiple="multiple" style="width: 100%;">
{foreach from=$members key=userid item=username}
<option value="{$userid}">{$username}</option>
{/foreach}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Update Users" /></td></tr>
{closetable}
</form>
<!-- End groups/edit_users.tpl -->


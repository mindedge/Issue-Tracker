<!-- Begin issues/move.tpl -->
{if !empty($smarty.post.gid)}
{opentable}
{titlebar colspan=2 title="Move Issue"}
<tr class="label"><td colspan="2">Are you sure you want to move this issue?  This will deescalate the issue from all groups.</td></tr>
<tr class="data" align="center">
<td width="50%">
<form method="post" action="?module=issues&action=move_issue&issueid={$smarty.get.issueid}">
<input type="hidden" name="confirm" value="true" />
<input type="hidden" name="gid" value="{$smarty.post.gid}" />
<input type="submit" value="Confirm" />
</form>
</td>
<td width="50%">
<form method="post" action="?module=issues&action=view&issueid={$smarty.get.issueid}">
<input type="submit" value="Cancel" />
</form>
</td>
</tr>
{closetable}
{else}
<form method="post" action="?module=issues&action=move_issue&issueid={$smarty.get.issueid}">
{opentable}
{titlebar colspan=2 title="Move Issue"}
<tr>
<td class="label" width="20%" align="right" valign="top">Move To:</td>
<td class="data" width="80%">
<select name="gid">
{foreach from=$smarty.session.groups item=gid}
{if group_active($gid) eq TRUE}
<option value="{$gid}">{groupname id=$gid}</option>
{/if}
{/foreach}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Move Issue" /></td></tr>
{closetable}
</form>
{/if}
<!-- End issues/move.tpl -->


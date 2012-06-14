<!-- Begin issues/choose_view_group.tpl -->
<form method="post" action="?module=issues&action=view&issueid={$smarty.get.issueid}">
{opentable}
{titlebar colspan=2 title="Issue Group Selection"}
<tr>
<td class="label" width="20%" align="right" valign="left">Group to view issue as:</td>
<td class="data" width="80%">
<select name="gid">
{foreach from=$ugroups item=group}
{if show_issue($smarty.get.issueid,$group.gid)}
<option value="{$group.gid}">{$group.name}</option>
{/if}
{/foreach}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Choose Group" /></td></tr>
{closetable}
</form>
<!-- End issues/choose_view_group.tpl -->


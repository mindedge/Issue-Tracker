<!-- Begin groups/status/summary.tpl -->
{opentable}
{titlebar colspan=7 title="Group Summaries"}
<tr class="tablehead" align="center">
<td width="5%">Standing</td>
<td align="left" width="10%">Group</td>
<td align="left">Information</td>
<td width="15%">Updated</td>
<td width="15%">End Date</td>
<td width="5%">&nbsp;</td>
</tr>
{if is_array($groups)}
{foreach from=$groups item=group}
<tr class="{rowcolor}" align="center">
{if $group.standing eq 3}
<td width="5%"><img src="{$smarty.env.imgs.urgent}" width="16" height="16" border="0" /></td>
{elseif $group.standing eq 2}
<td width="5%"><img src="{$smarty.env.imgs.high}" width="16" height="16" border="0" /></td>
{elseif $group.standing eq 1}
<td width="5%"><img src="{$smarty.env.imgs.normal}" width="16" height="16" border="0" /></td>
{else}
<td width="5%"><img src="{$smarty.env.imgs.low}" width="16" height="16" border="0" /></td>
{/if}
<td align="left" width="10%"><a href="?module=groups&action=status&history=true&gid={$group.gid}">{$group.name}</a></td>
<td align="left">{$group.info|stripslashes|stripslashes}</td>
<td width="15%">{$group.date_entered|userdate}</td>
<td width="15%">{$group.end_date|userdate}</td>
<td width="5%"><a href="?module=groups&action=status&gid={$group.gid}">Update</a></td>
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="7" align="center">No status reports to display.</td></tr>
{/if}
{closetable}
<!-- End groups/status/summary.tpl -->

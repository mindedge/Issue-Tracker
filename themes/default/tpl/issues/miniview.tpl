<!-- Begin issues/miniview.tpl -->
{opentable}
{titlebar colspan=5 title="Last Updated"}
<tr class="tablehead" align="center">
<td width="5%">Id</td>
<td width="15%">Group</td>
<td align="left">Summary</td>
<td width="10%">Updated</td>
<td width="15%">Status</td>
</tr>
{if is_array($last_issues)}
{foreach from=$last_issues item=issue}
<tr class="{rowcolor}" align="center">
<td width="5%"><a href="?module=issues&action=view&issueid={$issue.issueid}">{$issue.issueid}</a></td>{php}//made this a link, too MWarner 2/9/2010{/php}
<td width="15%">{groupname id=$issue.gid}</td>
<td align="left"><a href="?module=issues&action=view&issueid={$issue.issueid}">{$issue.summary|stripslashes}</a></td>
<td width="10%">{$issue.modified|userdate}</td>
<td width="15%">{status id=$issue.status}</td>
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="5">No issues to list.</td></tr>
{/if}
{closetable}
<br />
{opentable}
{titlebar colspan=5 title="My Opened"}
<tr class="tablehead" align="center">
<td width="5%">Id</td>
<td width="15%">Group</td>
<td align="left">Summary</td>
<td width="10%">Updated</td>
<td width="15%">Status</td>
</tr>
{if is_array($opened_issues)}
{foreach from=$opened_issues item=issue}
<tr class="{rowcolor}" align="center">
<td width="5%"><a href="?module=issues&action=view&issueid={$issue.issueid}">{$issue.issueid}</a></td>{php}//made this a link, too MWarner 2/9/2010{/php}
<td width="15%">{groupname id=$issue.gid}</td>
<td align="left"><a href="?module=issues&action=view&issueid={$issue.issueid}">{$issue.summary|stripslashes}</a></td>
<td width="10%">{$issue.modified|userdate}</td>
<td width="15%">{status id=$issue.status}</td>
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="5">No issues to list.</td></tr>
{/if}
{closetable} 
<br />
{opentable}
{titlebar colspan=5 title="<a href='?module=issues&action=my_assigned'>My Assigned</a>"}
<tr class="tablehead" align="center">
<td width="5%">Id</td>
<td width="15%">Group</td>
<td align="left">Summary</td>
<td width="10%">Updated</td>
<td width="15%">Status</td>
</tr>
{if is_array($assigned_issues)}
{foreach from=$assigned_issues item=issue}
<tr class="{rowcolor}" align="center">
<td width="5%"><a href="?module=issues&action=view&issueid={$issue.issueid}">{$issue.issueid}</a></td>{php}//mad this a link, too MWarner 2/9/2010{/php}
<td width="15%">{groupname id=$issue.gid}</td>
<td align="left"><a href="?module=issues&action=view&issueid={$issue.issueid}">{$issue.summary|stripslashes}</a></td>
<td width="10%">{$issue.modified|userdate}</td>
<td width="15%">{status id=$issue.status}</td>
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="5">No issues to list.</td></tr>
{/if}
{closetable}
<!-- End issues/miniview.tpl -->


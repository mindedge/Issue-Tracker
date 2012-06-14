<!-- Begin issues/my_assigned.tpl -->
{opentable}
{titlebar colspan=8 title=$table_title"}{php}//show num assigned in table title MWarner 2/23/2010{/php}
<tr class="tablehead" align="center">
<td width="5%"><a href="{$url}&sort=issueid">Id</a></td>
<td width="5%"><a href="{$url}&sort=severity">Sev</a></td>
<td width="10%"><a href="{$url}&sort=gid">Group</a></td>
<td align="left">Summary</td>
<td align="left">Product</td><!-- show product, too MWarner 2/2/2010-->
<td width="10%"><a href="{$url}&sort=opened_by">Opened By</a></td>
<td width="15%"><a href="{$url}&sort=status">Status</a></td>
<td width="10%"><a href="{$url}&sort=due_date">Due Date</a></td>
</tr>
{if is_array($issues)}
{foreach from=$issues item=issue}
{if show_issue($issue.issueid,$issue.gid)}
<tr class="{rowcolor}" align="center" onMouseOver="highlightRow(this)" onMouseOut="highlightRow(this)">{php}//highlight row on mouseover MWarner 3/9/2010{/php}
<td width="5%"><a href="?module=issues&action=view&issueid={$issue.issueid}">{$issue.issueid}</a></td>{php}//made this a link, too MWarner 2/9/2010{/php}
<td width="5%"><img src="{sevimg sev=$issue.severity}" width="16" height="16" border="0" />({$issue.severity})</td>
<td width="10%">{groupname id=$issue.gid}</td>
<td align="left"><a href="?module=issues&action=view&issueid={$issue.issueid}">{$issue.summary|stripslashes}</a></td>
<td width="15%" align="left">{product id=$issue.product}</td>{php}// show product, too MWarner 2/2/2010{/php}
<td width="10%">{username id=$issue.opened_by}</td>
<td width="15%">{status id=$issue.status}</td>
<td width="10%">{$issue.due_date|userdate}</td>{php}// show this MWarner 3/23/2010{/php}
</tr>
{/if}
{/foreach}
{else}
<tr class="data" align="center"><td colspan="8">No issues to display.</td></tr>
{/if}
{closetable}
<br>
<!-- End issues/my_assigned.tpl -->

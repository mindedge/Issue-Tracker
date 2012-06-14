<!-- Begin issues/my_closed.tpl built by MWarner 2/3/2010 -->
{opentable}
{titlebar colspan=8 title="My Issues (Closed)"}
<tr class="tablehead" align="center">
<td width="5%"><a href="{$url}&sort=issueid">Id</a></td>
<td width="5%"><a href="{$url}&sort=severity">Sev</a></td>
<td width="15%"><a href="{$url}&sort=gid">Group</a></td>
<td align="left">Summary</td>
<td align="left">Product</td><!-- show product, too MWarner 2/2/2010-->
<td width="10%"><a href="{$url}&sort=opened_by">Opened By</a></td>
<td width="15%"><a href="{$url}&sort=status">Status</a></td>
<td width="10%"><a href="{$url}&sort=modified{if $smarty.get.sort eq "modified" and $smarty.get.reverse ne "true"}&reverse=true{/if}">Closed On</a></td><!-- show this MWarner 2/3/2010-->
</tr>
{if is_array($issues)}
{foreach from=$issues item=issue}
{if show_issue($issue.issueid,$issue.gid)}
<tr class="{rowcolor}" align="center" onMouseOver="highlightRow(this)" onMouseOut="highlightRow(this)">{php}//highlight row on mouseover MWarner 3/9/2010{/php}
<td width="5%"><a href="?module=issues&action=view&issueid={$issue.issueid}">{$issue.issueid}</a></td>{php}//mad this a link, too MWarner 2/9/2010{/php}
<td width="5%"><img src="{sevimg sev=$issue.severity}" width="16" height="16" border="0" />({$issue.severity})</td>
<td width="15%">{groupname id=$issue.gid}</td>
<td align="left"><a href="?module=issues&action=view&issueid={$issue.issueid}">{$issue.summary|stripslashes}</a></td>
<td width="15%" align="left">{product id=$issue.product}</td><!-- show product, too MWarner 2/2/2010-->
<td width="10%">{username id=$issue.opened_by}</td>
<td width="15%">{status id=$issue.status}</td>
<td width="10%">{$issue.closed|userdate:TRUE}</td><!-- show this MWarner 2/3/2010-->
</tr>
{/if}
{/foreach}
{else}
<tr class="data" align="center"><td colspan="6">No issues to display.</td></tr>
{/if}
{closetable}
<!-- End issues/my_closed.tpl -->


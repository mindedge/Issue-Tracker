<!-- Begin issues/group.tpl -->
{opentable}
{titlebar colspan=$colspan title=$title}
<tr class="tablehead" align="center">
{if in_array("flags",$smarty.session.prefs.show_fields)
and is_employee($smarty.session.userid)}
<td width="60">Flags</td>
{/if}
{if in_array("issueid",$smarty.session.prefs.show_fields)}
<td width="5%"><a href="{$url}&sort=issueid{if $smarty.get.sort eq "issueid" and $smarty.get.reverse ne "true"}&reverse=true{/if}">Id</a></td>
{/if}
{if in_array("severity",$smarty.session.prefs.show_fields)}
<td width="5%"><a href="{$url}&sort=severity{if $smarty.get.sort eq "severity" and $smarty.get.reverse ne "true"}&reverse=true{/if}">Sev</a></td>
{/if}
<td align="left">Summary</td>
<td width="5%">Unread</td>
{if in_array("opened_by",$smarty.session.prefs.show_fields)}
<td width="10%"><a href="{$url}&sort=opened_by{if $smarty.get.sort eq "opened_by" and $smarty.get.reverse ne "true"}&reverse=true{/if}">Opened</a></td>
{/if}
{if in_array("assigned_to",$smarty.session.prefs.show_fields)}
<td width="10%"><a href="{$url}&sort=assigned_to{if $smarty.get.sort eq "assigned_to" and $smarty.get.reverse ne "true"}&reverse=true{/if}">Assigned</a></td>
{/if}
{if in_array("modified",$smarty.session.prefs.show_fields)}
<td width="10%"><a href="{$url}&sort=modified{if $smarty.get.sort eq "modified" and $smarty.get.reverse ne "true"}&reverse=true{/if}">Updated</a></td>
{/if}
{if in_array("category",$smarty.session.prefs.show_fields)}
<td width="10%"><a href="{$url}&sort=category{if $smarty.get.sort eq "category" and $smarty.get.reverse ne "true"}&reverse=true{/if}">Category</a></td>
{/if}
{if in_array("product",$smarty.session.prefs.show_fields)}
<td width="10%"><a href="{$url}&sort=product{if $smarty.get.sort eq "product" and $smarty.get.reverse ne "true"}&reverse=true{/if}">Product</a></td>
{/if}
{if in_array("status",$smarty.session.prefs.show_fields)}
<td width="10%"><a href="{$url}&sort=status{if $smarty.get.sort eq "status" and $smarty.get.reverse ne "true"}&reverse=true{/if}">Status</a></td>
{/if}
<td width="10%"><a href="{$url}&sort=due_date">Due Date</a></td>
</tr>
{if $num_rows > 0}
{foreach from=$rows key=issueid item=issue}
<tr class="{rowcolor}" align="center" onMouseOver="highlightRow(this)" onMouseOut="highlightRow(this)">{php}//highlight row on mouseover MWarner 3/9/2010{/php}
{if in_array("flags",$smarty.session.prefs.show_fields)
and is_employee($smarty.session.userid)}
<td width="60">
{if $issue.private eq "t"}
<img src="{$smarty.env.imgs.private}" width="16" height="16" border="0" alt="Private Issue" />
{/if}
{if $issue.escto eq TRUE}
<img src="{$smarty.env.imgs.deescalate}" width="16" height="16" border="0" alt="Escalated into this Group" />
{/if}
{if $issue.escfrom eq TRUE}
<img src="{$smarty.env.imgs.escalate}" width="16" height="16" border="0" alt="Escalated out of this Group" />
{/if}
</td>
{/if}
{if in_array("issueid",$smarty.session.prefs.show_fields)}
<td width="5%">{$issueid}</td>
{/if}
{if in_array("severity",$smarty.session.prefs.show_fields)}
<td width="5%"><img src="{sevimg sev=$issue.severity}" border="0" />({$issue.severity})</td>
{/if}
<td align="left"><a href="?module=issues&action=view&issueid={$issueid}&gid={$smarty.get.gid}">{$issue.summary|stripslashes}</td>
<td width="5%">{$issue.unread}</td>
{if in_array("opened_by",$smarty.session.prefs.show_fields)}
<td width="10%">{$issue.username}</td>
{/if}
{if in_array("assigned_to",$smarty.session.prefs.show_fields)}
<td width="10%">{username id=$issue.assigned_to}</td>
{/if}
{if in_array("modified",$smarty.session.prefs.show_fields)}
<td width="10%">{$issue.modified|userdate:TRUE}</td>
{/if}
{if in_array("category",$smarty.session.prefs.show_fields)}
<td width="15%">{category id=$issue.category}</td>
{/if}
{if in_array("product",$smarty.session.prefs.show_fields)}
<td width="15%">{product id=$issue.product}</td>
{/if}
{if in_array("status",$smarty.session.prefs.show_fields)}
<td width="15%">{status id=$issue.status}</td>
{/if}
<td width="10%">{$issue.due_date|userdate}</td>{php}// show this MWarner 3/23/2010{/php}
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="{$colspan}">No Issues to display.</td></tr>
{/if}
{closetable}
<!-- End issues/group.tpl -->


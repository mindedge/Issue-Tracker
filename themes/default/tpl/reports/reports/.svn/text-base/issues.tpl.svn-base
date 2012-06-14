<!-- Begin reports/reports/issues.tpl --> 
<table width="100%" border="0" cellspacing="0" cellpadding="2">
{foreach from=$issues item=issue}
<tr><td colspan="2" class="subtitle">(Issue #{$issue.issueid}) {$issue.summary|stripslashes}</td></tr>
{if is_array($smarty.post.fields)}
{if in_array("opened",$smarty.post.fields)}
<tr>
<td class="label" width="20%" align="right" valign="top">Opened:</td>
<td class="data" width="80%">{$issue.opened|userdate:TRUE}</td>
</tr>
{/if}
{if in_array("modified",$smarty.post.fields)}
<tr>
<td class="label" width="20%" align="right" valign="top">Modified:</td>
<td class="data" width="80%">{$issue.modified|userdate:TRUE}</td>
</tr>
{/if}
{if in_array("closed",$smarty.post.fields) and !empty($issue.closed)}
<tr>
<td class="label" width="20%" align="right" valign="top">Closed:</td>
<td class="data" width="80%">{$issue.closed|userdate:TRUE}</td>
</tr>
{/if}
{if in_array("opened_by",$smarty.post.fields)}
<tr>
<td class="label" width="20%" align="right" valign="top">Opened By:</td>
<td class="data" width="80%">{username id=$issue.opened_by}</td>
</tr>
{/if}
{if in_array("assigned_to",$smarty.post.fields)}
<tr>
<td class="label" width="20%" align="right" valign="top">Assigned To:</td>
<td class="data" width="80%">
{foreach from=$issue.assigned key=group item=user}
{groupname id=$group}: {username id=$user}<br />
{/foreach}
</td>
</tr>
{/if}
{if in_array("status",$smarty.post.fields)}
<tr>
<td class="label" width="20%" align="right" valign="top">Status:</td>
<td class="data" width="80%">{status id=$issue.status}</td>
</tr>
{/if}
{if in_array("product",$smarty.post.fields)}
<tr>
<td class="label" width="20%" align="right" valign="top">Product:</td>
<td class="data" width="80%">{product id=$issue.product}</td>
</tr>
{/if}
{if in_array("category",$smarty.post.fields)}
<tr>
<td class="label" width="20%" align="right" valign="top">Category:</td>
<td class="data" width="80%">{category id=$issue.category}</td>
</tr>
{/if}
{if in_array("severity",$smarty.post.fields)}
<tr>
<td class="label" width="20%" align="right" valign="top">Severity:</td>
<td class="data" width="80%">{$issue.severity} <img src="{sevimg sev=$issue.severity}" width="16" height="16" border="0" /></td>
</tr>
{/if}
{if in_array("problem",$smarty.post.fields)}
<tr>
<td class="label" width="20%" align="right" valign="top">Problem:</td>
<td class="data" width="80%">{$issue.problem|format}</td>
</tr>
{/if}
{/if}
{if $smarty.post.show_events eq "on" and is_array($issue.events)}
{foreach from=$issue.events item=event}
<tr><td class="label" colspan="2">Entered {$event.performed_on|userdate:TRUE} by {username id=$event.userid}</td></tr>
<tr>
<td class="data" colspan="2">
{$event.action|format}
</td>
</tr>
{/foreach}
{/if}
{/foreach}
</table>
<!-- End reports/reports/issues.tpl -->


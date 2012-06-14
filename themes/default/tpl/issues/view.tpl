<!-- Begin issues/view.tpl -->
{opentable}
{titlebar colspan=2 title="View Issue"}
<tr>
<td class="label" width="20%" align="right" valign="top">Summary:</td>
{if issue_priv($smarty.get.issueid,"technician")}
<td class="data" width="80%">
<form method="post" action="?module=issues&action=view&issueid={$smarty.get.issueid}&update_summary=true">
<input type="text" size="60" name="summary" value="{$issue.summary|stripslashes}" />
<input type="submit" value="Update" />
</form>
</td>
{else}
<td class="data" width="80%">{$issue.summary|stripslashes}</td>
{/if}
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Opened:</td>
<td class="data" width="80%">{$issue.opened|userdate:TRUE}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Modified:</td>
<td class="data" width="80%">{$issue.modified|userdate:TRUE}</td>
</tr>
{if is_employee($smarty.session.userid)}
<tr>
<td class="label" width="20%" align="right" valign="top">Due Date:<!--br>{$issue.due_date}--></td>
<td class="data" width="80%">
{if issue_priv($smarty.get.issueid,"technician")}
<form method="post" action="?module=issues&action=view&issueid={$smarty.get.issueid}">
{date_select name="duedate" value=$issue.due_date}<!--|userdate-->
<input type="submit" value="Update" />
</form>
{else}
{$issue.due_date|userdate}
{/if}
</td>
</tr>
{/if}
<tr>
<td class="label" width="20%" align="right" valign="top">Opened By:</td>
<td class="data" width="80%">{username id=$issue.opened_by}</td>
</tr>
{if !empty($requester)}
<tr>
<td class="label" width="20%" align="right" valign="top">Requester:</td>
<td class="data" width="80%">{$requester|stripslashes}</td>
</tr>
{/if}
<tr>
<td class="label" width="20%" align="right" valign="top">Assigned To:</td>
<td class="data" width="80%">
{foreach from=$assigned key=gid item=userid}
{groupname id=$gid}: {username id=$userid}<br />
{/foreach}
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Product:</td>
<td class="data" width="80%">{product id=$issue.product}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Category:</td>
<td class="data" width="80%">{category id=$issue.category}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Status:</td>
<td class="data" width="80%">{status id=$issue.status}</td>
</tr>
{if is_employee($smarty.session.userid) and !empty($issue.istatus)}
<tr>
<td class="label" width="20%" align="right" valign="top">Internal Status:</td>
<td class="data" width="80%">{status id=$issue.istatus}</td>
</tr>
{/if}
<tr>
<td class="label" width="20%" align="right" valign="top">Severity:</td>
<td class="data" width="80%"><img src="{sevimg sev=$issue.severity}" border="0" />({sevtxt sev=$issue.severity})</td>
</tr>
{if is_employee($smarty.session.userid) and !empty($issue.iseverity) and $issue.iseverity != $issue.severity}
<tr>
<td class="label" width="20%" align="right" valign="top">Internal Severity:</td>
<td class="data" width="80%"><img src="{sevimg sev=$issue.iseverity}" border="0" />({sevtxt sev=$issue.iseverity})</td>
</tr>
{/if}
<tr>
<td class="label" width="20%" align="right" valign="top">Problem:</td>
<td class="data" width="80%">{$issue.problem|format}</td>
</tr>
{closetable}
<br />
<!-- End issues/view.tpl -->


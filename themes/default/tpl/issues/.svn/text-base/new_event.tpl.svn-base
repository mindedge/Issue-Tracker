<!-- Begin issues/new_event.tpl -->
<span class="noprint">
<form method="post" action="?module=issues&action=update&issueid={$smarty.get.issueid}&gid={$group}" enctype="multipart/form-data">
<input type="hidden" name="ogid" value="{$issue.gid}" />
{opentable}
{titlebar colspan=2 title="New Event"}
{if group_over_limit($group,"hours")}
<tr class="data" align="center"><td colspan="2">This group has exceeded their limit.  Please contact the group administrator.</td></tr>
{else}
<tr class="label"><td colspan="2">Action:</td></tr>
<tr class="data">
<td colspan="2">
<textarea cols="60" rows="10" name="event"{if !user_in_group($issue.gid)} class="privateupdate"{/if}>{$smarty.post.event|stripslashes}</textarea>
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Status:</td>
<td class="data" width="80%">
<select name="new_status" style="width: 25%;">
<option value="">(Update Status)</option>
{if is_array($statuses)}
{foreach from=$statuses key=sid item=status}
<option value="{$sid}"{if $sid eq $issue.status} selected="selected"{/if}>{$status}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
{if is_employee($smarty.session.userid)}
<tr>
<td class="label" width="20%" align="right" valign="top">Internal Status:</td>
<td class="data" width="80%">
<select name="new_istatus" style="width: 25%;">
<option value="">(Update Internal Status)</option>
{if is_array($istatuses)}
{foreach from=$istatuses key=sid item=status}
<option value="{$sid}"{if $sid eq $issue.istatus} selected="selected"{/if}>{$status}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
{/if}
{if issue_priv($smarty.get.issueid,"technician")}
<tr>
<td class="label" width="20%" align="right" valign="top">Notify:</td>
<td class="data" width="80%">
<div style="float:left;width:350px;">
<select name="notify_list[]" size="5" multiple="multiple" style="width: 90%;">
{if is_array($notifylist)}
{foreach from=$notifylist key=userid item=username}
<option value="{$userid}">{$username}</option>
{/foreach}
{/if}
</select>
</div>
<div style="float:left;background-color:#f5f5f5;padding:4px;margin:3px;width:300px;border:1px solid gray">
Subscribed users:<br>
{php}echo get_subscriberlist($_GET["issueid"]){/php}
</div>
</td>
</tr>
{/if}
<tr>
<td class="label" width="20%" align="right" valign="top">Severity:</td>
<td class="data" width="80%">
<input type="radio" name="severity" value="4"{if $issue.severity eq 4} checked="checked"{/if} /> (Low)&nbsp;
<input type="radio" name="severity" value="3"{if $issue.severity eq 3} checked="checked"{/if} /> (Normal)&nbsp;
<input type="radio" name="severity" value="2"{if $issue.severity eq 2} checked="checked"{/if} /> (High)&nbsp;
<input type="radio" name="severity" value="1"{if $issue.severity eq 1} checked="checked"{/if} /> (Urgent)&nbsp;
</td>
</tr>
{if is_employee($smarty.session.userid)}
<tr>
<td class="label" width="20%" align="right" valign="top">Internal Severity:</td>
<td class="data" width="80%">
<input type="radio" name="iseverity" value="4"{if $issue.iseverity eq 4} checked="checked"{/if} /> (Low)&nbsp;
<input type="radio" name="iseverity" value="3"{if $issue.iseverity eq 3} checked="checked"{/if} /> (Normal)&nbsp;
<input type="radio" name="iseverity" value="2"{if $issue.iseverity eq 2} checked="checked"{/if} /> (High)&nbsp;
<input type="radio" name="iseverity" value="1"{if $issue.iseverity eq 1} checked="checked"{/if} /> (Urgent)&nbsp;
</td>
</tr>
{/if}
{if issue_priv($smarty.get.issueid,"upload_files")}
<tr>
<td class="label" width="20%" align="right" valign="top">File:</td>
<td class="data" width="80%"><input type="file" name="upload" style="width: 25%;" /></td>
</tr>
{/if}
{if issue_priv($smarty.get.issueid,"technician")}
<tr>
<td class="label" width="20%" align="right" valign="top">Category:</td>
<td class="data" width="80%">
<select name="cat" style="width: 25%;">
<option value="">(Category Not Set)</option>
{if is_array($categories)}
{foreach from=$categories key=cid item=category}
<option value="{$cid}"{if $cid eq $issue.category} selected="selected"{/if}>{$category}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Product:</td>
<td class="data" width="80%">
<select name="prod" style="width: 25%;">
<option value="">(Product Not Set)</option>
{if is_array($products)}
{php}asort($this->_tpl_vars['products']);//sort by product name, not ID MWarner 4/25/2011{/php}
{foreach from=$products key=pid item=product}
<option value="{$pid}"{if $pid eq $issue.product} selected="selected"{/if}>{$product}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Assign To:</td>
<td class="data" width="80%">
<select name="assign" style="width: 25%;">
<option value="">(No User Assigned)</option>
{if is_array($gmembers)}
{foreach from=$gmembers key=userid item=username}
<option value="{$userid}"{if $assigned eq $userid} selected="selected"{/if}>{$username}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Duration:</td>
<td class="data" width="80%"><input type="text" size="7" name="dur" value="{$smarty.post.dur}" /></td>
</tr>
{if is_array($egroups) and count($egroups) > 0}
<tr>
<td class="label" width="20%" align="right" valign="top">Escalate To:</td>
<td class="data" width="80%">
<select name="egid" style="width: 25%;">
<option value="">(Do Not Escalate)</option>
{foreach from=$egroups key=gid item=name}
{if !in_array($gid,$groups)
or (in_array($gid,$groups) and !show_issue($smarty.get.issueid,$gid))
and group_active($gid)}
<option value="{$gid}">{$name}</option>
{/if}
{/foreach}
</select>
</td>
</tr>
{/if}
{/if}
{if issue_priv($smarty.get.issueid,"view_private")}
<tr>
<td class="label" width="20%" align="right" valign="top">Ticket Private:</td>
<td class="data" width="80%"><input type="checkbox" name="tprivate"{if $smarty.post.tprivate eq "on" || $issue.private eq "t"} checked="checked"{/if} /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Event Private:</td>
{if user_in_group($issue.gid)}
<td class="data" width="80%"><input type="checkbox" name="eprivate"{if $smarty.post.eprivate eq "on"} checked="checked"{/if} /></td>
{else}
<td class="data" width="80%">Event Forced Private<input type="hidden" name="eprivate" value="on" /></td>
{/if}
</tr>
{/if}
<tr class="titlebar"><td colspan="2"><input type="submit" value="Commit Event" /></td></tr>
{/if}
{closetable}
</form>
</span>
<!-- End issues/new_event.tpl -->


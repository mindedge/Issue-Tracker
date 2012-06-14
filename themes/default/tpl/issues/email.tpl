<!-- Begin issues/email.tpl -->
<script language="javascript" type="text/javascript">
function toggleEvents(val)
{ldelim}
  events = document.emailform;
  len = events.elements.length;
  var i = 0;
  
  for (i = 0;i < len;i++) {ldelim}
    if (events.elements[i].name == 'eids[]') {ldelim}
      events.elements[i].checked = val;
    {rdelim}
  {rdelim}
{rdelim}
</script>
<form name="emailform" method="post" action="?module=issues&action=email&issueid={$smarty.get.issueid}">
{opentable}
{titlebar colspan=3 title="Email Issue"}
<tr>
<td class="subtitle"colspan="3">
[ <a href="javascript: toggleEvents(1);">Select All Events</a> ]
[ <a href="javascript: toggleEvents(0);">Clear Selected</a> ]
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Email:</td>
<td class="data" width="80%" colspan="2"><input type="text" size="64" maxlength="64" name="address" value="{$smarty.post.address|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Summary:</td>
<td class="data" width="80%" colspan="2"><input type="text" size="64" maxlength="250" name="subject" value="{$summary|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Problem:</td>
<td class="data" width="80%" colspan="2"><textarea cols="60" rows="10" name="problem">{$problem|stripslashes}</textarea></td>
</tr>
{titlebar colspan=3 title="Events"}
<tr class="tablehead" align="center">
<td width="20%">Username</td>
<td align="left">Action</td>
<td width="10%">Include</td>
</tr>
{if is_array($events)}
{foreach from=$events item=event}
<tr class="data" align="center">
<td width="20%">{username id=$event.userid}</td>
<td align="left">{$event.action|format}</td>
<td width="10%"><input type="checkbox" name="eids[]" value="{$event.eid}" checked="checked" /></td>
</tr>
{/foreach}
{else}
<tr class="data" align="center"><td colspan="3">No events to include.</td></tr>
{/if}
<tr class="titlebar"><td colspan="3"><input type="submit" value="Send Email" /></td></tr>
{closetable}
</form>
<!-- End issues/email.tpl -->


<!-- Begin issues/view_log.tpl -->
{opentable}
{if is_employee($smarty.session.userid)}
{titlebar colspan=4 title="Issue Log"}
{else}
{titlebar colspan=3 title="Issue Log"}
{/if}
<tr class="tablehead">
{if is_employee($smarty.session.userid)}
<td width="5%" align="center">Private</td>
{/if}
<td width="20%">Logged On</td>
<td width="15%">Logged By</td>
<td align="left">Message</td>
</tr>
{if is_array($messages)}
{foreach from=$messages item=message}
<tr class="{rowcolor}">
{if is_employee($smarty.session.userid)}
<td width="5%" align="center">
{if $message.private eq "t"}
<img src="{$smarty.env.imgs.private}" width="16" height="16" border="0" alt="Private Message" />
{else}
<img src="{$smarty.env.imgs.public}" width="16" height="16" border="0" alt="Public Message" />
{/if}
</td>
{/if}
<td width="20%">{$message.logged|userdate:TRUE}</td>
<td width="15%">{username id=$message.userid}</td>
<td align="left">{$message.message|stripslashes}</td>
</tr>
{/foreach}
{else}
{if is_employee($smarty.session.userid)}
<tr class="data" align="center"><td colspan="4">No log messages to display.</td></tr>
{else}
<tr class="data" align="center"><td colspan="3">No log messages to display.</td></tr>
{/if}
{/if}
{closetable}
<!-- End issues/view_log.tpl -->


<!-- Begin issues/show_events.tpl -->
{opentable}
{titlebar colspan=2 title="Events"}
{if is_array($events)}
{foreach from=$events item=event}
<tr class="label">
<td class="label" width="20%">
Posted: {$event.performed_on|userdate:TRUE}<br />
User: {username id=$event.userid}<br />
{if issue_priv($smarty.get.issueid,"technician")}
Duration: {$event.duration}<br />
{/if}
{if is_array($event.links)}
{foreach from=$event.links item=link}
[ <img src="{$link.img}" width="16" height="16" border="0" alt="{$link.alt}" /><a href="{$link.url}">{$link.alt}</a> ]<br />
{/foreach}
{/if}
</td>
<td class="{$event.class}">{$event.action|format}</td>
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="2" align="center">No events to display.</td></tr>
{/if}
{closetable}
<br />
<!-- End issues/show_events.tpl -->


<!-- Begin issues/group_status_miniview.tpl -->
{opentable}
{titlebar colspan=9 title="Group Standing"}
<tr class="tablehead">
<td width="5%" align="center">Standing</td>
<td>Group</td>
<td width="5%" align="center">New</td>
<td width="5%" align="center">Open</td>
<td width="5%" align="center">Urgent</td>
<td width="5%" align="center">High</td>
<td width="5%" align="center">Normal</td>
<td width="5%" align="center">Low</td>
<td width="5%" align="center">Closed</td>{php}//show num closed MWarner 2/23/2010{/php}
</tr>
{if count($group_status) > 0}
{foreach from=$group_status key=gid item=group}
{if show_group($gid)}
<tr class="{rowcolor}">
<td width="5%" align="center"><img src="{$group.standing}" width="16" height="16" border="0" /></td>
<td><a href="?module=issues&action=group&gid={$gid}">{$group.name}</a></td>
<td width="5%" align="center">{$group.new}</td>
<td width="5%" align="center">{$group.open}</td>
<td width="5%" align="center">{$group.sev1}</td>
<td width="5%" align="center">{$group.sev2}</td>
<td width="5%" align="center">{$group.sev3}</td>
<td width="5%" align="center">{$group.sev4}</td>
<td width="5%" align="center">{$group.closed}</td>{php}//show num closed MWarner 2/23/2010{/php}
</tr>
{/if}
{/foreach}
{else}
<tr class="data"><td colspan="9" align="center">No group standings to display.</td></tr>
{/if}
{closetable}
<div style="text-align: center; margin: 2px;">
<img src="{$smarty.env.imgs.normal}" width="16" height="16" border="0" alt="Rating below 25" /> = Good
<img src="{$smarty.env.imgs.high}" width="16" height="16" border="0" alt="Rating between 25 and 49" /> = Fair
<img src="{$smarty.env.imgs.urgent}" width="16" height="16" border="0" alt="Rating of 50 or higher" /> = Critical
</div>
<br />
<!-- End issues/group_status_miniview.tpl-->

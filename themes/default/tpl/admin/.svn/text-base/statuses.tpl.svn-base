<!-- Begin admin/statuses.tpl -->
{opentable}
{titlebar colspan=5 title="Statuses"}
<tr class="tablehead" align="center">
<td width="5%">ID</td>
<td align="left">Status</td>
<td width="15%">Type</td>
<td width="5%">Edit</td>
<td width="5%">Delete</td>
</tr>
{if is_array($statuses)}
{foreach from=$statuses item=status}
{php}$class = rowcolor();{/php}
<tr class="{php}print $class;{/php}" align="center">
<td width="5%">{$status.sid}</td>
<td align="left">{$status.status}</td>
<td width="15%">{$status.status_type}</td>
<td width="5%"><a href="?module=admin&action=statuses&subaction=edit&id={$status.sid}"><img src="{$smarty.env.imgs.edit}" width="16" height="16" border="0" alt="Edit" /></a></td>
<td width="5%"><a href="?module=admin&action=statuses&subaction=delete&id={$status.sid}"><img src="{$smarty.env.imgs.delete}" width="16" height="16" border="0" alt="Delete" /></a></td>
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="4">No defined statuses.</td></tr>
{/if}
{closetable}
<!-- End admin/statuses.tpl -->


<!-- Begin admin/view_log.tpl -->
{opentable}
{titlebar colspan=2 title="View Logs"}
<tr class="tablehead">
<td width="20%">Logs</td>
<td width="80%">Current Log</td>
</tr>
<tr class="data">
<td width="20%">
{if is_array($logs)}
{foreach from=$logs item=val}
<li><a href="?module=admin&action=view_logs&log={$val}">{$val}</a></li>
{/foreach}
{else}
No Logs
{/if}
</td>
<td width="80%">
<pre class="fixed">
{if !empty($smarty.get.log)}
{$log}
{else}
No log chosen to view.
{/if}
</pre>
</td>
</tr>
{closetable}
<!-- End admin/view_log.tpl -->


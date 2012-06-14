<!-- Begin reports/reports/per_status.tpl --> 
{if in_array("perstat",$smarty.post.options)}
	{subtitle colspan=4 title="Issues Per Status"}
	{if is_array($status_data)}
		{php}$col = 0;{/php}
		{foreach from=$status_data key=status item=count}
			{php}if ($col == 0) { print "<tr class=\"data\">\n"; }{/php}
			<td width="45%" class="label">{$status}</td>
			<td width="5%" align="center">{$count}</td>
			{php}$col++; if ($col == 2) { print "</tr>\n"; $col = 0; }{/php}
		{/foreach}
		{php}if ($col == 1) { print "<td class=\"label\" colspan=\"2\">&nbsp;</td>\n</tr>\n"; }{/php}
	{else}
		<tr class="data" align="center"><td colspan="4">No Data Available.</td></tr>
	{/if}
{/if}
<!-- End reports/reports/per_status.tpl -->


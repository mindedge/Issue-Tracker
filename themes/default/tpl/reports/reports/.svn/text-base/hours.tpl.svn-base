{if in_array("hours",$smarty.post.options)} 
<!-- Begin reports/reports/hours.tpl -->
{subtitle colspan=4 title="Hours Logged Per Technician"}
{if is_array($hour_data)}
{php}$col = 0;{/php}
{foreach from=$hour_data key=tech item=count}
{php}if ($col == 0) { print "<tr class=\"data\">\n"; }{/php}
<td width="45%" class="label">{$tech}</td>
<td width="5%" align="center">{$count}</td>
{php}$col++; if ($col == 2) { print "</tr>\n"; $col = 0; }{/php}
{/foreach}
{php}if ($col == 1) { print "<td class=\"label\" colspan=\"2\">&nbsp;</td>\n</tr>\n"; }{/php}
{else}
<tr class="data" align="center"><td colspan="4">No Data Available.</td></tr>
{/if}
<!-- End reports/reports/hours.tpl -->
{/if}


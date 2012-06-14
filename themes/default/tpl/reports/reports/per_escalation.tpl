{if in_array("peresc",$smarty.post.options)}
<!-- Begin reports/reports/per_escalation.tpl --> 
{subtitle colspan=4 title="Issues Per Escalation Type"}
{if is_array($escalation_data)}
{php}$col = 0;{/php}
{foreach from=$escalation_data key=escalation item=count}
{php}if ($col == 0) { print "<tr class=\"data\">\n"; }{/php}
<td width="45%" class="label">{$escalation}</td>
<td width="5%" align="center">{$count}</td>
{php}$col++; if ($col == 2) { print "</tr>\n"; $col = 0; }{/php}
{/foreach}
{php}if ($col == 1) { print "<td class=\"label\" colspan=\"2\">&nbsp;</td>\n</tr>\n"; }{/php}
{else}
<tr class="data" align="center"><td colspan="4">No Data Available.</td></tr>
{/if}
<!-- End reports/reports/per_escalation.tpl -->
{/if}


<!-- Begin reports/reports/graphs.tpl -->  
{subtitle colspan=4 title="Graphs"}
<tr class="tablehead" align="center">
<td width="25%">Issues Per Category</td>
<td width="25%">Issues Per Product</td>
<td width="25%">Issues Per Status</td>
<td width="25%">Issues Per Severity</td>
</tr>
<tr class="data" align="center">
<td width="25%">{$category_data}</td>
<td width="25%">{$product_data}</td>
<td width="25%">{$status_data}</td>
<td width="25%">{$severity_data}</td>
</tr>
{if $smarty.get.tech ne "true"}
<tr class="tablehead">
<td width="25%">Issues Per Technician</td>
{if !is_employee($smarty.session.userid)}
<td width="75%" colspan="3">&nbsp;</td>
{else}
<td width="25%">&nbsp;</td>
<td width="25%">&nbsp;</td>
<td width="25%">&nbsp;</td>
{/if}
</tr>
<tr class="data" align="center">
<td width="25%">{$tech_data}</td>
{if !is_employee($smarty.session.userid)}
<td width="75%" colspan="3">&nbsp;</td>
{else}
<td width="25%">{$escalation_data}</td>
<td width="25%">{$hours_data}</td>
<td width="25%">&nbsp;</td>
{/if}
</tr>
{/if}
<!-- End reports/reports/graphs.tpl -->


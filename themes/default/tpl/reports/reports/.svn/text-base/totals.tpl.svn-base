<!-- Begin reports/reports/totals.tpl --> 
{opentable}
{if !is_employee($smarty.session.userid)}
{subtitle colspan=4 title="Issue Totals"}
{else}
{subtitle colspan=4 title="Issue Totals"}
{/if}
<tr class="tablehead" align="center">
<td width="25%">Opened</td>
<td width="25%">Resolved</td>
<td width="25%">Events Entered</td>
{if !is_employee($smarty.session.userid)}
<td width="25%" class="label">&nbsp;</td>
{else}
<td width="25%">Hours Logged</td>
{/if}
</tr>
<tr class="data" align="center">
<td width="25%">{$numopened|default:"N/A"}</td>
<td width="25%">{$numresolved|default:"N/A"}</td>
<td width="25%">{$numevents|default:"N/A"}</td>
{if !is_employee($smarty.session.userid)}
<td width="25%" class="label">&nbsp;</td>
{else}
<td width="25%">{$numhours|default:"N/A"}</td>
{/if}
</tr>
{if $smarty.get.tech ne "true"}
<tr class="tablehead" align="center">
<td width="25%">Escalated To Group</td>
<td width="25%">Escalated From Group</td>
<td width="50%" colspan="2">&nbsp;</td>
</tr>
<tr class="data" align="center">
<td width="25%">{$escto|default:"N/A"}</td>
<td width="25%">{$escfrom|default:"N/A"}</td>
<td width="50%" colspan="2" class="label">&nbsp;</td>
</tr>
{/if}
{closetable}
<!-- End reports/reports/totals.tpl -->


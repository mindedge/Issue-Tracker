<!-- Begin reports/report.tpl -->
{opentable}
{titlebar title=$report_title}
<tr>
<td class="data">
{if is_array($smarty.post.options)}
{if in_array("percat",$smarty.post.options)
or in_array("perprod",$smarty.post.options)
or in_array("perstat",$smarty.post.options)
or in_array("persev",$smarty.post.options)
or in_array("pertech",$smarty.post.options)}
{opentable}
{if $smarty.post.use_graphs eq "on"}
{include file="reports/reports/graphs.tpl"}
{else}
{include file="reports/reports/per_category.tpl"}
{include file="reports/reports/per_product.tpl"}
{include file="reports/reports/per_status.tpl"}
{include file="reports/reports/per_severity.tpl"}
{if $smarty.get.tech ne "true"}
{include file="reports/reports/per_technician.tpl"}
{/if}
{/if}
{closetable}
<br />
{/if}
{if in_array("avgclose",$smarty.post.options)
or in_array("maxclose",$smarty.post.options)
or in_array("avgfirst",$smarty.post.options)}
{include file="reports/reports/times.tpl"}
{/if}
{if in_array("numissues",$smarty.post.options)
or in_array("numhours",$smarty.post.options)
or in_array("numevents",$smarty.post.options)
or in_array("resolved",$smarty.post.options)
or in_array("unresolved",$smarty.post.options)
or in_array("escto",$smarty.post.options)
or in_array("escfrom",$smarty.post.options)}
{include file="reports/reports/totals.tpl"}
<br />
{/if}
{/if}
{if $smarty.post.display_issues eq "on" and is_array($issues)}
{include file="reports/reports/issues.tpl"}
{/if}
</td>
</tr>
{closetable}
<!-- End reports/report.tpl -->


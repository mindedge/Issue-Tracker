<!-- Begin reports/employee.tpl -->
{if empty($smarty.post.gid)}
<form method="post" action="?module=reports">
{opentable}
{titlebar colspan=2 title="Issue Tracker Reports"}
<tr>
<td class="label" width="20%" align="right" valign="top">Group:</td>
<td class="data" width="80%">
<select name="gid">
{foreach from=$smarty.session.groups item=gid}
<option value="{$gid}">{groupname id=$gid}</option>
{/foreach}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Report Options" /></td></tr>
{closetable}
</form>
{else}
<form method="post" action="?module=reports&action=generate">
<input type="hidden" name="gid" value="{$smarty.post.gid}" />
{opentable}
{titlebar title="Report Options"}
<tr>
<td class="label" valign="middle">
Date Range (Format: mm/dd/yyyy)<br />
<input type="checkbox" name="use_date"{if $smarty.post.use_date eq "on"} checked="checked"{/if} />Use Date Range
</td>
</tr>
<tr>
<td class="data">
{date_select name="sdate" value=$smarty.post.sdate}
 to 
{date_select name="edate" value=$smarty.post.edate}
</td>
</tr>
<tr>
<td class="label">
Issue Information<br />
<input type="checkbox" name="display_issues"{if $smarty.post.display_issues eq "on"} checked="checked"{/if} />Display Issues
&nbsp;
<input type="checkbox" name="show_events"{if $smarty.post.show_events eq "on"} checked="checked"{/if} />Show Events
</td>
</tr>
<tr>
<td class="data">
<table width="100%" cellpadding="2" cellspacing="0">
{php}$col = 0;{/php}
{foreach from=$fields key=field item=text}
{php}if ($col == 0) { print "<tr class=\"data\">\n"; }{/php}
<td width="25%" style="border: none;"><input type="checkbox" name="fields[]" value="{$field}"{if in_array($field,$smarty.post.fields)} checked="checked"{/if} />{$text}</td>
{php}$col++; if ($col == 4) { print "</tr>\n"; $col = 0; }{/php}
{/foreach}
</table>
</td>
</tr>
<tr>
<td class="label" valign="middle">
Options
{if defined($smarty.const._JPGRAPH_) and file_exists($smarty.const._JPGRAPH_)}
<br />
<input type="checkbox" name="use_graphs"{if $smarty.post.use_graphs eq "on"} checked="checked"{/if} />Use graphs where available
{/if}
</td>
</tr>
<tr>
<td class="data">
<table width="100%" cellpadding="2" cellspacing="0">
{php}$col = 0;{/php}
{foreach from=$options key=option item=text}
{php}if ($col == 0) { print "<tr class=\"data\">\n"; }{/php}
<td width="25%" style="border: none;"><input type="checkbox" name="options[]" value="{$option}"{if in_array($option,$smarty.post.options)} checked="checked"{/if} />{$text}</td>
{php}$col++; if ($col == 4) { print "</tr>\n"; $col = 0; }{/php}
{/foreach}
</table>
</td>
</tr>
<tr class="titlebar"><td><input type="submit" value="Generate Report" /></td></tr>
{closetable}
</form>
{/if}
<!-- End reports/employee.tpl -->


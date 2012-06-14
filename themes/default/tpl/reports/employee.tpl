<!-- Begin reports/employee.tpl -->
<form method="post" action="?module=reports&action=generate">
{opentable}
{titlebar title="Report Options"}
<tr><td class="label">Groups:</td></tr>
<tr>
<td class="data">
<select name="gid[]" size="10" multiple="multiple=" style="width: 99%;">
{foreach from=$groups item=gid}
<option value="{$gid}">{groupname id=$gid}</option>
{/foreach}
</select>
</td>
</tr>
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
&nbsp;
<input type="checkbox" name="hidepriv"{if $smarty.post.hidepriv eq "on"} checked="checked"{/if} />Hide Private
</td>
</tr>
<tr>
<td class="data">
<table width="100%" cellpadding="2" cellspacing="0">
{php}$col = 0;{/php}
{foreach from=$fields key=field item=text}
{php}if ($col == 0) { print "<tr class=\"data\">\n"; }{/php}
<td width="25%" style="border: none;"><input type="checkbox" name="fields[]" value="{$field}" />{$text}</td>
{php}$col++; if ($col == 4) { print "</tr>\n"; $col = 0; }{/php}
{/foreach}
</table>
</td>
</tr>
<tr>
<td class="label" valign="middle">
Options
{if defined("_JPGRAPH_") and file_exists($smarty.const._JPGRAPH_)}
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
{if is_array($smarty.post.options)}
<td width="25%" style="border: none;"><input type="checkbox" name="options[]" value="{$option}"{if in_array("$option",$smarty.post.options)} checked="checked"{/if} />{$text}</td>
{else}
<td width="25%" style="border: none;"><input type="checkbox" name="options[]" value="{$option}" />{$text}</td>
{/if}
{php}$col++; if ($col == 4) { print "</tr>\n"; $col = 0; }{/php}
{/foreach}
</table>
</td>
</tr>
<tr class="titlebar"><td><input type="submit" value="Generate Report" /></td></tr>
{closetable}
</form>
<!-- End reports/employee.tpl -->


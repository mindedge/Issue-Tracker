<!-- Being reports/manage.tpl -->
{if $smarty.get.subaction eq "delete"}
{opentable}
{titlebar colspan="2" title="Confirm Report Deletion"}
<tr class="label"><td colspan="2">Are you sure you want to delete this report?</td></tr>
<tr class="data">
<td width="50%" align="center">
<form method="post" action="?module=reports&action=manage&subaction=delete&rid={$smarty.get.rid}&confirm=true">
<input type="hidden" name="confirm" value="true" />
<input type="submit" value="Confirm" />
</form>
</td>
<td width="50%" align="center">
<form method="post" action="?module=reports&action=manage">
<input type="submit" value="Cancel" />
</form>
</td>
</tr>
{closetable}
{elseif $smarty.get.subaction eq "rename"}
<form method="post" action="?module=reports&action=manage&subaction=rename&rid={$smarty.get.rid}&confirm=true">
{opentable}
{titlebar colspan="2" title="Rename Report"}
<tr>
<td class="label" width="20%" align="right" valign="top">Report Name:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="32" name="reportname" value="{$name}" /></td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Rename Report" /></td></tr>
{closetable}
</form>
{else}
{opentable}
{titlebar colspan=4 title="Stored Reports"}
<tr class="tablehead">
<td>Name</td>
<td width="5%" align="center">Rename</td>
<td width="5%" align="center">View</td>
<td width="5%" align="center">Delete</td>
</tr>
{if is_array($reports)}
{foreach from=$reports item=report}
<tr class="data">
<td>{$report.name}</td>
<td width="5%" align="center"><a href="?module=reports&action=manage&subaction=rename&rid={$report.rid}"><img src="{$smarty.env.imgs.edit}" border="0" alt="Rename Report" /></a></td>
<td width="5%" align="center"><a href="?module=reports&action=generate&rid={$report.rid}"><img src="{$smarty.env.imgs.motd}" border="0" alt="View Report" /></a></td>
<td width="5%" align="center"><a href="?module=reports&action=manage&subaction=delete&rid={$report.rid}"><img src="{$smarty.env.imgs.delete}" border="0" alt="Delete Report" /></a></td>
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="4" align="center">You currently have no stored reports.</td></tr>
{/if}
{closetable}
{/if}
<!-- End reports/manage.tpl -->

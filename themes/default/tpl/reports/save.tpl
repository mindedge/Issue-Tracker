<!-- Begin reports/save.tpl -->
{if !empty($saved) and empty($smarty.get.rid)}
<form method="post" action="?module=reports&action=save">
<input type="hidden" name="saved" value='{$saved}' />
{opentable}
{titlebar colspan=2 title="Save Report Options"}
<tr>
<td width="20%" align="right" valign="top" class="label">Report Name:</td>
<td width="80%" class="data"><input type="text" size="32" maxlength="32" name="reportname" /></td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Save Report Options" /></td></tr>
{closetable}
<br />
{/if}
<!-- End reports/save.tpl -->

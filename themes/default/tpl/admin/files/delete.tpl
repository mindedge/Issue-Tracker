<!-- Begin admin/files/delete.tpl -->
{opentable}
{titlebar colspan=2 title="File Deletion"}
<tr class="label"><td colspan="2">Are you sure you want to delete this file from the system?</td></tr>
<tr class="data" align="center">
<td width="50%">
<form method="post" action="?module=admin&action=files&subaction=delete&fid={$smarty.get.fid}{if !empty($smarty.get.issueid)}&issueid={$smarty.get.issueid}{/if}">
<input type="hidden" name="confirm" value="true" />
<input type="submit" value="Confirm" />
</form>
</td>
<td width="50%">
{if !empty($smarty.get.issueid)}
<form method="post" action="?module=issues&action=files&issueid={$smarty.get.issueid}">
{else}
<form method="post" action="?module=admin&action=files">
{/if}
<input type="submit" value="Cancel" />
</form>
</td>
</tr>
{closetable}
<!-- End admin/files/delete.tpl -->


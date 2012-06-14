<!-- Begin admin/permissions/delete.tpl -->
{opentable}
{titlebar colspan=2 title="Delete Permission"}
<tr><td class="label" colspan="2">Are you sure you want to delete this permission?</td></tr>
<tr>
<td class="data" align="center">
<form method="post" action="?module=admin&action=permissions&subaction=delete&id={$smarty.get.id}">
<input type="hidden" name="confirm" value="true" />
<input type="submit" value="Confirm" />
</form>
</td>
<td class="data" align="center">
<form method="post" action="?module=admin&action=permissions">
<input type="submit" value="Cancel" />
</form>
</td>
</tr>
{closetable}
<!-- End admin/permissions/delete.tpl -->


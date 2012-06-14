<!-- Begin admin/statuses/delete.tpl -->
{opentable}
{titlebar colspan=2 title="Delete Status"}
<tr><td class="label" colspan="2">Are you sure you want to delete this status?</td></tr>
<tr>
<td class="data" align="center">
<form method="post" action="?module=admin&action=statuses&subaction=delete&id={$smarty.get.id}">
<input type="hidden" name="confirm" value="true" />
<input type="submit" value="Confirm" />
</form>
</td>
<td class="data" align="center">
<form method="post" action="?module=admin&action=statuses">
<input type="submit" value="Cancel" />
</form>
</td>
</tr>
{closetable}
<!-- End admin/statuses/delete.tpl -->


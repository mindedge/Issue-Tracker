<!-- Begin admin/products/delete.tpl -->
{opentable}
{titlebar colspan=2 title="Delete Product"}
<tr><td class="label" colspan="2">Are you sure you want to delete this product?</td></tr>
<tr>
<td class="data" align="center">
<form method="post" action="?module=admin&action=products&subaction=delete&id={$smarty.get.id}">
<input type="hidden" name="confirm" value="true" />
<input type="submit" value="Confirm" />
</form>
</td>
<td class="data" align="center">
<form method="post" action="?module=admin&action=products">
<input type="submit" value="Cancel" />
</form>
</td>
</tr>
{closetable}
<!-- End admin/products/delete.tpl -->


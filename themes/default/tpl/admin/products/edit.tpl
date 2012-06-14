<!-- Begin admin/products/edit.tpl -->
<form method="post" action="?module=admin&action=products&subaction=edit&id={$smarty.get.id}">
<input type="hidden" name="commit" value="true">
{opentable}
{titlebar colspan=2 title="Update Product"}
<tr>
<td width="20%" class="label" align="right" valign="top">Product:</td>
<td width="80%" class="data"><input type="text" size="32" name="product" value="{$product|stripslashes}"></td>
</tr>
<tr><td class="titlebar" colspan="2"><input type="submit" value="Update Product"></td></tr>
{closetable}
</form>
<!-- End admin/products/edit.tpl -->


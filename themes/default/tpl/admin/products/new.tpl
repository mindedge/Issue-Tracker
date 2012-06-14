<!-- Begin admin/products/new.tpl -->
<form method="post" action="?module=admin&action=products&subaction=new">
<input type="hidden" name="commit" value="true">
{opentable}
{titlebar colspan=2 title="New Product"}
<tr>
<td width="20%" class="label" align="right" valign="top">New Product:</td>
<td width="80%" class="data"><input type="text" size="32" name="product" value="{$smarty.post.product|stripslashes}"></td>
</tr>
<tr><td class="titlebar" colspan="2"><input type="submit" value="Create Product"></td></tr>
{closetable}
</form>
<!-- End admin/products/new.tpl -->


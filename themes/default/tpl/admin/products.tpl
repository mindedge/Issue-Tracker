<!-- Begin admin/products.tpl -->
{opentable}
{titlebar colspan=4 title="Products"}
<tr class="tablehead" align="center">
<td width="5%">ID</td>
<td align="left">Product</td>
<td width="5%">Edit</td>
<td width="5%">Delete</td>
</tr>
{if is_array($products)}
{foreach from=$products item=product}
{php}$class = rowcolor();{/php}
<tr class="{php}print $class;{/php}" align="center">
<td width="5%">{$product.pid}</td>
<td align="left">{$product.product}</td>
<td width="5%"><a href="?module=admin&action=products&subaction=edit&id={$product.pid}"><img src="{$smarty.env.imgs.edit}" width="16" height="16" border="0" alt="Edit" /></a></td>
<td width="5%"><a href="?module=admin&action=products&subaction=delete&id={$product.pid}"><img src="{$smarty.env.imgs.delete}" width="16" height="16" border="0" alt="Delete" /></a></td>
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="4">No defined products.</td></tr>
{/if}
{closetable}
<!-- End admin/products.tpl -->


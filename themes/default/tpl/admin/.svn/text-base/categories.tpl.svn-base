<!-- Begin admin/categories.tpl -->
{opentable}
{titlebar colspan=4 title="Categories"}
<tr class="tablehead" align="center">
<td width="5%">ID</td>
<td align="left">Category</td>
<td width="5%">Edit</td>
<td width="5%">Delete</td>
</tr>
{if is_array($categories)}
{foreach from=$categories item=category}
{php}$class = rowcolor();{/php}
<tr class="{php}print $class;{/php}" align="center">
<td width="5%">{$category.cid}</td>
<td align="left">{$category.category}</td>
<td width="5%"><a href="?module=admin&action=categories&subaction=edit&id={$category.cid}"><img src="{$smarty.env.imgs.edit}" width="16" height="16" border="0" alt="Edit" /></a></td>
<td width="5%"><a href="?module=admin&action=categories&subaction=delete&id={$category.cid}"><img src="{$smarty.env.imgs.delete}" width="16" height="16" border="0" alt="Delete" /></a></td>
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="4">No defined categories.</td></tr>
{/if}
{closetable}
<!-- End admin/categories.tpl -->


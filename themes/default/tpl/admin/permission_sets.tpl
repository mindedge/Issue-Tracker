<!-- Begin admin/permission_sets.tpl -->
{opentable}
{titlebar colspan=3 title="Permission Sets"}
<tr class="tablehead">
<td>Name/Description</td>
<td width="30%" colspan="2">Permissions</td>
</tr>
{foreach from=$psets item=pset}
<tr>
<td class="label">{$pset.name}</td>
<td class="label" colspan="2">
{if $pset.system ne "t"}
<b>[</b> <img src="{$smarty.env.imgs.edit}" width="16" height="16" border="0" alt="Edit" /><a href="?module=admin&action=permission_sets&subaction=edit&setid={$pset.permsetid}">Edit Set</a> <b>]</b>
&nbsp;|&nbsp;
<b>[</b> <img src="{$smarty.env.imgs.delete}" width="16" height="16" border="0" alt="Delete" /><a href="?module=admin&action=permission_sets&subaction=delete&setid={$pset.permsetid}">Delete Set</a> <b>]</b>
{/if}
</td>
</tr>
<tr class="data">
<td  rowspan="{$rowspan}">{$pset.description}</td>
{php}$first = TRUE;{/php}
{foreach from=$perms item=perm}
{php}
if ($first != TRUE) {
{/php}
<tr class="data">
{php}
}
$first = FALSE;
{/php}
<td width="25%">{$perm}</td>
<td width="5%" align="center">
{if in_array($perm,$pset.permissions)}
<img src="{$smarty.env.imgs.ok}" width="16" height="16" border="0" />
{else}
<img src="{$smarty.env.imgs.no}" width="16" height="16" border="0" />
{/if}
</td>
</tr>
{/foreach}
{/foreach}
{closetable}
<!-- End admin/permission_sets.tpl -->


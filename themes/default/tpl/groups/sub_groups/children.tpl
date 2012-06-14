<!-- Begin groups/sub_groups/children.tpl -->
{opentable}
{titlebar colspan=8 title="Sub Group Propagation"}
<tr class="tablehead" align="center">
<td align="left">Sub Group</td>
<td width="10%">Users</td>
<td width="10%">Categories</td>
<td width="10%">Products</td>
<td width="10%">Statuses</td>
<td width="10%">Announcements</td>
<td width="10%">Issues</td>
<td width="10%">Remove</td>
</tr>
{if is_array($children)}
{foreach from=$children item=child}
<tr class="data" align="center">
<td align="left">{$child.name}</td>
{foreach from=$props item=prop}
<td width="10%">
<a href="?module=groups&action=edit_sub_groups&do=toggle_child&gid={$smarty.get.gid}&child={$child.child_gid}&prop={$prop}">
{if $child.$prop eq "t"}
<img src="{$smarty.env.imgs.ok}" width="16" height="16" border="0" alt="Enabled" />
{else}
<img src="{$smarty.env.imgs.no}" width="16" height="16" border="0" alt="Disabled" />
{/if}
</a>
</td>
{/foreach}
<td width="10%"><a href="?module=groups&action=edit_sub_groups&do=remove&gid={$smarty.get.gid}&child={$child.child_gid}"><img src="{$smarty.env.imgs.delete}" width="16" height="16" border="0" alt="Remove" /></a></td>
</tr>
{/foreach}
{else}
<tr class="data" align="center"><td colspan="8">No sub groups to display.</td></tr>
{/if}
{closetable}
<br />
<!-- End groups/sub_groups/children.tpl -->


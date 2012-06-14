<!-- Begin groups/sub_groups/group.tpl -->
{opentable}
{titlebar colspan=6 title=$name}
<tr class="tablehead" align="center">
<td width="15%">Users</td>
<td width="15%">Categories</td>
<td width="15%">Products</td>
<td width="15%">Statuses</td>
<td width="15%">Announcements</td>
<td width="15%">Issues</td>
</tr>
<tr class="data" align="center">
{foreach from=$props item=prop}
<td width="15%">
<a href="?module=groups&action=edit_sub_groups&do=toggle_parent&gid={$smarty.get.gid}&prop={$prop}">
{if $current.$prop eq "t"}
<img src="{$smarty.env.imgs.ok}" width="16" height="16" border="0" alt="Enabled" />
{else}
<img src="{$smarty.env.imgs.no}" width="16" height="16" border="0" alt="Disabled" />
{/if}
</a>
</td>
{/foreach}
</tr>
{closetable}
<br />
<!-- End groups/sub_groups/group.tpl -->


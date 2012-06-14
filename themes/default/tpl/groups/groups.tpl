<!-- Begin groups/groups.tpl -->
{opentable}
{titlebar colspan=3 title="Groups"}
<tr class="subtitle">
<td colspan="3" align="center">
{alphalist url="?module=groups"}
</td>
</tr>
<tr class="tablehead">
<td colspan="3" align="center">
<form method="post" action="?module=groups&search=true">
Group Search:
<input type="text" size="16" name="criteria" value="{$smarty.post.criteria}" />
<input type="submit" value="Search" />
<br />
<b>Note:</b> SQL wildcards accepted
</form>
</td>
</tr>
<tr class="tablehead">
<td>Name</td>
<td align="center" width="5%">Edit</td>
<td align="center" width="5%">Active</td>
</tr>
{foreach from=$groups item=group}
<tr class="{rowcolor}">
<td valign="top"><a href="?module=groups&action=view&gid={$group.gid}">{$group.name}</a></td>
<td align="center" width="5%"><a href="?module=groups&action=view&gid={$group.gid}"><img src="{$smarty.env.imgs.edit}" width="16" height="16" border="0" alt="Edit Group" /></a></td>
<td align="center" width="5%">
{if $group.active eq "t"}
<a href="?module=groups&gid={$group.gid}&active=f&start={$smarty.get.start}"><img src="{$smarty.env.imgs.ok}" width="16" height="16" border="0" alt="Active" /></a>
{else}
<a href="?module=groups&gid={$group.gid}&active=t&start={$smarty.get.start}"><img src="{$smarty.env.imgs.no}" width="16" height="16" border="0" alt="Inactive" /></a>
{/if}
</td>
</tr>
{/foreach}
{closetable}
<!-- End groups/groups.tpl -->


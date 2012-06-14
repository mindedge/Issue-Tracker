<!-- Begin issues/choose.tpl -->
{opentable}
{titlebar colspan=4 title="Choose Group"}
{if is_manager($smarty.session.userid) or count($smarty.session.groups) > 1}
<tr class="tablehead">
<td colspan="4" align="center">
{alphalist url="?module=issues&action=choose"}
</td>
</tr>
{/if}
<tr class="tablehead" align="center">
<td align="left">Group Name</td>
<td width="5%">New</td>
<td width="5%">Open</td>
<td width="40%">Last Activity</td>
</tr>
{if is_array($groups)}
{foreach from=$groups item=group}
{if show_group($group.gid)}
<tr class="{rowcolor}" align="center">
<td align="left"><a href="?module=issues&action=group&gid={$group.gid}">{$group.name|stripslashes}</a></td>
<td width="5%">{$group.new}</td>
<td width="5%">{$group.open}</td>
<td align="left" width="40%">{$group.date}{if !empty($group.user)} by {$group.user}{/if}</td>
</tr>
{/if}
{/foreach}
{else}
<tr class="data"><td colspan="4" align="center">No groups to choose from.</td></tr>
{/if}
{closetable}
<!-- End issues/choose.tpl -->


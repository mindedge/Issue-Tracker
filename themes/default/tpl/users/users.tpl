<!-- Begin users/users.tpl -->
{opentable}
{titlebar colspan=6 title="Users"}
<tr><td class="subtitle" colspan="6" align="center">{alphalist url="?module=users"}</td></tr>
<tr>
<td class="tablehead" colspan="6" align="center">
<span class="noprint">
<form method="post" action="?module=users&search=true">
User Search:
<input type="text" size="16" name="criteria" value="{$smarty.post.criteria}" />
<input type="submit" value="Search Users" />
<br />
<input type="checkbox" name="username"{if $smarty.post.username eq "on"} checked="checked"{/if} />Username&nbsp;
<input type="checkbox" name="firstname"{if $smarty.post.firstname eq "on"} checked="checked"{/if} />First Name&nbsp;
<input type="checkbox" name="lastname"{if $smarty.post.lastname eq "on"} checked="checked"{/if} />Last Name&nbsp;
<input type="checkbox" name="email"{if $smarty.post.email eq "on"} checked="checked"{/if} />Email
<br />
<b>Note:</b> SQL wildcards accepted.
</form>
</span>
</td>
</tr>
<tr class="tablehead">
<td>Username</td>
<td>Last Name</td>
<td>First Name</td>
<td>Email Address</td>
<td align="center" width="5%">Edit</td>
<td align="center" width="5%">Active</td>
</tr>
{if is_array($users)}
{foreach from=$users item=user}
<tr class="{rowcolor}">
<td width="20%"><a href="?module=users&action=view&uid={$user.userid}">{$user.username}</a></td>
<td width="20%">{$user.last_name}</td>
<td width="20%">{$user.first_name}</td>
<td width="35%">{$user.email}</td>
<td align="center" width="5%"><a href="?module=users&action=view&uid={$user.userid}"><img src="{$smarty.env.imgs.edit}" width="16" height="16" border="0" alt="Edit User" /></a></td>
<td align="center" width="5%">
{if $user.active eq "t"}
<a href="?module=users&uid={$user.userid}&active=f"><img src="{$smarty.env.imgs.ok}" width="16" height="16" border="0" alt="Active" /></a>
{else}
<a href="?module=users&uid={$user.userid}&active=t"><img src="{$smarty.env.imgs.no}" width="16" height="16" border="0" alt="Inactive" /></a>
{/if}
</td>
</tr>
{/foreach}
{else}
<tr class="data"><td colspan="6">No users retrieved from database.</td></tr>
{/if}
{closetable}
<!-- End users/users.tpl -->


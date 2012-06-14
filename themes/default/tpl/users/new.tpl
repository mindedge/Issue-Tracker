<!-- Begin users/new.tpl -->
<form method="post" action="?module=users&action=new">
{opentable}
{php}$colspan = is_admin($_SESSION['userid']) ? 6 : 4;{/php}
<tr><td class="titlebar" colspan="{php}print $colspan;{/php}">User Creation</td></tr>
<tr class="tablehead">
<td width="10%">Username</td>
<td>First Name</td>
<td>Last Name</td>
<td width="20%">Email Address</td>
{if is_admin($smarty.session.userid)}
<td width="10%" align="center">Admin</td>
<td width="10%" align="center">Employee</td>
{/if}
</tr>
{php}for ($x = 1;$x < 11;$x++) {{/php}
<tr class="data">
<td width="10%"><input type="text" size="16" maxlength="32" name="username{php}print $x;{/php}" /></td>
<td width="10%"><input type="text" size="16" maxlength="32" name="first{php}print $x;{/php}" /></td>
<td width="10%"><input type="text" size="16" maxlength="32" name="last{php}print $x;{/php}" /></td>
<td width="20%"><input type="text" size="32" maxlength="64" name="email{php}print $x;{/php}" /></td>
{if is_admin($smarty.session.userid)}
<td width="10%" align="center"><input type="checkbox" name="admin{php}print $x;{/php}" /></td>
<td width="10%" align="center"><input type="checkbox" name="emp{php}print $x;{/php}" /></td>
{/if}
</tr>
{php}}{/php}
<tr class="titlebar">
<td colspan="{php}print $colspan;{/php}"><input type="submit" value="Create Users" /></td>
</tr>
{closetable}
</form>
<!-- End users/new.tpl -->


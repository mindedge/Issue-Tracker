<!-- Begin login.tpl -->
<td width="20%">
<br />
{if is_array($smarty.session.errors)}
{if count($smarty.session.errors) > 0}
{include file="errors.tpl"}
{/if}
{/if}
{if $smarty.get.forgotten_password eq "true"}
<form method="post" action="?module=public&action=forgotten_password&send=true&forgotten_password=true">
<table width="98%" align="center" border="0" cellpadding="2" cellspacing="0" bgcolor="#cccccc" style="border: 1px solid black;">
{titlebar colspan=2 title="Forgotten Password Form"}
<tr>
<td width="60%" align="right" valign="top">Username:</td>
<td width="40%"><input type="text" size="16" name="username" /></td>
</tr>
<tr>
<td width="60%" align="right" valign="top">Email:</td>
<td width="40%"><input type="text" size="16" name="email" /></td>
</tr>
<tr><td colspan="2" align="center"><input type="submit" value="Send Password" /></td></tr>
</table>
</form>
<br />
</td>
<td width="80%" style="margin: 4px; padding: 4px;"><br />{$motd}</td>
{elseif $smarty.get.register eq "true" and $allow_register eq TRUE}
<form method="post" action="?module=public&action=register&create=true&register=true">
<table width="98%" align="center" class="login" border="0" cellpadding="2" cellspacing="0">
{titlebar colspan=2 title="Account Registration"}
<tr>
<td width="60%" align="right" valign="top">Username:</td>
<td width="40%"><input type="text" size="16" name="username" value="{$smarty.post.username}" /></td>
</tr>
<tr>
<td width="60%" align="right" valign="top">Email:</td>
<td width="40%"><input type="text" size="16" name="email" value="{$smarty.post.email}" /></td>
</tr>
<tr>
<td width="60%" align="right" valign="top">First Name:</td>
<td width="40%"><input type="text" size="16" name="firstname" value="{$smarty.post.firstname}" /></td>
</tr>
<tr>
<td width="60%" align="right" valign="top">Last Name:</td>
<td width="40%"><input type="text" size="16" name="lastname" value="{$smarty.post.lastname}" /></td>
</tr>
<tr><td colspan="2" align="center"><input type="submit" value="Create Account" /></td></tr>
</table>
</form>
<br />
</td>
<td width="80%" style="margin: 4px; padding: 4px;"><br />{$motd}</td>
{else}
<form method="post" name="loginForm" action="{$smarty.const._URL_}">
<input type="hidden" name="request" value="{$smarty.server.QUERY_STRING}" />
<!-- Check if Javascript is enabled -->
<script language="JavaScript" type="text/javascript">
document.write('<input type="hidden" name="javascript" value="enabled">');
</script>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="login">
<tr>
<td colspan="2" class="titlebar" style="border-bottom: 1px solid black;">Issue Tracker Login</td>
</tr>
<tr>
<td width="60%" align="right">Username:</td>
<td width="40%"><input type="text" size="16" name="username" /></td>
</tr>
<tr>
<td width="60%" align="right">Password:</td>
<td width="40%"><input type="password" size="16" name="password" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" value="Login"/></td>
</tr>
<tr>
<td colspan="2" align="center">
<br />
{if $allow_register eq TRUE}
<a href="?register=true">Register New Account</a><br />
{/if}
<a href="?forgotten_password=true">Forgot your password? Click Here.</a>
</td>
</tr>
</table>
</form>
<br />
</td>
<td width="80%" style="margin: 4px; padding; 4px;"><br />{$motd}</td>
{/if}

<script language="JavaScript" type="text/javascript">
document.forms[0].username.focus();//focus the first field MWarner 4/6/2010
</script>
<!-- End login.tpl -->


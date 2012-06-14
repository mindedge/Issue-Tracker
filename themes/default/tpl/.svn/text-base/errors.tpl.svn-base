{php}
if (count($_SESSION['errors']) > 0) {
{/php}
<!-- Begin errors.tpl -->
<table width="98%" class="borders" cellpadding="2" cellspacing="0" border="0" align="center">
<tr><td class="titlebar">Messages</td></tr>
<tr>
<td class="error" align="center">
{php}
foreach ($_SESSION['errors'] as $error) {
print $error."<br />";
}
{/php}
</td>
</tr>
</table>
<br />
<!-- End errors.tpl -->
{php}
$_SESSION['errors'] = array();
}
{/php}


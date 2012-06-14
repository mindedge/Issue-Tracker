<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!-- Begin header.tpl -->
<html>
<head>
<title>{$title}</title>
{if preg_match("/MSIE/",$smarty.server.HTTP_USER_AGENT)}
<link rel="stylesheet" type="text/css" href="themes/default/ie.css" />
{/if}
{if $smarty.get.print eq "true"}
<link rel="stylesheet" type="text/css" href="css/print.css" />
{else}
<link rel="stylesheet" type="text/css" media="print" href="css/print.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/{$cssfile}" />
{/if}
{include file="javascript.tpl"}
</head>
{if !empty($smarty.session.userid)}
<body marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" onLoad="loader(); return true;" onUnLoad="unloader(); return true;">
{else}
<body marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">
{/if}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="header" align="left" width="80%"><img src="{$smarty.env.imgs.logo}" alt="Issue Tracker" /></td>
<td class="header" align="center" width="20%">
<!-- changed is_employee to is_admin, so regular employees cannot do admin stuff MWarner 2/1/2010 -->
{if !empty($smarty.session.userid)}
{if (is_admin($smarty.session.userid)
or permission_check("status_manager")
or permission_check("category_manager")
or permission_check("product_manager"))
and $smarty.get.module != "help"}
<a href="?module=admin"><img src="{$smarty.env.imgs.system}" alt="Administration" border="0" />Administration</a>
{else}
&nbsp;
{/if}
{/if}
</td>
</tr>
{if !empty($smarty.session.userid)}
<tr>
{if preg_match("/(4.7)|(4.8)/",$smarty.server.HTTP_USER_AGENT)}
<td class="crumb" width="50%">&nbsp;</td>
{else}
<td class="crumb" width="50%"> .:{$crumbs}</td>
{/if}
{if $smarty.get.module ne "help"}
<td class="crumb" align="right" valign="top" width="50%">
<form method="post" action="?module=issues&action=view">
<input type="text" size="6" name="issueid" /><input type="submit" value="View Issue" />
</form>
</td>
{else}
<td class="crumb" align="right" width="50%">&nbsp;</td>
{/if}
</tr>
{/if}
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<!-- End header.tpl -->


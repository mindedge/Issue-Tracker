<!-- Begin prefs/prefs.tpl -->
<form method="post" action="?module=prefs&update=true">
{opentable}
{titlebar colspan=2 title="Preferences"}
<tr>
<td class="label" width="20%" align="right" valign="top">First Name:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="32" name="first" value="{$user.first_name}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Last Name:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="32" name="last" value="{$user.last_name}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Address:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="address" value="{$user.address}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">&nbsp;</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="address2" value="{$user.address2}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Phone Number:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="32" name="phone" value="{$user.telephone}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Email:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="email" value="{$user.email}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">SMS:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="sms" value="{$user.sms}" /></td>
</tr>
{titlebar colspan=2 title="Change Password"}
<tr>
<td class="label" width="20%" align="right" valign="top">Old Password:</td>
<td class="data" width="80%"><input type="password" size="32" maxlength="32" name="oldpass" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">New Password:</td>
<td class="data" width="80%"><input type="password" size="32" maxlength="32" name="newpass" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Confirm Password:</td>
<td class="data" width="80%"><input type="password" size="32" maxlength="32" name="confirm" /></td>
</tr>
{titlebar colspan=2 title="Personal Menu"}
<tr class="tablehead">
<td>Text</td>
<td>Link</td>
</tr>
{if is_array($menu_items)}
{foreach from=$menu_items item=menu}
<tr class="data">
<td>{$menu.text}</td>
<td>{$menu.url} <a href="?module=prefs&mid={$menu.mid}"><img src="{$smarty.env.imgs.delete}" width="16" height="16" border="0" alt="Remove" /></a></td>
</tr>
{/foreach}
{/if}
<tr class="data">
<td><input type="text" size="16" name="new_text" style="width: 98%;" /></td>
<td><input type="text" size="32" name="new_link" style="width: 98%;" /></td>
</tr>
{titlebar colspan=2 title="General"}
<tr>
<td class="label" width="20%" align="right" valign="top">Word Wrap:</td>
<td class="data" width="80%">
<input type="text" size="4" name="wrap" value="{$smarty.session.prefs.word_wrap}" />
<b>Note:</b> If left blank or set to 0, the default of 80 characters will be used.
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Disable Word Wrap:</td>
<td class="data" width="80%"><input type="checkbox" name="disablewrap"{if $smarty.session.prefs.disable_wrap eq "t" or $smarty.post.disablewrap eq "on"} checked="checked"{/if} /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Date Format:</td>
<td class="data" width="80%">
<select name="dformat">
<option value="m/d/Y"{if $smarty.session.prefs.date_format eq "m/d/Y"} selected="selected"{/if}>US (mm/dd/yyyy)</option>
<option value="d/m/Y"{if $smarty.session.prefs.date_format eq "d/m/Y"} selected="selected"{/if}>European (dd/mm/yyyy)</option>
<option value="Y/m/d"{if $smarty.session.prefs.date_format eq "Y/m/d"} selected="selected"{/if}>International (yyyy/mm/dd)</option>
</select>
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Use Local Timezone:</td>
<td class="data" width="80%"><input type="checkbox" name="localtz"{if $smarty.session.prefs.local_tz eq "t"} checked="checked"{/if} /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Session Timeout Warnings:</td>
<td class="data" width="80%"><input type="checkbox" name="sesstimeout"{if $smarty.session.prefs.session_timeout eq "t"} checked="checked"{/if} /></td>
</tr>
{titlebar colspan=2 title="Issue Listing"}
<tr class="data">
<td class="label" width="20%" align="right" valign="top">Show Fields:</td>
<td class="data" width="80%">
<table width="100%" cellpadding="2" cellspacing="0">
{php}$col = 0;{/php}
{foreach from=$issue_fields item=field}
{php}if ($col == 0) { print "<tr class=\"data\">\n"; }{/php}
<td width="25%" style="border: none;">
<input type="checkbox" name="fields[]" value="{$field.field}"{if in_array($field.field,$smarty.session.prefs.show_fields)} checked="checked"{/if} />
{$field.name}
</td>
{php}$col++; if ($col == 4) { print "</tr>\n"; $col = 0; }{/php}
{/foreach}
</table>
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Sort By:</td>
<td class="data" width="80%">
<select name="sort_by">
{foreach from=$issue_fields item=field}
{if $field.field ne "flags"}
<option value="{$field.field}"{if $field.field eq $smarty.session.prefs.sort_by} selected="selected"{/if}>{$field.name}</option>
{/if}
{/foreach}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Update Preferences" /></td></tr>
{closetable}
</form>
<!-- End prefs/prefs.tpl -->


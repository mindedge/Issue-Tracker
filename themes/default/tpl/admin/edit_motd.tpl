<!-- Begin admin/edit_motd.tpl -->
<form method="post" action="?module=admin&action=edit_motd">
{opentable}
{titlebar title="Edit Message of the Day"}
<tr>
<td class="data" align="center">
<textarea rows="20" cols="60" name="motd" style="width: 99%;">{$motd|stripslashes}</textarea>
</td>
</tr>
<tr><td class="titlebar"><input type="submit" value="Update MOTD"></td></tr>
{closetable}
</form>
<!-- End admin/edit_motd.tpl -->


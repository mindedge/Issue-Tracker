<!-- Begin announce/new.tpl -->
<span class="noprint">
<form method="post" action="?module=announce&action=new">
{opentable}
{titlebar colspan=2 title="New Announcement"}
<tr>
<td class="label" valign="top" align="right" width="20%">Title:</td>
<td class="data" width="80%"><input type="text" size="64" name="new_title" value="{$smarty.post.new_title|stripslashes}" /></td>
</tr>
<tr>
<td class="label" valign="top" align="right" width="20%">Announcement:</td>
<td class="data" width="80%" align="center"><textarea rows="10" cols="60" name="new_text" style="width: 99%;">{$smarty.post.new_text|stripslashes}</textarea></td>
</tr>
<tr>
<td class="label" valign="top" align="right" width="20%">Groups:</td>
<td class="data" width="80%">
<select name="groups[]" size="5" multiple="multiple">
{if is_admin($smarty.session.userid)}
<option value="GLOBAL">System Announcement</option>
{/if}
{foreach from=$smarty.session.groups item=gid}
{if permission_check("create_announcements",$gid)}
<option value="{$gid}">{groupname id=$gid}</option>
{/if}
{/foreach}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Create Announcement" /></td></tr>
{closetable}
</form>
</span>
<!-- End announce/new.tpl -->


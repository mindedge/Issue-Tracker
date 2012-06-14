<!-- Begin admin/statuses/new.tpl -->
<form method="post" action="?module=admin&action=statuses&subaction=new">
<input type="hidden" name="commit" value="true">
{opentable}
{titlebar colspan=2 title="New Status"}
<tr>
<td width="20%" class="label" align="right" valign="top">New Status:</td>
<td width="80%" class="data"><input type="text" size="32" name="status" value="{$smarty.post.status|stripslashes}"></td>
</tr>
<tr>
<td width="20%" class="label" align="right" valign="top">Status Type:</td>
<td width="80%" class="data">
<select name="status_type">
{foreach from=$status_types key=id item=type}
<option value="{$id}">{$type}</option>
{/foreach}
</select>
</td>
</tr>
<tr><td class="titlebar" colspan="2"><input type="submit" value="Create Status"></td></tr>
{closetable}
</form>
<!-- End admin/statuses/new.tpl -->


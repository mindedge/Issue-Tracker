<!-- Begin issues/choose_new.tpl -->
<form method="post" action="?module=issues&action=new{if !empty($smarty.get.icopy)}&icopy={$smarty.get.icopy}{/if}">
{opentable}
{titlebar colspan=2 title="Choose Group"}
<tr>
<td class="label" width="20%" align="right" valign="top">Group:</td>
<td class="data" width="80%">
<select name="gid">
{foreach from=$smarty.session.groups item=group}
{if permission_check("create_issues",$group)}
<option value="{$group}">{groupname id=$group}</option>
{/if}
{/foreach}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Create Issue" /></td></tr>
{closetable}
</form>
<!-- End issues/choose_new.tpl -->


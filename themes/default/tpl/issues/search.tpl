<!-- Begin issues/search.tpl -->
<form method="post" name="searchForm" action="?module=issues&action=search_results">
<input type="hidden" name="submit" value="true" />
{opentable}
{titlebar colspan=4 title="Issue Search"}
<tr>
<td class="label" width="25%" align="right" valign="top">Search String:</td>
<td class="data" colspan="3" width="75%"><input type="text" size="32" name="criteria" style="width: 99%;" /></td>
</tr>
{if $smarty.get.advanced eq "true"}
<tr>
<td class="label" width="25%" align="right" valign="top">Group(s):</td>
<td class="data" colspan="3" width="75%">
<select name="groups[]" size="10" multiple="multiple" style="width: 99%;">
{if is_array($ugroups)}
{foreach from=$ugroups item=gid}
<option value="{$gid}">{groupname id=$gid}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr>
<td class="label" width="25%" align="right" valign="top">Opened By:</td>
<td class="data" width="25%">
<select name="opened[]" size="10" multiple="multiple" style="width: 99%;">
{if is_array($users)}
{foreach from=$users key=userid item=username}
<option value="{$userid}">{$username}</option>
{/foreach}
{/if}
</select>
</td>
<td class="label" width="25%" align="right" valign="top">Assigned To:</td>
<td class="data" width="25%">
<select name="assigned[]" size="10" multiple="multiple" style="width: 99%;">
{if is_array($users)}
{foreach from=$users key=userid item=username}
<option value="{$userid}">{$username}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr>
<td class="label" width="25%" align="right" valign="top">Status:</td>
<td class="data" width="25%">
<select name="status[]" size="10" multiple="multiple" style="width: 99%;">
{if is_array($statuses)}
{foreach from=$statuses key=sid item=status}
<option value="{$sid}">{$status}</option>
{/foreach}
{/if}
</select>
</td>
<td class="label" width="25%" align="right" valign="top">Category:</td>
<td class="data" width="25%">
<select name="category[]" size="10" multiple="multiple" style="width: 99%;">
{if is_array($categories)}
{foreach from=$categories key=cid item=category}
<option value="{$cid}">{$category}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr>
<td class="label" width="25%" align="right" valign="top">Product:</td>
<td class="data" width="75%" colspan="3">
<select name="product[]" size="10" multiple="multiple" style="width: 99%;">
{if is_array($products)}
{foreach from=$products key=pid item=product}
<option value="{$pid}">{$product}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
{/if}
<tr class="titlebar"><td colspan="4"><input type="submit" value="Search Issues" /></td></tr>
{closetable}
</form>
<script language="JavaScript" type="text/javascript">
document.forms["searchForm"].criteria.focus();//focus the first field MWarner 4/6/2010
</script>
<!-- End issues/search.tpl -->


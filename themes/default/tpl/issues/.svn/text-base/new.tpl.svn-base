<!-- Begin issues/new.tpl -->
<form method="post" name="issueForm" action="?module=issues&action=new&gid={$smarty.get.gid}" enctype="multipart/form-data">
{opentable}
{titlebar colspan=2 title="New Issue"}
{if group_over_limit($smarty.get.gid,"issues")}
<tr class="data" align="center"><td colspan="2">This group has reached their limit for number of issues.  Please contact the group administrator.</td></tr>
{else}
<tr>
<td class="label" width="20%" align="right" valign="top"><span class="required">*</span> Summary:</td>
<td class="data" width="80%"><input type="text" size="60" maxlength="250" name="summary" value="{$smarty.post.summary|replace:"\"":"'"|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top"><span class="required">*</span> Problem:</td>
<td class="data" width="80%"><textarea cols="60" rows="10" name="problem">{$smarty.post.problem|stripslashes}</textarea></td>
</tr>
{if is_employee($smarty.session.userid)}
<tr>
<td class="label" width="20%" align="right" valign="top">Due Date:</td>
<td class="data" width="80%">{date_select name="duedate" value=$smarty.post.duedate}</td>
</tr>
{/if}
<tr>
<td class="label" width="20%" align="right" valign="top"><span class="required">*</span> Product:</td>
<td class="data" width="80%">
<select name="product">
<option value="">(Choose Product)</option>
{if is_array($products)}
{php}asort($this->_tpl_vars['products']);//sort by product name, not ID MWarner 2/1/2010{/php}
{foreach from=$products key=pid item=product}
<option value="{$pid}"{if $pid eq $smarty.post.product or count($products) == 1} selected="selected"{/if}>{$product}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr>{php}//show assign to here MWarner 2/3/2010{/php}
<td class="label" width="20%" align="right" valign="top"><span class="required">*</span> Assign To:</td>
<td class="data" width="80%">
<select name="assign" style="width: 25%;">
<option value="">(No User Assigned)</option>
{if is_array($members)}
{foreach from=$members key=userid item=username}
<option value="{$userid}"{if $smarty.post.assign eq $userid} selected="selected"{/if}>{$username}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top"><span class="required">*</span> Severity:</td>
<td class="data" width="80%">{php}//changed selected="selected" to checked here MWarner 2/8/2010{/php}
<input type="radio" name="severity" value="4"{if $smarty.post.severity eq 4} checked{/if} />(Low)&nbsp;
<input type="radio" name="severity" value="3"{if $smarty.post.severity eq 3} checked{/if} />(Normal)&nbsp;
<input type="radio" name="severity" value="2"{if $smarty.post.severity eq 2} checked{/if} />(High)&nbsp;
<input type="radio" name="severity" value="1"{if $smarty.post.severity eq 1} checked{/if} />(Urgent)&nbsp;
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Notify:</td>
<td class="data" width="80%">
<select name="notify[]" size="5" multiple="multiple">
{if is_array($members)}
{foreach from=$members key=userid item=username}
<option value="{$userid}">{$username}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
{if permission_check("view_private",$smarty.get.gid)}
<tr>
<td class="label" width="20%" align="right" valign="top">Private:</td>
<td class="data" width="80%"><input type="checkbox" name="private"{if $smarty.post.private eq "on"} checked="checked"{/if} /></td>
</tr>
{/if}
{if permission_check("upload_files",$smarty.get.gid)}
<tr>
<td class="label" width="20%" align="right" valign="top">File:</td>
<td class="data" width="80%"><input type="file" name="upload" /></td>
</tr>
{/if}
<tr>{php}//add categories here, but need to handle the array output differently than in new_event.tpl for some reason MWarner 2/4/2010 {/php}
<td class="label" width="20%" align="right" valign="top">Category:</td>
<td class="data" width="80%">
<select name="cat" style="width: 25%;">
<option value="">(Category Not Set)</option>
{if is_array($categories)}
{foreach from=$categories key=cid item=category}
<option value="{$category.cid}"{if $category.cid eq $issue.category} selected="selected"{/if}>{$category.category}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" name="create" value="Create Issue" /></td></tr>
{/if}
{closetable}
</form>
<script language="JavaScript" type="text/javascript">
document.forms["issueForm"].summary.focus();//focus the first field MWarner 4/6/2010
</script>
<div style="text-align: left; margin: 4px;"><span class="required">*</span> Denotes required field</div>
<!-- End issues/new.tpl -->


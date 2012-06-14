<!-- Begin groups/edit_info.tpl -->
<form method="post" action="?module=groups&action=edit_info&gid={$smarty.get.gid}&submit=true">
{opentable}
{titlebar colspan=2 title="Group Information"}
<tr>
<td class="label" width="20%" align="right" valign="top">Name:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="255" name="gname" value="{$group.name|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Address:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="100" name="address" value="{$group.address|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">&nbsp;</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="100" name="address2" value="{$group.address2|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Primary Contact:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="pcontact" value="{$group.contact|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Technical Contact:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="tcontact" value="{$group.tech|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Technical Account Manager:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="tao" value="{$group.tao|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Business Relation Manager:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="brm" value="{$group.brm|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Sales Contact:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="sales" value="{$group.sales|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Contract Type:</td>
<td class="data" width="80%">
<select name="grouptype">
<option value="">No Limit</option>
<option value="hours"{if $group.group_type eq "hours"} selected="selected"{/if}>Limit by Hours</option>
<option value="issues"{if $group.group_type eq "issues"} selected="selected"{/if}>Limit by Issues</option>
</select>
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Hours/Issues Purchased:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="32" name="bought" value="{$group.bought}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Contract Amount:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="32" name="amount" value="{$group.amount}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Start Date:</td>
<td class="data" width="80%">{date_select name="startdate" value=$group.start_date|userdate}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">End Date:</td>
<td class="data" width="80%">{date_select name="enddate" value=$group.end_date|userdate}</td>
</tr>
{if is_admin($smarty.session.userid)}
<tr>
<td class="label" width="20%" align="right" valign="top">Group Email:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="emailaddy" value="{$group.email|stripslashes}" /></td>
</tr>
{/if}
<tr>
<td class="label" width="20%" align="right" valign="top">Notes:</td>
<td class="data" width="80%"><textarea rows="10" cols="60" name="notes" style="width: 99%;">{$group.notes|stripslashes}</textarea></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Status Reports:</td>
<td class="data" width="80%"><input type="checkbox" name="statusreports"{if $group.status_reports eq "t"} checked="checked"{/if} /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Active:</td>
<td class="data" width="80%"><input type="checkbox" name="active"{if $group.active eq "t"} checked="checked"{/if} /></td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Update Information" /></td></tr>
{closetable}
</form>
<!-- End groups/edit_info.tpl -->


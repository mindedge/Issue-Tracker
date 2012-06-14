<!-- Begin groups/new.tpl -->
<form method="post" action="?module=groups&action=new">
{opentable}
{titlebar colspan=2 title="New Group"}
<tr>
<td class="label" width="20%" align="right" valign="top">Name:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="255" name="gname" value="{$smarty.post.gname|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Address:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="100" name="address" value="{$smarty.post.address|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">&nbsp;</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="100" name="address2" value="{$smarty.post.address2|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Primary Contact:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="pcontact" value="{$smarty.post.pcontact|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Technical Contact:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="tcontact" value="{$smarty.post.tcontact|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Technical Account Manager:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="tao" value="{$smarty.post.tao|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Business Relation Manager:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="brm" value="{$smarty.post.brm|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Sales Contact:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="sales" value="{$smarty.post.sales|stripslashes}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Contract Type:</td>
<td class="data" width="80%">
<select name="grouptype">
<option value="">No Limit</option>
<option value="hours">Limit by Hours</option>
<option value="issues">Limit by Issues</option>
</select>
</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Hours/Issues Purchased:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="32" name="bought" value="{$smarty.post.bought}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Contract Amount:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="32" name="amount" value="{$smarty.post.amount}" /></td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Start Date:</td>
<td class="data" width="80%">{date_select name="startdate" value=$smarty.post.startdate}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">End Date:</td>
<td class="data" width="80%">{date_select name="enddate" value=$smarty.post.enddate}</td>
</tr>
{if is_admin($smarty.session.userid)}
<tr>
<td class="label" width="20%" align="right" valign="top">Group Email:</td>
<td class="data" width="80%"><input type="text" size="32" maxlength="64" name="emailaddy" value="{$smarty.post.emailaddy|stripslashes}" /></td>
</tr>
{/if}
<tr>
<td class="label" width="20%" align="right" valign="top">Notes:</td>
<td class="data" width="80%"><textarea rows="10" cols="60" name="notes" style="width: 99%;">{$smarty.post.notes|stripslashes}</textarea></td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Create Group" /></td></tr>
{closetable}
</form>
<!-- End groups/new.tpl -->


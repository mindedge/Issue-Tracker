<!-- Begin groups/view.tpl -->
{opentable}
{titlebar colspan=2 title="Group Information"}
<tr>
<td class="label" width="20%" align="right" valign="top">Name:</td>
<td class="data" width="80%">{$group.name}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Address:</td>
<td class="data" width="80%">{$group.address}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">&nbsp;</td>
<td class="data" width="80%">{$group.address2}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Primary Contact:</td>
<td class="data" width="80%">{$group.contact}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Technical Contact:</td>
<td class="data" width="80%">{$group.tech}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Technical Account Manager:</td>
<td class="data" width="80%">{$group.tao}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Business Relation Manager:</td>
<td class="data" width="80%">{$group.brm}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Sales Contact:</td>
<td class="data" width="80%">{$group.sales}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Contract Type:</td>
<td class="data" width="80%">{$group.group_type|capitalize}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Hours/Issues Purchased:</td>
<td class="data" width="80%">{$group.bought}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Contract Amount:</td>
<td class="data" width="80%">{$group.amount|number_format:2}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Start Date:</td>
<td class="data" width="80%">{$group.start_date|userdate}</td>
</tr>
<tr>
<td class="label" width="20%" align="right" valign="top">End Date:</td>
<td class="data" width="80%">{$group.end_date|userdate}</td>
</tr>
{if !empty($group.email)}
<tr>
<td class="label" width="20%" align="right" valign="top">Group Email:</td>
<td class="data" width="80%">{$group.email}</td>
</tr>
{/if}
<tr>
<td class="label" width="20%" align="right" valign="top">Notes:</td>
<td class="data" width="80%">{$group.notes}</td>
</tr>
{if is_array($members)}
<tr>
<td class="label" width="20%" align="right" valign="top">Group Members:</td>
<td class="data" width="80%">
<b>Notes:</b><br />
Users in <font color="red">red</font> are system administrators.<br />
Users in <font color="blue">blue</font> are group administrators.<br />
<table width="100%" cellpadding="2" cellspacing="0">
{php}$col = 0;{/php}
{foreach from=$members key=userid item=username}
{php}if ($col == 0) { print "<tr class=\"data\">\n"; }{/php}
{if is_admin($userid)}
<td width="33%" style="border: none;"><font color="red">{$username}</font></td>
{elseif permission_check("update_group",$smarty.get.gid,$userid)}
<td width="33%" style="border: none;"><font color="blue">{$username}</font></td>
{else}
<td width="33%" style="border: none;">{$username}</td>
{/if}
{php}$col++; if ($col == 3) { print "</tr>\n"; $col = 0; }{/php}
{/foreach}
</table>
</td>
</tr>
{/if}
{closetable}
<!-- End groups/view.tpl -->


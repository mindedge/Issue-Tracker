<!-- Begin groups/status/history.tpl -->
{opentable}
{titlebar colspan=4 title="Status Report History"}
<tr class="tablehead" align="center">
<td width="5%">Standing</td>
<td align="left">Information</td>
<td width="15%">Updated On</td>
<td width="10%">Updated By</td>
</tr>
{if is_array($history)}
{foreach from=$history item=update}
<tr class="{rowcolor}" align="center">
{if $update.standing eq 3}
<td width="5%"><img src="{$smarty.env.imgs.urgent}" width="16" height="16" border="0" /></td>
{elseif $update.standing eq 2}
<td width="5%"><img src="{$smarty.env.imgs.high}" width="16" height="16" border="0" /></td>
{elseif $update.standing eq 1}
<td width="5%"><img src="{$smarty.env.imgs.normal}" width="16" height="16" border="0" /></td>
{else}
<td width="5%"><img src="{$smarty.env.imgs.low}" width="16" height="16" border="0" /></td>
{/if}
<td align="left">{$update.info|stripslashes|stripslashes}</td>
<td width="15%">{$update.date_entered|userdate:TRUE}</td>
<td width="10%">{username id=$update.userid}</td>
</tr>
{/foreach}
{else}
<tr class="data" align="center"><td colspan="4">There are no previous status updates for this group.</td></tr>
{/if}
{closetable}
<br />
<!-- End groups/status/history.tpl -->


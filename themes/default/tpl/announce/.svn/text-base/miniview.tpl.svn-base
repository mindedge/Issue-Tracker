<!-- Begin announce/miniview.tpl -->
{if is_array($system) and $system.posted > (time() - _WEEK_)}
{opentable}
<tr><td class="titlebar">System Announcement</td></tr>
<tr><td class="label">{$system.title} posted by {$system.username} on {$system.posted|userdate:TRUE}</td></tr>
<tr><td class="data">{$system.message|format}</td></tr>
<tr><td class="label"><a href="?module=announce">[Other Announcements]</a></td></tr>
{closetable}
<br />
{/if}
{opentable}
<tr><td class="titlebar">Group Announcements</td></tr>
{if count($announcements) > 0}
<tr>
<td class="data">
{foreach from=$announcements item=a}
<li><a href="?module=announce&action=view&aid={$a.aid}">{$a.title}</a></li>
{/foreach}
<br />
<a href="?module=announce">More Announcements...</a>
</td>
</tr>
{else}
<tr><td class="data" align="center">No Group Announcements at this time.</td></tr>
{/if}
{closetable}
<br />
<!-- End announce/miniview.tpl -->


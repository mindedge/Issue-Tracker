<!-- Begin announce/announce.tpl -->
{opentable}
{titlebar title="Announcements"}
<tr class="label"><td><a href="?module=announce&action=group&gid=">System Announcements</a></td></tr>
{if is_array($system) and count($system) > 0}
{foreach from=$system key=aid item=title}
<tr class="data"><td><a href="?module=announce&action=view&aid={$aid}">{$title}</a></td></tr>
{/foreach}
{else}
<tr class="data"><td>No system announcements at this time.</td></tr>
{/if}
{if is_array($announcements)}
{foreach from=$announcements key=gid item=a}
<tr class="label"><td><a href="?module=announce&action=group&gid={$gid}">{groupname id=$gid}</a></td></tr>
{if count($a) > 0}
{foreach from=$a item=announcement}
<tr class="data"><td><a href="?module=announce&action=view&aid={$announcement.aid}">{$announcement.title}</a></td></tr>
{/foreach}
{else}
<tr class="data"><td>No announcements for this group.</td></tr>
{/if}
{/foreach}
{/if}
{closetable}
<!-- End announce/announce.tpl -->


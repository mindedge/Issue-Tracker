<!-- Begin announce/group.tpl -->
{opentable}
{titlebar title=$title}
{if count($announcements) > 0}
{foreach from=$announcements key=aid item=title}
<tr class="data"><td><a href="?module=announce&action=view&aid={$aid}">{$title}</a></td></tr>
{/foreach}
{else}
<tr class="data"><td>No announcements for this group.</td></tr>
{/if}
{closetable}
<br />
{include file="announce/new.tpl"}
<!-- End announce/group.tpl -->


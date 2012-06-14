<!-- Begin admin/admin.tpl -->
{opentable}
{titlebar colspan=4 title="System Administration"}
{php}$col = 0;{/php}
{foreach from=$buttons item=button}
{php}if ($col == 0) { print "<tr class=\"data\">\n"; }{/php}
<td width="25%" style="border: none;">
<div class="buttons">
<img src="{$button.img}" alt="{$button.txt}" border="0" class="link" />
<a href="{$button.url}">{$button.txt}</a>
</div>
{if is_array($button.sub)}
<ul>
{foreach from=$button.sub key=txt item=url}
<li><a href="{$url}">{$txt}</a></li>
{/foreach}
</ul>
{/if}
</td>
{php}$col++; if ($col == 4) { print "</tr>\n"; $col = 0; }{/php}
{/foreach}
{php}if ($col != 0) { print "<td class=\"label\" colspan=\"".(4 - $col)."\">\n</tr>\n"; }{/php}
{closetable}
<!-- End admin/admin.tpl -->


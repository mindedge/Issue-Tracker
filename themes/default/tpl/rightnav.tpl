<!-- Begin rightnav.tpl -->
</td>
{if is_array($rightnav_menu)}
<td valign="top" class="rightnav" width="150">
{opennavtable}
<tr><td class="titlebar">Right Navigation</td></tr>
{foreach from=$rightnav_menu key=key item=val}
{if !is_integer($key)}
{if !is_array($val)}
<tr><td class="menu"><a href="{$val}">{$key}</a></td></tr>
{elseif !empty($val.url)}
<tr><td class="menu"><a href="{$val.url}">{$key}</a></td></tr>
{else}
<tr><td class="menu">{$key}</td></tr>
{/if}
{/if}
{if is_array($val.sub) and count($val.sub) > 0}
<tr>
<td class="submenu">
{foreach from=$val.sub key=text item=url}
<li><a href="{$url}">{$text}</a></li>
{/foreach}
</td>
</tr>
{/if}
{/foreach}
{closenavtable}
</td>
{/if}
<!-- End rightnav.tpl -->


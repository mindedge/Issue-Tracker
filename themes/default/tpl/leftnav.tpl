<!-- Begin leftnav.tpl -->
<td valign="top" class="leftnav" width="150">
{opennavtable}
<tr><td class="titlebar">Main Menu</td></tr>
{foreach from=$leftnav_menu key=key item=val}
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
{foreach from=$val.sub key=txt item=url}
<li><a href="{$url}">{$txt}</a></li>
{/foreach}
</td>
</tr>
{/if}
{/foreach}
{closenavtable}
{if is_array($pmenus)}
<br />
{opennavtable}
<tr><td class="titlebar">Personal Menu</td></tr>
{foreach from=$pmenus key=txt item=url}
<tr><td class="menu"><a href="{$url}">{$txt}</a></td></tr>
{/foreach}
{closenavtable}
<br />
{/if}
</td>
<td valign="top" style="padding: 4px;" width="100%" align="center">
<!-- End leftnav.tpl -->


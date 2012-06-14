<!-- Begin prefs/style.tpl -->
<form method="post" action="?module=prefs&action=style&submit=true">
{opentable}
{titlebar colspan=3 title="Style Preferences"}
<tr>
<td class="label" width="50%" align="right" valign="top">Font Size:</td>
<td class="data" colspan="2" width="50%">
<select name="style_font_size">
<option value="8"{if $font_size eq 8} selected="selected"{/if}>8</option>
<option value="9"{if $font_size eq 9} selected="selected"{/if}>9</option>
<option value="10"{if $font_size eq 10} selected="selected"{/if}>10</option>
<option value="11"{if $font_size eq 11} selected="selected"{/if}>11</option>
<option value="12"{if $font_size eq 12} selected="selected"{/if}>12</option>
<option value="13"{if $font_size eq 13} selected="selected"{/if}>13</option>
<option value="14"{if $font_size eq 14} selected="selected"{/if}>14</option>
</select>
<select name="style_font_unit">
<option value="pt"{if $font_unit eq "pt"} selected="selected"{/if}>pt (point)</option>
<option value="px"{if $font_unit eq "px"} selected="selected"{/if}>px (pixel)</option>
</select>
</td>
</tr>
<tr>
<td class="label" width="50%" align="right" valign="top">Font Family:</td>
<td class="data" colspan="2" width="50%"><input type="text" size="32" name="style_font_family" value="{$font_family}" /></td>
</tr>
<tr>
<td class="label" width="50%" align="right" valign="top">Table Border Color:</td>
<td class="data" colspan="2" width="50%"><input type="text" size="8" name="style_border_color" value="{$border_color}" /></td>
</tr>
<tr>
<td class="label" width="50%" align="right" valign="top">Link Hover Color:</td>
<td class="data" colspan="2" width="50%"><input type="text" size="8" name="style_link_hover" value="{$link_hover}" /></td>
</tr>
<tr>
<td class="label" width="50%" align="right" valign="top">Underline Links:</td>
<td class="data" colspan="2" width="50%"><input type="checkbox" name="style_underline"{if $underline eq TRUE} checked="checked"{/if}></td>
</tr>
{if is_array($smarty.env.image_exts)}
<tr>
<td class="label" width="50%" align="right" valign="top">Image Extension:</td>
<td class="data" colspan="2" width="50%">
<select name="imgext">
{foreach from=$smarty.env.image_exts key=ext item=comment}
<option value="{$ext}" {if $smarty.session.prefs.imgext eq $ext}selected="selected"{/if}>{$ext}{if !empty($comment)} ({$comment}){/if}</option>
{/foreach}
</select>
</td>
</tr>
{/if}
<tr class="tablehead" align="center">
<td width="50%" align="left">Element</td>
<td width="25%">Foreground</td>
<td width="25%">Background</td>
</tr>
{if is_array($elements)}
{php}
foreach ($this->_tpl_vars['elements'] as $key => $val) {
print "<tr align=\"center\">\n";
print "<td class=\"label\" width=\"50%\" align=\"left\">$key</td>\n";
print "<td class=\"data\" width=\"25%\"><input type=\"text\" size=\"8\" name=\"style_".$val['fgcolor']."\" value=\"".$this->_tpl_vars['values'][$val['fgcolor']]."\" /></td>\n";
print "<td class=\"data\" width=\"25%\"><input type=\"text\" size=\"8\" name=\"style_".$val['bgcolor']."\" value=\"".$this->_tpl_vars['values'][$val['bgcolor']]."\" /></td>\n";
print "</tr>\n";
}
{/php}
{/if}
<tr class="titlebar"><td colspan="3"><input type="submit" value="Update Preferences" /></td></tr>
{closetable}
</form>
<!-- End prefs/style.tpl -->


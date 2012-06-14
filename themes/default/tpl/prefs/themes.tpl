<!-- Begin prefs/style/predefined.tpl -->
<form method="post" action="?module=prefs&action=style&submit=true&predefined=true">
{opentable}
{titlebar colspan=2 title="Predefined Themes"}
<tr><td class="label" colspan="2">Choosing a theme will override any personal style preferences.</td></tr>
<tr>
<td class="label" width="20%" align="right" valign="top">Theme:</td>
<td class="data" width="80%">
<select name="theme">
{if is_array($themes)}
{foreach from=$themes item=theme}
<option value="{$theme}">{$theme|capitalize|replace:"_":" "}</option>
{/foreach}
{/if}
</select>
</td>
</tr>
<tr class="titlebar"><td colspan="2"><input type="submit" value="Set Theme" /></td></tr>
{closetable}
</form>
<br />
<!-- End prefs/style/predefined.tpl -->


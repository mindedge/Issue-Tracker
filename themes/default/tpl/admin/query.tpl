<!-- Begin admin/query.tpl -->
<span class="noprint">
<form method="post" action="?module=admin&action=query">
{opentable}
{titlebar colspan=2 title="Database Query Tool"}
<tr>
<td width="20%" align="right" valign="top" class="label">Query:</td>
<td width="80%" class="data">
<textarea rows="10" cols="60" name="query">{$smarty.post.query|stripslashes}</textarea>
</td>
</tr>
{if is_admin($smarty.session.userid)}
<tr>
<td width="20%" align="right" valign="top" class="label">Explain Query:</td>
<td width="80%" class="data"><input type="checkbox" name="explain" /></td>
</tr>
{/if}
<tr><td class="titlebar" colspan="2"><input type="submit" value="Run Query" /></td></tr>
{closetable}
</form>
</span>
{if !empty($smarty.post.query)}
<br />
{if $smarty.post.explain eq "on"}
{opentable}
{titlebar title="Query Plan"}
<tr>
<td class="data">
<pre class="fixed">
{$explain}
</pre>
</td>
</tr>
{closetable}
<br />
{/if}
{opentable}
{if !empty($results)}
{$results}
{else}
<tr><td class="data">No results returned.</td></tr>
{/if}
{closetable}
{/if}
<!-- End admin/query.tpl -->


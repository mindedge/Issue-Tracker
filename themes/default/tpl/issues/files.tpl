<!-- Begin issues/files.tpl -->
{opentable}
{if issue_priv($smarty.get.issueid,"view_private")}
{titlebar colspan=6 title="Issue Files"}
{else}
{titlebar colspan=5 title="Issue Files"}
{/if}
<tr class="tablehead" align="center">
<td align="left">Filename</td>
<td width="20%">Uploaded On</td>
<td width="15%">Uploaded By</td>
<td width="10%">Size</td>
{if issue_priv($smarty.get.issueid,"view_private")}
<td width="5%">Private</td>
{/if}
<td width="5%">Delete</td>
</tr>
{if is_array($files)}
{foreach from=$files item=file}
<tr class="{rowcolor}" align="center">
<td align="left"><a href="?module=download&fid={$file.fid}">{$file.name}</a></td>
<td width="20%">{$file.uploaded_on|userdate:TRUE}</td>
<td width="15%">{username id=$file.userid}</td>
<td width="10%">{fsize id=$file.fid}</td>
{if issue_priv($smarty.get.issueid,"view_private")}
{if $file.private eq "t"}
<td width="5%"><a href="?module=issues&action=files&issueid={$smarty.get.issueid}&fid={$file.fid}&private=false"><img src="{$smarty.env.imgs.private}" width="16" height="16" border="0" alt="Make file Public" /></a></td>
{else}
<td width="5%"><a href="?module=issues&action=files&issueid={$smarty.get.issueid}&fid={$file.fid}&private=true"><img src="{$smarty.env.imgs.public}" width="16" height="16" border="0" alt="Make file Private" /></a></td>
{/if}
{/if}
{if is_admin($smarty.session.userid)}
<td width="5%"><a href="?module=admin&action=files&subaction=delete&fid={$file.fid}&issueid={$smarty.get.issueid}"><img src="{$smarty.env.imgs.delete}" width="16" height="16" border="0" alt="Delete" /></a></td>
{else}
<td width="5%">&nbsp;</td>
{/if}
{/foreach}
{else}
<tr class="data" align="center"><td colspan="5">No files to list.</td></tr>
{/if}
{closetable}
<br />
{if issue_priv($smarty.get.issueid,"upload_files")}
<form method="post" action="?module=issues&action=files&issueid={$smarty.get.issueid}&submit=true" enctype="multipart/form-data">
{opentable}
{titlebar title="Upload Files"}
<tr><td class="data"><input type="file" size="64" name="upload1" /></td></tr>
<tr><td class="data"><input type="file" size="64" name="upload2" /></td></tr>
<tr><td class="data"><input type="file" size="64" name="upload3" /></td></tr>
<tr><td class="data"><input type="file" size="64" name="upload4" /></td></tr>
<tr><td class="data"><input type="file" size="64" name="upload5" /></td></tr>
<tr><td class="titlebar"><input type="submit" value="Upload Files" /></td></tr>
{closetable}
</form>
{/if}
<!-- End issues/files.tpl -->


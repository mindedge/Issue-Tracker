<!-- Begin iconbar.tpl -->
{if !empty($smarty.session.userid)}
{if $smarty.get.print ne "true"}
<div class="iconbar" align="center">
{if !empty($help_file) and file_exists($help_file)}
<img src="{$smarty.env.imgs.help}" width="16" height="16" border="0" alt="Help" />&nbsp;
{if $smarty.session.javascript}
<a href="" onClick="window.open('?module=help&nonav=true&mod={$smarty.get.module}&act={$smarty.get.action}','Help','location=no,menubar=no,status=no,toolbar=no,width=640,height=480'); return true;">Help</a>&nbsp;
{else}
<a target="_blank" href="?module=help&nonav&mod={$smarty.get.module}&act={$smarty.get.action}">Help</a>&nbsp;
{/if}
{/if}
{if $smarty.get.module ne "reports"}
<img src="{$smarty.env.imgs.print}" width="16" height="16" border="0" alt="Print Preview" />&nbsp;
<a target="_blank" href="?{$smarty.server.QUERY_STRING}&print=true">Print Preview</a>
{else}
&nbsp;
{/if}
</div>
{/if}
{include file="errors.tpl"}
{/if}
<!-- End iconbar.tpl -->


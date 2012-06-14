{if !empty($smarty.session.userid)}
<!-- Begin javascript.tpl -->
<script language="javascript" type="text/javascript">
<!-- Begin javascript -->
{if ($smarty.session.debugger eq "on" or $smarty.get.debug eq "on") 
and $smarty.get.debug ne "off"}
  debugwin = window.open('','DebugWin','toolbar=no,scrollbars=yes,resizable=yes,width=640,height=480');
  debugwin.document.writeln('<html>');
  debugwin.document.writeln('<head>');
  debugwin.document.writeln('<title>Issue Tracker Debugger</title>');
  debugwin.document.writeln('<link rel="stylesheet" type="text/css" href="css/{$cssfile}" />');
  debugwin.document.writeln('</head>');
  debugwin.document.writeln('<body>');
  debugwin.document.writeln('<table width="100%" class="borders" border="0" cellspacing="0" cellpadding="2">');
  debugwin.document.writeln('<tr><td class="tablehead">Debug Window</td></tr>');
{/if}
var timerID = null
var timerRunning = false
var sessionExpired = false
var startDate
var startSecs

function loader()
{ldelim}
  startDate = new Date()
  startSecs = (startDate.getHours() * 60 * 60) + (startDate.getMinutes() * 60) + startDate.getSeconds()

  if (timerRunning)
    clearTimeout(timerID)

  check_session()
{rdelim}

function unloader()
{ldelim}
{if ($smarty.session.debugger eq "on" or $smarty.get.debug eq "on")
and $smarty.get.debug ne "off"}
  debugwin.window.close();
{/if}
{rdelim}

function check_session()
{ldelim}
  var now = new Date()
  var nowSecs = (now.getHours() * 60 * 60) + (now.getMinutes() * 60) + now.getSeconds()
  var elapsedSecs = nowSecs - startSecs;

{if $smarty.session.prefs.session_timeout eq "t"}
  if (elapsedSecs == {php}print(ini_get("session.gc_maxlifetime") - 300);{/php})
    alert('Your {$smarty.const._TITLE_} session will expire in 5 minutes!');

  if (elapsedSecs >= {php}print(ini_get("session.gc_maxlifetime"));{/php} && !sessionExpired) {ldelim}
    sessionExpired = true;
    alert('Your {$smarty.const._TITLE_} session has expired!');
  {rdelim}
{/if}

  timerID = setTimeout("check_session()",1000)
  timerRunning = true
{rdelim}

{if $smarty.session.prefs.local_tz eq "t"}
/* Retrieve user's timezone */
var d = new Date()
if (d.getTimezoneOffset) {ldelim}
  var iMinutes = d.getTimezoneOffset()
  document.cookie = "tz=" + (iMinutes / 60)
{rdelim}
{/if}

/* new MWarner 3/9/2010 */
var originalClass="";
var originalBG="";
function highlightRow(which){ldelim}
	if(!originalClass){ldelim}
		originalClass=which.className;
		originalBG=which.style.backgroundColor;
		which.className='row_hover';
		which.style.backgroundColor='#FFFFAA';
	{rdelim}else{ldelim}
		which.className=originalClass;
		which.style.backgroundColor=originalBG;
		originalClass="";
		originalBG="";
	{rdelim}
{rdelim}

<!-- End Javascript -->
</script>
<!-- End javascript.tpl -->
{/if}


<%strip%>
<%include file=header.tpl%>
<form name="myform" id="myform" action="<%$wwwroot%>" method="post">
<table width="98%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
        <p class="SubheadlineYellow"><%if $tpl_status eq 'true'%>Abmelden<%elseif $tpl_status eq 'toggledtrue'%>Abgemeldet<%elseif $tpl_status eq 'toggledfalse'%>Angemeldet<%else%>Anmelden<%/if%></p>
		<br>
		<%if $tpl_status eq 'true' || $tpl_status eq 'false'%>
		<p valign="center"><button name="toggle" id="toggle" value="true" onclick="document.myform.submit();"><%if $tpl_status eq 'true'%>gehen<%else%>kommen<%/if%></button></p>
		<%elseif $tpl_status eq 'toggledtrue'%>
			Erfolgreich abgemeldet!
		<%elseif $tpl_status eq 'toggledfalse'%>
		    Erfolgreich angemeldet!
		<%/if%>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
</form>
<%include file=footer.tpl%>
<%/strip%> 
<%strip%>
<%include file=header.tpl%>
<table width="600" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
    <p class="SubheadlineYellow">Es ist ein Fehler aufgetreten</p>
	 Sollte sich dieser Fehler wiederholen, wenden Sie sich bitte mit folgenden Informationen an uns:
  	 <table border="0">
  	 	<tr>
		   <td><b>Seite:</b></td>
		   <td><%$tpl_page%></td>
		</tr>
  	 	<tr>
		   <td><b>Art:</b></td>
		   <td><%$tpl_errortype%></td>
		</tr>
		<tr>
		   <td><b>Klasse/Funktion:</b></td>
		   <td><%$tpl_classname%></td>
		</tr>
		<tr>
		   <td nowrap valign="top"><b>weitere Information:</b></td>
		   <td><%$tpl_info%></td>
		</tr>
		<tr>
		   <td nowrap valign="top"><b>Datenbank Information:</b></td>
		   <td><%$tpl_dbinfo%></td>
		</tr>
 	  </table>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>

<%include file=footer.tpl%>
<%/strip%>

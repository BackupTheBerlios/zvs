<%strip%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!-- 
	This website is brought to you by ZVS
	ZVS is a free open source Room Administration Framework created by Christian Ehret and licensed under GNU/GPL.
	ZVS is copyright 2003-2004 of Christian Ehret
-->
<title>zvs: Geburtstage</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
</HEAD>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<br><br><br>
<table width="98%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
		<p class="SubheadlineYellow">Geburtstage</p>	
    	<table border="0" cellspacing="0" cellpadding="3">
			<tr>
			    <td class="ListL1Header">&nbsp;</td>
				<td class="ListL1Header"><b>Datum</b></td>
			    <td class="ListL1Header"><b>Name</b></td>				
				<td class="ListL1Header"><b>Alter</b></td>
			</tr>
			<%section name=guest loop=$tpl_guests%>
			<tr>
				<td class="ListL<%$tpl_guests[guest].color%>" valign="top">
					<a href="javascript:window.opener.location.replace('<%$wwwroot%>showgast.php/guestid.<%$tpl_guests[guest].guestid%>');window.opener.focus();"><img src="<%$wwwroot%>img/icon_show.gif" width="16" height="16" border="0" alt="Anzeigen"></a>
				</td>
				<td class="ListL<%$tpl_guests[guest].color%>" valign="top">
					  <%$tpl_guests[guest].birthday%>
				</td>			
				<td class="ListL<%$tpl_guests[guest].color%>" valign="top">
					  <%$tpl_guests[guest].lastname%>, <%$tpl_guests[guest].firstname%>
				</td>		
				<td class="ListL<%$tpl_guests[guest].color%>" valign="top">
					  <%$tpl_guests[guest].age%>
				</td>						
			</tr>
			<%sectionelse%>
			<tr>
			    <td colspan="11">keine Eintr&auml;ge</td>
			</tr>
			<%/section%>
		</table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right"><a href="javascript:self.close();"><img src="<%$wwwroot%>img/button_schliessen.png" width="86" height="24" border="0"></a></td>
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
</body>
</html>
<%/strip%>
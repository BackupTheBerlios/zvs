<%strip%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>
<HEAD>
<title>zvs: <%$tpl_title%></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
</HEAD>
<%/strip%>
<script language="JavaScript" type="text/javascript">
<!--
function check(){
	if (document.addguest.frm_firstname.value == "" && document.addguest.frm_lastname.value == "")
	{
		alert("Entweder Vor- und/oder Nachnamen angeben");
		document.addguest.frm_firstname.focus();
	} else 
	{
		document.addguest.submit();
	}
}

function submit_onkeypress()
{
    if(window.event.keyCode==13)
    {
      check();
    }
}
    function openWindow(){
    F1 = window.open('<%$wwwroot%>colorchooser.php','colorchooser','width=308,height=203,left=0,top=0');
    F1.focus();
    }

//-->
</script>
<%strip%>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<%if $tpl_added eq 'false'%>
<br>
<table width="98%" border="0" cellspacing="0" cellpadding="0" class="Box" align="center">
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner01.gif" width="8" height="8"></td>
    <td class="BoxTop"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner02.gif" width="8" height="8"></td>
  </tr>
  <tr>
    <td class="BoxLeft"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td width="100%">
        <p class="SubheadlineYellow">Gast hinzuf&uuml;gen</p>
		<form name="addguest" id="addguest" method="post" action="<%$SCRIPT_NAME%>">
		<table border="0">
			<tr>
				<td><b>Vorname:</b></td>
				<td><input type="text" name="frm_firstname" id="frm_firstname" value="" onKeyPress="submit_onkeypress();"></td>
			</tr>
			<tr>
				<td><b>Nachname:</b></td>
				<td><input type="text" name="frm_lastname" id="frm_lastname" value="" onKeyPress="submit_onkeypress();"></td>
			</tr>	
			<tr>
				<td><b>Buchungskategorie</b></td>
				<td><select name="frm_bookingcat" id="frm_bookingcat">
					<%section name=cat loop=$tpl_bookingcat%>
					<option value="<%$tpl_bookingcat[cat].bookingcatid%>"><%$tpl_bookingcat[cat].name%></option>
					<%/section%>
				    </select></td>
			</tr>
			<tr>
				<td><b>Gruppenfarbe</b></td>
				<td><input type="text" name="frm_gcolor" id="frm_gcolor" size="7" maxlength="7" value=""/><a href="javascript:openWindow();"><img src="<%$wwwroot%>img/button_colorchooser.gif" width="16" height="15" border="0"></a></td>
			<tr>
			<tr>
				<td colspan="2" align="right"><a href="javascript:check();"><img src="<%$wwwroot%>img/button_weiter.gif" width="73" height="24" border="0"></a></td>
			</tr>		
		</table>
		</form>
    </td>
   <td class="BoxRight"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td><img src="<%$wwwroot%>img/box_corner04.gif" width="8" height="8"></td>
    <td class="BoxBottom"><img src="<%$wwwroot%>img/spacer.gif" width="1" height="1"></td>
    <td><img src="<%$wwwroot%>img/box_corner03.gif" width="8" height="8"></td>
  </tr>
</table>
<%/strip%>
<script language="Javascript" type="text/javascript">
<!--
	document.addguest.frm_firstname.focus();
//-->
</script>
<%strip%>
<%else%>
<%/strip%>
<script language="Javascript" type="text/javascript">
<!--
	window.opener.location.replace('<%$wwwroot%>index.php/guestid.<%$tpl_theguestid%>/index.php');
	self.close();
//-->
</script>
<%strip%>
<%/if%>
</body>
</html>
<%/strip%>

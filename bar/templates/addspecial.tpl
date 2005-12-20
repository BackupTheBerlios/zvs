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
	if (document.addspecial.frm_num.value == "") 
	{
		alert("Bitte Anzahl angeben");
		document.addspecial.frm_num.focus();
	} else if (document.addspecial.frm_description.value == "") 
	{
		alert("Bitte Beschreibung angeben");
		document.addspecial.frm_description.focus();
	} else if (document.addspecial.frm_price.value == "") 
	{
		alert("Bitte Preis angeben");
		document.addspecial.frm_price.focus();

	} else 
	{
		document.addspecial.submit();
	}
}

function submit_onkeypress()
{
    if(window.event.keyCode==13)
    {
      check();
    }
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
        <p class="SubheadlineYellow">Sonderverkauf</p>
		<form name="addspecial" id="addspecial" method="post" action="<%$SCRIPT_NAME%>">
		<input type="hidden" name="frm_theguestid" id="frm_theguestid" value="<%$tpl_theguestid%>">
		<input type="hidden" name="frm_catid" id="frm_catid" value="<%$tpl_catid%>">		
		<table border="0">
			<tr>
				<td><b>Anzahl:</b></td>
				<td><input type="text" name="frm_num" id="frm_num" value="1" size="3" maxlength="3" onKeyPress="submit_onkeypress();"></td>
			</tr>
			<tr>
				<td><b>Auswahl:</b></td>
				<td><select name="frm_select" id="frm_select" onChange="document.addspecial.frm_description.value=this.value;">
				        <option value="">Bitte ausw&auml;hlen</option>
						<%section name="select" loop="$tpl_articles"%>
							<option value="<%$tpl_articles[select]%>"><%$tpl_articles[select]%></option>
						<%/section%>
					</select>
				</td>
			</tr>			
			<tr>
				<td><b>Bezeichnung:</b></td>
				<td><input type="text" name="frm_description" id="frm_description" maxlength="255" size="50" value="" onKeyPress="submit_onkeypress();"></td>
			</tr>
			<tr>
				<td><b>Preis:</b></td>
				<td><input type="text" name="frm_price" id="frm_price" maxlength="6" size="6" value="0.00" onKeyPress="submit_onkeypress();"> EUR&nbsp;</td>
			</tr>	
			<tr>
				<td><b>Steuer:</b></td>
				<td><input type="text" name="frm_tax" id="frm_tax" maxlength="6" size="6" value="20.00" onKeyPress="submit_onkeypress();"> %&nbsp;</td>
			</tr>				
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
	document.addspecial.frm_description.focus();
//-->
</script>
<%strip%>
<%else%>
<%/strip%>
<script language="Javascript" type="text/javascript">
<!--
	window.opener.location.replace('<%$wwwroot%>index.php/guestid.<%$tpl_theguestid%>/showlast.true/index.php');
	self.close();
//-->
</script>
<%strip%>
<%/if%>
</body>
</html>
<%/strip%>

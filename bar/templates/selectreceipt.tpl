<%strip%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>
<HEAD>
<title>zvs: <%$tpl_title%></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<%$wwwroot%>css/admin.css" rel="stylesheet" type="text/css">
<link href="<%$wwwroot%>css/dynCalendar.css" rel="stylesheet" type="text/css">
<%/strip%>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="<%$wwwroot%>global/dynCalendar.js"></script>

<script language="JavaScript" type="text/javascript">
<!--

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
</HEAD>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
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
        <p class="SubheadlineYellow">Bon &uuml;ber Zeitraum erstellen</p>
		<form name="timeline" id="timeline" method="get" action="<%$wwwroot%>receipt.php/cats.<%section name=thecat loop=$tpl_selectedcat%><%$tpl_selectedcat[thecat]%><%if not $smarty.section.thecat.last%>,<%/if%><%/section%>/receipt.php">
		<input type="hidden" name="frm_theguestid" id="frm_theguestid" value="<%$tpl_theguestid%>">
		<table border="0">
			<tr>
				<td><b>von:</b></td>
				<td><input name="frm_start" type="text" id="frm_start" size="10" value=""><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar1Callback(date, month, year)
        {
            document.forms['timeline'].frm_start.value = date + '.' + month + '.' + year;
        }
        function calendar1GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['timeline'].frm_start.value;
        	if (strDate != "")
			{
				arrDate = strDate.split(".");
				month = arrDate[1]-1;
				year = arrDate[2];
				day = arrDate[0];
				strDate = month+', '+year+', '+day;
			} else {
				strDate = "";
			}
         return strDate
        }

        calendar1 = new dynCalendar('calendar1', 'calendar1Callback', '<%$wwwroot%>img/');
    //-->
    </script>
	<%strip%>
</td>
			</tr>
			<tr>
				<td><b>bis:</b></td>
				<td><input name="frm_end" type="text" id="frm_end" size="10" value=""><%/strip%>
    <script language="JavaScript" type="text/javascript">
    <!--
        /**
        * Example callback function
        */
        function calendar2Callback(date, month, year)
        {
            document.forms['timeline'].frm_end.value = date + '.' + month + '.' + year;
        }
        function calendar2GetValue()
        {
        	var strDate, arrDate, month, year, day;

        	strDate = document.forms['timeline'].frm_end.value;
        	if (strDate != "")
			{
				arrDate = strDate.split(".");
				month = arrDate[1]-1;
				year = arrDate[2];
				day = arrDate[0];
				strDate = month+', '+year+', '+day;
			} else {
				strDate = "";
			}
         return strDate
        }

        calendar2 = new dynCalendar('calendar2', 'calendar2Callback', '<%$wwwroot%>img/');
    //-->
    </script>
	<%strip%></td>
			</tr>	
			<tr>
				<td colspan="2" align="right"><a href="javascript:document.timeline.submit();"><img src="<%$wwwroot%>img/button_weiter.gif" width="73" height="24" border="0"></a></td>
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
	document.timeline.frm_start.focus();
//-->
</script>
<%strip%>
</body>
</html>
<%/strip%>
